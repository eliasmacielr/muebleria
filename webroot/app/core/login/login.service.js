'use strict';

angular.
  module('core.login').
  factory('Login', ['$resource', 'HostLocation',
    function($resource, HostLocation) {

      this.headers = {
        'Accept' : 'application/json',
        'Content-Type': 'application/json'
      };

      /*
      Default actions
      { 'get':    {method:'GET'},
        'save':   {method:'POST'},
        'query':  {method:'GET', isArray:true},
        'remove': {method:'DELETE'},
        'delete': {method:'DELETE'} };
      */

      return $resource(HostLocation.origin + '/api/auth/login',
        {},
        {
          login: {
            method: 'POST',
            headers: this.headers
          }
        }
      );

    }
  ]);
