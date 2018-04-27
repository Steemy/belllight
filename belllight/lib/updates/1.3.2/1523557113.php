<?php

/**
 * Обновление от 2018-04-12
 *
 * @author Steemy, created by 04.04.2018
 * @link http://steemy.ru/
 */

$file = wa()->getAppPath("plugins/belllight/templates/actions/backend/Bellight.html", "shop");

try {
    if (file_exists($file)) {
        waFiles::delete($file, true);
    }
} catch (Exception $e) {

}