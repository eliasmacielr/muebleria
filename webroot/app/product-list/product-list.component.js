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
            // $scope.status = 'You said the information was "' + answer + '".';
            //self.messageToast(answer);
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
        self.deleteProduct = function(productId) {
          Product.delete({productId: productId}); // TODO: add callback function
        };

        self.deleteProducts = function() {
          for(i = 0; i < self.selected.length; i++)
            self.deleteProduct(selected[i].id);
            // TODO: make something like
            // bool = true;
            // for(...) bool *= self.deleteProductCallbackResult;
            // mdToast(bool);
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
            /* name
               price
               stock
               main_image */
               in_offert: false,
               discount: 0
            /* category_id */
          };

          $scope.saveProduct = function() {
            Product.add($scope.product);
            $scope.answer(''/*response.message*/);
            // if status is true then push new object in self.products
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
          // var pinTo = '';

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
