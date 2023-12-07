<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Json;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CAllMain $APPLICATION
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (!Loader::includeModule('intec.core'))
    return;

$bBase = false;

if (Loader::includeModule('catalog') && Loader::includeModule('sale'))
    $bBase = true;

if ($bBase)
    CJSCore::Init(array('currency'));

if (!Loader::includeModule('intec.core'))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$arBlocks = $arResult['BLOCKS'];
$arVisual = $arResult['VISUAL'];

if (empty($arResult['ITEMS']) || empty($arResult['CATEGORIES']))
    return;

/**
 * @var Closure $vCounter
 * @var Closure $dData
 * @var Closure $vButtons
 * @var Closure $vImage
 * @var Closure $vPrice
 * @var Closure $vPurchase
 * @var Closure $vQuantity
 * @var Closure $vSku
 * @var Closure $vSkuExtended
 * @var Closure $vQuickView
 */
include(__DIR__.'/parts/counter.php');
include(__DIR__.'/parts/data.php');
include(__DIR__.'/parts/buttons.php');
include(__DIR__.'/parts/image.php');
include(__DIR__.'/parts/bigImage.php');
include(__DIR__.'/parts/price.php');
include(__DIR__.'/parts/purchase.php');
include(__DIR__.'/parts/quantity.php');
include(__DIR__.'/parts/sku.php');

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'widget',
        'c-widget',
        'c-widget-products-4'
    ],
    'data' => [
        'borders' => $arVisual['BORDERS']['USE'] ? 'true' : 'false',
        'columns-desktop' => $arVisual['COLUMNS']['DESKTOP'],
        'columns-mobile' => $arVisual['COLUMNS']['MOBILE'],
        'properties' => !empty($arResult['SKU_PROPS']) ? Json::encode($arResult['SKU_PROPS'], JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true) : '',
        'button' => $arResult['ACTION'] !== 'none' ? 'true' : 'false',
        'tabs' => $arResult['MODE'] === 'all' || $arResult['MODE'] === 'categories' ? 'true' : 'false',
    ]
]) ?>
    <div class="widget-wrapper intec-content intec-content-visible">
        <div class="widget-wrapper-2 intec-content-wrapper">
            <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['DESCRIPTION']['SHOW']) { ?>
                <div class="widget-header">
                    <?php if ($arBlocks['HEADER']['SHOW']) { ?>
                        <div class="<?= Html::cssClassFromArray([
                            'widget-title',
                            'align-'.$arBlocks['HEADER']['ALIGN']
                        ]) ?>">
                            <?= Html::encode($arBlocks['HEADER']['TEXT']) ?>
                        </div>
                    <?php } ?>
                    <?php if ($arBlocks['DESCRIPTION']['SHOW']) { ?>
                        <div class="<?= Html::cssClassFromArray([
                            'widget-description',
                            'align-'.$arBlocks['DESCRIPTION']['ALIGN']
                        ]) ?>">
                            <?= Html::encode($arBlocks['DESCRIPTION']['TEXT']) ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="widget-content">
                <?php if ($arResult['MODE'] === 'all' || $arResult['MODE'] === 'categories') { ?>
                    <?php if ($arVisual['VIEW'] === 'tabs') { ?>
                        <?= Html::beginTag('ul', [
                            'class' => [
                                'widget-tabs',
                                'intec-ui' => [
                                    '',
                                    'control-tabs',
                                    'mod-block',
                                    'mod-position-'.$arVisual['TABS']['ALIGN'],
                                    'scheme-current',
                                    'view-1'
                                ]
                            ],
                            'data' => [
                                'ui-control' => 'tabs'
                            ]
                        ]) ?>
                            <?php $iCounter = 0 ?>
                            <?php foreach ($arResult['CATEGORIES'] as $arCategory) { ?>
                                <?= Html::beginTag('li', [
                                    'class' => 'intec-ui-part-tab',
                                    'data' => [
                                        'active' => $iCounter === 0 ? 'true' : 'false'
                                    ]
                                ]) ?>
                                    <a href="<?= '#'.$sTemplateId.'-tab-'.$iCounter ?>" data-type="tab">
                                        <?= $arCategory['NAME'] ?>
                                    </a>
                                <?= Html::endTag('li') ?>
                                <?php $iCounter++ ?>
                            <?php } ?>
                        <?= Html::endTag('ul') ?>
                        <div class="widget-tabs-content intec-ui intec-ui-control-tabs-content">
                            <?php $iCounter = 0 ?>
                            <?php foreach ($arResult['CATEGORIES'] as $arCategory) { ?>
                                <?= Html::beginTag('div', [
                                    'id' => $sTemplateId.'-tab-'.$iCounter,
                                    'class' => 'intec-ui-part-tab',
                                    'data' => [
                                        'active' => $iCounter === 0 ? 'true' : 'false'
                                    ]
                                ]) ?>
                                    <?php $arBanner = &$arCategory['BANNER'] ?>
                                    <?php $arItems = &$arCategory['ITEMS'] ?>
                                    <?php include(__DIR__.'/parts/items.php') ?>
                                <?= Html::endTag('div') ?>
                                <?php $iCounter++ ?>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="widget-sections">
                            <?php foreach ($arResult['CATEGORIES'] as $arCategory) { ?>
                                <div class="widget-section">
                                    <?php if ($arVisual['SECTIONS']['TITLE']['SHOW']) { ?>
                                        <?= Html::tag('div', $arCategory['NAME'], [
                                            'class' => [
                                                'widget-section-name',
                                                'intec-template-part',
                                                'intec-template-part-title'
                                            ],
                                            'data' => [
                                                'align' => $arVisual['SECTIONS']['TITLE']['ALIGN']
                                            ]
                                        ]) ?>
                                    <?php } ?>
                                    <div class="widget-section-content">
                                        <?php $arBanner = &$arCategory['BANNER'] ?>
                                        <?php $arItems = &$arCategory['ITEMS'] ?>
                                        <?php include(__DIR__.'/parts/items.php') ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } else if ($arResult['MODE'] === 'category') { ?>
                    <?php $arCategory = null; ?>
                    <?php $arBanner = &$arResult['BANNER'] ?>
                    <?php $arItems = &$arResult['ITEMS'] ?>
                    <?php include(__DIR__.'/parts/items.php') ?>
                <?php } ?>
                <?php if (!defined('EDITOR')) include(__DIR__.'/parts/script.php') ?>
                <?php if ($arVisual['TIMER']['SHOW']) { ?>
                    <?php include(__DIR__ . '/parts/timer_script.php'); ?>
                <?php } ?>
            </div>
        </div>
    </div>
<?= Html::endTag('div') ?>
