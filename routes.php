<?php 


use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\Katalogs;
use App\Controllers\Sirkulasi;


SimpleRouter::get('/', function() {
    return 'Hello world';
});

SimpleRouter::get('/katalogs', [Katalogs::class, 'getCoveredKatalogs']);
SimpleRouter::get('/katalogs/all', [Katalogs::class, 'getAllKatalogs']);

SimpleRouter::get('/pinjam', [Sirkulasi::class, 'test']);

// SimpleRouter::error