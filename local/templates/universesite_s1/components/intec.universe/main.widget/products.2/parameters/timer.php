<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;

$sComponent = 'intec.universe:product.timer';
$sTemplate = 'template.1';
$sPrefix = 'SECTION_TIMER_';

$arTemplates = Arrays::from(CComponentUtil::GetTemplatesList(
    $sComponent,
    $siteTemplate
))->asArray(function ($key, $arTemplate) {
    return [
        'key' => $key,
        'value' => $arTemplate['NAME']
    ];
});

if (ArrayHelper::isIn($sTemplate, $arTemplates)) {
    $arTemplateParameters = ArrayHelper::merge($arTemplateParameters, Component::getParameters(
        $sComponent,
        $sTemplate,
        $siteTemplate,
        $arCurrentValues,
        $sPrefix,
        function ($key, &$arParameter) {
            $arParameter['NAME'] = Loc::getMessage('C_WIDGET_PRODUCTS_2_TIMER').' '.$arParameter['NAME'];
            $arParameter['PARENT'] = 'VISUAL';

            return true;
        },
        Component::PARAMETERS_MODE_BOTH
    ));
}

unset($sComponent, $sTemplate, $sPrefix, $arTemplates);
