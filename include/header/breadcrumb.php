<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @global CMain $APPLICATION
 */

$GLOBALS['BreadCrumbIBlockType'] = 'catalogs';
$GLOBALS['BreadCrumbIBlockId'] = '13';

?>
<?php $APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"START_FROM" => "0",
		"PATH" => "",
		"SITE_ID" => "s1"
	),
	false
); ?>