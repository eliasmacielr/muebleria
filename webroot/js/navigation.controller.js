publicAppCtrls.controller('navigation',
  ['$scope', '$location',
  function ($scope, $location) {

    $scope.home = function () {
      $location.path('/home');
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
