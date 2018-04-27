<?php

/**
 * Класс получения настроек бекенд
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginSettingsAction extends waViewAction
{
    public function execute()
    {
        $pluginSetting = shopBelllightPluginSettings::getInstance();

        $settings = $pluginSetting->getSettings();
        $pluginSetting->getSettingsCheck($settings);
        $pluginSetting->addFileSetting($settings);

        $this->view->assign("settings", $settings);
    }
}
