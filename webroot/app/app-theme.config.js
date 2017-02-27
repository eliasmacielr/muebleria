'use strict';

angular.
  module('clickmueblesAdminApp').
  config(['$mdThemingProvider',
    function config($mdThemingProvider) {
      $mdThemingProvider.theme('default')
      .primaryPalette('red')
      .accentPalette('deep-orange');
    }
  ]);
