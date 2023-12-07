<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Json;

/**
 * @var array $arResult
 * @var array $arVisual
 * @var string $sTemplateId
 */

include(__DIR__.'/sku.list.buttons.php');
include(__DIR__.'/sku.list.order.php');
include(__DIR__.'/sku.list.price.range.php');

$vTimer = include(__DIR__.'/sku.list.timer.php');

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId.'-sku-list',
    'class' => [
        'catalog-element-sections',
        'catalog-element-sections-wide'
    ]
]) ?>
    <div class="catalog-element-section">
        <div class="catalog-element-section-name">
            <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SKU_LIST_TITLE') ?>
        </div>
        <div class="catalog-element-section-content">
            <div class="catalog-element-section-offers-list" data-role="offers">
                <?php foreach ($arResult['OFFERS'] as $arOffer) {

                    $arOfferData = ArrayHelper::getValue($arData, ['offers', $arOffer['ID']]);

                    $arPrice = null;

                    if (!empty($arOfferData['prices']))
                        $arPrice = ArrayHelper::getFirstValue($arOfferData['prices']);

                ?>
                    <?= Html::beginTag('div', [
                        'class' => [
                            'catalog-element-offer'
                        ],
                        'data' => [
                            'role' => 'offer',
                            'offer-data' => Json::encode($arOfferData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true),
                            'available' => $arOfferData['available'] ? 'true' : 'false',
                            'subscribe' => $arOfferData['subscribe'] ? 'true' : 'false',
                        ]
                    ]) ?>
                        <?= Html::beginTag('div', [
                            'class' => [
                                'catalog-element-offer-content',
                                'intec-grid' => [
                                    '',
                                    'a-v-baseline',
                                    'i-12',
                                    '800-wrap'
                                ]
                            ]
                        ]) ?>
                            <div class="catalog-element-offer-info intec-grid-item-3 intec-grid-item-800-1">
                                <div class="catalog-element-offer-name">
                                    <?= $arOffer['NAME'] ?>
                                </div>
                                <div class="catalog-element-offer-quantity-wrap">
                                    <?php $vQuantity($arOffer, false) ?>
                                </div>
                                <div class="catalog-element-offer-properties">
                                    <?php foreach($arResult['SKU_PROPS'] as $arProperty) {

                                        $sPropertyValue = ArrayHelper::getValue($arProperty, [
                                            'values',
                                            $arOffer['TREE']['PROP_'.$arProperty['id']],
                                            'name'
                                        ]);

                                    ?>
                                        <div class="catalog-element-offer-property intec-grid">
                                            <div class="catalog-element-offer-property-title intec-grid-auto">
                                                <?= $arProperty['name'] ?>
                                            </div>
                                            <div class="catalog-element-offer-property-value intec-grid-auto">
                                                <?= $sPropertyValue ?>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="catalog-element-offer-price-wrap intec-grid-item-3 intec-grid-item-800-2 intec-grid-item-550-1">
                                <?= Html::beginTag('div', [
                                    'class' => [
                                        'catalog-element-offer-price',
                                        'intec-grid' => [
                                            '',
                                            'wrap',
                                            'i-5',
                                            'a-v-center',
                                            'a-h-start'
                                        ]
                                    ],
                                    'data' => [
                                        'role' => 'price',
                                        'show' => !empty($arPrice) ? 'true' : 'false',
                                        'discount' => !empty($arPrice) && $arPrice['discount']['use'] > 0 ? 'true' : 'false'
                                    ]
                                ]) ?>
                                    <div class="catalog-element-offer-price-discount intec-grid-item-auto">
                                        <span data-role="price.discount">
                                            <?= !empty($arPrice) ? $arPrice['discount']['display'] : null ?>
                                        </span>
                                        <?php if (!empty($arOffer['CATALOG_MEASURE_NAME'])) { ?>
                                            <span>
                                                /
                                            </span>
                                            <span>
                                                <?= $arOffer['CATALOG_MEASURE_NAME'].'.' ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <div class="catalog-element-offer-price-base intec-grid-item-auto" data-role="price.base">
                                        <?= $arPrice['base']['display'] ?>
                                    </div>

                                <?= Html::endTag('div') ?>
                                <?php if ($arVisual['PRICE']['RANGE']) {
                                    $vPriceRangeSKUList($arOffer, false);
                                } ?>
                                <?php if ($arVisual['TIMER']['SHOW'])
                                    $vTimer($arOffer)
                                ?>
                            </div>
                            <div class="catalog-element-offer-buy intec-grid-item-3 intec-grid-item-800-2 intec-grid-item-550-1">
                                <div class="catalog-element-offer-purshare-wrap intec-grid intec-grid-a-h-end intec-grid-a-h-550-start intec-grid-700-wrap intec-grid-i-v-5">
                                    <?php if ($arVisual['COUNTER']['SHOW']) { ?>
                                        <div class="catalog-element-purchase-counter-wrap intec-grid-item-2 intec-grid-item-700-auto">
                                            <?= Html::beginTag('div', [
                                                'class' => [
                                                    'catalog-element-purchase-counter-control',
                                                    'intec-ui' => [
                                                        '',
                                                        'control-numeric',
                                                        'scheme-current',
                                                        'view-2',
                                                        'size-4'
                                                    ]
                                                ],
                                                'data-role' => 'counter'
                                            ]) ?>
                                                <?= Html::tag('a', '-', [
                                                    'class' => 'intec-ui-part-decrement',
                                                    'href' => 'javascript:void(0)',
                                                    'data-type' => 'button',
                                                    'data-action' => 'decrement'
                                                ]) ?>
                                                <?= Html::input('text', null, 0, [
                                                    'data-type' => 'input',
                                                    'class' => 'intec-ui-part-input'
                                                ]) ?>
                                                <?= Html::tag('a', '+', [
                                                    'class' => 'intec-ui-part-increment',
                                                    'href' => 'javascript:void(0)',
                                                    'data-type' => 'button',
                                                    'data-action' => 'increment'
                                                ]) ?>
                                            <?= Html::endTag('div') ?>
                                        </div>
                                    <?php } ?>
                                    <div class="catalog-element-purchase-order-buttons intec-grid-item-2 intec-grid-item-700-auto" data-offer="false">
                                        <?php $vOrder($arOffer) ?>
                                    </div>
                                </div>
                                <div class="catalog-element-offer-buttons-wrap intec-grid intec-grid-a-h-end intec-grid-a-h-550-start intec-grid-a-v-center">
                                    <div class="catalog-element-offer-button">
                                        <?php $vButtons($arOffer) ?>
                                    </div>
                                    <?php if ($arResult['ORDER_FAST']['USE']) { ?>
                                        <?= Html::beginTag('div', [
                                            'class' => [
                                                'catalog-element-offer-orderfast',
                                                'intec-ui' => [
                                                    '',
                                                    'control-button',
                                                    'scheme-current',
                                                    'mod-link'
                                                ]
                                            ],
                                            'data-role' => 'orderFast'
                                        ]) ?>
                                            <div class="intec-ui-part-icon">
                                                <i class="glyph-icon-one_click"></i>
                                            </div>
                                            <div class="intec-ui-part-content">
                                                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_PURCHASE_ORDER_FAST') ?>
                                            </div>
                                        <?= Html::endTag('div') ?>
                                    <?php } ?>
                                </div>
                                <?php if ($arResult['DELIVERY_CALCULATION']['USE']) { ?>
                                    <div class="intec-grid intec-grid-wrap intec-grid-a-h-end intec-grid-a-h-550-start">
                                        <div class="intec-grid-item-auto">
                                            <?php include(__DIR__.'/delivery.calculation.php') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?= Html::endTag('div') ?>
                    <?= Html::endTag('div') ?>
                <?php } ?>
            </div>
        </div>
    </div>
<?= Html::endTag('div') ?>
<?php if ($arVisual['TIMER']['SHOW']) { ?>
    <?php include(__DIR__ . '/sku.list.timer_script.php'); ?>
<?php } ?>
<?php unset($vButtons, $vOrder) ?>

