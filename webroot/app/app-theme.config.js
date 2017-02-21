'use strict';

angular.
  module('clickmueblesAdminApp').
  config(['$mdThemingProvider',
    function config($mdThemingProvider) {
      $mdThemingProvider.theme('default')
      .primaryPalette('blue-grey')
      .accentPalette('teal');
    }
  ]);
