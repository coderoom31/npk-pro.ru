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
    'items' => 5,
    'loop' => $arVisual['SLIDER']['LOOP'],
    'nav' => false,
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
        var sliderContent = $('[data-role="slider.content"]', data.nodes);
        var sliderNavigation = $('[data-role="slider.navigation"]', data.nodes);
        var settings = <?= JavaScript::toObject($arSettings) ?>;

        var showContent = function () {
            var content = $('.widget-owl-item.center [data-role="slide.content"]', slider).html();

            sliderContent.css('opacity', 1).html(content);
        };

        var hideContent = function () {
            sliderContent.css('opacity', 0);
        };

        slider.owlCarousel({
            'items': settings.items,
            'itemClass': 'widget-owl-item owl-item',
            'loop': settings.loop,
            'center': true,
            'dots': false,
            'stageOuterClass': 'owl-stage-outer widget-outer-items',
            'stageClass': 'owl-stage',
            'nav': settings.nav,
            'autoplay': settings.autoplay,
            'autoplayTimeout': settings.autoplayTimeout,
            'autoplayHoverPause': settings.autoplayHoverPause,
            'autoHeight': settings.autoHeight,
            'onInitialized': showContent,
            'onTranslated': showContent,
            'onTranslate': hideContent,
            'responsive':{
                0: {
                    'items': 1
                },
                400: {
                    'items': 3
                },
                690:{}
            }
        });

        $('[data-role="slider.navigation.right"]', sliderNavigation).on('click', function () {
            slider.trigger('next.owl.carousel');
        });

        $('[data-role="slider.navigation.left"]', sliderNavigation).on('click', function () {
            slider.trigger('prev.owl.carousel');
        });
    }, {
        'name': '[Component] intec.universe:main.reviews (template.15) > slider',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>