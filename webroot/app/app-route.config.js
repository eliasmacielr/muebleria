'use strict';

angular.
  module('myApp').
  config(['$locationProvider', '$routeProvider',
    function config($locationProvider, $routeProvider) {
      $locationProvider.hashPrefix('!');

      if (!location.origin)
        location.origin = location.protocol + '//' + location.host;

      $routeProvider.
        when('/categorias', {
          template: '<category-list></category-list>'
        }).
        when('/login', {
          template: '<login></login>'
        }).
        when('/productos', {
          template: '<product-list></product-list>'
        }).
        when('/productos/editar/:productId', {
          template: '<product-edit></product-edit>'
        }).
        otherwise('/login');
    }
  ]);
