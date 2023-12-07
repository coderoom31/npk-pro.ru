<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\FileHelper;
use intec\core\helpers\JavaScript;

/**
 * @var array $arResult
 * @var array $arVisual
 * @var array $arSvg
 * @var string $sTemplateId
 * @var bool $bOffers
 * @var bool $bSkuDynamic
 * @var bool $bSkuList
 */

if (Loader::includeModule('catalog') && Loader::includeModule('sale'))
    $bBase = true;
else
    $bBase = false;

if ($bBase)
    CJSCore::Init(['currency']);

?>
<script type="text/javascript">
    template.load(function (data) {
        var app = this;
        var $ = this.getLibrary('$');
        var _ = this.getLibrary('_');
        var area = $(document);
        var root = data.nodes;
        var dynamic = $('[data-role="dynamic"]', root);
        var properties = root.data('properties');
        var dataItem = root.data('data');
        var entity = dataItem;

        dynamic.offers = new app.classes.catalog.Offers({
            'properties': properties,
            'list': dataItem.offers
        });

        window.offers = dynamic.offers;

        root.gallery = $('[data-role="gallery"]', root);
        root.gallery.preview = $('[data-role="gallery.preview"]', root.gallery);
        root.panel = $('[data-role="panel"]', root);
        root.panel.picture = $('[data-role="panel.picture"]', root.panel);
        root.section = $('[data-role="section"]', root);
        root.anchors = $('[data-role="anchor"]', root);
        root.storeSection = $('[data-role="store.section"]', root);

        dynamic.recalculation = dynamic.data('recalculation');
        dynamic.summary = $('[data-role="item.summary"]', dynamic);
        dynamic.summary.price = $('[data-role="item.summary.price"]', dynamic.summary);
        dynamic.article = $('[data-role="article"]', dynamic);
        dynamic.article.value = $('[data-role="article.value"]', dynamic.article);
        dynamic.counter = $('[data-role="counter"]', dynamic);
        dynamic.price = $('[data-role="price"]', dynamic);
        dynamic.price.base = $('[data-role="price.base"]', dynamic.price);
        dynamic.price.discount = $('[data-role="price.discount"]', dynamic.price);
        dynamic.price.percent = $('[data-role="price.percent"]', dynamic.price);
        dynamic.price.difference = $('[data-role="price.difference"]', dynamic.price);
        dynamic.price.measure = $('[data-role="price.measure"]', dynamic. price);

        dynamic.priceRange = $('[data-role="price.ranges"]', dynamic);

        dynamic.panelMobile = $('[data-role="panel.mobile"]', dynamic);
        dynamic.purchase = $('[data-role="purchase"]', dynamic);

        <?php if ($arVisual['MEASURES']['USE']) { ?>
        dynamic.ratio = $('[data-role="ratio"]', dynamic.purchase);
        dynamic.ratio.value = $('[data-role="ratio.value"]', dynamic.ratio);
        dynamic.ratio.measure = $('[data-role="ratio.measure"]', dynamic.ratio);
        dynamic.measures = $('[data-role="measures"]', dynamic.purchase);
        dynamic.measures.create = function () {
            var price = $('[data-role="measures.price"]', dynamic.measures);
            var select = $('[data-role="measures.select"]', dynamic.measures);

            select.each(function () {
                var self = $(this);
                var parts = {};

                parts.content = $('[data-role="measures.select.content"]', self);
                parts.option = $('[data-role="measures.select.option"]', self);

                parts.content.on('click', function () {
                    if (self.attr('data-active') === 'true')
                        self.attr('data-active', 'false');
                    else
                        self.attr('data-active', 'true');
                });
                parts.option.on('click', function () {
                    var option = $(this);

                    self.attr('data-active', 'false');

                    parts.option.attr('data-selected', 'false')
                        .removeClass('intec-cl-text');

                    option.attr('data-selected', 'true')
                        .addClass('intec-cl-text');

                    $('[data-role="measures.select.content.measure"]', parts.content).html(option.html());

                    dynamic.measures.setSelected(option.attr('data-measure-id'));

                    dynamic.update();
                });

                $(document).on('click', function (event) {
                    if (
                        !event.target.closest('[data-role="measures.select"]', self) &&
                        self.attr('data-active') === 'true'
                    ) {
                        self.attr('data-active', 'false');
                    }
                });
            });
        };
        dynamic.measures.setSelected = function (id) {
            id = _.toInteger(id);

            _.each(entity.measures.items, function (item) {
                if (item.id === id)
                    entity.measures.selected = item;
            });
        };
        dynamic.measures.getSelected = function () {
            return entity.measures.selected;
        };
        dynamic.measures.getSelectedMeasure = function () {
            return entity.measures.selected.symbol;
        };
        dynamic.measures.calculateRatio = function (ratio) {
            return ratio * entity.measures.selected.multiplier;
        };
        dynamic.measures.calculatePrice = function (price) {
            var measure = dynamic.measures.getSelected();

            return price.discount.value / measure.multiplier;
        };
        dynamic.measures.calculateQuantity = function (quantity) {
            return entity.measures.selected.multiplier * quantity;
        };
        dynamic.measures.calculateQuantityBase = function (quantity) {
            return (quantity / entity.measures.selected.multiplier * entity.measures.base.multiplier).toFixed(3);
        };
        dynamic.measures.calculateCounter = function () {
            var counter = {
                'bounds': {
                    'minimum': entity.quantity.ratio,
                    'maximum': false
                },
                'step': entity.quantity.ratio
            };

            if (entity.measures.selected.id !== entity.measures.base.id) {
                var ratio = dynamic.measures.calculateRatio(entity.quantity.ratio);

                counter.bounds.minimum = ratio;
                counter.step = ratio;
            }

            if (entity.quantity.trace && !entity.quantity.zero)
                counter.bounds.maximum = dynamic.measures.calculateQuantity(entity.quantity.value);

            return counter;
        };
        dynamic.measures.priceByQuantity = function (priceObject) {
            return priceObject.quantity.from === null ||
                dynamic.quantity.get() >= (priceObject.quantity.from * entity.measures.selected.multiplier)
        };
        <?php } ?>

        <?php if (!$bOffers || $bSkuDynamic) { ?>
        dynamic.quantity = app.ui.createControl('numeric', {
            'node': dynamic.counter,
            'bounds': {
                'minimum': entity.quantity.ratio,
                'maximum': entity.quantity.trace && !entity.quantity.zero ? entity.quantity.value : false
            },
            'step': entity.quantity.ratio
        });
        dynamic.update = function () {
            var article = entity.article;
            var price = null;
            var quantity = {
                'bounds': {
                    'minimum': entity.quantity.ratio,
                    'maximum': entity.quantity.trace && !entity.quantity.zero ? entity.quantity.value : false
                },
                'step': entity.quantity.ratio
            };

            <?php if ($arVisual['MEASURES']['USE']) { ?>
            quantity = dynamic.measures.calculateCounter();
            <?php } ?>

            root.attr('data-available', entity.available ? 'true' : 'false');

            if (article == null)
                article = dataItem.article;

            dynamic.article.attr('data-show', article == null ? 'false' : 'true');
            dynamic.article.value.text(article);

            _.each(entity.prices, function (object) {
                <?php if ($arVisual['MEASURES']['USE']) { ?>
                if (dynamic.measures.priceByQuantity(object))
                    price = object;
                <?php } else { ?>
                if (object.quantity.from === null || dynamic.quantity.get() >= object.quantity.from)
                    price = object;
                <?php } ?>
            });

            if (price !== null) {

                <?php if ($bBase) { ?>
                BX.Currency.setCurrencyFormat(price.currency.CURRENCY, price.currency);
                <?php } ?>

                if (dynamic.recalculation === true) {
                    var summary = [];
                    var quantitySum;

                    <?php if ($arVisual['MEASURES']['USE']) { ?>
                    quantitySum = dynamic.measures.calculateQuantityBase(dynamic.quantity.get());
                    <?php } else { ?>
                    quantitySum = dynamic.quantity.get();
                    <?php } ?>

                    summary.value = price.discount.value * quantitySum;
                    summary.value = summary.value.toFixed(price.currency.DECIMALS);
                    summary.display = BX.Currency.currencyFormat(summary.value, price.currency.CURRENCY, true);

                    dynamic.summary.price.html(summary.display);
                }

                dynamic.price.attr('data-discount', price.discount.use ? 'true' : 'false');
                dynamic.price.base.html(price.base.display);
                dynamic.price.discount.html(price.discount.display);
                dynamic.price.percent.text('-' + price.discount.percent + '%');
                dynamic.price.difference.html(price.discount.difference);

                <?php if ($arVisual['MEASURES']['USE']) { ?>
                var priceByMeasure = {
                    'value': dynamic.measures.calculatePrice(price),
                    'print': null
                };

                <?php if ($bBase) { ?>
                priceByMeasure.print = BX.Currency.currencyFormat(
                    priceByMeasure.value,
                    price.currency.CURRENCY,
                    true
                );
                <?php } ?>

                $('[data-role="measures.price"]', dynamic.measures).html(priceByMeasure.print);

                dynamic.ratio.value.html(dynamic.measures.calculateRatio(entity.quantity.ratio));
                dynamic.ratio.measure.html(dynamic.measures.getSelectedMeasure());
                <?php } ?>

                if (entity.quantity.measure) {
                    dynamic.price.attr('data-measure', 'true');
                    dynamic.price.measure.html(entity.quantity.measure);
                } else {
                    dynamic.price.attr('data-measure', 'false');
                    dynamic.price.measure.html(null);
                }
            } else {
                dynamic.price.attr('data-discount', 'false');
                dynamic.price.base.html(null);
                dynamic.price.discount.html(null);
                dynamic.price.percent.text(null);
                dynamic.price.difference.html(null);
                dynamic.price.measure.html(null);
            }

            dynamic.price.attr('data-show', price !== null ? 'true' : 'false');
            dynamic.quantity.configure(quantity);

            dynamic.find('[data-offer]').css('display', '');

            if (entity !== dataItem) {
                dynamic.find('[data-offer=' + entity.id + ']').css('display', 'block');
                dynamic.find('[data-offer="false"]').css('display', 'none');

                if (root.gallery.filter('[data-offer=' + entity.id + ']').length === 0)
                    root.gallery.filter('[data-offer="false"]').css('display', '');

                if (root.panel.picture.filter('[data-offer=' + entity.id + ']').length === 0)
                    root.panel.picture.filter('[data-offer="false"]').css('display', '');
            }

            var basketQuantity = dynamic.quantity.get();

            <?php if ($arVisual['MEASURES']['USE']) { ?>
            basketQuantity = dynamic.measures.calculateQuantityBase(basketQuantity);
            <?php } ?>

            dynamic.find('[data-basket-id]')
                .data('basketQuantity', basketQuantity)
                .attr('data-basket-quantity', basketQuantity);

            <?php if($arVisual['CREDIT']['SHOW']) { ?>
                creditPrice(summary, price);
            <?php } ?>

            <?php if ($arVisual['TIMER']['SHOW']) { ?>
                timerUpdate(entity.id);
            <?php } ?>

            if (dynamic.summary.length !== 0) {
                if (dynamic.quantity.get() === 1) {
                    if (!dynamic.summary.activated) {

                        dynamic.summary.animate({'height': 0}, 500, function () {
                            dynamic.summary.css({
                                'height': '',
                                'display': ''
                            });
                        });

                        dynamic.summary.addClass('hidden');
                        dynamic.attr('data-recalculation', 'false');
                    }
                    dynamic.summary.activated = true;
                } else if (dynamic.quantity.get() > 0) {
                    var heightSummary;
                    var recalc = dynamic.attr('data-recalculation');

                    dynamic.summary.removeClass('hidden');

                    if (recalc === 'false') {
                        dynamic.summary.css({
                            'height': 'auto',
                            'display': 'block'
                        });
                        heightSummary = dynamic.summary.outerHeight();
                        dynamic.summary.css('height', 0);

                        dynamic.summary.animate({'height': heightSummary}, 500, function () {
                            dynamic.summary.css('top', {
                                'height': '',
                                'display': ''
                            });
                        });
                    }

                    dynamic.attr('data-recalculation', 'true');
                    dynamic.summary.activated = true;
                }
            }
        };

        dynamic.update();

        (function () {
            var update = false;

            dynamic.quantity.on('change', function () {
                if (!update) {
                    update = true;
                    dynamic.update();
                    update = false;
                }
            });
        })();

        <?php if ($arResult['DELIVERY_CALCULATION']['USE']) { ?>
        dynamic.deliveryCalculation = $('[data-role="deliveryCalculation"]', dynamic);
        dynamic.deliveryCalculation.on('click', function () {
            var template = <?= JavaScript::toObject($arResult['DELIVERY_CALCULATION']['TEMPLATE']) ?>;
            var parameters = <?= JavaScript::toObject($arResult['DELIVERY_CALCULATION']['PARAMETERS']) ?>;

            if (_.isNil(parameters))
                parameters = {};

            parameters['PRODUCT_ID'] = entity.id;
            parameters['PRODUCT_QUANTITY_VALUE'] = dynamic.quantity.get();
            parameters['PRODUCT_QUANTITY_MIN'] = entity.quantity.ratio;
            parameters['PRODUCT_QUANTITY_MAX'] = entity.quantity.trace && !entity.quantity.zero ? entity.quantity.value : false;
            parameters['PRODUCT_QUANTITY_STEP'] = entity.quantity.ratio;

            app.api.components.show({
                'component': 'intec.universe:catalog.delivery',
                'template': template,
                'parameters': parameters,
                'settings': {
                    'parameters': {
                        'width': null
                    }
                }
            });
        });
        <?php } ?>

        <?php if ($arResult['ORDER_FAST']['USE']) { ?>
        dynamic.orderFast = $('[data-role="orderFast"]', dynamic);
        dynamic.orderFast.on('click', function () {
            var template = <?= JavaScript::toObject($arResult['ORDER_FAST']['TEMPLATE']) ?>;
            var parameters = <?= JavaScript::toObject($arResult['ORDER_FAST']['PARAMETERS']) ?>;

            if (_.isNil(parameters))
                parameters = {};

            parameters['PRODUCT'] = entity.id;
            parameters['QUANTITY'] = dynamic.quantity.get();

            app.api.components.show({
                'component': 'intec.universe:sale.order.fast',
                'template': template,
                'parameters': parameters,
                'settings': {
                    'parameters': {
                        'width': null
                    }
                }
            });
        });
        <?php } ?>

        <?php if ($arVisual['PANEL']['DESKTOP']['SHOW']) { ?>
        if (root.panel.length) (function () {
            var state = false;
            var area = $(window);
            var update;
            var panel = root.panel;
            var sticky = {
                'top': $('[data-sticky="top"]', root),
                'nulled': $('[data-sticky="nulled"]', root)
            };

            panel.css('top', -panel.outerHeight());

            update = function () {
                var bound = 0;

                if (root.is(':visible'))
                    bound += root.offset().top;

                if (area.width() <= 768) {
                    sticky.top.css('top', '');
                    sticky.nulled.css('top', '');
                }

                if (area.scrollTop() > bound)
                    panel.show();
                else
                    panel.hide();
            };

            panel.show = function () {
                if (state) return;

                state = true;

                panel.css('display', 'block')
                    .trigger('show')
                    .stop()
                    .animate({'top': 0}, 500);

                if (area.width() > 768) {
                    if (sticky.top.length)
                        sticky.top.animate({'top': panel.outerHeight() + 16}, 500);

                    if (sticky.nulled.length)
                        sticky.nulled.animate({'top': panel.outerHeight() - 1}, 500);
                }
            };

            panel.hide = function () {
                if (!state) return;

                state = false;

                panel.stop().animate({
                    'top': -panel.height()
                }, 500, function () {
                    panel.trigger('hide');
                    panel.css('display', 'none');
                });

                if (area.width() > 768) {
                    if (sticky.top.length) {
                        sticky.top.animate({
                            'top': 16
                        }, 500, function () {
                            sticky.top.css('top', '');
                        });
                    }

                    if (sticky.nulled.length) {
                        sticky.nulled.animate({
                            'top': -1
                        }, 500, function () {
                            sticky.nulled.css('top', '');
                        });
                    }
                }
            };

            update();

            area.on('scroll', update)
                .on('resize', update);
        })();
        <?php } ?>

        <?php if ($arVisual['PANEL']['MOBILE']['SHOW']) { ?>
        if (dynamic.panelMobile.length === 1 && dynamic.purchase.length === 1) (function () {
            var state = false;
            var area = $(window);
            var update;
            var panel;

            update = function () {
                var bound = dynamic.purchase.offset().top;

                if (area.scrollTop() > bound) {
                    panel.show();
                } else {
                    panel.hide();
                }
            };

            panel = dynamic.panelMobile;
            panel.css({
                'bottom': -panel.outerHeight()
            });

            panel.show = function () {
                if (state) return;

                state = true;
                panel.css({
                    'display': 'block'
                });

                panel.trigger('show');
                panel.stop().animate({
                    'bottom': 0
                }, 500)
            };

            panel.hide = function () {
                if (!state) return;

                state = false;
                panel.stop().animate({
                    'bottom': -panel.outerHeight()
                }, 500, function () {
                    panel.trigger('hide');
                    panel.css({
                        'display': 'none'
                    })
                })
            };

            update();

            area.on('scroll', update)
                .on('resize', update);
        })();
        <?php } ?>
        <?php } ?>

        <?php if ($bSkuDynamic) { ?>
        if (!dynamic.offers.isEmpty()) {
            dynamic.properties = $('[data-role="property"]', dynamic);
            dynamic.properties.values = $('[data-role="property.value"]', dynamic.properties);
            dynamic.properties.each(function () {
                var self = $(this);
                var property = self.data('property');
                var values = self.find(dynamic.properties.values);

                values.each(function () {
                    var self = $(this);
                    var value = self.data('value');

                    self.on('click', function () {
                        dynamic.offers.setCurrentByValue(property, value);
                    });
                });
            });

            dynamic.offers.on('change', function (event, offer, values) {
                entity = offer;

                _.each(values, function (values, state) {
                    _.each(values, function (values, property) {
                        property = dynamic.properties.filter('[data-property="' + property + '"]');

                        var selected = $('[data-role="property.selected"]', property);

                        _.each(values, function (value) {
                            value = property.find(dynamic.properties.values).filter('[data-value="' + value + '"]');
                            value.attr('data-state', state);

                            var valueContent = $('[data-role="property.value.content"]', value);
                            var valueContentType = valueContent.attr('data-content-type');

                            if (state === 'selected') {
                                selected.html(valueContent.attr('title'));

                                if (valueContentType === 'text') {
                                    valueContent.removeClass('intec-cl-border-hover intec-cl-background-hover')
                                        .addClass('intec-cl-background intec-cl-border intec-cl-background-light-hover intec-cl-border-light-hover');
                                } else if (valueContentType === 'picture') {
                                    valueContent.removeClass('intec-cl-border-hover')
                                        .addClass('intec-cl-border intec-cl-border-light-hover');
                                }
                            } else {
                                if (valueContentType === 'text') {
                                    valueContent.addClass('intec-cl-border-hover intec-cl-background-hover')
                                        .removeClass('intec-cl-background intec-cl-border intec-cl-background-light-hover intec-cl-border-light-hover');
                                } else if (valueContentType === 'picture') {
                                    valueContent.removeClass('intec-cl-border intec-cl-border-light-hover')
                                        .addClass('intec-cl-border-hover');
                                }
                            }
                        });
                    });
                });

                dynamic.update();
            });

            var offerCurrent;

            _.each(dynamic.offers.getList(), function (offer) {
                if (!offerCurrent || offerCurrent.sort > offer.sort)
                    offerCurrent = offer;
            });

            dynamic.offers.setCurrentById(offerCurrent.id);
        }
        <?php } ?>

        <?php if ($arVisual['MEASURES']['USE']) { ?>
        dynamic.measures.create();
        <?php } ?>

        <?php if ($bSkuList) { ?>
        dynamic.offers = $('[data-role="offers"]', root);
        dynamic.offers.list = $('[data-role="offer"]', dynamic.offers);

        dynamic.offers.list.each(function () {
            var offer = $(this);
            var dataOffer = offer.data('offer-data');

            offer.counter = $('[data-role="counter"]', offer);
            offer.quantity = app.ui.createControl('numeric', {
                'node': offer.counter,
                'bounds': {
                    'minimum': dataOffer.quantity.ratio,
                    'maximum': dataOffer.quantity.trace && !dataOffer.quantity.zero ? dataOffer.quantity.value : false
                },
                'step': dataOffer.quantity.ratio
            });
            offer.price = $('[data-role="price"]', offer);
            offer.price.base = $('[data-role="price.base"]', offer.price);
            offer.price.discount = $('[data-role="price.discount"]', offer.price);
            offer.price.difference = $('[data-role="price.difference"]', offer.price);

            offer.update = function () {
                var price = null;

                _.each(dataOffer.prices, function (object) {
                    if (object.quantity.from === null || offer.quantity.get() >= object.quantity.from)
                        price = object;
                });

                if (price !== null) {
                    <?php if ($bBase && $arVisual['PRICE']['RECALCULATION']) { ?>
                    if (price.quantity.from === null && price.quantity.to === null) {
                        var summary = [];

                        summary.base = price.base.value * offer.quantity.get();
                        summary.discount = price.discount.value * offer.quantity.get();
                        BX.Currency.setCurrencyFormat(price.currency.CURRENCY, price.currency);
                        price.base.display = BX.Currency.currencyFormat(summary.base, price.currency.CURRENCY, true);
                        price.discount.display = BX.Currency.currencyFormat(summary.discount, price.currency.CURRENCY, true);
                    }
                    <?php } ?>

                    offer.price.attr('data-discount', price.discount.use ? 'true' : 'false');
                    offer.price.base.html(price.base.display);
                    offer.price.discount.html(price.discount.display);
                    offer.price.difference.html(price.discount.difference);
                } else {
                    offer.price.attr('data-discount', 'false');
                    offer.price.base.html(null);
                    offer.price.discount.html(null);
                    offer.price.difference.html(null);
                }

                offer.find('[data-basket-id]')
                    .data('basketQuantity', offer.quantity.get())
                    .attr('data-basket-quantity', offer.quantity.get());
            };

            offer.quantity.on('change', function () {
                offer.update();
            });

            <?php if ($arResult['ORDER_FAST']['USE']) { ?>
            offer.orderFast = $('[data-role="orderFast"]', offer);

            offer.orderFast.on('click', function () {
                var template = <?= JavaScript::toObject($arResult['ORDER_FAST']['TEMPLATE']) ?>;
                var parameters = <?= JavaScript::toObject($arResult['ORDER_FAST']['PARAMETERS']) ?>;

                if (_.isNil(parameters))
                    parameters = {};

                parameters['PRODUCT'] = dataOffer.id;
                parameters['QUANTITY'] = offer.quantity.get();

                app.api.components.show({
                    'component': 'intec.universe:sale.order.fast',
                    'template': template,
                    'parameters': parameters,
                    'settings': {
                        'parameters': {
                            'width': null
                        }
                    }
                });
            });
            <?php } ?>

            <?php if ($arResult['DELIVERY_CALCULATION']['USE']) { ?>
            offer.deliveryCalculation = $('[data-role="deliveryCalculation"]', offer);
            offer.deliveryCalculation.on('click', function () {
                var template = <?= JavaScript::toObject($arResult['DELIVERY_CALCULATION']['TEMPLATE']) ?>;
                var parameters = <?= JavaScript::toObject($arResult['DELIVERY_CALCULATION']['PARAMETERS']) ?>;

                if (_.isNil(parameters))
                    parameters = {};

                parameters['PRODUCT_ID'] = dataOffer.id;
                parameters['PRODUCT_QUANTITY_VALUE'] = offer.quantity.get();
                parameters['PRODUCT_QUANTITY_MIN'] = dataOffer.quantity.ratio;
                parameters['PRODUCT_QUANTITY_MAX'] = dataOffer.quantity.trace && !dataOffer.quantity.zero ? dataOffer.quantity.value : false;
                parameters['PRODUCT_QUANTITY_STEP'] = dataOffer.quantity.ratio;

                app.api.components.show({
                    'component': 'intec.universe:catalog.delivery',
                    'template': template,
                    'parameters': parameters,
                    'settings': {
                        'parameters': {
                            'width': null
                        }
                    }
                });
            });
            <?php } ?>
        });

        dynamic.offers.list.on('mouseenter', function () {
            var self = $(this);

            if (area.width() < 1025)
                self.css('height', '');
            else
                self.css('height', this.getBoundingClientRect().height);

            self.attr('data-expanded', 'true');
        });

        dynamic.offers.list.on('mouseleave', function () {
            var self = $(this);

            self.css('height', '');

            if (area.width() > 1024)
                self.attr('data-expanded', 'false');
            else
                self.attr('data-expanded', 'true');
        });

        var adaptOffersList = function () {
            dynamic.offers.list.css('height', '');

            if (area.width() > 1024)
                dynamic.offers.list.attr('data-expanded', 'false');
            else
                dynamic.offers.list.attr('data-expanded', 'true');
        };

        area.on('ready', adaptOffersList);
        window.addEventListener('resize', adaptOffersList);
        <?php } ?>

        root.gallery.each(function () {
            var gallery = $(this);
            var pictures = $('[data-role="gallery.pictures"]', gallery);
            var preview = $('[data-role="gallery.preview"]', gallery);

            pictures.action = pictures.data('action');
            pictures.zoom = pictures.data('zoom');
            pictures.slider = $('[data-role="gallery.pictures.slider"]', pictures);
            pictures.items = $('[data-role="gallery.pictures.item"]', pictures);

            preview.slider = $('[data-role="gallery.preview.slider"]', preview);
            preview.items = $('[data-role="gallery.preview.slider.item"]', preview);
            preview.navigation = $('[data-role="gallery.preview.navigation"]', preview);

            pictures.slider.owlCarousel({
                'items': 1,
                'nav': false,
                'dots': false
            });

            preview.slider.owlCarousel({
                'items': 3,
                'margin': 8,
                'nav': true,
                'navContainer': preview.navigation,
                'navClass': ['preview-navigation-left', 'preview-navigation-right'],
                'navText': [
                    <?= JavaScript::toObject($arSvg['NAVIGATION']['LEFT']) ?>,
                    <?= JavaScript::toObject($arSvg['NAVIGATION']['RIGHT']) ?>
                ],
                'dots': false
            });

            pictures.slider.on('dragged.owl.carousel', function (event) {
                var index = event.item.index;

                preview.slider.trigger('to.owl.carousel', index);
                preview.items.attr('data-active', 'false');
                preview.items.eq(index).attr('data-active', 'true');
            });

            if (pictures.action === 'popup') {
                pictures.slider.lightGallery({
                    'share': false,
                    'selector': '[data-role="gallery.pictures.item.picture"]'
                });
            }

            if (pictures.zoom) {
                pictures.items.each(function () {
                    var self = $(this);
                    var picture = $('[data-role="gallery.pictures.item.picture"]', self);
                    var source = picture.data('src');

                    picture.zoom({
                        'url': source,
                        'touch': false
                    });
                });
            }

            preview.items.on('click', function () {
                var item = $(this);
                var index = item.closest('.owl-item').index();

                preview.items.attr('data-active', 'false');
                item.attr('data-active', 'true');
                pictures.slider.trigger('to.owl.carousel', index);
            });
        });

        if (root.anchors.length) {
            root.anchors.on('click', function () {
                var self = $(this);
                var target = $('[data-scroll-end="' + self.attr('data-scroll-to') + '"]', root);

                $('html, body').animate({'scrollTop': target.offset().top - 16}, 400);
            });
        }

        if (root.storeSection.length) {
            var tabs = $('[data-role="store.section.tab"]', root.storeSection);
            var content = $('[data-role="store.section.content"]', root.storeSection);

            tabs.on('click', function () {
                var self = $(this);
                var id = self.attr('data-store-section-id')
                var active = self.attr('data-store-section-active') === 'true';

                if (!active) {
                    tabs.attr('data-store-section-active', 'false');
                    self.attr('data-store-section-active', 'true');

                    content.attr('data-store-section-active', 'false');
                    content.filter('[data-store-section-id="' + id + '"]')
                        .attr('data-store-section-active', 'procesing');

                    setTimeout(function () {
                        content.filter('[data-store-section-id="' + id + '"]')
                            .attr('data-store-section-active', 'true');
                    }, 1);
                }
            });
        }

        <?php if ($arVisual['SECTIONS']) { ?>
        if (root.section.length) (function () {
            var tabs = $('[data-role="section.tabs"]', root.section);
            var content = $('[data-role="section.content"]', root.section);
            var offset = root.section.offset().top + tabs.height();

            $('[data-role="scroll"]', tabs).scrollbar();

            tabs.items = $('[data-role="section.tabs.item"]', tabs);
            content.items = $('[data-role="section.content.item"]', content);

            tabs.items.on('click', function () {
                var self = $(this);
                var active = self.attr('data-active') === 'true';
                var id = self.attr('data-id');

                offset = root.section.offset().top + tabs.height();

                if (root.panel.length && area.width() > 768)
                    offset = offset - root.panel.outerHeight();

                if (!active) {
                    tabs.items.filter('[data-active="true"]')
                        .attr('data-active', 'false')
                        .removeClass('intec-cl-background intec-cl-background-light-hover');

                    self.attr('data-active', 'true')
                        .addClass('intec-cl-background intec-cl-background-light-hover');

                    content.items.filter('[data-active="true"]')
                        .attr('data-active', 'false');

                    content.items.filter('[data-id="' + id + '"]')
                        .attr('data-active', 'processing');

                    setTimeout(function () {
                        content.items.filter('[data-id="' + id + '"]')
                            .attr('data-active', 'true');
                    }, 5);
                }

                if (area.scrollTop() > offset)
                    $('html, body').animate({'scrollTop': offset - 40}, 300);
            });
        })();
        <?php } ?>

        <?php if ($arResult['FORM']['ORDER']['SHOW']) { ?>
        dynamic.order = $('[data-role="order"]', dynamic);
        dynamic.order.on('click', function () {
            var options = <?= JavaScript::toObject([
                'id' => $arResult['FORM']['ORDER']['ID'],
                'template' => $arResult['FORM']['ORDER']['TEMPLATE'],
                'parameters' => [
                    'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'-form',
                    'CONSENT_URL' => $arResult['URL']['CONSENT']
                ],
                'settings' => [
                    'title' => Loc::getMessage('C_CATALOG_ELEMENT_DEFAULT_5_TEMPLATE_BUY_BUTTON_ORDER_FORM_TITLE')
                ]
            ]) ?>;

            options.fields = {};

            <?php if (!empty($arResult['FORM']['ORDER']['PROPERTIES']['PRODUCT'])) { ?>
            options.fields[<?= JavaScript::toObject($arResult['FORM']['ORDER']['PROPERTIES']['PRODUCT']) ?>] = dataItem.name;
            <?php } ?>

            app.api.forms.show(options);

            if (window.yandex && window.yandex.metrika) {
                window.yandex.metrika.reachGoal('forms.open');
                window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['FORM']['ORDER']['ID'].'.open') ?>);
            }
        });
        <?php } ?>

        <?php if ($arResult['FORM']['CHEAPER']['SHOW']) { ?>
        dynamic.cheaper = $('[data-role="cheaper"]', dynamic);

        dynamic.cheaper.on('click', function () {
            var options = <?= JavaScript::toObject([
                'id' => $arResult['FORM']['CHEAPER']['ID'],
                'template' => $arResult['FORM']['CHEAPER']['TEMPLATE'],
                'parameters' => [
                    'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'-form',
                    'CONSENT_URL' => $arResult['URL']['CONSENT']
                ],
                'settings' => [
                    'title' => Loc::getMessage('C_CATALOG_ELEMENT_DEFAULT_5_TEMPLATE_CHEAPER_TITLE')
                ]
            ]) ?>;

            options.fields = {};

            <?php if (!empty($arResult['FORM']['CHEAPER']['PROPERTIES']['PRODUCT'])) { ?>
            options.fields[<?= JavaScript::toObject($arResult['FORM']['CHEAPER']['PROPERTIES']['PRODUCT']) ?>] = dataItem.name;
            <?php } ?>

            app.api.forms.show(options);

            if (window.yandex && window.yandex.metrika) {
                window.yandex.metrika.reachGoal('forms.open');
                window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['FORM']['CHEAPER']['ID'].'.open') ?>);
            }
        });
        <?php } ?>

        <?php if ($arVisual['SECTIONS']) { ?>
        $('[data-role="properties.preview.button"]', dynamic).click(function(){
            $('[data-role="section.tabs.item"][data-id="properties"]').trigger('click');
        });
        <?php } else { ?>
        var heightPanel = 0;

        if (root.panel.length !== 0) {
            heightPanel = root.panel.outerHeight();
        }

        $('[data-role="properties.preview.button"]', dynamic).click(function(){
            area.scrollTo($('[data-role="properties.detail"]', dynamic).offset().top - heightPanel, 1000);
        });
        <?php } ?>

        function timerUpdate(id){

            var timerParameters = <?= JavaScript::toObject($arResult['TIMER']['PROPERTIES']) ?>;

            if (!!timerParameters) {
                timerParameters.parameters.ELEMENT_ID = id;

                app.api.components.get(timerParameters).then(function (content) {
                    $('[data-role="timer-holder"]', root).html(content);
                });
            }
        }

        function creditPrice(summary, price) {

            if(_.isNil(price))
                return;

            var status = $('[data-role="credit"]').data('status');
            var priceValue = 0;
            var duration = '<?= !empty($arVisual['CREDIT']['DURATION']) ? $arVisual['CREDIT']['DURATION'] : 10 ?>';

            if (status === 'dynamic' && !!summary && summary.value > 0) {
                priceValue = summary.value;
            } else {
                if (!price.discount) {
                    priceValue = price.base.value;
                } else {
                    priceValue = price.discount.value;
                }
            }

            var currency = price.currency.CURRENCY;
            priceValue = priceValue / duration;
            priceValue = priceValue.toFixed(1);
            var priceDisplay = BX.Currency.currencyFormat(priceValue, currency, true);

            $('[data-role="price.credit"]').html(priceDisplay);
        }
    }, {
        'name': '[Component] bitrix:catalog.element (catalog.default.5)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>