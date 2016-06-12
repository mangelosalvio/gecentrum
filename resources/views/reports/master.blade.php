<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GC Appliance Centrum</title>

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')  }}"/>
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')  }}"/>

    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script>
        function printPage() { print(); } //Must be present for Iframe printing
    </script>

    <style>
        body {
            font-family: 'Lato', Arial, Helvetica, sans-serif;
        }

        .table-content {
            width:100%;
            border-collapse: collapse;
        }
        .table-content td, .table-content th{
            border:1px solid #000;
            padding:3px;
        }
        .table-content tfoot td{
            border-top: 3px solid #000;
        }
        @media print {
            body { font-size: 8px; }
        }
    </style>
</head>
<body id="app-layout">
@yield('content')
</body>

</html>
