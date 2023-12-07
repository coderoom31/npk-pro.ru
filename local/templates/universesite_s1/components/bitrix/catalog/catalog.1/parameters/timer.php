<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;

$sPrefix = 'SECTIONS_TIMER_';

$arTemplateParameters[$sPrefix . 'SHOW'] = [
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_SECTIONS_TIMER_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if (!empty($arCurrentValues[$sPrefix . 'SHOW'] === 'Y')) {

    $sComponent = 'intec.universe:product.timer';
    $sTemplate = 'template.1';

    $arTemplates = Arrays::from(CComponentUtil::GetTemplatesList(
        $sComponent,
        $siteTemplate
    ))->asArray(function ($key, $arTemplate) {
        return [
            'key' => $arTemplate['NAME'],
            'value' => $arTemplate['NAME']
        ];
    });

    $arTemplateParameters[$sPrefix.'TEMPLATE'] = [
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_SECTIONS_TIMER_TEMPLATE'),
        'TYPE' => 'LIST',
        'VALUES' => $arTemplates,
        'DAFAULT' => $sTemplate,
        'REFRESH' => 'Y'
    ];

    if (!empty($arCurrentValues[$sPrefix.'TEMPLATE'])) {
        $sTemplate = $arCurrentValues[$sPrefix.'TEMPLATE'];
    }

    if (ArrayHelper::isIn($sTemplate, $arTemplates)) {
        $arTemplateParameters = ArrayHelper::merge($arTemplateParameters, Component::getParameters(
            $sComponent,
            $sTemplate,
            $siteTemplate,
            $arCurrentValues,
            $sPrefix,
            function ($key, &$arParameter) {
                $arParameter['NAME'] = Loc::getMessage('C_CATALOG_CATALOG_1_SECTIONS_TIMER').' '.$arParameter['NAME'];
                $arParameter['PARENT'] = 'LIST_SETTINGS';

                return true;
            },
            Component::PARAMETERS_MODE_BOTH
        ));
    }

    unset($sComponent, $sTemplate, $sPrefix, $arTemplates);
}