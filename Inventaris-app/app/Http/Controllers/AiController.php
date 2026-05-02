<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class AiController extends Controller
{
    public function cekAi(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'nullable|exists:barangs,id',
            'quantity' => 'nullable|integer|min:0',
            'status' => 'nullable|in:on_hold,unreleased,reject,approved',
            'days' => 'nullable|integer|min:0',
        ]);

        $barang = isset($validated['barang_id'])
            ? Barang::find($validated['barang_id'])
            : null;

        $payload = [
            'quantity' => $barang?->jumlah ?? (int) ($validated['quantity'] ?? 0),
            'status' => $barang?->status ?? ($validated['status'] ?? 'unreleased'),
            'days' => (int) ($validated['days'] ?? 1),
        ];

        try {
            $response = Http::timeout(5)->post('http://127.0.0.1:5000/analyze', $payload);

            if ($response->failed()) {
                return back()->withErrors([
                    'ai' => 'AI service gagal memproses data barang.',
                ]);
            }

            return view('inventory.hasil', [
                'barang' => $barang,
                'payload' => $payload,
                'hasil' => $response->json() ?? [],
            ]);
        } catch (Throwable $e) {
            return back()->withErrors([
                'ai' => 'AI service tidak tersedia. Pastikan Flask berjalan di port 5000.',
            ]);
        }
    }
}
