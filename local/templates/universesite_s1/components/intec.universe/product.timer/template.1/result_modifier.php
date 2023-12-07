<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\template\Properties;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arParams = ArrayHelper::merge([
    'SETTINGS_USE' => 'N',
    'LAZYLOAD_USE' => 'N',
    'TIMER_TITLE_SHOW' => 'N',
    'TIMER_TITLE_ENTER' => 'N',
    'TIMER_TITLE_VALUE' => null,
    'TIMER_QUANTITY_OVER' => 'Y'
], $arParams);

if ($arParams['SETTINGS_USE'] === 'Y')
    include(__DIR__.'/modifiers/settings.php');

$arVisual = [
    'LAZYLOAD' => [
        'USE' => $arParams['LAZYLOAD_USE'] === 'Y',
        'STUB' => null
    ],
    'SECTION' => $arParams['IS_SECTION'],
    'QUANTITY' => [
        'OVER' => $arParams['TIMER_QUANTITY_OVER'] === 'Y'
    ],
    'TITLE' => [
        'SHOW' => $arParams['TIMER_TITLE_SHOW'] === 'Y',
        'ENTER' => $arParams['TIMER_TITLE_ENTER'] === 'Y',
        'VALUE' => null
    ]
];

 if ($arVisual['QUANTITY']['OVER']) {
     if ($arResult['DATA']['TIMER']['PRODUCT']['QUANTITY'] > 999)
        $arResult['DATA']['TIMER']['PRODUCT']['QUANTITY'] = '999+';
 } else {
     $arResult['DATA']['TIMER']['PRODUCT']['QUANTITY'] = number_format($arResult['DATA']['TIMER']['PRODUCT']['QUANTITY'], 0, ',', ' ');
 }

if (!empty($arResult['VISUAL']['TITLE']['VALUE']))
     $arVisual['TITLE']['VALUE'] = $arResult['VISUAL']['TITLE']['VALUE'];

if ($arVisual['TITLE']['SHOW'] && $arVisual['TITLE']['ENTER']) {
     if (!empty(trim($arParams['TIMER_TITLE_VALUE']))) {
         $arVisual['TITLE']['VALUE'] = $arParams['TIMER_TITLE_VALUE'];
     }
 }

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

$arResult['VISUAL'] = ArrayHelper::merge($arResult['VISUAL'],$arVisual);