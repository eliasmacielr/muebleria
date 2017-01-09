'use strict';

/* location and routing config */
angular.
  module('myApp').
  config(['$locationProvider' ,'$routeProvider',
    function config($locationProvider, $routeProvider) {
      $locationProvider.hashPrefix('!');

      $routeProvider.
        when('/login', {
          template: '<login></login>'
        }).
        when('/clientes', {
          template: '<customer-list></customer-list>'
        }).
        when('/productos', {
          template: '<product-list></product-list>'
        }).
        otherwise('/login');
    }
  ]);

/* theming config */
angular.
  module('myApp').
  config(['$mdThemingProvider',
    function config($mdThemingProvider) {
      $mdThemingProvider.theme('default')
      .primaryPalette('blue-grey')
      .accentPalette('teal');
    }
  ]);
