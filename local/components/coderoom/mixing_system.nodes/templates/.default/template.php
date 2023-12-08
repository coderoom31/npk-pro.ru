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

<div class="system">
    <h2 class="system__title">Смесительные системы Mixmate</h2>
    <div class="system__grid">
        <div class="system__row three">
            <?php $i = 0; ?>
            <?php foreach ($arResult['ITEMS'] as $arSystem) { ?>
                <?php if ($i <= 2) { ?>
                    <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                       style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                        <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                        <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                    </a>
                <?php } ?>
                <?php $i++; ?>
            <?php } ?>
        </div>
        <div class="system__row two">
            <?php $a = 0; ?>
            <?php foreach ($arResult['ITEMS'] as $arSystem) { ?>
                <?php if ($a <= 4 && $a > 2) { ?>
                    <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                       style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                        <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                        <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                    </a>
                <?php } ?>
                <?php $a++; ?>
            <?php } ?>
        </div>
        <div class="system__row three">
            <?php $b = 0; ?>
            <?php foreach ($arResult['ITEMS'] as $arSystem) { ?>
                <?php if ($b <= 7 && $b > 4) { ?>
                    <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                       style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                        <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                        <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                    </a>
                <?php } ?>
                <?php $b++; ?>
            <?php } ?>
        </div>

        <div class="system__row mobile">
            <?php foreach ($arResult['ITEMS'] as $arSystem) { ?>
                <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                   style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                    <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                    <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
