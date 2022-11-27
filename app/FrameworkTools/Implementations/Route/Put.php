<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\UpdateDataController;
use App\Controllers\LucasController;

trait Put {

    private static function put() {
        switch (self::$processServerElements->getRoute()) {
            case '/update-data':
                return (new UpdateDataController)->exec();
            case '/santos3':
                return (new LucasController)->santos3();
        }
    }
}