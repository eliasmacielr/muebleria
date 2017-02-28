'use strict';

angular.
  module('clickmueblesAdminApp').
  config(['$locationProvider', '$routeProvider',
    function config($locationProvider, $routeProvider) {
      $locationProvider.hashPrefix('!');

      $routeProvider.
        when('/categorias', {
          template: '<category-list></category-list>'
        }).
        when('/bandeja', {
          template: '<dashboard></dashboard>'
        }).
        when('/login', {
          template: '<login></login>'
        }).
        when('/productos', {
          template: '<product-list></product-list>'
        }).
        when('/productos/agregar', {
          template: '<product-add></product-add>'
        }).
        when('/productos/editar/:productId', {
          template: '<product-edit></product-edit>'
        }).
        when('/configuracion', {
          template: '<setting-list></setting-list>'
        }).
        when('/usuarios', {
          template: '<user-list></user-list>'
        }).
        otherwise('/login');
    }
  ]).
  run(
    function ($rootScope, $http, $location, Auth) {
      $rootScope.$on('$routeChangeStart',
        function (event, next, current) {
          if (!Auth.$storage.logged_in) {
            if (next.template == '<login></login>') {
            } else {
              $location.path('/login');
            }
          }
          $http.defaults.headers.common['Authorization'] = 'Basic ' +
            window.btoa(Auth.$storage.user.username + ':' + Auth.$storage.user.api_key);
        }
      );
    }
  );

angular.
  module('clickmueblesPublicApp').
  config(['$locationProvider', '$routeProvider',
    function config($locationProvider, $routeProvider) {
      $locationProvider.hashPrefix('!');

      $routeProvider.
        when('/', {
          templateUrl: 'home.html'
        }).
        when('/home', {
          templateUrl: 'home.html'
        }).
        when('/productos', {
          templateUrl: 'product.html'
        }).
        when('/categorias/:categorySlug', {
          templateUrl: 'category-product.html'
        }).
        when('/productos/:productSlug', {
          templateUrl: 'single.html'
        }).
        when('/quienes-somos', {
          templateUrl: 'we.html'
        }).
        when('/contacto', {
          templateUrl: 'contact.html'
        }).
        otherwise('/home');

        // use the HTML5 History API
        $locationProvider.html5Mode(true);
    }
  ]);
