<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="pt_br">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="{{config('app.description')}}" />
    <meta name="csrf-token"  content="{{csrf_token()}}" />
    <title>{{config('app.name')}}</title>
    <link href="{{URL('/')}}/favicon.png?v={{config('system.cache_version')}}" rel="shortcut icon"/>
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/fonts/meteocons/style.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/fonts/simple-line-icons/style.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/vendors/css/vendors.min.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/vendors/css/extensions/unslider.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/vendors/css/weather-icons/climacons.min.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/vendors/css/charts/morris.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/vendors/css/tables/datatable/datatables.min.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/css/bootstrap.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/css/bootstrap-extended.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/css/colors.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/css/components.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/css/core/menu/menu-types/vertical-menu.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/css/core/colors/palette-gradient.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/SAv4.0/app-assets/css/pages/timeline.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('assets')}}/css/sweetalert2/sweetalert2.v11.22.2.min.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('assets')}}/css/cropperjs/cropper.v1.6.2.min.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('assets')}}/css/bootstrap-select/bootstrap-select.min.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('assets')}}/css/bootstrap-datepicker/bootstrap-datepicker.min.css?v={{config('system.cache_version')}}">
    <link rel="stylesheet" type="text/css" href="{{URL('assets')}}/css/tagify/tagify.min.css?v={{config('system.cache_version')}}">
    <link href="{{URL('assets')}}/css/App.css?v={{config('system.cache_version')}}" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i&v={{config('system.cache_version')}}" rel="stylesheet">
    @yield("style")
    <script>
        var G = {app_url:"{{URL('/')}}"};
    </script>
</head>

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns pace-done menu-collapsed" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

<nav id="header-navbar-topo" class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center">
    <div class="navbar-wrapper">
        <div class="navbar-header align-content-center">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a class="logo" href="{{URL('/')}}">
                        <img class="logo-open" width="150" src="{{URL('assets')}}/images/logo_orbicrm_h.png" />
                        {{--<img class="logo-close" width="32" src="{{URL('assets')}}/images/logo_orbicrm_icone.png" />--}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="header-navbar-menu" class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <a class="nav-link {{Request::segment(1)==''?'active':'' }}" href="{{route('loja.index')}}"><i class="feather icon-home"></i><span>Loja</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::segment(1)=='produtos'?'active':'' }}" href="{{route('produtos.index')}}"><i class="feather icon-aperture"></i><span>Produtos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::segment(1)=='variacoes'?'active':'' }}" href="{{route('produtos.index')}}"><i class="feather icon-tag"></i><span>Variações</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::segment(1)=='estoques'?'active':'' }}" href="{{route('produtos.index')}}"><i class="feather icon-box"></i><span>Estoques</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::segment(1)=='cupons'?'active':'' }}" href="{{route('cupons.index')}}"><i class="feather icon-award"></i><span>Cupons</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::segment(1)=='pedidos'?'active':'' }}" href="{{route('pedidos.index')}}"><i class="feather icon-shopping-cart"></i><span>Pedidos</span></a>
            </li>
        </ul>
    </div>
</div>

<div id="box-content" class="app-content container center-layout mt-2">
    <div class="content-overlay"></div>

    @yield('content')

</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<footer class="footer footer-light navbar-shadow fixed-bottom">
    <p class="clearfix white lighten-2 text-sm-center mb-0 px-2 container center-layout"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; {{date('Y')}} - {{config('app.name')}}</span></p>
</footer>

<script src="{{URL('/')}}/SAv4.0/app-assets/vendors/js/vendors.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('/')}}/SAv4.0/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="{{URL('/')}}/SAv4.0/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="{{URL('/')}}/SAv4.0/app-assets/vendors/js/extensions/jquery.knob.min.js"></script>
<script src="{{URL('/')}}/SAv4.0/app-assets/js/scripts/extensions/knob.min.js"></script>
<script src="{{URL('/')}}/SAv4.0/app-assets/vendors/js/tables/datatable/datatables.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('/')}}/SAv4.0/app-assets/js/core/app-menu.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('/')}}/SAv4.0/app-assets/js/core/app.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/jquery.mask/jquery.mask.v1.14.16.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/sweetalert2/sweetalert2.v11.22.2.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/cropperjs/cropper.v1.6.2.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/bootstrap-select/bootstrap-select.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/bootstrap-datepicker/bootstrap-datepicker.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/tagify/tagify.min.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/H.js?v={{config('system.cache_version')}}"> </script>
<script src="{{URL('assets')}}/js/App.js?v={{config('system.cache_version')}}"> </script>
@yield("script")
</body>
</html>
