'use strict';

// Register `customerList` component, along with its associated controller
// and template
angular.
  module('productList').
  component('productList', {
    templateUrl: 'app/product-list/product-list.template.html',
    controller: ['$routeParams', '$location', 'Product', 'Category',
      function CustomerListController($routeParams, $location, Product, Category) {

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
        }

        // View
        // this.viewProduct = function() {
        //   this.product = Product.view({productId: $routeParams.productId});
        // }

        // Add
        // this.addProduct = function() {
        //   Product.add(this.product);
        // }

        // Edit
        // this.editProduct = function(editedProduct) {
        //   Product.edit(editedProduct);
        // }

        // Delete
        self.deleteProduct = function(productId) {
          Product.delete({productId: productId}); // TODO: add callback function
        }

        self.deleteProducts = function() {
          for(i = 0; i < self.selected.length; i++)
            self.deleteProduct(selected[i].id);
            // TODO: make something like
            // bool = true;
            // for(...) bool *= self.deleteProductCallbackResult;
            // mdToast(bool);
        }

        self.selectProduct = function(product) {
          self.selected.push(product);
        }

        this.limitOptions = [5, 10, 15];

      }
    ]
  });
