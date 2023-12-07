<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @global CMain $APPLICATION
 */

?>
<?php $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"vertical.1", 
	array(
		"MAX_LEVEL" => "2",
		"COMPONENT_TEMPLATE" => "vertical.1",
		"ROOT_MENU_TYPE" => "left",
		"IBLOCK_TYPE" => "",
		"IBLOCK_ID" => "",
		"MAIN_VIEW" => "simple",
		"MAIN_LINK_SHOW" => "N",
		"VIEW" => "simple.1",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
); ?>