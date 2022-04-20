@extends('layouts.markup')

@section('halaman')

<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
  <div class="container d-flex align-items-center">

    {{-- Tulisan --}}
    <h1 class="logo mr-auto"><a href="/"><strong>{{ config('app.name') }}</strong></a></h1>
    <!-- Logo SE English -->
    <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

    <nav class="nav-menu d-none d-lg-block">
      <ul>
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#about">Informasi</a></li>
        <li><a href="#services">Tata Cara</a></li>
        <li><a href="#term">Ketentuan</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li><a href="#contact">Kontak Kami</a></li>
        @if (Auth::guest())
        <li class="drop-down"><a href="#">Login</a>
          <ul>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
          </ul>
        </li>
        @else
        <li class="drop-down"><a href="#">{{ Auth::user()->name }}</a>
          <ul>
            <li><a href="{{ route('home') }}">Dashboard</a></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
        @endif
      </ul>
    </nav><!-- .nav-menu -->

  </div>
</header>
<!-- Akhir header -->

<!-- ======= Section halaman awal ======= -->
<section id="hero">
  <div class="hero-container">
    <h3>Selamat Datang di <strong>SE English</strong></h3>
    <h1>Platform Tes TOEFL di Malang Raya</h1>
    <a href="#about" class="btn-get-started scrollto">Informasi Tes</a>
  </div>
</section><!-- Akhir section halaman awal -->

<main id="main">
  <!-- ======= Section informasi tes ======= -->
  <section id="about" class="about">
    <div class="container" style="padding-bottom: 100px;">

      <div class="section-title">
        <h2>Informasi Tes</h2>
        <h3>Jadwal tes TOEFL <span>SE English</span></h3>
        <p>Berikut merupakan jadwal pembukaan sesi tes TOEFL SE English</p>
      </div>

      <div class="row content">
        <div class="col-lg-12 ">
          <table class="table table-bordered yajra-datatable" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Sesi</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Kuota (Tersedia)</th>
              </tr>
            </thead>
            @if($sesi->count() > 0)
            @foreach ($sesi as $ses)
            @php $peserta = \App\User::where('id_kelas', $ses->id)->where('status', 'S')->where('status_validasi', 'Y')->count(); @endphp
            <tbody>
              <tr>
                <td width="5%">{{ $iter++ }}</td>
                <td width="35%">{{ $ses->nama }}</td>
                <td width="15%">{{ $ses->tanggal }}</td>
                <td width="20%">{{ $ses->jam_mulai }} - {{ $ses->jam_selesai }}</td>
                <td width="25%">{{ $ses->kuota}} <b>({{ $ses->kuota - $peserta}})</b></td>
              </tr>
            </tbody>
            @endforeach
            @else
            <tbody>
              <tr>
                <td colspan="5" style="text-align: center;"><br>Belum ada jadwal tes</td>
              </tr>
            </tbody>
            @endif
          </table>
        </div>
      </div>

    </div>
  </section>
  <!-- Akhir section informasi tes -->

  <!-- ======= Section tata cara ======= -->
  <section id="services" class="services">
    <div class="container">

      <div class="section-title">
        <h2>Tata Cara</h2>
        <h3>Alur Pendaftaran Tes TOEFL <span>SE English</span></h3>
        <!-- <p>Berikut merupakan alur pendaftaran tes toefl pada platform SE English.</p> -->
      </div>

      <div class="row">
        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>1</a></h2>
            </div>
            <h4 class="title"><a>Informasi Jadwal Tes</a></h4>
            <p class="description">Calon peserta dapat melihat jadwal test TOEFL yang tersedia pada halaman informasi tes.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>2</a></h2>
            </div>
            <h4 class="title"><a>Daftar Akun</a></h4>
            <p class="description">Calon peserta dapat membuat akun pada halaman register, jika sudah memiliki akun silahkan login.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>3</a></h2>
            </div>
            <h4 class="title"><a>Login dan Daftar Tes</a></h4>
            <p class="description">Calon peserta dapat melakukan login dan mendaftar tes TOEFL. Ketentuan pendaftaran dapat dilihat pada halaman pendaftaran.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>4</a></h2>
            </div>
            <h4 class="title"><a>Pembayaran</a></h4>
            <p class="description">Calon peserta melakukan pembayaran melalui beberapa metode pembayaran setelah daftar dengan mekanisme sesuai metode pembayaran selama jangka waktu 1x24 jam.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>5</a></h2>
            </div>
            <h4 class="title"><a>Terdaftar</a></h4>
            <p class="description">Calon peserta dinyatakan terdaftar sebagai peserta tes TOEFL setelah pembayaran tervalidasi.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>6</a></h2>
            </div>
            <h4 class="title"><a>Kartu Ujian</a></h4>
            <p class="description">Peserta yang telah berhasil melakukan pendaftaran hingga pembayaran akan mendapatkan email berisi informasi pendaftaran dan ujian.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>7</a></h2>
            </div>
            <h4 class="title"><a>Mulai Tes</a></h4>
            <p class="description">Peserta dapat mengikuti tes dengan ketentuan dan mekanisme yang diinformasikan pada website.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
          <div class="icon-box">
            <div class="title">
              <h2 style="font-weight: bold;"><a>8</a></h2>
            </div>
            <h4 class="title"><a>Hasil Tes</a></h4>
            <p class="description">Selamat telah mengikuti tes TOEFL di SE English, silahkan melihat hasil tes pada halaman riwayat.</p>
          </div>
        </div>

      </div>
  </section>
  <!-- Akhir section tata cara -->

  <!-- ======= Section term ======= -->
  <section id="term" class="term">
    <div class="container">

      <div class="section-title">
        <h2>Term and Conditions</h2>
        <h3>Syarat & Ketentuan Tes TOEFL <span>SE English</span></h3>
        <!-- <p>Berikut merupakan syarat tes toefl pada platform SE English.</p> -->
      </div>

      <div class="row content">
        <div class="col-lg-12">
          <h3 style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 15px;">Persyaratan Wajib Peserta, Perangkat, Dan Ruang Ujian Mandiri Untuk TOEFL Daring (Online)</h3>
          <h4 class="title" style="font-weight: bold; font-size: 20px;">Peserta</h4>
          <p style="font-size: 15px;">
            1. Mampu melakukan proses pendaftaran dan pembayaran sesuai dengan syarat dan tahapan yang ditentukan. <br>
            2. Mampu mengoperasikan dan menyediakan perangkat yang diperlukan untuk tes TOEFL Daring. Apabila mempunyai hambatan baik dalam hal jasmani atau teknologi, mohon menghubungi Kontak Helpdesk TOEFL untuk mendapatkan arahan lebih lanjut.</p>
          <h4 class="title" style="font-weight: bold; font-size: 20px;">Perangkat</h4>
          <ul>
            <li style="font-weight: bold; font-size: 15px;">Laptop/PC, dengan Spesifikasi Minimum (bisa lebih tinggi)</li>
            <p style="font-size: 15px;">
              1. Terkoneksi Internet dengan stabil dengan kuota minimal 4Gb <br>
              2. Kamera / Webcam <br>
              3. RAM 2Gb, Prosesor Dual-Core, Storage 10Gb <br>
              4. Sistem Operasi Windows 7/8/10 atau Sistem Operasi Mac OS atau Linux <br>
              5. Layar mendukung resolusi 1024x768 pixel 32-bit berukuran minimal 12 inci <br>
              6. Browser Firefox/Chrome versi terbaru <br>
              7. Tidak terhubung dengan perangkat lain, kecuali mouse dan charger/adaptor battery <br>
              8. Terpasang aplikasi Zoom <br>
              9. Harus menggunakan headset <br>
            </p>
            <li style="font-weight: bold; font-size: 15px;">Smartphone, dengan ketentuan:</li>
            <p style="font-size: 15px;">
              1. Terkoneksi Internet dengan stabil dengan kuota minimal 4Gb <br>
              2. Mempunyai kamera depan dan belakang <br>
              3. Terpasang aplikasi Zoom dengan update terbaru <br>
            </p>
            <li style="font-weight: bold; font-size: 15px;">Mampu mengoperasikan dan menyediakan perangkat yang diperlukan untuk tes TOEFL Daring. Apabila mempunyai hambatan baik dalam hal jasmani atau teknologi, mohon menghubungi Kontak Helpdesk TOEFL untuk mendapatkan arahan lebih lanjut.</li>
          </ul>
          <h4 class="title" style="font-weight: bold; font-size: 20px;">Ruangan Ujian Mandiri</h4>
          <p style="font-size: 15px;">
            1. Laptop/PC harus berada di atas meja dengan kondisi rapi <br>
            2. Terdapat kursi sebagai tempat duduk yang nyaman <br>
            3. Berada pada ruang tertutup dengan penerangan yang cukup <br>
            4. Disarankan untuk menggunakan ruangan yang jauh dari keramaian/suara bising untuk <br>
            5. mendapatkan kualitas audio yang lebih baik <br>
          </p>
          <h3 style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 15px; margin-top: 25px;">Ketentuan Pelaksanaan Tes TOEFL Daring (Online)</h3>
          <h4 class="title" style="font-weight: bold; font-size: 20px;">Persiapan Peserta Sebelum Hari Pelaksanaan TOEFL Daring (Online)</h4>
          <p style="font-size: 15px;">
            1. Bergabung dengan grup WhatsApp sesuai dengan jadwal yang ditentukan. <br>
            2. Mempersiapkan perangkat dan ruangan sesuai dengan syarat yang telah ditentukan oleh panitia. <br>
            3. Mendapatkan Dokumen Petunjuk Pelaksanaan TOEFL Daring (Online) dari panitia. <br>
            4. Kewajiban mengikuti sesi technical meeting (TM) untuk mendapatkan semua info penting dan simulasi pelaksanaan TOEFL Daring (Online). <br>
          </p>
          <h4 class="title" style="font-weight: bold; font-size: 20px;">Pelaksanaan TOEFL Daring (Online)</h4>
          <p style="font-size: 15px;">
            1. Untuk keperluan monetoring, peserta diwajibkan mengenakan baju formal berwarna terang/cerah. Apabila peserta mengenakan kerudung, juga diharuskan dengan warna yang terang/cerah. <br>
            2. Peserta harus sudah siap di ruangan ujian mandiri dan bergabung secara online di grup WhatsApp dan Zoom Meeting, maksimal 10 menit sebelum jam pelaksanaan tes, untuk verifikasi dan mendapatkan arahan terakhir sebelum tes. Peserta tidak diperbolehkan mematikan video dan audio di Zoom Meeting dengan sengaja selama pelaksanaan tes untuk keperluan monetoring. Jika video dan audio di Zoom Meeting dimatikan oleh peserta, tes dinyatakan gagal (peserta didiskualifikasi). <br>
            3. Peserta menjalankan tes TOEFL Daring (Online) tepat waktu sesuai jadwal yang ditentukan. Apabila peserta terlambat mengikuti tes, panitia akan memberikan bantuan teknis apabila dibutuhkan TANPA adanya tambahan waktu. <br>
            4. Peserta menjalankan tes TOEFL Daring (Online) sesuai dengan arahan panitia dan peraturan yang tertulis di laman tes. Kesalahan yang terjadi karena kelalaian memahami peraturan menjadi tanggung jawab peserta. <br>
            5. Peserta harus mengerjakan seluruh tahapan tes TOEFL Daring (Online) secara mandiri tanpa bantuan orang lain, kamus, atau alat bantu lainnya. Panitia berhak menganulir hasil tes apabila peserta terindikasi melakukan kecurangan yang bisa diketahui melalui monetoring di Zoom Meeting. <br>
            6. Jika koneksi internet peserta terputus saat tes berlangsung, peserta harus dengan cepat berupaya menyelesaikan masalah tersebut secara mandiri dengan koordinasi dengan panitia. <br>
            7. Peserta tidak diperkenankan untuk menduplikasi atau mendokumentasikan soal dan dokumen pendukung TOEFL Daring (Online) dengan alasan dan cara apapun. Pelanggaran terhadap ketentuan ini dapat berakibat pada diskualifikasi hasil tes peserta dan menimbulkan konsekuensi hukum bagi peserta terkait dengan pelanggaran Hak Merek/Hak Cipta TOEFL. <br>
            8. Panitia berhak mengistruksikan peserta untuk menghapus seluruh dokumen pendukung tes TOEFL Daring (Online) setelah pelaksanaan tes. <br>
          </p>
          <h4 class="title" style="font-weight: bold; font-size: 20px;">Proses Mendapatkan Hasil Tes TOEFL Daring (Online)</h4>
          <p style="font-size: 15px;">
            1. Hasil tes dan sertifikat digital TOEFL dapat diunduh secara mandiri maksimal 3 (tiga) jam setelah pelaksanaan tes berakhir (Rapid Reporting System). Lama waktu pengunduhan sertifikat mandiri ini dibatasi sesuai dengan keputusan panitia yang akan disampaikan di grup WhatsApp. <br>
            2. Peserta dapat mengajukan sertifikat fisik TOEFL dan salinan yang telah dilegalisasi dengan mendaftarkan diri lewat grup WhatsApp. Sertifikat fisik dan salinan yang telah dilegalisasi ini bisa didapatkan secara gratis dan diambil di Kantor Lembaga Bahasa UMM dengan alamat: Basement Gedung Kuliah Bersama (GKB) IV UMM, Kampus III, Jl. Raya Tlogomas No. 246 Malang, Jawa Timur 65144. <br>
            3. Layanan legalisasi sertifikat fisik/digital TOEFL juga dapat dilakukan di Kantor Lembaga Bahasa UMM, dengan jumlah maksimal 2 lembar. Layanan ini tidak dikenakan biaya dengan syarat peserta menunjukkan slip pembayaran asli pendaftaran tes TOEFL. Legalisasi yang dilakukan setelah tiga (3) bulan setelah tanggal terbit sertifikat akan dikenai biaya sebesar Rp 5.000,00 per lembarnya. <br>
            4. Pengiriman sertifikat fisik TOEFL dan salinan yang sudah dilegalisasi bisa dikirim ke alamat peserta dengan biaya kirim yang ditanggung oleh peserta. <br>
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir section term -->

  <!-- ======= Section F.A.Q ======= -->
  <section id="faq" class="faq">
    <div class="container">

      <div class="section-title">
        <h2>F.A.Q</h2>
        <h3>Frequently Asked <span>Questions</span></h3>
      </div>

      <ul class="faq-list">

        <li>
          <a data-toggle="collapse" class="" href="#faq1">Apakah bisa mendaftar tes tanpa mendaftar akun? <i class="icofont-simple-up"></i></a>
          <div id="faq1" class="collapse show" data-parent=".faq-list">
            <p>
              Tidak bisa.
              Anda harus mendaftar akun terlebih dahulu untuk proses administrasi tes
            </p>
          </div>
        </li>

        <li>
          <a data-toggle="collapse" href="#faq2" class="collapsed">Apakah boleh melakukan pembayaran selain metode yang ditentukan? <i class="icofont-simple-up"></i></a>
          <div id="faq2" class="collapse" data-parent=".faq-list">
            <p>
              Pembayaran dilakukan melalui metode pembarayan yang ada pada saat melakukan pendaftaran tes
            </p>
          </div>
        </li>

        <li>
          <a data-toggle="collapse" href="#faq3" class="collapsed">Apakah dapat mendaftar tes 2 kali pada akun yang sama? <i class="icofont-simple-up"></i></a>
          <div id="faq3" class="collapse" data-parent=".faq-list">
            <p>
              Tidak bisa apabila belum menyelesaikan tes, jika sudah menyelesaikan tes maka dapat mendaftar tes lagi
            </p>
          </div>
        </li>

        <li>
          <a data-toggle="collapse" href="#faq4" class="collapsed">Kapan saya dapat mengerjakan tes? <i class="icofont-simple-up"></i></a>
          <div id="faq4" class="collapse" data-parent=".faq-list">
            <p>
              Anda dapat mengerjakan tes pada hari dan jam yang telah ditentukan
            </p>
          </div>
        </li>

        <li>
          <a data-toggle="collapse" href="#faq5" class="collapsed">Bagaimana langkah saya setelah melakukan pembayaran? <i class="icofont-simple-up"></i></a>
          <div id="faq5" class="collapse" data-parent=".faq-list">
            <p>
              Silahkan menunggu cek email anda secara berkala, anda akan mendapatkan kartu pendaftaran tes apabila pembayaran tervalidasi
            </p>
          </div>
        </li>

        <li>
          <a data-toggle="collapse" href="#faq6" class="collapsed">Bagaimana terdapat kesalahan sistem atau human error pada saat tes? <i class="icofont-simple-up"></i></a>
          <div id="faq6" class="collapse" data-parent=".faq-list">
            <p>
              Anda dapat menghubungi proctor atau admin untuk menemukan solusi lebih lanjut
            </p>
          </div>
        </li>

      </ul>

    </div>
  </section>
  <!--Akhir F.A.Q Section -->

  <!-- ======= Section kontak ======= -->
  <section id="contact" class="contact">
    <div class="container">

      <div class="section-title">
        <h2>Kontak</h2>
        <h3>Kontak <span>Kami</span></h3>
        <p>Informasi lokasi, email serta nomor yang dapat dihubungi</p>
      </div>

      <div>
        <!-- <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe> -->

        <!-- <iframe width="600" height="450" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJdQliLX-CeC4R1V7uu1l0m_E&key=..."></iframe> -->
      </div>

      <div class="row mt-12">
        <div class="col-lg-4" style="padding-top: 40px;">
          <div class="info">
            <div class="address">
              <i class="icofont-google-map"></i>
              <h4>Location:</h4>
              <p>Gedung SE English, Ketawanggede,
                Kec. Lowokwaru, Malang
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="info">
            <div class="email">
              <i class="icofont-envelope"></i>
              <h4>Email:</h4>
              <p>info@SEEnglish.com</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="info">
            <div class="phone">
              <i class="icofont-phone"></i>
              <h4>Call:</h4>
              <p>+62 8589 6554 885</p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- Akhir section kontak -->

</main><!-- Akhir #main -->

<!-- ======= Footer section ======= -->
<footer id="footer">

  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-lg-3 col-md-6 footer-contact">
          <h3>SE English</h3>
          <p>
            Ketawanggede, Kec. Lowokwaru<br>
            Malang, 65145<br>
            Indonesia <br><br>
            <strong>Phone:</strong> +62 8589 6554 885<br>
            <strong>Email:</strong> info@SEEnglish.com<br>
          </p>
        </div>

        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Tautan Alternatif</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#about">Informasi Tes</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#services">Tata Cara</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#term">Ketentuan</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#faq">FAQ</a></li>
          </ul>
        </div>

        {{-- <div class="col-lg-4 col-md-6 footer-newsletter">
          <h4>Subsribe Informasi Terbaru</h4>
          <p>Masukkan email anda untuk mendapatkan informasi pembukaan tes SE English</p>
          <form action="" method="post">
            <input type="email" name="email"><input type="submit" value="Subscribe">
          </form>
        </div> --}}

      </div>
    </div>
  </div>

  <div class="container d-md-flex py-4">

    <div class="mr-md-auto text-center text-md-left">
      <div class="copyright">
        &copy; Copyright 2022. <strong><span>SE English</span></strong>
      </div>
      <div class="credits">
      </div>
    </div>
    <div class="social-links text-center text-md-right pt-3 pt-md-0">
      <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
      <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
      <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
    </div>
  </div>
</footer><!-- Akhir Footer -->

@endsection