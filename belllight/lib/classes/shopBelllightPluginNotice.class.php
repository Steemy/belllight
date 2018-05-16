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
        if(!$this->settings['telegram'])
            return;

        $chatId = $this->settings['telegram_chat_id'];
        $token = $this->settings['telegram_token'];

        if($chatId && $token)
        {
            $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&parse_mode=html&text={$this->getMessageTelegram($message)}";
            $data = file_get_contents($url);

            if(!$data) {
                waLog::log('Ошибка отправки телеграм! Сервис телеграм не доступен', 'shop/telegram.error.log');
            }
        }
        else
        {
            waLog::log('Не заданы настройки токена или чат id!', 'shop/telegram.error.log');
        }

    }

    /**
     * Отправка сообщения в вконтакте
     * @param $message
     */
    public function notifyVk($message)
    {
        if(!$this->settings['vk'])
            return;

        $url = 'https://api.vk.com/method/messages.send';
        $id = $this->settings['vk_id'];
        $token = $this->settings['vk_token'];

        if($id && $token)
        {
            $params = array(
                'user_id' => $id,
                'message' => $this->getMessageVk($message),
                'access_token' => $token,
                'v' => '5.73',
            );

            $result = file_get_contents($url, false, stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($params)
                )
            )));

            if(empty($result)) {
                waLog::log('Ошибка отправки vk! Сервис vk не доступен', 'shop/vk.error.log');
            }
        }
        else
        {
            waLog::log('Не заданы настройки токена или чат id!', 'shop/vk.error.log');
        }
    }

    /**
     * Вернет сформированное сообщение для телеграм
     * @param int $message
     * @return string
     */
    private function getMessageTelegram($message)
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

    /**
     * Вернет сформированное сообщение для вконтакте
     * @param int $message
     * @return string
     */
    private function getMessageVk($message)
    {
        $nameSite = wa('shop')->getConfig()->getGeneralSettings('name');

        $messTelegram = 'Заказ обратного звонка с сайта - ' . $nameSite . " \n";
        $messTelegram .= 'Имя: ' . $message['name'] . " \n";
        $messTelegram .= 'Телефон: ' . $message['phone'] . " \n";

        if ($message['text'])
            $messTelegram .= 'Сообщение: ' . $message['text'] . " \n";

        $messTelegram .= 'Со страницы: ' . $message['link'];


        return $messTelegram;
    }
}