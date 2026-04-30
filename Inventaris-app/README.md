🧾 Sistem Inventaris Barang

Aplikasi berbasis Laravel + Vite + MySQL untuk mengelola data inventaris dengan sistem role dan monitoring status.

🚀 Fitur Utama
📦 A. CRUD Inventaris
Tambah barang
Edit status barang
Hapus barang
Lihat daftar barang
📊 B. Monitoring Status (Core System)
Menampilkan jumlah barang berdasarkan status:
on_hold
unreleased
reject
approved
Menampilkan barang bermasalah (status: reject & on_hold)
Filter berdasarkan status
Tampilan khusus monitoring (read-only, tanpa CRUD)
🔐 C. Role Management
Role	Akses
Admin	Full akses (CRUD + Monitoring)
Staff Gudang	CRUD barang
Manager	Monitoring saja (tidak bisa CRUD)
🔑 D. Authentication
Login system
Redirect otomatis berdasarkan role
Logout menggunakan POST (secure Laravel)
🛠️ Teknologi yang Digunakan
Laravel 13
PHP 8.4
MySQL (phpMyAdmin)
Vite
Tailwind CSS
⚙️ Cara Menjalankan Project (Dari Nol)
1. Clone Repository
git clone https://github.com/username/nama-repo.git
cd nama-repo
2. Install Dependency
composer install
npm install
3. Copy File Environment
cp .env.example .env
4. Generate App Key
php artisan key:generate
5. Setting Database (.env)

Buka file .env, lalu sesuaikan:

DB_DATABASE=db_inventaris
DB_USERNAME=root
DB_PASSWORD=

📌 Pastikan database sudah dibuat di phpMyAdmin

6. Migrasi Database
php artisan migrate
7. Jalankan Vite
npm run dev
8. Jalankan Server
php artisan serve
9. Akses Aplikasi
http://127.0.0.1:8000

👉 otomatis diarahkan ke /login
