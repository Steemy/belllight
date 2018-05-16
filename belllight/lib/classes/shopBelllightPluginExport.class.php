<?php

/**
 * Класс экспорта в csv
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginExport
{
    private $namePlugin;

    public function __construct()
    {
        $this->namePlugin = shopBelllightPluginSettings::getInstance()->namePlugin;
    }

    public function execute()
    {
        $this->exportCSV();

        $view = wa()->getView();
        $view->assign('encoding', $this->getEncList());
    }

    /**
     * Экспорт заказов в CSV
     */
    private function exportCSV() {
        $pluginExport = waRequest::post("plugin_export");

        if(!$pluginExport)
            return;

        $encoding = waRequest::post('encoding', 'UTF-8', waRequest::TYPE_STRING_TRIM);
        $delimiter = waRequest::post('delimiter', ';', waRequest::TYPE_STRING_TRIM);
        $status = waRequest::post('status', 'all', waRequest::TYPE_STRING_TRIM);
        $count = waRequest::post('count', '1000', waRequest::TYPE_STRING_TRIM);

        if($delimiter == 'tab')
            $delimiter = '\t';

        /**
         * Получаем список заказов
         */
        $model = new shopBelllightListPluginModel();
        $list = $model->getList(0, $count, $status);

        $path = wa()->getConfig()->getPath('cache').'/'.$this->namePlugin.'/export_'.$this->namePlugin.'.csv';
        waFiles::delete($path);

        $writer = new shopCsvWriter($path,$delimiter,$encoding);
        $writer->setMap($this->getMapFields());

        foreach($list as $val) {
            $writeAdd = array();

            $writeAdd['id'] = $val['id'];
            $writeAdd['name'] = $val['name'];
            $writeAdd['phone'] = $val['phone'];
            $writeAdd['data'] = $val['data'];
            $writeAdd['link'] = $val['link'];
            $writeAdd['text'] = $val['text'];
            $writeAdd['status'] = $val['status'];

            $writer->write($writeAdd);
        }

        waFiles::readFile($path, "export_".$this->namePlugin."-".date('d.m.Y').".csv");
    }

    /**
     * Возвращает массив полей для CSV
     *
     * @return array
     */
    private function getMapFields()
    {
        $fields = array(
            "id" => "Номер заявки",
            "name" => "Имя",
            "phone" => "Телефон",
            "data" => "Дата",
            "link" => "Ссылка",
            "text" => "Комментарий",
            "status" => "Статус",
        );

        return $fields;
    }

    /**
     * Возваращает массив кодировок
     *
     * @return array
     */
    private function getEncList()
    {
        $encoding = array_diff(mb_list_encodings(), array(
            'pass',
            'wchar',
            'byte2be',
            'byte2le',
            'byte4be',
            'byte4le',
            'BASE64',
            'UUENCODE',
            'HTML-ENTITIES',
            'Quoted-Printable',
            '7bit',
            '8bit',
            'auto',
        ));

        $popular = array_intersect(array('UTF-8', 'Windows-1251', 'ISO-8859-1'), $encoding);
        asort($encoding);

        return array_unique(array_merge($popular, $encoding));
    }
}