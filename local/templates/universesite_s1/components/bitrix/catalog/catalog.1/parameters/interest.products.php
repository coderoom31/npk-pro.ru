<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arCurrentValues
 * @var string $componentName
 * @var string $componentTemplate
 * @var string $siteTemplate
 */

if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $arTemplateParameters['INTEREST_PRODUCTS_SHOW'] = [
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['INTEREST_PRODUCTS_SHOW'] === 'Y') {
        $arSectionsList = CIBlockSection::GetTreeList([
            'IBLOCK_ID' => $arIBlock['ID'],
            "ACTIVE" => "Y"
        ], [
            "ID",
            "NAME",
            "CODE"
        ]);

        $arSections [0] = Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_CATEGORIES_ALL');
        $arSections [1] = Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_CATEGORIES_DEFAULT');

        while($elements = $arSectionsList->GetNextElement()) {
            $element = $elements->GetFields();
            $arSections [$element['ID']] = '['.$element['CODE'].'] '.$element['NAME'];
        }

        $arTemplateParameters['INTEREST_PRODUCTS_TITLE'] = [
            'PARENT' => 'LIST_SETTINGS',
            'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCT_TITLE'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCT_NAME_DEFAULT')
        ];
        $arTemplateParameters['INTEREST_PRODUCTS_COUNT'] = [
            'PARENT' => 'LIST_SETTINGS',
            'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_COUNT'),
            'TYPE' => 'STRING',
            'DEFAULT' => 25
        ];

        $arTemplateParameters['INTEREST_PRODUCTS_POSITION'] = [
            'PARENT' => 'LIST_SETTINGS',
            'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_POSITION'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'content' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_POSITION_CONTENT'),
                'footer' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_POSITION_BOTTOM')
            ]
        ];

        $arTemplateParameters['INTEREST_PRODUCTS_CATEGORIES_PROPERTY_USE'] = [
            'PARENT' => 'LIST_SETTINGS',
            'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_CATEGORIES_PROPERTY_USE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
            'REFRESH' => 'Y'
        ];

        if ($arCurrentValues['INTEREST_PRODUCTS_CATEGORIES_PROPERTY_USE'] === 'Y') {
            $arTemplateParameters['INTEREST_PRODUCTS_CATEGORIES_PROPERTY'] = [
                'PARENT' => 'LIST_SETTINGS',
                'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_CATEGORIES_PROPERTY'),
                'TYPE' => 'LIST',
                'VALUES' => $arProperties->asArray(function ($iIndex, $arProperty) {
                    if (empty($arProperty['CODE']))
                        return ['skip' => true];

                    if ($arProperty['PROPERTY_TYPE'] !== 'L' || $arProperty['LIST_TYPE'] !== 'L' || $arProperty['MULTIPLE'] === 'Y')
                        return ['skip' => true];

                    return [
                        'key' => $arProperty['CODE'],
                        'value' => '['.$arProperty['CODE'].'] '.$arProperty['NAME']
                    ];
                }),
                'DEFAULT' => 'CATEGORY',
                'REFRESH' => 'Y',
                'ADDITIONAL_VALUES' => 'Y'
            ];

            if (!empty($arCurrentValues['INTEREST_PRODUCTS_CATEGORIES_PROPERTY'])) {
                $arProperty = CIBlockProperty::GetList([], [
                    'IBLOCK_ID' => $arIBlock['ID'],
                    'CODE' => $arCurrentValues['INTEREST_PRODUCTS_CATEGORIES_PROPERTY']
                ])->GetNext();

                if (!empty($arProperty)) {
                    $rsCategories = CIBlockPropertyEnum::GetList(['SORT' => 'ASC'], [
                        'PROPERTY_ID' => $arProperty['ID']
                    ]);

                    while ($arCategory = $rsCategories->GetNext())
                        if (!empty($arCategory['XML_ID']))
                            $arCategories[$arCategory['XML_ID']] = '['.$arCategory['XML_ID'].'] '.$arCategory['VALUE'];
                }
            }

            $arTemplateParameters['INTEREST_PRODUCTS_CATEGORIES'] = [
                'PARENT' => 'LIST_SETTINGS',
                'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_CATEGORIES'),
                'TYPE' => 'LIST',
                'VALUES' => $arCategories,
                'DEFAULT' => null,
                'ADDITIONAL_VALUES' => 'Y'
            ];
        } else {
            $arTemplateParameters['INTEREST_PRODUCTS_CATEGORIES'] = [
                'PARENT' => 'LIST_SETTINGS',
                'NAME' => Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCTS_CATEGORIES'),
                'TYPE' => 'LIST',
                'VALUES' => $arSections,
                'DEFAULT' => 0
            ];
        }

        $sComponent = 'bitrix:catalog.section';
        $sTemplate = 'products.small.6';
        $sPrefix = 'INTEREST_PRODUCTS_';

        $arTemplates = Arrays::from(CComponentUtil::GetTemplatesList(
            $sComponent,
            $siteTemplate
        ))->asArray(function ($key, $arTemplate) {
            return [
                'key' => $key,
                'value' => $arTemplate['NAME']
            ];
        });

        if (ArrayHelper::isIn($sTemplate, $arTemplates)) {
            $arRecommendedCommonParameters = [
                'SETTINGS_USE',
                'LAZYLOAD_USE'
            ];

            $arTemplateParameters = ArrayHelper::merge($arTemplateParameters, Component::getParameters(
                $sComponent,
                $sTemplate,
                $siteTemplate,
                $arCurrentValues,
                $sPrefix,
                function ($key, &$arParameter) use (&$arRecommendedCommonParameters) {
                    if (ArrayHelper::isIn($key, $arRecommendedCommonParameters))
                        return false;

                    $arParameter['NAME'] = Loc::getMessage('C_CATALOG_CATALOG_1_INTEREST_PRODUCT').' '.$arParameter['NAME'];
                    $arParameter['PARENT'] = 'LIST_SETTINGS';

                    return true;
                },
                Component::PARAMETERS_MODE_TEMPLATE
            ));

            unset($arRecommendedCommonParameters);
        }

        unset($sTemplate, $sComponent, $sPrefix, $arTemplates);
    }
}
