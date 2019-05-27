define(['jquery'], function($) {
   'use strict';

   return function (config, element) {
       $.get('/bookmark/block', function (result) {
           element.innerHTML = result;
           var id = document.getElementById('productId');
           if (id != null) {
               id.value = config.productId;
           }

       });
   }
});