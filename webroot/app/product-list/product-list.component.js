'use strict';

// Register `productList` component, along with its associated controller
// and template
angular.
  module('productList').
  component('productList', {
    templateUrl: 'app/product-list/product-list.template.html',
    controller: ['$routeParams', '$location', '$scope', '$mdDialog', '$mdToast', 'Product', 'Category',
      function ProductListController($routeParams, $location, $scope, $mdDialog, $mdToast, Product, Category) {

        var self = this;

        self.query = {
          order: 'name',
          limit: 10,
          page: 1
        };

        self.selected = []; // list of selected products in the table

        self.products = Product.list();

        // List
        self.getProducts = function() {
          self.selected = [];
          this.products = Product.list();
        };

        // View
        // this.viewProduct = function() {
        //   this.product = Product.view({productId: $routeParams.productId});
        // }

        // Add
        $scope.saveProductDialog = function(ev) {
          $mdDialog.show({
            controller: ProductSaveController,
            templateUrl: 'app/product-save/product-save.template.html',
            parent: angular.element(document.body),
            targetEvent: ev //,
            // clickOutsideToClose: true
          })
          .then(function(answer) {
            self.messageToast(answer);
          }, function() {
            // $scope.status = 'You cancelled the dialog.';
          });
        };

        // Edit
        $scope.editProductDialog = function(ev) {
          $mdDialog.show({
            controller: ProductEditController,
            templateUrl: 'app/product-edit/product-edit.template.html',
            parent: angular.element(document.body),
            targetEvent: ev //,
            // clickOutsideToClose: true
          })
          .then(function(answer) { // hide
            // $scope.status = 'You said the information was "' + answer + '".';
          }, function() {          // cancel
            // $scope.status = 'You cancelled the dialog.';
          });
        };

        // Delete
        $scope.deleteProductDialog = function(ev) {
          var confirm = $mdDialog.confirm()
            .title('Eliminar productos')
            .textContent('Está seguro de borrar ' + self.selected.length + ' registro(s)?')
            .ariaLabel('Eliminar productos')
            .targetEvent(ev)
            .ok('Aceptar')
            .cancel('Cancelar');

          $mdDialog.show(confirm).then(function() {
            self.deleteProducts();
          }, function() {
            self.messageToast('No se borraron registros');
          });
        };

        self.deleteProduct = function(productId) {
          Product.delete({productId: productId}); // TODO: add callback function
        };

        self.deleteProducts = function() {
          var allDeleted = true;
          for(var i = 0; i < self.selected.length; i++) {
            self.deleteProduct(
              self.selected[i].id,
              function(response) {
                allDeleted *= response.status;
              }
            );
            var index = self.products.products.indexOf(self.selected[i]);
            self.products.products.splice(index, 1); // delete one element
          }

          self.selected = [];
          self.products.pagination.count -= self.selected.length;

          if (allDeleted) {
            self.messageToast('Se han borrado los registros');
          }
        };

        self.search = {
            str: ''
        };

        self.showSearch = false;

        this.limitOptions = [5, 10, 15];

        // Controllers
        function ProductSaveController($scope, $mdDialog, Product, Category) {
          $scope.categories = Category.list();

          $scope.product = {
            /* name,
               price,
               stock,
               main_image, */
               in_offer: false,
               discount: 0
            /* category_id */
          };

          $scope.saveProduct = function() {
            Product.add($scope.product,
              function (response) {
                if (response.status) {
                  self.products.products.push(response.product);
                  self.products.pagination.count += 1;
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
        }

        function ProductEditController($scope, $mdDialog, Product, Category) {
          $scope.categories = Category.list();

          $scope.product;

          $scope.cancel = function() {
            $mdDialog.cancel();
          };

          $scope.editProduct = function() {
            Product.edit(
              {productId: $scope.product.id},
              $scope.product
            );
          };
        }

        // show toast
        self.messageToast = function(message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

      }
    ]
  });
