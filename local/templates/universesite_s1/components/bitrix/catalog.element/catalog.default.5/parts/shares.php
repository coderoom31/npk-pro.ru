<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var array $arSvg
 */

$sPrefix = 'SHARES_';

if (empty($arResult['SHARES']['ITEMS']))
    return null;
?>
    <div class="catalog-element-shares">
        <div class="intec-grid intec-grid-nowrap intec-grid-a-v-start intec-grid-i-h-4">
            <div class="intec-grid-item-auto">
                <div class="catalog-element-shares-icon intec-cl-svg">
                    <?= $arSvg['SHARES'] ?>
                </div>
            </div>
            <div class="catalog-element-shares-items intec-grid-item-auto intec-grid-item-shrink-1">
                <?php if ($arVisual['SHARES']['SHOW'] && !empty($arVisual['SHARES']['HEADER'])) { ?>
                    <div class="catalog-element-shares-items-header">
                        <?= $arVisual['SHARES']['HEADER'] ?>
                    </div>
                <?php } ?>
                <?php foreach ($arResult['SHARES']['ITEMS'] as $arSharesItem) { ?>
                    <?php
                    $arShares = [
                        'component' => 'intec.universe:main.widget',
                        'template' => 'catalog.shares.1',
                        'parameters' => [
                            'IBLOCK_ID' => $arSharesItem['IBLOCK_ID'],
                            'ELEMENT_ID' => $arSharesItem['ID'],
                            'DISCOUNT_SHOW' => $arParams[$sPrefix.'DISCOUNT_SHOW'],
                            'PROPERTY_DISCOUNT' => $arParams[$sPrefix.'PROPERTY_DISCOUNT'],
                            'DISCOUNT_MINUS_USE' => $arParams[$sPrefix.'DISCOUNT_MINUS_USE'],
                            'DATE_SHOW_FROM' => $arParams[$sPrefix.'DATE_SHOW_FROM'],
                            'DATE_FORMAT' => $arParams[$sPrefix.'DATE_FORMAT'],
                            'PROPERTY_DATE' => $arParams[$sPrefix.'PROPERTY_DATE'],
                            'DATE_ONLY_ONE_SHOW' => $arParams[$sPrefix.'DATE_ONLY_ONE_SHOW'],
                            'TIMER_SHOW' => $arParams[$sPrefix.'TIMER_SHOW'],
                            'TIMER_SECONDS_SHOW' => $arParams[$sPrefix.'TIMER_SECONDS_SHOW'],
                            'TIMER_END_HIDE' => $arParams[$sPrefix.'TIMER_END_HIDE'],
                            'TEXT_USE' => $arParams[$sPrefix.'TEXT_USE'],
                            'ALL_TEXT_SHOW' => $arParams[$sPrefix.'ALL_TEXT_SHOW'],
                            'BUTTON_SHOW' => $arParams[$sPrefix.'BUTTON_SHOW'],
                            'BUTTON_TEXT' => $arParams[$sPrefix.'BUTTON_TEXT']
                        ],
                        'settings' => [
                            'title' => $arSharesItem['NAME'],
                            'parameters' => [
                                'width' => 580,
                                'max-height' =>  680
                            ]
                        ]
                    ];
                    $arSharesJS = JavaScript::toObject($arShares);
                    ?>
                    <?= Html::tag('div', $arSharesItem['NAME'], [
                        'class' => [
                            'catalog-element-shares-name',
                            'intec-cl-text-hover',
                            'intec-cl-border-hover'
                        ],
                        'onclick' => 'template.api.components.show('.$arSharesJS.');'
                    ]) ?>
                <?php } ?>
            </div>
        </div>
    </div>
<?php unset($arSizes) ?>