'use strict';

// Register `productEdit` component, along with its associated controller
// and template
angular.
  module('productAdd').
  component('productAdd', {
    templateUrl: 'app/product/add/product-add.template.html',
    controller: ['$routeParams', '$location', '$mdSidenav', '$mdToast', 'Product', 'Category', 'Image', 'Specification',
      function ProductEditController($routeParams, $location, $mdSidenav, $mdToast, Product, Category, Image, Specification) {

        var self = this;

        self.product = {};
        Category.list().$promise.then(
          function (response) {
            self.categories = response;
          }
        );
        self.images = [];
        self.specifications = [];

        // self.addImage = function () { // fix the bug here
        //   var image = document.getElementById('file-upload');
        //   var protoId = self.images.length + 1; // a fake id before upload
        //   var newImage = {
        //     protoId: protoId,
        //     image: image.files[0],
        //     name: image.files[0].name
        //   };
        //
        //   var reader = new FileReader();
        //   reader.addEventListener("load", function () {
        //     newImage.image = reader.result;
        //   }, false);
        //
        //   if (image.files[0]) {
        //     reader.readAsDataURL(image.files[0]);
        //   }
        //
        //   self.images.push(newImage);
        // };
        //
        // self.deleteImage = function (image) {
        //   var index = self.images.indexOf(image);
        //   self.images.splice(index, 1); // delete the element
        // };

        self.addProduct = function () {
          var success;

          // first, create the product
          Product.add(self.product).$promise.then(
            function (response) {
              success = response.status;
              if (success) {
                self.productId = response.product.id;
                //success *= addImages();
                $location.path('/productos');
              }
              self.messageToast(
                (success ? 'El producto se agregó con éxito' : 'Ocurrió un error')
              );
            }
          );
        };

        // add images
        // function addImages() {
        //   var success = true;
        //   var fd;
        //   for (var i = 0; i < self.images.length; i++) {
        //     fd = new FormData();
        //     fd.append('file_name', self.images[i].image, self.images[i].name);
        //     Image.add({productId: self.productId}, fd).$promise.then(
        //       function (response) {
        //         success *= response.status;
        //         // bugged
        //         // if (i === self.mainImageId) {
        //         //   //self.mainImageId = response.productImage.id;
        //         //   success *= markMain(response.productImage.id);
        //         // }
        //       }
        //     );
        //   }
        //
        //   return success;
        // };

        // function markMain(productImageId) {
        //   Image.markAsMain(
        //     {productId: self.productId, action: 'mark-main', imageId: productImageId},
        //     self.product
        //   ).$promise.then(
        //     function (response) {
        //       return response.status;
        //     }
        //   );
        // };

        self.messageToast = function (message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

        self.cancel = function () {
          $location.path('/productos');
        };

        self.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
