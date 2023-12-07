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
        'items' => 1,
        'dots' => $arVisual['SLIDER']['DOTS'],
        'loop' => $arVisual['SLIDER']['LOOP'],
        'autoplay' => $arVisual['SLIDER']['AUTO']['USE'],
        'autoplayTimeout' => $arVisual['SLIDER']['AUTO']['TIME'],
        'autoplayHoverPause' => $arVisual['SLIDER']['AUTO']['HOVER'],
        'responsive' => [
            0 => ['items' => 1]
        ]
    ];
}

?>
<?php if ($arVisual['VIDEO']['SHOW']) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');
            var video = $('[data-role="container"]', data.nodes);

            video.lightGallery({
                'selector': '[data-role="video"]'
            });
        }, {
            'name': '[Component] intec.universe:main.reviews (template.18) > video',
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
            'name': '[Component] intec.universe:main.reviews (template.18) > slider',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>