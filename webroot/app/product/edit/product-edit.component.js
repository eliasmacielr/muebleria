'use strict';

// Register `productEdit` component, along with its associated controller
// and template
angular.
  module('productEdit').
  component('productEdit', {
    templateUrl: 'app/product/edit/product-edit.template.html',
    controller: ['$routeParams', '$location', '$mdSidenav', '$mdToast', 'Product', 'Category', 'Image', 'Specification',
      function ProductEditController($routeParams, $location, $mdSidenav, $mdToast, Product, Category, Image, Specification) {

        var self = this;

        self.productId = $routeParams.productId;

        Product.view({productId: self.productId}).$promise.then(
          function (response) {
            if (response.status) {
              self.product = response.product;
            }
          }
        );
        Category.list().$promise.then(
          function (response) {
            if (response.status) {
              self.categories = response.categories;
            }
          }
        );
        Image.view({productId: self.productId}).$promise.then(
          function (response) {
            self.productImages = response.productImages;
            for (var i = 0; i < response.productImages.length; i++) {
              if (response.productImages[i].main) {
                self.mainImageId = response.productImages[i].id;
              }
            }
          }
        );
        self.productSpecifications = [];
        Specification.view({productId: self.productId}).$promise.then(
          function (response) {
            if (response.status) {
              self.productSpecifications = response.productSpecifications;
            }
          }
        );


        self.addImage = function () {
          var image = document.getElementById('file-upload');
          var fd = new FormData();
          fd.append('file_name', image.files[0], image.files[0].name);

          Image.add({productId: self.productId}, fd).$promise.then(
            function (response) {
              image.value = "";
              self.productImages.push(response.productImage);
              if (self.productImages.length == 1) { // mark the first one
                self.mainImageId = self.productImages[0].id;
              }
            }
          );
        };

        self.deleteImage = function (image) {
          if (image.id == self.mainImageId) { self.mainImageId = undefined; }
          Image.delete({productId: image.product_id, imageId: image.id}).$promise.then(
            function (response) {
              var index = self.productImages.indexOf(image);
              self.productImages.splice(index, 1); // delete the element
              if (self.productImages.length == 1) { // mark the first one
                self.mainImageId = self.productImages[0].id;
              }
            }
          );
        };

        self.editProduct = function () {
          var success = true;
          Product.edit(
            {productId: self.productId},
            self.product,
            function (response) {
              success *= response.status;
            }
          );

          if (self.mainImageId) {
            Image.markAsMain(
              {productId: self.productId, action: 'mark-main', imageId: self.mainImageId},
              self.product,
              function (response) {
                success *= response.status;
              }
            );
          }

          // for each specification
          for(var i = 0; i < self.productSpecifications.length; i++) {
            Specification.edit(
              {productId: self.productId,
              specificationId: self.productSpecifications[i].id},
              self.productSpecifications[i],
              function (response) {
                success *= response.status;
              }
            );
          }

          self.messageToast(
            (success ? 'El producto se editó con éxito' : 'Ocurrió un error')
          );
        };

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
