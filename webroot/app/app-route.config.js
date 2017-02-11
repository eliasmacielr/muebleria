'use strict';

angular.
  module('myApp').
  config(['$locationProvider', '$routeProvider',
    function config($locationProvider, $routeProvider) {
      $locationProvider.hashPrefix('!');

      $routeProvider.
        when('/categorias', {
          template: '<category-list></category-list>'
        }).
        when('/bandeja', {
          template: '<dashboard></dashboard>'
        }).
        when('/login', {
          template: '<login></login>'
        }).
        when('/productos', {
          template: '<product-list></product-list>'
        }).
        when('/productos/agregar', {
          template: '<product-add></product-add>'
        }).
        when('/productos/editar/:productId', {
          template: '<product-edit></product-edit>'
        }).
        when('/configuracion', {
          template: '<setting-list></setting-list>'
        }).
        when('/usuarios', {
          template: '<user-list></user-list>'
        }).
        otherwise('/login');
    }
  ]);
