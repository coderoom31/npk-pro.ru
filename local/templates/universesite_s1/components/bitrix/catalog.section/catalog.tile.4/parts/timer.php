<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var array $arParams
 * @var string $sTemplateId
 */

$sComponentName = $arResult['TIMER']['PROPERTIES']['component'];
$sTemplate = $arResult['TIMER']['PROPERTIES']['template'];
$arProperties = $arResult['TIMER']['PROPERTIES']['properties'];

?>
<?= Html::beginTag('div', [
    'class' => [
        'product-timer-adaptation',
        $arVisual['COLUMNS']['MOBILE'] == 2 ? 'super-small' : null,
        $arVisual['COLUMNS']['MOBILE'] == 2 ? 'small' : null
    ],
    'data-role' => 'timer-holder'
])?>
    <?php
        $APPLICATION->IncludeComponent(
            $sComponentName,
            $sTemplate,
            $arProperties,
            $component
        );
    ?>
<?= Html::endTag('div') ?>
<?php unset($sPrefix, $sTemplate, $iTimerQuantity, $arTimerParams); ?>