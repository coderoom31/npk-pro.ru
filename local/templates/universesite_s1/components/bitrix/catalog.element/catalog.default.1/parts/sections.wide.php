<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var string $sTemplateId
 */

?>
<div class="catalog-element-sections catalog-element-sections-wide">
    <?php foreach ($arResult['SECTIONS'] as $sCode => $arSection) { ?>
        <div id="<?= $sTemplateId.'-'.$arSection['CODE'] ?>" class="catalog-element-section">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <?= $arSection['NAME'] ?>
            </div>
            <div class="catalog-element-section-content">
                <?php include(__DIR__.'/sections/'.$arSection['CODE'].'.php') ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php unset($sCode, $arSection) ?>