<?php
// класс для подготовки страницы со списком книг
class BookListController extends TwigBaseController {
    public $template = "book_list.twig";
    public $title = "BOOK LIST";

    public function getContext(): array {
        $context = parent::getContext();


        $query = $this->pdo->query("SELECT id, title, description FROM books");

        $context['books_list'] = $query->fetchAll();
        // echo "<pre>";
        // print_r($context['books_list']);
        // echo "</pre>";


        $context['url_group'] = '/book/';
        
        return $context;
    }
}