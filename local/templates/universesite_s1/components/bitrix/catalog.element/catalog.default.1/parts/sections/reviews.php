<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\JavaScript;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 * @var string $sTemplateId
 */

$sPrefix = 'REVIEWS_';

$iLength = StringHelper::length($sPrefix);

$arProperties = [];
$arExcluded = [
    'SHOW',
    'NAME',
    'IBLOCK_ID',
    'IBLOCK_TYPE',
    'MODE',
    'PROPERTY_ID',
    'ID',
    'SETTINGS_USE',
    'LAZYLOAD_USE',
    'CAPTCHA_USE',
    'CACHE_TYPE',
    'CACHE_TIME',
    'CACHE_NOTES'
];

foreach ($arParams as $sKey => $sValue) {
    if (!StringHelper::startsWith($sKey, $sPrefix))
        continue;

    $sKey = StringHelper::cut($sKey, $iLength);

    if (ArrayHelper::isIn($sKey, $arExcluded))
        continue;

    $arProperties[$sKey] = $sValue;
}

unset($sPrefix, $iLength, $arExcluded, $sKey, $sValue);

$arProperties = ArrayHelper::merge([
    'IBLOCK_TYPE' => $arParams['REVIEWS_IBLOCK_TYPE'],
    'IBLOCK_ID' => $arParams['REVIEWS_IBLOCK_ID'],
    'MODE' => 'linked',
    'PROPERTY_ID' => $arParams['REVIEWS_PROPERTY_ELEMENT_ID'],
    'ID' => $arResult['ID'],
    'CAPTCHA_USE' => $arParams['REVIEWS_USE_CAPTCHA'],
    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
    'CACHE_TIME' => $arParams['CACHE_TIME'],
    'SETTINGS_USE' => $arParams['SETTINGS_USE'],
    'LAZYLOAD_USE' => $arParams['LAZYLOAD_USE']
], $arProperties);

if ($arProperties['MODE'] === 'linked' && empty($arProperties['ID']))
    $arProperties['ID'] = $arResult['ID'];

?>
<div data-role="reviews">
    <?php $APPLICATION->IncludeComponent(
        'intec.universe:reviews',
        'template.1',
        $arProperties,
        $component,
        ['HIDE_ICONS' => 'Y']
    ) ?>
</div>
<?php unset($arProperties) ?>