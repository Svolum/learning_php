<?php
// класс для подготовки страницы чтения непосредственно самой книги
class BookReadController extends TwigBaseController {
    public $template = "book_read.twig";
    public $title = "READ BOOK";
    
    public function getContext(): array
    {
        $context = parent::getContext();

        return $context;
    }
}