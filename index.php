<?php
require_once __DIR__ . '/vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter;

/* Load external routes file */
require_once 'routes.php';

// SimpleRouter::get('/lira', function() {
//     return 'Hello world';
// });

/**
 * The default namespace for route-callbacks, so we don't have to specify it each time.
 * Can be overwritten by using the namespace config option on your routes.
 */

SimpleRouter::setDefaultNamespace('\Demo\Controllers');

// Start the routing
SimpleRouter::start();


//autoload Composer.json ==> untuk auto define namespace
// composer dumpautoload