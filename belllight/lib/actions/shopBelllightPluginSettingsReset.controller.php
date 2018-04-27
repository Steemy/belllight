<?php

/**
 * Класс для сброса файлов к оригиналам
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginSettingsResetController extends waJsonController
{

    public function execute()
    {
        $pluginSetting = shopBelllightPluginSettings::getInstance();
        $namePlugin = $pluginSetting->namePlugin;
        $fileForEditAndSave = $pluginSetting->fileForEditAndSave;

        $templ = waRequest::post('templ');

        foreach($fileForEditAndSave as $key=>$value)
        {
            if($templ == $key || $templ == 'templates_all')
            {
                $pathOriginal = wa()->getAppPath('plugins/' . $namePlugin . '/' . $value, 'shop');
                $pathData = wa()->getDataPath('plugins/' . $namePlugin . '/' . $value, 'shop');

                try {
                    $templOriginal = file_get_contents($pathOriginal);
                    file_put_contents($pathData, $templOriginal);
                } catch (Exception $e) {
                    $this->errors['messages'][] = 'Не удается сохранить файлы';
                }
            }
        }

        if($templOriginal)
        {
            $this->response = array(
                'status' => true,
                'templ_original' => $templOriginal
            );
        }
        else
        {
            $this->response = array(
                'status' => true,
                'error' => 'Не загрузился ориганал!'
            );
        }
    }
}