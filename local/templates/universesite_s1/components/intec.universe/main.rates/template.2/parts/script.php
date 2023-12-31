<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var array $arForm
 * @var string $sTemplateId
 */

?>
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
        'name': '[Component] intec.universe:main.rates (template.2) > order',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>