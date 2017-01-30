'use strict';

// Register `productEdit` component, along with its associated controller
// and template
angular.
  module('productEdit').
  component('productEdit', {
    templateUrl: 'app/product/edit/product-edit.template.html',
    controller: ['$routeParams', '$location', '$scope', '$mdSidenav', '$mdToast', 'Product', 'Category', 'Image', 'Specification',
      function ProductEditController($routeParams, $location, $scope, $mdSidenav, $mdToast, Product, Category, Image, Specification) {

        var self = this;

        self.productId = $routeParams.productId;

        self.product = Product.view({productId: self.productId});
        self.categories = Category.list();
        self.imagesUrls = Image.view({productId: self.productId});
        self.specifications = Specification.view({productId: self.productId});

        $scope.productImages = [];

        self.editProduct = function() {
          var success = true;
          Product.edit(
            {productId: self.productId},
            self.product,
            function(response) {
              success *= response.status;
            }
          );
          // for each specification
          // Specification.edit();
        };

        $scope.addImage = function () {
          var image = document.getElementById('file-upload');
          var fd = new FormData();
          fd.append('file_name', image.files[0], image.files[0].name);

          Image.add({productId: self.productId}, fd).$promise.then(function (result) {
            image.value = "";
            //$scope.productImages.push(result.productImage);
            self.imagesUrls.productImages.push(result.productImage);
            if (self.imagesUrls.productImages.length == 1) { // mark the first one
              self.mainImageId = self.imagesUrls.productImages[0].id;
            }
          });
        };

        $scope.deleteImage = function (prodImg) {
          Image.delete({productId: prodImg.product_id, imageId: prodImg.id},
            function(response) {
              console.log(response);
            }
          );
          var index = self.imagesUrls.productImages.indexOf(prodImg);
          self.imagesUrls.productImages.splice(index, 1); // delete one element
          // if there's only one left, mark that image
          if (self.imagesUrls.productImages.length == 1) { // mark the first one
            self.mainImageId = self.imagesUrls.productImages[0].id;
          }
        };

        $scope.cancel = function() {
          $location.path('/productos');
        };

        self.messageToast = function(message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

        self.showLeftSidenav = function() {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
