<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

$arTemplateParameters = [];

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];
$arTemplateParameters['LAZYLOAD_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_LAZYLOAD_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];
$arTemplateParameters['MAP_TYPE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_MAP_TYPE'),
    'TYPE' => 'LIST',
    'VALUES' => [
        'yandex' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_MAP_TYPE_YANDEX'),
        'google' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_MAP_TYPE_GOOGLE')
    ],
    'DEFAULT' => 'yandex'
];
$arTemplateParameters['PICTURE_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_PICTURE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];
$arTemplateParameters['SCHEDULE_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_SCHEDULE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];
$arTemplateParameters['PHONE_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_PHONE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];
$arTemplateParameters['EMAIL_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_EMAIL_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];
$arTemplateParameters['DESCRIPTION_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_CATALOG_STORE_AMOUNT_MAP_1_DESCRIPTION_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];