publicAppCtrls.controller('products',
  ['$scope', '$location', 'Product',
  function ($scope, $location, Product) {

    Product.list({available: 1}).$promise.then(
      function (response) {
        if (response.status) {
          $scope.products = response.products;
        }
      }
    );

    $scope.listProducts = function (d1, d2) {
      //discounts_range[]=0&discounts_range[]=10
      console.log('The function is being called');
      var discountRange = d1 + ',' + d2;
      Product.list({category_id: $scope.categoryId, available: 1, discount: discountRange}).
        $promise.then(
          function (response) {
            if (response.status) {
              $scope.products = response.products;
            }
          }
        );
    };

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
