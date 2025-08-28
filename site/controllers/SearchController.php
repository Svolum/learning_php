<?php
// класс контроллер, для поддержки какого-то поиска с множеством условий

class SearchController extends BaseOilCompsTwigController {
    public $template = "search.twig";
    public $title = "поиск?";

    public function getContext(): array{
        $context = parent::getContext();


        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $info = isset($_GET['info']) ? $_GET['info'] : '';

$sql = <<<EOL
SELECT id, title 
FROM oil_comps 
WHERE type = :my_type 
  AND (:my_title = '' OR title LIKE CONCAT('%', :my_title, '%'))
  AND (:my_info = '' OR info LIKE CONCAT('%', :my_info, '%'));
EOL;
        if ($type == 'all'){
$sql = <<<EOL
SELECT id, title 
FROM oil_comps 
WHERE (:my_title = '' OR title LIKE CONCAT('%', :my_title, '%'))
  AND (:my_info = '' OR info LIKE CONCAT('%', :my_info, '%'));
EOL;
        }
        $query = $this->pdo->prepare($sql);

        $query->bindValue("my_title", $title);
        $query->bindValue("my_info", $info);
        $query->bindValue("my_type", $type);
        $query->execute();

        $context['oil_comps'] = $query->fetchAll();
        
        
        $context['url_group'] = '/oil-company/';


        return $context;
    }
}