'use strict';

angular.
  module('core.image').
  factory('Image', ['$resource', 'HostLocation', 'Auth',
    function($resource, HostLocation, Auth) {

      this.headers = {
        'Accept' : 'application/json',
        'Content-Type': undefined,
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

      return $resource(HostLocation.origin + '/api/products/:productId/images/:action/:imageId',
        {},
        {
          list: {
            method: 'GET',
            headers: this.headers,
            isArray: false // returns object containing an array
          },
          view: {
            method: 'GET',
            headers: this.headers
          },
          add: {
            method: 'POST',
            headers: this.headers
          },
          markAsMain: {
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
