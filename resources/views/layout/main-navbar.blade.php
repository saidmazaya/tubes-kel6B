<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PREMIUM | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    @stack('css')
</head>


<body>
    @include('components.navbar-notif')
    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.min.js"
        integrity="sha512-bO7vUr8TJWtxp+AAw1YYbEg6IaTr6ysaOrME9x1yLYI1Fv8U6Yuhf6rywzQ2f3bMffI/mgqwmgX5D5nrdxbp6w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('js')
</body>

</html>