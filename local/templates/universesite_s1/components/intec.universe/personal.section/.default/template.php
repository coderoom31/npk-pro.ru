<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 * @var  CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <div class="sale-personal-section-index">
            <div class="intec-grid intec-grid-wrap intec-grid-a-v-stretch intec-grid-i-8">
                <?php if (!empty($arResult['URL']['ORDER'])) { ?>
                    <div class="intec-grid-item-3 intec-grid-item-768-2 intec-grid-item-550-1">
                        <div class="sale-personal-section-index-block intec-cl-background">
                            <a class="sale-personal-section-index-block-link" href="<?= $arResult['URL']['ORDER'] ?>">
                                <span class="sale-personal-section-index-block-ico">
                                    <i class="fa fa-calculator"></i>
                                </span>
                                <h2 class="sale-personal-section-index-block-name">
                                    <?= Loc::getMessage('PS_ORDERS') ?>
                                </h2>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($arResult['URL']['PERSONAL_DATA'])) { ?>
                    <div class="intec-grid-item-3 intec-grid-item-768-2 intec-grid-item-550-1">
                        <div class="sale-personal-section-index-block intec-cl-background">
                            <a class="sale-personal-section-index-block-link" href="<?= $arResult['URL']['PERSONAL_DATA'] ?>">
                                <span class="sale-personal-section-index-block-ico">
                                    <i class="fa fa-user-secret"></i>
                                </span>
                                <h2 class="sale-personal-section-index-block-name">
                                    <?= Loc::getMessage('PS_PERSONAL_DATA') ?>
                                </h2>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($arResult['URL']['BASKET'])) { ?>
                    <div class="intec-grid-item-3 intec-grid-item-768-2 intec-grid-item-550-1">
                        <div class="sale-personal-section-index-block intec-cl-background">
                            <a class="sale-personal-section-index-block-link" href="<?= $arResult['URL']['BASKET'] ?>">
                                <span class="sale-personal-section-index-block-ico">
                                    <i class="fa fa-shopping-cart"></i>
                                </span>
                                <h2 class="sale-personal-section-index-block-name">
                                    <?= Loc::getMessage('PS_BASKET') ?>
                                </h2>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($arResult['URL']['CONTACTS'])) { ?>
                    <div class="intec-grid-item-3 intec-grid-item-768-2 intec-grid-item-550-1">
                        <div class="sale-personal-section-index-block intec-cl-background">
                            <a class="sale-personal-section-index-block-link" href="<?= $arResult['URL']['CONTACTS'] ?>">
                                <span class="sale-personal-section-index-block-ico">
                                    <i class="fa fa-info-circle"></i>
                                </span>
                                <h2 class="sale-personal-section-index-block-name">
                                    <?= Loc::getMessage('PS_CONTACTS') ?>
                                </h2>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>