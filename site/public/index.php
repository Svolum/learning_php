<?php

// подключаем пакеты которые установили через composer
require_once '../vendor/autoload.php';
//
require_once '../framework/autoload.php';
// Контроллер's
require_once '../controllers/MainController.php';
require_once '../controllers/Controller404.php';
require_once '../controllers/ObjectController.php';


///     DB
$host = 'mariadb'; // Имя сервиса MariaDB из docker-compose.yml
$dbname = 'my_bd';
$user = 'root';
$password = 'root';
$port = '3306';
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


///     TWIG
// создаем загрузчик шаблонов, и указываем папку с шаблонами
// \Twig\Loader\FilesystemLoader -- это типа как в C# писать Twig.Loader.FilesystemLoader,
// только слеш вместо точек
$loader = new \Twig\Loader\FilesystemLoader('../views');

// создаем собственно экземпляр Twig с помощью которого будет рендерить
$twig = new \Twig\Environment($loader, [
    "debug" => true // добавить debug режим
]);
$twig->addExtension(new \Twig\Extension\DebugExtension()); // включить debug режим


//      ROUTER
$router = new Router($twig, $pdo);
$router->add("#^/$#", MainController::class);
$router->add("#^/oil-company/(?P<id>\d+)#", ObjectController::class);
// preg_match("/oil-company/(\d+)", $_SERVER['REQUEST_URI'], $match);
// echo "lol".$match;

$router->get_or_default(Controller404::class);