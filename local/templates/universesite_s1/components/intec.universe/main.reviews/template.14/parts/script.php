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
        'dots' => true,
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
            'name': '[Component] intec.universe:main.reviews (template.14) > video',
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
                'margin': 15,
                'dotsContainer': <?= JavaScript::toObject('#'.$sTemplateId) ?> + ' .widget-items-dots',
                'autoHeight': <?=$autoHeight?>,
                'onTranslate': customDots,
                'onTranslated': customDots
            });

            $('.widget-items-dot', data.nodes).on('click', function() {
                slider.trigger('to.owl.carousel', [$(this).index(), 300]);
            });

            function customDots() {
                slider.dots = $('[data-role="dot-items"]', data.nodes);
                slider.dots.dot = slider.dots.find('[data-role="dot-item"] .widget-dot-picture-wrap');
                slider.dots.dot.active = slider.dots.find('.active[data-role="dot-item"] .widget-dot-picture-wrap');
                slider.dots.dot.removeClass('intec-cl-border');
                slider.dots.dot.active.addClass('intec-cl-border');
            };

            customDots();

        }, {
            'name': '[Component] intec.universe:main.reviews (template.14) > slider',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>