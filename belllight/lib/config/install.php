<?php

/**
 * Установка начальных значений
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

/**
 * Получаем настройки по умолчанию
 */
$pluginSetting = new shopBelllightPluginSettings();

$settings = array();
$pluginSetting->getSettingsCheck($settings);
$namePlugin = $pluginSetting->namePlugin;

/**
 * Устанавливаем настройки для плагина по умолчанию
 */
$appSettingsModel = new waAppSettingsModel();

foreach($settings as $key=>$value) {
    $appSettingsModel->set(array('shop', $namePlugin), $key, $value);
}