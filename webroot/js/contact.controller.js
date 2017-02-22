publicAppCtrls.controller('contact',
  ['$scope', 'Setting',
  function ($scope, Setting) {

    Setting.view().$promise.then(
      function (response) {
        if (response.status) {
          $scope.setting = response.setting;
        }
      }
    );

  }]
);
