<?php

// подключаем пакеты которые установили через composer
require_once '../vendor/autoload.php';
// Контроллер's
require_once '../controllers/MainController.php';
require_once '../controllers/Controller404.php';
require_once '../controllers/ObjectController.php';

  
// создаем загрузчик шаблонов, и указываем папку с шаблонами
// \Twig\Loader\FilesystemLoader -- это типа как в C# писать Twig.Loader.FilesystemLoader,
// только слеш вместо точек
$loader = new \Twig\Loader\FilesystemLoader('../views');

  
// создаем собственно экземпляр Twig с помощью которого будет рендерить
$twig = new \Twig\Environment($loader, [
    "debug" => true // добавить debug режим
]);
$twig->addExtension(new \Twig\Extension\DebugExtension()); // включить debug режим




$url = $_SERVER["REQUEST_URI"];

$title = "";
$template = "";

$context = [];

$controller = new Controller404($twig);

$host = 'mariadb'; // Имя сервиса MariaDB из docker-compose.yml
$dbname = 'my_bd';
$user = 'root';
$password = 'root';
$port = '3306';
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $query = $pdo->query("SELECT * FROM oil_comps");
// $result = $query->fetchAll();

// echo "<pre>";
// foreach($result as $row) {
//     echo "---------new_row---------";
//     print_r($row);
// }
// echo "</pre>";


if ($url == "/") {
    $controller = new MainController($twig);
    
// Lukoil
}elseif (preg_match('#^/lukoil/image#', $url)) {
    $context['title'] = 'Lukoil';
    $context['base_url'] = "/lukoil";
    $context['image'] = "/images/lukoil.jpeg";
    $controller = new ObjectController($twig, "base_image.twig", $context);
}elseif (preg_match('#^/lukoil/info#', $url)) {
    $context['title'] = 'Lukoil';
    $context['base_url'] = "/lukoil";
    $context['info'] = "oil company";
    $controller = new ObjectController($twig, 'base_info.twig', $context);
}elseif (preg_match("#^/lukoil#", $url)) {
    $context['title'] = 'Lukoil';
    $context['base_url'] = "/lukoil";
    $controller = new ObjectController($twig, "__object.twig", $context);

// British petrolium
}elseif (preg_match("#^/british-petrolium/image#", $url)) {
    $context['title'] = "British petrolium";
    $context['base_url'] = "/british-petrolium";
    $context['image'] = "/images/brit_petr.jfif";
    $controller = new ObjectController($twig, "base_image.twig", $context);
}elseif (preg_match('#^/british-petrolium/info#', $url)) {
    $context['title'] = "British petrolium";
    $context['base_url'] = "/british-petrolium";
    $context['info'] = "big and old oil company";
    $controller = new ObjectController($twig, 'base_info.twig', $context);
}elseif (preg_match("#^/british-petrolium#", $url)) {
    $context['title'] = "British petrolium";
    $context['base_url'] = "/british-petrolium";
    $controller = new ObjectController($twig, "__object.twig", $context);
}


if ($controller) {
    $controller->setPDO($pdo);
    $controller->get();
}