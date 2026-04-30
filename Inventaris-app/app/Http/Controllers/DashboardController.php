<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Services\DashboardSnapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class DashboardController extends Controller
{
    public function index()
    {
        $snapshot = DashboardSnapshot::data();
        $barangs = Barang::all();
        $onHold = $snapshot['summary']['on_hold'];
        $unreleased = $snapshot['summary']['unreleased'];
        $reject = $snapshot['summary']['reject'];
        $approved = $snapshot['summary']['approved'];
        $problematic = $snapshot['problem'];
        $lowStock = $snapshot['low_stock'];
        $statusLogs = $snapshot['status_logs'];
        $insights = $snapshot['insights'];

        $alerts = $this->getAlerts($barangs);

        return view('dashboard', compact(
            'barangs',
            'onHold',
            'unreleased',
            'reject',
            'approved',
            'problematic',
            'alerts',
            'lowStock',
            'statusLogs',
            'insights'
        ));
    }

//     public function monitoring(Request $request)
// {
//     $query = Barang::query();

//     // filter status (optional)
//     if ($request->status) {
//         $query->where('status', $request->status);
//     }

//     $barangs = $query->latest()->get();

//     // statistik kecil
//     $total = Barang::count();
//     $problem = Barang::whereIn('status', ['reject', 'on_hold'])->count();

//     return view('monitoring', compact('barangs', 'total', 'problem'));
// }

public function monitoring(Request $request)
{
    $query = Barang::query();

    // 🔍 FILTER STATUS
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // 🔍 FILTER LOKASI (opsional kalau ada kolom lokasi)
    if ($request->lokasi) {
        $query->where('lokasi', $request->lokasi);
    }

    $barangs = $query->latest()->get();

    // 📊 STATISTIK
    $onHold = Barang::where('status', 'on_hold')->count();
    $unreleased = Barang::where('status', 'unreleased')->count();
    $reject = Barang::where('status', 'reject')->count();
    $approved = Barang::where('status', 'approved')->count();

    // ⚠️ PROBLEM
    $problematic = Barang::whereNotNull('anomaly')
        ->where('anomaly', '!=', 'Normal')
        ->get();
    $problem = $problematic->count();

    return view('monitoring', compact(
        'barangs',
        'onHold',
        'unreleased',
        'reject',
        'approved',
        'problem',
        'problematic'
    ));
}

private function getAlerts($barangs): array
{
    try {
        $response = Http::timeout(3)->post('http://127.0.0.1:5000/alerts', [
            'items' => $barangs->toArray(),
        ]);

        return $response->json('alerts') ?? [];
    } catch (Throwable $e) {
        return [];
    }
}
}
