<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Html;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];

$bShowSeconds = $arVisual['BLOCKS']['SECONDS'];
$bQuantityShow = $arVisual['QUANTITY']['SHOW'];

$arTimerBlocks = [
    'days',
    'hours',
    'minutes'
];

if ($bShowSeconds)
    $arTimerBlocks[] = 'seconds';

$sStatus = $arResult['DATE']['STATUS'];

$sDataStatus = empty($sStatus) ? 'enable' : 'disable';

?>
<div class="widget c-product-timer c-product-timer-template-1" id="<?= $sTemplateId ?>"  data-role="timer" data-status="<?= $sDataStatus ?>">
    <?php if ($sStatus === 'incorrect') { ?>
        <div class="widget-error">
            <?= Loc::getMessage('C_PRODUCT_TIMER_TEMPLATE_1_INCORRECT_DATE') ?>
        </div>
    <?php } ?>
    <?php if (empty($sStatus) || ($sStatus === 'passed' && !$arResult['DATA']['TIMER']['ZERO'])) { ?>
        <?php if ($arVisual['TITLE']['SHOW']) { ?>
            <div class="widget-title"><?= $arVisual['TITLE']['VALUE'] ?></div>
        <?php } ?>
        <div class="widget-content">
            <div class="widget-product-timer-item-date-end" data-role="date-end"><?= $arResult['DATE']['END'] ?></div>
            <div class="widget-product-timer-wrapper intec-grid intec-grid-a-v-end intec-grid-i-h-4">
                <div class="intec-grid-item widget-product-timer-item-time-wrapper" data-seconds="<?= $bShowSeconds ? 'true' : 'false'; ?>">
                    <?php if ($arVisual['HEADER']['SHOW']) { ?>
                        <div class="widget-product-timer-header">
                            <?= $arVisual['HEADER']['VALUE'] ?>
                        </div>
                    <?php } ?>
                    <div class="widget-product-timer-items intec-grid intec-grid-i-h-2">
                        <?php foreach ($arTimerBlocks as $key => $value) { ?>
                            <div class="widget-product-timer-item-wrapper intec-grid-item-<?= $bShowSeconds ? 4 : 3 ?>">
                                <div class="widget-product-timer-item-block">
                                    <div class="widget-product-timer-item-wrapper-2">
                                        <div class="widget-product-timer-item-time" data-role="<?= $value ?>">
                                            <?= $arResult['DATE']['REMAINING'][$key] ?>
                                        </div>
                                        <div class="widget-product-timer-item-description">
                                            <?= Loc::getMessage('C_PRODUCT_TIMER_TEMPLATE_1_UNTIL_THE_END_' . StringHelper::toUpperCase($value)) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <?php if ($bQuantityShow) { ?>
                    <div class="intec-grid-item widget-product-timer-item-quntity-wrapper">
                        <?php if ($arVisual['QUANTITY']['HEADER']['SHOW']) { ?>
                            <div class="widget-product-timer-header">
                                <?= $arVisual['QUANTITY']['HEADER']['VALUE'] ?>
                            </div>
                        <?php } ?>
                        <div class="widget-product-timer-items">
                            <div class="widget-product-timer-item-block timer-quantity">
                                <div class="widget-product-timer-item-wrapper-2">
                                    <div class="widget-product-timer-item-time" data-role="timer-quantity">
                                        <?= $arResult['DATA']['TIMER']['PRODUCT']['QUANTITY']; ?>
                                    </div>
                                    <div class="widget-product-timer-item-description">
                                        <?= Loc::getMessage('C_PRODUCT_TIMER_TEMPLATE_1_UNTIL_QUANTITY_VALUE') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php if (empty($sStatus) && !$arVisual['SECTION']) { ?>
    <?php include(__DIR__.'/parts/script.php'); ?>
<?php } ?>