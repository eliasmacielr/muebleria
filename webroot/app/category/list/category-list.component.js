'use strict';

// Register `categoryList` component, along with its associated controller and template
angular.
  module('categoryList').
  component('categoryList', {
    templateUrl: 'app/category/list/category-list.template.html',
    controller: ['$scope', '$mdDialog', '$mdSidenav', '$mdToast', 'Category',
      function CategoryListController($scope, $mdDialog, $mdSidenav, $mdToast, Category) {

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

        // Add
        $scope.categoryAddDialog = function(ev) {
          $mdDialog.show({
            controller: CategoryAddController,
            templateUrl: 'app/category/add/category-add.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function(answer) { // hide
            self.messageToast(answer);
          }, function() { // cancel
          });
        };

        // Edit
        $scope.categoryEditDialog = function(ev, category) {
          self.category = category;
          $mdDialog.show({
            controller: CategoryEditController,
            templateUrl: 'app/category/edit/category-edit.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function(answer) { // hide
            self.messageToast(answer);
          }, function() { // cancel
            self.messageToast('No se ha editado el registro');
          });
        };

        // Delete
        $scope.categoryDeleteDialog = function(ev) {
          var confirm = $mdDialog.confirm()
            .title('Eliminar categorías')
            .textContent('Está seguro de borrar ' + self.selected.length + ' registro(s)?')
            .ariaLabel('Eliminar categorías')
            .targetEvent(ev)
            .ok('Aceptar')
            .cancel('Cancelar');

          $mdDialog.show(confirm).then(function() {
            self.deleteCategories();
          }, function() {
            self.messageToast('No se borraron registros');
          });
        };

        // Controllers
        function CategoryAddController($scope, $mdDialog, Category) {
          $scope.category = {};

          $scope.addCategory = function() {
            Category.add($scope.category,
              function (response) {
                if (response.status) {
                  self.categories.categories.push(response.category);
                  self.categories.pagination.count += 1;
                }
                $scope.answer(response.message);
              }
            );
          };

          $scope.hide = function() {
            $mdDialog.hide();
          };

          $scope.cancel = function() {
            $mdDialog.cancel();
          };

          $scope.answer = function(answer) {
            $mdDialog.hide(answer);
          };
        };

        function CategoryEditController($scope, $mdDialog, Category) {
          $scope.toEdit = Category.view({categoryId: self.category.id});

          var index = self.categories.categories.indexOf(self.category);

          $scope.editCategory = function() {
            Category.edit(
              {categoryId: $scope.toEdit.category.id},
              $scope.toEdit.category,
              function (response) {
                if (response.status) {
                  self.categories.categories[index] = response.category; // replace edited element
                }
                $scope.answer(response.message);
              }
            );
          };

          $scope.hide = function() {
            $mdDialog.hide();
          };

          $scope.cancel = function() {
            $mdDialog.cancel();
          };

          $scope.answer = function(answer) {
            $mdDialog.hide(answer);
          };
        };

        self.deleteCategory = function(categoryId) {
          Category.delete({categoryId: categoryId});
        };

        self.deleteCategories = function() {
          var allDeleted = true;
          for(var i = 0; i < self.selected.length; i++) {
            self.deleteCategory(
              self.selected[i].id,
              function(response) {
                allDeleted *= response.status;
              }
            );
            var index = self.categories.categories.indexOf(self.selected[i]);
            self.categories.categories.splice(index, 1); // delete one element
          }

          self.categories.pagination.count -= self.selected.length; // update count
          self.selected = []; // empty self.selected array

          if (allDeleted) {
            self.messageToast('Se han borrado los registros');
          }
        };

        self.messageToast = function(message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

        // Navigation sidenav
        $scope.showLeftSidenav = function() {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
