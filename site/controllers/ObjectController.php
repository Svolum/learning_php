<?php
require_once 'TwigBaseController.php';

class ObjectController extends TwigBaseController {
    public $context = [];

    public function __construct($twig, $template, $context) {
        parent::__construct($twig);

        $this->template = $template;
        $this->context = $context;
    }
    public function getContext(): array {
        $context = parent::getContext();

        $context = array_merge($context, $this->context);

        return $context;
    }
}