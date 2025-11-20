<?php
// класс контроллер, для организации страницы 404
class Controller404 extends TwigBaseController {
    public $template = "404.twig";
    public $title = 'Page not found';

    public function get(array $context)
    {
        http_response_code(404);
        parent::get($context);
    }
}