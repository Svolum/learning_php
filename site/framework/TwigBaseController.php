<?php
/*
?Не до конца понимаю зачем мне столько прослоек между базовым классом и реализующими, но вероятно для обчения сойдет, хотя я сильно путяюсь\
добавляются переменные необходимые для непосредственного отображния страницы как например шаблон
*/
// require_once "BaseController.php";

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
    public function setTwig($twig) {
        $this->twig = $twig;
    }
    public function getContext(): array {
        $context = parent::getContext();
        $context['title'] = $this->title;

        return $context;
    }
    // функция гет, рендерит результат используя $template в качестве шаблона
    // и вызывает функцию getContext для формирования словаря контекста
    public function get() {
        if ($this->template == ""){
            print_r("<h2>template is not set</h2>");
        }
        echo $this->twig->render($this->template, $this->getContext());
    }
}