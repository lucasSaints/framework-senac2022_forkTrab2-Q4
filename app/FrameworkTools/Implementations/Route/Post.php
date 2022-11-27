<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\InsertDataController;
use App\Controllers\LucasController;

trait Post {
    private static function post() {
        switch (self::$processServerElements->getRoute()) {
            case '/insert-data':
                return (new InsertDataController)->exec();
            case '/santos2':
                return (new LucasController)->santos2();
        }
    }

}