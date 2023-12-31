<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;
use intec\core\helpers\ArrayHelper;

/**
 * @var array $arVisual
 * @var array $arSvg
 */

?>
<?php return function (&$arOffer) use (&$arVisual, &$arResult, $sTemplateId) {

    if (!empty($arOffer['ITEM_PRICES'])) {
        $arDiscount = ArrayHelper::getFirstValue($arOffer['ITEM_PRICES']);
        if (!empty($arDiscount) && $arDiscount['PERCENT'] <= 0 && $arDiscount['DISCOUNT'] <= 0) {
            return null;
        }
    } else {
        return null;
    }

    $arResult['TIMER']['PROPERTIES']['parameters']['ELEMENT_ID'] = $arOffer['ID'];
    $arResult['TIMER']['PROPERTIES']['parameters']['IS_SECTION'] = true;

    ?>
    <div class="catalog-element-product-timer-offers-list" data-role="timer-holder" data-timer-id="<?= $arOffer['ID'] ?>"></div>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');
            var root = data.nodes;
            var timerId = <?= $arOffer['ID'] ?>;

            this.api.components.get(<?= JavaScript::toObject(
                $arResult['TIMER']['PROPERTIES']
            ) ?>).then(function (content) {
                $('[data-timer-id="' + timerId + '"]', root).html(content);
            });
        }, {
            'name': '[Component] bitrix:catalog.element (catalog.default.5)',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>