'use strict';

angular.
  module('clickmueblesAdminApp').
  config(['$mdThemingProvider',
    function config($mdThemingProvider) {
      $mdThemingProvider.theme('default')
      .primaryPalette('red', {
        'default': '900'
      })
      .accentPalette('deep-orange');
    }
  ]);
