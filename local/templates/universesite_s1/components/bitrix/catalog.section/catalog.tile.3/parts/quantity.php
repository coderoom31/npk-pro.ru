<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 */

?>
<?php $vQuantity  = function (&$arItem) use (&$arVisual) { ?>
    <?php $fRender = function (&$arItem, $bOffer = false) use (&$arVisual) { ?>
        <?php if (!empty($arItem['OFFERS']) && !$bOffer) return ?>
        <?= Html::beginTag('div', [
            'class' => 'catalog-section-item-quantity',
            'data' => [
                'offer' => $bOffer ? $arItem['ID'] : 'false',
                'align' => $arVisual['QUANTITY']['ALIGN']
            ]
        ]) ?>
            <?php if ($arItem['CAN_BUY']) { ?>
                <span class="catalog-section-item-quantity-icon catalog-section-item-quantity-check">
                    <i class="far fa-check"></i>
                </span>
                <?php if ($arVisual['QUANTITY']['MODE'] === 'number') { ?>
                    <?php if ($arItem['CATALOG_QUANTITY'] > 0) { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_AVAILABLE').': ' ?>
                        <?= $arItem['CATALOG_QUANTITY'] ?>
                        <?php if (!empty($arItem['CATALOG_MEASURE_NAME'])) {
                            echo ' '.$arItem['CATALOG_MEASURE_NAME'];
                        } ?>
                    <?php } else if (($arItem['CATALOG_QUANTITY_TRACE'] === 'N' || $arItem['CATALOG_CAN_BUY_ZERO'] === 'Y') && $arItem['CATALOG_QUANTITY'] <= 0) { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_AVAILABLE') ?>
                    <?php } ?>
                <?php } else if ($arVisual['QUANTITY']['MODE'] === 'text') { ?>
                    <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_AVAILABLE').': ' ?>
                    <?php if ($arItem['CATALOG_QUANTITY'] > 0 && $arItem['CATALOG_QUANTITY'] <= $arVisual['QUANTITY']['BOUNDS']['FEW']) { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_BOUNDS_FEW') ?>
                    <?php } else if ($arItem['CATALOG_QUANTITY'] >= $arVisual['QUANTITY']['BOUNDS']['MANY']) { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_BOUNDS_MANY') ?>
                    <?php } else if ($arItem['CATALOG_QUANTITY'] > $arVisual['QUANTITY']['BOUNDS']['FEW'] && $arItem['CATALOG_QUANTITY'] < $arVisual['QUANTITY']['BOUNDS']['MANY']) { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_BOUNDS_ENOUGH') ?>
                    <?php } else if ($arItem['CATALOG_QUANTITY_TRACE'] === 'N' || $arItem['CATALOG_CAN_BUY_ZERO'] === 'Y') { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_BOUNDS_MANY') ?>
                    <?php } ?>
                <?php } else if ($arVisual['QUANTITY']['MODE'] === 'logic') { ?>
                    <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_AVAILABLE') ?>
                <?php } ?>
            <?php } else { ?>
                <span class="catalog-section-item-quantity-icon catalog-section-item-quantity-times">
                    <i class="far fa-times"></i>
                </span>
                <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_QUANTITY_UNAVAILABLE'); ?>
            <?php } ?>
        <?= Html::endTag('div') ?>
    <?php } ?>
    <?php $fRender($arItem, false) ?>
    <?php if ($arVisual['OFFERS']['USE'] && !empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer)
            $fRender($arOffer, true)
    ?>
<?php } ?>