<?php

/**
 * Обновление от 2018-02-11
 *
 * @author Steemy, created by 11.02.2018
 * @link http://steemy.ru/
 */

$model = new waModel();

try
{
    $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `shop_belllight_list` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `phone` varchar(255) NOT NULL,
            `data` varchar(255) NOT NULL,
            `link` varchar(255) NOT NULL,
            `text` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
SQL;

    $model->exec($sql);
}
catch (waDbException $e)
{
    
}