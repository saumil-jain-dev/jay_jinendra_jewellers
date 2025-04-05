<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('public/assets/img/favicon.png') }}">
        <link rel="icon" href="{{ asset('public/assets/img/favicon.png') }}" type="image/png" sizes="16x16" />
        <!--vendors-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/js/jquery-scrollbar/jquery.scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/js/jquery-ui/jquery-ui.min.css') }}" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600" rel="stylesheet" />
        <!--Material Icons-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/fonts/materialdesignicons/materialdesignicons.min.css') }}" />
        <!--Bootstrap + dataxdata Admin CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/dataxdata.css') }}" />
        <!-- Additional library for page -->
        <link rel="stylesheet" href="{{ asset('public/assets/js/DataTables/datatables.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/js/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/js/select2/css/select2.min.css') }}" />
        <link  rel="stylesheet" href="{{ asset('public/assets/css/toastr.css') }}"/>
        
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <style>
            .error{
                color: red;
            }
        </style>
    </head>
    <body class="sidebar-pinned">
        @include('layouts.sidebar')
        <main class="admin-main">
            @include('layouts.header')
            @yield('content')
        </main>
        <script src="{{ asset('public/assets/js/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/popper/popper.js') }}"></script>
        <script src="{{ asset('public/assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
        
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!--page specific scripts for demo-->
        <script src="{{ asset('public/assets/js/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/datatable-data.js') }}"></script>
        <script src="{{ asset('public/assets/js/toastr.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/select2/js/select2.full.min.js') }}"></script>

        <!-- Validation JS -->
        <script src="{{ asset('public/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery-validation/additional-methods.min.js') }}"></script>

        <!--Custom JS-->
        <script src="{{ asset('public/assets/js/dataxdata.js') }}"></script>
        <script>
            var site_url = "{{ URL('/') }}";
            @if (Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                var message = "{{ Session::get('message') }}";
                console.log(type)
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": 10000,
                    "extendedTimeOut": 1000,
                };
                switch (type) {
                    case 'info':
                        toastr.info(message);
                        break;
                    case 'success':
                        toastr.success(message);
                        break;
                    case 'warning':
                        toastr.warning(message);
                        break;
                    case 'error':
                        toastr.error(message);
                        break;
                }
            @endif
        </script>
        @yield('scripts')
    </body>
</html>
