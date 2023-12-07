<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
    <?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

/**
 * @param array $arItem
 */
$vPurchase = function (&$arItem) use (&$arResult, &$arVisual, &$APPLICATION, &$component, &$sTemplateId) {
    $fRender = function (&$arItem, $bOffer = false) use (&$arResult, &$APPLICATION, &$component, &$sTemplateId, &$arVisual) { ?>
        <?php if ($bOffer || $arItem['ACTION'] === 'buy' && $arItem['CAN_BUY']) { ?>
            <?php $arPrice = ArrayHelper::getValue($arItem, ['ITEM_PRICES', 0]) ?>
            <div class="catalog-section-item-purchase-buttons" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
                <?= Html::beginTag('div', [
                    'class' => [
                        'intec-ui',
                        'intec-ui-control-basket-button',
                        'catalog-section-item-purchase-button',
                        'catalog-section-item-purchase-button-add',
                        'intec-ui-control-button',
                        'intec-ui-scheme-current'
                    ],
                    'data' => [
                        'basket-id' => $arItem['ID'],
                        'basket-action' => 'add',
                        'basket-state' => 'none',
                        'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                    ]
                ]) ?>

                    <div class="intec-ui-part-icon">
                        <i class="glyph-icon-cart"></i>
                    </div>
                    <div class="intec-ui-part-content">
                        <?= $arVisual['BUTTONS']['BASKET']['TEXT'] ?>
                    </div>
                    <span class="intec-ui-part-effect intec-ui-part-effect-bounce">
                        <span class="intec-ui-part-effect-wrapper">
                            <i></i><i></i><i></i>
                        </span>
                    </span>
                <?= Html::endTag('div') ?>
                <?= Html::beginTag('a', [
                    'href' => $arResult['URL']['BASKET'],
                    'class' => [
                    'catalog-section-item-purchase-button',
                    'catalog-section-item-purchase-button-added',
                    'intec-ui',
                    'intec-ui-control-button',
                    'intec-ui-scheme-current',
                    'intec-ui-state-hover'
                    ],
                    'data' => [
                        'basket-id' => $arItem['ID'],
                        'basket-action' => 'add',
                        'basket-state' => 'none',
                        'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                    ]
                ]) ?>
                    <div class="intec-ui-part-icon">
                        <i class="glyph-icon-cart"></i>
                    </div>
                    <div class="intec-ui-part-content">
                        <?= Loc::getMessage('C_CATALOG_SECTION_PRODUCTS_SMALL_5_BUTTON_ADDED') ?>
                    </div>

                <?= Html::endTag('a') ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'catalog-section-item-purchase-button',
                        'catalog-section-item-purchase-button-update',
                        'intec-ui',
                        'intec-ui-control-button',
                        'intec-ui-scheme-current',
                    ],
                    'data' => [
                        'basket-id' => $arItem['ID'],
                        'basket-action' => 'setQuantity',
                        'basket-state' => 'none',
                        'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                    ]
                ]) ?>

                    <div class="intec-ui-part-icon">
                        <i class="glyph-icon-cart"></i>
                    </div>
                    <div class="intec-ui-part-content">
                        <?= Loc::getMessage('C_CATALOG_SECTION_PRODUCTS_SMALL_5_BUTTON_UPDATE') ?>
                    </div>
                <?= Html::endTag('div') ?>
            </div>
        <?php } ?>
    <?php };

    $fRender($arItem, false);

    if ($arItem['ACTION'] === 'buy' && $arVisual['OFFERS']['USE'] && !empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer) {
            $fRender($arOffer, true);

            unset($arOffer);
        }
};