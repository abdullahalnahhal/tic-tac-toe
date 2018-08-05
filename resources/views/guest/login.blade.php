
@extends('layouts.main')
@section('content')
        <!-- Home -->
        <div id="home" class="hero-area">

            <!-- Backgound Image -->
            <div class="bg-image bg-parallax overlay" style="background-image:url(./img/home-background.jpg)"></div>
            <!-- /Backgound Image -->

            <div class="home-wrapper">
                <div class="container">
                    <div class="row">
                        <form method="POST" action="user/login" id="login" class="login" type='login'>
                            <div class="col-sm-offset-2 col-md-8" style="min-height: 14em;border: 2px solid #ffffff ; border-top-right-radius: 3em; border-bottom-left-radius: 3em;">
                                <br>
                                <div class="col-xs-12 form-group">
                                    <input type="file" maxsize="15" name="email" id="email" class=" email form-control" required>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <input type="password" name="password" id="password" class="password form-control" required>
                                </div>
                                <div class="col-xs-6 col-xs-offset-3 form-group">
                                    <div class="btn btn-lg col-xs-12 btn-warning" id="submit" > {{trans('main.save')}} </div>
                                </div>
                                <br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Home -->
@endsection



