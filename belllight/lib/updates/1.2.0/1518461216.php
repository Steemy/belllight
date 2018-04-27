<?php

/**
 * Обновление от 2018-02-18
 *
 * @author Steemy, created by 18.02.2018
 * @link http://steemy.ru/
 */

// Delete old files
$files = array(
    wa()->getAppPath("plugins/belllight/js/jmaskedinput.js", "shop"),
    wa()->getAppPath("plugins/belllight/templates/actions/Bellight.html", "shop"),
);

try {
    foreach ($files as $file) {
        if (file_exists($file)) {
            waFiles::delete($file, true);
        }
    }
} catch (Exception $e) {

}