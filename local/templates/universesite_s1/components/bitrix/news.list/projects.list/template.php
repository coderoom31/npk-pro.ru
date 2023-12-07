<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

?>
<div class="ns-bitrix c-news-list c-news-list-projects-list">
    <div class="intec-content">
        <div class="intec-content-wrapper">
            <?= Html::beginTag('ul', [
                'class' => [
                    'news-list-tabs',
                    'intec-ui' => [
                        '',
                        'control-tabs',
                        'scheme-current',
                        'view-1',
                        'mod-block',
                        'mod-position-left'
                    ]
                ],
                'data' => [
                    'ui-control' => 'tabs'
                ]
            ]) ?>
                <?php $bActive = true ?>
                <?php foreach ($arResult['SECTIONS'] as $arSection) { ?>
                <?php
                    if (empty($arSection['ITEMS']))
                        continue;
                ?>
                    <?= Html::beginTag('li', [
                        'class' => 'intec-ui-part-tab',
                        'data' => [
                            'active' => $bActive ? 'true' : 'false'
                        ]
                    ]) ?>
                        <?= Html::tag('a', $arSection['NAME'], [
                            'href' => '#'.$sTemplateId.'-section-'.$arSection['ID'],
                            'data' => [
                                'type' => 'tab'
                            ]
                        ]) ?>
                    <?= Html::endTag('li') ?>
                    <?php $bActive = false ?>
                <?php } ?>
            <?= Html::endTag('ul') ?>
            <div class="news-list-tab-container intec-ui intec-ui-control-tabs-content">
                <?php $bActive = true ?>
                <?php foreach ($arResult['SECTIONS'] as $arSection) { ?>
                <?php
                    if (empty($arSection['ITEMS']))
                        continue;
                ?>
                    <?= Html::beginTag('div', [
                        'id' => $sTemplateId.'-section-'.$arSection['ID'],
                        'class' => 'intec-ui-part-tab',
                        'data' => [
                            'active' => $bActive ? 'true' : 'false'
                        ]
                    ]) ?>
                        <div class="news-list-elements">
                            <div class="news-list-elements-wrapper">
                                <?php foreach($arSection['ITEMS'] as $arItem) {

                                    $sId = $sTemplateId.'_section_'.$arSection['ID'].'_desktop_default_'.$arItem['ID'];
                                    $sAreaId = $this->GetEditAreaId($sId);
                                    $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                                    $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);
                                    $sImage = null;

                                    if (!empty($arItem['PREVIEW_PICTURE'])) {
                                        $sImage = $arItem['PREVIEW_PICTURE'];
                                    } else if (!empty($arItem['DETAIL_PICTURE'])) {
                                        $sImage = $arItem['DETAIL_PICTURE'];
                                    }

                                    $sImage = CFile::ResizeImageGet($sImage, [
                                        'width' => 340,
                                        'height' => 220
                                    ], BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                                    if (!empty($sImage))
                                        $sImage = $sImage['src'];
                                    else
                                        $sImage = null;

                                    $sDescriptionText = trim($arItem['PREVIEW_TEXT']);
                                    $sDescriptionText = TruncateText($sDescriptionText, 300);

                                    $bImageShow = $arResult['VIEW_PARAMETERS']['PICTURE_SHOW'] && !empty($sImage);
                                    $bDescriptionShow = $arResult['VIEW_PARAMETERS']['DESCRIPTION_SHOW'] && !empty($sDescriptionText);

                                ?>
                                    <div class="news-list-element <?= $bImageShow ? '' : 'no-image' ?>">
                                        <div class="intec-grid intec-grid-600-wrap news-list-element-wrapper" id="<?= $sAreaId ?>">
                                            <?php if ($bImageShow){?>
                                                <div class="intec-grid-item-600-1 news-list-element-image-wrapper">
                                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="news-list-element-image intec-image-effect" style="background-image: url('<?= $sImage ?>')"></a>
                                                </div>
                                            <?php }?>
                                            <div class="intec-grid-item-600-1 intec-grid intec-grid-a-v-center news-list-element-content">
                                                <div class="intec-grid-item-auto intec-grid-item-shrink-1 news-list-element-content-wrapper">
                                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="news-list-element-name">
                                                        <?= $arItem['NAME'] ?>
                                                    </a>
                                                    <?php if ($bDescriptionShow){ ?>
                                                    <div class="news-list-element-description">
                                                        <?= $sDescriptionText ?>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?= Html::endTag('div') ?>
                    <?php $bActive = false ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
