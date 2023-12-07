<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arParams
 * @var array $arForm
 */

?>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var _ = this.getLibrary('_');
        var contacts = $('[data-role="contacts"]', data.nodes);

        var initialize;
        var loader;
        var move;
        var map;

        initialize = function () {

            if (!_.isObject(window.maps))
                return false;

            map = window.maps[<?= JavaScript::toObject($arParams['MAP_ID']) ?>];

            if (map == null)
                return false;

            contacts.items = $('[data-role="contacts.item"]', contacts);

            contacts.items.each(function () {
                var contact = $(this);

                contact.on('click', function () {
                    var activeContact = contacts.items.filter('[data-state="enabled"]', contacts);

                    activeContact.attr('data-state', 'disabled');
                    contact.attr('data-state', 'enabled');
                    activeContact.removeClass('intec-cl-background');
                    contact.addClass('intec-cl-background');

                    move(
                        contact.data('latitude'),
                        contact.data('longitude')
                    );

                });
            });

            return true;
        };

        move = function (latitude, longitude) {
            latitude = _.toNumber(latitude);
            longitude = _.toNumber(longitude);

            <?php if ($arParams['MAP_VENDOR'] == 'google') { ?>
            map.panTo(new google.maps.LatLng(latitude, longitude));
            <?php } else if ($arParams['MAP_VENDOR'] == 'yandex') { ?>
            map.panTo([latitude, longitude]);
            <?php } ?>
        };

        <?php if ($arParams['MAP_VENDOR'] == 'google') { ?>
        BX.ready(initialize);
        <?php } else if ($arParams['MAP_VENDOR'] == 'yandex') { ?>
        loader = function () {
            var load;

            load = function () {
                if (!initialize())
                    setTimeout(load, 100);
            };

            if (window.ymaps) {
                ymaps.ready(load);
            } else {
                setTimeout(loader, 100);
            }
        };

        loader();
        <?php } ?>
    }, {
        'name': '[Component] intec.universe:main.widget (contacts.1) > bitrix:news.list (.default)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>
<?php if (!empty($arVisual['FEEDBACK']['BUTTON']['VALUE'])) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var app = this;
            var $ = app.getLibrary('$');
            var form = {
                'nodes': $('[data-role="form"]', data.nodes),
                'parameters': <?= JavaScript::toObject($arForm) ?>
            };

            form.nodes.each(function () {
                var self = $(this);

                self.on('click', function () {
                    app.api.forms.show(form.parameters);

                    if (window.yandex && window.yandex.metrika) {
                        window.yandex.metrika.reachGoal('forms.open');
                        window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arForm['id'].'.open') ?>);
                    }
                });
            });
        }, {
            'name': '[Component] intec.universe:main.widget (contacts.1) > bitrix:news.list (.default) > feedback',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>