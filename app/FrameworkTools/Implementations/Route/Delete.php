<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\DeleteController;
use App\Controllers\LucasController;

trait Delete {    
    private static function delete() {
        switch (self::$processServerElements->getRoute()) {  
            case '/delete_user':
                $delete = new DeleteController();
                return $delete->exec();
            case '/padilhadossantos4':
                return (new LucasController)->padilhadossantos4();
        }
    }
}