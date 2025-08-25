<?php
// класс контроллер, для отображения страницы конкретно нефтяной компании
class BaseOilTypesTwigController extends TwigBaseController {
    public function getContext(): array
    {
        $context = parent::getContext();

        // создаем запрос к БД
        $query = $this->pdo->query("SELECT DISTINCT type FROM oil_comps ORDER BY 1");
        // стягиваем данные и создаем глобальную переменную в $twig, которая будет достпна из любого шаблона
        $context['types'] = $query->fetchAll();

        return $context;
    }
}