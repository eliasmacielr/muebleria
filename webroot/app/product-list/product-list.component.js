'use strict';

// Register `customerList` component, along with its associated controller
// and template
angular.
  module('productList').
  component('productList', {
    templateUrl: 'product-list/product-list.template.html',
    controller: ['$routeParams', '$location', 'Product',
      function CustomerListController($routeParams, $location, Product) {

        this.query = {
          order: 'name',
          limit: 5,
          page: 1
        };

        this.selected = []; // list of selected customers in the table

        this.product = null;

        // List
        this.products = Product.list(); //

        // View
        this.viewProduct = function() {
          this.product = Product.view({productId: $routeParams.productId});
        }

        // Add
        this.addProduct = function() {
          Product.add(this.product);
        }

        // Edit
        this.editProduct = function(editedProduct) {
          Product.edit(editedProduct);
        }

        // Delete
        this.deleteProduct = function() {
          Product.delete({productId: $routeParams.productId});
        }

      }
    ]
  });
