'use strict';

angular.
  module('auth').
  factory('Auth', ['$location', 'Login',
    function ($location, Login) {

      var service = {};

      service.login = function (username, password, callback) {
        Login.login({username: username, password: password}).$promise.then(
          function (response) {
            if (response.status) {
              service.setCredentials(response.user);
            }
            callback(response);
          }
        );
      };

      service.logout = function () {
        service.clearCredentials();
        $location.path('/login');
      };

      service.setCredentials = function (user) {
        service.user = user;
        service.logged_in = true;
        service.basicAuthHeader = 'Basic ' +
          window.btoa(user.username + ':' + user.api_key);
      };

      service.clearCredentials = function () {
        service.user = {};
        service.logged_in = false;
        service.basicAuthHeader = '';
      };

      return service;

    }
  ]);
