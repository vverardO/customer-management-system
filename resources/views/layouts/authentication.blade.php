<!doctype html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>@yield('page.title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ URL::asset('/assets/images/shortcut.ico') }}">
        <link href="assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <livewire:styles />
    </head>
    <body data-layout="horizontal" data-topbar="dark">
        <div class="authentication-bg min-vh-100">
            <div class="container">
                <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            {{$slot}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center text-muted p-4">
                                <p class="text-white-50">
                                    <script>document.write(new Date().getFullYear())</script> &copy; Customer Management System - Desenvolvido por Valentim Verardo
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenujs/metismenujs.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/libs/alertifyjs/build/alertify.min.js"></script>
        <livewire:scripts />

        <script>
            @if (session()->has('message'))
                switch ("{{session('type')}}") {
                    case "success":
                        alertify.success("{{session('message')}}")
                        break;
                    case 'warning':
                        alertify.warning("{{session('message')}}")
                        break;
                    case 'error':
                        alertify.error("{{session('message')}}")
                        break;
                    default:
                        alertify.message("{{session('message')}}")
                        break;
                }
            @endif
        </script>

    </body>
</html>
