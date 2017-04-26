<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SGVC - Sistema de Gestão e Vigência de Contratos</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/css/minified/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/css/minified/core.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/css/minified/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/css/minified/colors.min.css') }}" rel="stylesheet" type="text/css">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
    <!-- /global stylesheets -->
    <link rel="icon" href="{{ asset('public/favicon.ico') }}">

</head>

<body>

@include('layouts.partials.navbar')

<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        @include('layouts.partials.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">


                @yield('content')

                @include('layouts.partials.footer')

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
<!-- Core JS files -->
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/loaders/pace.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/core/libraries/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/core/libraries/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/loaders/blockui.min.js') }}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/ui/moment/moment.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/assets/js/plugins/forms/validation/validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/forms/validation/additional_methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/forms/validation/localization/messages_pt_BR.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/forms/selects/select2.min.js') }}"></script>
@yield('scripts-after')
<script type="text/javascript" src="{{ asset('public/assets/js/core/app.js') }}"></script>
@yield('scripts-before')
<!-- /theme JS files -->
</body>
</html>
