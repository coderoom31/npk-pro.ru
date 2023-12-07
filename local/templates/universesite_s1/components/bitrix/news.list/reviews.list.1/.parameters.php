<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;


if (!empty($arCurrentValues['IBLOCK_ID'])) {
    if (!empty($_REQUEST['site'])) {
        $sSite = $_REQUEST['site'];
    } else if (!empty($_REQUEST['src_site'])) {
        $sSite = $_REQUEST['src_site'];
    }
    if($arCurrentValues['VIDEO_SHOW'] === 'Y'){
        $arIBlockTypes = CIBlockParameters::GetIBlockTypes();
        $arIBlocksList = Arrays::fromDBResult(CIBlock::GetList([], [
            'ACTIVE' => 'Y',
            'SITE_ID' => $sSite
        ]))->indexBy('ID');
        if (!empty($arCurrentValues['VIDEO_IBLOCK_TYPE']))
            $arIBlocks = $arIBlocksList->asArray(function ($sKey, $arProperty) use (&$arCurrentValues) {
                if ($arProperty['IBLOCK_TYPE_ID'] === $arCurrentValues['VIDEO_IBLOCK_TYPE'])
                    return [
                        'key' => $arProperty['ID'],
                        'value' => '[' . $arProperty['ID'] . '] ' . $arProperty['NAME']
                    ];

                return ['skip' => true];
            });
        else
            $arIBlocks = $arIBlocksList->asArray(function ($sKey, $arProperty) {
                return [
                    'key' => $arProperty['ID'],
                    'value' => '['.$arProperty['ID'].'] '.$arProperty['NAME']
                ];
            });
    }


    $arProperties = Arrays::fromDBResult(CIBlockProperty::GetList(['SORT' => 'ASC'], [
        'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
        'ACTIVE' => 'Y'
    ]));


    $hPropertyFile = function ($id, $value) {
        if ($value['ACTIVE'] == 'Y' && $value['PROPERTY_TYPE'] === 'F')
            return [
                'key' => $value['CODE'],
                'value' => '['.$value['CODE'].'] '.$value['NAME']
            ];

        return ['skip' => true];
    };
    $hPropertyTextNumber = function ($sKey, $value) {
        if ($value['ACTIVE'] == 'Y' && $value['PROPERTY_TYPE'] == 'S' && $value['LIST_TYPE'] == 'L' && $value['MULTIPLE'] === 'N')
            return [
                'key' => $value['CODE'],
                'value' => '['.$value['CODE'].'] '.$value['NAME']
            ];

        if ($value['ACTIVE'] == 'Y' && $value['PROPERTY_TYPE'] === 'N' && $value['MULTIPLE'] === 'N')
            return [
                'key' => $value['CODE'],
                'value' => '['.$value['CODE'].'] '.$value['NAME']
            ];

        return ['skip' => true];
    };
    $hPropertyElement = function ($sKey, $value) {
        if ($value['ACTIVE'] == 'Y' && $value['PROPERTY_TYPE'] == 'E')
            return [
                'key' => $value['CODE'],
                'value' => '['.$value['CODE'].'] '.$value['NAME']
            ];

        return ['skip' => true];
    };
    $hPropertyList = function ($id, $value) {
        if ($value['ACTIVE'] == 'Y' && $value['PROPERTY_TYPE'] === 'L' && $value['LIST_TYPE'] === 'C')
            return [
                'key' => $value['CODE'],
                'value' => '['.$value['CODE'].'] '.$value['NAME']
            ];

        return ['skip' => true];
    };
    $hPropertyListMultiple = function ($id, $value) {
        if ($value['ACTIVE'] == 'Y' && $value['PROPERTY_TYPE'] === 'L' && $value['LIST_TYPE'] === 'L' && $value['MULTIPLE'] === 'Y')
            return [
                'key' => $value['CODE'],
                'value' => '['.$value['CODE'].'] '.$value['NAME']
            ];

        return ['skip' => true];
    };


    $arPropertyFile = $arProperties->asArray($hPropertyFile);
    $arPropertyElement = $arProperties->asArray($hPropertyElement);
    $arPropertyTextNumber = $arProperties->asArray($hPropertyTextNumber);
    $arPropertyListMultiple = $arProperties->asArray($hPropertyListMultiple);
    $arPropertyList = $arProperties->asArray($hPropertyList);
}

$arTemplateParameters = [];

$arTemplateParameters['LAZYLOAD_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_LAZYLOAD_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];


$arTemplateParameters['VIDEO_SHOW'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];
if (!empty($arCurrentValues['IBLOCK_ID']) && $arCurrentValues['VIDEO_SHOW'] === 'Y') {
    $arTemplateParameters['VIDEO_IBLOCK_TYPE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IBLOCK_TYPE'),
        'TYPE' => 'LIST',
        'VALUES' => $arIBlockTypes,
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];

    $arTemplateParameters['VIDEO_IBLOCK_ID'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IBLOCK_ID'),
        'TYPE' => 'LIST',
        'VALUES' => $arIBlocks,
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];
    if (!empty($arCurrentValues['VIDEO_IBLOCK_ID'])){
        $arVideoProperties = Arrays::fromDBResult(CIBlockProperty::GetList(['SORT' => 'ASC'], [
            'IBLOCK_ID' => $arCurrentValues['VIDEO_IBLOCK_ID'],
            'ACTIVE' => 'Y'
        ]));

        $hVideoPropertyText = function ($sKey, $value) {
            if ($value['ACTIVE'] == 'Y' && $value['PROPERTY_TYPE'] == 'S' && $value['LIST_TYPE'] == 'L' && $value['MULTIPLE'] === 'N')
                return [
                    'key' => $value['CODE'],
                    'value' => '['.$value['CODE'].'] '.$value['NAME']
                ];

            return ['skip' => true];
        };
        $arVideoPropertyText = $arVideoProperties->asArray($hVideoPropertyText);
    }

    $arTemplateParameters['BIG_VIDEO_USE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_BIG_VIDEO_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        'REFRESH' => 'Y'
    ];
    if ($arCurrentValues['BIG_VIDEO_USE'] === 'Y'){
        $arTemplateParameters['SHOW_FULL_COMMENT'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_BIG_VIDEO_SHOW_FULL_COMMENT'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
        ];
    }
}

$arTemplateParameters['ANSWER_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_ANSWER_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];
if ($arCurrentValues['ANSWER_SHOW'] === 'Y'){
    $arTemplateParameters['PROPERTY_ANSWER_DEFAULT_IMAGE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_ANSWER_DEFAULT_IMAGE'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ];
    $arTemplateParameters['PROPERTY_ANSWER_DEFAULT_NAME'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_ANSWER_DEFAULT_NAME'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ];
    $arTemplateParameters['PROPERTY_ANSWER_DEFAULT_POSITION'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_ANSWER_DEFAULT_POSITION'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ];

}


$arTemplateParameters['REVIEWS_BUTTON_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_REVIEWS_BUTTON_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y'
];
$arTemplateParameters['IMAGE_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_IMAGE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'N'
];
$arTemplateParameters['DOCUMENTS_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DOCUMENTS_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];
if ($arCurrentValues['DOCUMENTS_SHOW'] === 'Y'){
    $arTemplateParameters['DOCUMENTS_DOWNLOAD'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DOCUMENTS_DOWNLOAD'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'N'
    ];
}



$arTemplateParameters['RATING_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_RATING_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['RATING_SHOW'] === 'Y'){
    $arTemplateParameters['RATING_MAX'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_RATING_MAX'),
        'TYPE' => 'LIST',
        'VALUES' => ['5'=>'5', '10'=>'10'],
        'DEFAULT' => '5'
    ];
}

$arTemplateParameters['PROPERTY_IMAGE'] = [
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_IMAGE'),
    'TYPE' => 'LIST',
    'VALUES' => $arPropertyFile,
    'ADDITIONAL_VALUES' => 'Y'
];
$arTemplateParameters['PROPERTY_DOCUMENTS'] = [
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_DOCUMENTS'),
    'TYPE' => 'LIST',
    'VALUES' => $arPropertyFile,
    'ADDITIONAL_VALUES' => 'Y'
];
$arTemplateParameters['PROPERTY_RATING'] = [
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_RATING'),
    'TYPE' => 'LIST',
    'VALUES' => $arPropertyTextNumber,
    'ADDITIONAL_VALUES' => 'Y'
];
if ($arCurrentValues['BIG_VIDEO_USE'] === 'Y'){
    $arTemplateParameters['PROPERTY_BIG_VIDEO'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_BIG_VIDEO'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyList,
        'ADDITIONAL_VALUES' => 'Y'
    ];
}


if (!empty($arCurrentValues['IBLOCK_ID']) && $arCurrentValues['VIDEO_SHOW'] === 'Y'){
    $arTemplateParameters['PROPERTY_VIDEO'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_VIDEO'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyElement,
        'ADDITIONAL_VALUES' => 'Y'
    ];
    $arTemplateParameters['VIDEO_IBLOCK_PROPERTY_LINK'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IBLOCK_PROPERTY_LINK'),
        'TYPE' => 'LIST',
        'VALUES' => $arVideoPropertyText,
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];
}
if ($arCurrentValues['ANSWER_SHOW'] === 'Y'){
    $arTemplateParameters['ANSWER_PICTURE'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_ANSWER_PICTURE'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyFile,
        'ADDITIONAL_VALUES' => 'Y'
    ];
    $arTemplateParameters['ANSWER_NAME'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_ANSWER_NAME'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyTextNumber,
        'ADDITIONAL_VALUES' => 'Y'
    ];
    $arTemplateParameters['ANSWER_POSITION'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_ANSWER_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyTextNumber,
        'ADDITIONAL_VALUES' => 'Y'
    ];
    $arTemplateParameters['ANSWER_TEXT'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_PROPERTY_ANSWER_TEXT'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyTextNumber,
        'ADDITIONAL_VALUES' => 'Y'
    ];
}

if (
    !empty($arCurrentValues['VIDEO_IBLOCK_ID']) &&
    !empty($arCurrentValues['VIDEO_IBLOCK_PROPERTY_LINK'])
) {
    $arTemplateParameters['VIDEO_IMAGE_QUALITY'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IMAGE_QUALITY'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'mqdefault' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IMAGE_QUALITY_MQ'),
            'hqdefault' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IMAGE_QUALITY_HQ'),
            'sddefault' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IMAGE_QUALITY_SD'),
            'maxresdefault' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_VIDEO_IMAGE_QUALITY_MAXRES')
        ],
        'DEFAULT' => 'hqdefault'
    ];

}


$arTemplateParameters['DATE_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DATE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['DATE_SHOW'] === 'Y') {
    $arTemplateParameters['DATE_TYPE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DATE_TYPE'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'DATE_CREATE' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DATE_TYPE_CREATE'),
            'DATE_ACTIVE_FROM' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DATE_TYPE_ACTIVE_FROM'),
            'DATE_ACTIVE_TO' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DATE_TYPE_ACTIVE_TO'),
            'TIMESTAMP_X' => Loc::getMessage('C_REVIEWS_LIST_LIST_1_DATE_TYPE_TIMESTAMP_X')
        ],
        'DEFAULT' => 'DATE_ACTIVE_FROM'
    ];
    $arTemplateParameters['DATE_FORMAT'] = CIBlockParameters::GetDateFormat(
        Loc::getMessage('C_REVIEWS_LIST_LIST_1_DATE_FORMAT'),
        'VISUAL'
    );
}
