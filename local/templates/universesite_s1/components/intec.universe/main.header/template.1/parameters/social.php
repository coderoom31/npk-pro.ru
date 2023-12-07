<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\component\InnerTemplate;

/**
 * @var string $componentName
 * @var string $templateName
 * @var string $siteTemplate
 * @var array $arCurrentValues
 * @var array $arTemplateParameters
 * @var array $arParts
 * @var InnerTemplate $desktopTemplate
 * @var InnerTemplate $fixedTemplate
 * @var InnerTemplate $mobileTemplate
 */

$arParts['SOCIAL'] = null;

if (!empty($desktopTemplate)) {
    $arTemplateParameters['SOCIAL_SHOW'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_SHOW'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'Y'
    ];
}

if (!empty($mobileTemplate)) {
    $arTemplateParameters['SOCIAL_SHOW_MOBILE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_SHOW_MOBILE'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'Y'
    ];
}

$arTemplateParameters['SOCIAL_VK'] = [
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_VK'),
    'DEFAULT' => 'https://vk.com'
];

$arTemplateParameters['SOCIAL_INSTAGRAM'] = [
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_INSTAGRAM'),
    'DEFAULT' => 'https://instagram.com'
];

$arTemplateParameters['SOCIAL_FACEBOOK'] = [
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_FACEBOOK'),
    'DEFAULT' => 'https://facebook.com'
];

$arTemplateParameters['SOCIAL_TWITTER'] = [
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_TWITTER'),
    'DEFAULT' => 'https://twitter.com'
];

$arTemplateParameters['SOCIAL_YOUTUBE'] = [
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_YOUTUBE'),
    'DEFAULT' => 'https://youtube.com'
];

$arTemplateParameters['SOCIAL_ODNOKLASSNIKI'] = [
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_SOCIAL_ODNOKLASSNIKI'),
    'DEFAULT' => 'https://ok.ru'
];