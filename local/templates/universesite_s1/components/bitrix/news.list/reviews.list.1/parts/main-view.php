<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 * @var array $arTags
 * @var array $arItemTags
 */

?>




<div class="reviews-list-item intec-grid-item-1 main-view" id="<?= $sAreaId ?>">
    <div class="reviews-list-item-wrapper">

        <div class="reviews-list-item-review">
            <? if(!empty($arItem['NAME']) ||
                $arVisual['DATE']['SHOW'] && !empty($arItem['DATA']['DATE']) ||
                $arVisual['RATING']['SHOW'] && !empty($sRaiting)) { ?>
                <div class="reviews-list-item-header intec-grid intec-grid-a-v-center">
                    <div class="reviews-list-item-header-picture-wrap">
                        <?= Html::tag('div', '', [
                            'class' => 'reviews-list-item-header-picture',
                            'data' => [
                                'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                'original' => $arVisual['LAZYLOAD']['USE'] ? $sPicture : null
                            ],
                            'style' => [
                                'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$sPicture.'\')' : null
                            ]
                        ]) ?>
                    </div>
                    <div class="reviews-list-item-header-text intec-grid intec-grid-o-vertical">
                        <? if(!empty($arItem['NAME'])) { ?>
                            <div class="reviews-list-item-name">
                                <?= $arItem['NAME']?>
                            </div>
                        <? } ?>
                        <?php if ($arVisual['DATE']['SHOW'] && !empty($arItem['DATA']['DATE'])) { ?>
                            <div class="reviews-list-item-date">
                                <?= $arItem['DATA']['DATE'] ?>
                            </div>
                        <? } ?>
                    </div>
                    <div class="intec-grid-item"></div>
                    <?php if ($arVisual['RATING']['SHOW'] && !empty($sRaiting)) {?>
                        <?= Html::beginTag('div', [
                            'class' => Html::cssClassFromArray([
                                'reviews-list-item-header-rating-wrap' => true,
                                'intec-grid' => [
                                    '' => true,
                                    'i-h-3' => true
                                ]
                            ], true)
                        ])?>
                        <?php for ($countStar=1;$countStar<=$arVisual['RATING']['MAX'];$countStar++) { ?>
                            <?= Html::beginTag('div', [
                                'class' => Html::cssClassFromArray([
                                    'intec-grid-item-auto' => true,
                                    'reviews-list-item-header-rating' => [
                                        '' => true,
                                        'active' => ($countStar<=$sRaiting)
                                    ]
                                ], true)
                            ])?>
                            <i class="intec-ui-icon intec-ui-icon-star-1"></i>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                </div>
            <? } ?>
            <? if(!empty($sText)) { ?>
                <div class="reviews-list-item-text">
                    <?= $sText ?>
                </div>
            <? } ?>
            <? if($arVisual['IMAGE']['SHOW'] && !empty($arItem['PROPERTIES']['IMAGES']['VALUE']) ||
                $arVisual['VIDEO']['SHOW'] && !empty($arItem['DATA']['VIDEO'])) { ?>
                <div class="reviews-list-item-media">
                    <?php include(__DIR__.'/media.php'); ?>
                </div>
            <? } ?>
            <? if($arVisual['DOCUMENTS']['SHOW'] && !empty($arItem['DATA']['DOCUMENTS'])) { ?>
                <div class="reviews-list-item-documents">
                    <?php include(__DIR__.'/documents.php'); ?>
                </div>
            <? } ?>
        </div>

        <?php include(__DIR__.'/answer.php'); ?>

    </div>
</div>





