publicAppCtrls.controller('productDetails',
  ['$routeParams', '$scope', '$location', 'Product', 'Image', 'Specification',
  function ($routeParams, $scope, $location, Product, Image, Specification) {

    $scope.productSlug = $routeParams.productSlug;

    Product.view({productId: $scope.productSlug}).$promise.then(
      function (response) {
        if (response.status) {
          $scope.product = response.product;
          Image.view({productId: response.product.id}).$promise.then(
            function (response) {
              if (response.status) {
                $scope.productImages = response.productImages;
              }
            }
          );
          Specification.view({productId: response.product.id}).$promise.then(
            function (response) {
              if (response.status) {
                $scope.specifications = response.productSpecifications;
              }
            }
          );
        }
      }
    );

    $scope.viewProduct = function (productSlug) {
      $location.path('/productos/' + productSlug);
    };

    $scope.discountPrice = function (realPrice, discount) {
      var n = realPrice - (realPrice * (discount/100));
      return $scope.thousandSeparator(n);
    };

    $scope.thousandSeparator = function (n) {
      return n.toLocaleString('de-DE');
    };

  }]
);
