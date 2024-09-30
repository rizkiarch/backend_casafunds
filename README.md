<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Aplication
CasaFunds berasal dari dua kata:

Casa yang berarti "rumah" dalam bahasa Spanyol atau Italia.
Funds yang berarti "dana" atau "keuangan" dalam bahasa Inggris.
Jika digabungkan, CasaFunds secara harfiah berarti "dana rumah" atau "keuangan rumah," yang menggambarkan aplikasi untuk mengelola dana, pembayaran, dan pengeluaran yang berhubungan dengan perumahan.

## Entity Relationship Diagram
<img src="[/docs/logo.png]()" alt="ERD"/>
![Alt text]([https://example.com/path/to/image.png](https://github.com/rizkiarch/backend_casafunds/blob/main/Cuplikan%20layar%202024-09-30%20140456.png
))

## Installation
Berikut adalah langkah-langkah untuk menginstal dan mengatur aplikasi CasaFunds dari awal hingga akhir.

Prasyarat
Node.js: Pastikan Anda sudah menginstal Node.js versi terbaru.
https://nodejs.org/
Composer: Pastikan Anda sudah menginstal Composer.
https://getcomposer.org/
PHP: PHP 8.0 atau yang lebih baru.
MySQL: Sebagai basis data default, meskipun Anda dapat menggunakan basis data lain yang didukung oleh Laravel.

## Langkah Instalasi
1. Clone Repository
```bash
git clone https://github.com/rizkiarch/backend_casafunds.git
```
```bash
cd backend_casafunds
```

2. Instal Dependensi Backend Instal dependensi PHP yang dibutuhkan oleh Laravel menggunakan Composer:
```bash
composer install
```

4. Copy File Environment Buat salinan file .env.example dan ubah menjadi .env:
```bash
cp .env.example .env
```

5. Konfigurasi Database Buka file .env dan ubah konfigurasi database sesuai dengan setelan lokal Anda:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database
```

6. Generate Application Key Jalankan perintah berikut untuk menghasilkan aplikasi key Laravel:
```bash
php artisan key:generate
```

7. Migrasi Database dan Seeder Jalankan migrasi untuk membuat tabel-tabel yang dibutuhkan di database:
```bash
php artisan migrate --seed
or
php artisan migrate:fresh --seed
```


8. Jalankan Server Lokal Jalankan server development lokal untuk backend:
```bash
php artisan serve
```

```bash
Username : admin
Password : 123123123
```

Aplikasi sekarang dapat diakses di http://localhost:8000 untuk backend dan frontend disini https://github.com/rizkiarch/frontend_casafunds tergantung dari Vite.

License
Aplikasi CasaFunds bersifat open-source dan dilisensikan di bawah MIT license.







