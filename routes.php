<?php 


use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\Katalogs;
use App\Controllers\Sirkulasi;


SimpleRouter::get('/', function() {
    echo nl2br("\n \n HOMEPAGE OF DATA TRAFFIC LIRA APP \n \n \n ### IF YOU WAS JUMPED HERE ACCIDENTALLY, IT MEANS YOU GOT SOME ERROR FROM PREVIOUS DATA CONNECTIONS.");
});

SimpleRouter::get('/katalogs', [Katalogs::class, 'getKatalogs']);
SimpleRouter::get('/katalogs/search', [Katalogs::class, 'getSearchKatalogs']);
SimpleRouter::get('/katalogs/{id}', [Katalogs::class, 'getKatalogDetailByID']);

SimpleRouter::post('/auth', [Authentikasi::class, login]);

SimpleRouter::get('/pinjam', [Sirkulasi::class, 'test']);

// SimpleRouter::error