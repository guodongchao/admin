@extends('admin.layout')
@section('content')
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {

            align-items: center;
            display: flex;
            justify-content: center;

        }

        .position-ref {

            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            margin: 250px;
            font-size: 84px;
            width: 1000px;
            border: 1px solid black;
            background: #eee;
            color: red;
            text-align: center;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {

            margin-bottom: 30px;
        }
    </style>
    <body>
    <div class="flex-center position-ref ">

        <div class="content">
            <div class="title m-b-md">
               你没有权限！
            </div>

            
        </div>
    </div>
    </body>
@endsection


