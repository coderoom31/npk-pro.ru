<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

if (!Loader::includeModule('intec.core'))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];

/**
 * @var Closure $tagsRender($arTags)
 */
//$tagsRender = include(__DIR__.'/parts/tags.php');

?>
<div class="ns-bitrix c-reviews-list c-reviews-list-list-1" id="<?= $sTemplateId ?>">
    <div class="intec-content intec-content-visible">
        <div class="intec-content-wrapper">
            <?= Html::beginTag('div', [
                'class' => [
                    'reviews-list-items',
                    'intec-grid',
                    'intec-grid-o-vertical'
                ],
                'data-role' => 'items'
            ]) ?>

                <? /*if($arVisual['BUTTON']['REVIEWS']) { ?>
                    <? include(__DIR__.'/parts/addreview.php') ;?>
                <? } */?>

                <?php foreach ($arResult['ITEMS'] as $arItem) {

                $sId = $sTemplateId.'_'.$arItem['ID'];
                $sAreaId = $this->GetEditAreaId($sId);

                $sPicture = $arItem['PREVIEW_PICTURE'];
                $sAnswerPicture = CFile::GetPath($arItem['DATA']['ANSWER']['PICTURE']);
                if (empty($sAnswerPicture))
                    $sAnswerPicture = $arVisual['ANSWER']['DEFAULT']['IMAGE'];

                $sRaiting = $arItem['PROPERTIES']['RAITING']['VALUE'];
                $sText = empty($arItem['DETAIL_TEXT']) ? $arItem['PREVIEW_TEXT'] : $arItem['DETAIL_TEXT'];

                if (empty($sPicture))
                    $sPicture = $arItem['DETAIL_PICTURE'];

                if (!empty($sPicture)) {
                    $sPicture = CFile::ResizeImageGet($sPicture, [
                        'width' => 80,
                        'height' => 80
                    ], BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                    if (!empty($sPicture['src']))
                        $sPicture = $sPicture['src'];
                }
                if (empty($sPicture))
                    $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

                ?>

                <?php
                if($arVisual['VIDEO']['BIG']['USE']  && !empty($arItem['DATA']['VIDEO']['BIG'] === 'Y') && !empty($arItem['DATA']['VIDEO']['ITEMS'])){
                    include(__DIR__.'/parts/big-view.php');
                } else {
                    include(__DIR__.'/parts/main-view.php');
                }
                ?>

                <?php } ?>
            <?= Html::endTag('div') ?>
        </div>
    </div>
    <?php include(__DIR__.'/parts/script.php'); ?>
</div>