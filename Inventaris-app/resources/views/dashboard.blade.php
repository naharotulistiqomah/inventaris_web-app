<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris - Dashboard</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        /* ---------- PASTIKAN SEMUA ELEMEN MEMAKAI FONT INTER ---------- */
        body, button, input, select, textarea, a, p, h1, h2, h3, h4, h5, h6, span, div, li, ul, ol, table, th, td, thead, tbody, tr, aside, nav, header, main, footer {
            font-family: 'Inter', sans-serif;
        }
        /* Atau cara universal (tetap) */
        * {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            z-index: 50;
            overflow: hidden;
        }
        .nav-item {
            transition: all 0.2s ease;
            border-radius: 12px;
        }
        .nav-item:hover {
            background-color: #dbeafe;
            transform: translateX(4px);
        }
        .nav-item.active {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .stat-card {
            border-radius: 20px;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-4px);
        }
        .chart-container, .problem-card {
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-blue-50">

<div class="flex">
    <!-- ======================= SIDEBAR KIRI (FONT SUDAH INTER) ======================= -->
    <aside class="w-72 bg-white shadow-xl fixed h-full z-10 border-r border-blue-100 sidebar-scroll">
        <div class="p-6 border-b border-blue-100">
            <div class="flex items-center space-x-3">
                <!-- Logo solid -->
                <div class="bg-blue-600 p-2 rounded-xl">
                    <i class="fas fa-boxes text-white text-xl"></i>
                </div>
                <!-- Nama website -->
                <div>
                    <span class="text-xl font-bold text-gray-800">Inventaris</span>
                    <p class="text-xs text-gray-500">Manajemen Barang</p>
                </div>
            </div>
        </div>
        <nav class="mt-6 px-4">
            <a href="/dashboard" class="nav-item flex active items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-tachometer-alt w-6 text-blue-500 mr-3 text-lg"></i>
                <span>Dashboard</span>
            </a>
            <a href="/monitoring" class="nav-item flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-chart-line w-6 text-green-500 mr-3 text-lg"></i>
                <span>Monitoring Status Barang</span>
            </a>

            @if(in_array(auth()->user()->role, ['admin', 'staff']))
            <a href="/barang" class="nav-item flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-plus-circle w-6 text-purple-500 mr-3 text-lg"></i>
                <span>Data Barang</span>
            @endif
            </a>
        </nav>
        <!-- Footer sidebar solid -->
        <div class="absolute bottom-5 left-0 right-0 px-6">
            <div class="bg-gray-100 rounded-xl p-3 text-center">
                <i class="fas fa-database text-gray-400"></i>
                <p class="text-xs text-gray-500 mt-1">versi 1.0</p>
            </div>
        </div>
    </aside>
    <!-- ======================= KONTEN UTAMA ======================= -->
    <div class="ml-72 flex-1">
        <!-- Navbar atas -->
        <header class="sticky top-0 z-20 bg-white shadow-sm border-b border-blue-100">
            <div class="flex justify-between items-center px-8 py-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-chart-pie text-blue-500 text-xl"></i>
                    <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 px-4 py-2 rounded-full">
                        <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                        <span class="text-gray-700 font-medium">Halo, <span class="text-blue-700 font-bold">Admin</span></span>
                    </div>
                    <div class="relative dropdown">
                        <button class="flex items-center focus:outline-none">
                            <div class="w-10 h-10 rounded-full ring-2 ring-blue-300 overflow-hidden">
                                <img src="https://ui-avatars.com/api/?background=3b82f6&color=fff&name=Admin"
                                     alt="Profile"
                                     class="w-full h-full object-cover">
                            </div>
                            <i class="fas fa-chevron-down ml-2 text-gray-400 text-xs"></i>
                        </button>
                        <div class="dropdown-menu">
                            <div class="py-2">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">Admin</p>
                                    <p class="text-xs text-gray-500">admin@inventaris.com</p>
                                </div>
                                <a href="#"
                                    class="text-red-500 flex items-center gap-1"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                    <i class="fas fa-sign-out-alt mr-3 ml-3 text-red-500"></i> Logout
                                </a>

                                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                                @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main content dashboard -->
        <main class="p-8">
            <!-- Stat Card -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white p-5 border-l-4 border-yellow-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">On Hold</p>
                            <p id="on_hold" class="text-3xl font-bold text-gray-800">{{ $onHold ?? 0 }}</p>
                        </div>
                        <i class="fas fa-pause-circle text-yellow-500 text-3xl"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-5 border-l-4 border-gray-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Unreleased</p>
                            <p id="unreleased" class="text-3xl font-bold text-gray-800">{{ $unreleased ?? 0 }}</p>
                        </div>
                        <i class="fas fa-clock text-gray-500 text-3xl"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-5 border-l-4 border-red-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Reject</p>
                            <p id="reject" class="text-3xl font-bold text-gray-800">{{ $reject ?? 0 }}</p>
                        </div>
                        <i class="fas fa-times-circle text-red-500 text-3xl"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-5 border-l-4 border-green-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Approved</p>
                            <p id="approved" class="text-3xl font-bold text-gray-800">{{ $approved ?? 0 }}</p>
                        </div>
                        <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                    </div>
                </div>
            </div>

            <div id="ai-alert" class="hidden mb-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg"></div>
            <div id="ws-status" class="mb-8 bg-gray-100 border-l-4 border-gray-400 text-gray-600 p-3 rounded-lg text-sm">
                <i class="fas fa-plug mr-2"></i> Menghubungkan real-time dashboard...
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-brain text-blue-500 mr-2"></i> AI Insight
                    </h3>
                    <div id="ai-insight-list" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($insights as $insight)
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-sm text-gray-700">
                                {{ $insight }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-bell text-red-500 mr-2"></i> Notifikasi Operasional
                    </h3>
                    <div id="ops-alert-list" class="space-y-3">
                        @if(($problematic->count() ?? 0) > 0)
                            <div class="bg-red-50 border border-red-100 rounded-xl p-3 text-sm text-red-700">
                                {{ $problematic->count() }} barang memiliki anomaly.
                            </div>
                        @endif
                        @if(($lowStock->count() ?? 0) > 0)
                            <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 text-sm text-yellow-700">
                                {{ $lowStock->count() }} barang stok rendah.
                            </div>
                        @endif
                        @if(($problematic->count() ?? 0) === 0 && ($lowStock->count() ?? 0) === 0)
                            <div class="bg-green-50 border border-green-100 rounded-xl p-3 text-sm text-green-700">
                                Tidak ada alert operasional mendesak.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-8 bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-history text-purple-500 mr-2"></i> Riwayat Perubahan Status
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Barang</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            </tr>
                        </thead>
                        <tbody id="status-log-table" class="divide-y divide-gray-100">
                            @forelse($statusLogs as $log)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $log->created_at->format('d M H:i') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ $log->barang->nama_barang ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $log->old_status ?? '-' }} &rarr; {{ $log->new_status ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $log->old_jumlah ?? '-' }} &rarr; {{ $log->new_jumlah ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $log->user->name ?? 'System' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat perubahan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(!empty($alerts))
            <div id="flask-alert" class="mb-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <div class="font-semibold mb-2">
                    <i class="fas fa-bell mr-2"></i> Alert AI
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($alerts as $alert)
                        <li>{{ $alert }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-8 bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-robot text-blue-500 mr-2"></i> Chatbot Inventaris
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Tanya data barang langsung dari database Laravel.</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-3">
                    <input
                        type="text"
                        id="chatInput"
                        class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none"
                        placeholder="Contoh: berapa barang reject?"
                    >
                    <button
                        type="button"
                        onclick="sendChat()"
                        id="chatButton"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition"
                    >
                        <i class="fas fa-paper-plane mr-2"></i> Kirim
                    </button>
                </div>
                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                    <button type="button" onclick="askChat('berapa barang reject?')" class="px-3 py-1 rounded-full bg-red-100 text-red-700">barang reject</button>
                    <button type="button" onclick="askChat('barang mana bermasalah?')" class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">barang bermasalah</button>
                    <button type="button" onclick="askChat('stok habis apa saja?')" class="px-3 py-1 rounded-full bg-green-100 text-green-700">stok hampir habis</button>
                </div>
                <div id="chatResult" class="mt-4 hidden rounded-xl bg-blue-50 border border-blue-100 p-4 text-sm text-gray-700"></div>
            </div>

            <!-- Chart dan Barang Bermasalah -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="chart-container bg-white p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Jumlah Barang per Status</h3>
                    <canvas id="statusChart" width="400" height="300"></canvas>
                </div>
                <div class="problem-card bg-white p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Barang Bermasalah
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Anomaly</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Recommendation</th>
                                </tr>
                            </thead>
                            <tbody id="problem-table" class="divide-y divide-gray-100">
                                @forelse($problematic as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ $item->nama_barang }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $item->jumlah }}</td>
                                    <td class="px-4 py-2">
                                        @if($item->status == 'reject')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                                <i class="fas fa-times-circle mr-1"></i> Reject
                                            </span>
                                        @elseif($item->status == 'approved')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle mr-1"></i> Approved
                                            </span>
                                        @elseif($item->status == 'unreleased')
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                                <i class="fas fa-clock mr-1"></i> Unreleased
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                                <i class="fas fa-pause-circle mr-1"></i> On Hold
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm text-red-600 font-medium">{{ $item->anomaly ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-green-700">{{ $item->recommendation ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-400">
                                        <i class="fas fa-check-circle text-4xl mb-2 block"></i>
                                        Tidak ada barang bermasalah
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    const statusData = [
        {{ $onHold ?? 0 }},
        {{ $unreleased ?? 0 }},
        {{ $reject ?? 0 }},
        {{ $approved ?? 0 }}
    ];
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['On Hold', 'Unreleased', 'Reject', 'Approved'],
            datasets: [{
                label: 'Jumlah Barang',
                data: statusData,
                backgroundColor: ['#eab308', '#6b7280', '#ef4444', '#22c55e'],
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: (ctx) => ctx.raw + ' barang' } }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Jumlah' }, grid: { color: '#e5e7eb' } },
                x: { title: { display: true, text: 'Status' } }
            }
        }
    });

    const summaryIds = ['on_hold', 'unreleased', 'reject', 'approved'];
    const csrfToken = '{{ csrf_token() }}';
    let dashboardFallbackInterval = null;

    function escapeHtml(value) {
        return String(value ?? '-')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatStatus(status) {
        const config = {
            reject: ['bg-red-100 text-red-700', 'fas fa-times-circle mr-1', 'Reject'],
            approved: ['bg-green-100 text-green-700', 'fas fa-check-circle mr-1', 'Approved'],
            unreleased: ['bg-gray-100 text-gray-700', 'fas fa-clock mr-1', 'Unreleased'],
            on_hold: ['bg-yellow-100 text-yellow-700', 'fas fa-pause-circle mr-1', 'On Hold'],
        };

        const [classes, icon, label] = config[status] ?? ['bg-gray-100 text-gray-700', 'fas fa-info-circle mr-1', status ?? '-'];

        return `<span class="px-2 py-1 text-xs rounded-full ${classes}">
            <i class="${icon}"></i> ${escapeHtml(label)}
        </span>`;
    }

    function renderProblemTable(items) {
        const table = document.getElementById('problem-table');

        if (!items.length) {
            table.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-gray-400">
                        <i class="fas fa-check-circle text-4xl mb-2 block"></i>
                        Tidak ada barang bermasalah
                    </td>
                </tr>
            `;
            return;
        }

        table.innerHTML = items.map((item) => `
            <tr>
                <td class="px-4 py-2 text-sm text-gray-800">${escapeHtml(item.nama_barang)}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${escapeHtml(item.jumlah)}</td>
                <td class="px-4 py-2">${formatStatus(item.status)}</td>
                <td class="px-4 py-2 text-sm text-red-600 font-medium">${escapeHtml(item.anomaly)}</td>
                <td class="px-4 py-2 text-sm text-green-700">${escapeHtml(item.recommendation)}</td>
            </tr>
        `).join('');
    }

    function renderAiAlert(count) {
        const alertBox = document.getElementById('ai-alert');
        const flaskAlert = document.getElementById('flask-alert');

        if (count > 0) {
            alertBox.classList.remove('hidden');
            alertBox.innerHTML = `
                <div class="font-semibold">
                    <i class="fas fa-brain mr-2"></i> AI Alert
                </div>
                <div class="text-sm mt-1">${count} barang perlu perhatian.</div>
            `;

            if (flaskAlert) {
                flaskAlert.classList.add('hidden');
            }
            return;
        }

        alertBox.classList.add('hidden');
        alertBox.innerHTML = '';
    }

    function renderInsights(insights) {
        const container = document.getElementById('ai-insight-list');

        if (!insights.length) {
            container.innerHTML = '<div class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-sm text-gray-500">Belum ada insight.</div>';
            return;
        }

        container.innerHTML = insights.map((insight) => `
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-sm text-gray-700">
                ${escapeHtml(insight)}
            </div>
        `).join('');
    }

    function renderOpsAlerts(data) {
        const container = document.getElementById('ops-alert-list');
        const alerts = [];

        if ((data.problem_count ?? 0) > 0) {
            alerts.push(`<div class="bg-red-50 border border-red-100 rounded-xl p-3 text-sm text-red-700">${data.problem_count} barang memiliki anomaly.</div>`);
        }

        if ((data.low_stock_count ?? 0) > 0) {
            const names = (data.low_stock ?? []).slice(0, 4).map((item) => escapeHtml(item.nama_barang)).join(', ');
            alerts.push(`<div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 text-sm text-yellow-700">${data.low_stock_count} barang stok rendah${names ? `: ${names}` : ''}.</div>`);
        }

        if (!alerts.length) {
            alerts.push('<div class="bg-green-50 border border-green-100 rounded-xl p-3 text-sm text-green-700">Tidak ada alert operasional mendesak.</div>');
        }

        container.innerHTML = alerts.join('');
    }

    function renderStatusLogs(logs) {
        const table = document.getElementById('status-log-table');

        if (!logs.length) {
            table.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat perubahan.</td></tr>';
            return;
        }

        table.innerHTML = logs.map((log) => {
            const time = new Date(log.created_at).toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                hour: '2-digit',
                minute: '2-digit',
            });

            return `
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-600">${escapeHtml(time)}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">${escapeHtml(log.barang?.nama_barang)}</td>
                    <td class="px-4 py-2 text-sm text-gray-600">${escapeHtml(log.old_status)} &rarr; ${escapeHtml(log.new_status)}</td>
                    <td class="px-4 py-2 text-sm text-gray-600">${escapeHtml(log.old_jumlah)} &rarr; ${escapeHtml(log.new_jumlah)}</td>
                    <td class="px-4 py-2 text-sm text-gray-600">${escapeHtml(log.user?.name ?? 'System')}</td>
                </tr>
            `;
        }).join('');
    }

    function applyDashboardData(data) {
        summaryIds.forEach((key) => {
            document.getElementById(key).innerText = data.summary[key] ?? 0;
        });

        statusChart.data.datasets[0].data = [
            data.summary.on_hold ?? 0,
            data.summary.unreleased ?? 0,
            data.summary.reject ?? 0,
            data.summary.approved ?? 0,
        ];
        statusChart.update();

        renderProblemTable(data.problem ?? []);
        renderAiAlert(data.problem_count ?? 0);
        renderInsights(data.insights ?? []);
        renderOpsAlerts(data);
        renderStatusLogs(data.status_logs ?? []);
    }

    function setWebSocketStatus(status) {
        const statusBox = document.getElementById('ws-status');
        const config = {
            connected: ['bg-green-100 border-green-500 text-green-700', 'Real-time dashboard aktif.'],
            connecting: ['bg-gray-100 border-gray-400 text-gray-600', 'Menghubungkan real-time dashboard...'],
            disconnected: ['bg-yellow-100 border-yellow-500 text-yellow-700', 'WebSocket belum tersambung. Jalankan php artisan dashboard:websocket, sementara dashboard memakai fallback AJAX.'],
        };
        const [classes, message] = config[status] ?? config.connecting;

        statusBox.className = `mb-8 border-l-4 p-3 rounded-lg text-sm ${classes}`;
        statusBox.innerHTML = `<i class="fas fa-plug mr-2"></i> ${message}`;
    }

    async function loadDashboardFallback() {
        try {
            const res = await fetch('/api/dashboard-data', {
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) {
                return;
            }

            applyDashboardData(await res.json());
        } catch (error) {
            console.warn('Fallback dashboard gagal.', error);
        }
    }

    function startDashboardFallback() {
        if (dashboardFallbackInterval) {
            return;
        }

        loadDashboardFallback();
        dashboardFallbackInterval = setInterval(loadDashboardFallback, 5000);
    }

    function stopDashboardFallback() {
        if (!dashboardFallbackInterval) {
            return;
        }

        clearInterval(dashboardFallbackInterval);
        dashboardFallbackInterval = null;
    }

    function connectDashboardSocket() {
        setWebSocketStatus('connecting');

        const protocol = window.location.protocol === 'https:' ? 'wss' : 'ws';
        const socket = new WebSocket(`${protocol}://${window.location.hostname}:6001/dashboard`);

        socket.addEventListener('open', () => {
            stopDashboardFallback();
            setWebSocketStatus('connected');
        });

        socket.addEventListener('message', (event) => {
            const data = JSON.parse(event.data);

            if (data.type === 'dashboard.updated') {
                applyDashboardData(data);
            }
        });

        socket.addEventListener('close', () => {
            setWebSocketStatus('disconnected');
            startDashboardFallback();
            setTimeout(connectDashboardSocket, 3000);
        });

        socket.addEventListener('error', () => {
            socket.close();
        });
    }

    async function sendChat() {
        const input = document.getElementById('chatInput');
        const result = document.getElementById('chatResult');
        const button = document.getElementById('chatButton');
        const message = input.value.trim();

        if (!message) {
            return;
        }

        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses';
        result.classList.remove('hidden');
        result.innerHTML = `<p><b>Kamu:</b> ${escapeHtml(message)}</p><p class="mt-2 text-gray-500"><b>AI:</b> Sedang membaca data...</p>`;

        try {
            const res = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ message }),
            });

            const data = await res.json();
            result.innerHTML = `<p><b>Kamu:</b> ${escapeHtml(message)}</p><p class="mt-2"><b>AI:</b> ${escapeHtml(data.reply)}</p>`;
            input.value = '';
        } catch (error) {
            result.innerHTML = `<p><b>AI:</b> Maaf, chatbot belum bisa dihubungi.</p>`;
        } finally {
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Kirim';
            input.focus();
        }
    }

    function askChat(message) {
        document.getElementById('chatInput').value = message;
        sendChat();
    }

    document.getElementById('chatInput').addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            sendChat();
        }
    });

    connectDashboardSocket();
</script>

</body>
</html>
