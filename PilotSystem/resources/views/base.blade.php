<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}">
        <title>@yield('title') - {{ config('app.name') }}</title>

        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flag-icon.min.css') }}">
        <!-- endinject -->

        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
        <!-- endinject -->
        <link rel="shortcut icon" href="{{ asset("assets/images/logo.png") }}" />

        <!-- plugin css for this page -->
        @yield('head')
        <!-- End plugin css for this page -->
    </head>
    <body>
        <div class="container-scroller">
            @yield('main')
        </div>
        @section('footer')
            <footer class="text-center text-white position-absolute mx-auto" style="bottom:0; width:100%">
                <div class="container">
                    Copyright &copy; 2019 ChinaFlier <a target="_blank" href="{{ url('/') }}">Pilot System</a> All Rights Reserved
                </div>
            </footer>
        @endsection
        @yield('footer')
        <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- inject:js -->
        <script src="{{asset("assets/js/off-canvas.js")}}"></script>
        <script src="{{asset("assets/js/misc.js")}}"></script>
        <!-- endinject -->
        @yield('script')
    </body>
</html>