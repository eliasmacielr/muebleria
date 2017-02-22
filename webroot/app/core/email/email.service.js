'use strict';

angular.
  module('core.email').
  factory('Email', ['$resource', 'HostLocation',
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

      return $resource(HostLocation.origin + '/api/email/send',
        {},
        {
          send: {
            method: 'POST',
            headers: this.headers
          }
        }
      );

    }
  ]);
