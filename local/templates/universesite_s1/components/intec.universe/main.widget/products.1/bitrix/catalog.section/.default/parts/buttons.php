<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

/**
 * @param array $arItem
 */
$vButtons = function (&$arItem) use (&$arResult, &$arVisual) {
    $iBlockId = $arItem['IBLOCK_ID'];

    $fRender = function (&$arItem, $bOffer = false) use (&$arResult, &$iBlockId, &$arVisual) { ?>
        <div class="widget-item-image-buttons" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
            <?php if ($arItem['DELAY']['USE'] && $arItem['CAN_BUY'] && ($bOffer || empty($arItem['OFFERS']))) { ?>
                <?php $arPrice = ArrayHelper::getValue($arItem, ['ITEM_PRICES', 0]) ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'widget-item-image-button',
                        'widget-item-image-button-delay',
                        'intec-cl-text-hover'
                    ],
                    'data' => [
                        'basket-id' => $arItem['ID'],
                        'basket-action' => 'delay',
                        'basket-state' => 'none',
                        'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                    ],
                    'title' => Loc::getMessage('C_WIDGET_PRODUCTS_1_DELAY_ADD_TITLE')
                ]) ?>
                <i class="intec-ui-icon intec-ui-icon-heart-1"></i>
                <?= Html::endTag('div') ?>
                <?= Html::beginTag('div', [
                'class' => [
                    'widget-item-image-button',
                    'widget-item-image-button-delayed',
                    'intec-cl-text'
                ],
                'data' => [
                    'basket-id' => $arItem['ID'],
                    'basket-action' => 'remove',
                    'basket-state' => 'none'
                ],
                'title' => Loc::getMessage('C_WIDGET_PRODUCTS_1_DELAY_ADDED_TITLE')
            ]) ?>
                <i class="intec-ui-icon intec-ui-icon-heart-1"></i>
                <?= Html::endTag('div') ?>
            <?php } ?>
            <?php if ($arResult['COMPARE']['USE']) { ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'widget-item-image-button',
                        'widget-item-image-button-compare',
                        'intec-cl-text-hover'
                    ],
                    'data' => [
                        'compare-id' => $arItem['ID'],
                        'compare-action' => 'add',
                        'compare-code' => $arResult['COMPARE']['CODE'],
                        'compare-state' => 'none',
                        'compare-iblock' => $iBlockId
                    ],
                    'title' => Loc::getMessage('C_WIDGET_PRODUCTS_1_COMPARE_ADD_TITLE')
                ]) ?>
                    <i class="glyph-icon-compare"></i>
                <?= Html::endTag('div') ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'widget-item-image-button',
                        'widget-item-image-button-compared',
                        'intec-cl-text'
                    ],
                    'data' => [
                        'compare-id' => $arItem['ID'],
                        'compare-action' => 'remove',
                        'compare-code' => $arResult['COMPARE']['CODE'],
                        'compare-state' => 'none',
                        'compare-iblock' => $iBlockId
                    ],
                    'title' => Loc::getMessage('C_WIDGET_PRODUCTS_1_COMPARE_ADDED_TITLE')
                ]) ?>
                    <i class="glyph-icon-compare"></i>
                <?= Html::endTag('div') ?>
            <?php } ?>
        </div>
    <?php };

    $fRender($arItem);

    if (!empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer)
            $fRender($arOffer, true);
};