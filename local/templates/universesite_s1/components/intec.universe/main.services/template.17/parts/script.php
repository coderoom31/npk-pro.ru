<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arVisual
 */

$arSlider = [
    'items' => 3,
    'nav' => $arVisual['SLIDER']['NAV']['SHOW'],
    'navContainer' => '[data-role="container.nav"]',
    'navClass' => [
        'nav-prev',
        'nav-next'
    ],
    'navText' => [
        '<span class="far fa-angle-left"></span>',
        '<span class="far fa-angle-right"></span>'
    ],
    'dots' => $arVisual['SLIDER']['DOTS']['SHOW'],
    'dotsContainer' => '[data-role="container.dots"]',
    'margin' => 24,
    'loop' => $arVisual['SLIDER']['LOOP'],
    'autoplay' => $arVisual['SLIDER']['AUTO']['USE'],
    'responsive' => [
        '0' => ['items' => 1],
        '769' => ['items' => 2],
        '1025' => ['items' => 3]
    ]
];

if ($arSlider['autoplay']) {
    $arSlider['autoplayTimeout'] = $arVisual['SLIDER']['AUTO']['TIME'];
    $arSlider['autoplayHoverPause'] = $arVisual['SLIDER']['AUTO']['HOVER'];
}

?>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var slider = $('[data-role="container"]', data.nodes);
        var settings = <?= JavaScript::toObject($arSlider) ?>;

        slider.owlCarousel(settings);
    }, {
        'name': '[Component] intec.universe:main.services (template.17) > slider',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>