<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

?>
<div class="catalog-element-projects-2">
    <?php $APPLICATION->IncludeComponent(
        'intec.universe:main.projects',
        'template.4',
        ArrayHelper::merge($arBlock['PARAMETERS'], [
            'IBLOCK_TYPE' => $arBlock['IBLOCK']['TYPE'],
            'IBLOCK_ID' => $arBlock['IBLOCK']['ID'],
            'FILTER' => [
                'ID' => $arBlock['IBLOCK']['ELEMENTS']
            ],
            'HEADER_SHOW' => 'Y',
            'HEADER_POSITION' => 'center',
            'HEADER_TEXT' => $arBlock['HEADER'],
            'DESCRIPTION_SHOW' => 'N',
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
