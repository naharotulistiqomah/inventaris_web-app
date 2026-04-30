<?php

namespace App\Console\Commands;

use App\Models\Barang;
use App\Models\BarangStatusLog;
use Illuminate\Console\Command;

class BackfillBarangStatusLogs extends Command
{
    protected $signature = 'barang:backfill-status-logs';

    protected $description = 'Create initial status logs for existing barang records.';

    public function handle(): int
    {
        $created = 0;

        Barang::query()->each(function (Barang $barang) use (&$created): void {
            $log = BarangStatusLog::firstOrCreate(
                [
                    'barang_id' => $barang->id,
                    'action' => 'initial',
                ],
                [
                    'new_status' => $barang->status,
                    'new_jumlah' => $barang->jumlah,
                    'note' => 'Snapshot awal sebelum history log aktif.',
                ]
            );

            if ($log->wasRecentlyCreated) {
                $created++;
            }
        });

        $this->info("Initial status logs created: {$created}");

        return self::SUCCESS;
    }
}
