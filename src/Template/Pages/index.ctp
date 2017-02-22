<?php $this->layout = 'angular' ?>
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html ng-app="clickmueblesPublicApp">
<head>
<!-- <title>Lighting A Ecommerce Category Flat Bootstarp Resposive Website Template | Home :: w3layouts</title> -->
<title>Clickmuebles</title>

<script src="app/bower_components/angular/angular.js"></script>
<script src="app/bower_components/angular-route/angular-route.js"></script>
<script src="app/bower_components/angular-resource/angular-resource.js"></script>

<!-- clickmueblesPublicApp modules -->
<script src="app/app.module.js"></script>
<script src="app/app-route.config.js"></script>

<!-- Host location -->
<script src="app/core/host-location.module.js"></script>
<script src="app/core/host-location.service.js"></script>

<!-- Core module -->
<script src="app/core/core.module.js"></script>
<!-- Core tree modules -->
<script src="app/core/category/category.module.js"></script>
<script src="app/core/category/category.service.js"></script>

<script src="app/core/email/email.module.js"></script>
<script src="app/core/email/email.service.js"></script>

<script src="app/core/image/image.module.js"></script>
<script src="app/core/image/image.service.js"></script>

<script src="app/core/login/login.module.js"></script>
<script src="app/core/login/login.service.js"></script>

<script src="app/core/product/product.module.js"></script>
<script src="app/core/product/product.service.js"></script>

<script src="app/core/setting/setting.module.js"></script>
<script src="app/core/setting/setting.service.js"></script>

<script src="app/core/specification/specification.module.js"></script>
<script src="app/core/specification/specification.service.js"></script>

<script src="app/core/user/user.module.js"></script>
<script src="app/core/user/user.service.js"></script>

<!-- Controllers -->
<script src="js/main.controller.js"></script>
<script src="js/categories.controller.js"></script>
<script src="js/category-products.controller.js"></script>
<script src="js/navigation.controller.js"></script>
<script src="js/products-home.controller.js"></script>
<script src="js/products.controller.js"></script>
<script src="js/product-details.controller.js"></script>
<script src="js/settings.controller.js"></script>
<script src="js/contact.controller.js"></script>

<link rel="icon" type="image/png" href="img/icons/favicon-16x16.png" sizes="16x16">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<!--theme style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<script src="js/jquery.min.js"></script>

<!--//theme style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Wedding Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- start menu -->
<script src="js/simpleCart.min.js"> </script>
<!-- start menu -->
<link href="css/memenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/memenu.js"></script>
<script>$(document).ready(function(){$(".memenu").memenu();});</script>
<!-- /start menu -->
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
		</script>
<!-- //the jScrollPane script -->
<script src="https://use.fontawesome.com/0c95362910.js"></script>

</head>
<body>
  <div ng-view ng-cloak></div>
</body>
</html>
