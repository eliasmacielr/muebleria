<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html ng-app="clickmueblesPublicApp">
<head>
<base href="/muebleria/">
<title>ClickMuebles</title>

<script src="js/jquery-1.12.4.min.js"></script>
<script src="js/imagezoom.js"></script>
<script defer src="js/jquery.flexslider.js"></script>

<script src="app/bower_components/angular/angular.min.js"></script>
<script src="app/bower_components/angular-animate/angular-animate.min.js"></script>
<script src="app/bower_components/angular-route/angular-route.min.js"></script>
<script src="app/bower_components/angular-resource/angular-resource.min.js"></script>

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
<script src="js/products-home.controller.js"></script>
<script src="js/products.controller.js"></script>
<script src="js/product-details.controller.js"></script>
<script src="js/settings.controller.js"></script>
<script src="js/contact.controller.js"></script>
<script src="js/navigation.controller.js"></script>

<script src="js/directives/main.directives.js"></script>
<script src="js/directives/top-header.directive.js"></script>

<link rel="icon" type="image/png" href="img/icons/favicon-16x16.png" sizes="16x16">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<!--theme style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<!--//theme style-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Wedding Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- start menu -->
<script src="js/simpleCart.min.js"> </script>
<!-- start menu -->
<link href="css/memenu.css" rel="stylesheet" type="text/css" media="all" />
<!-- /start menu -->
<link href="css/form.css" rel="stylesheet" type="text/css" media="all" />
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

<!-- Start of Smartsupp Live Chat script -->
<script type="text/javascript">
	var _smartsupp = _smartsupp || {};
	_smartsupp.key = 'd8fd84045997aeed69a54b0264403af02cb7ef50';
	window.smartsupp||(function(d) {
		var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
		s=d.getElementsByTagName('script')[0];c=d.createElement('script');
		c.type='text/javascript';c.charset='utf-8';c.async=true;
		c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
	})(document);
</script>
<script src="js/bootstrap.js"></script>
<style>
	ul.memenu li a {
		cursor: pointer;
	}
</style>
</head>
<body>
  <!-- header and menu -->
  <top-header></top-header>
  <div ng-view ng-cloak autoscroll="true"></div>
  <div ng-include src="'partials/copyright.html'"></div>
</body>
</html>
