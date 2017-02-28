'use strict';

angular.
  module('auth').
  factory('Auth', ['$http', '$location', '$localStorage', 'Login',
    function ($http, $location, $localStorage, Login) {

      var NOT_FOUND_CODE = 404;
      var INVALID_CREDENTIALS_MSG = 'Credenciales no válidas';
      var USER_NOT_FOUND_MSG = 'Usuario no registrado';
      var LOGIN_ERROR_MSG = 'Error en el login';

      var defaultUser = {
        name : '',
        last_name : '',
        role : ''
      };

      var service = {
        user : defaultUser
      };

      service.$storage = $localStorage.$default({
        user: service.user,
        logged_in: service.logged_in
      });

      service.login = function (username, password, callback, callbackError) {
        Login.login({username: username, password: password}).$promise.then(
          function (response) {
            if (response.status) { // successful login
              service.setCredentials(response.user);
            } else { // `status: false` for invalid credential (password)
              response.message = INVALID_CREDENTIALS_MSG;
            }
            callback(response);
          },
          function (reason) {
            reason.message = (reason.code == NOT_FOUND_CODE
              ? USER_NOT_FOUND_MSG
              : LOGIN_ERROR_MSG);
            callbackError(reason);
          }
        );
      };

      service.logout = function () {
        service.clearCredentials();
      };

      service.setCredentials = function (user) {
        service.$storage.user = user;
        service.$storage.logged_in = true;
        service.$storage.authHeader = 'Basic ' +
          window.btoa(user.username + ':' + user.api_key);
        $http.defaults.headers.common['Authorization'] = 'Basic ' +
          window.btoa(user.username + ':' + user.api_key);
      };

      service.clearCredentials = function () {
        service.$storage.user = defaultUser;
        service.$storage.logged_in = false;
        $http.defaults.headers.common['Authorization'] = '';
      };

      return service;

    }
  ]);
