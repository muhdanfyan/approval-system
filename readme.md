**Aplikasi Pengelolaan Pengeluaran**

Aplikasi ini dirancang untuk membantu mengelola pengeluaran dalam sebuah organisasi. Aplikasi ini memungkinkan pengguna untuk membuat, mengedit, dan menghapus pengeluaran, serta menyetujui atau menolak pengeluaran yang diajukan oleh pengguna lain.

**Instalasi**

1. Clone repository ini ke dalam direktori Anda:
```bash
git clone https://github.com/muhdanfyan/approval-system.git
```
2. Jalankan perintah berikut untuk menginstal dependensi:
```bash
composer install
```
3. Jalankan perintah berikut untuk membuat tabel database:
```bash
php artisan migrate
```
4. Jalankan perintah berikut untuk membuat data awal:
```bash
php artisan db:seed
```
5. Jalankan perintah berikut untuk menjalankan aplikasi:
```bash
php artisan serve
```
6. Buka aplikasi di browser Anda dengan alamat `http://localhost:8000`

**Konfigurasi**

* Buat file `.env` di direktori root aplikasi dan isi dengan konfigurasi database Anda:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_management
DB_USERNAME=root
DB_PASSWORD=
```
* Atur konfigurasi aplikasi di file `config/app.php` jika perlu.

**Penggunaan**

1. Masuk ke aplikasi dengan menggunakan akun yang sudah ada atau buat akun baru.
2. Anda bisa menggunakan aplikasi untuk membuat, mengedit, dan menghapus pengeluaran, serta menyetujui atau menolak pengeluaran yang diajukan oleh pengguna lain.


**Topik**

* Pengelolaan pengeluaran
* Validasi endpoint
* Penggunaan Form Request Validation
* Penggunaan Repository Pattern
* Dokumentasi dengan Swagger
* Testing dengan PHPUnit

**Requirement**

* PHP 7.4 atau lebih tinggi
* Laravel 8.x atau lebih tinggi
* MySQL 5.7 atau lebih tinggi

**Nilai Tambah**

* Aplikasi ini dapat membantu mengelola pengeluaran dalam sebuah organisasi dengan lebih efektif dan efisien.
* Aplikasi ini dapat membantu mengurangi kesalahan dalam pengelolaan pengeluaran.

**Validasi Endpoint**

* Aplikasi ini menggunakan Form Request Validation untuk memvalidasi input pengguna.
* Aplikasi ini menggunakan Repository Pattern untuk memisahkan logika bisnis dari logika kontrol.

**Gunakan Form Request Validation**

* Aplikasi ini menggunakan Form Request Validation untuk memvalidasi input pengguna.

**Menggunakan file class request terpisah**

* Aplikasi ini menggunakan file class request terpisah untuk memisahkan logika validasi dari logika kontrol.

**Controller**

* Aplikasi ini menggunakan controller untuk mengatur logika kontrol.

**Alur logika kode diletakkan diluar file class Controller**

* Aplikasi ini menggunakan repository pattern untuk memisahkan logika bisnis dari logika kontrol.
**Menggunakan Repository Pattern**

* Aplikasi ini menggunakan repository pattern untuk memisahkan logika bisnis dari logika kontrol.
**Dokumentasi**

* Aplikasi ini menggunakan dokumentasi swagger untuk memudahkan penggunaan API.
* Contoh:
```php
// routes/api.php

Route::get('/expenses', 'ExpenseController@index')->name('expenses.index');
```

**Gunakan dokumentasi swagger**

* Aplikasi ini menggunakan dokumentasi swagger untuk memudahkan penggunaan API.
* Contoh:
```php
// routes/api.php

Route::get('/expenses', 'ExpenseController@index')->name('expenses.index');
```

**Pastikan Swagger UI bisa diakses, dan bisa digunakan untuk mencoba endpoint.**

* Aplikasi ini menggunakan dokumentasi swagger untuk memudahkan penggunaan API.
* Anda bisa mengakses Swagger UI di `http://localhost:8000/api/docs`
* Contoh:


**Testing**

* Aplikasi ini menggunakan PHPUnit untuk melakukan testing.
* Aplikasi ini melakukan testing untuk setiap endpoint.
* Contoh:

**Setiap endpoint di-test untuk memastikan bisa berjalan dengan baik.**

* Aplikasi ini melakukan testing untuk setiap endpoint.
* Aplikasi ini melakukan testing untuk setiap kondisi, mulai dari validasi input hingga alur didalamnya.

**Tidak hanya test response code saja, tapi berbagai kondisi di-test. Mulai dari test validasinya, serta test alur didalamnya. Semakin lengkap semakin bagus.**

