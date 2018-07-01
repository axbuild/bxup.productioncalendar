<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'bxup.crmhookclient');

if (!$USER->isAdmin()) {
		$APPLICATION->authForm('Nope');
}

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();
$hook = $request->getPost('crm_hook_secret');
$profile = $request->getPost('profile');

Loc::loadMessages($context->getServer()->getDocumentRoot()."/bitrix/modules/main/options.php");
Loc::loadMessages(__FILE__);

$tabControl = new CAdminTabControl("tabControl", 
	[
		[
			"DIV" => "edit1",
			"TAB" => Loc::getMessage("MAIN_TAB_SET"),
			"TITLE" => Loc::getMessage("MAIN_TAB_TITLE_SET"),
		]
	]
);

if ((!empty($save) || !empty($restore)) && $request->isPost() && check_bitrix_sessid()) 
{
		if (!empty($restore)) 
		{
			Option::delete(ADMIN_MODULE_NAME);
			CAdminMessage::showMessage(
				[
					"MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_RESTORED"),
					"TYPE" => "OK",
				]
			);
		} 
		elseif ($hook)
		{
			Option::set(ADMIN_MODULE_NAME, "crm_hook_secret", $hook);
			CAdminMessage::showMessage(
				[
					"MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_SAVED"),
					"TYPE" => "OK",
				]
			);
		} 
		else 
		{
			CAdminMessage::showMessage(
				Loc::getMessage("REFERENCES_INVALID_VALUE")
			);
		}
}

$tabControl->begin();
?>

<form 
	method="post" 
	action="<?=sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($mid), LANGUAGE_ID)?>">
		<?php
		echo bitrix_sessid_post();
		$tabControl->beginNextTab();
		?>
		<tr>
			<td width="40%">
				<label for="crm_hook_secret"><?=Loc::getMessage("REFERENCES_HOOK") ?>:</label>
			<td width="60%">
				<input type="text"
					size="50"
					maxlength="300"
					name="crm_hook_secret"
					value="<?=Option::get(ADMIN_MODULE_NAME, "crm_hook_secret", '');?>"
					/>
			</td>
		</tr>

		<?php $tabControl->buttons();?>

		<input type="submit"
			name="save"
			value="<?=Loc::getMessage("MAIN_SAVE") ?>"
			title="<?=Loc::getMessage("MAIN_OPT_SAVE_TITLE") ?>"
			class="adm-btn-save"
			/>
		<input type="submit"
			name="restore"
			title="<?=Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>"
			onclick="return confirm('<?= AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING")) ?>')"
			value="<?=Loc::getMessage("MAIN_RESTORE_DEFAULTS") ?>"
			/>
		<?php $tabControl->end();?>
</form>
