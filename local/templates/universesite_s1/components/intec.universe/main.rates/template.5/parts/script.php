<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arVisual
 * @var array $arForm
 */

if (!$arVisual['SLIDER']['USE'] && !$arForm['USE'])
    return;

if ($arVisual['SLIDER']['USE']) {
    $arSlider = [
        'items' => $arVisual['COLUMNS'],
        'nav' => $arVisual['SLIDER']['NAV'],
        'navText' => [
            '<i class="fal fa-angle-left"></i>',
            '<i class="fal fa-angle-right"></i>'
        ],
        'dots' => $arVisual['SLIDER']['DOTS'],
        'loop' => $arVisual['SLIDER']['LOOP'],
        'autoplay' => $arVisual['SLIDER']['AUTO']['USE'],
        'autoplayTimeout' => $arVisual['SLIDER']['AUTO']['TIME'],
        'autoplayHoverPause' => false,
        'responsive' => [
            0 => ['items' => 1],
            650 => ['items' => 2],
            901 => ['items' => 3],
        ]
    ];

    if ($arVisual['COLUMNS'] >= 4)
        $arSlider['responsive'][1201] = ['items' => 4];
}

?>
<?php if ($arVisual['SLIDER']['USE']) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');
            var slider = $('[data-slider="true"]', data.nodes);
            var settings = <?= JavaScript::toObject($arSlider) ?>;

            slider.each(function () {
                var self = $(this);

                var adapt = function () {
                    <?php if (!defined('EDITOR')) { ?>
                        var container = $('.owl-stage', self);
                        var item = $('.owl-item', self);

                        item.css({'height': 'initial'});
                        item.css({'height': container.height()});
                    <?php }  else { ?>
                        return false;
                    <?php } ?>
                };

                self.owlCarousel({
                    'items': settings.items,
                    'loop': settings.loop,
                    'nav': settings.nav,
                    'autoplay': settings.autoplay,
                    'autoplayTimeout': settings.autoplayTimeout,
                    'autoplayHoverPause': settings.autoplayHoverPause,
                    'navText': settings.navText,
                    'navContainerClass': 'intec-ui intec-ui-control-navigation',
                    'navClass': ['intec-ui-part-button-left intec-cl-background-hover intec-cl-border-hover', 'intec-ui-part-button-right intec-cl-background-hover intec-cl-border-hover'],
                    'dots': settings.dots,
                    'dotsClass': 'intec-ui intec-ui-control-dots',
                    'dotClass': 'intec-ui-part-dot',
                    'responsive': settings.responsive,
                    'onRefreshed': adapt
                });
            });
        }, {
            'name': '[Component] intec.universe:main.rates (template.5) > slider',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>
<?php if ($arVisual['BUTTON']['MODE'] === 'order' && $arForm['SHOW']) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var app = this;
            var $ = app.getLibrary('$');
            var buttons = $('[data-role="rate.button"]', data.nodes);

            buttons.each(function () {
                var self = $(this);

                self.on('click', function () {
                    var parameters = <?= JavaScript::toObject($arForm['PARAMETERS']) ?>;

                    parameters.fields[<?= JavaScript::toObject($arForm['FIELD']) ?>] = self.data('value');

                    app.api.forms.show(parameters);

                    if (window.yandex && window.yandex.metrika) {
                        window.yandex.metrika.reachGoal('forms.open');
                        window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arForm['ID'].'.open') ?>);
                    }
                });
            });
        }, {
            'name': '[Component] intec.universe:main.rates (template.5) > order',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>