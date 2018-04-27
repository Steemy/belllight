<?php

/**
 * Класс бекенд, для смены статуса заявок
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginBackendDeleteController extends waJsonController
{

    public function execute()
    {
        $id = (int) waRequest::post('id', 0, 'int');

        $model = new shopBelllightListPluginModel();
        
        if($id)
        {
            $model->updateStatusId($id);

            $this->response = array(
                'status' => true,
                'body'  => 'Удаление прошло успешно!'
            );
        }
        else
        {
            $this->response = array(
                'status' => false,
                'error'  => 'Не удалось удалить!'
            );
        }
    }
    
}