<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 */

?>
<script type="text/javascript">
    template.load(function (data) {
        var app = this;
        var $ = this.getLibrary('$');

        var root = data.nodes;
        var print = $('[data-role="print"]', root);
        var clear = $('[data-role="clear"]', root);

        print.on('click', function () {
            var cssPath = [
                <?= JavaScript::toObject(SITE_TEMPLATE_PATH.'/css/interface.css') ?>,
                <?= JavaScript::toObject(SITE_TEMPLATE_PATH.'/css/grid.css') ?>,
                <?= JavaScript::toObject($this->GetFolder().'/style.css') ?>
            ];

            root.printThis({
                'importCSS': false,
                'importStyle': true,
                'loadCSS': cssPath,
                'pageTitle': "",
                'removeInline': false,
                'header': null,
                'formValues': true,
                'base': true
            });
        });

        clear.on('click', function () {
            app.api.basket.clear().run().then(function () {
                location.reload();
            });
        });
    }, {
        'name': '[Component] bitrix:sale.basket.basket (template.2)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>