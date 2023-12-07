<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var array $arResult
 * @var array $arParams
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-section',
        'c-catalog-section-products-additional-1'
    ],
    'data' => [
        'trigger' => $arResult['TRIGGER']
    ]
]) ?>
    <div class="catalog-section-items" data-role="items">
        <?php foreach ($arResult['ITEMS'] as $arItem) {

            if (!$arItem['CAN_BUY'])
                continue;

            $arPrice = null;

            if (!empty($arItem['ITEM_PRICES']))
                $arPrice = $arItem['ITEM_PRICES'][0];
        ?>
            <?= Html::beginTag('div', [
                'class' => 'catalog-section-item',
                'data' => [
                    'role' => 'item',
                    'basket-id' => $arItem['ID'],
                    'basket-state' => 'none',
                    'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                ]
            ]) ?>
                <?= Html::beginTag('label', [
                    'class' => [
                        'intec-ui' => [
                            '',
                            'control-switch',
                            'scheme-current',
                            'size-2'
                        ]
                    ]
                ]) ?>
                    <input type="checkbox" data-role="item.input">
                    <span class="intec-ui-part-selector"></span>
                    <span class="intec-ui-part-content">
                        <?= $arItem['NAME'] ?>
                        <?php if (!empty($arPrice)) { ?>
                            + <?= $arPrice['PRINT_PRICE'] ?>
                        <?php } ?>
                    </span>
                <?= Html::endTag('label') ?>
            <?= Html::endTag('div') ?>
        <?php } ?>
    </div>
    <script type="text/javascript">
        template.load(function (data) {
            var app = this;
            var $ = this.getLibrary('$');
            var _ = this.getLibrary('_');
            var root = data.nodes;
            var items = $('[data-role="items"] [data-role="item"]', root);
            var trigger = root.data('trigger');

            app.api.basket.on('add', function (data) {
                if (data[trigger] === true && data.delay !== 'Y') {
                    var actions = [];

                    items.each(function () {
                         var item = $(this);
                         var input = $('[data-role="item.input"]', item);
                         var id = item.attr('data-basket-id');
                         var price = item.attr('data-basket-price');
                         var state = item.attr('data-basket-state');

                         if (state === 'none' && input.prop('checked')) {
                             actions.push(app.api.basket.add({
                                 'id': id,
                                 'price': price
                             }));
                         }
                    });

                    if (actions.length > 0)
                        app.api.runActions(actions);
                }
            });
        }, {
            'name': '[Component] bitrix:catalog.section (products.additional.1)',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?= Html::endTag('div') ?>