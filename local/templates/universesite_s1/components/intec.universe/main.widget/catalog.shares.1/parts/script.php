<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;
use Bitrix\Main\Localization\Loc;

/**
 * @var string $sTemplateId
 */

$bShowSeconds = $arVisual['TIMER']['SECONDS']['SHOW'];

?>
<script type="text/javascript">
    template.load(function (data) {
        let $ = this.getLibrary('$');
        let root = data.nodes;

        let secondsShow = $(<?= JavaScript::toObject($bShowSeconds) ?>);
        let fieldDay = $('[data-role="days"]', root);
        let fieldHour = $('[data-role="hours"]', root);
        let fieldMinute = $('[data-role="minutes"]', root);
        let fieldSeconds = $('[data-role="seconds"]', root);
        let scrollbar = $('[data-role="scrollbar"]', root);
        let aboveZero = true;
        let arDate = $(<?= JavaScript::toObject($arResult['DATA']['TIMER']['DATE']) ?>);

        if (!secondsShow)
            arDate[4]++;

        let finalDate = new Date(arDate[0], arDate[1] - 1, arDate[2], arDate[3], arDate[4], arDate[5]);
        let timeout = 60000;

        if (secondsShow)
            timeout = 1000;

        scrollbar.scrollbar();
        update('0', '00', '00', '00');
        time();

        function time() {
            let currentDate = new Date();
            let differentDate = finalDate - currentDate;
            let days = Math.floor(differentDate / 1000); /*миллисекунды в секунды*/

            if (days <= 0)
                aboveZero = false;

            if (!secondsShow) {
                timeout = ((days % 60) * 1000) + 1000;
            }

            let sec = days % 60; if (sec < 10) sec = '0' + sec; days = Math.floor(days / 60); /*секунды в минуты*/
            let min = days % 60; if (min < 10) min = '0' + min; days = Math.floor(days / 60); /*минуты в часы*/
            let hour = days % 24; if (hour < 10) hour = '0' + hour; days = Math.floor(days / 24); /*часы в дни*/

            if (aboveZero){
                update(days, hour, min, sec);
                setTimeout(time, timeout);
            } else {
                update('0', '00', '00', '00');
            }
        }

        function update(day, hour, minute, seconds) {
            fieldDay.html(day);
            fieldHour.html(hour);
            fieldMinute.html(minute);

            if (secondsShow)
                fieldSeconds.html(seconds);
        }
    }, {
        'name': '[Component] intec.universe:main.widget (catalog.shares.1)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>