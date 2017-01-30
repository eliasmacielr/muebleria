'use strict';

angular.
  module('myApp').
  config(['$mdThemingProvider',
    function config($mdThemingProvider) {
      $mdThemingProvider.theme('default')
      .primaryPalette('blue-grey')
      .accentPalette('teal');
    }
  ]);
