<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arItem
 */

$sPicture = null;

if (!empty($arItem['PREVIEW_PICTURE']['SRC']))
    $sPicture = $arItem['PREVIEW_PICTURE']['SRC'];
else if (!empty($arItem['PREVIEW_PICTURE_SECOND']['SRC']))
    $sPicture = $arItem['PREVIEW_PICTURE_SECOND']['SRC'];

if (empty($sPicture))
    $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

if (!empty($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']))
    $sPictureTitle = $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'];
else
    $sPictureTitle = $arItem['NAME'];

?>
    <div class="catalog-item-picture-container">
        <?= Html::tag('a', null, [
            'class' => [
                'catalog-item-picture',
                'intec-image-effect'
            ],
            'href' => $arItem['DETAIL_PAGE_URL'],
            'title' => $sPictureTitle,
            'style' => [
                'background-image' => 'url(\''.$sPicture.'\')'
            ]
        ]) ?>
    </div>
<?php unset($sPicture, $sPictureTitle) ?>