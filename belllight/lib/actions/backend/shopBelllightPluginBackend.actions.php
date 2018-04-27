<?php

/**
 * Класс бекенд, показывающий списко заявок
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginBackendActions extends waViewActions
{
    /**
     * @var STATUS_TITLE_BACKEND - статусы в бекенде
     */
    static $_STATUS_TITLE_BACKEND = array(
        'active' => 'Все заказы звонков',
        'delete' => 'Удаленные заказы звонков',
        'export' => 'Экспорт в CSV',
    );

    public function defaultAction()
    {
        $this->setLayout(new shopBelllightPluginBackendLayout());
        $this->setTemplate('plugins/belllight/templates/actions/backend/Backendlist.html');

        /*
         * - Проверка активной вкладки и задание title
         */
        $status = waRequest::get("status", "active");

        $statusTitle = self::$_STATUS_TITLE_BACKEND;

        if(!empty($statusTitle[$status]))
            $title = $statusTitle[$status];


        /*
         * - Количество звонков по статусу
         */
        $model = new shopBelllightListPluginModel();

        $countListStatus = array(
            'active' => $model->count('active'),
            'delete' => $model->count('delete'),
        );

        if($status != 'export')
        {
            /*
             * - Получения списка звонков
             */
            $limit = 15;

            $page = waRequest::get('page', 1, 'int');
            $page = $page > 1 ? $page : 1;

            $offset = ($page - 1) * $limit;

            $list = $model->getList($offset, $limit, $status);
            $pagesCount = ceil((float) $countListStatus[$status] / $limit);

            $this->view->assign('pagesCount', $pagesCount);

            /*
             * - Обновляем статус с new на active при первом заходе в активные заявки
             */
            if($status == 'active')
                $model->updateStatus();
        }
        else
        {
            /*
             * - Экспорт в csv
             */

            $list = $model->getList(0, 99999, 'all');
            $statusExport = waRequest::post("status_export");

            if($statusExport)
            {
                $titles = array("id", "Имя", "Телефон", "Дата", "Ссылка", "Комментарий", "Статус");
                $shopPluginExport = new shopBelllightPluginExport();
                $shopPluginExport->arrayToCsv($list, $titles);
            }
        }

        $this->view->assign('list', $list);
        $this->view->assign('countListStatus', $countListStatus);
        $this->view->assign('status', $status);
        $this->view->assign('title', $title);
        
        $this->getResponse()->setTitle($title.'. Обратный звонок (lite)');
    }

}