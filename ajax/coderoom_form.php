<?php require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Context;
use \Bitrix\Main\Loader;

Loader::includeModule('iblock');

$request = Context::getCurrent()->getRequest();
$obElement = new CIBlockElement;

$PROP = [];
$PROP['NAME'] = $request["name"];
$PROP['PHONE'] = $request["phone"];

$arData = [
    'IBLOCK_ID' => 43,
    'PROPERTY_VALUES' => $PROP,
    'NAME' => $PROP['NAME'],
];

$obElement->Add($arData);