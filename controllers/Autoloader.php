<?php
namespace Demetech;

class Autoloader {
    static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class) {
        if (strpos($class, __NAMESPACE__) === 0) {
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);

            $directories = [
                __DIR__ . '/../models/',
                __DIR__ . '/../controllers/',
                __DIR__ . '/../config/',
            ];

            foreach ($directories as $directory) {
                $file = $directory . $class . '.php';
                if (file_exists($file)) {
                    require $file;
                    return;
                }
            }

            throw new \Exception("Fichier introuvable pour la classe : " . $class);
        }
    }
}