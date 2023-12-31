<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 * @var array $arTags
 * @var array $arItemTags
 */

?>
<div class="documents-content intec-grid intec-grid-wrap">

    <? foreach ($arItem['DATA']['DOCUMENTS'] as $arDocument) { ?>
        <div class="document-item">
            <a class="document-wrapper intec-grid" href="<?= $arDocument['SRC'] ?>" target="_blank" <?= $arVisial['DOCUMENTS']['DOWNLOAD'] ? 'download' : null ?>>
                <div class="document-image">
                    <div class="image-holder intec-grid intec-grid-o-vertical">
                        <div class="image-background">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path d="M10 0C8.625 0 7.5 1.125 7.5 2.5V37.5C7.5 38.875 8.625 40 10 40H35C36.375 40 37.5 38.875 37.5 37.5V10L27.5 0H10Z" fill="#E2E5E7"/>
                                <path d="M30 10H37.5L27.5 0V7.5C27.5 8.875 28.625 10 30 10Z" fill="#B0B7BD"/>
                                <path d="M37.5 17.5L30 10H37.5V17.5Z" fill="#CAD1D8"/>
                            </svg>
                        </div>
                        <div class="image-substrate">
                            <span class="image-type type-<?= $arDocument['TYPE'] ?>">
                                <?= $arDocument['TYPE'] ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="document-name-block">
                    <div class="document-name">
                        <?= $arDocument['NAME'] ?>
                    </div>
                    <div class="document-size">
                        <?= $arDocument['SIZE'] ?>
                    </div>
                </div>
            </a>
        </div>
    <? } ?>

</div>