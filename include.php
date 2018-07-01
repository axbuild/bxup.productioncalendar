<?php

use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

Loader::registerAutoLoadClasses(
	'bxup.productioncalendar', 
	[
		'BxUp\ProductionCalendar\DataGovRu' => 'lib/DataGovRu.php',
		'BxUp\ProductionCalendar\Params' => 'lib/Params.php',
		'BxUp\ProductionCalendar\Table' => 'lib/Table.php',
		'BxUp\ProductionCalendar' => 'lib/ProductionCalendar.php',
	]
);

EventManager::getInstance()->addEventHandler('main', 'OnAfterUserAdd', function(){
	// do something
});
