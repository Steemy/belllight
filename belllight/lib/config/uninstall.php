<?php

/**
 * Удаление
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */

$public = wa()->getDataPath('plugins/belllight/', 'shop');
waFiles::delete($public, true);