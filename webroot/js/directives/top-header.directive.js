'use strict'

publicAppCtrls.directive('topHeader', ['$location', function($location) {
  var location = $location
  function link(scope, element, attrs) {
    $(".memenu").memenu();
    angular.element('.goto-home').on('click', function () {
      scope.$apply(function () {
        $location.path('/');
      });
    });
    angular.element('.goto-products').on('click', function () {
      scope.$apply(function () {
        $location.path('/productos');
      });
    });
    angular.element('.goto-who').on('click', function () {
      scope.$apply(function () {
        $location.path('/quienes-somos');
      });
    });
    angular.element('.goto-contact').on('click', function () {
      scope.$apply(function () {
        $location.path('/contacto');
      });
    });
  }
  return {
    link: link,
    templateUrl: "partials/top-header.html"
  };
}
]);
