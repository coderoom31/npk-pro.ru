<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\measures\helpers\ProductsHelper;

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['MEASURES'] = ProductsHelper::getMeasures($arItem['ID']);

    if (!empty($arItem['OFFERS'])) {
        foreach ($arItem['OFFERS'] as &$arOffer) {
            $arOffer['MEASURES'] = ProductsHelper::getMeasures($arOffer['ID']);
        }
    }
}