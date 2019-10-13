@include('header')
        <div class="ts-main-content">
                @include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="container-fluid">
                    <div class="row">
                        <div class="content-header col-sm-12">
                            <ol class="breadcrumb">
                                <li><a href="myprofile.html"><i class="fa fa-dashboard"></i> Manage</a></li>
                                <li class="active">Subscription</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">
                            <!--                            <h2 class="page-title">Subscription</h2>-->
                        <div class="alert alert-danger" id="plan_err" style="display: none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        <div class="alert alert-success" id="msg_data" style="display: none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                       
                   

                            <div class="col-xs-12 col-xs-offset-0  col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 ordersum orderhide ">
                                <div class="row">
                                <form id="change_subscription" name="form1" method="post" action="change_subscription">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                    <h2 class="text-center"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Summary </h2>
                                    <div class="col-xs-12 card">
                                        <div class="row orderdiv">
                                            <a href="{{url('managesubscription')}}"><span class="pull-right closeplan"><i class="fa fa-retweet" aria-hidden="true"></i> Change Plan</span></a><span class="pull-right plandetail" data-toggle="modal" data-target="#plandetail"><i class="fa fa-file-text-o" aria-hidden="true"></i> Plan Details</span>
                                        </div>
                                        <div class="row orderdiv">
                                        <em>You are purchasing</em>
                                        <p id="new_plan"><mark>{{$payment_data['new_planname']}}</mark> {{$payment_data['new_freqdesc']}}<i class="fa fa-arrow-circle-right"></i><span class="fa fa-rupee" id="unit_cost">{{$payment_data['unit_cost']}}</span></p>
                                        <p> Total Cost of Selected plan <span class="fa fa-rupee" id="newtot_cost">{{$payment_data['tot_comput_cost']}}</span></p>
                                        <p> Total Number of Users Selected <i class="fa fa-arrow-circle-right"></i><span>{{$payment_data['total_users']}}</span></p>
                                        <p> Total Credits Available <i class="fa fa-arrow-circle-right"></i><span>{{$payment_data['credit_balance']}}</span></p>

                                        </div>
                                     
                                        
                                 
                                        <!-- <hr>
                                        <h4>Your Order Total</h4>
                                        <hr> -->
                                        <div class="row orderdiv">
                                            <p>Number Of Users Added Now <span class="fa">{{$payment_data['users_added_now']}}</span></p>
                                            <p>Balance From Previous Plan<span class="fa fa-rupee">{{$payment_data['balcost_alluser']}}</span></p>
                                            <p>Pro Rata Amount to be paid now<span class="fa fa-rupee">{{$payment_data['prorata_cost']}}</span></p>
                                            <p>Sub Total<span class="fa fa-rupee" name="sub_tot" id="sub_tot">{{$payment_data['sub_total']}}</span></p>
                                            @if($payment_data['sub_total'] > 0)
                                            <div class="row orderdiv">
                                            
                                            <input type="text" id="coupon_val" placeholder="Have a coupon ?"/>
                                            <a class="btn btn-sm btn-primary " id="coupon_apply">APPLY</a><i class="round fa fa fa-spinner fa-spin" style="font-size:20px" style="display: none;"></i>
                                            <span id="coupon_msg" class="label label-success" style="display: none;">Coupon Applied</span>
                                            <span id="coupon_errmsg" class="label label-danger" style="display: none;"></span>
                                            </div>

                                            <p>Coupon Discount<span id="coupen_amt" class="fa fa-rupee"></span></p>
                                            <hr>
                                            @endif
                                            <p>Credit Applied<span class="fa fa-rupee">{{$payment_data['creditsApplied']}}</span></p>
                                            <p>Credit Refund<span class="fa fa-rupee">{{$payment_data['creditsToBeAdded']}}</span></p>
                                            <p>Credit Balance<span class="fa fa-rupee">{{$payment_data['new_credit_balance']}}</span></p>
                                            
                                            <p>Payable Amount<i>(Inclusive of taxes)</i><span class="fa fa-rupee" id="payable_amt">{{$payment_data['nowpaid_cost']}}</span></p>
                                            <input type="hidden" name="_ttoken" id="ttoken" value="{{ csrf_token() }}">
                                    <input type="hidden" name="new_planid" id="new_planid" value="{{$payment_data['new_planid']}}">
                                    <input type="hidden" name="new_planval" id="new_planval" value="{{$payment_data['new_planname']}}">
                                    <input type="hidden" name="new_freq_desc" id="new_freq_desc" value="{{$payment_data['new_freqdesc']}}">
                                     <input type="hidden" name="new_freq_id" id="new_freq_id" value="{{$payment_data['new_freqid']}}">
                                   <input type="hidden" name="new_freq_interval" id="new_freq_interval" value="{{$payment_data['new_freq_int']}}">
                                   
                                   <input type="hidden" name="max_user" id="max_user" value="{{$payment_data['total_users']}}">
                                    <input type="hidden" name="old_subid" id="old_subid" value="{{$payment_data['old_id']}}">
                                    <input type="hidden" name="old_subscription_id" id="old_subscription_id" value="{{$payment_data['old_id']}}">
                                    <input type="hidden" name="new_subscription_id" id="new_subscription_id" value="{{$payment_data['new_id']}}">


                                    <input type="hidden" id="coupon_code" name="coupon_code">
                                    <input type="hidden" id="coupon_amount" name="coupon_amount"/>
                                  
                                    
                                    
                                    
                                        </div>
                                        <hr>
           
                                        <div class="row orderdiv">
                                            <input type="checkbox" id="termcheckid" name="termcheckid"/> I agree to <a href="<?=URL::to('http://www.dealerplus.in/terms_conditions.html')?>" target="_blank" tabindex="7">Terms and Conditions</a> and <a href="<?=URL::to('http://www.dealerplus.in/privacy_policy.html')?>" target="_blank" tabindex="7">Privacy Policy</a>
                                        </div>
                                        <div class="row text-center">
                                            @if ($payment_data['nowpaid_cost'] ==0 )
                                            <button id="proceed" class="btn btn-primary proceed">Change Plan</button>
                                            @else
                                            <button id="proceed" class="btn btn-primary proceed">Proceed to Payment</button>
                                            @endif  
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @include('footer')
            </div>
        </div>

        <div class="modal fade" id="plandetail" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{$payment_data['new_planname']}}&nbsp;{{$payment_data['new_freqdesc']}} Plan</h4>
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
                                            @foreach ($freq as $plan)
                                               
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
        <div class="modal fade" id="terms" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Terms and Conditions</h4>
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
       
        <!-- Loading Scripts -->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/fileinput.js')}}"></script>
        <script> 
        $(document).ready(function () {
               //var coupen_val = 0;
               var pla_name  = $("#new_planval").val();
               var fre_name  = $("#new_ffreq").val(); 
               var users = $("#max_user").val();
               var oldsub_id = $("#old_subid").val();
               $(".round").hide();
               $("#coupen_amt").text(0);
              
                            
                
                $("#search-slide").slideUp(0);
            });
        </script>
        <script src="js/main.js"></script>
        <script src="js/menu.js"></script>
        <script>
            $(".search-click").click(function () {
                $("#search-slide").slideToggle();
            });
            $(".dropdown-toggle").click(function () {
                $(this).parent(".dropdown").ToggleClass("open");
//               $(this).children(".dropdown-menu").slideToggle();
            });

            $("#proceed").click(function(e){

                if ($('#termcheckid').prop("checked") == false) 
                {
                   
                    msg = " Please check terms and conditions. ";
                    $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                    $('html, body').animate({
                    scrollTop: ($('.container').offset().top - 500)
                    }, 0);
                    return false;
                }
                else
                {

                  $("#change_subscription").submit();
                }
            });

            $("#coupon_apply").on('click' , function(e){
                //alert("coupon apply")
                //e.preventDefault();
                $(".round").show();
                var csrf_token = $('#token').val();
                var cval=$("#coupon_val").val();
                var csub_tot=$("#sub_tot").text();
                var cpay_amt=$("#payable_amt").text();

                $.ajax({
                    url: 'coupon_data',
                    type: 'post',
                    dataType: 'json',
                    data: {_token: csrf_token, c_val: cval,c_subtot: csub_tot,c_payamt:cpay_amt},
                    success: function (response)
                    {
                       if(response.res_msg == 1)
                       {
                        
                        
                            $(".round").hide();
                           var coupon_amt = response.coupon_amt;
                           var new_payable_amt = 0;
                           $("#coupon_amount").val(coupon_amt)
                           $("#coupon_code").val(cval)
                           
                           if(cpay_amt > coupon_amt )
                           {

                              new_payable_amt = parseInt(cpay_amt) - coupon_amt;
                              
                              
                           }

                           

                           $("#payable_amt").text(new_payable_amt);
                           $("#coupon_msg").show(function(){
                              $("#coupon_msg").delay(2000).hide(500)
                            $("#coupen_amt").text(coupon_amt)
                           });
                           
                       }
                       else if(response.res_msg == 0)
                       {
                            
                            $(".round").hide();
                            $("#coupon_errmsg").text(response.message)
                            $("#coupon_errmsg").show(function(){
                                $("#coupon_errmsg").delay(2000).hide(500);
                                $("#coupen_amt").text(0)
                            });
                       }
                        /*$('html, body').animate({
                        scrollTop: ($('.container').offset().top - 1000)
                        }, 0); */
                         return false;
                    },
                    error: function (e)
                    {
                        console.log("error");
                    }
                });


            });
        </script>
    </body>

</html>