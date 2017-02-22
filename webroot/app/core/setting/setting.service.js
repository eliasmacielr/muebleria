'use strict';

angular.
  module('core.setting').
  factory('Setting', ['$resource', 'HostLocation',
    function($resource, HostLocation) {

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

      return $resource(HostLocation.origin + '/api/settings',
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
