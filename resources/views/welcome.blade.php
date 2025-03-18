<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <title>Jjj | Login</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('public/assets/img/favicon-icon.png') }}" />
        <link rel="icon" href="{{ asset('public/assets/img/favicon-icon.png') }}" type="image/png" sizes="16x16" />
        <!--vendors-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/js/jquery-scrollbar/jquery.scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/js/jquery-ui/jquery-ui.min.css') }}" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600" rel="stylesheet" />
        <!--Material Icons-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/fonts/materialdesignicons/materialdesignicons.min.css') }}" />
        <!--Bootstrap + dataxdata Admin CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/dataxdata.css') }}" />
        <link  rel="stylesheet"  type="text/css" href="{{ asset('public/assets/css/toastr.css') }}" />

        <!-- Additional library for page -->
    </head>
    <!--body with default sidebar pinned -->

    <body>
        <section>
            <div class="login_page container-fluid">
                <div class="color-overlay"></div>
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                        <div class="login_bg_color">
                            <div class="form-image text-center">
                                <img src="{{ asset('public/assets/img/logo.jpeg') }}" alt="Data-X-Data logo" />
                            </div>
                            <div class="form_top_content">
                                <h5>Welcome Back,</h5>
                                <p>Login to your Account</p>
                            </div>
                            <form method="post" name="update_form" action="{{ route('login-post') }}" id="update_form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group first">
                                    <label for="username">Email</label>
                                    <input type="text" class="form-control" placeholder="Email" name="email" id="email" />
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group last mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" placeholder="Your Password" name="password" id="password" />
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="submit" value="Log In" class="mt-4 login-button btn btn-block btn-primary login" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="{{ asset('public/assets/js/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/popper/popper.js') }}"></script>
        <script src="{{ asset('public/assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/dataxdata.js') }}"></script>
        <script src="{{ asset('public/assets/js/toastr.min.js') }}"></script>

        <script>

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

                // Play notification sound

            @endif
        </script>

        <!--page specific scripts for demo-->
    </body>
</html>
