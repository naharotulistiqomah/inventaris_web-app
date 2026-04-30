<?php

namespace App\Console\Commands;

use App\Services\DashboardSnapshot;
use Illuminate\Console\Command;
use Throwable;

class DashboardWebSocketServer extends Command
{
    protected $signature = 'dashboard:websocket {--host=127.0.0.1} {--port=6001}';

    protected $description = 'Run a lightweight WebSocket server for real-time dashboard updates.';

    public function handle(): int
    {
        $host = $this->option('host');
        $port = (int) $this->option('port');
        $server = @stream_socket_server("tcp://{$host}:{$port}", $errno, $errstr);

        if (!$server) {
            $this->error("WebSocket server gagal jalan: {$errstr} ({$errno})");
            return self::FAILURE;
        }

        stream_set_blocking($server, false);

        $clients = [];
        $lastHash = null;
        $lastPayload = null;
        $lastCheck = 0.0;

        $this->info("Dashboard WebSocket aktif di ws://{$host}:{$port}/dashboard");

        while (true) {
            $client = @stream_socket_accept($server, 0);

            if ($client) {
                stream_set_blocking($client, false);
                $clients[(int) $client] = [
                    'socket' => $client,
                    'handshake' => false,
                ];
            }

            foreach ($clients as $id => $clientData) {
                $socket = $clientData['socket'];

                if (feof($socket)) {
                    fclose($socket);
                    unset($clients[$id]);
                    continue;
                }

                $buffer = @fread($socket, 2048);

                if (!$buffer) {
                    continue;
                }

                if (!$clientData['handshake']) {
                    if ($this->handshake($socket, $buffer)) {
                        $clients[$id]['handshake'] = true;

                        if ($lastPayload === null) {
                            $lastPayload = $this->dashboardPayload();
                            $lastHash = md5($lastPayload);
                        }

                        @fwrite($socket, $this->encode($lastPayload));
                    } else {
                        fclose($socket);
                        unset($clients[$id]);
                    }
                }
            }

            if (microtime(true) - $lastCheck >= 1) {
                $lastCheck = microtime(true);
                $payload = $this->dashboardPayload();
                $hash = md5($payload);

                if ($hash !== $lastHash) {
                    $lastHash = $hash;
                    $lastPayload = $payload;
                    $clients = $this->broadcast($clients, $payload);
                }
            }

            usleep(100000);
        }
    }

    private function handshake($socket, string $request): bool
    {
        if (!preg_match('/Sec-WebSocket-Key:\s*(.*)\r\n/i', $request, $matches)) {
            return false;
        }

        $key = trim($matches[1]);
        $accept = base64_encode(sha1($key.'258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        $response = "HTTP/1.1 101 Switching Protocols\r\n"
            ."Upgrade: websocket\r\n"
            ."Connection: Upgrade\r\n"
            ."Sec-WebSocket-Accept: {$accept}\r\n\r\n";

        return @fwrite($socket, $response) !== false;
    }

    private function dashboardPayload(): string
    {
        return json_encode(DashboardSnapshot::data(), JSON_UNESCAPED_SLASHES);
    }

    private function broadcast(array $clients, string $payload): array
    {
        $frame = $this->encode($payload);

        foreach ($clients as $id => $clientData) {
            if (!$clientData['handshake']) {
                continue;
            }

            try {
                if (@fwrite($clientData['socket'], $frame) === false) {
                    fclose($clientData['socket']);
                    unset($clients[$id]);
                }
            } catch (Throwable $e) {
                fclose($clientData['socket']);
                unset($clients[$id]);
            }
        }

        return $clients;
    }

    private function encode(string $payload): string
    {
        $length = strlen($payload);
        $header = chr(129);

        if ($length <= 125) {
            return $header.chr($length).$payload;
        }

        if ($length <= 65535) {
            return $header.chr(126).pack('n', $length).$payload;
        }

        return $header.chr(127).pack('NN', 0, $length).$payload;
    }
}
