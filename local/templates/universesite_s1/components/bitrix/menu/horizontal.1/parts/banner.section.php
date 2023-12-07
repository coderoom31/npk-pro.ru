<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 * @var int $iLevel
 * @var array $arItem
 * @var array $arItems
 */

$bFirstItem = true;

?>
<div class="menu-submenu menu-submenu-<?=$iLevel?> menu-submenu-banner-section <?=$sLongMenu?>" data-role="menu" data-menu="menu<?=$iCount?>">
    <div class="menu-submenu-banner-section-wrapper intec-grid">
        <div class="menu-submenu-main-section scrollbar-inner intec-grid-item" data-role="scrollbar">
            <div class="menu-submenu-main-section-wrapper">
                <?php foreach ($arItems as $arItem) { ?>
                    <?php
                        $bActive = $arItem['ACTIVE'];
                        $sUrl = $bActive ? null : $arItem['LINK'];
                        $sTag = $bActive ? 'div' : 'a';
                        $bSelected = ArrayHelper::getValue($arItem, 'SELECTED');
                        $bSelected = Type::toBoolean($bSelected);
                    ?>
                    <div class="menu-submenu-main-section-item <?= $bSelected ? 'active' : null ?>" data-role="main-item">
                        <?= Html::beginTag($sTag, array(
                            'class' => [
                                    'menu-submenu-main-section-item-text',
                                    'intec' => [
                                        'grid',
                                        'grid-a-v-center',
                                        $bSelected ? 'cl-text' : null
                                    ],
                            ],
                            'href' => $arItem['LINK']
                        )); ?>
                            <?= Html::encode($arItem['TEXT']) ?>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <?= Html::endTag($sTag) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="menu-submenu-section intec-grid-item">
            <div class="menu-submenu-section-wrapper">
                <?php foreach ($arItems as $arItemMain) {
                    if (empty($arItemMain['ITEMS']) && empty($arItemMain['PARAMS']['BANNER'])) {
                        echo Html::tag('div','',array(
                           'class' => [
                                   'menu-submenu-section-items-container'
                           ],
                           'data' => [
                                   'role' => 'menu-item-content'
                           ]
                        ));
                        continue;
                    } else {
                        include('banner.section.items.php');
                    }
                } ?>
            </div>
        </div>
    </div>
</div>