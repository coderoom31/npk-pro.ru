<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arHeader = ArrayHelper::getValue($arResult, 'HEADER_BLOCK');
$arDescription = ArrayHelper::getValue($arResult, 'DESCRIPTION_BLOCK');
$arFooter = ArrayHelper::getValue($arResult, 'FOOTER_BLOCK');
$arVisual = ArrayHelper::getValue($arResult, 'VISUAL');
$arCodes = ArrayHelper::getValue($arResult, 'PROPERTY_CODES');

$arNavigation = $arResult['NAVIGATION'];

$iElementCount = 1;
$arClasses = [];

$sElementTag = $arVisual['LINK_USE']?'a':'div';
?>
<div class="widget c-shares c-shares-template-1" id="<?= $sTemplateId ?>">
    <div class="widget-wrapper intec-content">
        <div class="widget-wrapper-2 intec-content-wrapper">
            <?php if ($arHeader['SHOW'] || $arDescription['SHOW']) { ?>
                <div class="widget-header">
                    <?php if ($arHeader['SHOW']) { ?>
                        <div class="widget-title align-<?= $arHeader['POSITION'] ?>">
                            <?= $arHeader['TEXT'] ?>
                        </div>
                    <?php } ?>
                    <?php if ($arDescription['SHOW']) { ?>
                        <div class="widget-description align-<?= $arDescription['POSITION'] ?>">
                            <?= $arDescription['TEXT'] ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?= Html::beginTag('div', [
                'class' => Html::cssClassFromArray([
                    'widget-content',
                    'intec-grid' => [
                        '',
                        'wrap',
                        'a-v-stretch',
                        'a-h-start',
                        'i-7'
                    ]
                ]),
                'data-role' => 'items'
            ]) ?>
                <!--items-->
                <?php foreach ($arResult['ITEMS'] as $arItem) {

                    $sId = $sTemplateId.'_'.$arItem['ID'];
                    $sAreaId = $this->GetEditAreaId($sId);
                    $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                    $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                    $sName = ArrayHelper::getValue($arItem, 'NAME');
                    $sDescription = ArrayHelper::getValue($arItem, 'PREVIEW_TEXT');
                    $sPicture = ArrayHelper::getValue($arItem, ['PREVIEW_PICTURE', 'SRC']);
                    $sDetailPageUrl = ArrayHelper::getValue($arItem, 'DETAIL_PAGE_URL');

                    $arClasses = [
                        'widget-element-wrap',
                        'intec-grid-item' => [
                            $arVisual['LINE_COUNT'],
                            '1000-2',
                            '550-1'
                        ]
                    ];

                    $sDate = null;
                    $sDateFrom = $arItem['DISPLAY_ACTIVE_FROM'];
                    $sDateTo = $arItem["DISPLAY_ACTIVE_TO"];

                    if (!empty($sDateFrom)) {
                        $sDate = GetMessage('C_SHARES_TEMP1_DEFAULT_DATE_FROM').' '.$sDateFrom;

                        if (!empty($sDateTo))
                            $sDate .= ' '.GetMessage('C_SHARES_TEMP1_DEFAULT_DATE_TO_SMALL').' '.$sDateTo;
                    } else if (!empty($sDateTo)) {
                        $sDate = GetMessage('C_SHARES_TEMP1_DEFAULT_DATE_TO').' '.$sDateTo;
                    }
                ?>
                    <?= Html::beginTag('div', [
                        'class' => Html::cssClassFromArray($arClasses)
                    ]) ?>
                        <div class="widget-element" id="<?= $sAreaId ?>">
                            <?= Html::tag($sElementTag, '', [
                                'class' => [
                                    'widget-element-picture',
                                    'intec-image-effect'
                                ],
                                'data' => [
                                    'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                    'original' => $arVisual['LAZYLOAD']['USE'] ? $sPicture : null
                                ],
                                'style' => [
                                    'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$sPicture.'\')' : null
                                ],
                                'href' => $arVisual['LINK_USE']?$sDetailPageUrl:null
                            ]) ?>
                            <div class="widget-element-text">
                                <?php if ($arVisual['DATE_SHOW']) { ?>
                                    <div class="widget-element-date">
                                        <?= $sDate ?>
                                    </div>
                                <?php } ?>
                                <div class="widget-element-name">
                                    <?= Html::tag($sElementTag, $sName, [
                                        'class' => [
                                            'widget-element-name-wrapper',
                                            'intec-cl-text-hover'
                                        ],
                                        'href' => $arVisual['LINK_USE']?$sDetailPageUrl:null
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    <?= Html::endTag('div') ?>
                <?php } ?>
                <!--items-->
            <?= Html::endTag('div') ?>
            <?php if ($arNavigation['USE']) { ?>
                <div class="widget-pagination">
                    <!--navigation-->
                    <?= $arNavigation['PRINT'] ?>
                    <!--navigation-->
                </div>
            <?php } ?>
            <?php if ($arFooter['SHOW']) { ?>
                <div class="widget-footer align-<?= $arFooter['POSITION'] ?>">
                    <a class="widget-footer-all intec-cl-border intec-cl-background-hover" href="<?= $arFooter['LIST_PAGE'] ?>">
                        <?= $arFooter['TEXT'] ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if ($arNavigation['USE'] && $arNavigation['MODE'] === 'ajax' && !defined('EDITOR'))
        include(__DIR__.'/parts/script.php');
    ?>
</div>