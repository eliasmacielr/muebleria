publicAppCtrls.controller('categoryProducts',
  ['$routeParams', '$scope', '$location', 'Product',
  function ($routeParams, $scope, $location, Product) {

    $scope.categoryId = $routeParams.categoryId;

    $scope.query = {
      category_id: $scope.categoryId,
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
          $scope.products = response.products;
        }
      }
    );

    $scope.listProducts = function (d1, d2) {
      var discountRange = d1 + ',' + d2;
      $scope.query.discount = discountRange;
      Product.list($scope.query).
        $promise.then(
          function (response) {
            if (response.status) {
              $scope.products = response.products;
            }
          }
        );
    };

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
            $scope.products = response.products;
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
