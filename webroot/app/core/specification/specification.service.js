'use strict';

angular.
  module('core.specification').
  factory('Specification', ['$resource',
    function($resource) {

      this.headers = {
        'Content-Type' : 'application/json',
        'Accept' : 'application/json'
      };

      /*
      Default actions
      { 'get':    {method:'GET'},
        'save':   {method:'POST'},
        'query':  {method:'GET', isArray:true},
        'remove': {method:'DELETE'},
        'delete': {method:'DELETE'} };
      */

      return $resource(location.origin + '/muebleria/api/products/:productId/specifications/:id',
        {'productId': '@product_id'},
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
