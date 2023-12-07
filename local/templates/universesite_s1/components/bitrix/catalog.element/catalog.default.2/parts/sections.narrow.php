<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var string $sTemplateId
 */

?>
<div class="catalog-element-sections catalog-element-sections-narrow" data-role="sections">
    <?php foreach ($arResult['SECTIONS'] as $sCode => $arSection) { ?>
        <?php if ($sCode === 'STORES') continue ?>
        <?= Html::beginTag('div', [
            'id' => $sTemplateId.'-'.$arSection['CODE'],
            'class' => 'catalog-element-section',
            'data' => [
                'role' => 'section',
                'expanded' => 'false'
            ]
        ]) ?>
            <div class="catalog-element-section-name intec-ui-markup-header">
                <div class="catalog-element-section-name-wrapper">
                    <span data-role="section.toggle">
                        <?= $arSection['NAME'] ?>
                    </span>
                    <div class="catalog-element-section-name-decoration" data-role="section.toggle"></div>
                </div>
            </div>
            <div class="catalog-element-section-content" data-role="section.content">
                <div class="catalog-element-section-content-wrapper">
                    <?php include(__DIR__.'/sections/'.$arSection['CODE'].'.php') ?>
                </div>
            </div>
        <?= Html::endTag('div') ?>
    <?php } ?>
</div>
<?php unset($sCode, $arSection) ?>