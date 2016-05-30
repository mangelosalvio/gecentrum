<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GC Appliance Centrum</title>

    <!-- Fonts -->
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>--}}

    <!-- Styles -->
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">--}}

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')  }}"/>
    <link rel="stylesheet" href="{{ asset('bower_components/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css')  }}"/>
    <link rel="stylesheet" href="{{ asset('bower_components/startbootstrap-sb-admin-2/dist/css/timeline.css')  }}"/>
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')  }}"/>


    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap-datepicker3.min.css')  }}"/>
    <link rel="stylesheet" href="{{ asset('bower_components/typeahead.js/dist/typeahead.css')  }}"/>

    <style>
        body {
            font-family: 'Lato', Arial, Helvetica, sans-serif;
        }

    </style>
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/metisMenu/dist/metisMenu.js') }}"></script>

    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('bower_components/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js') }}"></script>

    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('bower_components/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

    <script>
        $.fn.datepicker.defaults.todayHighlight = true;
        $.fn.datepicker.defaults.autoclose = true;
    </script>
</head>
<body id="app-layout">
    @include('menu')
    @yield('content')
    @include('developer')

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    @include('scripts.product_ac')
</body>

</html>
