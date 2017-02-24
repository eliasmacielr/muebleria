publicAppCtrls.controller('productDetails',
  ['$routeParams', '$scope', '$location', 'Product', 'Image', 'Specification',
  function ($routeParams, $scope, $location, Product, Image, Specification) {

    $scope.productSlug = $routeParams.productSlug;

    console.log($scope.productImages);

    Product.view({productId: $scope.productSlug}).$promise.then(
      function (response) {
        if (response.status) {
          $scope.product = response.product;
        }
      }
    );
    Image.view({productId: $scope.productSlug}).$promise.then(
      function (response) {
        if (response.status) {
          if (response.productImages[0]) {
            $scope.selectedImage = response.productImages[0].file_path;
          }
          $scope.productImages = response.productImages;
        }
      }
    );
    Specification.view({productId: $scope.productSlug}).$promise.then(
      function (response) {
        if (response.status) {
          $scope.specifications = response.productSpecifications;
        }
      }
    );

    $scope.discountPrice = function (realPrice, discount) {
      var n = realPrice - (realPrice * (discount/100));
      return $scope.thousandSeparator(n);
    };

    $scope.thousandSeparator = function (n) {
      return n.toLocaleString('de-DE');
    };

    $scope.changeImg = function (image) {
      $scope.selectedImage = image;
    }
  }]
);
