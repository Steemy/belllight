<?php

/**
 * Обзательные настройки
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

return array(
    'app.shop' => array(
        'strict' => true,
        'version' => '>=7.0',
    ),
    'php' => array(
        'strict' => true,
        'version' => '>=5.2',
    ),
    'phpini.max_exection_time'=>array(
        'name'=>'Максимальное время исполнения PHP-скриптов',
        'description'=>'',
        'strict'=>false,
        'value'=>'>60',
    ),
    'app.installer' => array(
        'strict' => true,
        'version' => '>=1.7.6',
    )
);
