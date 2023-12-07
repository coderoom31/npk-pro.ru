<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arVisual
 */

if (empty($arVisual['PROPERTIES']['DETAIL']['NAME']))
    $arVisual['PROPERTIES']['DETAIL']['NAME'] = Loc::getMessage('C_CATALOG_ELEMENT_DEFAULT_5_TEMPLATE_PROPERTIES_DETAIL_NAME_DEFAULT');

?>
<div class="catalog-element-properties-detail-container catalog-element-additional-block" data-role="properties.detail">
    <div class="catalog-element-additional-block-name">
        <?= $arVisual['PROPERTIES']['DETAIL']['NAME'] ?>
    </div>
    <div class="catalog-element-additional-block-content-text">
        <div class="catalog-element-properties-detail">
            <?php foreach ($arResult['DISPLAY_PROPERTIES'] as $arProperty) { ?>
                <div class="catalog-element-properties-detail-item">
                    <div class="intec-grid intec-grid-a-v-center intec-grid-i-4 intec-grid-500-wrap">
                        <div class="intec-grid-item-2 intec-grid-item-500-1">
                            <div class="catalog-element-properties-detail-item-name">
                                <?= $arProperty['NAME'] ?>
                            </div>
                        </div>
                        <div class="intec-grid-item-2 intec-grid-item-500-1">
                            <div class="catalog-element-properties-detail-item-value">
                                <?php if (Type::isArray($arProperty['DISPLAY_VALUE'])) { ?>
                                    <?= implode(', ', $arProperty['DISPLAY_VALUE']) ?>
                                <?php } else { ?>
                                    <?= $arProperty['DISPLAY_VALUE'] ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php unset($arProperty) ?>