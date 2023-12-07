<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Loader;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;
use intec\regionality\Module as Regionality;
use intec\regionality\models\Region;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

$arParams = ArrayHelper::merge([
    'SETTINGS_USE' => 'N',
    'REGIONALITY_USE' => 'N',
    'REGIONALITY_FILTER_USE' => 'N',
    'REGIONALITY_FILTER_PROPERTY' => null,
    'REGIONALITY_FILTER_STRICT' => 'N',
    'REGIONALITY_PRICES_TYPES_USE' => 'N',
    'REGIONALITY_STORES_USE' => 'N',
    'SEF_TABS_USE' => 'N',

    'INTEREST_PRODUCTS_SHOW' => 'N',
    'INTEREST_PRODUCTS_CATEGORIES_PROPERTY_USE' => 'N',
    'INTEREST_PRODUCTS_CATEGORIES_PROPERTY' => null,
    'INTEREST_PRODUCTS_CATEGORIES' => null,
    'INTEREST_PRODUCTS_TITLE' => null,
    'INTEREST_PRODUCTS_POSITION' => 'footer',

    'ADDITIONAL_ARTICLES_SHOW' => 'N',
    'ADDITIONAL_ARTICLES_HEADER_SHOW' => 'N',
    'ADDITIONAL_ARTICLES_HEADER_TEXT' => null,
], $arParams);

if (empty($arParams['FILTER_NAME']))
    $arParams['FILTER_NAME'] = 'arrCatalogFilter';

if ($arParams['SETTINGS_USE'] === 'Y')
    include(__DIR__.'/modifiers/settings.php');

$arIBlock = null;
$arSection = null;

if (!empty($arParams['IBLOCK_ID'])) {
    $oCache = Cache::createInstance();
    $arFilter = [
        'ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y'
    ];

    if ($oCache->initCache(36000, 'IBLOCK'.serialize($arFilter), '/iblock/catalog')) {
        $arIBlock = $oCache->getVars();
    } else if ($oCache->startDataCache()) {
        $arIBlocks = Arrays::fromDBResult(CIBlock::GetList([], $arFilter));
        $arIBlock = $arIBlocks->getFirst();
        $oCache->endDataCache($arIBlock);
    }
}

if (
    !empty($arResult['VARIABLES']['SECTION_ID']) ||
    !empty($arResult['VARIABLES']['SECTION_CODE'])
) {
    $oCache = Cache::createInstance();
    $arFilter = [
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y',
        'GLOBAL_ACTIVE' => 'Y'
    ];

    if (!empty($arResult['VARIABLES']['SECTION_ID'])) {
        $arFilter['ID'] = $arResult['VARIABLES']['SECTION_ID'];
    } else {
        $arFilter['CODE'] = $arResult['VARIABLES']['SECTION_CODE'];
    }

    if ($oCache->initCache(36000, 'SECTION'.serialize($arFilter), '/iblock/catalog')) {
        $arSection = $oCache->getVars();
    } else if ($oCache->startDataCache()) {
        $arSections = Arrays::fromDBResult(CIBlockSection::GetList([], $arFilter, false, [
            '*',
            'UF_*'
        ]));

        $arSection = $arSections->getFirst();
        $oCache->endDataCache($arSection);
    }
}

$arResult['IBLOCK'] = $arIBlock;
$arResult['SECTION'] = $arSection;

$arResult['REGIONALITY'] = [
    'USE' => $arParams['REGIONALITY_USE'] === 'Y',
    'FILTER' => [
        'USE' => $arParams['REGIONALITY_FILTER_USE'] === 'Y',
        'PROPERTY' => $arParams['REGIONALITY_FILTER_PROPERTY'],
        'STRICT' => $arParams['REGIONALITY_FILTER_STRICT'] === 'Y'
    ],
    'PRICES' => [
        'USE' => $arParams['REGIONALITY_PRICES_TYPES_USE'] === 'Y'
    ],
    'STORES' => [
        'USE' => $arParams['REGIONALITY_STORES_USE'] === 'Y'
    ]
];

$arResult['PRODUCTS'] = [
    'INTEREST' => [
        'SHOW' => $arParams['INTEREST_PRODUCTS_SHOW'] === 'Y',
        'PROPERTY' => [
            'USE' => $arParams['INTEREST_PRODUCTS_CATEGORIES_PROPERTY_USE'] === 'Y',
            'VALUE' => $arParams['INTEREST_PRODUCTS_CATEGORIES_PROPERTY'],
            'NAME' => null,
        ],
        'TITLE' => $arParams['INTEREST_PRODUCTS_TITLE'],
        'COUNT' => $arParams['INTEREST_PRODUCTS_COUNT'] > 0 ? $arParams['INTEREST_PRODUCTS_COUNT'] : 1,
        'POSITION' => $arParams['INTEREST_PRODUCTS_POSITION'],
        'CATEGORIES' => $arParams['INTEREST_PRODUCTS_CATEGORIES']
    ],
];

$arResult['ADDITIONAL'] = [
    'ARTICLES' => [
        'SHOW' => $arParams['ADDITIONAL_ARTICLES_SHOW'] === 'Y' && !empty($arParams['PROPERTY_ADDITIONAL_ARTICLES']),
        'HEADER' => [
            'SHOW' => $arParams['ADDITIONAL_ARTICLES_HEADER_SHOW'] === 'Y',
            'TEXT' => $arParams['~ADDITIONAL_ARTICLES_HEADER_TEXT']
        ]
    ],
];

/** Статьи */

/*$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'],'ID'=>$arResult['SECTION']['ID'], 'GLOBAL_ACTIVE'=>'Y');
$db_list = CIBlockSection::GetList([], $arFilter, false, Array("UF_ADD_ARTICLE"));
if($uf_value = $db_list->GetNext()) {
    $link = $uf_value["UF_ADD_ARTICLE"];
}*/

$arAdditional = function ($paramName) use (&$arResult, &$arParams) {

    $arAdditional = [];

    if (!empty($arParams[$paramName])) {
        $arProperty = ArrayHelper::getValue($arResult, [
            'SECTION',
            $arParams[$paramName]
        ]);

        if (!empty($arProperty)) {
            foreach ($arProperty as $sValue) {
                if (!empty($sValue))
                    $arAdditional[] = $sValue;
            }

        }

    }

    return $arAdditional;
};

$arAdditionalArticles = $arAdditional('PROPERTY_ADDITIONAL_ARTICLES');

if ($arResult['ADDITIONAL']['ARTICLES']['SHOW'] && empty($arAdditionalArticles))
    $arResult['ADDITIONAL']['ARTICLES']['SHOW'] = false;

if (!empty($arAdditionalArticles))
    $arResult['ADDITIONAL']['ARTICLES']['VALUE'] = $arAdditionalArticles;

unset($arAdditionalArticles);

if (empty($arIBlock) || !Loader::includeModule('intec.regionality'))
    $arResult['REGIONALITY']['USE'] = false;

if (empty($arResult['REGIONALITY']['FILTER']['PROPERTY']))
    $arResult['REGIONALITY']['FILTER']['USE'] = false;

$arResult['PARAMETERS'] = [
    'COMMON' => [
        'FORM_ID',
        'FORM_TEMPLATE',
        'FORM_PROPERTY_PRODUCT',
        'PROPERTY_MARKS_RECOMMEND',
        'PROPERTY_MARKS_NEW',
        'PROPERTY_MARKS_HIT',
        'PROPERTY_ORDER_USE',
        'CONSENT_URL',
        'LAZY_LOAD',
        'VOTE_MODE',
        'DELAY_USE',
        'QUANTITY_MODE',
        'QUANTITY_BOUNDS_FEW',
        'QUANTITY_BOUNDS_MANY',

        'VIDEO_IBLOCK_TYPE',
        'VIDEO_IBLOCK_ID',
        'VIDEO_PROPERTY_URL',
        'SERVICES_IBLOCK_TYPE',
        'SERVICES_IBLOCK_ID',
        'REVIEWS_IBLOCK_TYPE',
        'REVIEWS_IBLOCK_ID',
        'REVIEWS_PROPERTY_ELEMENT_ID',
        'REVIEWS_USE_CAPTCHA',
        'PROPERTY_ARTICLE',
        'PROPERTY_BRAND',
        'PROPERTY_PICTURES',
        'PROPERTY_SERVICES',
        'PROPERTY_DOCUMENTS',
        'PROPERTY_ADDITIONAL',
        'PROPERTY_ASSOCIATED',
        'PROPERTY_RECOMMENDED',
        'PROPERTY_VIDEO',
        'OFFERS_PROPERTY_ARTICLE',
        'OFFERS_PROPERTY_PICTURES',

        'CONVERT_CURRENCY',
        'CURRENCY_ID',
        'PRICE_CODE'
    ]
];

if ($arResult['REGIONALITY']['USE']) {
    $oRegion = Region::getCurrent();

    if (!empty($oRegion)) {
        if ($arResult['REGIONALITY']['FILTER']['USE']) {
            if (!isset($GLOBALS[$arParams['FILTER_NAME']]) || !Type::isArray($GLOBALS[$arParams['FILTER_NAME']]))
                $GLOBALS[$arParams['FILTER_NAME']] = [];

            $arConditions = [
                'LOGIC' => 'OR',
                ['PROPERTY_'.$arResult['REGIONALITY']['FILTER']['PROPERTY'] => $oRegion->id]
            ];

            if (!$arResult['REGIONALITY']['FILTER']['STRICT'])
                $arConditions[] = ['PROPERTY_'.$arResult['REGIONALITY']['FILTER']['PROPERTY'] => false];

            $GLOBALS[$arParams['FILTER_NAME']][] = $arConditions;
        }

        if (Loader::includeModule('catalog') && Loader::includeModule('sale')) {
            if ($arResult['REGIONALITY']['PRICES']['USE']) {
                $arParams['FILTER_PRICE_CODE'] = $_SESSION[Regionality::VARIABLE][Region::VARIABLE]['PRICES']['CODE'];
                $arParams['PRICE_CODE'] = $_SESSION[Regionality::VARIABLE][Region::VARIABLE]['PRICES']['CODE'];
            }

            if ($arResult['REGIONALITY']['STORES']['USE'])
                $arParams['STORES'] = $_SESSION[Regionality::VARIABLE][Region::VARIABLE]['STORES']['ID'];
        } else if (Loader::includeModule('intec.startshop')) {
            if ($arResult['REGIONALITY']['PRICES']['USE'])
                $arParams['PRICE_CODE'] = $_SESSION[Regionality::VARIABLE][Region::VARIABLE]['PRICES']['CODE'];
        }
    }
}

if ($arParams['SEF_TABS_USE'] !== 'Y') {
    unset($arResult['URL_TEMPLATES']['tabs']);
    unset($arResult['VARIABLES']['TAB']);
}

if ($arParams['SEF_MODE'] === 'N') {
    if ($arParams['SEF_TABS_USE'] === 'Y') {
        $arResult['URL_TEMPLATES']['tabs'] = Html::encode($APPLICATION->GetCurPage()).'?'.
            $arResult['ALIASES']['SECTION_ID'].'=#SECTION_ID#&'.
            $arResult['ALIASES']['ELEMENT_ID'].'=#ELEMENT_ID#&'.
            $arResult['ALIASES']['TAB'].'=#TAB#';
    }
}

if ($arResult['PRODUCTS']['INTEREST']['PROPERTY']['USE']) {
    $property_name = CIBlockPropertyEnum::GetList(Array(), Array(
        "IBLOCK_ID" => $arIBlock['ID'],
        "CODE" => $arResult['PRODUCTS']['INTEREST']['PROPERTY']['VALUE'],
        "EXTERNAL_ID" => $arResult['PRODUCTS']['INTEREST']['CATEGORIES']));

    $arResult['PRODUCTS']['INTEREST']['PROPERTY']['NAME'] = $property_name->GetNext()['VALUE'];

    unset($property_name);
}