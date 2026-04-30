<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris - Monitoring Inventaris</title>
   <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
        .data-table {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        .data-table thead tr {
            background-color: #f1f5f9;
            border-bottom: 2px solid #cbd5e1;
        }
        .data-table tbody tr {
            transition: background-color 0.2s;
        }
        .data-table tbody tr:hover {
            background-color: #f8fafc;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-blue-50">

<div class="flex">
    <!-- ======================= SIDEBAR KIRI ======================= -->
    <aside class="w-72 bg-white shadow-xl fixed h-full z-10 border-r border-blue-100 sidebar-scroll">
        <div class="p-6 border-b border-blue-100">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 p-2 rounded-xl">
                    <i class="fas fa-boxes text-white text-xl"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-gray-800">Inventaris</span>
                    <p class="text-xs text-gray-500">Manajemen Barang</p>
                </div>
            </div>
        </div>
        <nav class="mt-6 px-4">
            <a href="/dashboard" class="nav-item flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-tachometer-alt w-6 text-blue-500 mr-3 text-lg"></i>
                <span>Dashboard</span>
            </a>
            <a href="/monitoring" class="nav-item active flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-chart-line w-6 text-green-500 mr-3 text-lg"></i>
                <span>Monitoring Status Barang</span>
            </a>
            <a href="/barang" class="nav-item flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-plus-circle w-6 text-purple-500 mr-3 text-lg"></i>
                <span>Data Barang</span>
            </a>
        </nav>
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
                    <i class="fas fa-chart-line text-green-500 text-xl"></i>
                    <h2 class="text-2xl font-semibold text-gray-800">Monitoring Inventaris</h2>
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

        <!-- Main content -->
        <main class="p-8">
            <!-- STATISTIK 4 STATUS (Card) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white p-5 border-l-4 border-yellow-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">On Hold</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $onHold ?? 0 }}</p>
                        </div>
                        <i class="fas fa-pause-circle text-yellow-500 text-3xl"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-5 border-l-4 border-gray-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Unreleased</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $unreleased ?? 0 }}</p>
                        </div>
                        <i class="fas fa-clock text-gray-500 text-3xl"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-5 border-l-4 border-red-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Reject</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $reject ?? 0 }}</p>
                        </div>
                        <i class="fas fa-times-circle text-red-500 text-3xl"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-5 border-l-4 border-green-500 shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Approved</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $approved ?? 0 }}</p>
                        </div>
                        <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- ALERT BARANG BERMASALAH -->
            @if(($problem ?? 0) > 0)
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded-lg flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                ⚠️ Ada {{ $problem }} barang bermasalah! (Reject / On Hold)
            </div>
            @endif

            <!-- FORM FILTER (Hanya Status - Tanpa Lokasi) -->
            <div class="mb-8 bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                            <option value="">Semua Status</option>
                            <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                            <option value="unreleased" {{ request('status') == 'unreleased' ? 'selected' : '' }}>Unreleased</option>
                            <option value="reject" {{ request('status') == 'reject' ? 'selected' : '' }}>Reject</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                            <i class="fas fa-search mr-1"></i> Filter
                        </button>
                        <a href="{{ request()->url() }}" class="ml-2 text-gray-500 hover:text-gray-700 px-3 py-2">Reset</a>
                    </div>
                </form>
            </div>

            <!-- ======================= TABEL BARANG BERMASALAH ======================= -->
            <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Barang Bermasalah
            </h2>
            <div class="data-table bg-white border border-gray-200 mb-8">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prediction</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Anomaly</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Recommendation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($problematic as $item)
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-box text-red-400 mr-2"></i>
                                    <span class="font-medium text-gray-800">{{ $item->nama_barang }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">{{ $item->jumlah }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="status-badge bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle mr-1"></i> {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->prediction ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->anomaly ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $item->recommendation ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-check-circle text-3xl mb-2 block"></i>
                                Tidak ada barang bermasalah
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ======================= TABEL SEMUA BARANG ======================= -->
            <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-list-ul text-blue-500 mr-2"></i> Semua Barang
            </h2>
            <div class="data-table bg-white border border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prediction</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Anomaly</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Recommendation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($barangs as $item)
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-box text-blue-400 mr-2"></i>
                                    <span class="font-medium text-gray-800">{{ $item->nama_barang }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">{{ $item->jumlah }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                @php
                                    $statusClass = '';
                                    $statusIcon = '';
                                    if($item->status == 'approved') {
                                        $statusClass = 'bg-green-100 text-green-700';
                                        $statusIcon = 'fas fa-check-circle mr-1';
                                    } elseif($item->status == 'reject') {
                                        $statusClass = 'bg-red-100 text-red-700';
                                        $statusIcon = 'fas fa-times-circle mr-1';
                                    } elseif($item->status == 'on_hold') {
                                        $statusClass = 'bg-yellow-100 text-yellow-700';
                                        $statusIcon = 'fas fa-pause-circle mr-1';
                                    } else {
                                        $statusClass = 'bg-gray-100 text-gray-700';
                                        $statusIcon = 'fas fa-clock mr-1';
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="{{ $statusIcon }}"></i> {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->prediction ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->anomaly ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $item->recommendation ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                Tidak ada data barang
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

</body>
</html>
