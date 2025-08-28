<?php
// надо поправить код так, чтобы он не позволял создавать если, в поле type пустота или value="new"
class OilCompCreateController extends BaseOilCompsTwigController {
    public $template = "oil_company_create.twig";

    public function get(){
        echo $_SERVER['REQUEST_METHOD'];
        parent::get();
    }
    public function post(){
        $this->get();
    }
}