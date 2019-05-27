define(['jquery'], function($) {
   'use strict';

   return function (config, element) {
       $.get('/bookmark/block/index/id/'+ config.productId, function (result) {
           element.innerHTML = result;
       });
   }
});