<?php

/**
 * Класс отправки почты на фронтенд
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

class shopBelllightPluginFrontendBelllightController extends waJsonController
{
    public function execute()
    {
        /**
         * Настройки
         */
        $pluginSetting = shopBelllightPluginSettings::getInstance();
        $settings = $pluginSetting->getSettingsCheckStatus();
        $pluginSetting->getSettingsCheck($settings);

        $emailSender = $settings['email_sender'] ? $settings['email_sender'] : wa()->getSetting('email', '', 'shop');
        $emailRecipient = $settings['email_recipient'] ? $settings['email_recipient'] : wa()->getSetting('email', '', 'shop');

        $name  = htmlspecialchars(trim(waRequest::post('bellLight__name')));
        $phone = htmlspecialchars(trim(waRequest::post('bellLight__phone')));
        $mess  = htmlspecialchars(trim(waRequest::post('bellLight__mess')));
        $link  = htmlspecialchars(trim(waRequest::post('bellLight__link')));
        $belllightAntispam = waRequest::post('bellLight__antispam');

        // antispam
        $strEnCode = md5('string antispam 545');
        $arrASCII = array() ;
        for ($i = 0; $i < strlen($strEnCode); $i++) $arrASCII[] = ord($strEnCode[$i]);
        $arrASCIIEncode = implode(',', $arrASCII);

        // politika checkbox
        $policy_checkbox = true;
        if($settings['policy_checkbox'])
        {
            $policy_checkbox = htmlspecialchars(trim(waRequest::post('policy_checkbox')));
        }

        if(!empty($name) && !empty($phone) && $arrASCIIEncode == $belllightAntispam && !empty($policy_checkbox))
        {
            $nameSite = wa('shop')->getConfig()->getGeneralSettings('name');

            $subject = $settings['theme'];

            $view = wa()->getView();
            $view->assign('nameSite', $nameSite);
            $view->assign('name', $name);
            $view->assign('phone', $phone);
            $view->assign('mess', $mess ? $mess : '');

            $body = $view->fetch('string:' . $settings['templates_email']);

            $mailMessage = new waMailMessage($subject, $body);
            $mailMessage->setFrom($emailSender, $nameSite);
            $mailMessage->setTo($emailRecipient);

            if(!$mailMessage->send())
            {
                $this->response = array(
                    'status' => false,
                    'error'  => 'Ошибка отправления!'
                );
            }
            else
            {
                $this->response = array(
                    'status' => true,
                    'body'  => 'Сообщение отправлено!'
                );
            }

            /*
             * - Добовляем в базу при успешной валидации,
             *   даже если отправка на почту не сработала
             */
            $bell = array(
                'name'   => $name,
                'phone'  => $phone,
                'data'   => date("Y-m-d H:i:s"),
                'link'   => $link,
                'text'   => $mess ? $mess : "-",
                'status' => "new",
            );

            $model = new shopBelllightListPluginModel();
            $model->insert($bell);

            /*
             * - Отправляем сообщение в телеграм и вк при успешной валидации,
             *   даже если отправка на почту не сработала
             */
            $notice = new shopBelllightPluginNotice($settings);
            $notice->notifyTelegram($bell);
            $notice->notifyVk($bell);
        }
        else
        {
            $this->response = array(
                'status' => false,
                'error'  => 'Ошибка валидации!'
            );
        }
    }
}
