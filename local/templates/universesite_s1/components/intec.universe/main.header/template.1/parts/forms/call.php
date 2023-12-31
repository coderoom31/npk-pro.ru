<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var array $arResult
 * @var string $sTemplateId
 */

$arFormCall = $arResult['FORMS']['CALL'];

?>
<script type="text/javascript">
    template.load(function (data) {
        var app = this;
        var $ = app.getLibrary('$');
        var root = data.nodes;
        var button = $('[data-action="forms.call.open"]', root);

        button.on('click', function () {
            app.api.forms.show(<?= JavaScript::toObject([
                'id' => $arFormCall['ID'],
                'template' => $arFormCall['TEMPLATE'],
                'parameters' => [
                    'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_FORM_CALL',
                    'CONSENT_URL' => $arResult['URL']['CONSENT']
                ],
                'settings' => [
                    'title' => $arFormCall['TITLE']
                ]
            ]) ?>);

            if (window.yandex && window.yandex.metrika) {
                window.yandex.metrika.reachGoal('forms.open');
                window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arFormCall['ID'].'.open') ?>);
            }
        });
    }, {
        'name': '[Component] intec.universe:main.header (template.1) > popup-form-call)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>