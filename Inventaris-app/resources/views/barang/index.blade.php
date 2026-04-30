{{-- <h1>Data Barang</h1>

<a href="/barang/create">Tambah Barang</a>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($barangs as $b)
    <tr>
        <td>{{ $b->nama_barang }}</td>
        <td>{{ $b->jumlah }}</td>
        <td>{{ $b->status }}</td>
        <td>
            <a href="/barang/{{ $b->id }}/edit">Edit</a>

            <form action="/barang/{{ $b->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table> --}}


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris - Data Barang</title>
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
        /* Sidebar custom scroll */
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
        /* Dropdown hover */
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
        /* Efek hover menu sidebar */
        .nav-item {
            transition: all 0.2s ease;
            border-radius: 12px;
        }
        .nav-item:hover {
            background-color: #dbeafe;
            transform: translateX(4px);
        }
        /* Tabel cantik */
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
        /* Tombol aksi bulat */
        .action-btn {
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 9999px;
        }
        .action-btn.edit:hover {
            background-color: #e0e7ff;
            color: #4f46e5;
        }
        .action-btn.delete:hover {
            background-color: #fee2e2;
            color: #ef4444;
        }
        /* Badge status */
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
            <a href="/dashboard" class="nav-item flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-tachometer-alt w-6 text-blue-500 mr-3 text-lg"></i>
                <span>Dashboard</span>
            </a>
            <a href="/monitoring" class="nav-item flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-chart-line w-6 text-green-500 mr-3 text-lg"></i>
                <span>Monitoring Status Barang</span>
            </a>

            @if(in_array(auth()->user()->role, ['admin', 'staff']))
            <a href="/barang" class="nav-item flex items-center px-4 py-3 font-medium  bg-blue-100 text-blue-800">
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
                <!-- Nama halaman (kiri navbar) -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-cubes text-blue-500 text-xl"></i>
                    <h2 class="text-2xl font-semibold text-gray-800">Data Barang</h2>
                </div>

                <!-- Kanan navbar: sapaan + foto + dropdown logout -->
                <div class="flex items-center space-x-4">
                    <!-- Sapaan admin dengan background soft -->
                    <div class="bg-blue-100 px-4 py-2 rounded-full">
                        <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                        <span class="text-gray-700 font-medium">Halo, <span class="text-blue-700 font-bold">Admin</span></span>
                    </div>
                    <!-- Dropdown profil -->
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
            <!-- Tombol Tambah Barang (solid) -->
            <div class="mb-6">
                <a href="/barang/create"
                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl shadow-md hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Barang
                </a>
            </div>

            <!-- Tabel Data Barang -->
            <div class="data-table bg-white rounded-2xl border border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prediction</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Anomaly</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Recommendation</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($barangs as $b)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-box text-blue-400 mr-3"></i>
                                    <span class="font-medium text-gray-800">{{ $b->nama_barang }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm">{{ $b->jumlah }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = '';
                                    $statusIcon = '';
                                    if($b->status == 'approved') {
                                        $statusClass = 'bg-green-100 text-green-700';
                                        $statusIcon = 'fas fa-check-circle mr-1';
                                    } elseif($b->status == 'reject') {
                                        $statusClass = 'bg-red-100 text-red-700';
                                        $statusIcon = 'fas fa-times-circle mr-1';
                                    } elseif($b->status == 'on_hold') {
                                        $statusClass = 'bg-yellow-100 text-yellow-700';
                                        $statusIcon = 'fas fa-pause-circle mr-1';
                                    } else {
                                        $statusClass = 'bg-gray-100 text-gray-700';
                                        $statusIcon = 'fas fa-clock mr-1';
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="{{ $statusIcon }}"></i> {{ $b->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $b->prediction ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $b->anomaly ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $b->recommendation ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="/barang/{{ $b->id }}/edit"
                                       class="action-btn edit text-blue-600 hover:bg-blue-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/barang/{{ $b->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete text-red-500 hover:bg-red-50">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Informasi total barang -->
            <div class="mt-5 text-right text-xs text-gray-400">
                <i class="fas fa-chart-simple"></i> Total barang: {{ $barangs->count() }}
            </div>
        </main>
    </div>
</div>

</body>
</html>
