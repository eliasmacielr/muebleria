'use strict';

// Register `login` component, along with its associated controller and template
angular.
  module('login').
  component('login', {
    templateUrl: 'app/login/login.template.html',
    controller: ['Auth',
      function LoginController(Auth) {

        var self = this;

        Auth.clearCredentials();

        self.login = function () {
          Auth.login(self.username, self.password,
            function (response) {
              // go to dashboard
              if (response.status) {
                console.log('You are now logged in');
              }
            }
          );
        };

        self.logout = function () {
          Auth.logout();
        };

      }
    ]
  });
