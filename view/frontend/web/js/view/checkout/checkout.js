var checkoutjs_module = 'paystand';
var use_sandbox = window.checkoutConfig.payment.paystandmagento.use_sandbox;
if(use_sandbox){
  checkoutjs_module = 'paystand-sandbox';
}

/*jshint browser:true jquery:true*/
define([
  'require',
  'jquery',
  'Magento_Payment/js/view/payment/iframe',
  'Magento_Checkout/js/model/quote',
  'Magento_Checkout/js/model/error-processor',
  checkoutjs_module
], function (require, $, Component, quote, errorProcessor, paystand) {
'use strict';

  /**
   * Load the Paystand checkout
   */
  var loadPaystandCheckout = function(){

    var core_domain = 'paystand.com';

    var use_sandbox = window.checkoutConfig.payment.paystandmagento.use_sandbox;
    if(use_sandbox){
      core_domain = 'paystand.co';
    }

    var publishable_key = window.checkoutConfig.payment.paystandmagento.publishable_key;
    console.log("publishable key = "+publishable_key);

    //var price = window.checkoutConfig.totalsData.base_grand_total.replace(/[^0-9\.]+/g,"");
    var price = $(".grand.totals .price").html().replace(/[^0-9\.]+/g,"");
    var quoteId = quote.getQuoteId();

    PayStandCheckout.checkoutComplete = function (data) {
      console.log("custom checkout complete:", data);
      $(".submit-trigger").click();
    };
    PayStandCheckout.checkoutFailed = function (data) {
      console.log("custom checkout failed:", data);
    };
    PayStandCheckout.init({
      "publishableKey": publishable_key,
      "checkout_domain": "https://checkout."+core_domain+"/v2/",
      "domain": "https://api."+core_domain,
      "template": "default",
      "theme": "default",
      "total": price,
      "currency": "USD",
      "features": {
        "cards": true,
        "echeck": {
          "enabled": true
        }
      },
      "ui": {
        "billing": {
          "show": true
        }
      },
      "meta": {
        "source":"magento 2",
        "quote": quoteId
      }
    },null,400);

    // stop observing for mutation events
    window.observer.disconnect();
  };

  // select the target node
  var target = $('.payment-method').parent().get( 0 );

// create an observer instance
  window.observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      console.log(mutation.type);
      for (var i = 0; i < mutation.addedNodes.length; ++i) {
        var item = mutation.addedNodes[i];
        if (typeof item.getElementsByClassName === "function") {
          if(item.getElementsByClassName('paystand-checkout-form').length > 0){
            loadPaystandCheckout();
          }
        }
      }
    });
  });

// configuration of the observer:
  var config = { attributes: true, childList: true, characterData: true }

// pass in the target node, as well as the observer options
  observer.observe(target, config);

  return this;
});