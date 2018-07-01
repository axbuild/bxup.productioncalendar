<?php
namespace BxUp;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException; 

Loc::loadMessages(__FILE__);

defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'bxup.crmhookclient');

Class CRMHookClient {
    
    protected $_CRM_HOOK_SECRET;
    protected $_PROFILE;
	protected $_DATA;
	
	function __construct ()
	{
		$this->_CRM_HOOK_SECRET = Option::get(ADMIN_MODULE_NAME, "crm_hook_secret");
	}
    
    public function setHook ($hook)
    {
        $this->_CRM_HOOK_SECRET = $hook;
        return $this;        
    }

    public function setProfile ($profile)
    {
        $this->_PROFILE = $profile;
        return $this;
    }

    public function setData ($data)
    {
        $this->_DATA = $data;
        return $this;
	}
	
	private function _buildURL()
	{
		return str_replace("profile", $this->_PROFILE, $this->_CRM_HOOK_SECRET);
	}

	private function _getData()
	{
		return http_build_query($this->_DATA);
	}

    public function call ($debug = false)
    {
		if(empty($this->_CRM_HOOK_SECRET)) throw new SystemException(Loc::getMessage("EXCEPTION_HOOK"));
		if(empty($this->_PROFILE)) throw new SystemException(Loc::getMessage("EXCEPTION_PROFILE"));
		if(empty($this->_DATA))  throw new SystemException(Loc::getMessage("EXCEPTION_DATA"));
		if(!function_exists('curl_init') ||
			!function_exists('curl_setopt_array')) 
				throw new SystemException(Loc::getMessage("EXCEPTION_CURL"));

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POST => true,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $this->_buildURL(),
			CURLOPT_POSTFIELDS => $this->_getData(),
		]);

		$result = curl_exec($curl);
		curl_close($curl);
		return json_decode($result, true);
    }
}
?>