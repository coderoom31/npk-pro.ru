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
    'margin-bottom' => '100px'
]]) ?>
    <?php $APPLICATION->IncludeComponent(
	"intec.universe:main.services", 
	"template.1", 
	array(
		"IBLOCK_TYPE" => "catalogs",
		"IBLOCK_ID" => "16",
		"ELEMENTS_COUNT" => "6",
		"HEADER_BLOCK_SHOW" => "Y",
		"HEADER_BLOCK_POSITION" => "center",
		"HEADER_BLOCK_TEXT" => "ОБОРУДОВНАИЕ ДЛЯ КАС и СЗР",
		"DESCRIPTION_BLOCK_SHOW" => "N",
		"LINE_COUNT" => "3",
		"ALIGNMENT" => "center",
		"DESCRIPTION_SHOW" => "Y",
		"DETAIL_SHOW" => "Y",
		"DETAIL_TEXT" => "Подробнее",
		"FOOTER_SHOW" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"SORT_BY" => "SORT",
		"ORDER_BY" => "ASC",
		"COMPONENT_TEMPLATE" => "template.1",
		"SECTIONS" => array(
			0 => "66",
			1 => "",
		),
		"LIST_PAGE_URL" => "",
		"FOOTER_POSITION" => "center",
		"FOOTER_BUTTON_SHOW" => "N"
	),
	false
); ?>
<?= Html::endTag('div') ?>