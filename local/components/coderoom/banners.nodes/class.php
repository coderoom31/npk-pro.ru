<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
class CoderoomBannersNodes extends CBitrixComponent
{

    public function executeComponent()
    {
        if ($this->StartResultCache()) {
            $this->getSlides();
        }

        $this->includeComponentTemplate();
    }

    public function getSlides()
    {
        $arBanners = \Bitrix\Iblock\Elements\ElementBannerNodesTable::getList([
            'select' => [
                'ID',
                'SLIDER_IMAGE_' => 'SLIDER_IMAGE'
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ],
        ])->fetchAll();

        foreach ($arBanners as $arBanner) {
            $this->arResult['ITEMS'][] = \CFile::GetPath($arBanner['SLIDER_IMAGE_IBLOCK_GENERIC_VALUE']);
        }
    }
}
