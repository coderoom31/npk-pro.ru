<?php

use intec\core\helpers\Html;
use intec\constructor\models\build\layout\Renderer;
use intec\constructor\models\build\layout\renderers\EditorRenderer;
use intec\template\Properties;

/**
 * @var Renderer $this
 */

global $APPLICATION;

$isInEditor = $this instanceof EditorRenderer;
$zones = $this->getLayout()->getZones();
$settings = [
    'flat' => !$isInEditor && $APPLICATION->GetCurPage(false) === SITE_DIR ? 'both' : 'top',
    'background' => [
        'show' => !$isInEditor ? Properties::get('template-background-show') : false
    ]
];

$handle = function ($part) use ($isInEditor) {
    require(__DIR__.'/../../parts/layout.php');
}

?>
<?php if ($this->getIsRenderAllowed()) { ?>
<?php $handle('begin') ?>
<?= Html::beginTag('div', [
    'class' => [
        'intec-template'
    ],
    'data' => [
        'background-show' => $settings['background']['show'] ? 'true' : 'false',
        'editor' => $isInEditor ? 'true' : 'false',
        'flat' => $settings['flat']
    ]
]) ?>
    <?= Html::beginTag('div', [
        'class' => [
            'intec-template-layout',
            'intec-content-wrap'
        ],
        'data' => [
            'name' => 'wide'
        ]
    ]) ?>
        <?= Html::beginTag('div', [
            'class' => Html::cssClassFromArray([
                'intec-template-layout-header' => true,
                'intec-content' => $settings['background']['show'],
                'intec-content-visible' => $settings['background']['show']
            ], true)
        ]) ?>
            <?= Html::beginTag('div', [
                'class' => Html::cssClassFromArray([
                    'intec-template-layout-header-wrapper' => true,
                    'intec-content-wrapper' => $settings['background']['show']
                ], true)
            ]) ?>
                <?php $handle('headerBegin') ?>
<?php } ?>
                <?php $this->renderZone($zones->get('header')) ?>
<?php if ($this->getIsRenderAllowed()) { ?>
                <?php $handle('headerEnd') ?>
            <?= Html::endTag('div') ?>
        <?= Html::endTag('div') ?>
        <?= Html::beginTag('div', [
            'class' => Html::cssClassFromArray([
                'intec-template-layout-page' => true,
                'intec-content' => $settings['background']['show'],
                'intec-content-visible' => $settings['background']['show']
            ], true)
        ]) ?>
            <?= Html::beginTag('div', [
                'class' => Html::cssClassFromArray([
                    'intec-template-layout-page-wrapper' => true,
                    'intec-content-wrapper' => $settings['background']['show']
                ], true)
            ]) ?>
                <div class="intec-template-layout-content">
                    <?php $handle('contentBegin') ?>
<?php } ?>
                    <?php $this->renderZone($zones->get('default')) ?>
<?php if ($this->getIsRenderAllowed()) { ?>
                    <?php $handle('contentEnd') ?>
                </div>
            <?= Html::endTag('div') ?>
        <?= Html::endTag('div') ?>
        <div class="intec-template-layout-footer">
            <?php $handle('footerBegin') ?>
<?php } ?>
            <?php $this->renderZone($zones->get('footer')) ?>
<?php if ($this->getIsRenderAllowed()) { ?>
            <?php $handle('footerEnd') ?>
        </div>
    <?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
<?php $handle('end') ?>
<?php } ?>
