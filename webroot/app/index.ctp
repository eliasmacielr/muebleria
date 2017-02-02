<?php $this->layout = 'angular' ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" ng-app="myApp" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" ng-app="myApp" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" ng-app="myApp" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html ng-app="myApp" ng-cloak> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mueblería</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="app/bower_components/angular-material/angular-material.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Angular & Angular Material -->
  <!-- In production use:
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/x.x.x/angular.min.js"></script>
  -->
  <script src="app/bower_components/angular/angular.js"></script>
  <script src="app/bower_components/angular-route/angular-route.js"></script>
  <script src="app/bower_components/angular-resource/angular-resource.js"></script>
  <script src="app/bower_components/angular-animate/angular-animate.js"></script>
  <script src="app/bower_components/angular-aria/angular-aria.js"></script>
  <script src="app/bower_components/angular-messages/angular-messages.js"></script>
  <script src="app/bower_components/angular-material/angular-material.js"></script>

  <!--md-data-table  -->
  <!-- style sheet -->
  <link href="app/bower_components/angular-material-data-table/dist/md-data-table.min.css" rel="stylesheet" type="text/css"/>
  <!-- module -->
  <script type="text/javascript" src="app/bower_components/angular-material-data-table/dist/md-data-table.min.js"></script>

  <!-- App modules -->
  <script src="app/app.module.js"></script>
  <script src="app/app-route.config.js"></script>
  <script src="app/app-theme.config.js"></script>

  <!-- Core module -->
  <script src="app/core/core.module.js"></script>
  <!-- Core tree modules -->
  <script src="app/core/category/category.module.js"></script>
  <script src="app/core/category/category.service.js"></script>

  <script src="app/core/image/image.module.js"></script>
  <script src="app/core/image/image.service.js"></script>

  <script src="app/core/product/product.module.js"></script>
  <script src="app/core/product/product.service.js"></script>

  <script src="app/core/setting/setting.module.js"></script>
  <script src="app/core/setting/setting.service.js"></script>

  <script src="app/core/specification/specification.module.js"></script>
  <script src="app/core/specification/specification.service.js"></script>

  <script src="app/core/user/user.module.js"></script>
  <script src="app/core/user/user.service.js"></script>

  <script src="app/core/host-location.module.js"></script>
  <script src="app/core/host-location.service.js"></script>

  <!-- Login -->
  <script src="app/login/login.module.js"></script>
  <script src="app/login/login.component.js"></script>

  <!-- Components for views -->
  <!-- Category -->
  <script src="app/category/list/category-list.module.js"></script>
  <script src="app/category/list/category-list.component.js"></script>

  <!-- Product -->
  <script src="app/product/list/product-list.module.js"></script>
  <script src="app/product/list/product-list.component.js"></script>
  <script src="app/product/edit/product-edit.module.js"></script>
  <script src="app/product/edit/product-edit.component.js"></script>

  <!-- Style customizations -->
  <link rel="stylesheet" href="app/app.css">
</head>
<body>

  <div ng-view layout-fill></div>

</body>
</html>
