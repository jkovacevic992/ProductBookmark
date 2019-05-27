define(['jquery'], function($) {
   'use strict';

   return function (config, element) {
       var productId = document.getElementById('productId').getAttribute('value');
       $.get('/bookmark/block/index/id/'+ productId, function (result) {
           element.innerHTML = result;
       });
   }
});