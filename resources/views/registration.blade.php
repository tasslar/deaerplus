<!doctype html>
<html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>DealerPlus-Registration</title>

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
        <!-- start Mixpanel --><script type="text/javascript">(function(e, a){if (!a.__SV){var b = window; try{var c, l, i, j = b.location, g = j.hash; c = function(a, b){return(l = a.match(RegExp(b + "=([^&]*)")))?l[1]:null}; g && c(g, "state") && (i = JSON.parse(decodeURIComponent(c(g, "state"))), "mpeditor" === i.action && (b.sessionStorage.setItem("_mpcehash", g), history.replaceState(i.desiredHash || "", e.title, j.pathname + j.search)))} catch (m){}var k, h; window.mixpanel = a; a._i = []; a.init = function(b, c, f){function e(b, a){var c = a.split("."); 2 == c.length && (b = b[c[0]], a = c[1]); b[a] = function(){b.push([a].concat(Array.prototype.slice.call(arguments,
                    0)))}}var d = a; "undefined" !== typeof f?d = a[f] = []:f = "mixpanel"; d.people = d.people || []; d.toString = function(b){var a = "mixpanel"; "mixpanel" !== f && (a += "." + f); b || (a += " (stub)"); return a}; d.people.toString = function(){return d.toString(1) + ".people (stub)"}; k = "disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
            for (h = 0; h < k.length; h++)e(d, k[h]); a._i.push([b, c, f])}; a.__SV = 1.2; b = e.createElement("script"); b.type = "text/javascript"; b.async = !0; b.src = "undefined" !== typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:" === e.location.protocol && "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js"; c = e.getElementsByTagName("script")[0]; c.parentNode.insertBefore(b, c)}})(document, window.mixpanel || []);
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
                        <span>Already have an account? </span><a href="<?= URL::to('/login') ?>"> Sign In <i class="fa fa-sign-in" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </header>

        <section class="col-xs-12 bk-img">
            <div class="container">


                @if($errors->has('dealer_name') || $errors->has('d_email') || $errors->has('periodselection') || $errors->has('d_mobile')|| $errors->has('dealership_name') || Session::has('message-err')) 
                <div id="message-err" class="alert alert-danger">{{ $errors->first('dealer_name') }} {{ $errors->first('d_email') }} {{ $errors->first('dealership_name') }} {{ $errors->first('d_mobile') }} {{ $errors->first('periodselection') }} {{ Session::get('message-err') }} 
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                @endif
                
                <div class="alert alert-danger" id="plan_err" style="display: none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                
                @if (Session::has('message'))
                <div id="message-succ" class="alert alert-success">{{ Session::get('message') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                @endif
                <!-- @if (Session::has('message-err'))
                <div class="alert alert-danger">{{ Session::get('message-err') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                @endif -->

                <form id="register" method="POST" action="user_register_store" >
                    <div class="login-page">
                        <div class="col-xs-12 bk-light">

                        </div> 
                    </div> 
                    <div class="login-page">
                        <div class="col-xs-12 bk-light">
                            <div class="col-md-7 col-xs-12 ordersum">
                                <h2 class="text-center"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registration</h2>
                                <div class="col-xs-12 card">
                                    <div class="col-xs-10 col-xs-offset-1 bk-light">
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <div class="form-group field-wrapper1">
                                            <label>Name</label>
                                            <input type="text" placeholder="Name" class="form-control data-name validate-space" name="dealer_name" id="dealer_name" maxlength="50" tabindex="1" data-validation="alphanumeric,required" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-error-msg="Please Enter Name" value="{{old('dealer_name')}}">
                                        </div>
                                        <div class="form-group field-wrapper1">
                                            <label>Contact Number</label>
                                            <input type="tel" placeholder="Contact Number" class="form-control data-number" name="d_mobile" id="d_mobileno" maxlength="11" tabindex="2" data-validation="required,length" data-validation-optional="false" data-validation-length="8-11" data-validation-error-msg="Enter mobile number" value="{{old('d_mobile')}}"></div>
                                        <div class="form-group field-wrapper1">
                                            <label>Email Id</label>
                                            <input type="mail" placeholder="Email Id" class="form-control validate-space" name="d_email" id="d_email" maxlength="50" tabindex="3" data-validation="required,email" data-validation-optional="false" data-validation-error-msg="Enter correct email id" value="{{old('d_email')}}">
                                        </div>
                                        <div class="form-group field-wrapper1">
                                            <label>Dealership Name</label>
                                            <input type="text" placeholder="Dealership Name" class="form-control data-name validate-space" name="dealership_name" id="dealership_name" maxlength="50" tabindex="4" data-validation="alphanumeric,required" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-error-msg="Please Enter Dealershipname" value="{{old('dealership_name')}}">
                                        </div>
                                        <!-- <input type="text" placeholder="Dealer Number" class="form-control"> -->
                                        <div class="form-group field-wrapper1">
                                            <label>Select your City</label>
                                            <select class="form-control" name="d_city" tabindex="5" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Select Your City">
                                                <option selected="true" disabled="disabled">Select your City</option>
                                                @foreach($city_list as $fetch)
                                                <option value="{{$fetch->master_id}}">{{$fetch->city_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group field-wrapper1">
                                            <label>How did you hear about us?</label>
                                            <select class="form-control" name="hear_us" tabindex="" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Select Your Choice ">
                                                <option selected="true" disabled="disabled">Select Your Choice</option>
                                                <option value="Google Ads">Google Ads</option>
                                                <option value="Search">Search</option>
                                                <option value="Facebook">Facebook</option>
                                                <option value="Trade Show">Trade Show</option>
                                                <option value="Dealer Referral">Dealer Referral</option>
                                                <option value="Others">Others</option>

                                            </select>
                                        </div>

                                        <div class="row orderdiv">
                                                <input type="checkbox" id="termcheckid" name="termcheckid" /> I agree to <a href="<?=URL::to('http://www.dealerplus.in/terms_conditions.html')?>" target="_blank" tabindex="7">Terms and Conditions</a> and <a href="<?=URL::to('http://www.dealerplus.in/privacy_policy.html')?>" target="_blank" tabindex="7">Privacy Policy</a>
                                        </div>

                                        <!-- <p>Already Have An Account? <a href="<?= URL::to('/login') ?>">Login Now.</a></p> -->

                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-5">
                                <div class="selectbuy col-xs-12">
                                    <h2 class="text-center"><i class="fa fa-credit-card" aria-hidden="true"></i> Buy Plan</h2>
                                    <div class="card col-xs-12">
                                        <ul class="nav nav-tabs row" role="tablist" name="plan">

                                            @foreach ($d_planlist as $plan)
                                            @if($plan->plan_type_id == $planid)
                                            @php ($planactive = 'active')
                                            @else
                                            @php ($planactive = '') 
                                            @endif
                                            @php ($d_plan_id = $plan->plan_type_id)
                                            @php ($plan_name = $plan->plan_type_name)
                                            <li role="presentation" class="{{$planactive}}"><a tabindex="6" class="form-control anchorplanlist"  href="#{{$plan->plan_type_name}}" aria-controls="fyear" role="tab" data-toggle="tab">{{$plan->plan_type_name}}</a></li>

                                            @endforeach
                                        </ul>


                                        <!-- Tab panes -->
                                        <div class="tab-content ">

                                            @php ($d_plan_id = '')
                                            @php ($sno = 0)
                                            @php ($frequency_listno = '0')
                                            @foreach ($d_planlist as $plan) 
                                            @php ($sno++)
                                             @php ($activestatus = '')
                                            
                                            @if ($sno == '1') 
                                             @php ($activestatus = 'active')
                                             @php ($selectstatus = 'selected')
                                            @endif
                                            @if($plan->plan_type_id == $planid) 
                                             @php ($activestatus = 'active')
                                             @php ($selectstatus = 'selected')
                                            @else
                                             @php ($activestatus = '')
                                             @php ($selectstatus = '')
                                            @endif
                                            @php ($plan_name = $plan->plan_type_name)

                                            <div role="tabpanel" class="tab-pane {{$activestatus}} col-xs-12" id="{{$plan->plan_type_name}}">

                                                <span class="col-xs-12 pull-left text-c enter btn btn-primary mb" data-toggle="modal" data-target="#{{$plan->plan_type_name}}plan"><i class="fa fa-file-text-o" aria-hidden="true"></i> Plan Details</span>
                                                @foreach ($frequency_list[$plan_name] as $plan) 
                                                @php ($frequency_listno++)
                                                @if($plan_name != "BASIC")

                                                <div class="col-xs-12">
                                                    <div class="radiostylebtn">
                                                        <input type="hidden" name="plan_type" id="plan_type" data-val="{{$plan_name}}" val="{{$plan_name}}">

                                                        <input type="radio" {{$selectstatus}}  class=" form-control period" data-plan="{{$plan_name}}" name="period" data-sub="{{$plan['subscription_plan_id']}}" data-frq="{{$plan['frequency_id']}}" data-amt="{{$plan['plan_amount']}}" data-id="{{$plan['frequency_interval'].' '. $plan['frequency_name']}}" id="subs-{{$plan['subscription_plan_id']}}" value="{{$plan['frequency_interval']}}">

                                                        <label for="subs-{{$plan['subscription_plan_id']}}">{{$plan['frequency_desc']}}</label>
                                                        <div class="check"></div>
                                                        @if($plan['plan_amount'] != "0")
                                                          <span id="plan_amount" class="fa fa-rupee">&nbsp;&nbsp;{{$plan['plan_amount']}}</span>
                                                        @else
                                                          <span id="plan_amount" class="">&nbsp;&nbsp;{{$freeVal}}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                                @else

                                                <div class="col-xs-12">
                                                    <div class="radiostylebtn">
                                                        <input type="hidden" name="plan_type" id="plan_type" data-val="{{$plan_name}}" val="{{$plan_name}}">

                                                        <input {{$selectstatus}} type="radio"  class=" form-control period" data-plan="{{$plan_name}}" name="period" data-sub="{{$plan['subscription_plan_id']}}" data-frq="{{$plan['frequency_id']}}" data-amt="{{$plan['plan_amount']}}" data-id="{{$plan['frequency_interval'].' '. $plan['frequency_name']}}" id="subs-{{$plan['subscription_plan_id']}}" value="{{$plan['frequency_interval']}}">

                                                        <label for="subs-{{$plan['subscription_plan_id']}}">{{$plan['frequency_desc']}}</label>
                                                        <div class="check"></div>
                                                       
                                                    </div>
                                                </div> 
                                                @endif   
                                                @endforeach

                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                   
                                </div>
                                @foreach ($d_planlist as $planterm) 
                                <div class="modal fade" id="{{$planterm->plan_type_name}}plan" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">{{$planterm->plan_type_name}} Plan</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="col-xs-12"><div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title">plan details</h3>
                                                                </div>
                                                                <div class="panel-body regispop">
                                                                    <ul>

                                                                        @foreach ($feature_list[$planterm->plan_type_name] as $plan)
                                                                        @if($plan['feature_allowed'] == 'Y')
                                                                        <li><i class="fa fa-check true" aria-hidden="true"></i>{{'  '.$plan['feature_desc'].' '.$plan['plan_feature_desc']}}</li>
                                                                        @else
                                                                        <li><i class="fa fa-close false" aria-hidden="true"></i>{{'  '.$plan['feature_desc'].' '.$plan['plan_feature_desc']}}</li>
                                                                        @endif
                                                                        @endforeach


                                                                    </ul>
                                                                </div>
                                                            </div>

                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                
                                    <div class="col-xs-12 ordersum orderhide ">
                                    <div class="row">
                                      <h2 class="text-center"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Summary </h2>
                                        <div class="col-xs-12 card">
                                            <div class="row orderdiv">
                                            @if($pricePlanData['key']!='Pricing')
                                                <span class="pull-right closeplan"><i class="fa fa-retweet" aria-hidden="true"></i> Change Plan</span>
                                            @endif
                                                <span class="pull-right plandetail" id="btn_plandetail" data-toggle="modal" data-target=""><i class="fa fa-file-text-o" aria-hidden="true"></i> Plan Details</span>
                                            </div>
                                            <div class="row orderdiv">
                                                <em>You are Purchasing</em>
                                                <p>
                                                <mark id="amt_mark"> </mark>
                                                <mark id="plan_mark"></mark> 
                                                <mark id="plan_mark_view" class="fa fa-rupee">&nbsp;&nbsp;</mark>
                                                </p>
                                            </div>

                                            <div class="row orderdiv coupondiv">
                                                <input type="text" id="coupon_val" placeholder="Have a coupon ?"/>

                                                <input type="button" id="coupon_apply" name="coupon_btn" value="APPLY"><i class="round fa fa fa-spinner fa-spin" style="font-size:20px" style="display: none;"></i>
                                                <span id="coupon_msg" class="label label-success" style="display: none;">Coupon Applied</span>
                                                <span id="coupon_errmsg" class="label label-danger" style="display: none;"></span>
                                            </div>
                                            <hr class="coupondiv">
                                            <h4 class="coupondiv">Your Order Total</h4>
                                            <hr class="coupondiv">
                                            <div class="row orderdiv coupondiv">
                                                <p>sub Total<span id="amt_mark_sub" class="fa fa-rupee"></span></p>
                                                <p>Coupon Discount<span id="coupen_amt" class="fa fa-rupee"></span></p>
                                                <hr>
                                                <p>Payable Amount<span id="total_payable_amt" class="fa fa-rupee"> 0<i>(Inclusive of taxes)</i></span></p>
                                            </div>
                                            <hr class="coupondiv">
                                                                     
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 ">
                                  <div class="bk-light">
                                    <button class="btn btn-primary" id="submitbtn" type="submit" name="submitbtn" tabindex="8">PROCEED TO PAYMENT</button> 
                                  </div>
                                </div>
                                

                            </div>

                             <input type="hidden" id="subscription_plan_id" name="subscription_plan_id" value="">
                             <input type="hidden" id="frequency_id" name="frequency_id" value="">
                             <input type="hidden" id="payment" name="payment" value="">
                             <input type="hidden" id="periodselection" name="periodselection" value="">
                            <input type="hidden" name="urplanid" id="urplanid" value="{{$planid}}">
                            <input type="hidden" id="coupon_code" name="coupon_code">
                            <input type="hidden" id="coupon_amount" name="coupon_amount"/>
                            <input type="hidden" name="plan_duration" id="plan_duration" value="">        
                            <input type="hidden" name="plan_amt" id="plan_amt" value="">
                            <input type="hidden" name="coupen_amount" id="coupen_amount" value="">
                            <input type="hidden" name="payable_amount" id="payable_amount" value="">
                            <!-- <div class="col-xs-12 ">
                                <div class="bk-light">
                                    <button class="btn btn-primary" id="submitbtn" type="submit" name="submitbtn" tabindex="8">PROCEED TO PAYMENT</button> (or)
                                    <button class="btn btn-primary" id="trial" type="" name="trial" tabindex="9">TRY A FREE TRIAL</button>
                                
                                </div>
                            </div> -->
                        </div>



                </form>
            </div>
        </section>


        <!--</section>-->


        @include('login_footer')


        <div class="modal fade" id="terms" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" tabindex="">Terms and Conditions</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 bid-title">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Loading Scripts -->
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery.form-validator.min.js"></script>
<script src="js/dealerplus.js"></script>
<script src="js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="js/label-slide.js" type="text/javascript"></script>
<script type='text/javascript'>
// <![CDATA[
$(window).on('load', function() {
 // code here
 $(".round").hide();
 @if($pricePlanData['key']=='Pricing')
 $("#subs-{{$priFreq_id}}").click();
@endif
$('#submitbtn').html('Get Started');
});      
            jQuery(document).ready(function () {
               $(".round").hide();   
               $("#submitbtn").attr('disabled',true);             

            $("#subs-6").click();
            $("#coupen_amt").text(0);
            $("#message-err").fadeIn(2000, function ()
            {
            $(this).delay(4000).fadeOut(2000);
            });
            $("#message-succ").fadeIn(2000, function ()
            {
            $(this).delay(4000).fadeOut(2000);
            });
            $(".anchorplanlist").click(function(e){
            var pval = $(this).attr('href');
            $("#btn_plandetail").attr('data-target', pval + "plan");
            });
            $('#trial').removeAttr('href');
            
            $("#submitbtn").click(function (e) {
                
            $("#message-succ").hide();
            var temp = 0;
            var msg = "";
            if ($('#dealer_name').val() == "" && $('#d_email').val() == "" && $('#d_mobileno').val() == "") {
            msg = "All fields are required. ";
            temp++;
            }
            if ($("input[type=radio]:checked") == false) {
            msg += " Please select one plan. ";
            temp++;
            }
            if ($('#termcheckid').prop("checked") == false) {
            msg += " Please Check Terms and Conditions. ";
            temp++;
            }
            if (temp > 0)
            {
            
            $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').delay(2000).fadeOut(2000);
            
            $('html, body').animate({
            scrollTop: ($('.container').offset().top - 500)
            }, 0);
            return false;
            } else {
            $("#register").submit();
            }
            });
            $("#trial").click(function (e) {
            e.preventDefault();
            var msg = "";
            if ($('#dealer_name').val() == "" && $('#d_email').val() == "" && $('#d_mobileno').val() == "")
            {
            msg = "All fields are required. ";
            $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').delay(2000).fadeOut(2000);
            return false;
            } else {
            var plan_data = "14 Days";
            $("#plan_duration").val(plan_data);
            $("#payment").val('0');
            $("#subscription_plan_id").val('1');
            $("#frequency_id").val('1');
            $("#register").submit();
            }
            });
            $("#coupon_apply").click(function(e){
            //alert("coupon apply")
             $(".round").show();
            var csrf_token = $('#token').val();
            var cval = $("#coupon_val").val();
            var csub_tot = $("#amt_mark_sub").text();
            var cpay_amt = $("#total_payable_amt").text();

            $.ajax({
            url: 'coupon_data',
                    type: 'post',
                    dataType: 'json',
                    data: {_token: csrf_token, c_val: cval, c_subtot: csub_tot, c_payamt:cpay_amt},
                    success: function (response)
                    {
                    if (response.res_msg == 1)
                    {
                            $(".round").hide();
                            var coupon_amt = response.coupon_amt;
                            $("#coupen_amt").text(coupon_amt)
                            $("#coupon_amount").val(coupon_amt)
                            $("#coupon_code").val(cval)
                            var total_payable_amt = parseInt(csub_tot) - coupon_amt;
                            $("#total_payable_amt").text(total_payable_amt);
                            $("#coupon_msg").show(function(){
                              $("#coupon_msg").delay(2000).hide(500)
                            $("#coupen_amt").text(coupon_amt)
                           });
                    }
                    else if (response.res_msg == 0)
                    {
                         $(".round").hide();
                         $("#coupon_errmsg").text(response.message)
                            $("#coupon_errmsg").show(function(){
                                $("#coupon_errmsg").delay(2000).hide(500);
                                $("#coupen_amt").text(0)
                            });

                    /*$("#plan_err").show().html(response.message + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');*/
                    }
                    $('html, body').animate({
                    scrollTop: ($('.container').offset().top - 500)
                    }, 0);
                    return false;
                    },
                    error: function (e)
                    {
                    console.log("error");
                    }
            });
            });
            $(".period").click(function () {
                $("#submitbtn").attr('disabled',false);
            var frequency_id = $(this).attr("data-frq");
            
            var plan_name = $(this).attr("data-plan");
            $("#btn_plandetail").attr('data-target','#'+plan_name+'plan')
         
            var plan_data = $(this).attr("data-id");
            
            var plan_amt = $(this).attr("data-amt");
            
            if(plan_amt<=0 && plan_name=="BASIC")
            {

                $('.coupondiv').hide();
                $('#submitbtn').html('Get Started');
                $("#plan_mark_view").text("FREE");
                $("#plan_mark").hide()

            }
            else if(plan_amt<=0 && plan_name!="BASIC")
            {
                 $('.coupondiv').hide();
                $('#submitbtn').html('Get Started');
                $("#plan_mark_view").text("FREE");
                $("#plan_mark").show()
            }
            else
            {
                $('#submitbtn').html('PROCEED TO PAYMENT');
                $('.coupondiv').show();  
                $("#plan_mark_view").text(plan_amt);    
            }
            var subscription_plan_id = $(this).attr("data-sub");
            var coupen_val = 0;
            $("#amt_mark").text(plan_name);
            $("#amt_mark_sub").text(plan_amt);
            $("#plan_mark").text(plan_data);
            
            $("#coupen_amt").text(coupen_val);
            $("#total_payable_amt").text(parseInt(plan_amt) - parseInt(coupen_val));
            $("#payment").val(plan_amt);
            $("#subscription_plan_id").val(subscription_plan_id);
            $("#frequency_id").val(frequency_id);
            $("#plan_duration").val(plan_data);
            $("#plan_amt").val(plan_amt);
            $("#coupen_amount").val(coupen_val);
            $('#periodselection').val(1);
            $("#payable_amount").val(parseInt(plan_amt) - parseInt(coupen_val));
            $('.orderhide').slideDown(1000);
            $('.selectbuy').slideUp(1000);
//$(this).prop('checked', false);
            });
            $('.closeplan').click(function () {
                $("#submitbtn").attr('disabled',true); 
                $('#periodselection').val('');  
            $('.orderhide').slideUp(1000);
            $('.selectbuy').slideDown(1000);
            });
            $('.orderhide').slideUp(0);
            });</script>
</body>
 
</html>