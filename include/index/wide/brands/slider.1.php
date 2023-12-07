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
    'background-color' => '#f1f1f1'
]]) ?>
    <?php $APPLICATION->IncludeComponent(
	"intec.universe:main.brands", 
	"template.1", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "34",
		"SECTIONS_MODE" => "id",
		"ELEMENTS_COUNT" => "",
		"SETTINGS_USE" => "N",
		"LAZYLOAD_USE" => "N",
		"LINK_USE" => "N",
		"HEADER_SHOW" => "Y",
		"HEADER_POSITION" => "center",
		"HEADER_TEXT" => "Нам доверяют",
		"DESCRIPTION_SHOW" => "N",
		"LINE_COUNT" => "3",
		"EFFECT" => "none",
		"TRANSPARENCY" => "0",
		"SLIDER_USE" => "Y",
		"SLIDER_NAVIGATION" => "Y",
		"SLIDER_DOTS" => "Y",
		"SLIDER_LOOP" => "N",
		"SLIDER_AUTO_USE" => "Y",
		"FOOTER_SHOW" => "N",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"SORT_BY" => "SORT",
		"ORDER_BY" => "ASC",
		"COMPONENT_TEMPLATE" => "template.1",
		"SECTIONS" => array(
			0 => "",
			1 => "",
		),
		"SLIDER_AUTO_PAUSE" => "N",
		"SLIDER_AUTO_SPEED" => "700",
		"SLIDER_AUTO_TIME" => "7000",
		"LIST_PAGE_URL" => ""
	),
	false
); ?>
<?= Html::endTag('div') ?>