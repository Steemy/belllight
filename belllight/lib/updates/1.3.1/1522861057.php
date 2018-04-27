<?php

/**
 * Обновление от 2018-04-04
 *
 * @author Steemy, created by 04.04.2018
 * @link http://steemy.ru/
 */

// Move files
$templOld = wa()->getDataPath("plugins/belllight/FrontendDisplay.html", "shop");
$templNew = wa()->getDataPath("plugins/belllight/templates/FrontendDisplay.html", "shop");

$templNewPath = wa()->getDataPath("plugins/belllight/templates/FrontendDisplay.html", "shop");

if(file_exists($templOld) && !file_exists($templNew))
    waFiles::move($templOld, $templNewPath);