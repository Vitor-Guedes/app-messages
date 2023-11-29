<?php

use App\Messages\App;

include "../vendor/autoload.php";

define('BASE_VIEW', dirname(__FILE__) . "/../views/");

try {
    include "../src/Helpers/functions.php";

    $app = new App();

    include "../src/routes.php";

    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . ":" . $e->getFile() . ' - ' . $e->getLine();
}