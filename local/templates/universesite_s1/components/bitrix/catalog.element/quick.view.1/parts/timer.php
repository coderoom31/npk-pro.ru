<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\JavaScript;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 * @var string $sTemplateId
 */

$sPrefix = 'TIMER_';

$iLength = StringHelper::length($sPrefix);

$arProperties = [];
$arExcluded = [
    'SHOW',
    'NAME'
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
    'ELEMENT_ID' => $arResult['ID'],
    'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    'IBLOCK_TYPE' => $arResult['IBLOCK_TYPE_ID'],
    'QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
    'ITEM_NAME' => $arResult['NAME']
], $arProperties);

$arProperties['QUANTITY'] = $arResult['PRODUCT']['QUANTITY'];
?>
<div data-role="timer"></div>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var root = data.nodes;

        this.api.components.get(<?= JavaScript::toObject([
            'component' => 'intec.universe:product.timer',
            'template' => 'template.1',
            'parameters' => $arProperties
        ]) ?>).then(function (content) {
            $('[data-role="timer"]', root).html(content);
        });
    }, {
        'name': '[Component] bitrix:catalog.element (quick.view.1)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>
