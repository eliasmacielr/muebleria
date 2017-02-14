'use strict';

angular.
  module('hostLocation'). // core
  factory('HostLocation', [
    function () {
      var origin;
      if (window.location.host.indexOf('clickmuebles.com.py') !== -1 || window.location.host.indexOf('herokuapp.com') !== -1) { // if is clickmuebles.com.py or in herokuapp.com
        origin = window.location.origin;
      } else {
        origin = window.location.protocol + '//' + window.location.host + '/' + 'muebleria';
      }

      return {
        'origin': origin
      };
    }
  ]);
