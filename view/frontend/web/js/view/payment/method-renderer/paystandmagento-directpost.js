define(
    [
        'require',
        'jquery',
        'Magento_Payment/js/view/payment/iframe',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/action/set-payment-information',
        'Magento_Checkout/js/model/full-screen-loader',
        'paystand-checkout'
    ],
    function (require, $, Component, quote, setPaymentInformationAction, fullScreenLoader, paystandCheckout) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'PayStand_PayStandMagento/payment/paystandmagento-directpost'
            },
            placeOrderHandler: null,

            setPlaceOrderHandler: function(handler) {
                this.placeOrderHandler = handler;
            },

            context: function() {
                return this;
            },

            isShowLegend: function() {
                return true;
            },

            getCode: function() {
                return 'paystandmagento_directpost';
            },

            isActive: function() {
                return true;
            }
        });
    }
);
