<?php

/**
 * Класс констант плагина
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginConst
{
    /**
     * Название плагина
     * @return string
     */
    public function getNamePlugin()
    {
        return 'belllight';
    }

    /**
     * Возвращает массив настроек по умолчанию
     * @return array
     */
    public function getSettingsDefault()
    {
        return array(
            'status'           => 0,
            'selector'         => '',
            'email_sender'     => '',
            'email_recipient'  => '',
            'mess'             => 0,
            'mask'             => 0,
            'mask_view'        => '+7 (999) 999-99-99',
            'thank'            => 'Спасибо за оставленную заявку!<br />Наш оператор свяжется с вами в ближайшее время',
            'policy_checkbox'  => 0,
            'politika'         => 'Нажимая на кнопку, вы даете согласие на обработку своих<br />персональных данных и соглашаетесь с <a href="#ссылка на политику" target="_blank">политикой конфиденциальности</a>',
            'telegram'         => 0,
            'telegram_chat_id' => '',
            'telegram_token'   => '',
            'yandex_counter'   => '',
            'yandex_click'     => '',
            'yandex_send'      => '',
            'style_enable'     => 0,
            'script_enable'    => 0,
            'button_a'         => 0,
            'button_a_mobile'  => 0,
        );
    }

    /**
     * файлы css, js, templ которые можно редактировать и сохранять
     * @return array
     */
    public function getFileForEditAndSave()
    {
        return array(
            'style'  => 'css/' . self::getNamePlugin() . '.css',
            'script' => 'js/' . self::getNamePlugin() . '.js',
            'templ'  => 'templates/FrontendDisplay.html',
        );
    }
}