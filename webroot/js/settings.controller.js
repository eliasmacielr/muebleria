publicAppCtrls.controller('settings',
  ['$scope', '$window', '$location', 'Setting',
  function ($scope, $window, $location, Setting) {

    Setting.view().$promise.then(
      function (response) {
        $scope.setting = response.setting;
      }
    );

    $scope.open = function (url) {
      window.open('https://' + url, '_blank');
    };

  }]
);
