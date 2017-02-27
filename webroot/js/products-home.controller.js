publicAppCtrls.controller('productsHome',
  ['$scope', '$location', 'Product',
  function ($scope, $location, Product) {

    $scope.query = {
      in_offer: 1,
      available: 1
    };

    var bookmark;

    $scope.filter = {
      options: {
        debounce: 500
      }
    };

    Product.list($scope.query).$promise.then(
      function (response) {
        if (response.status) {
          $scope.productsInOffer = response.products;
        }
      }
    );

    $scope.$watch('query.search', function (newValue, oldValue) {
      if(!oldValue) {
        bookmark = $scope.query.page;
      }

      if(newValue !== oldValue) {
        $scope.query.page = 1;
      }

      if(!newValue) {
        $scope.query.page = bookmark;
      }

      Product.list($scope.query).$promise.then(
        function (response) {
          if (response.status) {
            $scope.productsInOffer = response.products;
          }
        }
      );
    });

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
