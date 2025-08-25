<?php
// класс контроллер, для организации страницы, по корневому адресу "/"
class MainController extends BaseOilTypesTwigController {
    public $template = "main.twig";
    public $title = "Main page";

    public function getContext(): array {
        $context = parent::getContext();


        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT id, title, image FROM oil_comps WHERE type = :my_type");
            $query->bindValue("my_type", $_GET['type']);
            $query->execute();
        }
        else {
            $query = $this->pdo->query("SELECT id, title, image FROM oil_comps");
        }
        
        $context['oil_comps'] = $query->fetchAll();


        $context['url_group'] = '/oil-company/';
        
        return $context;
    }
}