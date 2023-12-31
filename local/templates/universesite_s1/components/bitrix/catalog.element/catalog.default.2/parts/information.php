<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\JavaScript;

/**
 * @var array $arVisual
 */

?>
<div class="intec-grid intec-grid-a-v-center">
    <?php if ($arVisual['INFORMATION']['PAYMENT']['SHOW']) { ?>
        <div class="catalog-element-other-information-item intec-grid-item">
            <div class="catalog-element-other-information-item-button intec-cl-text-hover intec-cl-border-hover" onclick="template.api.components.show(<?= JavaScript::toObject([
                'component' => 'intec.universe:main.widget',
                'template' => 'catalog.information.1',
                'parameters' => [
                    'PATH' => $arVisual['INFORMATION']['PAYMENT']['PATH']
                ],
                'settings' => [
                    'title' => Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_INFORMATION_PAYMENT'),
                    'parameters' => [
                        'width' => null
                    ]
                ]
            ]) ?>)">
                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_INFORMATION_PAYMENT') ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($arVisual['INFORMATION']['SHIPMENT']['SHOW']) { ?>
        <div class="catalog-element-other-information-item intec-grid-item">
            <div class="catalog-element-other-information-item-button intec-cl-text-hover intec-cl-border-hover" onclick="template.api.components.show(<?= JavaScript::toObject([
                'component' => 'intec.universe:main.widget',
                'template' => 'catalog.information.1',
                'parameters' => [
                    'PATH' => $arVisual['INFORMATION']['SHIPMENT']['PATH']
                ],
                'settings' => [
                    'title' => Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_INFORMATION_SHIPMENT'),
                    'parameters' => [
                        'width' => null
                    ]
                ]
            ]) ?>)">
                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_INFORMATION_SHIPMENT') ?>
            </div>
        </div>
    <?php } ?>
</div>
