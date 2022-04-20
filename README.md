# SE English Final

Aplikasi Ujian Bahasa Inggris Berbasis Web Online

## Kebutuhan Server

Aplikasi ini dibangun diatas Framework <a href="https://laravel.com/docs/7.0" target="_blank" title="silahkan buka di tab baru, dengan klik kanan atau klik CTRL + clik">Laravel 7.0</a> dan MySQL versi 5. Sebelum menjalankan aplikasi ini, silahkan disiapkan terlebih dahulu beberapa software dan ekstension berikut:

- PHP versi 7.2 keatas
  - OpenSSL PHP Extension
  - PDO PHP Extension
  - Mbstring PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension
- MySQL
- Browser (lebih direkomendasikan Chrome versi 60 keatas)

Dapat menggunakan beberapa paket yang siap pakai untuk mempersingkat proses instalasi aplikasi ini.

## Instalasi

Disini proses instalasi pada sistem operasi Windows.

Pertama silahkan download XAMPP, silahkan download <a href="https://www.apachefriends.org/xampp-files/7.0.32/xampp-win32-7.0.32-0-VC14-installer.exe" target="_blank" title="silahkan buka di tab baru, dengan klik kanan atau klik CTRL + clik">disini</a>.
Silahkan install XAMPP yang telah berhasil didownload. Pastikan di komputer belum terinstall PHP & MySQL untuk menghindari konflik port. Apabila sebelumnya telah ada, silahkan cek versi PHP harus 7.2.

Setelah berhasil menginstal PHP dan MySQL (dalam paket XAMPP), lanjutkan install composer dan gitbash.

Untuk composer silahkan download <a href="https://getcomposer.org/" target="_blank" title="silahkan buka di tab baru, dengan klik kanan atau klik CTRL + clik">disini</a>.

Untuk gitbash silahkan download <a href="https://git-scm.com/download/win" target="_blank" title="silahkan buka di tab baru, dengan klik kanan atau klik CTRL + clik">disini</a>.

Silahkan instal composer dan git bash di komputer server. Setelah semua berhasil diinstal dengan benar bisa mulai clone aplikasi ini ke komputer.

Buka command prompt (gitbash) lalu arahkan ke folder htdocs (ada didalam folder xampp, misal menginstal di C. Berarti harus ke folder C:\\xampp\htdocs).

Setelah itu ketikan:

```
git clone https://github.com/eko10/seenglish_final.git
```

Tunggu sampai file selesai di clone ke folder htdocs server, lalu masuk ke folder <b>seenglish_final</b> dengan mengetikan (`cd seenglish_final`) pada command prompt (gitbash), lalu ketikan :

```
composer install
cp .env.example .env
php artisan key:generate
```

Atau apabila telah melakukan instalasi sebelumnya silahkan update composer dengan ketikan script dibawah ini (opsi ini hanya digunakan apabila terdapat update aplikasi, saat instalasi awal tidak diperlukan menggunakan script ini karena akan memakan waktu cukup lama):

```
composer update
cp .env.example .env
php artisan key:generate
```

Kemudian konfigurasi environment aplikasi seperti database, email dsb pada file .env(ubah .env.example menjadi .env)

Buka browser dan ketikan url http://localhost/phpmyadmin. Lalu buat database baru dengan nama <b>seenglish_final</b>. Setelah itu ketikan script berikut pada command promt:

```
php artisan migrate
php artisan db:seed
```

Setelah proses diatas berhasil dilalui tanpa hambatan, silahkan akses di browser url http://localhost/seenglish_final/public untuk mengakses aplikasi ujian atau juga http://localhost:8000 / http://127.0.0.1:8000 dengan menjalankan server via cmd.

```
php artisan serve
```

Untuk login sebagai admin silahkan gunakan email: <b>admin@seenglish.com</b>, password: <b>123456</b>
