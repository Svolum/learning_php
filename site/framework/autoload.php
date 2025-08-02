<?php

spl_autoload_register(function($class) {
    $fn = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($fn)) {
	    require_once $fn; 
    }
    //      ЖУТКИЙ КОСТЫЛЬ
    // который проверяет наличие искомого файла с кодом класса в соседней папке "controllers"
    else {
        $fn = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($fn)) {
            require_once $fn; 
        }
    }
});