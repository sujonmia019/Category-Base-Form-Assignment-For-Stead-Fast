<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('settings.site_title') ? config('settings.site_title') : config('app.name') }}</title>
    <!-- Bootstrap -->
    <link href="{{ asset('/') }}css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('/') }}css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('/') }}css/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('/') }}css/animate.min.css" rel="stylesheet">
    <style>
        body{
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-4 mx-auto">
                @if (session('error'))
                <div class="alert alert-danger py-2"><b>Message:</b> {{ session('error') }}</div>
                @elseif (session('warning'))
                <div class="alert alert-warning py-2"><b>Message:</b> {{ session('warning') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
