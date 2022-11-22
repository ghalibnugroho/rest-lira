<?php 


use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\Katalogs;
use App\Controllers\Sirkulasi;
use App\Controllers\Autentikasi;


SimpleRouter::get('/', function() {
    echo nl2br("\n \n HOMEPAGE OF DATA TRAFFIC LIRA APP \n \n \n ### IF YOU WAS JUMPED HERE ACCIDENTALLY, IT MEANS YOU GOT SOME ERROR FROM PREVIOUS DATA CONNECTIONS.");
});

// guest routes
SimpleRouter::get('/katalogs', [Katalogs::class, 'getKatalogs']);
SimpleRouter::get('/katalogs/search', [Katalogs::class, 'getSearchKatalogs']);
SimpleRouter::get('/katalogs/{id}', [Katalogs::class, 'getKatalogDetailByID']);

// auth route
SimpleRouter::post('/auth', [Autentikasi::class, 'login']);
SimpleRouter::post('/registrasi', [Autentikasi::class, 'registrasi']);

// petugas route
SimpleRouter::get('/petugas/getAllAnggota', [Sirkulasi::class, 'getAllMembers']);
SimpleRouter::get('/petugas/anggotaById/{id}', [Sirkulasi::class, 'getMemberByID']);
SimpleRouter::get('/petugas/anggotaCollectionLoans/{memberNo}', [Sirkulasi::class, 'getMemberCollectionLoans']);
SimpleRouter::get('/petugas/anggotaCollectionLoanItems/{collectionLoan_id}', [Sirkulasi::class, 'getMemberCollectionLoanItems']);
SimpleRouter::get('/petugas/daftarPresensi', [Presensi::class, 'getAllDaftarPresensi']);

// anggota route
SimpleRouter::get('/anggota/daftarPresensi/{memberNo}', [Presensi::class, 'getPresensiByMemberNo']);

// SimpleRouter::error