'use strict';

// Register `navigation` component, along with its associated controller
// and template
angular.
  module('navigation').
  component('navigation', {
    templateUrl: 'app/navigation/navigation.template.html',
    controller: ['$location', 'Auth',
      function SudeNavigationController($location, Auth) {

        var self = this;

        self.username = Auth.$storage.user.username;

        self.dashboard = function () {
          $location.path('/bandeja');
        };

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

        self.openMenu = function ($mdMenu, ev) {
          $mdMenu.open(ev);
        };

        self.logout = function () {
          Auth.logout();
          $location.path('/login');
        };

      }
    ]
  });
