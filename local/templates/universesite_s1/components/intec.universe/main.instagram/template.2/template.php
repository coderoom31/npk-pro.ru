<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

$bError = false;

if (empty($arResult['ITEMS']))
    $bError = true;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];

$iCounter = 0;
$bAdditionally = false;

?>
<div class="widget c-instagram c-instagram-template-2" id="<?= $sTemplateId ?>">
    <?php if ($bError) { ?>
        <div class="widget-error">
            <?= Loc::getMessage('C_MAIN_INSTAGRAM_TEMPLATE_2_ERROR'); ?>
        </div>
        <?php return; ?>
    <?php } ?>
    <?php if ($arVisual['HEADER']['SHOW']) { ?>
        <div class="widget-header">
            <div class="intec-content">
                <div class="intec-content-wrapper">
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
            </div>
        </div>
    <?php } ?>
    <div class="widget-content">
        <div class="intec-grid">
            <?php if ($arVisual['ITEMS']['BIG']) {
                $arItem = ArrayHelper::getFirstValue($arResult['ITEMS']);
                $sImage = null;
                $bVideo = $arItem['VIDEO']['IS'];
                $bVideo ? $sImage = $arItem['VIDEO']['IMAGES'] : $sImage = $arItem['IMAGES'];

                $sDescription = ArrayHelper::getValue($arItem, 'DESCRIPTION');
                $sLink = ArrayHelper::getValue($arItem, 'LINK');
                ?>
                <div class="widget-items-first-big">
                    <div class="widget-item">
                        <div class="widget-item-wrapper">
                            <?= Html::beginTag('a', [
                                'class' => [
                                    'widget-item-image'
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
                            <?php if ($arVisual['ITEMS']['DESCRIPTION']['SHOW']) { ?>
                                <div class="widget-item-fade scrollbar-inner">
                                    <?php if ($arVisual['ITEMS']['DATE']['SHOW']) { ?>
                                        <div class="widget-item-date">
                                            <?= $arItem['DATE']['FORMATTED'] ?>
                                        </div>
                                    <?php } ?>
                                    <div class="widget-item-description">
                                        <?php if ($arVisual['ITEMS']['DESCRIPTION']['CUT']) { ?>
                                            <?= TruncateText($sDescription, '200') ?>
                                        <?php } else { ?>
                                            <?= $sDescription ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?= Html::endTag('a') ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="widget-items intec-grid intec-grid-wrap">
                <?php $sRoleAdditionally = false; ?>
                <?php include(__DIR__.'/parts/items.php'); ?>
            </div>
        </div>
        <?php if ($arVisual['ITEMS']['BIG'] && $arVisual['ITEMS']['MORE']['SHOW'] && $arVisual['ITEMS']['MORE']['VIEW']['DESKTOP']) { ?>
            <div class="widget-items-more intec-grid intec-grid-wrap">
                <?php
                    $sRoleAdditionally = true;
                    $bAdditionally = true;
                ?>
                <?php include(__DIR__.'/parts/items.php'); ?>
            </div>
        <?php } ?>
    </div>
    <?php if ($arVisual['FOOTER']['SHOW']) { ?>
        <div class="widget-footer align-<?= $arVisual['FOOTER']['POSITION'] ?>">
            <div class="intec-content">
                <div class="intec-content-wrapper">
                    <a class="widget-footer-all intec-cl-border intec-cl-background-hover" href="<?= $arVisual['FOOTER']['LINK'] ?>">
                        <?= $arVisual['FOOTER']['TEXT'] ?>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php include(__DIR__.'/parts/script.php'); ?>
</div>