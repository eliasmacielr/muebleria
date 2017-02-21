publicAppCtrls.controller('categoryProducts',
  ['$routeParams', '$scope', '$location', 'Product',
  function ($routeParams, $scope, $location, Product) {

    $scope.categoryId = $routeParams.categoryId;

    Product.list({category_id: $scope.categoryId}).$promise.then(
      function (response) {
        if (response.status) {
          $scope.products = response.products;
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
