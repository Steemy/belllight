<?php

/**
 * Класс уведомления в телеграм
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginNotice
{
    private $settings;

    public function __construct($settings)
    {
        $this->settings = shopBelllightPluginSettings::getInstance()->getSettings();
    }

    /**
     * Отправка сообщения в телеграм
     * @param string $message
     */
    public function notifyTelegram($message)
    {
        if($this->settings['telegram'])
        {
            $chatId = $this->settings['telegram_chat_id'];
            $token = $this->settings['telegram_token'];

            if ($chatId && $token)
            {
                $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&parse_mode=html&text={$this->getMessageTelegram($message)}";
                $data = file_get_contents($url);

                if (!$data) {
                    waLog::log('Ошибка отправки телеграм!', 'shop/telegram.error.log');
                }
            }
            else
            {
                waLog::log('Не заданы настройки токена ичат id!', 'shop/telegram.error.log');
            }
        }
    }

    /**
     * Вернет сформированное сообщение для телеграм
     * @param int $message
     * @return string
     */
    protected function getMessageTelegram($message)
    {
        $nameSite = wa('shop')->getConfig()->getGeneralSettings('name');

        $messTelegram = urlencode('<b>Заказ обратного звонка с сайта - ' . $nameSite . '</b>') . '%0A';
        $messTelegram .= urlencode('<b>Имя:</b> ') . $message['name'] . '%0A';
        $messTelegram .= urlencode('<b>Телефон:</b> ') . $message['phone'] . '%0A';

        if ($message['text'])
            $messTelegram .= urlencode('<b>Сообщение:</b> ') . $message['text'] . '%0A';

        $messTelegram .= urlencode('<b>Со страницы:</b> ') . $message['link'] . '%0A';


        return $messTelegram;
    }
}