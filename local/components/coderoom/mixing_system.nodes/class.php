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
                'LINK_' => 'LINK'
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ],
        ])->fetchAll();

        foreach ($arSystems as $arSystem) {
            $this->arResult['ITEMS'][$arSystem['ID']]['NAME'] = $arSystem['NAME'];
            $this->arResult['ITEMS'][$arSystem['ID']]['IMAGE'] = \CFile::GetPath($arSystem['PREVIEW_PICTURE']);
            $this->arResult['ITEMS'][$arSystem['ID']]['TEXT'] = $arSystem['PREVIEW_TEXT'];
            $this->arResult['ITEMS'][$arSystem['ID']]['LINK'] = $arSystem['LINK_VALUE'];
        }
    }
}
?>