<?php
// класс контроллер, для организации страницы 404
class Controller404 extends BaseOilTypesTwigController {
    public $template = "404.twig";
    public $title = 'Page not found';

    public function get()
    {
        http_response_code(404);
        parent::get();
    }
}