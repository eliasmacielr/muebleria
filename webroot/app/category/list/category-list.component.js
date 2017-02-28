'use strict';

// Register `categoryList` component, along with its associated controller
// and template
angular.
  module('categoryList').
  component('categoryList', {
    templateUrl: 'app/category/list/category-list.template.html',
    controller: ['$scope', '$q','$mdDialog', '$mdSidenav', '$mdToast', 'Category',
      function CategoryListController($scope, $q, $mdDialog, $mdSidenav, $mdToast, Category) {

        var self = this;

        $scope.selected = [];

        $scope.query = {
          limit: 5,
          page: 1,
          sort: 'name',
          name: ''
        };

        var bookmark;

        $scope.filter = {
          options: {
            debounce: 500
          }
        };

        self.showSearch = false;

        $scope.limitOptions = [5, 10, 15];

        // List
        function success(categories) {
          self.categories = categories;
        }

        $scope.getCategories = function () {
          $scope.promise = Category.list($scope.query, success).$promise;
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

        // Add
        $scope.addCategoryDialog = function (ev) {
          $mdDialog.show({
            controller: AddCategoryController,
            templateUrl: 'app/category/add/category-add.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function (answer) {
            self.messageToast(answer);
          }, function () {
            self.messageToast('No se agregaron registros nuevos');
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
          .then(function (answer) {
            self.messageToast(answer);
          }, function () {
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
            Category.add($scope.category).$promise.then(
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
          Category.view({categoryId: self.category.id}).$promise.then(
            function (response) {
              $scope.toEdit = response;
            }
          );

          var index = self.categories.categories.indexOf(self.category);

          $scope.editCategory = function () {
            Category.edit(
              {categoryId: $scope.toEdit.category.id},
              $scope.toEdit.category
            ).$promise.then(
              function (response) {
                if (response.status) {
                  self.categories.categories[index] = response.category;
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

        self.deleteCategories = function () {
          var promises = [];

          for (var i = 0; i < $scope.selected.length; i++) {
            promises.push(
              Category.delete({categoryId: $scope.selected[i].id})
            );
          }

          $q.all(promises).then(
            function (response) {
              self.messageToast('Se han borrado los registros');
            },
            function (reason) {
              self.messageToast('Ocurrió un error');
            }
          );

          $scope.getCategories();
        };

        self.messageToast = function (message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

        $scope.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
