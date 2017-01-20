'use strict';

// Register `categoryList` component, along with its associated controller and template
angular.
  module('categoryList').
  component('categoryList', {
    templateUrl: 'app/category-list/category-list.template.html',
    controller: ['$scope', 'Category',
      function CategoryListController($scope, Category) {

        var self = this;

        self.categories = Category.list();

        self.selected = [];

        self.query = {
          order: 'name',
          limit: 10,
          page: 1
        };

        self.showSearch = false;

        this.limitOptions = [5, 10, 15];

        // List
        self.getCategories = function() {
          self.selected = [];
          this.categories = Category.list();
        };

        $scope.toggleRight = buildToggler('right');

        function buildToggler(componentId) {
          return function() {
            $mdSidenav(componentId).toggle();
          }
        };

      }
    ]
  });
