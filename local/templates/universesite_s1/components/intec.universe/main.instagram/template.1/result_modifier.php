<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Type;
use intec\core\helpers\StringHelper;
use intec\template\Properties;

/**
 * @var array $arParams
 * @var array $arResult
 */

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
    'ITEM_PADDING_USE' => 'N',
    'ITEM_WIDE' => 'N',
    'ITEM_LINE_COUNT' => 5,
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
        'DESCRIPTION' => $arParams['ITEM_DESCRIPTION_SHOW'] === 'Y',
        'PADDING' => $arParams['ITEM_PADDING_USE'] === 'Y',
        'WIDE' => $arParams['ITEM_WIDE'] === 'Y',
        'COUNT' => $arParams['ITEM_LINE_COUNT']
    ]
];

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