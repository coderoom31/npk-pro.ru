<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global $APPLICATION
 */

$APPLICATION->SetTitle("Новости");

?>
<?php $APPLICATION->IncludeComponent(
	"bitrix:news", 
	"news.1", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "23",
		"NEWS_COUNT" => "20",
		"USE_SEARCH" => "N",
		"FILTER" => "arrFilter",
		"SETTINGS_USE" => "Y",
		"SETTINGS_PROFILE" => "news",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"PROPERTY_TAGS" => "TAGS",
		"TAGS_USE" => "N",
		"TAGS_VARIABLE" => "tags",
		"TAGS_HEADER_SHOW" => "Y",
		"TAGS_HEADER_TEXT" => "Популярное сейчас",
		"TAGS_TEMPLATE" => "template.2",
		"TAGS_SECTION_SUBSECTIONS" => "Y",
		"TAGS_COUNT" => "Y",
		"TAGS_USED" => "Y",
		"TOP_USE" => "N",
		"SUBSCRIBE_USE" => "N",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/company/news/",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"USE_PERMISSIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "j M Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "ASSOCIATED",
			1 => "TAGS",
			2 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PANEL_SHOW" => "Y",
		"PANEL_VARIABLE" => "year",
		"PANEL_VIEW" => "1",
		"LIST_TEMPLATE" => "list.1",
		"LIST_LINK_BLANK" => "N",
		"LIST_IMAGE_SHOW" => "Y",
		"LIST_IMAGE_VIEW" => "default",
		"LIST_PREVIEW_SHOW" => "Y",
		"LIST_PREVIEW_TRUNCATE_USE" => "Y",
		"LIST_PREVIEW_TRUNCATE_COUNT" => "30",
		"LIST_TAGS_SHOW" => "Y",
		"LIST_TAGS_MODE" => "active",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_ACTIVE_DATE_FORMAT" => "j M Y",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "ASSOCIATED",
			1 => "TAGS",
			2 => "",
		),
		"DETAIL_TEMPLATE" => "default.1",
		"DETAIL_PROPERTY_ADDITIONAL_NEWS" => "ASSOCIATED",
		"DETAIL_DATE_SHOW" => "Y",
		"DETAIL_DATE_TYPE" => "DATE_ACTIVE_FROM",
		"DETAIL_PRINT_SHOW" => "Y",
		"DETAIL_PREVIEW_SHOW" => "Y",
		"DETAIL_IMAGE_SHOW" => "Y",
		"DETAIL_ADDITIONAL_NEWS_SHOW" => "Y",
		"DETAIL_ADDITIONAL_NEWS_HEADER_SHOW" => "Y",
		"DETAIL_ADDITIONAL_NEWS_HEADER_TEXT" => "Читайте также",
		"DETAIL_ADDITIONAL_NEWS_DATE_SHOW" => "Y",
		"DETAIL_ADDITIONAL_NEWS_LINK_USE" => "Y",
		"DETAIL_ADDITIONAL_NEWS_LINK_BLANK" => "Y",
		"DETAIL_ADDITIONAL_NEWS_COLUMNS" => "2",
		"DETAIL_ADDITIONAL_NEWS_SLIDER_LOOP" => "N",
		"DETAIL_ADDITIONAL_NEWS_SLIDER_AUTO_USE" => "N",
		"DETAIL_BUTTON_BACK_SHOW" => "Y",
		"DETAIL_BUTTON_SOCIAL_SHOW" => "N",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_TAGS_SHOW" => "Y",
		"DETAIL_TAGS_POSITION" => "top",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"FILE_404" => "/404.php",
		"COMPONENT_TEMPLATE" => "news.1",
		"LIST_LAZYLOAD_USE" => "N",
		"LIST_DELIMITER_SHOW" => "N",
		"LIST_DATE_SHOW" => "N",
		"DETAIL_LAZYLOAD_USE" => "N",
		"DETAIL_PROPERTY_ADDITIONAL_PRODUCTS" => "",
		"DETAIL_PROPERTY_ADDITIONAL_PRODUCTS_CATEGORIES" => "",
		"DETAIL_ADDITIONAL_NEWS_NAVIGATION_USE" => "N",
		"DETAIL_ADDITIONAL_NEWS_LAZYLOAD_USE" => "N",
		"DETAIL_ADDITIONAL_NEWS_PREVIEW_SHOW" => "N",
		"DETAIL_ADDITIONAL_NEWS_PREVIEW_TRUNCATE_USE" => "N",
		"DETAIL_MICRODATA_TYPE" => "Article",
		"DETAIL_MICRODATA_AUTHOR" => "",
		"DETAIL_MICRODATA_PUBLISHER" => "",
		"DETAIL_LINKING_SHOW" => "N",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
); ?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php") ?>