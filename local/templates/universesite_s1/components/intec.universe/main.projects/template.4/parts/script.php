<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arForm
 */

?>
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
        'name': '[Component] intec.universe:main.projects (template.4)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>