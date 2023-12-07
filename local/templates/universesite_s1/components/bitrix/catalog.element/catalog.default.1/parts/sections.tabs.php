<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arResult
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
            'mod-block'
        ]
    ],
    'data-ui-control' => 'tabs'
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
<div class="catalog-element-sections catalog-element-sections-tabs intec-ui intec-ui-control-tabs-content">
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
</div>
<?php unset($sCode, $arSection) ?>