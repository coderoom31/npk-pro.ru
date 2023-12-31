<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arResult
 * @var array $arParams
 */

$arFormParameters = [
    'id' => $arResult['WEB_FORM']['ID'],
    'template' => $arParams['WEB_FORM_TEMPLATE'],
    'parameters' => [
        'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_FORM',
        'CONSENT_URL' => $arParams['CONSENT_URL']
    ],
    'settings' => [
        'title' => $arResult['TEXT']['FORM']
    ]
];

?>
<script type="text/javascript">
    template.load(function (data) {
        var app = this;
        var $ = app.getLibrary('$');
        var form = {
            'node': $('[data-role="form"]', data.nodes),
            'parameters': <?= JavaScript::toObject($arFormParameters) ?>
        };

        form.node.on('click', function () {
            app.api.forms.show(form.parameters);

            if (window.yandex && window.yandex.metrika) {
                window.yandex.metrika.reachGoal('forms.open');
                window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['WEB_FORM']['ID'].'.open') ?>);
            }
        });
    }, {
        'name': '[Component] intec.universe:widget (web.form.2)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>