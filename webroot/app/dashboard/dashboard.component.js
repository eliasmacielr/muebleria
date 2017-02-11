'use strict';

// Register `dashboard` component, along with its associated controller and template
angular.
  module('dashboard').
  component('dashboard', {
    templateUrl: 'app/dashboard/dashboard.template.html',
    controller: ['$scope', '$mdSidenav', 'Auth',
      function DashboardController($scope, $mdSidenav, Auth) {

        var self = this;

        self.logout = function () {
          Auth.logout();
        };

        $scope.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        }

      }
    ]
  });
