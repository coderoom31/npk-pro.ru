<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arBlocks = $arResult['BLOCKS'];
$arVisual = $arResult['VISUAL'];

?>
<div class="widget c-reviews c-reviews-template-12" id="<?= $sTemplateId ?>">
    <div class="widget-wrapper intec-content">
        <div class="widget-wrapper-2 intec-content-wrapper intec-grid intec-grid-important intec-grid-800-wrap">
            <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['DESCRIPTION']['SHOW']) { ?>
                <div class="widget-header widget-content-left intec-grid-item-4 intec-grid-item-950-3 intec-grid-item-800-1">
                    <?php if ($arBlocks['HEADER']['SHOW']) { ?>
                        <div class="widget-title intec-grid-item-auto align-<?= $arBlocks['HEADER']['POSITION'] ?>">
                            <?= Html::encode($arBlocks['HEADER']['TEXT']) ?>
                        </div>
                    <?php } ?>
                    <?php if ($arBlocks['DESCRIPTION']['SHOW']) { ?>
                        <div class="widget-description align-<?= $arBlocks['DESCRIPTION']['POSITION'] ?>">
                            <?= Html::encode($arBlocks['DESCRIPTION']['TEXT']) ?>
                        </div>
                    <?php } ?>
                    <?php if ($arVisual['BUTTON_SHOW_ALL']['SHOW']) { ?>
                        <?= Html::tag('a', $arVisual['BUTTON_SHOW_ALL']['TEXT'], [
                            'href' => $arVisual['BUTTON_SHOW_ALL']['LINK'],
                            'class' => [
                                'widget-link-all',
                                'intec-cl-text-hover'
                            ],
                            'style' => [
                                'text-align' => $arParams['BUTTON_ALL_POSITION']
                            ]
                        ]) ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="widget-content-right intec-grid-item">
                <?= Html::beginTag('div', [
                    'class' => [
                        'widget-items',
                        'owl-carousel'
                    ],
                    'data' => [
                        'role' => 'container'
                    ]
                ]) ?>
                    <?php foreach ($arResult['ITEMS'] as $arItem) {

                        if (empty($arItem['PREVIEW_TEXT']) && empty($arItem['DETAIL_TEXT']))
                            continue;

                        $sId = $sTemplateId.'_'.$arItem['ID'];
                        $sAreaId = $this->GetEditAreaId($sId);
                        $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                        $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                        $arData = $arItem['DATA'];
                        $sPicture = $arItem['PREVIEW_PICTURE'];

                        if (empty($sPicture))
                            $sPicture = $arItem['DETAIL_PICTURE'];

                        if (!empty($sPicture)) {
                            $sPicture = CFile::ResizeImageGet($sPicture, [
                                    'width' => 64,
                                    'height' => 64
                                ], BX_RESIZE_IMAGE_PROPORTIONAL_ALT
                            );

                            if (!empty($sPicture))
                                $sPicture = $sPicture['src'];
                        }

                        if (!empty($arItem['PREVIEW_TEXT']))
                            $sText = $arItem['PREVIEW_TEXT'];
                        else
                            $sText = $arItem['DETAIL_TEXT'];

                        if (!empty($sText) && $arParams['SLIDER_SHORT_TEXT'] === 'Y')
                            $sText = StringHelper::cut($sText, 0, 140).'...';

                        $sTag = !empty($arItem['DETAIL_PAGE_URL']) && $arVisual['LINK']['USE'] ? 'a' : 'div';

                    ?>
                        <div class="widget-item intec-grid-item" id="<?= $sAreaId ?>">
                            <div class="intec-grid intec-grid-nowrap intec-grid-o-vertical intec-grid-a-h-start widget-item-wrapper">
                                <div class="intec-grid-item-auto intec-grid intec-grid-a-v-center intec-grid-i-h-8 intec-grid-i-v-5 intec-grid-wrap">
                                    <div class="widget-item-image-wrap intec-grid-item-auto">
                                        <?= Html::tag($sTag, '', [
                                            'href' => $sTag === 'a' ? $arItem['DETAIL_PAGE_URL'] : null,
                                            'class' => 'widget-item-image',
                                            'target' => $sTag === 'a' && $arVisual['LINK']['BLANK'] ? '_blank' : null,
                                            'data' => [
                                                'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                                'original' => $arVisual['LAZYLOAD']['USE'] ? $sPicture : null
                                            ],
                                            'style' => [
                                                'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$sPicture.'\')' : null
                                            ]
                                        ]) ?>
                                    </div>
                                    <div class="widget-item-name-wrap intec-grid-item">
                                        <?php if ($arVisual['ACTIVE_DATE']['SHOW']) { ?>
                                            <div class="widget-item-date">
                                                <?= $arItem['DISPLAY_ACTIVE_FROM'];?>
                                            </div>
                                        <?php } ?>
                                        <?= Html::tag($sTag, $arItem['NAME'], [
                                            'href' => $sTag === 'a' ? $arItem['DETAIL_PAGE_URL'] : null,
                                            'class' => 'widget-item-name',
                                            'target' => $sTag === 'a' && $arVisual['LINK']['BLANK'] ? '_blank' : null
                                        ]) ?>
                                    </div>
                                    <?php if ($arVisual['RATING']['SHOW'] && !empty($arData['RATING'])) {?>
                                        <div class="intec-grid-item-auto intec-grid-item-600-1">
                                            <div class="widget-item-rating-wrap intec-grid intec-grid-i-h-3">
                                                <?php for ($countStar = 1; $countStar <= $arVisual['RATING']['MAX']; $countStar++) { ?>
                                                    <?= Html::beginTag('div', [
                                                        'class' => Html::cssClassFromArray([
                                                            'intec-grid-item-auto' => true,
                                                            'widget-item-rating' => [
                                                                '' => true,
                                                                'active' => ($countStar <= $arData['RATING'])
                                                            ]
                                                        ], true)
                                                    ])?>
                                                        <i class="intec-ui-icon intec-ui-icon-star-1"></i>
                                                    <?= Html::endTag('div') ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="intec-grid-item-auto widget-item-description">
                                    <?= $sText ?>
                                </div>
                                <?php if ($arVisual['LINK']['USE'] && !empty($arParams['LINK_TEXT'])) { ?>
                                    <div class="intec-grid-item-auto widget-item-link-detail">
                                        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="widget-item-link-detail-button intec-ui intec-ui-control-button intec-ui-mod-transparent intec-ui-scheme-current">
                                            <?= $arParams['LINK_TEXT'] ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?= Html::endTag('div') ?>
            </div>
        </div>
    </div>
    <?php include(__DIR__.'/parts/script.php') ?>
</div>