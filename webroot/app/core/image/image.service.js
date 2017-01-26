'use strict';

angular.
  module('core.image').
  factory('Image', ['$resource',
    function($resource) {

      this.headers = {
        'Accept' : 'application/json',
        'Content-Type': undefined
      };

      /*
      Default actions
      { 'get':    {method:'GET'},
        'save':   {method:'POST'},
        'query':  {method:'GET', isArray:true},
        'remove': {method:'DELETE'},
        'delete': {method:'DELETE'} };
      */

      return $resource(location.origin + '/muebleria/api/products/:productId/images/:imageId',
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
          delete: {
            method: 'DELETE',
            headers: this.headers
          }
        }
      );

    }
  ]);
