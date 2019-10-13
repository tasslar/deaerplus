
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
<h2 class="page-title">Subscription</h2>
<div class="alert alert-danger" id="plan_err" style="display: none;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
<div class="card col-xs-12">
<div class="col-sm-2 col-xs-12"><b>Plan</b><p id="plan_name">{{$data['dealer_plan']}}</p></div>
<div class="col-sm-2 col-xs-12" ><b>Paid Users</b><p id="user_count">{{$data['user_count']}}</p></div>
<div class="col-sm-2 col-xs-12"><b>Payment Frequency</b><p>{{$data['frequency_name']}}</p></div>

<div class="col-sm-2 col-xs-12"><b>Subscription Id</b><p id="sub_id">{{$data['dealer_sub_id']}}</p></div>
<div class="col-sm-2 col-xs-12"><b>NextRenewal On</b><p>{{Carbon\Carbon::parse($data['dealer_paymentdate'])->format('d-m-Y')}}</p></div>
<div class="col-sm-2 col-xs-12"><b>Current Cost</b><p>{{$data['dealer_payment']}}</p></div>
<!-- <div class="col-sm-2 col-xs-12"><a id="renew" href="" class="btn btn-primary btn-sm">RENEW</a></div> -->

</div>
<div class="col-xs-12 card subscriptionsec">

<div class="ordersum col-sm-12 col-xs-12">
    <div class="form-group col-sm-2 col-xs-12">
        <label>Plan Detail</label>
        <select id="planchange" name="planchange" class="form-control">
        <option value="">Plan Details</option>
            @foreach ($d_planlist as $plan) 
            @php ($d_plan_id = $plan->plan_type_id)
            @php ($plan_name = $plan->plan_type_name)
            <option value="{{$plan->plan_type_id}}">{{$plan->plan_type_name}}</option>
            @endforeach
        </select>
    </div> 
    <div class="form-group col-sm-3 col-xs-12">
        <label>PaymentFrequency</label>
        <select id="frequency" class="form-control">
            <option value="">Payment Frequency</option>
            <option value="2">1 Month</option>
            <option value="3">3 Months</option>
            <option value="4">6 Months</option>
            <option value="5">1 Year</option>
        </select>
    </div> 
    <div class="form-group col-sm-2 col-xs-12">
        <label>Add User</label>
        <!--<input type="text" class="form-control" />
        <span class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>-->
        <div class="input-group">
            <input type="number" min="1" id="add_user" class=" form-control" name="start" value="1">
            <!--                                            <span class="input-group-addon btn btn-primary"><i class="fa fa-plus"></i></span>-->
        </div>
    </div> 
    <div class="form-group col-sm-2 col-xs-12">
     <label>Total Users</label>
    <div class="input-group">
     <input type="text" class=" form-control" id="tot_user" name="tot_user" value="" readonly>
    </div>
    </div> 

    <!-- <div class="pricingContent">

    </div> -->
</div>
<div class="col-sm-4 col-xs-12 pricingTable">
    <p class="btn-primary">ACTIVE</p>

    <p align="left" id="new_ppplan" class="testval"></p>
    <p align="left" id="carry_user" class="testval"></p>
    <p align="left" id="unit_cost" class="testval"></p>
    <p align="left" id="pre_rem_days" class="testval"></p>
    <p align="left" id="pre_tot_days" class="testval"></p>
    <p align="left" id="precost_perdayuser" class="testval"></p>
    <p align="left" id="balcost_peruser" class="testval"></p>
    <p align="left" id="balcost_alluser" class="testval"></p>
    <p align="left" id="user_comput_for" class="testval"></p>
    <p align="left" id="cur_cost" class="testval"></p>
    <p align="left" id="tot_comput_cost" class="testval"></p>
    <p align="left" id="nowpaid_cost" class="testval"></p>
   
    <a id="active" class="btn btn-primary btn-sm">Activate</a>
</div>
</div>
<div class="row">
<section class="col-xs-12 section3 subscriptionsec">
    <div class="row">
        <div class="col-sm-4 col-xs-12 basictable">
            <div class="pricingTable">
                <div class="pricingTable-header">
                    <span class="heading">
                        <h3>Basic</h3>
                        <span class="price-value">&#x20a8; <span>10</span><span class="month">/per month</span></span>
                    </span>

                    <div class="pricingTable-sign-up">
                        <a href="subscriptiondetail.html" class="btn btn-block btn-default">Activate</a>
                    </div>
                </div>

                <div class="pricingContent">
                    <ul>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Website & Mobile Apps</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Pricing per User is <i>Free</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Posting to Multiple Portals</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Vehicle Listing is <i>< 20</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Premium Listing/ Ad is <i>Rs. A</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Customer Records is <i>upto 100</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Contact Records is<i>upto 100</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Lead SMS Alerts/ Month is <i>upto 100</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Loan Offers</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  e-Auction <i>selling</i></li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Inventory Feed from Multiple Portals</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Monthly Call Support</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Assessment & Analytics</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Business Website</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Sales Tracker</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Reports</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Image Editor with Watermark</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Video Editor with Watermark</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Document Capture</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Market Trend Analysis</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Inventory Funding Access</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Sales Application  - Mobile App</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Auto Inspekt Integration</li>
                    </ul>
                </div><!-- /  CONTENT BOX-->

                <div class="pricingTable-sign-up">
                    <a href="subscriptiondetail.html" class="btn btn-block btn-default">Activate</a>
                </div><!-- BUTTON BOX-->
            </div>
        </div>
        <div class="col-sm-4 col-xs-12 goldtable">
            <div class="pricingTable">
                <div class="pricingTable-header">
                    <span class="heading">
                        <h3>Gold</h3>
                        <span class="price-value">&#x20a8;  <span>10</span><span class="month">/per month</span></span>
                    </span>

                    <div class="pricingTable-sign-up">
                        <a href="subscriptiondetail.html" class="btn btn-block btn-default">Activate</a>
                    </div>
                </div>

                <div class="pricingContent">
                    <ul>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Website & Mobile Apps</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Pricing per User is <i>Rs. X</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Posting to Multiple Portals</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Vehicle Listing is <i>upto 100</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Premium Listing/ Ad is <i>Rs. B</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Customer Records is <i>upto 1000</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Contact Records is<i>upto 1000</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Lead SMS Alerts/ Month is <i>upto 1000</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Loan Offers</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  e-Auction for <i>selling</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Inventory Feed from Multiple Portals</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Monthly Call Support <i>upto 100</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Assessment & Analytics</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Business Website</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Sales Tracker</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Reports</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Image Editor with Watermark</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Video Editor with Watermark</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Document Capture</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Market Trend Analysis</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Inventory Funding Access</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Sales Application  - Mobile App</li>
                        <li><i class="fa fa-times false" aria-hidden="true"></i>  Auto Inspekt Integration</li>

                    </ul>
                </div><!-- /  CONTENT BOX-->

                <div class="pricingTable-sign-up">
                    <a href="subscriptiondetail.html" class="btn btn-block btn-default">Activate</a>
                </div><!-- BUTTON BOX-->
            </div>
        </div>
        <div class="col-sm-4 col-xs-12 premiumtable">
            <div class="pricingTable">
                <div class="pricingTable-header">
                    <span class="heading">
                        <h3>Premium</h3>
                        <span class="price-value">&#x20a8; <span>10</span><span class="month">/per month</span></span>
                    </span>

                    <div class="pricingTable-sign-up">
                        <a href="subscriptiondetail.html" class="btn btn-block btn-default">Activate</a>
                    </div>
                </div>

                <div class="pricingContent">
                    <ul>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Website & Mobile Apps</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Pricing per User is <i>Rs. Y</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Posting to Multiple Portals</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Vehicle Listing is <i>Unlimited</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Premium Listing/ Ad is <i>Rs. C</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Customer Records is <i>Unlimited</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Contact Records is <i>Unlimited</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Lead SMS Alerts/ Month is <i>Unlimited</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Loan Offers</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  e-Auction for <i>Buying & Selling</i></li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Inventory Feed from Multiple Portals</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  <i>dedicated Support</i> for Monthly Call </li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Assessment & Analytics</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Business Website</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Sales Tracker</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Reports</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Image Editor with Watermark</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Video Editor with Watermark</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Document Capture</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Market Trend Analysis</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Inventory Funding Access</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Sales Application  - Mobile App</li>
                        <li><i class="fa fa-check true" aria-hidden="true"></i>  Auto Inspekt Integration</li>
                    </ul>
                </div><!-- /  CONTENT BOX-->

                <div class="pricingTable-sign-up">
                    <a href="subscriptiondetail.html" class="btn btn-block btn-default">Activate</a>
                </div><!-- BUTTON BOX-->
            </div>
        </div>
    </div>
</section>
</div>
</div>
</div>
<form id="subscriptiondetail" method="post" action="subscriptiondetail">
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<input type="hidden" id="new_plan" name="new_plan"/>
<input type="hidden" id="new_freq" name="new_freq"/>
<input type="hidden" id="new_freqid" name="new_freqid"/>
<input type="hidden" id="newtot_user" name="newtot_user"/>
<input type="hidden" id="newtot_cost" name="newtot_cost"/>


</form>


</div>

@include('footer')
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
        $("#search-slide").slideUp(0);
        $("#tot_user").val($("#user_count").text());



        $("#add_user").blur(function(e){
          $("#tot_user").val(parseInt($("#user_count").text())+parseInt($("#add_user").val()));
            var plan_val=$("#planchange").val();
            var plan_name=$("#planchange option:selected").text();

            var freq_val=$("#frequency").val();
            var add_user=$("#add_user").val();
            var user_count=parseInt($("#user_count").text());
            var tot_user=$("#tot_user").val();
            var sub_id=parseInt($("#sub_id").text());
            var csrf_token = $('#token').val();
             $.ajax({
                url: 'subscription_data',
                type: 'post',
                dataType: 'json',
                data: {_token: csrf_token, plan_val: plan_val,freq_val: freq_val,add_user: add_user,sub_id: sub_id,user_count: user_count,tot_user:tot_user},
                success: function(response)
                {
                    $("#new_ppplan").html("New Plan---"+$("#planchange option:selected").text());
                    $("#tot_comput_cost").html(response.tot_comput_cost);
                    $("#nowpaid_cost").html("Nowpaid cost----"+response.nowpaid_cost);
                    $("#pre_rem_days").html("pre_rem_days-----"+response.pre_rem_days);
                    $("#pre_tot_days").html("pre_tot_days----"+response.pre_tot_days);
                    $("#precost_perdayuser").html("precost_perdayuser----"+response.precost_perdayuser);
                    $("#balcost_peruser").html("balcost_peruser----"+response.balcost_peruser);
                    $("#balcost_alluser").html("balcost_alluser----"+response.balcost_alluser);
                    $("#cur_cost").html("cur_cost----"+response.cur_cost);
                    $("#user_comput_for").html("user_comput_for----"+response.user_comput_for);
                    $("#unit_cost").html("unit_cost----"+response.unit_cost);
                    
                   
                },
                error: function(e)
                {
                    
                    console.log("error");
                }
            });

        });

        $("#active").click(function(e){
             $("#new_plan").val($("#planchange option:selected").text());
             $("#new_freq").val($("#frequency option:selected").text());
             $("#new_freqid").val($("#frequency").val());
             $("#newtot_user").val($("#tot_user").val());
             $("#newtot_cost").val($("#tot_comput_cost").text())
             if($(".testval").text()=="")
             {
                
                msg = " Please Select new plan. ";
                    $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                    $('html, body').animate({
                    scrollTop: ($('.container').offset().top - 500)
                    }, 0);
                    return false;
             }
             else
             {

                $("#subscriptiondetail").submit();
             }
   
        });

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
        //  $(this).children(".dropdown-menu").slideToggle();
        });

</script>
</body>

</html>