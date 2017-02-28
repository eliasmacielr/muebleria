'use strict'

publicAppCtrls.directive('topHeader', ['$location', function($location) {
  var location = $location
  function link(scope, element, attrs) {

  }
  return {
    link: link,
    templateUrl: "partials/top-header.html"
  };
}
]);
