<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;
use intec\template\Properties;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!Loader::includeModule('intec.core'))
    return;

$bBase = false;
$bLite = false;

if (Loader::includeModule('catalog') && Loader::includeModule('sale')) {
    $bBase = true;
} else if (Loader::includeModule('intec.startshop')) {
    $bLite = true;
}

$bSeo = Loader::includeModule('intec.seo');

$arParams = ArrayHelper::merge([
    'PROPERTY_MARKS_HIT' => null,
    'PROPERTY_MARKS_NEW' => null,
    'PROPERTY_MARKS_RECOMMEND' => null,
    'PROPERTY_ORDER_USE' => null,
    'PROPERTY_PICTURES' => null,
    'OFFERS_PROPERTY_PICTURES' => null,
    'LAZYLOAD_USE' => 'N',
    'COLUMNS' => 3,
    'COLUMNS_MOBILE' => 1,
    'DELAY_USE' => 'N',
    'BORDERS' => 'N',
    'BORDERS_STYLE' => 'squared',
    'COUNTER_SHOW' => 'N',
    'MARKS_SHOW' => 'N',
    'MARKS_ORIENTATION' => 'horizontal',
    'QUICK_VIEW_USE' => 'N',
    'QUICK_VIEW_DETAIL' => 'N',
    'QUICK_VIEW_VIEW' => 'right',
    'QUICK_VIEW_TEMPLATE' => null,
    'NAME_POSITION' => 'middle',
    'NAME_ALIGN' => 'left',
    'PRICE_ALIGN' => 'left',
    'IMAGE_ASPECT_RATIO' => '1:1',
    'IMAGE_SLIDER_SHOW' => 'N',
    'ACTION' => 'buy',
    'OFFERS_USE' => 'N',
    'OFFERS_ALIGN' => 'left',
    'OFFERS_VIEW' => 'default',
    'OFFERS_VIEW_EXTENDED_LEFT' => null,
    'OFFERS_VIEW_EXTENDED_RIGHT' => null,
    'IMAGE_SLIDER_NAV_HIDE' => 'N',
    'VOTE_SHOW' => 'N',
    'VOTE_ALIGN' => 'left',
    'VOTE_MODE' => 'rating',
    'QUANTITY_SHOW' => 'N',
    'QUANTITY_MODE' => 'number',
    'QUANTITY_BOUNDS_FEW' => null,
    'QUANTITY_BOUNDS_MANY' => null,
    'QUANTITY_ALIGN' => 'left',
    'RECALCULATION_PRICES_USE' => 'N',
    'SECTIONS_TIMER_SHOW' => 'N',
    'SECTION_TIMER_SHOW' => 'Y',
    'SECTIONS_TIMER_TIMER_QUANTITY_OVER' => 'Y'
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

$arPosition = [
    'left',
    'center',
    'right'
];

$arCodes = [
    'MARKS' => [
        'HIT' => $arParams['PROPERTY_MARKS_HIT'],
        'NEW' => $arParams['PROPERTY_MARKS_NEW'],
        'RECOMMEND' => $arParams['PROPERTY_MARKS_RECOMMEND']
    ],
    'PICTURES' => $arParams['PROPERTY_PICTURES'],
    'OFFERS' => [
        'PICTURES' => $arParams['OFFERS_PROPERTY_PICTURES']
    ]
];

$arVisual = [
    'LAZYLOAD' => [
        'USE' => $arParams['LAZYLOAD_USE'] === 'Y',
        'STUB' => null
    ],
    'BORDERS' => [
        'USE' => $arParams['BORDERS'] === 'Y',
        'STYLE' => ArrayHelper::fromRange(['squared', 'rounded'], $arParams['BORDERS_STYLE'])
    ],
    'COLUMNS' => [
        'DESKTOP' => ArrayHelper::fromRange([3, 2, 4], $arParams['COLUMNS']),
        'MOBILE' => ArrayHelper::fromRange([1, 2], $arParams['COLUMNS_MOBILE']),
    ],
    'IMAGE' => [
        'ASPECT_RATIO' => 100,
        'SLIDER' => $arParams['IMAGE_SLIDER_SHOW'] === 'Y',
        'NAV' => $arParams['IMAGE_SLIDER_NAV_HIDE'] === 'Y'
    ],
    'COUNTER' => [
        'SHOW' => $arParams['COUNTER_SHOW'] === 'Y'
    ],
    'MARKS' => [
        'SHOW' => $arParams['MARKS_SHOW'] === 'Y' && (!empty($arCodes['MARKS']['HIT']) || !empty($arCodes['MARKS']['NEW']) || !empty($arCodes['MARKS']['RECOMMEND'])),
        'ORIENTATION' => ArrayHelper::fromRange(['horizontal', 'vertical'], $arParams['MARKS_ORIENTATION'])
    ],
    'COMPARE' => [
        'USE' => $arParams['USE_COMPARE'] === 'Y',
        'CODE' => $arParams['COMPARE_NAME']
    ],
    'DELAY' => [
        'USE' => $arParams['DELAY_USE'] === 'Y'
    ],
    'NAME' => [
        'ALIGN' => ArrayHelper::fromRange($arPosition, $arParams['NAME_ALIGN']),
        'POSITION' => ArrayHelper::fromRange(['middle', 'top'], $arParams['NAME_POSITION'])
    ],
    'PRICE' => [
        'ALIGN' => ArrayHelper::fromRange(['start', 'center', 'end'], $arParams['PRICE_ALIGN']),
        'RECALCULATION' => $arParams['RECALCULATION_PRICES_USE'] === 'Y'
    ],
    'OFFERS' => [
        'USE' => $arParams['OFFERS_USE'] === 'Y',
        'ALIGN' => ArrayHelper::fromRange($arPosition, $arParams['OFFERS_ALIGN']),
        'VIEW' => ArrayHelper::fromRange(['default', 'extended'], $arParams['OFFERS_VIEW']),
        'EXTENDED' => [
            'LEFT' => $arParams['OFFERS_VIEW_EXTENDED_LEFT'],
            'RIGHT' => $arParams['OFFERS_VIEW_EXTENDED_RIGHT']
        ]
    ],
    'NAVIGATION' => [
        'TOP' => [
            'SHOW' => $arParams['DISPLAY_TOP_PAGER']
        ],
        'BOTTOM' => [
            'SHOW' => $arParams['DISPLAY_BOTTOM_PAGER']
        ],
        'LAZY' => [
            'BUTTON' => $arParams['LAZY_LOAD'] === 'Y',
            'SCROLL' => $arParams['LOAD_ON_SCROLL'] === 'Y'
        ]
    ],
    'WIDE' => $arParams['WIDE'] === 'Y',
    'VOTE' => [
        'SHOW' => $arParams['VOTE_SHOW'] === 'Y',
        'MODE' => ArrayHelper::fromRange(['average', 'rating'], $arParams['VOTE_MODE']),
        'ALIGN' => ArrayHelper::fromRange($arPosition, $arParams['VOTE_ALIGN'])
    ],
    'QUANTITY' => [
        'SHOW' => $arParams['QUANTITY_SHOW'] === 'Y',
        'MODE' => ArrayHelper::fromRange(['number', 'text', 'logic'], $arParams['QUANTITY_MODE']),
        'ALIGN' => ArrayHelper::fromRange($arPosition, $arParams['QUANTITY_ALIGN']),
        'BOUNDS' => [
            'FEW' => Type::toFloat($arParams['QUANTITY_BOUNDS_FEW']),
            'MANY' => Type::toFloat($arParams['QUANTITY_BOUNDS_MANY'])
        ]
    ],
    'BUTTONS' => [
        'BASKET' => [
            'TEXT' => $arParams['PURCHASE_BASKET_BUTTON_TEXT']
        ],
        'ORDER' => [
            'TEXT' => $arParams['PURCHASE_ORDER_BUTTON_TEXT']
        ]
    ],
    'TIMER' => [
        'SHOW' => $arParams['SECTIONS_TIMER_SHOW'] === 'Y' && $arParams['SECTION_TIMER_SHOW'] === 'Y' && $bBase,
        'TIMER_QUANTITY_OVER' => $arParams['SECTIONS_TIMER_TIMER_QUANTITY_OVER'] === 'Y'
    ],
];

if (empty($arVisual['BUTTONS']['BASKET']['TEXT']))
    $arVisual['BUTTONS']['BASKET']['TEXT'] = Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_2_BASKET_ADD');

if (empty($arVisual['BUTTONS']['ORDER']['TEXT']))
    $arVisual['BUTTONS']['ORDER']['TEXT'] = Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_2_ORDER');

if (defined('EDITOR') || !class_exists('\\intec\\template\\Properties'))
    $arVisual['LAZYLOAD']['USE'] = false;

if ($arVisual['LAZYLOAD']['USE'])
    $arVisual['LAZYLOAD']['STUB'] = Properties::get('template-images-lazyload-stub');

if ($arVisual['QUANTITY']['BOUNDS']['FEW'] < 0)
    $arVisual['QUANTITY']['BOUNDS']['FEW'] = 5;

if ($arVisual['QUANTITY']['BOUNDS']['MANY'] <= $arVisual['QUANTITY']['BOUNDS']['FEW'])
    $arVisual['QUANTITY']['BOUNDS']['MANY'] = $arVisual['QUANTITY']['BOUNDS']['FEW'] + 10;

if ($arVisual['OFFERS']['VIEW'] === 'extended' && $arVisual['IMAGE']['NAV'])
    $arVisual['IMAGE']['NAV'] = true;

if (empty($arResult['NAV_STRING'])) {
    $arVisual['NAVIGATION']['TOP']['SHOW'] = false;
    $arVisual['NAVIGATION']['BOTTOM']['SHOW'] = false;
}

$arRatio = explode(':', $arParams['IMAGE_ASPECT_RATIO']);

if (count($arRatio) >= 2) {
    $arRatio[0] = Type::toFloat($arRatio[0]);
    $arRatio[1] = Type::toFloat($arRatio[1]);

    if ($arRatio[0] <= 0)
        $arRatio[0] = 1;

    if ($arRatio[1] <= 0)
        $arRatio[1] = 1;

    $arVisual['IMAGE']['ASPECT_RATIO'] = floor(100 * $arRatio[1] / $arRatio[0]);
}

unset($arRatio);

$arResult['ACTION'] = ArrayHelper::fromRange([
    'none',
    'buy',
    'detail',
    'order'
], $arParams['ACTION']);

$arResult['DELAY'] = [
    'USE' => $arParams['DELAY_USE'] === 'Y'
];

if ($arResult['ACTION'] !== 'buy' || $bLite)
    $arResult['DELAY']['USE'] = false;

$arResult['COMPARE'] = [
    'USE' => $arParams['USE_COMPARE'] === 'Y',
    'CODE' => $arParams['COMPARE_NAME']
];

if (empty($arResult['COMPARE']['CODE']))
    $arResult['COMPARE']['USE'] = false;

$arResult['FORM'] = [
    'SHOW' => true,
    'ID' => $arParams['FORM_ID'],
    'TEMPLATE' => $arParams['FORM_TEMPLATE'],
    'PROPERTIES' => [
        'PRODUCT' => $arParams['FORM_PROPERTY_PRODUCT']
    ]
];

if (empty($arResult['FORM']['ID']))
    $arResult['FORM']['SHOW'] = false;

$arUrl['URL'] = [
    'BASKET' => $arParams['BASKET_URL'],
    'CONSENT' => $arParams['CONSENT_URL']
];

foreach ($arUrl['URL'] as $sKey => $sUrl)
    $arResult['URL'][$sKey] = StringHelper::replaceMacros($sUrl, $arMacros);

if ($bSeo) {
    $arSeo = $APPLICATION->IncludeComponent('intec.seo:iblocks.elements.modifier', '', [
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'SECTION_ID' => $arParams['SECTION_ID'],
        'SECTION_CODE' => $arParams['SECTION_CODE'],
        'ITEMS' => $arResult['ITEMS'],
        'PAGE_USE' => 'Y',
        'PAGE_COUNT' => !empty($arResult['NAV_RESULT']) ? $arResult['NAV_RESULT']->NavPageCount : null,
        'PAGE_SIZE' => !empty($arResult['NAV_RESULT']) ? $arResult['NAV_RESULT']->NavPageSize : null,
        'PAGE_NUMBER' => !empty($arResult['NAV_RESULT']) ? $arResult['NAV_RESULT']->NavPageNomer : null,
        'CACHE_TYPE' => 'N'
    ], $component);

    if (!empty($arSeo))
        $arResult['ITEMS'] = $arSeo['ITEMS'];

    foreach ($arResult['ITEMS'] as $arItem) {
        $arItems[] = $arItem['ID'];
    }

    $GLOBALS['arCatalogSectionsExtendingFilterMainItems'] = $arItems;
}

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['ACTION'] = $arResult['ACTION'];
    $arItem['DELAY'] = [
        'USE' => $arResult['DELAY']['USE']
    ];

    $arOrderUse = ArrayHelper::getValue($arItem, [
        'PROPERTIES',
        $arParams['PROPERTY_ORDER_USE'],
        'VALUE'
    ]);

    if (!empty($arOrderUse) && $arItem['ACTION'] === 'buy' && !empty($arResult['FORM']['ID'])) {
        $arItem['ACTION'] = 'order';
        $arItem['DELAY']['USE'] = false;
    }

    $arItem['MARKS'] = [
        'SHOW' => false,
        'VALUES' => [
            'RECOMMEND' => ArrayHelper::getValue($arItem, ['PROPERTIES', $arCodes['MARKS']['RECOMMEND'], 'VALUE']),
            'NEW' => ArrayHelper::getValue($arItem, ['PROPERTIES', $arCodes['MARKS']['NEW'], 'VALUE']),
            'HIT' => ArrayHelper::getValue($arItem, ['PROPERTIES', $arCodes['MARKS']['HIT'], 'VALUE'])
        ]
    ];

    foreach ($arItem['MARKS']['VALUES'] as $key => &$markValue) {
        $markValue = !empty($markValue);

        if ($markValue && $arVisual['MARKS']['SHOW'] && !$arItem['MARKS']['SHOW'])
            $arItem['MARKS']['SHOW'] = true;
    }

    unset($arItem, $key, $markValue);
}

if ($bLite)
    include(__DIR__.'/modifiers/lite/catalog.php');

include(__DIR__.'/modifiers/pictures.php');
include(__DIR__.'/modifiers/properties.php');
include(__DIR__.'/modifiers/quick.view.php');

if ($arVisual['TIMER']['SHOW']) {
    include(__DIR__.'/modifiers/timer.php');
}

if ($bBase)
    include(__DIR__.'/modifiers/base/catalog.php');

if ($bBase || $bLite)
    include(__DIR__.'/modifiers/catalog.php');

$arResult['VISUAL'] = $arVisual;