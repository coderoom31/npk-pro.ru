<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var string $sTemplateId
 * @var array $arVisual
 */

?>
<div class="catalog-element-properties">
    <div class="intec-grid intec-grid-wrap intec-grid-i-h-25 intec-grid-i-v-10">
    <?php $iPropertyNumber = 1 ?>
    <?php foreach ($arResult['DISPLAY_PROPERTIES'] as $arProperty) {

        if ($iPropertyNumber > $arVisual['PROPERTIES']['PREVIEW']['COUNT'])
            break;

        if (!empty($arProperty['USER_TYPE']))
            continue;

    ?>
        <div class="intec-grid-item intec-grid-item-2 intec-grid-item-1000-1 catalog-element-property">
            <span class="catalog-element-property-name">
                <?= $arProperty['NAME'] ?> -
            </span>
            <span class="catalog-element-property-value">
                <?= !Type::isArray($arProperty['DISPLAY_VALUE']) ?
                    $arProperty['DISPLAY_VALUE'] :
                    implode(', ', $arProperty['DISPLAY_VALUE'])
                ?>;
            </span>
        </div>
        <?php $iPropertyNumber++ ?>
    <?php } ?>
    <?php unset($iPropertyNumber, $arProperty) ?>
    </div>
    <?php if (!empty($arResult['SECTIONS']['PROPERTIES']) && count($arResult['DISPLAY_PROPERTIES']) > $arVisual['PROPERTIES']['PREVIEW']['COUNT']) { ?>
        <a class="catalog-element-properties-all intec-cl-text" onclick="template.load(function (data) {
            var $ = this.getLibrary('$');
            var id = <?= JavaScript::toObject('#'.$sTemplateId.'-properties') ?>;
            var content = $(id, data.nodes);
            var tab = $('[href=\'' + id + '\']', data.nodes);

            tab.trigger('click');

            $(document).scrollTo(content, 500);
        }, {
            'name': '[Component] bitrix:catalog.element (catalog.default.1) > properties anchor',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        })">
            <span class="catalog-element-properties-all-text intec-cl-text">
                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_1_PROPERTIES_ALL') ?>
            </span>
        </a>
    <?php } ?>
</div>