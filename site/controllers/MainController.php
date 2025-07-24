<?php
require_once "TwigBaseController.php";


class MainController extends TwigBaseController {
    public $template = "main.twig";
    public $title = "Main page";

    public function getContext(): array {
        $context = parent::getContext();

        $query = $this->pdo->query("SELECT * FROM oil_comps");

        $context['oil_comps'] = $query->fetchAll();
        
        return $context;
    }
}