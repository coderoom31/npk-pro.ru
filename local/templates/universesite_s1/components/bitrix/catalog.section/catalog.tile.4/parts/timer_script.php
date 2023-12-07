<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

?>
<script type="text/javascript">
    template.load(function (data) {
        var $ = this.getLibrary('$');
        var root = data.nodes;
        var aboveZero = true;

        timer();

        function timer(){
            var timerBlock = $('[data-role="timer-holder"] .widget-content', root);

            timerBlock.each(function(){
                var date = $('[data-role="date-end"]', this);
                var block = this;

                var dateEnd = date.html().split(' ');
                var dateDate = dateEnd[0].split('-');
                var dateTime = dateEnd[1].split(':');
                dateEnd = dateDate.concat(dateTime);

                var finalDate = new Date(dateEnd[0], dateEnd[1] - 1, dateEnd[2], dateEnd[3], dateEnd[4], dateEnd[5]);

                time(block, finalDate, aboveZero);
            });
            setTimeout(timer, 1000);
        }

        function time(block, finalDate, aboveZero) {
            var currentDate = new Date();
            var differentDate = finalDate - currentDate;
            var days = Math.floor(differentDate / 1000); /*миллисекунды в секунды*/

            if (days <= 0)
                aboveZero = false;

            var sec = days % 60; if (sec < 10) sec = '0' + sec; days = Math.floor(days / 60); /*секунды в минуты*/
            var min = days % 60; if (min < 10) min = '0' + min; days = Math.floor(days / 60); /*минуты в часы*/
            var hour = days % 24; if (hour < 10) hour = '0' + hour; days = Math.floor(days / 24); /*часы в дни*/

            if (aboveZero) {
                update(block, days, hour, min, sec);
            } else {
                update(block, '0', '00', '00', '00');
            }
        }

        function update(block, day, hour, minute, seconds) {
            $('[data-role="days"]', block).html(day);
            $('[data-role="hours"]', block).html(hour);
            $('[data-role="minutes"]', block).html(minute);
            $('[data-role="seconds"]', block).html(seconds);
        }
    }, {
        'name': '[Component] bitrix:catalog.section (catalog.tile.4)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>