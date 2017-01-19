'use strict';

/* location and routing config */
angular.
  module('myApp').
  config(['$locationProvider', '$routeProvider',
    function config($locationProvider, $routeProvider) {
      $locationProvider.hashPrefix('!');

      if (!location.origin)
        location.origin = location.protocol + '//' + location.host;

      $routeProvider.
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
