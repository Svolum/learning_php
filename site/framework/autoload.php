<?php
// этот файл вроде бы нужен для того чтобы подгружалось что-то, что явно не подгружено
// например эта функция отвечает за подгрузку (подключение?) кода классов 
// в файлах с тем же именем что и класс в папках "controllers" и "framework"
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