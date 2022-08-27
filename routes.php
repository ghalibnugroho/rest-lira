<?php 


use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\Katalogs;


SimpleRouter::get('/', function() {
    return 'Hello world';
});

SimpleRouter::get('/katalogs', [Katalogs::class, 'getAllKatalogs']);

// SimpleRouter::error