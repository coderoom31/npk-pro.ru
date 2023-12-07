<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;
use intec\template\Properties;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'SETTINGS_USE' => 'N',
    'LAZYLOAD_USE' => 'N',
    'WIDE' => 'N',
    'COLUMNS' => 2,
    'TABS_USE' => 'N',
    'TABS_POSITION' => 'center',
    'LINK_USE' => 'N',

    'SITE_SHOW' => 'N',
    'PROPERTY_SITE_NAME' => null,
    'PROPERTY_SITE' => null,

    'ADDITIONAL_SHOW' => 'N',
    'PROPERTY_ADDITIONAL' => null,
    'PROPERTIES_LIST_SHOW' => 'N',
    'PROPERTIES_LIST' => null,
    'RESULT_SHOW' => 'N',
    'PROPERTIES_RESULT' => null,

    'ORDER_USE' => 'N',
    'ORDER_FORM_ID' => null,
    'ORDER_FORM_TEMPLATE' => null,
    'ORDER_FORM_FIELD' => null,
    'ORDER_FORM_TITLE' => null,
    'ORDER_FORM_CONSENT' => null,
    'ORDER_BUTTON' => null,

    'FOOTER_SHOW' => 'N',
    'FOOTER_POSITION' => 'center',
    'FOOTER_BUTTON_SHOW' => 'N',
    'FOOTER_BUTTON_TEXT' => null
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR
];

if ($arParams['SETTINGS_USE'] === 'Y')
    include(__DIR__.'/modifiers/settings.php');

$arVisual = [
    'LAZYLOAD' => [
        'USE' => $arParams['LAZYLOAD_USE'] === 'Y',
        'STUB' => null
    ],
    'WIDE' => $arParams['WIDE'] === 'Y',
    'COLUMNS' => ArrayHelper::fromRange([2, 3], $arParams['COLUMNS']),
    'LINK' => [
        'USE' => $arParams['LINK_USE'] === 'Y'
    ],
    'SITE' => [
        'SHOW' => $arParams['SITE_SHOW'] === 'Y'
    ],
    'ADDITIONAL' => [
        'SHOW' => $arParams['ADDITIONAL_SHOW'] === 'Y'
    ],
    'PROPERTIES_LIST' => [
        'SHOW' => $arParams['PROPERTIES_LIST_SHOW'] === 'Y'
    ],
    'RESULT' => [
        'SHOW' => $arParams['RESULT_SHOW'] === 'Y'
    ]
];

if (defined('EDITOR'))
    $arVisual['LAZYLOAD']['USE'] = false;

if ($arVisual['LAZYLOAD']['USE'])
    $arVisual['LAZYLOAD']['STUB'] = Properties::get('template-images-lazyload-stub');

if ($arVisual['COLUMNS'] > 4 && !$arVisual['WIDE'])
    $arVisual['COLUMNS'] = 4;

$arResult['VISUAL'] = ArrayHelper::merge($arVisual, $arResult['VISUAL']);

unset($arVisual);

$arForm = [
    'USE' => $arParams['ORDER_USE'] === 'Y',
    'ID' => $arParams['ORDER_FORM_ID'],
    'TEMPLATE' => $arParams['ORDER_FORM_TEMPLATE'],
    'FIELD' => $arParams['ORDER_FORM_FIELD'],
    'TITLE' => $arParams['ORDER_FORM_TITLE'],
    'CONSENT' => $arParams['ORDER_FORM_CONSENT'],
    'BUTTON' => $arParams['ORDER_BUTTON']
];

if ($arForm['USE'])
    if (empty($arForm['ID']) || empty($arForm['TEMPLATE']))
        $arForm['USE'] = false;

$arResult['FORM'] = $arForm;

unset($arForm);

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['DATA'] = [];

    $arItem['DATA']['SITE'] = [
      'NAME' => ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_SITE_NAME'], 'VALUE']),
      'LINK' => ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_SITE'], 'VALUE'])
    ];

    $arAdditional = ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_ADDITIONAL']]);

    $arItem['DATA']['ADDITIONAL'] = [];

    foreach ($arAdditional['VALUE'] as $key => $value) {
        $arItem['DATA']['ADDITIONAL'][] = [
            'VALUE' => $value,
            'DESCRIPTION' => $arAdditional['DESCRIPTION'][$key]
        ];
    }

    $arItem['DATA']['RESULT'] = ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_RESULT'], 'VALUE']);

    foreach ($arParams['PROPERTIES_LIST'] as $sProperty) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $sProperty
        ]);

        $arProp = [
            'NAME' => $arProperty['NAME'],
            'VALUE' => $arProperty['VALUE']
        ];

        if (!empty($arProp['VALUE'])) {
            if (Type::isArray($arProp['VALUE'])) {
                if (ArrayHelper::keyExists('TEXT', $arProp['VALUE']))
                    $arProp['VALUE'] = Html::stripTags($arProp['VALUE']['TEXT']);
                else
                    $arProp['VALUE'] = implode(', ', $arProp['VALUE']);

                if (empty($arProp['VALUE']))
                    $arProp['VALUE'] = null;
            }

            $arItem['DATA']['PROPERTIES'][] =  $arProp;
        }
    }
}

unset ($arAdditional);

$arFooter = [
    'SHOW' => $arParams['FOOTER_SHOW'] === 'Y',
    'POSITION' => ArrayHelper::fromRange([
        'left',
        'center',
        'right'
    ], $arParams['FOOTER_POSITION']),
    'BUTTON' => [
        'SHOW' => $arParams['FOOTER_BUTTON_SHOW'] === 'Y',
        'TEXT' => $arParams['FOOTER_BUTTON_TEXT'],
        'LINK' => null
    ]
];

if (!empty($arParams['LIST_PAGE_URL']))
    $arFooter['BUTTON']['LINK'] = StringHelper::replaceMacros(
        $arParams['LIST_PAGE_URL'],
        $arMacros
    );

if (empty($arFooter['BUTTON']['TEXT']) || empty($arFooter['BUTTON']['LINK']))
    $arFooter['BUTTON']['SHOW'] = false;

if (!$arFooter['BUTTON']['SHOW'])
    $arFooter['SHOW'] = false;

$arResult['BLOCKS']['FOOTER'] = $arFooter;

unset($arFooter, $arMacros);