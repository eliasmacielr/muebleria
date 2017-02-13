'use strict';

// Register `productList` component, along with its associated controller
// and template
angular.
  module('productList').
  component('productList', {
    templateUrl: 'app/product/list/product-list.template.html',
    controller: ['$routeParams', '$location', '$scope', '$mdDialog', '$mdSidenav', '$mdToast', 'Product', 'Category', 'Image',
      function ProductListController($routeParams, $location, $scope, $mdDialog, $mdSidenav, $mdToast, Product, Category, Image) {

        var self = this;

        $scope.selected = []; // list of selected products in the table

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
        function success(products) {
          $scope.products = products;
        }

        $scope.getProducts = function () {
          $scope.promise = Product.list($scope.query, success).$promise;
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

          $scope.getProducts();
        });

        // View
        self.viewProduct = function (product) {
          self.product = product;
          Category.view({categoryId: product.category_id}).$promise.then(
            function (response) {
              self.product.category = response.category.name;
            }
          );
          $mdSidenav('right').toggle();
        };

        $scope.toggleRight = buildToggler('right');

        function buildToggler(componentId) {
          return function () {
            $mdSidenav(componentId).toggle();
          }
        };

        // Add
        self.addProduct = function () {
          $location.path('/productos/agregar');
        };

        // Edit
        self.editProduct = function (productId) {
          $location.path('/productos/editar/' + productId);
        };

        // Delete
        $scope.deleteProductDialog = function (ev) {
          var confirm = $mdDialog.confirm()
            .title('Eliminar productos')
            .textContent('Está seguro de borrar ' + $scope.selected.length + ' registro(s)?')
            .ariaLabel('Eliminar productos')
            .targetEvent(ev)
            .ok('Aceptar')
            .cancel('Cancelar');

          $mdDialog.show(confirm).then(function () {
            self.deleteProducts();
          }, function () {
            self.messageToast('No se borraron registros');
          });
        };

        self.deleteProduct = function (productId) {
          Product.delete({productId: productId});
        };

        self.deleteProducts = function() {
          var allDeleted = true;
          for(var i = 0; i < $scope.selected.length; i++) {
            self.deleteProduct(
              $scope.selected[i].id,
              function (response) {
                allDeleted *= response.status;
              }
            );
            var index = $scope.products.products.indexOf($scope.selected[i]);
            $scope.products.products.splice(index, 1); // delete one element
          }

          // TODO: fix this bug, execute all this when the deletion is done
          $scope.products.pagination.count -= $scope.selected.length; // update count
          $scope.selected = []; // empty self.selected array

          if (allDeleted) {
            self.messageToast('Se han borrado los registros');
          }
        };

        // Show toast
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
