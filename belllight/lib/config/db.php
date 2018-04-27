<?php

/**
 * Установка базы данных
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

return array(
    'shop_belllight_list' => array(
        'id'     => array('int', 11, 'null' => 0, 'autoincrement' => 1),
        'name'   => array('varchar', 255, 'null' => 0),
        'phone'  => array('varchar', 255, 'null' => 0),
        'data'   => array('varchar', 255, 'null' => 0),
        'link'   => array('varchar', 255, 'null' => 0),
        'text'   => array('text', 'null' => 0),
        'status' => array('varchar', 255, 'null' => 0),
        ':keys'  => array(
            'PRIMARY' => 'id',
        ),
    ),
);