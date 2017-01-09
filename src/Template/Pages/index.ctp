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

  <link rel="stylesheet" href="webroot/app/bower_components/angular-material/angular-material.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Angular & Angular Material -->
  <!-- In production use:
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/x.x.x/angular.min.js"></script>
  -->
  <script src="webroot/app/bower_components/angular/angular.js"></script>
  <script src="webroot/app/bower_components/angular-route/angular-route.js"></script>
  <script src="webroot/app/bower_components/angular-resource/angular-resource.js"></script>
  <script src="webroot/app/bower_components/angular-animate/angular-animate.js"></script>
  <script src="webroot/app/bower_components/angular-aria/angular-aria.js"></script>
  <script src="webroot/app/bower_components/angular-messages/angular-messages.js"></script>
  <script src="webroot/app/bower_components/angular-material/angular-material.js"></script>

  <!--md-data-table  -->
  <!-- style sheet -->
  <link href="webroot/app/bower_components/angular-material-data-table/dist/md-data-table.min.css" rel="stylesheet" type="text/css"/>
  <!-- module -->
  <script type="text/javascript" src="webroot/app/bower_components/angular-material-data-table/dist/md-data-table.min.js"></script>

  <!-- App modules -->
  <script src="webroot/app/app.module.js"></script>
  <script src="webroot/app/app.config.js"></script>

  <!-- Core module -->
  <script src="webroot/app/core/core.module.js"></script>
  <!-- Core tree modules -->
  <script src="webroot/app/core/category/category.module.js"></script>
  <script src="webroot/app/core/category/category.service.js"></script>

  <script src="webroot/app/core/customer/customer.module.js"></script>
  <script src="webroot/app/core/customer/customer.service.js"></script>

  <script src="webroot/app/core/product/product.module.js"></script>
  <script src="webroot/app/core/product/product.service.js"></script>

  <script src="webroot/app/login/login.module.js"></script>
  <script src="webroot/app/login/login.component.js"></script>

  <!-- Components for tables -->
  <!-- <script src="webroot/app/category-list/category-list.module.js"></script>
  <script src="webroot/app/category-list/category-list.component.js"></script> -->

  <script src="webroot/app/customer-list/customer-list.module.js"></script>
  <script src="webroot/app/customer-list/customer-list.component.js"></script>

  <script src="webroot/app/product-list/product-list.module.js"></script>
  <script src="webroot/app/product-list/product-list.component.js"></script>

  <!-- Style customizations -->
  <link rel="stylesheet" href="webroot/app/app.css">
</head>
<body>

  <div ng-view></div>

</body>
</html>
