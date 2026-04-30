# Inventaris_web-app
Web dan AI

1.	Clone Repository : git clone https://github.com/username/nama-repo.git cd nama-repo
2.	Install Dependency : composer install npm install
3.	Copy File Environment : cp .env.example .env
4.	Generate App Key : php artisan key:generate
5.	Setting Database (.env)
Buka file .env, lalu sesuaikan:
DB_DATABASE=db_inventaris DB_USERNAME=root DB_PASSWORD=
📌 Pastikan database sudah dibuat di phpMyAdmin
6.	Migrasi Database : php artisan migrate
7.	Jalankan Vite : npm run dev
8.	Jalankan Server : php artisan serve
9.	Akses Aplikasi http://127.0.0.1:8000
👉 otomatis diarahkan ke /login

