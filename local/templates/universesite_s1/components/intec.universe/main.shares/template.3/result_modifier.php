<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\Core;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\template\Properties;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'SETTINGS_USE' => 'N',
    'LAZYLOAD_USE' => 'N'
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

if (!defined('EDITOR')) {
    if ($arResult['NAVIGATION']['USE'] && $arResult['NAVIGATION']['MODE'] === 'ajax')
        Core::setAlias('@intec/template', $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/classes');
}

if ($arParams['SETTINGS_USE'] === 'Y')
    include(__DIR__.'/modifiers/settings.php');

/** Коды свойств */
$arResult['PROPERTY_CODES'] = [
    'PRICE' => ArrayHelper::getValue($arParams, 'PROPERTY_PRICE')
];

/** Обработка настроенных параметров компонента */
$iLineCount = ArrayHelper::getValue($arParams, 'LINE_COUNT');

if ($iLineCount <= 2)
    $iLineCount = 2;

if ($iLineCount >= 4)
    $iLineCount = 4;

$arVisual = ArrayHelper::merge($arResult['VISUAL'], [
    'LAZYLOAD' => [
        'USE' => !defined('EDITOR') ? $arParams['LAZYLOAD_USE'] === 'Y' : false,
        'STUB' => !defined('EDITOR') ? Properties::get('template-images-lazyload-stub') : null
    ],
    'LINE_COUNT' => $iLineCount,
    'LINK_USE' => ArrayHelper::getValue($arParams, 'LINK_USE') == 'Y',
    'DESCRIPTION_USE' => ArrayHelper::getValue($arParams, 'DESCRIPTION_USE') == 'Y'
]);

$arResult['VISUAL'] = $arVisual;

unset($arVisual);

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['PREVIEW_PICTURE'])) {
        $sImage = $arItem['PREVIEW_PICTURE'];
    } else if (!empty($arItem['DETAIL_PICTURE'])) {
        $sImage = $arItem['DETAIL_PICTURE'];
    }

    $sImage = CFile::ResizeImageGet($sImage, array(
        'width' => 600,
        'height' => 600
    ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

    $arItem['PREVIEW_PICTURE']['SRC'] = !empty($sImage['src']) ? $sImage['src'] : null;
}

/** Параметры кнопки "Показать все" */
$sFooterText = ArrayHelper::getValue($arParams, 'SEE_ALL_TEXT');
$sFooterText = trim($sFooterText);
$sListPage = ArrayHelper::getValue($arParams, 'LIST_PAGE_URL');

if (!empty($sListPage)) {
    $sListPage = trim($sListPage);
    $sListPage = StringHelper::replaceMacros($sListPage, $arMacros);
} else {
    $sListPage = ArrayHelper::getFirstValue($arResult['ITEMS']);
    $sListPage = $sListPage['LIST_PAGE_URL'];
}

$bFooterShow = ArrayHelper::getValue($arParams, 'SEE_ALL_SHOW');
$bFooterShow = $bFooterShow == 'Y' && !empty($sFooterText) && !empty($sListPage);

$arResult['FOOTER_BLOCK'] = [
    'SHOW' => $bFooterShow,
    'POSITION' => ArrayHelper::getValue($arParams, 'SEE_ALL_POSITION'),
    'TEXT' => $sFooterText,
    'LIST_PAGE' => $sListPage
];