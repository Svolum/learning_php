<?php
require_once "BaseController.php";

class TwigBaseController extends BaseController {
    public $title = "";
    public $template = "";
    protected \Twig\Environment $twig; // ссылка на экземпляр twig, для рендернига
    // теперь пишем конструктор, 
    // передаем в него один параметр
    // собственно ссылка на экземпляр twig
    // это кстати Dependency Injection называется
    // это лучше чем создавать глобальный объект $twig 
    // и быстрее чем создавать персональный $twig обработчик для каждого класс
    public function __construct($twig) {
        $this->twig = $twig;
    }
    public function getContext(): array {
        $context = parent::getContext();
        $context['title'] = $this->title;

        // Menu
        $context['menu'] = [
            [
                "title" => "Main page",
                "url" => "/"
            ],
            [
                "title" => "Lukoil",
                "url" => "/lukoil"
            ],
            [
                "title" => "British petrolium",
                "url" => "/british-petrolium"
            ]
        ];

        return $context;
    }
    // функция гет, рендерит результат используя $template в качестве шаблона
    // и вызывает функцию getContext для формирования словаря контекста
    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}