'use strict';

// Register `dashboard` component, along with its associated controller and template
angular.
  module('dashboard').
  component('dashboard', {
    templateUrl: 'app/dashboard/dashboard.template.html',
    controller: ['$scope', '$mdSidenav',
      function DashboardController($scope, $mdSidenav) {

        var self = this;

        $scope.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        }

      }
    ]
  });
