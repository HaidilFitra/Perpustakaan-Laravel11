# Perpustakaan Digital Literalink

## Deskripsi

Perpustakaan Digital Literalink adalah sebuah aplikasi web yang memungkinkan pengguna untuk mengelola buku, peminjaman, dan pengembalian buku. Aplikasi ini dibuat untuk memudahkan pengguna dalam mengakses dan meminjam buku digital. Untuk Dashboard admin menggunakan Argon Dashboard Laravel.

## Fitur

-   Fitur 1: Login Dengan Role Admin(administrator),Petugas,dan User(Peminjam) beserta dengan Recaptcha v2
-   Fitur 2: CRUD Buku
-   Fitur 3: CRUD Peminjaman
-   Fitur 4: CRUD Pengembalian
-   Fitur 5: Generate Laporan

## Teknologi yang Digunakan

-   Teknologi 1: Laravel 11
-   Teknologi 2: Bootstrap 5
-   Teknologi 4: DomPDF

## Cara Instalasi

1. Clone repository ini
2. Install composer dan npm
3. Jalankan perintah `composer install` dan `npm install`
4. Copy file `.env.example` menjadi `.env` dan isi dengan data database Anda
5. Untuk Recaptcha v2, silahkan daftar di google recaptcha dan isi id site dan secret key di file `.env`
6. Jalankan perintah `php artisan key:generate`
7. Jalankan perintah `php artisan migrate`
8. Jalankan perintah `php artisan serve`
