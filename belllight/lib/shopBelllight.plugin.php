<?php

/**
 * Класс плагина
 *
 * @author Steemy, created by 11.02.2018
 * @link http://steemy.ru/
 */

class shopBelllightPlugin extends shopPlugin
{
    /**
     * Вывод в пункта меню в бекенде магазина
     * @return array|string
     */
    public function backendMenu()
    {
        if(!$this->getSettings('status'))
            return '';

        $model = new shopBelllightListPluginModel();
        $count = $model->count();
        $countSTR = '';
        if($count)
            $countSTR = '<sup class="red" style="display:inline">'.$count.'</sup>';

        $html = '<li ' . (waRequest::get('plugin') == $this->id ? 'class="selected"' : 'class="no-tab"') . '>
                    <a href="?plugin=belllight">
                        Звонок (lite)
                        ' . $countSTR . '
                    </a>
                </li>';

        return array(
            'core_li' => $html
        );
    }

    /**
     * Вывод самой формы
     * @return string
     */
    static public function display()
    {
        $pluginSetting = shopBelllightPluginSettings::getInstance();
        $settings = $pluginSetting->getSettings();

        if(!$settings['status'])
            return '';

        $url = wa()->getRouteUrl('shop/frontend');
        $settings['url'] = $url;

        // antispam
        $strEnCode = md5('string antispam 545');
        $arrASCII = array() ;
        for ($i = 0; $i < strlen($strEnCode); $i++) $arrASCII[] = ord($strEnCode[$i]);
        $arrASCIIEncode = implode(',', $arrASCII);

        $view = wa()->getView();
        $view->assign('settings', $settings);
        $view->assign('belllightAntispam', $arrASCIIEncode);

        $FrontendDisplay = wa()->getDataPath('plugins/belllight/templates/FrontendDisplay.html', true, 'shop');

        return $view->fetch($FrontendDisplay);
    }

    /**
     * Вывод css и js
     * @return string
     */
    static public function head()
    {
        $pluginSetting = shopBelllightPluginSettings::getInstance();
        $settings = $pluginSetting->getSettings();

        if(!$settings['status'])
            return '';

        $html = '';

        $waUrlData = wa()->getDataUrl('plugins/' . $pluginSetting->namePlugin . '/', true, 'shop');

        if(!$settings['style_enable']) $html .= '
    <link href="' . $waUrlData . 'css/' . $pluginSetting->namePlugin . '.css" rel="stylesheet" />';

        if(!$settings['script_enable']) $html .= '
    <script src="' . $waUrlData . 'js/' . $pluginSetting->namePlugin . '.js"></script>';

        return $html;
    }

}