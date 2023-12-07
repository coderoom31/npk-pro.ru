<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Схемы Mixmate");
?><div class="schemes">
<?$APPLICATION->IncludeComponent(
	"intec.universe:main.gallery", 
	"template.2", 
	array(
		"CACHE_TIME" => "0",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "template.2",
		"DELIMITERS" => "Y",
		"DESCRIPTION_SHOW" => "N",
		"ELEMENTS_COUNT" => "",
		"FOOTER_BUTTON_SHOW" => "N",
		"FOOTER_POSITION" => "left",
		"FOOTER_SHOW" => "Y",
		"HEADER_SHOW" => "N",
		"IBLOCK_ID" => "37",
		"IBLOCK_TYPE" => "content",
		"LAZYLOAD_USE" => "N",
		"LINE_COUNT" => "6",
		"LIST_PAGE_URL" => "",
		"ORDER_BY" => "ASC",
		"SECTIONS" => array(
			0 => "",
			1 => "",
		),
		"SETTINGS_USE" => "N",
		"SORT_BY" => "SORT",
		"WIDE" => "Y"
	),
	false
);?>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>