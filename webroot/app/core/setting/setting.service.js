'use strict';

angular.
  module('core.setting').
  factory('Setting', ['$resource',
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

      return $resource(location.origin + '/muebleria/api/setting',
        {},
        {
          view: {
            method: 'GET',
            headers: this.headers
          },
          edit: {
            method: 'PUT',
            headers: this.headers
          },
        }
      );

    }
  ]);
