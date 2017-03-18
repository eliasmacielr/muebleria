'use strict';

// Declare app level module which depends on views, and components
angular.module('clickmueblesAdminApp', [
  'ngRoute',
  'ngMaterial',
  'md.data.table',
  'ngStorage',
  'ngMessages',
  'auth',
  'core',
  'dashboard',
  'hostLocation',
  'navigation',
  'categoryList',
  'login',
  'productAdd',
  'productEdit',
  'productList',
  'settingList',
  'userList'
]);

angular.module('clickmueblesPublicApp', [
  'ngRoute',
  'ui.bootstrap',
  'core',
  'hostLocation',
  'publicAppCtrls',
  'clickmueblesDirectives'
]);
