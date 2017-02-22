publicAppCtrls.controller('contact',
  ['$scope', 'Setting', 'Email',
  function ($scope, Setting, Email) {

    Setting.view().$promise.then(
      function (response) {
        if (response.status) {
          $scope.setting = response.setting;
        }
      }
    );

    $scope.responseMsg = "";

    $scope.sendMail = function () {
      Email.send($scope.user,
        function (response) {
          if (response.status) {
            $scope.responseMsg = "El mensaje ha sido enviado";
          } else {
            $scope.responseMsg = "El mensaje no pudo enviarse";
          }
        },
        function (reason) {
          $scope.responseMsg = "El mensaje no pudo enviarse";
        }
      );
    };

  }]
);
