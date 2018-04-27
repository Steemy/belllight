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

    /**
     * @param array $array
     * @param array $titles
     * @return null
     * @throws waException
     */
    public function arrayToCsv(array &$array, $titles)
    {
        if (count($array) == 0)
            return null;

        $path = wa()->getConfig()->getPath('cache').'/'.$this->namePlugin.'/export_'.$this->namePlugin.'.csv';
        waFiles::create($path);

        /**
         * - Преобразование массива в csv
         */
        ob_start();

        $fp = fopen($path, 'w');
        fputcsv($fp, $this->conv($titles), ';');

        foreach ($array as $row)
        {
            fputcsv($fp, $this->conv($row), ';');
        }

        fclose($fp);

        /**
         * - Вывод в бразуер пользователя
         */
        if (file_exists($path) && is_file($path))
            waFiles::readFile($path, 'export_'.$this->namePlugin.'.csv');
        else
            throw new waException("File not found", 404);
    }


    /**
     * Перекодирование
     * @param $array
     * @return array
     */
    private function conv($array)
    {
        foreach ($array as $key => $value)
        {
            $array[$key] = mb_convert_encoding($value, "CP1251", "UTF-8");
        }

        return $array;
    }
}