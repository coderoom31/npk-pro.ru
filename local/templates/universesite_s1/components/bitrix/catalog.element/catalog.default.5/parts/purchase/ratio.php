<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var array $arVisual
 */

?>
<?= Html::beginTag('div', [
    'class' => 'catalog-element-ratio'
]) ?>
    <div class="intec-grid intec-grid-wrap intec-grid-a-v-center intec-grid-i-h-12 intec-grid-i-v-8">
        <?= Html::beginTag('div', [
            'class' => Html::cssClassFromArray([
                'intec-grid-item' => $arVisual['MEASURES']['POSITION'] !== 'bottom',
                'intec-grid-item-3' => $arVisual['MEASURES']['POSITION'] === 'bottom',
                'intec-grid-item-450-1' => true
            ], true)
        ]) ?>
            <div class="catalog-element-ratio-content">
                <?= Html::beginTag('div', [
                    'class' => [
                        'catalog-element-ratio-message',
                        'catalog-element-ratio-part',
                        'catalog-element-ratio-text'
                    ]
                ]) ?>
                    <?= Loc::getMessage('C_CATALOG_ELEMENT_DEFAULT_5_TEMPLATE_MEASURES_MULTIPLICITY_ORDER') ?>
                <?= Html::endTag('div') ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'catalog-element-ratio-value',
                        'catalog-element-ratio-part',
                        'catalog-element-ratio-text',
                        'intec-cl-text',
                    ],
                    'data-role' => 'ratio'
                ]) ?>
                    <span data-role="ratio.value">
                        <?= $arResult['CATALOG_MEASURE_RATIO'] ?>
                    </span>
                    <span data-role="ratio.measure">
                        <?= $arResult['CATALOG_MEASURE_NAME'] ?>
                    </span>
                <?= Html::endTag('div') ?>
            </div>
        <?= Html::endTag('div') ?>
        <?php if ($arVisual['MEASURES']['POSITION'] === 'bottom') { ?>
            <div class="intec-grid-item intec-grid-item-450-1">
                <?php include(__DIR__.'/measures.php') ?>
            </div>
        <?php } ?>
    </div>
<?= Html::endTag('div') ?>