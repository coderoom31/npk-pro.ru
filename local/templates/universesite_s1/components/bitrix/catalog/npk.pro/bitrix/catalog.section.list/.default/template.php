<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(true);
?>

<?php foreach ($arResult['SECTIONS'] as &$arSection):
    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    ?>
    <div class="section">
        <div class="sections-title">
            <h3><?= $arSection['NAME'] ?></h3>
        </div>
        <div class="section-description"><?= $arSection['DESCRIPTION'] ?></div>
        <div class="catalog-section-items">
            <?php foreach ($arResult['ELEMENTS'][$arSection['ID']] as $element):
                if ($element['RESIZE_PICTURE']['src']):
                    ?>
                    <a class="catalog-section-item" href="<?= $element['DETAIL_PAGE_URL'] ?>">
                        <img src="<?= $element['RESIZE_PICTURE']['src'] ?>" alt="<?= $element['NAME'] ?>">
                        <div class="catalog-section-item-text">
                            <div class="catalog-section-item-title"><span><?= $element['NAME'] ?></span></div>
                            <span class="catalog-section-item-description"><?= $element['PREVIEW_TEXT'] ?></span>
                        </div>
                    </a>
                <?php
                endif;
            endforeach;
            ?>
        </div>

    </div>

<?php endforeach; ?>



