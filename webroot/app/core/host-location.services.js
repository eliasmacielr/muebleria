'use strict';

angular.module('core')
  .factory('HostLocation',
  function () {
    var origin;
    if (window.location.host.indexOf('clickmuebles.com.py') !== -1) {
      origin = window.location.origin;
    } else {
      origin = window.location.protocol + '//' + window.location.host + '/' + 'muebleria';
    }

    return {
      'origin': origin
    };
  }
);
