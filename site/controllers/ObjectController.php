<?php
// класс контроллер, для организации страницы, отвечающей за отображение какой-то карточки (в данном случае нефтяной компании) 
// "/oil-company/{id}" и еще подхватывает какие-то доп адреса "/oil-company/{id}/{image|info}"
require '../vendor/autoload.php';


class ObjectController extends BaseOilTypesTwigController {
    public $context = [];
    public function __construct()
    {
        //      TEMPLATE
        $this->template = "__object.twig";
        if (isset($_GET['show'])) {
            if ($_GET['show'] == 'image') {
                $this->template = "base_image.twig";
            }
            else if ($_GET['show'] == 'info') {
                $this->template = "base_info.twig";
            }
        }
    }
    public function getContext(): array {
        $context = parent::getContext();

        $context['url'] = $_SERVER["REQUEST_URI"];
        $context['base_url'] = $this->params[0];

        
        //      SERTAIN COMPANY
        // $query = $this->pdo->query("SELECT * FROM oil_comps WHERE id = " . $this->params['id']);
        $query = $this->pdo->prepare("SELECT * FROM oil_comps WHERE id = :my_id");
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        $context['company'] = $query->fetch();


        //      MURKDOWN PARSER
        $markdown = $context['company']['info'];
        $parsedown = new Parsedown();
        $context['company']['info'] = $parsedown->text($markdown);

        // INSERT oil_comps TO context FOR __layout.twig
        $query = $this->pdo->query("SELECT id, title FROM oil_comps");
        $context['oil_comps'] = $query->fetchAll();
        

        // echo "<pre>";
        // print_r($context);
        // echo "</pre>";

        return $context;
    }
}