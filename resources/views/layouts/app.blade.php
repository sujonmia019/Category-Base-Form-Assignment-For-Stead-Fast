<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>@yield('title') - {{ config('settings.site_title') ? config('settings.site_title') : config('app.name') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('css') }}/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css') }}/font-awesome.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.3/css/dataTables.responsive.css">
    <!-- NProgress -->
    <link href=".{{ asset('css') }}/nprogress.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('css') }}/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('css') }}/custom.min.css" rel="stylesheet">
    <link href="{{ asset('css') }}/main.css" rel="stylesheet">
    <style>
        label {
            margin-bottom: 2px;
            font-weight: 600;
            font-size: 12px;
            color: #707070;
        }
        button, a{
            box-shadow: none !important;
            border-radius: 0 !important
        }
        .btn-group-sm>.btn, .btn-sm {
            padding: .15rem .5rem !important;
            font-size: .81rem !important;
        }
        .dropdown-usermenu {
            padding-top: 5px;
            padding-bottom: 5px;
            transform: translate3d(-40px, 42px, 0px) !important;
        }
        .dropdown-usermenu a,
        .dropdown-usermenu button{
            padding: 5px 20px !important
        }
        .navbar-nav .open .dropdown-menu{
            width: 160px !important
        }
        small{
            font-size: 100% !important;
        }
        div:where(.swal2-container) div:where(.swal2-popup) {
            width: 22em !important;
        }
        .swal2-toast .swal2-top-end {
            padding: 0.5em !important;
        }
        .swal2-top-end .swal2-title{
            margin-left: 0 !important;
            font-size: 15px !important;
        }
        .swal2-title{
            font-size: 20px !important;
            font-weight: 500 !important;
        }
        div:where(.swal2-container) button:where(.swal2-styled) {
            padding: 5px 15px !important;
            font-size: 14px !important;
            margin: 0 5px !important;
        }
        .badge {
            padding: .5em .6em !important;
        }
        .dt-input {
            padding: .4rem .5rem !important;
            border: 1px solid #ccc !important;
            border-radius: 0 !important;
        }
        .dt-paging{
            width: 100%
        }
        .dt-paging button {
            padding: 5px 8px !important;
        }
        .card-title {
            font-size: 18px !important;
        }
        .card-header {
            background: #ffffff;
        }
    </style>
    @stack('styles')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Streed First</span></a>
                    </div>

                    <div class="clearfix"></div>


                    <br />

                    <!-- sidebar menu -->
                    @include('include.sidebar')
                    <!-- /sidebar menu -->

                </div>
            </div>

            <!-- top navigation -->
            @include('include.header')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
            </div>
            <!-- /page content -->

            <!-- footer content -->
            @include('include.footer')
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('js') }}/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js') }}/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="{{ asset('js') }}/fastclick.js"></script>
    <!-- NProgress -->
    <script src="{{ asset('js') }}/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="{{ asset('js') }}/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="{{ asset('js') }}/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('js') }}/bootstrap-progressbar.min.js"></script>
    <!-- Datatables -->
    <script class="script" src="{{ asset('js') }}/jquery.dataTables.min.js"></script>
    <script class="script" src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script class="script" src="https://cdn.datatables.net/responsive/1.0.3/js/dataTables.responsive.min.js"></script>
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Skycons -->
    <script src="{{ asset('js') }}/skycons.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('js') }}/custom.js"></script>
    <script src="{{ asset('js') }}/main.js"></script>
    <script>
        // ajax header setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // token
        var _token = "{{ csrf_token() }}";
        var table;

        function notification(status,message){
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: status,
                title: message
            });
        }

        $(document).ready(function(){
            // tooltip
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            // session flash message
            @if(Session::get('success'))
            notification('success', "{{ Session::get('success') }}")
            @elseif(Session::get('error'))
            notification('error', "{{ Session::get('error') }}")
            @elseif(Session::get('info'))
            notification('info', "{{ Session::get('info') }}")
            @elseif(Session::get('warning'))
            notification('warning', "{{ Session::get('warning') }}")
            @endif
        });

        $(document).on('keyup keypress','input[name="search_here"]',function(){
            table.ajax.reload();
        });
    </script>

    @stack('scripts')
</body>

</html>
