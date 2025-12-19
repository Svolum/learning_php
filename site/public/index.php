<?php
session_start();

// подключаем пакеты которые установили через composer
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
// JavaScript



///     DB
$host = 'mariadb'; // Имя сервиса MariaDB из docker-compose.yml
$dbname = 'my_bd';
$user = 'root';
$password = 'root';
$port = '3306';
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $password, $user);
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
$twig->addGlobal('session', $_SESSION);


//      ROUTER
$router = new Router($twig, $pdo);
$router->add("^/", MainController::class)
        ->middleware(new LoginRequiredMiddleware());;
$router->add("/oil-company/(?P<id>\d+)", ObjectController::class)
        ->middleware(new LoginRequiredMiddleware());;;
$router->add("/oil-company/delete", OilCompDeleteController::class)
        ->middleware(new LoginRequiredMiddleware());
$router->add("/login", LoginController::class);
$router->add("/logout", LogoutController::class)
        ->middleware(new LoginRequiredMiddleware());;;

$router->add("/oil-company/create", OilCompCreateController::class)
       ->middleware(new LoginRequiredMiddleware());

$router->add("/oil-company/update/(?P<id>\d+)", OilCompUpdateController::class)
       ->middleware(new LoginRequiredMiddleware());

$router->add("/search", SearchController::class)
        ->middleware(new LoginRequiredMiddleware());;;
$router->add("/books", BookListController::class)
        ->middleware(new LoginRequiredMiddleware());;;
$router->add("/book/(?P<id>\d+)", BookReadController::class)
        ->middleware(new LoginRequiredMiddleware());;;

$router->get_or_default(Controller404::class);