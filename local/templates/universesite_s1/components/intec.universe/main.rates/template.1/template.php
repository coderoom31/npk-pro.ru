<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arBlocks = $arResult['BLOCKS'];
$arVisual = $arResult['VISUAL'];
$arForm = $arResult['FORM'];
$arForm['PARAMETERS'] = [
    'id' => $arForm['ID'],
    'template' => $arForm['TEMPLATE'],
    'parameters' => [
        'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_FORM_ORDER',
        'CONSENT_URL' => $arForm['CONSENT']
    ],
    'settings' => [
        'title' => $arForm['TITLE']
    ],
    'fields' => [
        $arForm['FIELD'] => null
    ]
];

/**
 * @var Closure $vItems()
 */
include(__DIR__.'/parts/items.php')

?>
<div class="widget c-rates c-rates-template-1-1" id="<?= $sTemplateId ?>">
    <div class="widget-wrapper intec-content intec-content-visible">
        <div class="widget-wrapper-2 intec-content-wrapper">
            <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['DESCRIPTION']['SHOW']) { ?>
                <div class="widget-header">
                    <?php if ($arBlocks['HEADER']['SHOW']) { ?>
                        <div class="widget-title align-<?= $arBlocks['HEADER']['POSITION'] ?>">
                            <?= Html::encode($arBlocks['HEADER']['TEXT']) ?>
                        </div>
                    <?php } ?>
                    <?php if ($arBlocks['DESCRIPTION']['SHOW']) { ?>
                        <div class="widget-description align-<?= $arBlocks['DESCRIPTION']['POSITION'] ?>">
                            <?= Html::encode($arBlocks['DESCRIPTION']['TEXT']) ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="widget-content">
                <?php if ($arVisual['VIEW'] === 'tabs') {
                    include(__DIR__.'/parts/tabs.php');
                } else {
                    $vItems($arResult['ITEMS']);
                } ?>
            </div>
        </div>
    </div>
    <?php if ($arVisual['SLIDER']['USE'] || $arForm['SHOW'])
        include(__DIR__.'/parts/script.php');
    ?>
</div>