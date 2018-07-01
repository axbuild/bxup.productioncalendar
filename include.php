<?php defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

Bitrix\Main\Loader::registerAutoLoadClasses(
	'bxup.crmhookclient', 
	[
		'BxUp\CRMHookClient\Table' => 'lib/CRMHookTable.php',
		'BxUp\CRMHookClient' => 'lib/CRMHookClient.php',
	]
);