<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\StringHelper;
use intec\template\Properties;
use Bitrix\Main\Loader;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!Loader::includeModule('iblock'))
    return;

$arParams = ArrayHelper::merge([
    'HEADER_SHOW' => 'N',
    'HEADER_TEXT' => null,
    'HEADER_POSITION' => 'center',
    'DESCRIPTION_SHOW' => 'N',
    'DESCRIPTION_TEXT' => null,
    'DESCRIPTION_POSITION' => 'center',
    'FOOTER_SHOW' => 'N',
    'FOOTER_TEXT' => null,
    'FOOTER_POSITION' => 'center',
    'FOOTER_LINK' => null,
    'ITEM_DESCRIPTION_SHOW' => 'N',
    'ITEM_FIRST_BIG' => 'Y',
    'ITEM_FILL_BLOCKS' => 'Y',
    'ITEM_SHOW_MORE' => 'N',
    'ITEM_SHOW_MORE_IN' => 'mobile',
    'SETTINGS_USE' => 'N',
    'LAZYLOAD_USE' => 'N',
], $arParams);

if ($arParams['SETTINGS_USE'] === 'Y')
    include(__DIR__.'/modifiers/settings.php');

$arVisual = [
    'LAZYLOAD' => [
        'USE' => $arParams['LAZYLOAD_USE'] === 'Y',
        'STUB' => null
    ],
    'HEADER' => [
        'SHOW' => $arParams['HEADER_SHOW'] === 'Y' && !empty($arParams['HEADER_TEXT']),
        'TEXT' => $arParams['HEADER_TEXT'],
        'POSITION' => $arParams['HEADER_POSITION']
    ],
    'DESCRIPTION' => [
        'SHOW' => $arParams['DESCRIPTION_SHOW'] === 'Y' && !empty($arParams['DESCRIPTION_TEXT']),
        'TEXT' => $arParams['DESCRIPTION_TEXT'],
        'POSITION' => $arParams['DESCRIPTION_POSITION']
    ],
    'FOOTER' => [
        'SHOW' => $arParams['FOOTER_SHOW'] === 'Y',
        'TEXT' => !empty($arParams['FOOTER_TEXT']) ? $arParams['FOOTER_TEXT'] : Loc::getMessage('MAIN_INSTAGRAM_TEMP1_FOOTER_DEFAULT'),
        'POSITION' => $arParams['FOOTER_POSITION'],
        'LINK' => $arParams['FOOTER_LINK']
    ],
    'ITEMS' => [
        'BIG' => $arParams['ITEM_FIRST_BIG'] === 'Y',
        'FILL' => $arParams['ITEM_FILL_BLOCKS'] === 'Y',
        'MORE' => [
            'SHOW' => $arParams['ITEM_SHOW_MORE'] === 'Y',
            'VIEW' => [
                'MOBILE' => $arParams['ITEM_SHOW_MORE_IN'] === 'mobile' || $arParams['ITEM_SHOW_MORE_IN'] === 'both',
                'DESKTOP' => $arParams['ITEM_SHOW_MORE_IN'] === 'desktop' || $arParams['ITEM_SHOW_MORE_IN'] === 'both'
            ]
        ],
        'MAX' => [
            'DESKTOP' => 0,
            'LAPTOP' => 0,
            'MOBILE' => 0
        ],
        'DATE' => [
            'SHOW' => $arParams['ITEM_DATE_SHOW'] === 'Y',
            'FORMAT' => $arParams['ITEM_DATE_FORMAT']
        ],
        'DESCRIPTION' => [
            'SHOW' => $arParams['ITEM_DESCRIPTION_SHOW'] === 'Y',
        ]
    ]
];

$sDateFormat = $arParams['ITEM_DATE_FORMAT'];

foreach ($arResult['ITEMS'] as &$arItem) {
    $oDate = new DateTime($arItem['DATE']);
    $sDate = $oDate->format('d-m-Y H:i:s');

    if (!empty($sDateFormat)){
        if (!empty($sDate)) {
            $arItem['DATE'] = null;
            $arItem['DATE']['VALUE'] = $sDate;
            $arItem['DATE']['FORMATTED'] = CIBlockFormatProperties::DateFormat(
                $sDateFormat,
                MakeTimeStamp(
                    $sDate,
                    CSite::GetDateFormat()
                )
            );
        }
    }
    unset($sDate, $oDate);
}

$iItemsCount = count($arResult['ITEMS']);

if (!$arVisual['ITEMS']['BIG']) {
    $arVisual['ITEMS']['MORE']['SHOW'] = true;
    $arVisual['ITEMS']['MORE']['VIEW']['MOBILE'] = true;

    $iDesktopMax = intdiv($iItemsCount, 5);
    $iDesktopMax = $iDesktopMax * 5;
} else {
    $iDesktopMax = $iItemsCount - 7;
    $iDesktopMax = intdiv($iDesktopMax, 5);
    $iDesktopMax = ($iDesktopMax * 5) + 7;
}

$arVisual['ITEMS']['MAX']['DESKTOP'] = $iDesktopMax;

if ($arVisual['ITEMS']['MORE']['SHOW'] && !$arVisual['ITEMS']['MORE']['VIEW']['MOBILE'])
    $iItemsCount = 7;

$iLaptopMax = intdiv($iItemsCount, 3) * 3;
$arVisual['ITEMS']['MAX']['LAPTOP'] = $iLaptopMax;

$iMobileMax = intdiv($iItemsCount, 2) * 2;
$arVisual['ITEMS']['MAX']['MOBILE'] = $iMobileMax;


if (defined('EDITOR'))
    $arVisual['LAZYLOAD']['USE'] = false;

if ($arVisual['LAZYLOAD']['USE'])
    $arVisual['LAZYLOAD']['STUB'] = Properties::get('template-images-lazyload-stub');

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

$arVisual['FOOTER']['LINK'] = StringHelper::replaceMacros($arParams['FOOTER_LINK'], $arMacros);

$arResult['VISUAL'] = ArrayHelper::merge($arResult['VISUAL'], $arVisual);