<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\constructor\models\Build;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
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
 */

$this->setFrameMode(true);

$build = Build::getCurrent();
$page = $build->getPage();
$properties = $page->getProperties();
$templateCertificates = $properties->get('sections-certificates-template');
$arVisual = $arResult['VISUAL'];
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

switch ($templateCertificates) {
    case 'tiles.1': $templateCertificates = 'tiles'; break;
    case 'list.1': $templateCertificates = 'list'; break;
}

if ($arParams['DESKTOP_TEMPLATE'] == 'settings') {
    if (in_array($templateCertificates, ['list', 'tiles'])) {
        $arParams['DESKTOP_TEMPLATE'] = $templateCertificates;
    } else {
        $arParams['DESKTOP_TEMPLATE'] = 'list';
    }
}
?>
<div id="<?= $arResult['COMPONENT_HASH'] ?>" class="intec-content intec-content-visible">
    <div class="intec-certificates desktop-template template-<?= $arParams['DESKTOP_TEMPLATE'] ?>">
        <?php if ($arParams['DISPLAY_TOP_PAGER']) {
            echo $arResult['NAV_STRING'];
        } ?>
        <div class="intec-certificates_list">
            <?php foreach ($arResult['ITEMS'] as $item) {
                $itemData = $item['CUSTOM_DATA'];
                ?>
                <div class="intec-certificates_item intec-ui-clearfix">
                    <?= Html::beginTag('div', [
                        'class' => 'intec-certificates_wrap',
                        'data' => [
                            'src' => $itemData['DETAIL_IMAGE'],
                            'preview-src' => $itemData['PREVIEW_IMAGE'],
                            'role' => $arParams['DESKTOP_TEMPLATE'] === 'tiles' ? 'item' : null
                        ]
                    ]) ?>
                        <?= Html::tag('div', '', [
                            'class' => 'intec-certificates_image',
                            'data' => [
                                'src' => $itemData['DETAIL_IMAGE'],
                                'preview-src' => $itemData['PREVIEW_IMAGE'],
                                'role' => $arParams['DESKTOP_TEMPLATE'] === 'list' ? 'item' : null,
                                'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                'original' => $arVisual['LAZYLOAD']['USE'] ? $itemData['DETAIL_IMAGE'] : null
                            ],
                            'style' => [
                                'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$itemData['DETAIL_IMAGE'].'\')' : null
                            ]
                        ]) ?>
                        <div class="intec-certificates_name">
                            <?= $item['NAME'] ?>
                        </div>
                        <div class="intec-certificates_description">
                            <?= $item['PREVIEW_TEXT'] ?>
                        </div>
                    <?= Html::endTag('div') ?>
                </div>
            <?php } ?>
        </div>
        <?php if ($arParams['DISPLAY_BOTTOM_PAGER']) {
            echo $arResult['NAV_STRING'];
        } ?>
    </div>
</div>

<script type="text/javascript">

        <?php switch ($arParams['DESKTOP_TEMPLATE']) {
        case 'tiles':
        ?>
            template.load(function(data) {
                var $ = this.getLibrary('$');
                $('#<?= $arResult['COMPONENT_HASH'] ?> .intec-certificates_list').lightGallery({
                    selector: '[data-role="item"]',
                    exThumbImage: 'data-preview-src',
                    autoplay: false,
                    share: false
                });
            }, {
                'name': '[Component] bitrix:news.list (certificates)',
                'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
                'loader': {
                    'name': 'lazy'
                }
            });
        <?php
        break;
        case 'list':
        ?>
            template.load(function(data) {
                var $ = this.getLibrary('$');
                $('#<?= $arResult['COMPONENT_HASH'] ?> .intec-certificates_list').lightGallery({
                    selector: '[data-role="item"]',
                    exThumbImage: 'data-preview-src',
                    autoplay: false,
                    share: false
                });
            }, {
                'name': '[Component] bitrix:news.list (certificates)',
                'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
                'loader': {
                    'name': 'lazy'
                }
            });
        <?php
        break;
        } ?>
</script>
