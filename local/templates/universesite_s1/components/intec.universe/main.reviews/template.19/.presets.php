<?php

use Bitrix\Main\Localization\Loc;

return [
    [
        'name' => Loc::getMessage('PRESETS_REVIEWS_TEMPLATE_19_PRESET_BLOCKS_4'),
        'group' => 'reviews',
        'sort' => 104,
        'properties' => [
            'SECTIONS_MODE' => 'id',
            'SETTINGS_USE' => 'Y',
            'LAZYLOAD_USE' => 'N',
            'CACHE_TYPE' => 'A',
            'CACHE_TIME' => 3600000,
            'SORT_BY' => 'SORT',
            'ORDER_BY' => 'ASC',
            'ELEMENTS_COUNT' => 2,
            'LIST_PAGE_URL' => '#SITE_DIR#company/reviews/',
            'SECTION_URL' => '',
            'DETAIL_URL' => '',
            'RATING_SHOW' => 'Y',
            'PROPERTY_RATING' => 'RATING',
            'RATING_MAX' => '5',
            'HEADER_SHOW' => 'Y',
            'HEADER_POSITION' => 'left',
            'HEADER_TEXT' => Loc::getMessage('PRESETS_REVIEWS_TEMPLATE_19_HEADER_TEXT'),
            'DESCRIPTION_SHOW' => 'N',
            'LINK_USE' => 'Y',
            'LINK_BLANK' => 'Y',
            'LINK_TEXT' => Loc::getMessage('PRESETS_REVIEWS_TEMPLATE_19_LINK_TEXT'),
            'BUTTON_ALL_SHOW' => 'Y',
            'BUTTON_ALL_TEXT' => Loc::getMessage('PRESETS_REVIEWS_TEMPLATE_19_BUTTON_ALL_TEXT')
        ]
    ]
];