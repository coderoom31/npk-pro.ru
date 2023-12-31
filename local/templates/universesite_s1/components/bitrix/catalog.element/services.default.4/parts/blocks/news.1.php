<?php use intec\core\helpers\ArrayHelper;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

?>
<div class="catalog-element-news">
    <?php $APPLICATION->IncludeComponent(
        'intec.universe:main.news',
        $arBlock['TEMPLATE'],
        ArrayHelper::merge($arBlock['PARAMETERS'], [
            'IBLOCK_TYPE' => $arBlock['IBLOCK']['TYPE'],
            'IBLOCK_ID' => $arBlock['IBLOCK']['ID'],
            'FILTER' => [
                'ID' => $arBlock['IBLOCK']['ELEMENTS']
            ],
            'HEADER_BLOCK_SHOW' => 'Y',
            'HEADER_BLOCK_POSITION' => 'left',
            'HEADER_BLOCK_TEXT' => $arBlock['HEADER'],
            'DESCRIPTION_BLOCK_SHOW' => 'N',
            'ELEMENTS_COUNT' => '',
            'MODE' => 'N',
            'SECTIONS' => null,
            'CACHE_TYPE' => 'N',
            'SETTINGS_USE' => 'N',
            'LAZYLOAD_USE' => $arResult['LAZYLOAD']['USE'] ? 'Y' : 'N'
        ]),
        $component
    ) ?>
</div>