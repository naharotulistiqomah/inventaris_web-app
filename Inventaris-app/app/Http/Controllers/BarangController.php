<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangStatusLog;
use App\Services\DashboardSnapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Throwable;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  Barang::create($request->all());
        // return redirect()->route('barang.index');
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:on_hold,unreleased,reject,approved',
        ]);

        $ai = $this->analyzeBarang($validated);

        $barang = Barang::create([
            'nama_barang' => $validated['nama_barang'],
            'jumlah' => $validated['jumlah'],
            'status' => $validated['status'],
            'prediction' => $ai['prediction'] ?? null,
            'anomaly' => $ai['anomaly'] ?? null,
            'recommendation' => $ai['recommendation'] ?? null,
        ]);

        BarangStatusLog::create([
            'barang_id' => $barang->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'new_status' => $barang->status,
            'new_jumlah' => $barang->jumlah,
            'note' => 'Barang dibuat dan dianalisis AI.',
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        //  $barang->update($request->all());
        // return redirect()->route('barang.index');

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:on_hold,unreleased,reject,approved',
        ]);

        $ai = $this->analyzeBarang($validated);

        $oldStatus = $barang->status;
        $oldJumlah = $barang->jumlah;

        $barang->update([
            'nama_barang' => $validated['nama_barang'],
            'jumlah' => $validated['jumlah'],
            'status' => $validated['status'],
            'prediction' => $ai['prediction'] ?? null,
            'anomaly' => $ai['anomaly'] ?? null,
            'recommendation' => $ai['recommendation'] ?? null,
        ]);

        BarangStatusLog::create([
            'barang_id' => $barang->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'old_status' => $oldStatus,
            'new_status' => $barang->status,
            'old_jumlah' => $oldJumlah,
            'new_jumlah' => $barang->jumlah,
            'note' => 'Barang diperbarui dan dianalisis ulang oleh AI.',
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index');
    }

    public function dashboardData()
    {
        return response()->json(DashboardSnapshot::data());
    }

    public function chatbot(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $items = Barang::select([
            'id',
            'nama_barang',
            'jumlah',
            'status',
            'prediction',
            'anomaly',
            'recommendation',
        ])->get();

        try {
            $response = Http::timeout(5)->post('http://127.0.0.1:5000/chat', [
                'message' => $validated['message'],
                'items' => $items,
            ]);

            return response()->json($response->json() ?? [
                'reply' => 'AI belum memberi jawaban.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'reply' => 'Maaf, layanan AI sedang tidak tersedia. Pastikan Flask berjalan di port 5000.',
            ], 503);
        }
    }

    private function analyzeBarang(array $data): array
    {
        try {
            $response = Http::timeout(3)->post('http://127.0.0.1:5000/analyze', [
                'quantity' => $data['jumlah'],
                'status' => $data['status'],
                'days' => 1,
            ]);

            return $response->json() ?? [];
        } catch (Throwable $e) {
            return [];
        }
    }
}
