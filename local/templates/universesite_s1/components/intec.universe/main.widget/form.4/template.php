<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Html;

/**
 * @var $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (empty($arResult['WEB_FORM']))
    return;

$arVisual = $arResult['VISUAL'];
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'widget',
        'c-widget',
        'c-widget-form-4'
    ]
]) ?>
    <?php if (!$arVisual['WIDE']) { ?>
    <div class="intec-content">
        <div class="intec-content-wrapper">
    <?php } ?>
        <div class="widget-form intec-cl-background" data-borders="<?= $arVisual['BORDERS'] ?>">
            <div class="intec-content widget-form-wrapper">
                <div class="intec-content-wrapper widget-form-wrapper-2">
                    <div class="widget-form-title-wrap intec-grid intec-grid-a-v-center intec-grid-a-h-center">
                        <div class="widget-form-image" style="background-image: url('<?= $this->GetFolder().'/images/question_mark.png' ?>')"></div>
                        <div class="widget-form-title">
                            <div class="widget-form-title-wrapper">
                                <?= $arResult['FORM']['TITLE'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="widget-form-description-wrap intec-grid intec-grid-a-v-center intec-grid-a-h-center">
                        <div class="widget-form-description">
                            <?= $arResult['FORM']['DESCRIPTION'] ?>
                        </div>
                    </div>
                    <div class="widget-form-button-wrap intec-grid intec-grid-a-v-center intec-grid-a-h-center">
                        <?= Html::tag('div', $arResult['FORM']['BUTTON_TEXT'], [
                            'class' => [
                                'widget-form-button',
                                'intec-ui' => [
                                    '',
                                    'control-button',
                                    'size-2',
                                    'scheme-white',
                                    'mod-round-2',
                                    'mod-transparent'
                                ],
                                'intec-cl-text-hover'
                            ],
                            'data-role' => 'form'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php if (!$arVisual['WIDE']) { ?>
        </div>
    </div>
    <?php } ?>
    <?php include(__DIR__.'/parts/script.php') ?>
<?= Html::endTag('div') ?>
