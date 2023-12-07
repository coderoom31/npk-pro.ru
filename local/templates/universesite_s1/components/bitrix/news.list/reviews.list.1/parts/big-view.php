<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 * @var array $arTags
 * @var array $arItemTags
 */

?>

<div class="reviews-list-item intec-grid-item-1 big-view" id="<?= $sAreaId ?>">
    <div class="reviews-list-item-wrapper" data-role="container">
        <div class="reviews-list-big-video">
            <? $arBigVideo = array_shift($arItem['DATA']['VIDEO']['ITEMS']); ?>

            <?= Html::beginTag('div', [
                'class' => [
                    'media-big-item-picture',
                    'intec-cl-svg-path-stroke',
                    'intec-cl-svg-path-fill'
                ],
                'style' => [
                    'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$arBigVideo[$arVisual['VIDEO']['IMAGE']['QUALITY']].'\')' : null
                ],
                'data' => [
                    'role' => 'media',
                    'src' => $arBigVideo['iframe'],
                    'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                    'original' => $arVisual['LAZYLOAD']['USE'] ? $arBigVideo[$arVisual['VIDEO']['QUALITY']] : null
                ]
            ]) ?>

                <svg class="media-big-item-picture-icon" width="96" height="96" viewBox="0 0 98 98" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M97 49C97 75.512 75.512 97 49 97C22.488 97 1 75.512 1 49C1 22.488 22.488 1 49 1C75.512 1 97 22.488 97 49Z" fill="#0065FF" stroke="#0065FF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path class="media-item-picture-icon-path-white" d="M43.3524 33.3091L64.0564 45.5544C66.675 47.1011 66.675 50.8931 64.0564 52.4398L43.3524 64.6851C40.6857 66.2638 37.315 64.3384 37.315 61.2398V36.7544C37.315 33.6558 40.6857 31.7304 43.3524 33.3091Z" fill="white" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <div class="reviews-list-item-review" data-status="<?= $arVisual['VIDEO']['BIG']['FULL'] ? "true" : "false" ?>">
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
                    <? if($arVisual['VIDEO']['BIG']['FULL']){ ?>
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
                    <? } ?>
                </div>
            <?= Html::endTag('div') ?>

        </div>

        <?php include(__DIR__.'/answer.php'); ?>

    </div>
</div>