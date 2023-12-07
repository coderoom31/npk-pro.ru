<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use intec\core\bitrix\Component;
use intec\core\helpers\Html;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => Html::cssClassFromArray([
        'ns-bitrix' => true,
        'c-sale-personal-section' => true,
        'c-sale-personal-section-default' => true,
    ], true)
]) ?>
    <div class="intec-content">
        <div class="intec-content-wrapper">
            <div class="intec-grid intec-grid-wrap intec-grid-i-10 intec-grid-a-h-center intec-grid-a-v-stretch">
                <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
                    <div class="intec-grid-item-4 intec-grid-item-700-2 intec-grid-item-shrink-1">
                        <div class="sale-personal-section-index-block intec-cl-background">
                            <a class="intec-grid intec-grid-wrap intec-grid-a-h-center sale-personal-section-index-block-link" href="<?= htmlspecialcharsbx($arItem['PATH']) ?>">
                                <div class="intec-grid-item-1 sale-personal-section-index-block-icon">
                                    <?= $arItem['ICON'] ?>
                                </div>
                                <div class="intec-grid-item-auto intec-grid-item-shrink-1 sale-personal-section-index-block-name">
                                    <?= htmlspecialcharsbx($arItem['NAME']) ?>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?= Html::endTag('div') ?>