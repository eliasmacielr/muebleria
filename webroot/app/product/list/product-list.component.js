'use strict';

// Register `productList` component, along with its associated controller
// and template
angular.
  module('productList').
  component('productList', {
    templateUrl: 'app/product/list/product-list.template.html',
    controller: ['$routeParams', '$route', '$location', '$scope', '$q', '$mdDialog', '$mdSidenav', '$mdToast', 'Product', 'Category', 'Image',
      function ProductListController($routeParams, $route, $location, $scope, $q, $mdDialog, $mdSidenav, $mdToast, Product, Category, Image) {

        var self = this;

        $scope.selected = [];

        $scope.query = {
          limit: 5,
          page: 1,
          sort: 'name',
          search: ''
        };

        var bookmark;

        $scope.search = {
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

        $scope.$watch('query.search', function (newValue, oldValue) {
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

        self.deleteProducts = function () {
          var promises = [];

          for (var i = 0; i < $scope.selected.length; i++) {
            promises.push(
              Product.delete({productId: $scope.selected[i].id})
            );
          }

          $q.all(promises).then(
            function (response) {
              self.messageToast('Se han borrado los registros');
              $route.reload();
            },
            function (reason) {
              self.messageToast('No se pudieron borrar los registros');
            }
          );
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
