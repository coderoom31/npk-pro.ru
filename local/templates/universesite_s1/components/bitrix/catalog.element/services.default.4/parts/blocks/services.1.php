<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

?>
<div class="catalog-element-services-1">
    <?php $APPLICATION->IncludeComponent(
        'intec.universe:main.services',
        $arBlock['TEMPLATE'],
        ArrayHelper::merge($arBlock['PARAMETERS'], [
            'IBLOCK_TYPE' => $arBlock['IBLOCK']['TYPE'],
            'IBLOCK_ID' => $arBlock['IBLOCK']['ID'],
            'FILTER' => [
                'ID' => $arBlock['IBLOCK']['ELEMENTS']
            ],
            'SECTIONS_MODE' => 'id',
            'SECTIONS' => [
                0 => "",
                1 => "",
            ],
            'ELEMENTS_COUNT' => '',
            'SETTINGS_USE' => 'N',
            'LAZYLOAD_USE' => $arResult['LAZYLOAD']['USE'] ? 'Y' : 'N',
            'HEADER_BLOCK_SHOW' => 'Y',
            'HEADER_BLOCK_POSITION' => 'left',
            'HEADER_BLOCK_TEXT' => $arBlock['HEADER']['VALUE'],
            'DESCRIPTION_SHOW' => 'N',
            'CACHE_TYPE' => 'N'
        ]),
        $component
    ) ?>
</div>