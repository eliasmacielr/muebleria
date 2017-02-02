'use strict';

angular.
  module('hostLocation'). // core
  factory('HostLocation', [
    function () {
      var origin;
      if (window.location.host.indexOf('clickmuebles.com.py') !== -1) { // es clickmuebles.com.py
        origin = window.location.origin;
      } else {
        origin = window.location.protocol + '//' + window.location.host + '/' + 'muebleria';
      }

      return {
        'origin': origin
      };
    }
  ]);
