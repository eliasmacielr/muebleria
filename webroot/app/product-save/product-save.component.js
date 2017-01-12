'use strict';

// Register `productSave` component, along with its associated controller
// and template
angular.
  module('productSave').
  component('productSave', {
    templateUrl: 'app/product-save/product-save.template.html',
    controller: ['$mdDialog', 'Product', 'Category',
      function ProductSaveController($mdDialog, Product, Category) {

        var self = this;

        self.categories = Category.list();

        self.product = {
          /* name
             price
             stock
             main_image
             in_offert
             category_id
             discount */
        };

        self.saveProduct = function() {
          Product.add(self.product);
        }

      }
    ]
  });
