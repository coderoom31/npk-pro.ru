<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Type;

/**
 * @var array $arResult
 */

?>
<div class="catalog-element-section-properties">
    <?php foreach ($arResult['DISPLAY_PROPERTIES'] as $arProperty) { ?>
        <div class="catalog-element-section-property">
            <div class="catalog-element-section-property-name">
                <?= $arProperty['NAME'] ?>
            </div>
            <div class="catalog-element-section-property-value">
                <?= !Type::isArray($arProperty['DISPLAY_VALUE']) ?
                    $arProperty['DISPLAY_VALUE'] :
                    implode(', ', $arProperty['DISPLAY_VALUE'])
                ?>
            </div>
            <div class="intec-ui-clearfix"></div>
        </div>
    <?php } ?>
    <?php unset($arProperty) ?>
</div>