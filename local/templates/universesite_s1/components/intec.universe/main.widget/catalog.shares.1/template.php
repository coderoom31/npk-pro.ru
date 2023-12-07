<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;
use intec\core\bitrix\Component;

if (!Loader::includeModule('intec.core'))
    return;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 */
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$arVisual['TIMER']['SECONDS']['SHOW'] = true;
$arVisual = $arResult['VISUAL'];
$sTimerStatus = $arVisual['TIMER']['SECONDS']['SHOW'] ? 'true' : 'false';

$sLink = $arResult['ITEM']['DETAIL_PAGE_URL'];

?>
    <div class="widget c-widget c-widget-catalog-shares-1" id="<?= $sTemplateId ?>">
        <div class="widget-content">
            <div class="shares-status intec-grid intec-grid-a-v-center">
                <?php if ($arVisual['DISCOUNT']['SHOW']) { ?>
                    <div class="shares-status-item shares-status-item-discount">
                        <?= $arVisual['DISCOUNT']['VALUE'] ?>
                    </div>
                <?php } ?>
                <?php if ($arVisual['TIMER']['SHOW']) { ?>
                    <div class="shares-status-item shares-status-item-timer intec-grid" data-status="<?= $sTimerStatus ?>">
                        <span class="shares-timer-day-value" data-role="days"> </span>
                        <span class="shares-timer-day-title">
                        <?= Loc::getMessage('C_MAIN_WIDGET_CATALOG_SHARES_1_TIMER_DAYS_TITLE')?>
                    </span>
                        <span class="shares-delimiter"> : </span>
                        <span class="shares-timer-hour-value" data-role="hours"> </span>
                        <span class="shares-timer-hour-title">
                        <?= Loc::getMessage('C_MAIN_WIDGET_CATALOG_SHARES_1_TIMER_HOURS_TITLE')?>
                    </span>
                        <span class="shares-delimiter"> : </span>
                        <span class="shares-timer-minute-value" data-role="minutes"> </span>
                        <span class="shares-timer-minute-title">
                        <?= Loc::getMessage('C_MAIN_WIDGET_CATALOG_SHARES_1_TIMER_MINUTES_TITLE')?>
                    </span>
                        <?php if ($arVisual['TIMER']['SECONDS']['SHOW']) { ?>
                            <span class="shares-delimiter"> : </span>
                            <span class="shares-timer-second-value" data-role="seconds"> </span>
                            <span class="shares-timer-second-title">
                            <?= Loc::getMessage('C_MAIN_WIDGET_CATALOG_SHARES_1_TIMER_SECONDS_TITLE')?>
                        </span>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($arVisual['DATE']['SHOW']) { ?>
                    <div class="shares-status-item shares-status-item-date intec-grid intec-grid-a-v-center">
                        <div class="shares-status-item-date-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                <path d="M8.97921 5.75204L5.47279 10.8171C5.15137 11.2809 4.42396 11.054 4.42396 10.4893V7.15088H1.49271C1.02837 7.15088 0.754789 6.62938 1.01962 6.24729L4.52604 1.18221C4.84746 0.718461 5.57487 0.945377 5.57487 1.51004V4.84846H8.50612C8.96987 4.84846 9.24346 5.36996 8.97921 5.75204Z" fill="#FF2D55"/>
                            </svg>
                        </div>
                        <div class="shares-status-item-date-text">
                            <?= $arVisual['DATE']['VALUE'] ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?= Html::tag('div', $arVisual['TEXT']['VALUE'], [
                'class' => [
                    'shares-text',
                    $arVisual['TEXT']['ALL'] ? 'scrollbar-outer' : null
                ],
                'data-role' => $arVisual['TEXT']['ALL'] ? 'scrollbar' : null
            ]) ?>
            <?php if ($arVisual['BUTTON']['SHOW'] && !empty($sLink)) { ?>
                <div class="shares-button-wrapper">
                    <a class="shares-button intec-ui intec-ui-control-button intec-ui-mod-round-2 intec-ui-scheme-current" href="<?= $sLink ?>">
                        <?= $arVisual['BUTTON']['VALUE']?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php if ($arVisual['TIMER']['SHOW']) { ?>
    <?php include(__DIR__.'/parts/script.php'); ?>
<?php } ?>