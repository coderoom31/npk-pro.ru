<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\JavaScript;

/**
 * @var array $arResult
 * @var array $arData
 */

?>
<script type="text/javascript" id="95784268">
    template.load(function (data) {
    console.log('Hello World!');
        var app = this;
        var $ = app.getLibrary('$');
        var button = $('[data-action="forms.call.open"]', data.nodes);

        button.on('click', function () {
            console.log(app.api);
            app.api.forms.show(<?= JavaScript::toObject([
                'id' => $arResult['FORMS']['CALL']['ID'],
                'template' => $arResult['FORMS']['CALL']['TEMPLATE'],
                'parameters' => [
                    'AJAX_OPTION_ADDITIONAL' => $arData['id'].'_FORM_CALL',
                    'CONSENT_URL' => $arResult['URL']['CONSENT']
                ],
                'settings' => [
                    'title' => $arResult['FORMS']['CALL']['TITLE']
                ]
            ]) ?>);

            if (window.yandex && window.yandex.metrika) {
                window.yandex.metrika.reachGoal('forms.open');
                window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['FORMS']['CALL']['ID'].'.open') ?>);
            }
        });
    }, {
        'name': '[Component] intec.universe:main.footer (template.1)',
        'nodes': <?= JavaScript::toObject('#'.$arData['id']) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>
