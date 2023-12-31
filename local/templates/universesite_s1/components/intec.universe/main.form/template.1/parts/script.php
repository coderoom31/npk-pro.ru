<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var array $arResult
 * @var string $sTemplateId
 */

$arFormParameters = [
    'id' => $arResult['ID'],
    'template' => $arResult['TEMPLATE'],
    'parameters' => [
        'AJAX_OPTION_ADDITIONAL' => $sTemplateId . '_FORM_TEMPLATE_1',
        'CONSENT_URL' => $arResult['CONSENT']
    ],
    'settings' => [
        'title' => $arResult['NAME']
    ]
];

?>
<script type="text/javascript">
    template.load(function (data) {
        var app = this;
        var $ = app.getLibrary('$');

        $('[data-role="form.button"]', data.nodes).on('click', function () {
            app.api.forms.show(<?= JavaScript::toObject($arFormParameters) ?>);

            if (window.yandex && window.yandex.metrika) {
                window.yandex.metrika.reachGoal('forms.open');
                window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['ID'].'.open') ?>);
            }
        });
    }, {
        'name': '[Component] intec.universe:main.form (template.1)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>