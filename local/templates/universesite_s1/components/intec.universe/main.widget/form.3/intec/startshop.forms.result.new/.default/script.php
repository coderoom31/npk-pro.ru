<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 */

?>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var field = $('[data-role="field"]', data.nodes);
        var input = $('[data-role="input"]', data.nodes);

        field.on('click', function () {
            $(this).attr('data-active', 'true');
        });

        field.on('focusin', function() {
            $(this).attr('data-active', 'true');
        });

        input.on('focusout', function () {
            var field = $(this).closest('[data-role="field"]');
            var input = $(this);

            if (input.length){
                if (input.val().length === 0)
                    field.attr('data-active', 'false');
            }
        });
    }, {
        'name': '[Component] intec.universe:main.widget (form.4) > intec:startshop.form.result.new (.default)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>