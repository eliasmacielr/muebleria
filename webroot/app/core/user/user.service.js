'use strict';

angular.
  module('core.user').
  factory('User', ['$resource', 'HostLocation', 'Auth',
    function($resource, HostLocation, Auth) {

      this.headers = {
        'Content-Type' : 'application/json',
        'Accept' : 'application/json',
        'Authorization' : Auth.basicAuthHeader
      };

      /*
      Default actions
      { 'get':    {method:'GET'},
        'save':   {method:'POST'},
        'query':  {method:'GET', isArray:true},
        'remove': {method:'DELETE'},
        'delete': {method:'DELETE'} };
      */

      return $resource(HostLocation.origin + '/api/users/:userId',
        {'userId': '@id'},
        {
          list: {
            method: 'GET',
            headers: this.headers,
            isArray: false // returns object containing an array called customers
          },
          view: {
            method: 'GET',
            headers: this.headers
          },
          add: {
            method: 'POST',
            headers: this.headers
          },
          edit: {
            method: 'PUT',
            headers: this.headers
          },
          delete: {
            method: 'DELETE',
            headers: this.headers
          }
        }
      );

    }
  ]);
