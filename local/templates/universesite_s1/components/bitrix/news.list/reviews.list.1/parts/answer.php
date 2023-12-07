<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 * @var array $arTags
 * @var array $arItemTags
 */

?>

<? if($arVisual['ANSWER']['SHOW'] === 'Y') { ?>
    <? if(!empty($arItem['DATA']['ANSWER']['TEXT'])) { ?>

        <div class="reviews-list-item-answer">
            <div class="reviews-list-item-answer-header intec-grid intec-grid-a-v-center">
                <div class="reviews-list-item-answer-picture-wrap">
                    <?= Html::tag('div', '', [
                        'class' => 'reviews-list-item-answer-picture',
                        'style' => [
                            'background-image' => !empty($sAnswerPicture) ? 'url(\''.$sAnswerPicture.'\')' : 'url(\''.SITE_TEMPLATE_PATH.'/images/picture.missing.png'.'\')'
                        ]
                    ]) ?>
                </div>
                <div class="reviews-list-item-answer-header-text">
                    <? if(!empty($arItem['DATA']['ANSWER']['NAME']) || !empty($arVisual['ANSWER']['DEFAULT']['NAME'])){ ?>
                        <div class="reviews-list-item-name">
                            <?= !empty($arItem['DATA']['ANSWER']['NAME']) ? $arItem['DATA']['ANSWER']['NAME'] : $arVisual['ANSWER']['DEFAULT']['NAME'] ?>
                        </div>
                    <? } ?>
                    <? if(!empty($arItem['DATA']['ANSWER']['POSITION']) || !empty($arVisual['ANSWER']['DEFAULT']['POSITION'])){ ?>
                        <div class="reviews-list-item-position">
                            <?= !empty($arItem['DATA']['ANSWER']['POSITION']) ? $arItem['DATA']['ANSWER']['POSITION'] : $arVisual['ANSWER']['DEFAULT']['POSITION'] ?>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="reviews-list-item-text">
                <?= $arItem['DATA']['ANSWER']['TEXT'] ?>
            </div>
        </div>
    <? } ?>
<? } ?>


