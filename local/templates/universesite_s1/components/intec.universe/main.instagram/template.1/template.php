<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 */


$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];

?>
<div class="widget c-instagram c-instagram-template-1" id="<?= $sTemplateId ?>">
    <?php if (!$arVisual['ITEMS']['WIDE']) { ?>
    <div class="widget-wrapper intec-content">
        <div class="widget-wrapper-2 intec-content-wrapper">
            <?php } ?>
            <?php if ($arVisual['HEADER']['SHOW']) { ?>
                <div class="widget-header">
                    <?php if ($arVisual['HEADER']['SHOW']) { ?>
                        <div class="widget-title align-<?= $arVisual['HEADER']['POSITION'] ?>">
                            <?= $arVisual['HEADER']['TEXT'] ?>
                        </div>
                    <?php } ?>
                    <?php if ($arVisual['DESCRIPTION']['SHOW']) { ?>
                        <div class="widget-description align-<?= $arVisual['DESCRIPTION']['POSITION'] ?>">
                            <?= $arVisual['DESCRIPTION']['TEXT'] ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="widget-content">
                <div class="widget-elements<?= $arVisual['ITEMS']['PADDING'] ? ' widget-elements-with-padding' : '' ?>">
                    <?php foreach ($arResult['ITEMS'] as $arItem) {

                        $sImage = null;
                        $bVideo = $arItem['VIDEO']['IS'];
                        $bVideo ? $sImage = $arItem['VIDEO']['IMAGES'] : $sImage = $arItem['IMAGES'];

                        $sDescription = ArrayHelper::getValue($arItem, 'DESCRIPTION');
                        $sLink = ArrayHelper::getValue($arItem, 'LINK');

                        ?>
                        <div class="widget-element grid-<?= $arVisual['ITEMS']['COUNT'] ?>">
                            <div class="widget-element-wrapper">
                                <?= Html::beginTag('a', [
                                    'class' => [
                                        'widget-element-image'
                                    ],
                                    'target' => '_blank',
                                    'href' => $sLink,
                                    'data' => [
                                        'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                        'original' => $arVisual['LAZYLOAD']['USE'] ? $sImage : null
                                    ],
                                    'style' => [
                                        'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$sImage.'\')' : null
                                    ]
                                ]) ?>
                                <?php if ($bVideo) { ?>
                                    <i class="fas fa-play"></i>
                                <?php } ?>
                                <div class="widget-element-description">
                                    <?php if ($arVisual['ITEMS']['DESCRIPTION']) { ?>
                                        <?= TruncateText($sDescription, '200') ?>
                                    <?php } ?>
                                </div>
                                <?= Html::endTag('a') ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if ($arVisual['FOOTER']['SHOW']) { ?>
                <div class="widget-footer align-<?= $arVisual['FOOTER']['POSITION'] ?>">
                    <a class="widget-footer-all intec-cl-border intec-cl-background-hover" href="<?= $arVisual['FOOTER']['LINK'] ?>">
                        <?= $arVisual['FOOTER']['TEXT'] ?>
                    </a>
                </div>
            <?php } ?>
            <?php if (!$arVisual['ITEMS']['WIDE']) { ?>
        </div>
    </div>
<?php } ?>
</div>