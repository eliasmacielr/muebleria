'use strict';

// Register `login` component, along with its associated controller and template
angular.
  module('login').
  component('login', {
    templateUrl: 'app/login/login.template.html',
    controller: ['$http', '$location', '$mdToast', 'Auth',
      function LoginController($http, $location, $mdToast, Auth) {

        var self = this;

        self.user = {};

        Auth.clearCredentials();

        self.login = function () {
          Auth.login(self.user.username, self.user.password,
            function (response) {
              if (response.status) { // successful login
                $location.path('/bandeja');
              } else {
                self.messageToast(response.message);
              }
            },
            function (reason) { // error
              self.messageToast(reason.message);
            }
          );
        };

        self.messageToast = function (message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

      }
    ]
  });
