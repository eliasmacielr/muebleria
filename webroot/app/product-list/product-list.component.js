'use strict';

// Register `productList` component, along with its associated controller
// and template
angular.
  module('productList').
  component('productList', {
    templateUrl: 'app/product-list/product-list.template.html',
    controller: ['$routeParams', '$location', '$scope', '$mdDialog', 'Product', 'Category',
      function ProductListController($routeParams, $location, $scope, $mdDialog, Product, Category) {

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
        // this.addProduct = function() {
        //   Product.add(this.product);
        // }

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
          }, function() {
            // $scope.status = 'You cancelled the dialog.';
          });
        };

        // Edit
        // this.editProduct = function(editedProduct) {
        //   Product.edit(editedProduct);
        // }

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

        function ProductSaveController($scope, $mdDialog, Product, Category) {
          //var self = this;

          $scope.categories = Category.list();

          $scope.product = {
            /* name
               price
               stock
               main_image
               in_offert
               category_id
               discount */
          };

          $scope.cancel = function() {
            $mdDialog.cancel();
          };

          $scope.saveProduct = function() {
            Product.add($scope.product);
          };
        }

      }
    ]
  });
