<p align="center"> <a href="https://casafunds.com" target="_blank"> <img src="https://raw.githubusercontent.com/your-repo/logo/master/casafunds-logo.svg" width="400" alt="CasaFunds Logo"> </a> </p> <p align="center"> <a href="https://github.com/casafunds/casafunds/actions"> <img src="https://github.com/casafunds/casafunds/workflows/tests/badge.svg" alt="Build Status"> </a> <a href="https://packagist.org/packages/casafunds/casafunds"> <img src="https://img.shields.io/packagist/dt/casafunds/casafunds" alt="Total Downloads"> </a> <a href="https://packagist.org/packages/casafunds/casafunds"> <img src="https://img.shields.io/packagist/v/casafunds/casafunds" alt="Latest Stable Version"> </a> <a href="https://packagist.org/packages/casafunds/casafunds"> <img src="https://img.shields.io/packagist/l/casafunds/casafunds" alt="License"> </a> </p>

### About CasaFunds
CasaFunds berasal dari dua kata:

Casa yang berarti "rumah" dalam bahasa Spanyol atau Italia.
Funds yang berarti "dana" atau "keuangan" dalam bahasa Inggris.
Jika digabungkan, CasaFunds secara harfiah berarti "dana rumah" atau "keuangan rumah," yang menggambarkan aplikasi untuk mengelola dana, pembayaran, dan pengeluaran yang berhubungan dengan perumahan.

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
git clone https://github.com/your-username/casafunds.git
cd casafunds

2. Instal Dependensi Backend Instal dependensi PHP yang dibutuhkan oleh Laravel menggunakan Composer:
composer install

3. Instal Dependensi Frontend Instal semua dependensi frontend menggunakan npm:
npm install

4. Copy File Environment Buat salinan file .env.example dan ubah menjadi .env:
cp .env.example .env

5. Konfigurasi Database Buka file .env dan ubah konfigurasi database sesuai dengan setelan lokal Anda:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database

6. Generate Application Key Jalankan perintah berikut untuk menghasilkan aplikasi key Laravel:
php artisan key:generate

7. Migrasi Database dan Seeder Jalankan migrasi untuk membuat tabel-tabel yang dibutuhkan di database:
php artisan migrate --seed
or
php artisan migrate:fresh --seed

9. Jalankan Server Lokal Jalankan server development lokal untuk backend:
php artisan serve

Aplikasi sekarang dapat diakses di http://localhost:8000 untuk backend dan frontend tergantung dari Vite.

Contributing
Kami sangat menghargai kontribusi untuk mengembangkan aplikasi CasaFunds. Silakan merujuk pada Panduan Kontribusi untuk informasi lebih lanjut.

License
Aplikasi CasaFunds bersifat open-source dan dilisensikan di bawah MIT license.







