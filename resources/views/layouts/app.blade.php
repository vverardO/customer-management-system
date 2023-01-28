<!doctype html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>@yield('head.title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ URL::asset('/assets/images/shortcut.ico') }}">
        <link href="/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <livewire:styles />
    </head>
    <body data-layout="horizontal" data-topbar="dark">
        <div id="layout-wrapper">
            <header class="ishorizontal-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <livewire:components.header.brand />
                        <livewire:components.header.navbar />
                    </div>
                    <div class="d-flex">
                        <livewire:components.header.dropdown />
                    </div>
                </div>
            </header>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">@yield('page.title')</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{$slot}}
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> &copy; Customer Management System - Desenvolvido por Valentim Verardo
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/libs/metismenujs/metismenujs.min.js"></script>
        <script src="/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/assets/libs/feather-icons/feather.min.js"></script>
        <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="/assets/js/pages/chartjs.js"></script>
        <script src="/assets/js/app.js"></script>
        <script src="/assets/libs/alertifyjs/build/alertify.min.js"></script>
        <script src="/assets/libs/flot-charts/jquery.js"></script>
        <livewire:scripts />
        @yield('script')

        <script>
            $(document).ready(function () {
                window.livewire.on('alert', param => {
                    switch (param.type) {
                        case "success":
                            alertify.success(param.message)
                            break;
                        case 'warning':
                            alertify.warning(param.message)
                            break;
                        case 'error':
                            alertify.error(param.message)
                            break;
                        default:
                            alertify.message(param.message)    
                            break;
                    }
                });

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
            });
        </script>
    </body>
</html>
