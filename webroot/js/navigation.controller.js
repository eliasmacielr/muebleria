publicAppCtrls.controller('navigation',
  ['$scope', '$location',
  function ($scope, $location) {

    $scope.home = function () {
      $location.path('/');
    };

    $scope.products = function () {
      $location.path('/productos');
    };

    $scope.whoWeAre = function () {
      $location.path('/quienes-somos');
    };

    $scope.contact = function () {
      $location.path('/contacto');
    };
  }]
);
