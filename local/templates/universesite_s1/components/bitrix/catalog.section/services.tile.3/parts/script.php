<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $sTemplateId
 * @var string $sTemplateContainer
 * @var array $arVisual
 * @var array $arNavigation
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$oSigner = new \Bitrix\Main\Security\Sign\Signer;
$sSignedTemplate = $oSigner->sign($templateName, 'catalog.section');
$sSignedParameters = $oSigner->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');

?>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var root = data.nodes;
        var items;
        var expanded = false;

        root.update = function () {

            items = $('[data-role="item"]', root);

            items.each(function () {
                var item = $(this);

                item.expand = function () {
                    var rectangle = item[0].getBoundingClientRect();
                    var height = rectangle.bottom - rectangle.top;

                    if (expanded)
                        return;

                    expanded = true;
                    item.attr('data-expanded', 'true');
                    item.css('height', height);
                };

                item.narrow = function () {
                    if (!expanded)
                        return;

                    expanded = false;
                    item.attr('data-expanded', 'false');
                    item.css('height', '');
                };

                item.on('mouseenter', item.expand)
                    .on('mouseleave', item.narrow);

                $(window).on('resize', function () {
                    if (expanded) {
                        item.narrow();
                        item.expand();
                    }
                });
            });
        };

        BX.message(<?= JavaScript::toObject([
            'BTN_MESSAGE_LAZY_LOAD' => '',
            'BTN_MESSAGE_LAZY_LOAD_WAITER' => ''
        ]) ?>);

        component = new JCCatalogSectionComponent(<?= JavaScript::toObject([
            'siteId' => SITE_ID,
            'componentPath' => $componentPath,
            'navParams' => $arNavigation,
            'deferredLoad' => false,
            'initiallyShowHeader' => false,
            'bigData' => $arResult['BIG_DATA'],
            'lazyLoad' => $arVisual['NAVIGATION']['LAZY']['BUTTON'],
            'loadOnScroll' => $arVisual['NAVIGATION']['LAZY']['SCROLL'],
            'template' => $sSignedTemplate,
            'parameters' => $sSignedParameters,
            'ajaxId' => $arParams['AJAX_ID'],
            'container' => $sTemplateContainer
        ]) ?>);

        component.processItems = (function () {
            var action = component.processItems;

            return function () {
                var result = action.apply(this, arguments);

                root.update();

                return result;
            };
        })();

        root.update();

    }, {
        'name': '[Component] bitrix:catalog.section (services.tile.3)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>
<?php

unset($sSignedParameters);
unset($sSignedTemplate);
unset($oSigner);