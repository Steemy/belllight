<?php

/**
 * Класс сохранения настроек
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginSettingsSaveController extends waJsonController
{
    public function execute()
    {
        $pluginSetting = shopBelllightPluginSettings::getInstance();
        $namePlugin = $pluginSetting->namePlugin;

        $settings = waRequest::post('shop_plugins', array());
        $pluginSetting->getSettingsCheck($settings);

        try {
            $settingsFile = waRequest::post('shop_plugins_file', array());
            $pluginSetting->saveFileSettings($settingsFile);

            $plugin = waSystem::getInstance()->getPlugin($namePlugin);
            $plugin->saveSettings($settings);
        } catch (Exception $e) {
            $this->errors['messages'][] = 'Не удается сохранить поля настроек';
        }
    }
}