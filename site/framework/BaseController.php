<?php
/* 
это класс - основа для всех контроллеров. В этом классе стягиваются базовые переменные (объекты или точнее классы) 
для вообще работы сайта и наследник может иметь косвенное отношение к реализующему отображение страницы класс или вообще не иметь
*/
abstract class BaseController {
    public PDO $pdo;
    public array $params;
    public function setPDO(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function setParams(array $params){
        $this->params = $params;
    }

    public function getContext(): array {
        return [];
    }
    // с помощью функции get будет вызывать непосредственно рендеринг
    // так как рендерить необязательно twig шаблоны, а можно, например, всякий json
    // то метод сделаем абстрактным, ну типа кто наследуем BaseController
    // тот обязан переопределить этот метод
    public function process_responce(){
        $method =  $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET'){
            $this->get();
        } else if ($method == 'POST'){
            $this->post();
        }
    }
    public function get() {}
    public function post() {}
}