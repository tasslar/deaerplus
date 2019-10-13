<!doctype html>
<html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>DealerPlus-Login</title>
        <link rel='shortcut icon' href='img/dealerplus_fav.ico' type='image/x-icon'/ >

              <!-- Font awesome -->
              <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="{{URL::asset('css/awesome-bootstrap-checkbox.css')}}">
        <!-- Admin Stye -->
        <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
        <link href="{{URL::asset('css/owl.carousel.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('css/owl.theme.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('css/owl.transitions.css')}}" rel="stylesheet" type="text/css"/>

        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <style type="text/css">
            #login label.error{
                color:red;
            }
            #login input.error{
                border: 1px solid red;
            }
            .error {
                border: 1px solid red;
            }
        </style>
        <script type="text/javascript">
            window.$zopim || (function (d, s) {
                var z = $zopim = function (c) {
                    z._.push(c)
                }, $ = z.s =
                        d.createElement(s), e = d.getElementsByTagName(s)[0];
                z.set = function (o) {
                    z.set.
                            _.push(o)
                };
                z._ = [];
                z.set._ = [];
                $.async = !0;
                $.setAttribute("charset", "utf-8");
                $.src = "https://v2.zopim.com/?4f5oYU5I4KRUTVisP6jhEKm5qASgwOza";
                z.t = +new Date;
                $.
                        type = "text/javascript";
                e.parentNode.insertBefore($, e)
            })(document, "script");
        </script>
        <!-- start Mixpanel --><script type="text/javascript">(function (e, a) {
                if (!a.__SV) {
                    var b = window;
                    try {
                        var c, l, i, j = b.location, g = j.hash;
                        c = function (a, b) {
                            return(l = a.match(RegExp(b + "=([^&]*)"))) ? l[1] : null
                        };
                        g && c(g, "state") && (i = JSON.parse(decodeURIComponent(c(g, "state"))), "mpeditor" === i.action && (b.sessionStorage.setItem("_mpcehash", g), history.replaceState(i.desiredHash || "", e.title, j.pathname + j.search)))
                    } catch (m) {
                    }
                    var k, h;
                    window.mixpanel = a;
                    a._i = [];
                    a.init = function (b, c, f) {
                        function e(b, a) {
                            var c = a.split(".");
                            2 == c.length && (b = b[c[0]], a = c[1]);
                            b[a] = function () {
                                b.push([a].concat(Array.prototype.slice.call(arguments,
                                        0)))
                            }
                        }
                        var d = a;
                        "undefined" !== typeof f ? d = a[f] = [] : f = "mixpanel";
                        d.people = d.people || [];
                        d.toString = function (b) {
                            var a = "mixpanel";
                            "mixpanel" !== f && (a += "." + f);
                            b || (a += " (stub)");
                            return a
                        };
                        d.people.toString = function () {
                            return d.toString(1) + ".people (stub)"
                        };
                        k = "disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
                        for (h = 0; h < k.length; h++)
                            e(d, k[h]);
                        a._i.push([b, c, f])
                    };
                    a.__SV = 1.2;
                    b = e.createElement("script");
                    b.type = "text/javascript";
                    b.async = !0;
                    b.src = "undefined" !== typeof MIXPANEL_CUSTOM_LIB_URL ? MIXPANEL_CUSTOM_LIB_URL : "file:" === e.location.protocol && "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//) ? "https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js" : "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";
                    c = e.getElementsByTagName("script")[0];
                    c.parentNode.insertBefore(b, c)
                }
            })(document, window.mixpanel || []);
            mixpanel.init("cca53a159f40b2e49dc055cde26418c6");</script><!-- end Mixpanel -->
    </head>

    <body>
        <header class="col-xs-12">
            <div class="row">
                <div class="guestheader_div col-xs-12">
                    <div class="col-sm-3 col-xs-6">
                        <a href="<?= URL::to('http://www.dealerplus.in/index.html') ?>"><img src=" {{URL::asset('img/logo.png')}}" alt="Logo" title="Logo" class="img-responsive guestlogo" width="250"/></a>
                    </div>
                    <div class="col-xs-6 col-sm-8 text-right mt">
                        <span>Don't have an account? </span><a href="<?= URL::to('http://www.dealerplus.in/pricingpage.html') ?>"> Sign Up <i class="fa fa-sign-in" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </header>
        <div class="login-page">
            <div class="form-content">
                <div class="col-sm-8 col-xs-12 pt-2x pb-3x">
                    <h1 class="text-center text-bold text-dark mt-4x">Sign in</h1>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            @if (Session::has('message'))
                            <div class="alert alert-danger">{{ Session::get('message') }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
                            </div>
                            @endif
                            @if (Session::has('message_success'))
                            <div class="alert alert-success">{{ Session::get('message_success') }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
                            </div>
                            @endif							
                            <form id="login" action="{{url('loginprocess')}}" class="mt" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="" class="text-uppercase text-sm">Your  Email</label>
                                    <input type="mail" name="email" placeholder="Email" class="form-control" data-validation="email,length" data-validation-optional="false" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please enter email id" value="{{old('email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="" class="text-uppercase text-sm">Password</label>
                                    <input type="password" name="password" placeholder="Password" class="form-control" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please enter correct password">
                                </div>
                                <div class="checkbox checkbox-circle checkbox-info">
                                    <input id="remember" type="checkbox" name="remember">
                                    <label for="remember">
                                        Keep me signed in
                                    </label>
                                    <a href="{{url('forgetpassword')}}" class="pull-right">Forgot password?</a>
                                </div>

                                <button class="btn btn-primary btn-block" type="submit">LOGIN</button>

                            </form>
                            <p class="text-center">Don't Have An Account? <a href="http://www.dealerplus.in/pricingpage.html">Register Now.</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 pt-3x pb-4x" style="background: #183055;">
                    <div class="row pt-2x pb-3x mt-4x" id="demo">
                        <div id="owl-login" class="owl-carousel col-xs-12">
                            <div class="item">
                                <h3>Search</h3>
                                <img src="{{URL::asset('img/1_search.png')}}"/>
                                <p>Unified and simplified search mechanism.</p>
                            </div>
                            <div class="item">
                                <h3>Online Presence</h3>
                                <img src="{{URL::asset('img/5_Online Presence.png')}}"/>
                                <p>Helps dealers build faster online presence.</p>
                            </div>
                            <div class="item">
                                <h3>Speed</h3>
                                <img src="{{URL::asset('img/2_speed.png')}}"/>
                                <p>Faster Business Processes that improves customer satisfaction.</p>
                            </div>
                            <div class="item">
                                <h3>Multiplatform</h3>
                                <img src="{{URL::asset('img/4_web&mobile.png')}}"/>
                                <p>Multi-Platform access to information like Web and Mobile.</p>
                            </div>
                            <div class="item">
                                <h3>Marketplace</h3>
                                <img src="{{URL::asset('img/3_marketplace.png')}}"/>
                                <p>Instant Publish to Marketplaces.</p>
                            </div>
                            <div class="item">
                                <h3>Salesforce</h3>
                                <img src="{{URL::asset('img/6_salesforce.png')}}"/>
                                <p>Efficient Management of internal and external sales representation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('login_footer')


        <!-- Loading Scripts -->
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
        <script src="{{URL::asset('js/owl.carousel.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
        <script src="{{URL::asset('js/dealerplus.js')}}"></script>

        <script>
$(document).ready(function ($) {
    $("#owl-login").owlCarousel({
        autoPlay: 3000,
        stopOnHover: true,
        navigation: false,
        pagination: false,
        paginationSpeed: 1000,
        goToFirstSpeed: 300,
        singleItem: true,
        //        autoHeight: true,
        transitionStyle: "fade"
    });
});
        </script>

<!--	<script type="text/javascript">
        $("document").ready(function(){
                $("#login").validate({
                                rules:{
                                        'email':{
                                                required:true,

                                        },
                                        'password':{
                                                required:true,
                                        }
                                },
                                /*messages:{
                                        'fname':{
                                                required:"Please Enter first name",
                                        },
                                        'password':{
                                                required:"Please Enter password"
                                        }
                                }*/
                                highlight: function(input) {
                        $(input).addClass('error');
                        },errorPlacement: function(error, element){}
                });
        });
        </script>-->
    </body>
    
</html>