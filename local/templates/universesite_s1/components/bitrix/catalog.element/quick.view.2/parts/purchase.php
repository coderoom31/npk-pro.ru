<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 */

?>
<?php $vPurchase = function (&$arItem, $bOffer = false) use (&$arResult, &$arPrice, &$APPLICATION, &$component, &$sTemplateId) { ?>
    <?php if ($arResult['ACTION'] === 'buy') { ?>
        <?php if ($arItem['CAN_BUY']) { ?>
            <?php $arPrice = ArrayHelper::getValue($arItem, ['ITEM_PRICES', 0]) ?>
            <div class="catalog-element-purchase-buttons" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
                <?= Html::beginTag('div', [
                    'class' => [
                        'intec-ui',
                        'intec-ui-control-basket-button',
                        'catalog-element-purchase-button',
                        'catalog-element-purchase-button-add',
                        'intec-cl-background',
                        'intec-cl-background-light-hover'
                    ],
                    'data' => [
                        'basket-id' => $arItem['ID'],
                        'basket-action' => 'add',
                        'basket-state' => 'none',
                        'basket-quantity' => $arItem['CATALOG_MEASURE_RATIO'],
                        'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                    ]
                ]) ?>
                    <span class="catalog-element-purchase-button-content intec-ui-part-content">
                        <i class="glyph-icon-cart"></i>
                        <span>
                            <?= Loc::getMessage('C_CATALOG_ELEMENT_QUICK_VIEW_2_PURCHASE_ADD') ?>
                        </span>
                    </span>
                    <span class="intec-ui-part-effect intec-ui-part-effect-bounce">
                        <span class="intec-ui-part-effect-wrapper">
                            <i></i><i></i><i></i>
                        </span>
                    </span>
                <?= Html::endTag('div') ?>
                <?= Html::beginTag('a', [
                    'href' => $arResult['URL']['BASKET'],
                    'class' => [
                        'catalog-element-purchase-button',
                        'catalog-element-purchase-button-added',
                        'intec-cl-background-light'
                    ],
                    'data' => [
                        'basket-id' => $arItem['ID'],
                        'basket-state' => 'none'
                    ]
                ]) ?>
                    <span class="catalog-element-purchase-button-content">
                        <i class="glyph-icon-cart"></i>
                        <span>
                            <?= Loc::getMessage('C_CATALOG_ELEMENT_QUICK_VIEW_2_PURCHASE_ADDED') ?>
                        </span>
                    </span>
                <?= Html::endTag('a') ?>
            </div>
        <?php } else { ?>
            <?php if ($arItem['CATALOG_SUBSCRIBE'] == 'Y') { ?>
                <?php if (!empty($arItem['OFFERS']) && $bOffer == false) { ?>
                    <?php return; ?>
                <?php } ?>
                <div class="catalog-element-purchase-buttons" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:catalog.product.subscribe",
                        ".default",
                        [
                            "BUTTON_CLASS" => "catalog-element-purchase-button catalog-element-purchase-button-subscribe intec-cl-background intec-cl-background-light-hover",
                            "BUTTON_ID" => $sTemplateId . "_subscribe_" . $arItem['ID'],
                            "PRODUCT_ID" => $arItem['ID']
                        ],
                        $component
                    ); ?>
                </div>
            <?php } else { ?>
                <div class="catalog-element-purchase-buttons" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
                    <?= Html::beginTag('div', [
                        'class' => [
                            'catalog-element-purchase-button',
                            'catalog-element-purchase-button-unavailable',
                            'intec-cl-background'
                        ],
                        'title' => Loc::getMessage('C_CATALOG_ELEMENT_QUICK_VIEW_2_PURCHASE_UNAVAILABLE')
                    ]) ?>
                        <span class="catalog-element-purchase-button-content">
                            <i class="far fa-times-circle"></i>
                            <span>
                                <?= Loc::getMessage('C_CATALOG_ELEMENT_QUICK_VIEW_2_PURCHASE_UNAVAILABLE') ?>
                            </span>
                        </span>
                    <?= Html::endTag('div') ?>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <div class="catalog-element-purchase-buttons">
            <?= Html::beginTag('a', [
                'href' => Html::decode($arResult['DETAIL_PAGE_URL']),
                'class' => [
                    'catalog-element-purchase-button',
                    'catalog-element-purchase-button-detail',
                    'intec-cl-background',
                    'intec-cl-background-light-hover'
                ]
            ]) ?>
                <span class="catalog-element-purchase-button-content">
                    <span>
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_QUICK_VIEW_2_PURCHASE_DETAIL') ?>
                    </span>
                </span>
            <?= Html::endTag('a') ?>
        </div>
    <?php } ?>
<?php } ?>

<div class="catalog-element-purchase">
    <?php $vPurchase($arResult);

        if (!empty($arResult['OFFERS']) && $arResult['ACTION'] === 'buy')
            foreach ($arResult['OFFERS'] as &$arOffer) {
                $vPurchase($arOffer, true);

                unset($arOffer);
            }

        unset($vPurchase);
    ?>
</div>