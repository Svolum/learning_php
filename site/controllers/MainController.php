<?php
class MainController extends TwigBaseController {
    public $template = "main.twig";
    public $title = "Main page";

    public function getContext(): array {
        $context = parent::getContext();

        $query = $this->pdo->query("SELECT id, title, image FROM oil_comps");
        $context['oil_comps'] = $query->fetchAll();
        
        return $context;
    }
}