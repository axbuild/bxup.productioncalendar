<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$aMenu = array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 400,
        'text' => "название",
        'title' => "Название2",
        'url' => 'bxup_productioncalendar_index.php',
        'items_id' => 'menu_references',
        'items' => array(
            array(
                'text' => "Текст",
                'url' => 'bxup_productioncalendar_index.php?param1=paramval&lang='.LANGUAGE_ID,
                'more_url' => array('bxup_productioncalendar_index.php?param1=paramval&lang='.LANGUAGE_ID),
                'title' => "текст",
            ),
        ),
    ),
);

return $aMenu;
