<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX'
];

$arTemplateParameters['LAZYLOAD_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_LAZYLOAD_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];

$arTemplateParameters['HEADER_SHOW'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_HEADER_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['HEADER_SHOW'] == 'Y') {
    $arTemplateParameters['HEADER_POSITION'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_HEADER_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'left' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_LEFT'),
            'center' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_CENTER'),
            'right' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_RIGHT')
        ),
        'DEFAULT' => 'center'
    );
    $arTemplateParameters['HEADER_TEXT'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_HEADER_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_HEADER_TEXT_DEFAULT')
    );
}

$arTemplateParameters['DESCRIPTION_SHOW'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_DESCRIPTION_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

$arTemplateParameters['ITEM_WIDE'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_ITEM_WIDE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);

if ($arCurrentValues['DESCRIPTION_SHOW'] == 'Y') {
    $arTemplateParameters['DESCRIPTION_POSITION'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_DESCRIPTION_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'left' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_LEFT'),
            'center' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_CENTER'),
            'right' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_RIGHT')
        ),
        'DEFAULT' => 'center'
    );
    $arTemplateParameters['DESCRIPTION_TEXT'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_DESCRIPTION_TEXT'),
        'TYPE' => 'STRING'
    );
}

if (!empty($arCurrentValues['ACCESS_TOKEN'])) {
    $arTemplateParameters['ITEM_DESCRIPTION_SHOW'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_ITEM_DESCRIPTION_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    );

    $arTemplateParameters['ITEM_LINE_COUNT'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_ITEM_LINE_COUNT'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6'
        ),
        'DEFAULT' => '5'
    );

    $arTemplateParameters['CACHE_PATH'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_CACHE_PATH'),
        'TYPE' => 'STRING',
        'DEFAULT' => 'upload/intec.universe/instagram/cache/#SITE_DIR#'
    );

}

$arTemplateParameters['ITEM_PADDING_USE'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_ITEM_PADDING_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
);

$arTemplateParameters['FOOTER_SHOW'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_FOOTER_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['FOOTER_SHOW'] == 'Y') {
    $arTemplateParameters['FOOTER_POSITION'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_FOOTER_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'left' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_LEFT'),
            'center' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_CENTER'),
            'right' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_POSITION_RIGHT')
        ),
        'DEFAULT' => 'center'
    );
    $arTemplateParameters['FOOTER_LINK'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_FOOTER_LINK'),
        'TYPE' => 'STRING'
    );
    $arTemplateParameters['FOOTER_TEXT'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_FOOTER_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_1_FOOTER_DEFAULT')
    );
}