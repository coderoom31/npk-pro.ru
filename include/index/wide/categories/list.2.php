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
    <? $APPLICATION->IncludeComponent(
        "intec.universe:main.categories",
        "template.19",
        array(
            "IBLOCK_TYPE" => "content",
            "IBLOCK_ID" => "9",
            "SECTIONS_MODE" => "id",
            "SETTINGS_USE" => "Y",
            "LAZYLOAD_USE" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => 3600000,
            "SORT_BY" => "SORT",
            "SORT_ORDER" => "ASC",
            "ELEMENTS_COUNT" => 3,
            "COLUMNS" => 3,
            "LINK_USE" => "Y",
            "LINK_BLANK" => "Y",
            "LINK_MODE" => "property",
            "PROPERTY_LINK" => "LINK",
            "HEADER_SHOW" => "N",
            "DESCRIPTION_SHOW" => "N",
            "NAME_SHOW" => "Y",
            "PREVIEW_SHOW" => "Y"
        ),
        false
    ); ?>
<?= Html::endTag('div') ?>