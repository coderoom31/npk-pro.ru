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
        var order = $('[data-role="service.order"]', data.nodes);

        order.each(function () {
           var self  = $(this);

           self.on('click', function () {
               var parameters = <?= JavaScript::toObject($arForm['PARAMETERS']) ?>;

               parameters.fields[<?= JavaScript::toObject($arForm['FIELD']) ?>] = self.attr('data-name');

               app.api.forms.show(parameters);

               if (window.yandex && window.yandex.metrika) {
                   window.yandex.metrika.reachGoal('forms.open');
                   window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arForm['PARAMETERS']['id'].'.open') ?>);
               }
           });
        });
    }, {
        'name': '[Component] intec.universe:main.services (template.22) > order',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>