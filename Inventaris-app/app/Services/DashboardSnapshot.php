<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\BarangStatusLog;

class DashboardSnapshot
{
    public static function data(): array
    {
        $summary = [
            'on_hold' => Barang::where('status', 'on_hold')->count(),
            'unreleased' => Barang::where('status', 'unreleased')->count(),
            'reject' => Barang::where('status', 'reject')->count(),
            'approved' => Barang::where('status', 'approved')->count(),
        ];

        $problem = Barang::whereNotNull('anomaly')
            ->where('anomaly', '!=', 'Normal')
            ->latest()
            ->get();

        $lowStock = Barang::where('jumlah', '<', 10)
            ->orderBy('jumlah')
            ->get();

        $statusLogs = BarangStatusLog::with(['barang:id,nama_barang', 'user:id,name'])
            ->latest()
            ->limit(8)
            ->get();

        return [
            'type' => 'dashboard.updated',
            'summary' => $summary,
            'problem' => $problem,
            'problem_count' => $problem->count(),
            'low_stock' => $lowStock,
            'low_stock_count' => $lowStock->count(),
            'status_logs' => $statusLogs,
            'insights' => self::insights($summary, $problem, $lowStock),
            'generated_at' => now()->toIso8601String(),
        ];
    }

    private static function insights(array $summary, $problem, $lowStock): array
    {
        $total = array_sum($summary);
        $insights = [];

        if ($total === 0) {
            return ['Belum ada data inventaris untuk dianalisis.'];
        }

        $rejectRate = round(($summary['reject'] / $total) * 100, 1);
        $problemRate = round(($problem->count() / $total) * 100, 1);

        $insights[] = "Total {$total} item terpantau, dengan {$summary['approved']} approved dan {$summary['reject']} reject.";
        $insights[] = "Rasio reject saat ini {$rejectRate}% dari total data.";
        $insights[] = "AI mendeteksi {$problem->count()} barang bermasalah ({$problemRate}%).";

        if ($lowStock->count() > 0) {
            $names = $lowStock->take(4)->pluck('nama_barang')->join(', ');
            $insights[] = "Stok rendah perlu diprioritaskan: {$names}.";
        } else {
            $insights[] = 'Tidak ada stok rendah di bawah batas 10 unit.';
        }

        if ($summary['on_hold'] > 0) {
            $insights[] = "{$summary['on_hold']} barang on hold perlu review operasional.";
        }

        return $insights;
    }
}
