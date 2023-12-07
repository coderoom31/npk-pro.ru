<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var array $arVisual
 * @var array $arForm
 * @var string $sTemplateId
 */

$arSlider = [
    'items' => 1,
    'nav' => $arVisual['SLIDER']['NAV'],
    'navText' => [
        '<i class="fal fa-angle-left"></i>',
        '<i class="fal fa-angle-right"></i>'
    ],
    'dots' => false
];

?>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var gallery = $('[data-role="items"]', data.nodes);
        var settings = <?= JavaScript::toObject($arSlider) ?>;

        gallery.owlCarousel({
            'items': settings.items,
            'nav': settings.nav,
            'navText': settings.navText,
            'dots': false,
            'autoHeight': true
        });
    }, {
        'name': '[Component] intec.universe:main.staff (template.5) > slider',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>
<?php if ($arForm['SHOW']) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var app = this;
            var $ = app.getLibrary('$');
            var form = {
                'nodes': $('[data-role="form"]', data.nodes),
                'parameters': <?= JavaScript::toObject($arForm['PARAMETERS']) ?>
            };

            form.nodes.each(function () {
                var self = $(this);

                self.on('click', function () {
                    form.parameters.fields[<?= JavaScript::toObject($arForm['FIELD']) ?>] = self.attr('data-name');

                    app.api.forms.show(form.parameters);

                    form.parameters.fields[<?= JavaScript::toObject($arForm['FIELD']) ?>] = null;

                    if (window.yandex && window.yandex.metrika) {
                        window.yandex.metrika.reachGoal('forms.open');
                        window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arForm['ID'].'.open') ?>);
                    }
                });
            });
        }, {
            'name': '[Component] intec.universe:main.staff (template.5) > form',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>