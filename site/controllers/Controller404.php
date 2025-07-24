<?php
require_once "TwigBaseController.php";

class Controller404 extends TwigBaseController {
    public $template = "404.twig";
    public $title = 'Page not found';

    public function get()
    {
        http_response_code(404);
        parent::get();
    }
}