<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arShares = [];
$arShares['PREFIX'] = 'SHARES_';
$arShares['SHOW'] = $arParams['SHARES_SHOW'] === 'Y';
$arShares['PARAMETER'] = [];

foreach ($arParams as $sKey => $sValue) {
    if (!StringHelper::startsWith($sKey, $arShares['PREFIX']))
        continue;

    $sKey = StringHelper::cut($sKey, StringHelper::length($arShares['PREFIX']));
    $arShares['PARAMETERS'][$sKey] = $sValue;
}

$arResult['SHARES'] = $arShares;

unset($arShares);