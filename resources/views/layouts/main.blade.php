<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>HTML Education Template</title>

        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>

        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}">

        <!-- Custom stlylesheet -->
        <link type="text/css" rel="stylesheet" href="{{asset('/css/style.css')}}"/>

        <link rel="shortcut icon" href="{{asset('/img/tic-tac-toe.png')}}" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @stack('css')
    </head>
    <body>


    	@yield('content')
        <!-- jQuery Plugins -->
        <script type="text/javascript" src="{{asset('/js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/main.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/form-control.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/index.js')}}"></script>
        @stack('js')
    </body>
</html>