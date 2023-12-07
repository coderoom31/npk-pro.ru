<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 * @var array $arTags
 * @var array $arItemTags
 */

?>
<div class="media-content intec-grid intec-grid-wrap" data-role="container">
    <? if ($arVisual['VIDEO']['SHOW'] && !empty($arItem['DATA']['VIDEO'])) { ?>
        <? foreach ($arItem['DATA']['VIDEO']['ITEMS'] as $arVideos) {?>
            <div class="media-item">
                <?= Html::beginTag('div', [
                    'class' => [
                        'media-item-picture',
                        'intec-cl-svg-path-stroke',
                        'intec-cl-svg-path-fill'
                    ],
                    'style' => [
                        'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$arVideos[$arVisual['VIDEO']['IMAGE']['QUALITY']].'\')' : null
                    ],
                    'data' => [
                        'role' => 'media',
                        'src' => $arVideos['iframe'],
                        'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                        'original' => $arVisual['LAZYLOAD']['USE'] ? $arVideos[$arVisual['VIDEO']['QUALITY']] : null
                    ]
                ]) ?>
                    <svg class="media-item-picture-icon" width="24" height="24" viewBox="0 0 98 98" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M97 49C97 75.512 75.512 97 49 97C22.488 97 1 75.512 1 49C1 22.488 22.488 1 49 1C75.512 1 97 22.488 97 49Z" fill="#0065FF" stroke="#0065FF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path class="media-item-picture-icon-path-white" d="M43.3524 33.3091L64.0564 45.5544C66.675 47.1011 66.675 50.8931 64.0564 52.4398L43.3524 64.6851C40.6857 66.2638 37.315 64.3384 37.315 61.2398V36.7544C37.315 33.6558 40.6857 31.7304 43.3524 33.3091Z" fill="white" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                <?= Html::endTag('div') ?>
            </div>
        <? } ?>
    <? } ?>

    <?php if ($arVisual['IMAGE']['SHOW'] && !empty($arItem['PROPERTIES']['IMAGES']['VALUE'])) { ?>
        <? foreach ($arItem['PROPERTIES']['IMAGES']['VALUE'] as $arImages) { ?>
            <? $src = CFile::GetPath($arImages); ?>
            <div class="media-item">
                <?= Html::beginTag('div', [
                    'class' => [
                        'media-item-picture',
                    ],
                    'style' => [
                        'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$src.'\')' : null
                    ],
                    'data' => [
                        'role' => 'media',
                        'src' => $src,
                        'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                        'original' => $arVisual['LAZYLOAD']['USE'] ? $src : null
                    ]
                ]) ?>
                    <img src="<?= $src ?>" alt="">
                <?= Html::endTag('div') ?>
            </div>
            <? unset($src) ?>
       <? }?>
    <? } ?>
</div>