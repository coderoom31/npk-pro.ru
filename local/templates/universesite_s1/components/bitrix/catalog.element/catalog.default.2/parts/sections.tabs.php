<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var array $arVisual
 * @var string $sTemplateId
 */

?>
<?= Html::beginTag('ul', [
    'class' => [
        'catalog-element-tabs',
        'intec-ui' => [
            '',
            'control-tabs',
            'scheme-current',
            'view-1',
            'mod-block',
            'mod-position-left'
        ],
        'intec-ui-clearfix'
    ],
    'data' => [
        'ui-control' => 'tabs',
        'animation' => $arVisual['TABS']['ANIMATION'] ? 'true' : 'false'
    ]
]) ?>
    <?php foreach ($arResult['SECTIONS'] as $sCode => $arSection) { ?>
        <?= Html::beginTag('li', [
            'class' => [
                'catalog-element-tab',
                'intec-ui-part-tab'
            ],
            'data-active' => $arSection['ACTIVE'] ? 'true' : 'false'
        ]) ?>
            <?= Html::tag('a', $arSection['NAME'], [
                'href' => !empty($arSection['URL']) ? ($arSection['ACTIVE'] ? null : $arSection['URL']) : '#'.$sTemplateId.'-'.$arSection['CODE'],
                'data-type' => 'tab'
            ]) ?>
        <?= Html::endTag('li') ?>
    <?php } ?>
<?= Html::endTag('ul') ?>
<?= Html::beginTag('div', [
    'class' => [
        'catalog-element-sections',
        'catalog-element-sections-tabs',
        'intec-ui' => [
            '',
            'control-tabs-content',
            'clearfix'
        ],
    ]
]) ?>
    <?php foreach ($arResult['SECTIONS'] as $sCode => $arSection) {

        if (!empty($arSection['URL']) && !$arSection['ACTIVE'])
            continue;

    ?>
        <?= Html::beginTag('div', [
            'id' => empty($arSection['URL']) ? $sTemplateId.'-'.$arSection['CODE'] : null,
            'class' => [
                'catalog-element-section',
                'intec-ui-part-tab'
            ],
            'data-active' => $arSection['ACTIVE'] ? 'true' : 'false'
        ]) ?>
            <div class="catalog-element-section-content" data-role="section.content">
                <?php include(__DIR__.'/sections/'.$arSection['CODE'].'.php') ?>
            </div>
        <?= Html::endTag('div') ?>
    <?php } ?>
<?= Html::endTag('div') ?>
<?php unset($sCode, $arSection) ?>