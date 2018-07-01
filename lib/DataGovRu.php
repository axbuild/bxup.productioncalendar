<?
namespace BxUp\ProductionCalendar;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException; 

Loc::loadMessages(__FILE__);

defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'bxup.productioncalendar');

class DataGovRu
{
	public function getList ()
	{ 
		try
		{
			$access_token = Option::get(ADMIN_MODULE_NAME, "token", '');

			if(empty($access_token))
				throw new SystemException (Loc::getMessage("EXCEPTION_TOKEN_REQUIRED"));

			$url = "http://data.gov.ru/api/json/dataset/7708660670-proizvcalendar/version/20151123T183036/content/?access_token=${access_token}";
				
			$res = json_decode(file_get_contents($url), true);

			if(is_null($res)) 
				throw new SystemException (Loc::getMessage("EXCEPTION_JDECODE_FAILED"));

			return $res;

		}
		catch (SystemException $e)
		{
			echo $e->getMessage();
		}

	}
}
?>