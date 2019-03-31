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
        <link rel="stylesheet" href="//cdn.materialdesignicons.com/3.5.95/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
        <!-- endinject -->

        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
        <!-- endinject -->
        <link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" />

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
                    Copyright &copy; 2019 ChinaFlier <a target="_blank" href="https://pilot.chinaflier.com/">Pilot System</a> All Rights Reserved
                </div>
            </footer>
        @endsection
        @yield('footer')
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- inject:js -->
        <script src="{{asset("assets/js/off-canvas.js")}}"></script>
        <script src="{{asset("assets/js/misc.js")}}"></script>
        <!-- endinject -->
        @yield('script')
    </body>
</html>