<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

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

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$sTitle = $arResult['TEXT']['TITLE'];
$sDescription = $arResult['TEXT']['DESCRIPTION'];
$sButton = $arResult['TEXT']['BUTTON'];
$sForm = $arResult['TEXT']['FORM'];

?>
<div class="widget-web-form-2 intec-cl-background" id="<?= $sTemplateId ?>">
    <div class="intec-content widget-web-form-2-background intec-cl-background">
        <div class="intec-content-wrapper widget-web-form-2-background-wrapper">
            <div class="widget-web-form-2-section widget-web-form-2-title">
                <div class="widget-web-form-2-image" style="background-image: url('<?= $this->GetFolder().'/images/question_mark.png' ?>')"></div>
                <div class="widget-web-form-2-text-wrap">
                    <div class="widget-web-form-2-text">
                        <?= $sTitle ?>
                    </div>
                </div>
            </div>
            <div class="widget-web-form-2-section widget-web-form-2-description">
                <div class="widget-web-form-2-text">
                    <?= $sDescription ?>
                </div>
            </div>
            <div class="widget-web-form-2-section widget-web-form-2-button">
                <?= Html::tag('div', $sButton, [
                    'class' => [
                        'intec-ui',
                        'intec-ui-control-button',
                        'intec-ui-scheme-current',
                        'intec-ui-size-4',
                        'intec-ui-mod-transparent',
                        'intec-ui-state-hover'
                    ],
                    'data-role' => 'form'
                ]) ?>
            </div>
        </div>
    </div>
    <?php include(__DIR__.'/parts/script.php') ?>
</div>
