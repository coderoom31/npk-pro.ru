<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\component\InnerTemplate;
use intec\core\helpers\FileHelper;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arData
 * @var InnerTemplate $this
 */

$sTemplateId = $arData['id'];
$sTemplateType = $arData['type'];

$bContainerShow = false;

foreach ([
    'LOGOTYPE',
    'CONTACTS',
    'AUTHORIZATION',
    'ADDRESS',
    'EMAIL',
    'SEARCH',
    'BASKET',
    'DELAY',
    'COMPARE',
    'MENU'
] as $sBlock) {
    $bContainerShow = $bContainerShow || $arResult[$sBlock]['SHOW']['DESKTOP'];
}

$bBasketShow =
    $arResult['BASKET']['SHOW']['DESKTOP'] ||
    $arResult['DELAY']['SHOW']['DESKTOP'] ||
    $arResult['COMPARE']['SHOW']['DESKTOP'];

?>
<div class="widget-view-desktop-2">
    <?php if ($bContainerShow) { ?>
        <div class="widget-container">
            <div class="intec-content intec-content-visible intec-content-primary">
                <div class="intec-content-wrapper">
                    <?= Html::beginTag('div', [
                        'class' => [
                            'widget-container-wrapper',
                            'intec-grid' => [
                                '',
                                'nowrap',
                                'a-h-start',
                                'a-v-center',
                                'i-h-10'
                            ]
                        ]
                    ]) ?>
                        <?php if ($arResult['MENU']['MAIN']['SHOW']['DESKTOP']) { ?>
                            <div class="widget-menu-wrap intec-grid-item-auto">
                                <div class="widget-item widget-menu">
                                    <?php include(__DIR__.'/../../../parts/menu/main.popup.php') ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($arResult['LOGOTYPE']['SHOW']['DESKTOP']) { ?>
                            <div class="widget-logotype-wrap intec-grid-item-auto">
                                <?= Html::beginTag($arResult['LOGOTYPE']['LINK']['USE'] ? 'a' : 'div', [
                                    'href' => $arResult['LOGOTYPE']['LINK']['USE'] ? $arResult['LOGOTYPE']['LINK']['VALUE'] : null,
                                    'class' => [
                                        'widget-item',
                                        'widget-logotype',
                                        'intec-ui-picture'
                                    ]
                                ]) ?>
                                    <?php include(__DIR__.'/../../../parts/logotype.php') ?>
                                <?= Html::endTag($arResult['LOGOTYPE']['LINK']['USE'] ? 'a' : 'div') ?>
                            </div>
                        <?php } ?>
                        <?php if ($arResult['ADDRESS']['SHOW']['DESKTOP'] || $arResult['REGIONALITY']['USE']) { ?>
                            <?php if ($arResult['REGIONALITY']['USE']) { ?>
                                <div class="widget-region-wrap intec-grid-item-auto">
                                    <!--noindex-->
                                    <div class="widget-item widget-region">
                                        <div class="widget-region-icon intec-grid-item-auto intec-cl-svg-path-stroke">
                                            <?= FileHelper::getFileData(__DIR__.'/../../../svg/region_icon.svg')?>
                                        </div>
                                        <div class="widget-region-component">
                                            <?php $APPLICATION->IncludeComponent('intec.regionality:regions.select', $arResult['REGIONALITY']['TEMPLATE'], []) ?>
                                        </div>
                                    </div>
                                    <!--/noindex-->
                                </div>
                            <?php } else { ?>
                                <div class="widget-address-wrap intec-grid-item-auto">
                                    <div class="widget-item widget-address">
                                        <div class="widget-address-icon glyph-icon-location intec-cl-text"></div>
                                        <div class="widget-address-text">
                                            <?= $arResult['ADDRESS']['VALUE'] ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="intec-grid-item"></div>
                        <?php if ($arResult['CONTACTS']['SHOW']['DESKTOP'] || $arResult['EMAIL']['SHOW']['DESKTOP']) { ?>
                            <div class="widget-contacts-wrap intec-grid-item-auto">
                                <div class="widget-contacts widget-item">
                                    <?php if ($arResult['CONTACTS']['SHOW']['DESKTOP']) { ?>
                                        <?php $arContact = $arResult['CONTACTS']['SELECTED'] ?>
                                        <?php $arContacts = $arResult['CONTACTS']['VALUES'] ?>
                                        <div class="widget-phone-wrap">
                                            <div class="widget-phone">
                                                <div class="widget-phone-content" data-block="phone" data-expanded="false">
                                                    <div class="widget-phone-content-text intec-grid intec-grid-a-v-center intec-cl-text-hover" data-block-action="popup.open">
                                                        <div class="widget-phone-content-text-icon intec-ui-icon intec-ui-icon-phone-1 intec-cl-text"></div>
                                                        <div class="widget-phone-content-wrapper intec-grid intec-grid-o-vertical">
                                                            <?php if ($arResult['CONTACTS']['ADVANCED']) { ?>
                                                                <?php foreach ($arContact as $arContactItem) { ?>
                                                                    <a href="tel:<?= $arContactItem['PHONE']['VALUE'] ?>" class="widget-phone-content-text-value intec-cl-text-hover">
                                                                        <?= $arContactItem['PHONE']['DISPLAY'] ?>
                                                                    </a>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <?php foreach ($arContact as $arContactItem) { ?>
                                                                    <a href="tel:<?= $arContactItem['VALUE'] ?>" class="widget-phone-content-text-value intec-cl-text-hover">
                                                                        <?= $arContactItem['DISPLAY'] ?>
                                                                    </a>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($arContacts)) { ?>
                                                        <div class="widget-phone-content-popup" data-block-element="popup">
                                                            <div class="widget-phone-content-popup-wrapper scrollbar-inner">
                                                                <?php if ($arResult['CONTACTS']['ADVANCED']) {?>
                                                                    <?php foreach ($arContacts as $arContact) { ?>
                                                                        <div class="widget-phone-content-popup-contacts">
                                                                            <?php if (!empty($arContact['PHONE'])) { ?>
                                                                                <a href="tel:<?= $arContact['PHONE']['VALUE'] ?>" class="widget-phone-content-popup-contact phone intec-cl-text-hover">
                                                                                    <?= $arContact['PHONE']['DISPLAY'] ?>
                                                                                </a>
                                                                            <?php } ?>
                                                                            <?php if (!empty($arContact['ADDRESS'])) { ?>
                                                                                <div class="widget-phone-content-popup-contact address">
                                                                                    <?= $arContact['ADDRESS'] ?>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if (!empty($arContact['SCHEDULE'])) { ?>
                                                                                <div  class="widget-phone-content-popup-contact schedule">
                                                                                    <?php if (Type::isArray($arContact['SCHEDULE'])) { ?>
                                                                                        <?php foreach ($arContact['SCHEDULE'] as $sValue) { ?>
                                                                                            <div><?= $sValue ?></div>
                                                                                        <?php } ?>
                                                                                    <?php } else { ?>
                                                                                        <?= $arContact['SCHEDULE'] ?>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if (!empty($arContact['EMAIL'])) { ?>
                                                                                <a href="mailto:<?= $arContact['EMAIL'] ?>" class="widget-phone-content-popup-contact email intec-cl-text-hover">
                                                                                    <?= $arContact['EMAIL'] ?>
                                                                                </a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php foreach ($arContacts as $arContact) { ?>
                                                                        <a href="tel:<?= $arContact['VALUE'] ?>" class="widget-phone-content-popup-item intec-cl-text-hover">
                                                                            <?= $arContact['DISPLAY'] ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php if (!empty($arContacts) && !defined('EDITOR')) { ?>
                                                <script type="text/javascript">
                                                    template.load(function (data) {
                                                        var $ = this.getLibrary('$');
                                                        var root = data.nodes;
                                                        var block = $('[data-block="phone"]', root);
                                                        var popup = $('[data-block-element="popup"]', block);
                                                        var scrollContacts = $('.widget-phone-content-popup-wrapper', popup);

                                                        popup.open = $('[data-block-action="popup.open"]', block);
                                                        popup.open.on('mouseenter', function () {
                                                            block.attr('data-expanded', 'true');
                                                        });

                                                        block.on('mouseleave', function () {
                                                            block.attr('data-expanded', 'false');
                                                        });

                                                        scrollContacts.scrollbar();
                                                    }, {
                                                        'name': '[Component] intec.universe:main.header (template.1) > desktop (template.2) > phone.expand',
                                                        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
                                                        'loader': {
                                                            'name': 'lazy'
                                                        }
                                                    });
                                                </script>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($arResult['EMAIL']['SHOW']['DESKTOP']) { ?>
                                        <div class="widget-email-wrap">
                                            <div class="widget-email">
                                                <div class="widget-email-icon intec-ui-icon intec-ui-icon-mail-1 intec-cl-text"></div>
                                                <a href="mailto:<?= $arResult['EMAIL']['VALUE'] ?>" class="widget-email-text">
                                                    <?= $arResult['EMAIL']['VALUE'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($arResult['FORMS']['CALL']['SHOW']) { ?>
                            <div class="widget-button-wrap intec-grid-item-auto">
                                <div class="widget-button intec-ui intec-ui-control-button intec-ui-scheme-current intec-ui-size-2 intec-ui-mod-transparent intec-ui-mod-round-3" data-action="forms.call.open">
                                    <?= Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP2_BUTTON') ?>
                                </div>
                                <?php include(__DIR__.'/../../../parts/forms/call.php') ?>
                            </div>
                        <?php } ?>
                        <div class="intec-grid-item"></div>
                        <?php if ($bBasketShow) { ?>
                            <div class="widget-basket-wrap intec-grid-item-auto">
                                <div class="widget-basket widget-item">
                                    <?php include(__DIR__.'/../../../parts/basket.php') ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($arResult['SEARCH']['SHOW']['DESKTOP']) { ?>
                            <div class="widget-search-wrap intec-grid-item-auto">
                                <div class="widget-search widget-item">
                                    <?php $arSearchParams = [
                                        'INPUT_ID' => $arParams['SEARCH_INPUT_ID'].'-desktop'
                                    ] ?>
                                    <?php include(__DIR__.'/../../../parts/search/popup.1.php') ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($arResult['AUTHORIZATION']['SHOW']['DESKTOP']) { ?>
                            <div class="widget-authorize-wrap intec-grid-item-auto">
                                <div class="widget-authorize widget-item">
                                    <?php include(__DIR__.'/../../../parts/auth/panel.php') ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?= Html::endTag('div') ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>