<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\template\Properties;

if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0) {
    $APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

if ($arParams['SETTINGS_USE'] === 'Y') {
    if (!Properties::get('basket-use')) {
        $arParams['SHOW_BASKET_PAGE'] = 'N';
    }
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arResult['PATH_TO_ORDERS'],
        "NAME" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
        "ICON" => '<i class="fa fa-calculator"></i>'
    );
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arResult['PATH_TO_ACCOUNT'],
        "NAME" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
        "ICON" => '<i class="fa fa-credit-card"></i>'
    );
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arResult['PATH_TO_PRIVATE'],
        "NAME" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
        "ICON" => '<i class="fa fa-user-secret"></i>'
    );
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y') {
    $delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
    $arResult['ITEMS'][] = array(
        "PATH" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
        "NAME" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
        "ICON" => '<i class="fa fa-list-alt"></i>'
    );
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arResult['PATH_TO_PROFILE'],
        "NAME" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
        "ICON" => '<i class="fa fa-list-ol"></i>'
    );
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arParams['PATH_TO_BASKET'],
        "NAME" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
        "ICON" => '<i class="fa fa-shopping-cart"></i>'
    );
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arResult['PATH_TO_SUBSCRIBE'],
        "NAME" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
        "ICON" => '<i class="fas fa-star"></i>'
    );
}

if ($arParams['MAILING_SHOW'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arParams['MAILING_PATH'],
        "NAME" => Loc::getMessage("SPS_MAILING_PAGE_NAME"),
        "ICON" => '<i class="fa fa-envelope"></i>'
    );
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y') {
    $arResult['ITEMS'][] = array(
        "PATH" => $arParams['PATH_TO_CONTACT'],
        "NAME" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
        "ICON" => '<i class="fa fa-info-circle"></i>'
    );
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList) {
    foreach ($customPagesList as $page) {
        $arResult['ITEMS'][] = array(
            "PATH" => $page[0],
            "NAME" => $page[1],
            "ICON" => (strlen($page[2])) ? '<i class="fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
        );
    }
}