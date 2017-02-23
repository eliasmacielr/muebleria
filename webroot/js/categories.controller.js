publicAppCtrls.controller('categories',
  ['$scope', '$location', 'Category',
  function ($scope, $location, Category) {

    Category.list({paged: 0}).$promise.then(
      function (response) {
        if (response.status) {
          $scope.categories = response.categories;
        }
      }
    );

    $scope.viewCategoryProducts = function (categoryId) {
      $location.path('/categorias/' + categoryId);
    };

  }]
);
