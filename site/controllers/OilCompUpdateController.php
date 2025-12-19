<?php

class OilCompUpdateController extends BaseOilCompsTwigController {
    public $template = "oil_company_update.twig";
    public $title = "Обновление информации об нефтяной компании";

    public function get(array $context){
        $id = $this->params['id'];

        $sql = "SELECT * FROM oil_comps WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        $context['oil_comp'] = $data;

        parent::get($context);
    }

    public function post(array $context){
        $title =        trim($_POST['title']);
        $description =  trim($_POST['description']);
        $type =         trim($_POST['type']);
        $info =         trim($_POST['info']);
        $id =           $this->params['id'];

        if (empty($title) || empty($description) || empty($type) || empty($info) || $type === "new") {
            $context['message'] = 'Поля не должны быть пустыми!';
            $this->get($context);
        }else {
            $sql = <<<EOL
UPDATE oil_comps
SET title = :title,
    description = :description,
    type = :type,
    info = :info
WHERE id = :id

EOL;

            // подготавливаем запрос к БД
            $query = $this->pdo->prepare($sql);
            // привязываем параметры
            $query->bindValue("title", $title);
            $query->bindValue("description", $description);
            $query->bindValue("type", $type);
            $query->bindValue("info", $info);
            $query->bindValue("id", $id);

            // выполняем запрос
            $query->execute();

            $context['message'] = 'Вы успешно обновили объект';
            $context['id'] = $id;

            $this->get($context);
        }
    }
}