<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 * @var string $sTemplateId
 */

$sComponentName = $arResult['TIMER']['PROPERTIES']['component'];
$sTemplate = $arResult['TIMER']['PROPERTIES']['template'];
$arProperties = $arResult['TIMER']['PROPERTIES']['properties'];

?>
<div data-role="timer-holder">
    <?php
    $APPLICATION->IncludeComponent(
        $sComponentName,
        $sTemplate,
        $arProperties,
        $component
    );
    ?>
</div>
<?php unset($sPrefix, $sTemplate, $iTimerQuantity, $arTimerParams); ?>