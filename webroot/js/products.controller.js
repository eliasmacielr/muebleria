publicAppCtrls.controller('products',
  ['$scope', '$location', 'Product',
  function ($scope, $location, Product) {

    $scope.query = {
      available: 1,
      limit: 9,
      page: 1
    };

    var bookmark;

    $scope.filter = {
      options: {
        debounce: 500
      }
    };

    $scope.listProductsPage = function () {
      Product.list($scope.query).$promise.then(
        function (response) {
          if (response.status) {
            $scope.products = response.products;
            $scope.total = response.pagination.count;
          }
        }
      );
    };

    $scope.listProductsPage();

    $scope.fetchPage = function (page) {
      $scope.query.page = page;
      $scope.listProductsPage();
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

      $scope.listProductsPage();
    });

    $scope.listProducts = function (d1, d2) {
      var discountRange = d1 + ',' + d2;
      $scope.query.discount = discountRange;
      Product.list($scope.query).
        $promise.then(
          function (response) {
            if (response.status) {
              $scope.products = response.products;
              $scope.total = response.pagination.count;
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
