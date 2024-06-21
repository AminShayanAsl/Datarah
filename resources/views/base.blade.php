<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('title')
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <style type="text/css" rel="stylesheet">
        @font-face {
            font-family: irsans;
            src: url({{ asset('fonts/irsans.ttf') }});
        } body {
            font-family: irsans, Arial, serif;
            font-size: 1.2rem;
        } .f-iranSans {
            font-family: irsans, Arial, serif;
        }
    </style>
    <!-- JS -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/jquery.sweet-modal.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sweet-modal.min.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/jquery.scroll-spy.min.js') }}"></script>
</head>
<body class="h-100">
@yield('body')
</body>
</html>
