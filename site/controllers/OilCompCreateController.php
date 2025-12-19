<?php
// надо поправить код так, чтобы он не позволял создавать если, в поле type пустота или value="new"
class OilCompCreateController extends BaseOilCompsTwigController {
    public $template = "oil_company_create.twig";

    public function get(array $context){
        echo $_SERVER['REQUEST_METHOD'];
        parent::get($context);
    }
    public function post(array $context){
        $title =        trim($_POST['title']);
        $description =  trim($_POST['description']);
        $type =         trim($_POST['type']);
        $info =         trim($_POST['info']);

        $tmp_name = $_FILES['image']['tmp_name'];
        $name =  $_FILES['image']['name'];
        move_uploaded_file($tmp_name, "../public/media/$name");
        $image_url = "/media/$name";

        if (empty($title) || empty($description) || empty($type) || empty($info) || $type === "new") {
            $context['message'] = 'Поля не должны быть пустыми!';
            $this->get($context);
        }else {
            $sql = <<<EOL
INSERT INTO oil_comps(title, description, type, info, image)
VALUES(:title, :description, :type, :info, :image_url)
EOL;

            // подготавливаем запрос к БД
            $query = $this->pdo->prepare($sql);
            // привязываем параметры
            $query->bindValue("title", $title);
            $query->bindValue("description", $description);
            $query->bindValue("type", $type);
            $query->bindValue("info", $info);
            $query->bindValue("image_url", $image_url);

            // выполняем запрос
            $query->execute();

            $context['message'] = 'Вы успешно создали объект';
            $context['id'] = $this->pdo->lastInsertId();

            $this->get($context);
        }
    }
}