'use strict';

angular.
  module('core.utils').
  factory('Utils', ['$location',
    function($location) {
      if (!$location.origin)
        $location.origin = $location.protocol() + "//" + location.host();

      return $location.origin;
    }
  ]);
