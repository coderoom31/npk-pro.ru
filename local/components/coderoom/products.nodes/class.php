<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
class CoderoomProductsNodes extends CBitrixComponent
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
        $obProducts = \Bitrix\Iblock\Elements\ElementNodesProductsTable::getList([
            'select' => [
                'ID',
                'NAME',
                'PRODUCT_IMAGE',
                'PRODUCTS_ICONS',
                'PRODUCTS_TABS',
                'PRODUCTS_CONTENTS',
                'PDF',
                'WORD'
            ],
            'filter' => [
                '=ACTIVE' => 'Y'
            ],
        ])->fetchCollection();

        foreach ($obProducts as $obProduct) {
            $id = $obProduct->getId();

            $this->arResult['ITEMS'][$id]['NAME'] = $obProduct->getName();
            $this->arResult['ITEMS'][$id]['IMAGE'] = \CFile::GetPath($obProduct->getProductImage()->getValue());

            if($obProduct->getProductsIcons()) {
                $this->arResult['ITEMS'][$id]['ICONS'] = unserialize($obProduct->getProductsIcons()->getValue());
            }

            if ($obProduct->getPdf()) {
                $this->arResult['ITEMS'][$id]['PDF'] = \CFile::GetPath($obProduct->getPdf()->getValue());
            }

            $i = 0;

            foreach ($obProduct->getProductsTabs()->getAll() as $arTab) {
                $this->arResult['ITEMS'][$id]['TABS'][$i++]['NAME'] = $arTab->getValue();
            }

            $i = 0;

            foreach ($obProduct->getProductsContents()->getAll() as $arContent) {
                $this->arResult['ITEMS'][$id]['TABS'][$i++]['CONTENT'] = unserialize($arContent->getValue());
            }
        }
    }
}
