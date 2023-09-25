<?php

namespace App;

use App\Autloader as AppAutoloader;

/**
 * This class is an autoloader, allow us to automatically require Classes
 * 
 * @package App\Autoloader
 */
class Autloader
{

    /**
     * This function will retrieve the class name 
     * and trigger the function autload
     */
    static function register()
    {

        //Doc: https://www.php.net/manual/fr/function.spl-autoload-register.php
        spl_autoload_register([__CLASS__, 'autoload']);
    }


    /**
     * @param string $class name Ex: App\Test  
     */
    static function autoload(string $class)
    {
        // Replace \\ to /
        // Ex: App\Test -> App/Test
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        // Remove the namespace
        // Ex: App/Test -> Test
        $class = str_replace(__NAMESPACE__, '', $class);

        $path = __DIR__ . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        } else {
            echo "File " . $path . " doesn't existe";
        }
    }
}

// Init autloader
AppAutoloader::register();
