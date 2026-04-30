{{-- <h1>Edit Barang</h1>

<form action="/barang/{{ $barang->id }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}">
    <input type="number" name="jumlah" value="{{ $barang->jumlah }}">

   <select name="status">
    <option value="on_hold">On Hold</option>
    <option value="unreleased">Unreleased</option>
    <option value="reject">Reject</option>
    <option value="approved">Approved</option>
</select>

    <button type="submit">Update</button>
</form> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris - Edit Barang</title>
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
        .form-card {
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        .input-field {
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
        }
        .input-field:focus {
            border-color: #3b82f6;
            outline: none;
            ring: 2px solid #bfdbfe;
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
            <a href="/monitoring" class="nav-item flex items-center px-4 py-3 text-gray-700 font-medium">
                <i class="fas fa-chart-line w-6 text-green-500 mr-3 text-lg"></i>
                <span>Monitoring Status Barang</span>
            </a>


            @if(in_array(auth()->user()->role, ['admin', 'staff']))
            <a href="/barang" class="nav-item flex items-center px-4 py-3  bg-blue-100 text-blue-800 font-medium">
                <i class="fas fa-plus-circle w-6 text-purple-500 mr-3 text-lg"></i>
                <span>Data Barang</span>
            </a>
            @endif

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
                <!-- Nama halaman (kiri navbar) -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-edit text-blue-500 text-xl"></i>
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Barang</h2>
                </div>

                <!-- Kanan navbar: sapaan + foto + dropdown logout -->
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

        <!-- Main content: Form Edit Barang -->
        <main class="p-8">
            <div class="max-w-2xl mx-auto">
                <div class="form-card bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Form Edit Barang</h3>
                        <p class="text-sm text-gray-500 mt-1">Ubah data barang yang diperlukan.</p>
                    </div>

                    <form action="/barang/{{ $barang->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Barang -->
                        <div class="mb-5">
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                            <div class="relative">
                                <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="nama_barang" id="nama_barang"
                                       value="{{ $barang->nama_barang }}"
                                       class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                                       placeholder="Contoh: Laptop, Meja, Kursi" required>
                            </div>
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-5">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <div class="relative">
                                <i class="fas fa-hashtag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="number" name="jumlah" id="jumlah"
                                       value="{{ $barang->jumlah }}"
                                       class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                                       placeholder="0" min="0" required>
                            </div>
                        </div>

                        <!-- Status (dengan nilai selected sesuai data) -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <div class="relative">
                                <i class="fas fa-flag-checkered absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <select name="status" id="status"
                                        class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none bg-white">
                                    <option value="on_hold" {{ $barang->status == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                    <option value="unreleased" {{ $barang->status == 'unreleased' ? 'selected' : '' }}>Unreleased</option>
                                    <option value="reject" {{ $barang->status == 'reject' ? 'selected' : '' }}>Reject</option>
                                    <option value="approved" {{ $barang->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Tombol Update & Batal -->
                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <a href="/barang" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition duration-200">
                                <i class="fas fa-save mr-2"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
