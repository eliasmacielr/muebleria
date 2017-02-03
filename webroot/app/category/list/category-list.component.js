'use strict';

// Register `categoryList` component, along with its associated controller and template
angular.
  module('categoryList').
  component('categoryList', {
    templateUrl: 'app/category/list/category-list.template.html',
    controller: ['$scope', '$mdDialog', '$mdSidenav', '$mdToast', 'Category',
      function CategoryListController($scope, $mdDialog, $mdSidenav, $mdToast, Category) {

        var self = this;

        /* -------------------- */
        $scope.selected = []; // list of selected categories in the table

        $scope.query = {
          //order = 'name',
          limit: 5,
          page: 1,
          sort: 'name'
        };

        $scope.limitOptions = [5, 10, 15];

        // List
        // self.categories = Category.list($scope.query, success).$promise;

        function success(categories) {
          self.categories = categories;
        }

        $scope.getCategories = function () {
          $scope.promise = Category.list($scope.query, success).$promise;
        };

        /* esto agregué */
        var bookmark;

        $scope.filter = {
          options: {
            debounce: 500
          }
        };

        $scope.$watch('query.name', function (newValue, oldValue) {
          if(!oldValue) {
            bookmark = $scope.query.page;
          }

          if(newValue !== oldValue) {
            $scope.query.page = 1;
          }

          if(!newValue) {
            $scope.query.page = bookmark;
          }

          $scope.getCategories();
        });
        /* hasta acá */

        /* -------------------- */
        // var self = this;

        self.showSearch = false;

        // Add
        $scope.addCategoryDialog = function (ev) {
          $mdDialog.show({
            controller: AddCategoryController,
            templateUrl: 'app/category/add/category-add.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function (answer) { // hide
            self.messageToast(answer);
          }, function () { // cancel
          });
        };

        // Edit
        $scope.editCategoryDialog = function (ev, category) {
          self.category = category;
          $mdDialog.show({
            controller: EditCategoryController,
            templateUrl: 'app/category/edit/category-edit.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function (answer) { // hide
            self.messageToast(answer);
          }, function () { // cancel
            self.messageToast('No se ha editado el registro');
          });
        };

        // Delete
        $scope.deleteCategoryDialog = function (ev) {
          var confirm = $mdDialog.confirm()
            .title('Eliminar categorías')
            .textContent('Está seguro de borrar ' + $scope.selected.length + ' registro(s)?')
            .ariaLabel('Eliminar categorías')
            .targetEvent(ev)
            .ok('Aceptar')
            .cancel('Cancelar');

          $mdDialog.show(confirm).then(function () {
            self.deleteCategories();
          }, function () {
            self.messageToast('No se borraron registros');
          });
        };

        // Controllers
        function AddCategoryController($scope, $mdDialog, Category) {
          $scope.category = {};

          $scope.addCategory = function () {
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

          $scope.hide = function () {
            $mdDialog.hide();
          };

          $scope.cancel = function () {
            $mdDialog.cancel();
          };

          $scope.answer = function (answer) {
            $mdDialog.hide(answer);
          };
        };

        function EditCategoryController($scope, $mdDialog, Category) {
          $scope.toEdit = Category.view({categoryId: self.category.id});

          var index = self.categories.categories.indexOf(self.category);

          $scope.editCategory = function () {
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

          $scope.hide = function () {
            $mdDialog.hide();
          };

          $scope.cancel = function () {
            $mdDialog.cancel();
          };

          $scope.answer = function (answer) {
            $mdDialog.hide(answer);
          };
        };

        self.deleteCategory = function (categoryId) {
          Category.delete({categoryId: categoryId});
        };

        self.deleteCategories = function () {
          var allDeleted = true;
          for (var i = 0; i < $scope.selected.length; i++) {
            self.deleteCategory(
              $scope.selected[i].id,
              function(response) {
                allDeleted *= response.status;
              }
            );
            var index = self.categories.categories.indexOf($scope.selected[i]);
            self.categories.categories.splice(index, 1); // delete one element
          }

          self.categories.pagination.count -= $scope.selected.length; // update count
          $scope.selected = []; // empty $scope.selected array

          if (allDeleted) {
            self.messageToast('Se han borrado los registros');
          }
        };

        self.messageToast = function (message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

        // Navigation sidenav
        $scope.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
