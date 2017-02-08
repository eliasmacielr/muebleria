'use strict';

// Register `navigation` component, along with its associated controller
// and template
angular.
  module('navigation').
  component('navigation', {
    templateUrl: 'app/navigation/navigation.template.html',
    controller: ['$location',
      function SudeNavigationController($location) {

        var self = this;

        self.categories = function () {
          $location.path('/categorias');
        };

        self.products = function () {
          $location.path('/productos');
        };

        self.users = function () {
          $location.path('/usuarios');
        };

        self.setting = function () {
          $location.path('/configuracion');
        };

      }
    ]
  });
