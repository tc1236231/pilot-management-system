@extends('base')

@section('main')
    <div class="container-scroller">
        @include('dashboard.navbar')

        <div class="container-fluid page-body-wrapper">
            <div class="row row-offcanvas row-offcanvas-right">
                @include('dashboard.sidebar')

                <div class="content-wrapper">
                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="container-fluid clearfix">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019 ChinaFlier <a href="https://pilot.chinaflier.com/" target="_blank">Pilot System</a>. All rights reserved.</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- row-offcanvas ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection
@section('footer')
@endsection