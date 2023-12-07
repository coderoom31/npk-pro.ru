<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arVisual
 * @var string $sTemplateId
 */

?>
<div class="catalog-element-properties">
    <div class="intec-grid intec-grid-wrap intec-grid-i-h-10">
        <?php $iPropertyNumber = 1 ?>
        <?php foreach ($arResult['DISPLAY_PROPERTIES'] as $arProperty) {

            if ($iPropertyNumber > $arVisual['PROPERTIES']['PREVIEW']['COUNT'])
                break;

            if (!empty($arProperty['USER_TYPE']))
                continue;

        ?>
            <div class="intec-grid-item-2 intec-grid-item-400-1">
                <div class="catalog-element-property">
                    <div class="catalog-element-property-name">
                        <?= $arProperty['NAME'] ?>
                    </div>
                    <div class="catalog-element-property-value">
                        <?= !Type::isArray($arProperty['DISPLAY_VALUE']) ?
                            $arProperty['DISPLAY_VALUE'] :
                            implode(', ', $arProperty['DISPLAY_VALUE'])
                        ?>;
                    </div>
                </div>
            </div>
            <?php $iPropertyNumber++ ?>
        <?php } ?>
        <?php unset($iPropertyNumber, $arProperty) ?>
    </div>
    <?php if (!empty($arResult['SECTIONS']['PROPERTIES']) && count($arResult['DISPLAY_PROPERTIES']) > $arVisual['PROPERTIES']['PREVIEW']['COUNT']) { ?>
        <a class="catalog-element-properties-all" onclick="template.load(function (data) {
            var $ = this.getLibrary('$');
            var id = <?= JavaScript::toObject('#'.$sTemplateId.'-properties') ?>;
            var content = $(id, data.nodes);
            var tab = $('[href=\'' + id + '\']');

            tab.trigger('click');

            $(document).scrollTo(content, 500);
        }, {
            'name': '[Component] bitrix:catalog.element (catalog.default.2) > properties anchor',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        })">
            <span class="catalog-element-properties-all-text">
                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_PROPERTIES_ALL') ?>
            </span>
            <span class="catalog-element-properties-all-icon">
                <i class="far fa-chevron-right"></i>
            </span>
        </a>
    <?php } ?>
</div>