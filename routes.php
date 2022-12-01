<?php 

use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\Katalogs;
use App\Controllers\Autentikasi;
use App\Controllers\Sirkulasi;
use App\Controllers\Koleksi;
use App\Controllers\Presensi;


SimpleRouter::get('/', function() {
    echo nl2br("\n \n HOMEPAGE OF DATA TRAFFIC \n \n \n ### IF YOU GOT JUMPED HERE ACCIDENTALLY, IT MEANS YOU'VE SOME ERROR FROM PREVIOUS DATA CONNECTIONS.");
});

// Guest route
SimpleRouter::get('/katalogs', [Katalogs::class, 'getKatalogs']);
SimpleRouter::get('/katalogs/search', [Katalogs::class, 'getSearchKatalogs']);
SimpleRouter::get('/katalogs/{id}', [Katalogs::class, 'getKatalogDetailByID']);

// Auth route
SimpleRouter::post('/auth', [Autentikasi::class, 'login']);
SimpleRouter::post('/registrasi', [Autentikasi::class, 'registrasi']);

// petugas route
SimpleRouter::get('/petugas/getAllAnggota', [Sirkulasi::class, 'getAllMembers']);
SimpleRouter::get('/petugas/anggotaById/{id}', [Sirkulasi::class, 'getMemberByID']);
SimpleRouter::get('/petugas/anggotaCollectionLoans/{memberNo}', [Sirkulasi::class, 'getMemberCollectionLoans']);
SimpleRouter::get('/petugas/anggotaCollectionLoanItems/{collectionLoan_id}', [Sirkulasi::class, 'getMemberCollectionLoanItems']);

SimpleRouter::get('/petugas/koleksiKatalog/{id}', [Koleksi::class, 'getKoleksiKatalogById']);
SimpleRouter::post('/petugas/tambahKoleksi', [Koleksi::class, 'addKoleksiKatalog']);
SimpleRouter::delete('/petugas/delete/koleksi/{id}', [Koleksi::class, 'deleteKoleksi']);
SimpleRouter::get('/koleksi/kodeQR/{QR}', [Koleksi::class, 'getKodeQR']);

SimpleRouter::get('/petugas/daftarPresensi', [Presensi::class, 'getAllDaftarPresensi']);

SimpleRouter::put('/petugas/validasiPeminjaman/{collectionLoanId}', [Sirkulasi::class, 'validateLoan']);
SimpleRouter::delete('/petugas/abortPeminjaman/{collectionLoanId}', [Sirkulasi::class, 'abortLoan']);

SimpleRouter::post('/petugas/extendPeminjaman', [Sirkulasi::class,'extendLoan']);
SimpleRouter::put('/petugas/finishPeminjaman/{collectionLoanId}/{collectionId}', [Sirkulasi::class, 'finishLoan']);


// Anggota route
SimpleRouter::get('/anggota/logPresensi/{memberNo}', [Presensi::class, 'getPresensiByMemberNo']);
SimpleRouter::post('/anggota/presensi', [Presensi::class,'presensiByMemberNo']);
SimpleRouter::get('/anggota/data/{memberNo}', [Presensi::class, 'getDataAnggota']);
SimpleRouter::get('/anggota/katalog/koleksi/kodeQR/{QR}', [Sirkulasi::class, 'getKatalogByKodeQR']);
SimpleRouter::post('/anggota/pinjambuku', [Sirkulasi::class, 'addSirkulasiLoanAnggota']);
