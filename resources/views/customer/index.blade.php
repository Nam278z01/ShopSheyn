<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/css/app.css" rel="stylesheet">
	<title>Shop</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script> -->
	<script src="js/controller/app.js"></script>
	<script src="js/controller/product.controller.js"></script>
	<script src="js/controller/productdetails.controller.js"></script>
</head>

<body ng-app="myApp">

	<div id="root">
		<!-- Header -->
		@include('customer.shared.header')

		<!-- Main -->
		@yield('customer.content')

		<!-- Footer -->
		@include('customer.shared.footer')

	</div>

</body>

</html>
