<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\collections\Arrays;
use intec\core\helpers\Html;
use intec\core\io\Path;

/**
 * @var Arrays $blocks
 * @var array $block
 * @var array $data
 * @var string $page
 * @var Path $path
 * @global CMain $APPLICATION
 */

?>
<?= Html::beginTag('div', ['style' => [
    'padding-top' => '50px',
    'padding-bottom' => '50px',
    'background-color' => '#f1f1f1'
]]) ?>
    <?php $APPLICATION->IncludeComponent(
	"intec.universe:main.advantages", 
	"template-advantages-custom", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "5",
		"SECTIONS_MODE" => "id",
		"ELEMENTS_COUNT" => "6",
		"LINE_COUNT" => "3",
		"SETTINGS_USE" => "Y",
		"LAZYLOAD_USE" => "N",
		"HEADER_SHOW" => "Y",
		"HEADER_POSITION" => "center",
		"HEADER" => "Преимущества",
		"DESCRIPTION_SHOW" => "N",
		"VIEW" => "icon",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"SORT_BY" => "SORT",
		"ORDER_BY" => "ASC",
		"COMPONENT_TEMPLATE" => "template-advantages-custom",
		"SECTIONS" => array(
			0 => "",
			1 => "",
		),
		"PICTURE_SHOW" => "N",
		"BORDER_SHOW" => "N",
		"BACKGROUND_SIZE" => "cover",
		"ARROW_SHOW" => "N",
		"INDENT_USE" => "N",
		"PREVIEW_SHOW" => "N",
		"COLUMNS" => "3",
		"NUMBER_SHOW" => "N",
		"THEME" => "light",
		"ICON_SHOW" => "N",
		"BACKGROUND_USE" => "N",
		"BACKGROUND_SHOW" => "N",
		"PROPERTY_NUMBER" => "",
		"PROPERTY_MAX_NUMBER" => "",
		"BUTTON_SHOW" => "N",
		"PICTURE_POSITION" => "top",
		"ELEMENTS_ROW_COUNT" => "4",
		"BACKGROUND_PATH" => "",
		"PICTURE_SIZE" => "60",
		"NAME_SHOW" => "N",
		"NAME_SIZE" => "middle",
		"NAME_MARGIN" => "middle",
		"ELEMENT_MARGIN" => "middle",
		"TITLE_POSITION" => "top",
		"ALIGNMENT" => "center",
		"PROPERTY_NAME" => "",
		"PROPERTY_IMAGES" => "",
		"PROPERTY_TEXT_ADDITIONAL" => "",
		"PROPERTY_THEME" => "",
		"PROPERTY_VIEW" => "",
		"PROPERTY_DETAIL_NARROW" => "",
		"BUTTON_TEXT" => "Подробнее"
	),
	false
); ?>
<?= Html::endTag('div') ?>