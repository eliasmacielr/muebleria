'use strict';

// Register `productEdit` component, along with its associated controller
// and template
angular.
  module('productEdit').
  component('productEdit', {
    templateUrl: 'app/product/edit/product-edit.template.html',
    controller: ['$routeParams', '$scope', '$q', '$location', '$mdSidenav', '$mdDialog', '$mdToast', 'Product', 'Category', 'Image', 'Specification',
      function ProductEditController($routeParams, $scope, $q, $location, $mdSidenav, $mdDialog, $mdToast, Product, Category, Image, Specification) {

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
        self.productNewSpecifications = []; // for new specifications

        self.addImage = function () {
          var image = document.getElementById('file-upload');

          if (image.files[0] == null) {
            self.messageToast('Por favor cargue una imagen');
            return;
          }

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

        $scope.addSpecificationDialog = function (ev) {
          $mdDialog.show({
            controller: AddSpecificationController,
            templateUrl: 'app/product/edit/specification-add.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function (answer) { // hide
            // self.messageToast(answer);
          }, function () { // cancel
            //self.messageToast('No se agregó especificación nueva');
          });
        };

        function AddSpecificationController($scope, $mdDialog) {
          $scope.specification = {};

          $scope.addSpecification = function () {
            $scope.specification.product_id = self.productId;
            self.productNewSpecifications.push($scope.specification);
            $scope.hide();
          };

          $scope.hide = function () {
            $mdDialog.hide();
          };

          $scope.cancel = function () {
            $mdDialog.cancel();
          };

          $scope.answer = function (answer) {
            $mdDialog.hide(answer);
          };
        };

        self.deleteSpecification = function (productSpecification) {
          Specification.delete({productId: self.productId, specificationId: productSpecification.id}).$promise.then(
            function (response) {
              if (response.status) {
                var index = self.productSpecifications.indexOf(productSpecification);
                self.productSpecifications.splice(index, 1);
              }
            }
          );
        };

        self.deleteNewSpecification = function (productNewSpecification) {
          var index = self.productNewSpecifications.indexOf(productNewSpecification);
          self.productNewSpecifications.splice(index, 1);
        };

        self.editProduct = function () {
          var promises = [];

          promises.push(Product.edit({productId: self.productId}, self.product));

          if (self.mainImageId) {
            promises.push(
              Image.markAsMain(
                {productId: self.productId, action: 'mark-main', imageId: self.mainImageId},
                self.product)
            );
          }

          // edit and add specifications
          for(var i = 0; i < self.productSpecifications.length; i++) {
            promises.push(
              Specification.edit(
                {productId: self.productId, specificationId: self.productSpecifications[i].id},
                self.productSpecifications[i])
            );
          }
          for(var i = 0; i < self.productNewSpecifications.length; i++) {
            promises.push(
              Specification.add(
                {productId: self.productId},
                self.productNewSpecifications[i])
            );
          }

          $q.all(promises).then(
            function (response) {
              self.messageToast('El producto se editó con éxito');
            },
            function (reason) {
              self.messageToast('Ocurrió un error');
            }
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
