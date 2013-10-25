<?
IncludeModuleLangFile(__FILE__);
Class yeti_mashajs extends CModule
{
	const MODULE_ID = 'yeti.mashajs';
	var $MODULE_ID = 'yeti.mashajs'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("yeti.mashajs_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("yeti.mashajs_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("yeti.mashajs_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("yeti.mashajs_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
		RegisterModuleDependences("main", "OnProlog", self::MODULE_ID, 'CYetiMashaJS', 'OnProlog');
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		UnRegisterModuleDependences("main", "OnProlog", self::MODULE_ID, 'CYetiMashaJS', 'OnProlog');
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".self::MODULE_ID."/install/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js", true, true);
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/js/".self::MODULE_ID);
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
