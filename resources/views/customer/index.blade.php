<!DOCTYPE html>
<html ng-app="myApp">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@{{ title }}</title>
        <link rel="shortcut icon" href="/image/product/icon.png" />
        <link href="/css/customer.css" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
            rel="stylesheet"
        />
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
        <script src="/js/app.js"></script>
        <script src="/js/customer.js"></script>
    </body>
</html>
