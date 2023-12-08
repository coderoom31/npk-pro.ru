<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="banner">
    <div class="banner__slider swiper">
        <div class="swiper-wrapper">
            <?php if ($arResult['ITEMS']) { ?>
                <?php foreach ($arResult['ITEMS'] as $sSrc) { ?>
                    <div class="swiper-slide">
                        <img src="<?=$sSrc?>" alt="slide">
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="swiper-pagination banner__pagination"></div>
    </div>
    <div class="banner__content">
        <h1 class="banner__title">
            <?=$arParams['HEADER']?>
        </h1>
        <ul class="banner__list">
            <li class="banner__item">Автоматическая дозация от 3-х до 21 компонентов СЗР</li>
            <li class="banner__item">Пре-миксер с функцией измерения СЗР и быстрым опорожнением и промывкой канистры</li>
            <li class="banner__item">Высокая производительность 60 м/час растворов в автоматическом режиме.</li>
        </ul>
        <div class="banner__btns">
<!--            <a class="banner__download" href="/" download>Скачать опросный лист</a>-->
<!--            <a class="banner__play" href="/">Смотреть презентацию <img-->
<!--                    src="--><?php //echo SITE_TEMPLATE_PATH ?><!--/images/nodes/play-icon.svg" alt="icon"></a>-->
        </div>
    </div>
</div>
