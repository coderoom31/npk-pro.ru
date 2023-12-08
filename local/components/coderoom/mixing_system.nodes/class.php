<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

class CoderoomMixingSystemNodes extends CBitrixComponent
{
    public function executeComponent()
    {
        if ($this->StartResultCache()) {
            $this->getResult();
        }
        $this->includeComponentTemplate();
    }

    public function getResult()
    {
        $arSystems = \Bitrix\Iblock\Elements\ElementNodesSystemTable::getList([
            'select' => [
                'ID',
                'NAME',
                'PREVIEW_PICTURE',
                'PREVIEW_TEXT',
                'LINK_' => 'LINK',
                'SORT'
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ],
            'order' => [
                'SORT' => 'ASC'
            ]
        ])->fetchAll();

        foreach ($arSystems as $arSystem) {
            $arItem = [];


            $arItem['NAME'] = $arSystem['NAME'];
            $arItem['IMAGE'] = \CFile::GetPath($arSystem['PREVIEW_PICTURE']);
            $arItem['TEXT'] = $arSystem['PREVIEW_TEXT'];
            $arItem['LINK'] = $arSystem['LINK_VALUE'];

            $this->arResult['ITEMS'][] = $arItem;
        }
    }
}
?>