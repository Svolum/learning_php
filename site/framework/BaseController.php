<?php
abstract class BaseController {
    public PDO $pdo;
    public function setPDO(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getContext(): array {
        return [];
    }
    // с помощью функции get будет вызывать непосредственно рендеринг
    // так как рендерить необязательно twig шаблоны, а можно, например, всякий json
    // то метод сделаем абстрактным, ну типа кто наследуем BaseController
    // тот обязан переопределить этот метод
    abstract public function get();
}