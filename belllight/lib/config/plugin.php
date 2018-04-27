<?php

/**
 * Конфиг плагина
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */
 
return array(
    'name' => 'Обратный звонок (lite)',
    'description' => 'Заказать обратный звонок',
    'version'=>'1.3.3',
    'vendor' => '989788',
    'img' => 'img/icon.png',
    'shop_settings' => true,
    'frontend' => true,
    'custom_settings' => true,
    'icons' => array(
        16 => 'img/cart.png',
    ),
    'handlers' => array(
        'backend_menu' => 'backendMenu',
    ),
);