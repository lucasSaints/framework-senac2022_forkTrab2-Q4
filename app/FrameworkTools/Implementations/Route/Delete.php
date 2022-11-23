<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\DeleteController;
trait Delete {
    
    private static function delete() {
        switch (self::$processServerElements->getRoute()) {  
            case '/delete_user':
                $delete = new DeleteController();
                return $delete->exec();
            break;
        }
    }

}