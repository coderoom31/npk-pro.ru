<style type="text/css">
    .page-company-items {}

    .page-company-items .page-company-item {
        margin-bottom: 15px;
        color: #888;
    }
    .page-company-items .page-company-item-header {
        margin-bottom: 10px;
        line-height: 1;
    }
    .page-company-items .page-company-item-header img,
    .page-company-items .page-company-item-header .page-company-item-picture,
    .page-company-items .page-company-item-title {
        display: inline-block;
        vertical-align: middle;
    }
    .page-company-items .page-company-item-header img,
    .page-company-items .page-company-item-header .page-company-item-picture {
        width: 50px;
        height: 50px;
    }
    .page-company-items .page-company-item-header .page-company-item-picture svg {
        max-width: 100%;
        max-height: 100%;
    }
    .page-company-items .page-company-item-title {
        padding-left: 8px;
        font-size: 40px;
    }
    .page-company-items .page-company-item-description {
        font-size: 14px;
    }

    @media all and (max-width: 768px) {
        .page-company-items .page-company-item-header,
        .page-company-items .page-company-item-description {
            text-align: center;
        }
    }

    @media all and (max-width: 500px) {
        .page-company-items .page-company-item-header,
        .page-company-items .page-company-item-description {
            text-align: left;
        }
    }
</style>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <div class="intec-grid intec-grid-wrap intec-grid-a-v-center intec-grid-a-h-center intec-grid-i-h-25 intec-grid-i-v-10">
            <div class="intec-grid-item-3 intec-grid-item-720-auto">
                <img alt="О компании" src="/images/about.png">
            </div>
            <div class="intec-grid-item intec-grid-item-720-1">
                <h1 class="intec-ui-markup-header intec-ui-markup-h2">О компании</h1>
                <div class="intec-ui-markup-text">
                    Волшебный мир, в который он уже вступал, который уже возникал из туманных волн прошедшего, шевельнулся — и исчез. Дорога из Марьина огибала лесок; легкая пыль лежала на ней, еще не тронутая со вчерашнего дня ни колесом, ни ногою. Базаров невольно посматривал вдоль той дороги, рвал и кусал траву, а сам все твердил про себя: «Экая глупость!» Утренний холодок заставил его раза два вздрогнуть... Петр уныло взглянул на него, но Базаров только усмехнулся: он не трусил.
                </div>
                <div class="page-company-items intec-grid intec-grid-wrap intec-grid-a-h-center itec-grid-i-h-15 intec-ui-p-t-30">
                    <div class="page-company-item intec-grid-item-3 intec-grid-item-768-2 intec-grid-item-500-1">
                        <div class="page-company-item-header">
                            <span class="page-company-item-picture">
                                <?php include(__DIR__.'/svg/exam.svg') ?>
                            </span>
                            <span class="page-company-item-title"><span data-new-number="10"></span> лет</span>
                        </div>
                        <div class="page-company-item-description">на рынке услуг</div>
                    </div>
                    <div class="page-company-item intec-grid-item-3 intec-grid-item-768-2 intec-grid-item-500-1">
                        <div class="page-company-item-header">
                            <span class="page-company-item-picture">
                                <?php include(__DIR__.'/svg/trophy.svg') ?>
                            </span>
                            <span class="page-company-item-title"><span data-new-number="350"></span></span>
                        </div>
                        <div class="page-company-item-description">выполненных проектов</div>
                    </div>
                    <div class="page-company-item intec-grid-item-3 intec-grid-item-768-2 intec-grid-item-500-1">
                        <div class="page-company-item-header">
                            <span class="page-company-item-picture">
                                <?php include(__DIR__.'/svg/business.svg') ?>
                            </span>
                            <span class="page-company-item-title"><span data-new-number="275"></span> %</span>
                        </div>
                        <div class="page-company-item-description">увеличение оборота за год</div>
                    </div>
                </div>
                <div class="intec-ui-m-t-10">
                    <a href="/company/" class="intec-ui intec-ui-control-button intec-ui-mod-round-3 intec-ui-mod-transparent intec-ui-scheme-current intec-ui-size-2">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var inWindow = function (selector) {
            var $elements = $(selector);
            var scrollTop = $(window).scrollTop();
            var windowHeight = $(window).height();
            var result = [];
            $elements.each(function(){
                var $el = $(this);
                var offset = $el.offset();
                var elHeight = $el.height();
                if (((scrollTop - 50) <= offset.top && (elHeight + offset.top) <= (scrollTop + windowHeight + 50))
                    ||
                    ((scrollTop + 50) >= offset.top && (elHeight + offset.top) >= (scrollTop + windowHeight - 50) )
                ) {
                    result.push(this);
                }
            });
            return $(result);
        };

        var numberAnimate = function (el) {
            var $el = $(el);
            var newNumber = parseInt($el.data('new-number'));
            if (newNumber > 0) {
                $el.prop('number', 0)
                    .animateNumber({
                        number: newNumber,
                        numberStep: $.animateNumber.numberStepFactories.separator(' ')
                    }, 1500);
            }
            $el.addClass('show_animation');
        };

        $(window).scroll(function(){
            inWindow('.page-company-item-header [data-new-number]:not(.show_animation)').each(function(){
                numberAnimate(this);
            });
        });
        inWindow($('.page-company-item-header [data-new-number]').html('0')).each(function(){
            numberAnimate(this);
        });
    });
</script>