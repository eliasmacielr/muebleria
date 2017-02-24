'use strict'

publicAppCtrls.directive('topHeader', function() {
  function link(scope, element, attrs) {
    $(".memenu").memenu();
    $('.scroll-pane').jScrollPane();
  }
  return {
    link: link,
    templateUrl: "partials/top-header.html"
  };
});
