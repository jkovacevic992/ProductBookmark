define(['jquery'], function($) {
   'use strict';

   return function (config, element) {
       console.log(element);
       $.get('/bookmark/block', function (result) {
           element.innerHTML = result;
       });
   }
});