<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Catalog\ProductTable;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arProductsId = [];

$arProductsId[] = $arParams['ELEMENT_ID'];

if ($arResult['IS_SKU']) {
    foreach($arResult['JS']['SKU'] as $key => $val)
        $arProductsId[] = $key;
}

$arMeasureResult = ProductTable::getCurrentRatioWithMeasure($arProductsId);

$arMeasure = [];

foreach ($arMeasureResult as $key => $arItem)
    $arMeasure[$key] = $arItem['MEASURE']['SYMBOL_RUS'];

unset($arMeasureResult);

if ($arResult['IS_SKU'])
    $arResult['JS']['MEASURE'] = $arMeasure;

foreach ($arResult['STORES'] as $key => $arStore) {
    if ($arParams['USE_MIN_AMOUNT'] != 'Y')
        $arResult['STORES'][$key]['AMOUNT'] = $arStore['AMOUNT'].' '.$arMeasure[$arParams['ELEMENT_ID']];

    $arResult['STORES'][$key]['REAL_AMOUNT'] = $arStore['REAL_AMOUNT'].' '.$arMeasure[$arParams['ELEMENT_ID']];
}