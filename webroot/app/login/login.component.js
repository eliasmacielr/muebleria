'use strict';

// Register `login` component, along with its associated controller and template
angular.
  module('login').
  component('login', {
    templateUrl: 'app/login/login.template.html',
    controller: ['$http', '$location', 'Auth',
      function LoginController($http, $location, Auth) {

        var self = this;

        self.user = {};

        Auth.clearCredentials();

        self.login = function () {
          Auth.login(self.user.username, self.user.password,
            function (response) {
              if (response.status) {
                $location.path('/bandeja');
              }
            }
          );
        };

        self.logout = function () {
          Auth.logout(
            function (response) {
              if (response.status) {
                $location.path('/login');
              }
            }
          );
        };

      }
    ]
  });
