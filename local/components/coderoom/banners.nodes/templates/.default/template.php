<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
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
            <li class="banner__item">Перевозка препаратов в растворном узле</li>
            <li class="banner__item">Заправляется препаратами на базе</li>
            <li class="banner__item">Растворный узел и 10 т воды на одном прицепе КАМАЗа</li>
            <li class="banner__item">Встроенная мешалка для порошковых СЗР</li>
        </ul>
        <div class="banner__btns">
            <a class="banner__download" href="/" download>Скачать опросный лист</a>
            <a class="banner__play" href="/">Смотреть презентацию <img
                    src="<?php echo SITE_TEMPLATE_PATH ?>/images/nodes/play-icon.svg" alt="icon"></a>
        </div>
    </div>
</div>
