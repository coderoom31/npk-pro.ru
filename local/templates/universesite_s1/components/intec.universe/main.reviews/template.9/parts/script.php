<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arVisual
 */

if ($arParams['SLIDER_SHORT_TEXT'] === 'Y') {
    $autoHeight = false;
} else {
    !defined('EDITOR') ? $autoHeight = true : $autoHeight = false;
}

$arSettings = [
    'loop' => $arVisual['SLIDER']['LOOP'],
    'navText' => [
        '<i class="fal fa-angle-left"></i>',
        '<i class="fal fa-angle-right"></i>'
    ],
    'autoplay' => $arVisual['SLIDER']['AUTO']['USE'],
    'autoplayTimeout' => $arVisual['SLIDER']['AUTO']['TIME'],
    'autoplayHoverPause' => $arVisual['SLIDER']['AUTO']['HOVER'],
    'autoHeight' => $autoHeight
];

?>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var slider = $('[data-role="container"]', data.nodes);
        var settings = <?= JavaScript::toObject($arSettings) ?>;

        slider.owlCarousel({
            'items': 1,
            'loop': settings.loop,
            'dots': false,
            'nav': true,
            'navText': settings.navText,
            'navContainerClass': 'intec-ui intec-ui-control-navigation',
            'navClass': ['intec-ui-part-button-left', 'intec-ui-part-button-right'],
            'autoplay': settings.autoplay,
            'autoplayTimeout': settings.autoplayTimeout,
            'autoplayHoverPause': settings.autoplayHoverPause,
            'autoHeight': settings.autoHeight
        });
    }, {
        'name': '[Component] intec.universe:main.reviews (template.9) > slider',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>