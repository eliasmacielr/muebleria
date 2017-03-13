publicAppCtrls.controller('productsHome',
  ['$scope', '$location', 'Product',
  function ($scope, $location, Product) {

    $scope.query = {
      in_offer: 1,
      available: 1,
      limit: 9,
      page: 1,
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
            $scope.productsInOffer = response.products;
            $scope.pages = createArray(response.pagination.pageCount);
          }
        }
      );
    };

    function createArray(n) {
      var a = new Array(n);
      for (var i = 0; i < n; i++) {
        a[i] = i+1;
      }
      return a;
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
