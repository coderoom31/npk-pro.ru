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
    'margin-top' => '100px',
]]) ?>
	<?php $APPLICATION->IncludeComponent(
	"intec.universe:main.about", 
	"template.2", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "4",
		"SECTIONS_MODE" => "id",
		"SECTION" => array(
			0 => "",
			1 => "",
		),
		"ELEMENTS_MODE" => "code",
		"ELEMENT" => "about_2",
		"PICTURE_SOURCES" => array(
			0 => "preview",
		),
		"SETTINGS_USE" => "N",
		"ADVANTAGES_IBLOCK_TYPE" => "content",
		"ADVANTAGES_IBLOCK_ID" => "7",
		"PROPERTY_TITLE" => "HEADER",
		"PROPERTY_LINK" => "LINK",
		"PROPERTY_VIDEO" => "VIDEO_LINK",
		"PROPERTY_ADVANTAGES" => "ADVANTAGES",
		"ADVANTAGES_PROPERTY_SVG_FILE" => "ICON",
		"VIEW" => "2",
		"TITLE_SHOW" => "Y",
		"PREVIEW_SHOW" => "Y",
		"BUTTON_SHOW" => "Y",
		"BUTTON_VIEW" => "1",
		"BUTTON_BLANK" => "N",
		"BUTTON_TEXT" => "Узнать подробнее",
		"PICTURE_SHOW" => "Y",
		"PICTURE_SIZE" => "contain",
		"POSITION_HORIZONTAL" => "center",
		"POSITION_VERTICAL" => "center",
		"VIDEO_SHOW" => "Y",
		"ADVANTAGES_SHOW" => "Y",
		"SVG_FILE_USE" => "Y",
		"ADVANTAGES_COLUMNS" => "2",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"CACHE_NOTES" => "",
		"SORT_BY" => "SORT",
		"ORDER_BY" => "ASC",
		"LAZYLOAD_USE" => "N",
		"COMPONENT_TEMPLATE" => "template.2",
		"PROPERTY_BACKGROUND" => ""
	),
	false
); ?>
<?= Html::endTag('div') ?>