<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arVisual
 */

if ($arParams['SLIDER_SHORT_TEXT'] === 'Y') {
    $autoHeight = "false";
} else {
    $autoHeight = "true";
}

if ($arVisual['SLIDER']['USE']) {
    $arSettings = [
        'items' => $arVisual['COLUMNS'],
        'dots' => $arVisual['SLIDER']['DOTS'],
        'loop' => $arVisual['SLIDER']['LOOP'],
        'autoplay' => $arVisual['SLIDER']['AUTO']['USE'],
        'autoplayTimeout' => $arVisual['SLIDER']['AUTO']['TIME'],
        'autoplayHoverPause' => $arVisual['SLIDER']['AUTO']['HOVER'],
        'responsive' => [
            0 => ['items' => 1]
        ]
    ];

    if ($arVisual['COLUMNS'] >= 2)
        $arSettings['responsive'][1025] = ['items' => 2];
}

?>
<?php if ($arVisual['VIDEO']['SHOW']) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');
            var container = $('[data-role="container"]', data.nodes);

            container.lightGallery({
                'selector': '[data-role="video"]'
            });
        }, {
            'name': '[Component] intec.universe:main.reviews (template.1) > video',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>
<?php if ($arVisual['SLIDER']['USE']) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');
            var slider = $('[data-role="container"]', data.nodes);
            var settings = <?= JavaScript::toObject($arSettings) ?>;

            slider.owlCarousel({
                'items': settings.items,
                'dots': settings.dots,
                'dotsClass': 'intec-ui intec-ui-control-dots',
                'dotClass': 'intec-ui-part-dot',
                'loop': settings.loop,
                'autoplay': settings.autoplay,
                'autoplayTimeout': settings.autoplayTimeout,
                'autoplayHoverPause': settings.autoplayHoverPause,
                'responsive': settings.responsive,
                'autoHeight': <?=$autoHeight?>
            });
        }, {
            'name': '[Component] intec.universe:main.reviews (template.1) > slider',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        })
    </script>
<?php } ?>