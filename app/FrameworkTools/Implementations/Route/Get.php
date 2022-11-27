<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\HelloWorldController;
use App\Controllers\TrainQueryController;
use App\Controllers\LucasController;

trait Get {
    
    private static function get() {
        switch (self::$processServerElements->getRoute()) {
            case '/hello-world':
                return (new HelloWorldController)->execute();
            case '/train-query':
                return (new TrainQueryController)->execute();
            case '/santos1':
                return (new LucasController)->santos1();
        }
    }

}