<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\Core;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;
use intec\template\Properties;
use intec\core\helpers\FileHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

$arParams = ArrayHelper::merge([
    'LAZYLOAD_USE' => 'N',

    'VIDEO_SHOW' => 'Y',
    'BIG_VIDEO_USE' => 'Y',
    'SHOW_FULL_COMMENT' => null,
    'IMAGE_SHOW' => 'Y,',
    'ANSWER_SHOW' => 'Y',
    'PROPERTY_ANSWER_DEFAULT_IMAGE' => null,
    'PROPERTY_ANSWER_DEFAULT_NAME' => null,
    'PROPERTY_ANSWER_DEFAULT_POSITION' => null,
    'DOCUMENTS_SHOW' => 'Y',
    'DOCUMENTS_DOWNLOAD' => 'N',
    'RATING_SHOW' => 'Y',
    'RATING_MAX' => 5,
    'PROPERTY_IMAGE' => null,
    'PROPERTY_DOCUMENTS' => null,
    'PROPERTY_RATING' => null,
    'PROPERTY_VIDEO' => null,
    'PROPERTY_BIG_VIDEO' => null,
    'VIDEO_IBLOCK_PROPERTY_LINK' => null,
    'VIDEO_IMAGE_QUALITY' => null,

    'DATE_SHOW' => 'N',
    'DATE_TYPE' => 'DATE_ACTIVE_FROM',
    'DATE_FORMAT' => 'd.m.Y',
], $arParams);

$arResult['VIDEO_IBLOCK_ID'] = $arParams['VIDEO_IBLOCK_ID'];


$arVisual = [
    'LAZYLOAD' => [
        'USE' => $arParams['LAZYLOAD_USE'] === 'Y',
        'STUB' => null
    ],
    'VIDEO' => [
        'SHOW' => $arParams['VIDEO_SHOW'] === 'Y',
        'BIG' => [
          'USE' => $arParams['BIG_VIDEO_USE'] === 'Y',
          'FULL' => $arParams['SHOW_FULL_COMMENT'] === 'Y',
        ],
        'IMAGE' => [
            'QUALITY' => ArrayHelper::fromRange([
                'mqdefault',
                'hqdefault',
                'sddefault',
                'maxresdefault'
            ],$arParams['VIDEO_IMAGE_QUALITY'])
        ]
    ],
    'BUTTON' => [
        'REVIEWS' => $arParams['REVIEWS_BUTTON_SHOW'] === 'Y',
    ],
    'IMAGE' => [
        'SHOW' => $arParams['IMAGE_SHOW'] === 'Y'
    ],
    'DOCUMENTS' => [
        'SHOW' => $arParams['DOCUMENTS_SHOW'] === 'Y',
        'DOWNLOAD' => $arParams['DOCUMENTS_DOWNLOAD'] === 'Y'
    ],
    'RATING' => [
        'SHOW' => $arParams['RATING_SHOW'] === 'Y',
        'MAX' => ArrayHelper::fromRange([ 5, 10], Type::toInteger($arParams['RATING_MAX']))
    ],
    'ANSWER' => [
        'SHOW' => $arParams['ANSWER_SHOW'],
        'DEFAULT' => [
            'IMAGE' => $arParams['PROPERTY_ANSWER_DEFAULT_IMAGE'],
            'NAME' => $arParams['PROPERTY_ANSWER_DEFAULT_NAME'],
            'POSITION' => $arParams['PROPERTY_ANSWER_DEFAULT_POSITION']
        ]
    ],
    'DATE' => [
        'SHOW' => $arParams['DATE_SHOW'] === 'Y',
        'TYPE' => ArrayHelper::fromRange([
            'DATE_ACTIVE_FROM',
            'DATE_CREATE',
            'DATE_ACTIVE_TO',
            'TIMESTAMP_X'
        ], $arParams['DATE_TYPE']),
        'FORMAT' => $arParams['DATE_FORMAT']
    ]
];

if (defined('EDITOR'))
    $arVisual['LAZYLOAD']['USE'] = false;

if ($arVisual['LAZYLOAD']['USE'])
    $arVisual['LAZYLOAD']['STUB'] = Properties::get('template-images-lazyload-stub');



/*видео*/
if(!empty($arParams['VIDEO_IBLOCK_ID']) && $arParams['VIDEO_SHOW'] === 'Y'){

    $arVideos = [];


    $hGetProperty = function (&$arItem, $property) {

        $property = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $property,
            'VALUE'
        ]);

        if (!empty($property)) {
            if (Type::isArray($property))
                $property = ArrayHelper::getFirstValue($property);

            return $property;
        }

        return null;
    };


    foreach ($arResult['ITEMS'] as &$arItem) {
        $arItem['DATA'] = [];

        if (!empty($arParams['PROPERTY_RATING'])) {
            $arProperty = $hGetProperty($arItem, $arParams['PROPERTY_RATING']);

            if (!empty($arProperty))
                $arItem['DATA']['RATING'] = $arProperty;
        }

        if (!empty($arParams['VIDEO_IBLOCK_ID']) &&
            !empty($arParams['PROPERTY_VIDEO']) &&
            !empty($arParams['VIDEO_IBLOCK_PROPERTY_LINK'])
        ) {
            $arProperty = ArrayHelper::getValue($arItem, [
                'PROPERTIES',
                $arParams['PROPERTY_VIDEO'],
                'VALUE'
            ]);

            if (!empty($arProperty)) {
                $arVideos[] = $arProperty;
            }
        }
    }

    unset($arItem);

    if (!empty($arVideos)) {
        $youtube = function ($url) {
            $arrUrl = parse_url($url);

            if (isset($arrUrl['query'])) {
                $arrUrlGet = explode('&', $arrUrl['query']);
                foreach ($arrUrlGet as $value) {
                    $arrGetParam = explode('=', $value);
                    if (!strcmp(array_shift($arrGetParam), 'v')) {
                        $videoID = array_pop($arrGetParam);
                        break;
                    }
                }
                if (empty($videoID)) {
                    $videoID = array_pop(explode('/', $arrUrl['path']));
                }
            } else {
                $videoID = array_pop(explode('/', $url));
            }

            return [
                'iframe' => 'https://www.youtube.com/embed/'.$videoID,
                'src' => 'https://www.youtube.com/watch?v='.$videoID,
                'mqdefault' => 'https://img.youtube.com/vi/'.$videoID.'/mqdefault.jpg',
                'hqdefault' => 'https://img.youtube.com/vi/'.$videoID.'/hqdefault.jpg',
                'sddefault' => 'https://img.youtube.com/vi/'.$videoID.'/sddefault.jpg',
                'maxresdefault' => 'https://img.youtube.com/vi/'.$videoID.'/maxresdefault.jpg',
                'id' => $videoID
            ];
        };

        $arVideosData = [];
        $rsVideos = CIBlockElement::GetList([], [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $arParams['VIDEO_IBLOCK_ID'],
            'ID' => $arVideos
        ]);

        while ($arVideo = $rsVideos->GetNextElement()) {
            $arData = $arVideo->GetFields();
            $arData['PROPERTIES'] = $arVideo->GetProperties();

            $arVideosData[$arData['ID']] = $arData['PROPERTIES'][$arParams['VIDEO_IBLOCK_PROPERTY_LINK']]['VALUE'];

            if (Type::isArray($arVideosData[$arData['ID']]))
                $arVideosData[$arData['ID']] = ArrayHelper::getFirstValue($arVideosData[$arData['ID']]);
        }

        unset($rsVideos, $arVideo, $arData);

        if (!empty($arVideosData)) {
            foreach ($arVideosData as &$arItem) {
                $arItem = $youtube($arItem);
            }

            unset($arItem);

            $arVideosData = Arrays::from($arVideosData);

            foreach ($arResult['ITEMS'] as &$arItem) {
                $arProperty = ArrayHelper::getValue($arItem, [
                    'PROPERTIES',
                    $arParams['PROPERTY_VIDEO'],
                    'VALUE'
                ]);
                $arPropertyBigVideo= ArrayHelper::getValue($arItem, [
                    'PROPERTIES',
                    $arParams['PROPERTY_VIDEO'],
                    'VALUE'
                ]);

                if (!empty($arProperty)) {
                    foreach ($arProperty as $val){
                        if ($arVideosData->exists($val))
                            $arItem['DATA']['VIDEO']['ITEMS'][] = $arVideosData->get($val);
                    }

                }

                if($arVisual['VIDEO']['BIG']['USE'])
                    $arItem['DATA']['VIDEO']['BIG'] = $arItem['PROPERTIES'][$arParams['PROPERTY_BIG_VIDEO']]['VALUE_XML_ID'];

            }

            unset($arItem);
        }

        unset($youtube, $arVideosData);
    }

    unset($arProperty);

}

if($arVisual['DATE']['SHOW']){
    foreach ($arResult['ITEMS'] as &$arItem) {
        $sDate = ArrayHelper::getValue($arItem, $arVisual['DATE']['TYPE']);

        if (empty($sDate))
            $sDate = $arItem['DATE_CREATE'];

        if (!empty($arVisual['DATE']['FORMAT']))
            $sDate = CIBlockFormatProperties::DateFormat(
                $arVisual['DATE']['FORMAT'],
                MakeTimeStamp($sDate, CSite::GetDateFormat())
            );

        $arItem['DATA']['DATE'] = trim($sDate);

        unset($sDate);
    }
}
if($arVisual['ANSWER']['SHOW'] === 'Y'){
    foreach ($arResult['ITEMS'] as &$arItem) {
        $arAnswer = [
            'IMAGE' => $arItem['PROPERTIES'][$arParams['ANSWER_PICTURE']]['VALUE'],
            'NAME' => $arItem['PROPERTIES'][$arParams['ANSWER_NAME']]['VALUE'],
            'POSITION' => $arItem['PROPERTIES'][$arParams['ANSWER_POSITION']]['VALUE'],
            'TEXT' => $arItem['PROPERTIES'][$arParams['ANSWER_TEXT']]['VALUE'],
        ];

        if(!empty($arItem['PROPERTIES'][$arParams['ANSWER_PICTURE']]['VALUE']) ||
            !empty($arItem['PROPERTIES'][$arParams['ANSWER_NAME']]['VALUE']) ||
            !empty($arItem['PROPERTIES'][$arParams['ANSWER_POSITION']]['VALUE']) ||
            !empty($arItem['PROPERTIES'][$arParams['ANSWER_TEXT']]['VALUE'])){
            $arItem['DATA']['ANSWER'] = [
                'PICTURE' => $arItem['PROPERTIES'][$arParams['ANSWER_PICTURE']]['VALUE'],
                'NAME' => $arItem['PROPERTIES'][$arParams['ANSWER_NAME']]['VALUE'],
                'POSITION' => $arItem['PROPERTIES'][$arParams['ANSWER_POSITION']]['VALUE'],
                'TEXT' => $arItem['PROPERTIES'][$arParams['ANSWER_TEXT']]['VALUE'],
            ];

        }
    }

}

if($arVisual['DOCUMENTS']['SHOW'] == 'Y'){

    $file = null;
    $arFileproperty = null;

    foreach ($arResult['ITEMS'] as &$arItem) {
        if(!empty($arItem['PROPERTIES'][$arParams['PROPERTY_DOCUMENTS']]['VALUE'])){
            $file = $arItem['PROPERTIES'][$arParams['PROPERTY_DOCUMENTS']]['VALUE'];
            foreach ($file as $fileItem){
                $arFileproperty = CFile::GetFileArray($fileItem);
                if(!empty($arFileproperty)){
                    $filename = FileHelper::getFileNameWithoutExtension($arFileproperty['ORIGINAL_NAME']);
                    if (empty($filename))
                        $filename = $arFileproperty['ORIGINAL_NAME'];
                    $arItem['DATA']['DOCUMENTS'][] = [
                        'ID' => $arFileproperty['ID'],
                        'SIZE' => CFile::FormatSize($arFileproperty['FILE_SIZE']),
                        'NAME' => $filename,
                        'TYPE' => FileHelper::getFileExtension($arFileproperty['FILE_NAME']),
                        'SRC' => $arFileproperty['SRC']
                    ];
                }
            }
        }
    }
    unset($file,$filename,$arFileproperty);
}



if (defined('EDITOR'))
    $arVisual['LAZYLOAD']['USE'] = false;

if ($arVisual['LAZYLOAD']['USE'])
    $arVisual['LAZYLOAD']['STUB'] = Properties::get('template-images-lazyload-stub');

if ($arVisual['VIDEO']['SHOW'] && empty($arVideos))
    $arVisual['VIDEO']['SHOW'] = false;

if ($arVisual['SLIDER']['AUTO']['TIME'] < 1)
    $arVisual['SLIDER']['AUTO']['TIME'] = 10000;

$arResult['VISUAL'] = ArrayHelper::merge($arResult['VISUAL'], $arVisual);

unset($arVisual, $arVideos);

if (!empty($arParams['LIST_PAGE_URL']))
    $arButtons['SHOW_ALL']['LINK'] = StringHelper::replaceMacros(
        $arParams['LIST_PAGE_URL'],
        $arMacros
    );

unset($arMacros);






















