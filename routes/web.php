<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['register' => false]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::group(['middleware' => 'guest'], function () {
	Route::get('/register', 'DaftarController@index')->name('register');
	Route::post('/register/proses', 'DaftarController@register')->name('register.proses');
	Route::get('/', 'HalamanController@index')->name('halaman.index');
});

Route::get('/home', 'HomeController@index')->name('home');

// reute group for crud
Route::group(['prefix' => 'crud'], function () {
	Route::post('simpan-soal', 'SoalController@simpanSoal');
	Route::post('update-profil', 'CrudController@updateProfil');
	Route::post('simpan-materi', 'CrudController@simpanMateri');
	Route::post('terbit-soal', 'CrudController@terbitSoal');
	Route::post('simpan-detail-soal', 'SoalController@simpanDetailSoal');
	Route::post('simpan-detail-soal-via-excel', 'SoalController@simpanDetailSoalExcel');
	Route::post('simpan-gambar-materi', 'CrudController@simpanGambarMateri');
	Route::post('hapus-gambar-materi', 'CrudController@hapusGambarMateri');
	Route::post('simpan-gambar-user', 'CrudController@simpanGambarUser');
	Route::post('update-profil-sekolah', 'CrudController@updateProfilSekolah');
	Route::post('simpan-informasi', 'CrudController@simpanInformasi');
	Route::post('simpan-guru', 'GuruController@simpanGuru');
	Route::post('simpan-siswa', 'CrudController@simpanSiswa');
	Route::post('update-siswa', 'CrudController@updateSiswa');
	Route::post('simpan-siswa-via-excel', 'CrudController@simpanSiswaViaExcel');
	Route::post('update-img-siswa', 'CrudController@updateImgSiswa');
	Route::post('delete-siswa', 'CrudController@deleteSiswa');
	Route::post('update-guru', 'CrudController@updateGuru');
	Route::post('delete-guru', 'CrudController@deleteGuru');
	Route::post('simpan-kelas', 'CrudController@simpanKelas');
	Route::post('delete-kelas', 'CrudController@deleteKelas');
	Route::post('delete-informasi', 'CrudController@deleteInformasi');
	Route::post('reset-ujian', 'CrudController@resetUjian');
});

Route::group(['prefix' => 'pengaturan'], function () {
	Route::get('/', 'HomeController@pengaturan')->name('pengaturan');
});

Route::group(['prefix' => 'master'], function () {
	// route master guru
	Route::group(['prefix' => 'guru'], function () {
		Route::get('/', 'GuruController@index')->name('master.guru');
		Route::get('data-guru', 'GuruController@dataGuru')->name('master.data_guru');
		Route::get('detail/{id}', 'GuruController@detailGuru');
		Route::get('ubah/{id}', 'GuruController@ubahGuru');
	});
	// route master informasi
	Route::get('informasi', 'InformasiController@index')->name('master.informasi');
	Route::get('data-informasi', 'InformasiController@dataInformasi')->name('master.data_informasi');
	Route::get('informasi/detail/{id}', 'InformasiController@detailInformasi')->name('master.detail_informasi');
	Route::get('detail-informasi/', 'InformasiController@detailInformasiSiswa')->name('master.detail_informasi_siswa');
	Route::get('informasi/ubah/{id}', 'InformasiController@ubahInformasi')->name('master.ubah_informasi');
	// route master kelas
	Route::get('kelas', 'KelasController@index')->name('master.kelas');
	Route::get('data-kelas', 'KelasController@dataKelas')->name('master.data_kelas');
	Route::get('kelas/detail/{id}', 'KelasController@detailKelas')->name('master.detail_kelas');
	Route::get('detail-kelas/', 'KelasController@detailKelasSiswa')->name('master.detail_kelas_siswa');
	Route::get('kelas/ubah/{id}', 'KelasController@ubahKelas')->name('master.ubah_kelas');
	// route master siswa
	Route::group(['prefix' => 'siswa'], function () {
		Route::get('/', 'SiswaController@index')->name('siswa');
		Route::get('data-siswa', 'SiswaController@dataSiswa')->name('master.data_siswa');
		Route::get('detail/{id}', 'SiswaController@detailSiswa');
		Route::get('edit/{id}', 'SiswaController@editSiswa');
		Route::get('delete', 'SiswaController@delete');
		Route::get('get-btn-delete/{password}', 'SiswaController@getBtnDelete');
		Route::get('delete-all', 'SiswaController@deleteAll');
		Route::post('validasi', 'SiswaController@validasi')->name('validasi');
	});
});

Route::group(['prefix' => 'elearning'], function () {
	Route::group(['prefix' => 'materi'], function () {
		Route::get('/', 'MateriController@index')->name('elearning.materi');
		Route::get('/get-materi-guru', 'MateriController@dataMateriGuru')->name('elearning.dataMateriGuru');
		Route::get('/detail/{id}', 'MateriController@detail')->name('elearning.detailMateri');
		Route::get('/ubah/{id}', 'MateriController@ubah')->name('elearning.detailMateri');
	});
	Route::group(['prefix' => 'laporan'], function () {
		Route::get('/', 'LaporanController@index')->name('elearning.laporan');
		Route::get('/detail-kelas/{id}', 'LaporanController@detailKelas')->name('elearning.laporan');
		Route::get('data-paket-soal', 'LaporanController@data_paket_soal')->name('elearning.laporan.data_paket_soal');
		Route::get('detail-kelas/{id_kelas}/paket-soal/{id_soal}', 'LaporanController@detailPaketSoalPerKelas');
		Route::get('data-kelas-paket-soal', 'LaporanController@dataKelasPaketSoal')->name('elearning.laporan.data_kelas_paket_soal');
		Route::get('data-siswa', 'LaporanController@dataSiswa')->name('elearning.laporan.data_siswa');
		Route::get('{id_soal}/{id_user}', 'LaporanController@detailLaporanSiswa')->name('elearning.detailLaporanSiswa');
		Route::get('hasil-siswa', 'LaporanController@hasilSiswa')->name('elearning.hasilSiswa');
	});
	Route::group(['prefix' => 'soal'], function () {
		Route::get('/', 'SoalController@index')->name('soal');
		Route::get('/ubah/{id}', 'SoalController@ubahSoal')->name('soal.ubah');
		Route::get('/detail/{id}', 'SoalController@detail')->name('elearning.detail-soal');
		Route::get('/get-soal', 'SoalController@dataSoal')->name('elearning.get-soal');
		Route::get('/get-soal-home', 'SoalController@dataSoalHome')->name('elearning.get-soal-home');
		Route::get('/get-detail-soal', 'SoalController@dataDetailSoal')->name('elearning.get-detail-soal');
		Route::get('/detail/ubah/{id}', 'SoalController@ubahDetailSoal')->name('elearning.ubah-detail-soal');
		Route::get('/detail/data-soal/{id}', 'SoalController@detailDataSoal')->name('elearning.detail-data-soal');
		Route::get('/essay/data', 'DetailSoalEssayController@data');
		Route::get('/essay/simpan-score', 'JawabController@simpanScore');
		Route::resource('/essay', 'DetailSoalEssayController');
	});
	Route::group(['prefix' => 'nilai'], function () {
		Route::get('/', 'NilaiController@index')->name('nilai');
		Route::get('data-nilai', 'NilaiController@dataNilai')->name('elearning.data_nilai');
		Route::get('input/{id}', 'NilaiController@inputNilai');
		Route::get('pengeluaran/{id}', 'NilaiController@pengeluaran');
		Route::post('input', 'NilaiController@inputNilaiPost')->name('nilai.input.post');
		Route::post('pengeluaran', 'NilaiController@pengeluaranPost')->name('nilai.pengeluaran.post');
		Route::get('cetak/pdf/sertifikat/{user}/{kelas}', 'NilaiController@pdfSertifikatUjian');
		Route::get('import', 'NilaiController@import')->name('nilai.import');
		Route::post('import/proses', 'NilaiController@importProses')->name('nilai.import.proses');
	});
});

Route::group(['prefix' => 'keuangan'], function () {
	Route::get('/laporan', 'LaporanController@keuanganIndex')->name('keuangan.laporan');
	Route::post('data-keuangan', 'LaporanController@laporanKeuangan')->name('keuangan.laporan.data_keuangan');
});

Route::get('/download-file-format/{filename}', 'DownloadController@download')->name('download');
Route::group(['prefix' => 'cetak'], function () {
	Route::get('/kartu-ujian', 'ErrorHandleController@e404')->name('soal');
	Route::get('/berita-acara', 'ErrorHandleController@e404')->name('soal');
	Route::get('/excel/hasil-ujian-perkelas/{soal}/{kelas}', 'LaporanController@excelHasilUjianPerkelas');
	Route::get('/pdf/hasil-ujian-persiswa/{siswa}/{soal}', 'LaporanController@pdfHasilUjianPersiswa');
	Route::get('/pdf/laporan-keuangan/{user}/{awal}/{akhir}', 'LaporanController@pdfLaporanKeuangan');
	// Route::get('/pdf/laporan-keuangan/{user}/{tahun}', 'LaporanController@pdfLaporanKeuangan');
});
Route::get('/activity', 'HomeController@activity');

Route::group(['prefix' => 'siswa'], function () {
	Route::get('data-materi', 'SiswaController@dataMateri')->name('siswa.materi');
	Route::get('materi/detail/{id}', 'SiswaController@detailMateri');
	Route::get('materi', 'SiswaController@materi');
	Route::get('daftar-ujian', 'SiswaController@daftarUjian')->name('siswa.daftar-ujian');
	Route::post('payment-ujian', 'SiswaController@payment')->name('siswa.payment');
	Route::post('payment-ujian-post', 'SiswaController@paymentPost')->name('siswa.payment-post');
	Route::get('history-ujian', 'SiswaController@historyUjian');
	Route::get('ujian', 'SiswaController@ujian');
	Route::post('ujian/cek-token-ujian', 'SiswaController@cekTokenUjian')->name('siswa.cek-token-ujian');
	Route::get('ujian/get-detail-essay', 'SiswaController@getDetailEssay');
	Route::get('ujian/simpan-jawaban-essay', 'SiswaController@simpanJawabanEssay');
	Route::get('ujian/detail/{id}', 'SiswaController@detailUjian');
	Route::get('ujian/finish/{id}', 'SiswaController@finishUjian');
	Route::get('ujian/get-soal/{id}', 'SiswaController@getSoal');
	Route::post('ujian/jawab', 'SiswaController@jawab');
	Route::post('ujian/kirim-jawaban', 'SiswaController@kirimJawaban');
	Route::get('cetak/pdf/sertifikat-ujian-persiswa/{nilai}', 'LaporanController@pdfSertifikatUjianPersiswa');
	Route::post('ujian/pembayaran-ujian/kirim-email', 'SiswaController@kirimEmailMin1Jam')->name('siswa.pembayaran.email');
	Route::post('ujian/pembayaran-ujian/reset', 'SiswaController@resetPendaftaranUjian')->name('siswa.pembayaran.reset');
});
