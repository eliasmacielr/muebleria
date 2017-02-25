'use strict';

// Register `dashboard` component, along with its associated controller and template
angular.
  module('dashboard').
  component('dashboard', {
    templateUrl: 'app/dashboard/dashboard.template.html',
    controller: ['$http', '$location', '$scope', '$mdSidenav', 'Product',
      function DashboardController($http, $location, $scope, $mdSidenav, Product) {

        var self = this;

        // TOTAL
        Product.list().$promise.then(
          function (response) {
            if (response.status) {
              self.totalProducts = response.pagination.count;
            }
          }
        );
        // Available
        Product.list({available: 1}).$promise.then(
          function (response) {
            if (response.status) {
              self.availableProducts = response.pagination.count;
            }
          }
        );
        // In offer
        Product.list({available: 1, in_offer: 1}).$promise.then(
          function (response) {
            if (response.status) {
              self.inOfferProducts = response.pagination.count;
            }
          }
        );

        $scope.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
