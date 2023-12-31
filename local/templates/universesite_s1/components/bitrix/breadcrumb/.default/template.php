

<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

include(__DIR__.'/result_modifier.php');

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\Core;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;


/**
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 * @var Arrays $arSections
 */

if (!Loader::includeModule('intec.core'))
    return;

global $APPLICATION;

if (defined('EDITOR'))
    $arResult = [[
        'TITLE' => Loc::getMessage('BREADCRUMB_PAGE_TITLE'),
        'LINK' => ''
    ]];

if (empty($arResult))
    return '';

$sTemplateId = Core::$app->security->generateRandomString(8);
$arRender = [];
$arResult = ArrayHelper::merge(
    [[
        'TITLE' => Loc::getMessage('BREADCRUMB_MAIN_TITLE'),
        'LINK' => SITE_DIR
    ]],
    $arResult
);

$arSeparator = [
    'MOBILE' => null,
    'USUAL' => null
];

$iCount = count($arResult);
$iIndex = 0;

$arRenderSlider = [];

foreach ($arResult as $arItem) {
    $sTitle = Html::encode($arItem['TITLE']);
    $sLink = $arItem['LINK'];

    if ($arItem['LINK'] != '') {
        $arSectionCurrent = null;

        foreach ($arSections as $arSection)
            if ($arSection['SECTION_PAGE_URL'] == $arItem['LINK']) {
                $arSectionCurrent = $arSection;
                break;
            }

        $arRenderMenu = [];

        if (!empty($arSectionCurrent)) {
            $arSectionsCurrent = $arSections->where(function ($sKey, $arSection) use (&$arSectionCurrent) {
                return $arSection['IBLOCK_SECTION_ID'] == $arSectionCurrent['IBLOCK_SECTION_ID'];
            })->asArray();

            if (!empty($arSectionsCurrent)) {
                $arRenderMenu[] = Html::beginTag('div', [
                    'class' => 'breadcrumb-menu',
                    'data-control' => 'menu'
                ]);
                $arRenderMenu[] = Html::beginTag('div', [
                    'class' => 'breadcrumb-menu-wrapper'
                ]);

                foreach ($arSectionsCurrent as $arSection) {
                    $arRenderMenu[] = Html::tag('a', $arSection['NAME'], [
                        'class' => 'breadcrumb-menu-item intec-cl-text-hover',
                        'href' => $arSection['SECTION_PAGE_URL']
                    ]);
                }

                $arRenderMenu[] = Html::endTag('div');
                $arRenderMenu[] = Html::endTag('div');
            }
        }

        $arRender[] =
            '<div class="breadcrumb-item" data-control="item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="'.$sLink.'" title="'.$sTitle.'" data-control="link" class="breadcrumb-link intec-cl-text-hover" itemprop="item">
                    <span itemprop="name">'.$sTitle.'</span>
                    <meta itemprop="position" content="'.($iIndex + 1).'">'.
                    (!empty($arRenderMenu) ? '<i class="far fa-angle-down"></i>' : null).
                '</a>'.
                implode('', $arRenderMenu).
            '</div>';

        $arRenderSlider[] =
            '<div class="breadcrumb-item" data-control="item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="'.$sLink.'" title="'.$sTitle.'" data-control="link" class="breadcrumb-link intec-cl-text-hover" itemprop="item">
                    <span itemprop="name">'.$sTitle.'</span>
                    <meta itemprop="position" content="'.($iIndex + 1).'">'.
                '</a>'.
            '</div>';
    } else {
        $arRender[] =
            '<div class="breadcrumb-item intec-cl-text" data-control="item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <div itemprop="item">
                    <span itemprop="name">'.$sTitle.'</span>
                    <meta itemprop="position" content="'.($iIndex + 1).'">
                </div>
            </div>';

        $arRenderSlider[] =
            '<div class="breadcrumb-item intec-cl-text" data-control="item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <div itemprop="item">
                    <span itemprop="name">'.$sTitle.'</span>
                    <meta itemprop="position" content="'.($iIndex + 1).'">
                </div>
            </div>';
    }

    $iIndex++;
}

$arPreviews = $arResult[count($arResult)-2];

$sMobileData = $arVisual['MOBILE']['USE'] ? 'true' : 'false';

$sReturns =
    '<div id="'.$sTemplateId.'" class="ns-bitrix c-breadcrumb c-breadcrumb-default c-breadcrumb-usual" data-mobile="'.$sMobileData.'">'.
        '<div class="breadcrumb-wrapper intec-content intec-content-visible">'.
            '<div class="breadcrumb-wrapper-2 intec-content-wrapper" itemscope="" itemtype="http://schema.org/BreadcrumbList">'.
                implode('<span class="breadcrumb-separator"> / </span>', $arRender).
            '</div>'.
        '</div>'
            .Html::script('template.load(function (data) {

                    var $ = this.getLibrary(\'$\');
                    var root = data.nodes;
                    
                    root.find(\'[data-control="item"]\').each(function () {
                        var item;
                        var link;
                        var menu;
                        
                        item = $(this);
                        link = item.find(\'[data-control="link"]\');
                        menu = item.find(\'[data-control="menu"]\');
                        
                        item.on(\'mouseover\', function () {
                            link.addClass(\'intec-cl-text\');
                            menu.css({\'display\': \'block\'}).stop().animate({
                                \'opacity\': 1
                            }, 300);
                        }).on(\'mouseout\', function () {
                            link.removeClass(\'intec-cl-text\');
                            menu.stop().animate({
                                \'opacity\': 0
                            }, 300, function () {
                                menu.css({\'display\': \'none\'});
                            });
                        });
                    });
            }, {
            \'name\': \'[Component] bitrix:breadcrumb (.default)\',
            \'nodes\': '.JavaScript::toObject('#'.$sTemplateId).',
            \'loader\': {
                \'name\': \'lazy\'
            }
        })', [
                'type' => 'text/javascript'
            ]).
    '</div>';

if ($arVisual['MOBILE']['USE']) {
    if ($arVisual['MOBILE']['SLIDER']['USE']) {
        $sReturns = $sReturns.
            '<div id="S_'.$sTemplateId.'" class="ns-bitrix c-breadcrumb c-breadcrumb-default c-breadcrumb-mobile-slider" data-mobile="'.$sMobileData.'">'.
                '<div class="breadcrumb-wrapper intec-content intec-content-visible">'.
                    '<div class="breadcrumb-wrapper-2 intec-content-wrapper" itemscope="" itemtype="http://schema.org/BreadcrumbList">'.
                        '<div class="scroll-mod-hiding scrollbar-inner">'.
                           '<div class="scroll-mod-hiding scrollbar-inner scroll-content scroll-scrolly_visible" data-role="scroll">'.
                                implode('<span class="breadcrumb-separator"> / </span>', $arRenderSlider).
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>'
                .Html::script('template.load(function (data) {
    
                        var $ = this.getLibrary(\'$\');
                        var root = data.nodes;
                        
                        var scroll = $(\'[data-role="scroll"]\', root);
                        scroll.scrollbar();
                    }, {
                    \'name\': \'[Component] bitrix:breadcrumb (.default)\',
                    \'nodes\': '.JavaScript::toObject('#S_'.$sTemplateId).',
                    \'loader\': {
                        \'name\': \'lazy\'
                    }
                })', [
                    'type' => 'text/javascript'
                ]).
            '</div>';
    } else {
        $sReturns = $sReturns.
            '<div id="M_'.$sTemplateId.'" class="ns-bitrix c-breadcrumb c-breadcrumb-default c-breadcrumb-mobile">'.
                '<div class="breadcrumb-wrapper intec-content intec-content-visible">'.
                    '<div class="breadcrumb-wrapper-2 intec-content-wrapper" itemscope="" itemtype="http://schema.org/BreadcrumbList">'.
                        '<div class="breadcrumb-item" data-control="item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a href="'.$arPreviews['LINK'].'" title="'.$arPreviews['TITLE'].'" data-control="link" class="breadcrumb-link intec-cl-text-hover" itemprop="item">
                                <i class="far fa-angle-left intec-cl-text"></i>'.
                                $arPreviews['TITLE'].
                            '</a>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</div>';
    }
}

return $sReturns;