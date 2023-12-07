<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */
/** @var array $arParams */

$sectionsId = [];
foreach ($arResult['SECTIONS'] as $section) {
    $sectionsId[] = $section['ID'];
}

$elements = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $sectionsId],
    false,
    false,
    ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL']
);

while ($element = $elements->GetNext()) {
$element['RESIZE_PICTURE'] = CFile::ResizeImageGet($element['PREVIEW_PICTURE'],
    ['width' => 600, 'height' => 480],
    BX_RESIZE_IMAGE_EXACT, false);
    $arResult['ELEMENTS'][$element['IBLOCK_SECTION_ID']][] = $element;
}