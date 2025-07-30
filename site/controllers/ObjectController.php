<?php
require '../vendor/autoload.php';


class ObjectController extends TwigBaseController {
    public $context = [];
    public $id = null;
    public function __construct()
    {
        $url = $_SERVER['REQUEST_URI'];
        
        // ID
        preg_match("#^/(\d+)#", $url, $match);
        $this->id = $match[1];
        $this->context['base_url'] = "/$this->id";

        // TEMPLATE
        $this->template = "__object.twig";
        if (preg_match("#/image$#", $url)) {
            // print_r("image");
            $this->template = "base_image.twig";
        }
        if (preg_match("#/info$#", $url)) {
            // print_r("info");
            $this->template = "base_info.twig";
        }
    }
    public function getContext(): array {
        $context = parent::getContext();

        $context = array_merge($context, $this->context);

        return $context;
    }
    public function addContext($field_name, $field_value) {
        $this->context[$field_name] = $field_value;
    }
    public function pullContextFromDB(){
        $query = $this->pdo->query("SELECT * FROM oil_comps WHERE id = $this->id");
        $this->context['company'] = $query->fetchObject();

        //      MURKDOWN PARSER
        $markdown = $this->context['company']->info;
        $parsedown = new Parsedown();
        $this->context['company']->info = $parsedown->text($markdown);

        // INSERT oil_comps TO context FOR __layout.twig
        $query = $this->pdo->query("SELECT id, title FROM oil_comps");
        $this->context['oil_comps'] = $query->fetchAll();
    }
}