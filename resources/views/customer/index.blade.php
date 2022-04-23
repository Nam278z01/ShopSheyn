<!doctype html>
<html ng-app="myApp">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@{{ title }}</title>
    <link rel="shortcut icon" href="/image/icon.png">
	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/pagination.css" rel="stylesheet">
	<link href="/css/loading.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.3/angular.min.js" integrity="sha512-KZmyTq3PLx9EZl0RHShHQuXtrvdJ+m35tuOiwlcZfs/rE7NZv29ygNA8SFCkMXTnYZQK2OX0Gm2qKGfvWEtRXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-route/1.8.3/angular-route.min.js" integrity="sha512-y1qD3hz/IAf8W4+/UMLZ+CN6LIoUGi7srWJ3r1R17Hid8x0yXe+1B5ZelkaL1Mjzedzu0Cg3HBvDG02SAgSzBw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.8.3/angular-sanitize.min.js" integrity="sha512-dqbRITjlgYAKHWHwL8fK7VPOsFc702ybywomtYLRcjOzBHM3WgEGN0SQQR6IJKY4ZiJiZkNguOAcFZmalk+2sA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/js/app.js"></script>
    <script src="/js/controller/app.js"></script>
	<script src="/js/controller/product.controller.js"></script>
	<script src="/js/controller/productdetails.controller.js"></script>
</head>

<body>

	<div id="root">
		<!-- Header -->
		@include('customer.includes.header')

		<!-- Main -->
		<div ng-view></div>

		<!-- Footer -->
		@include('customer.includes.footer')

	</div>

</body>

</html>
