@include('header')

<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="container-fluid">
            <div class="row">   
                <div class="content-header col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('/myeditaccount')}}"><i class="fa fa-dashboard"></i>Manage</a></li>
                        <li class="active">Subscription</li>
                    </ol>
                </div>
                <div class="col-xs-12">
                    <h2 class="page-title">Subscription</h2>
                    @if (Session::has('message'))
                    <div class="alert alert-success" id="message">{{ Session::get('message') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                    @endif
                    @if (Session::has('message-err'))
                    <div class="alert alert-danger" id="message-err">{{ Session::get('message-err') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                    @endif

                    <div class="alert alert-success" id="msg_data" style="display: none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>

                    <div class="alert alert-danger" id="plan_err" style="display: none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                    <div class="row">
                        <div class="col-xs-12 mb ">
                            <div class="col-sm-6 col-xs-12 pull-right text-center creditsdiv">
                                <h4>Current Plan : <span class="btn-sm">{{$cur_plan_details['plan_type_name']}}</span></h4>
                                <span class="btn-sm">Current Plan Duration:
                                {{Carbon\Carbon::parse($cur_plan_details['cur_startdate'])->format('d/m/Y')}} - {{Carbon\Carbon::parse($cur_plan_details['cur_enddate'])->format('d/m/Y')}}</span>
                                <p></p>
                                <span class="btn-sm creditspan">Available Credit Balance Rs. {{$cur_plan_details['cur_credit']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card col-xs-12">

                        <div class="col-sm-1 col-xs-12"><b>Plan</b><p id="plan_name">{{$cur_plan_details['plan_type_name']}}</p></div>
                        <div class="col-sm-2 col-xs-12" ><b>Paid Users</b><p id="user_count">{{$cur_plan_details['user_count']}}</p></div>
                        <div class="col-sm-2 col-xs-12"><b>Payment Frequency</b><p id="freq">{{$cur_plan_details['frequency_name']}}</p></div>

                        <div class="col-sm-2 col-xs-12 hidden"><b>Subscription Id</b><p id="sub_id">{{$cur_plan_details['dealer_sub_id']}}</p></div>
                        <div class="col-sm-2 col-xs-12"><b>NextRenewal On</b><p id="renew_date">{{Carbon\Carbon::parse($cur_plan_details['dealer_paymentdate'])->format('d-m-Y')}}</p></div>
                        <div class="col-sm-2 col-xs-12"><b>Current Cost</b><p id="c_cost" >{{$cur_plan_details['total_plan_amount']}}</p></div>
                        <div class="col-sm-2 col-xs-12"><b>Balance Cost in Plan</b><p id="cb_cost" name="planBalCost" >{{$cur_plan_details['plan_balance_amount']}}</p></div>
                        <input type="hidden" id="next_renew" name="next_renew" value="{{$cur_plan_details['dealer_paymentdate']}}">
                        <input type="hidden" id="cost" name="cost" value="{{$cur_plan_details['dealer_payment']}}">
                        <input type="hidden" name="renew_token" id="renew_token" value="{{ csrf_token() }}">

                        <div class="col-sm-1 col-xs-12"><a id="renew" href="#" class="btn btn-primary btn-sm">RENEW</a></div>
                    </div>

                    <div class="row">
                        <section class="col-xs-12 section3 subscriptionsec">
                            <div class="col-xs-12 col-md-8">
                                <div class="row">
                                    @foreach ($d_planlist as $plan) 
                                    @php ($d_plan_id = $plan->plan_type_id)
                                    @php ($plan_name = $plan->plan_type_name)
                                    <div class="col-xs-12 basictable">
                                        <div class="pricingTable col-xs-12">
                                            <div class="accordsec row">
                                                <div class="pricingTable-header col-sm-11 col-xs-12">
                                                    <div class="row">
                                                        <span class="heading col-sm-3 col-xs-12 text-center">
                                                            <h3>{{$plan->plan_type_name}}</h3>
                                                        </span>
                                                        <ul id="myTab" class="nav nav-tabs nav-tabs-responsive col-sm-9 col-xs-12" role="tablist">
                                                            @foreach ($frequency_list[$plan_name] as $plan) 
                                                            <li role="presentation" class="active">
                                                                <a class="sub_list" data-list="{{$plan_name}}" data-list-id="{{$d_plan_id}}" data-sub="{{$plan['frequency_desc']}}" data-interval="{{$plan['frequency_interval']}}" data-desc="{{$plan['frequency_desc']}}" role="tab" data-toggle="tab" aria-controls="div1" aria-expanded="true">
                                                                    <span class="text">{{$plan['frequency_desc']}}</span>
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1 col-xs-12 accrsec">
                                                    <div class="row">
                                                        <button class="accordion">
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="bs-example bs-example-tabs panel col-xs-12" role="tabpanel" data-example-id="togglable-tabs" id="">
                                                    <div id="myTabContent" class="tab-content">
                                                        <div role="tabpanel" class="tab-pane fade in active" id="">
                                                            <div class="pricingContent">
                                                                <ul class="col-xs-12">
                                                                    @foreach ($feature_list[$plan_name] as $plan)
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
                                            <!-- /  CONTENT BOX-->

                                            <!-- <div class="pricingTable-sign-up">
                                               <a href="" class="btn btn-block btn-default">Activate</a>
                                           </div> -->
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>


                            <div class="col-xs-12 col-md-4 card subscriptionsec">
                                <div class="ordersum row">
                                    <div class="form-group  col-xs-12">
                                        <label>Plan Details</label>
                                        <input type="text" class=" form-control" id="planchange" name="planchange" planchange="" value="" readonly>



                                    </div> 
                                    <div class="form-group  col-xs-12">
                                        <label>Payment Frequency</label>
                                        <input type="text" class=" form-control" id="frequency" name="frequency" value="" freqq="" freqdesc="" readonly>


                                    </div> 
                                    <div class="form-group col-xs-12">
                                        <label>Add User</label> 
                                        <div class="col-xs-10">
                                            <div class="row">
                                                <input type="number" min="1" id="add_user" class=" form-control" name="start" value="{{$cur_plan_details['user_count']}}" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="row filenum">
                                                <a id="add_up" class="calc input-group  glyphicon glyphicon-chevron-up"></a>
                                                <a id="add_down" class="calc input-group  glyphicon glyphicon-chevron-down"></a>
                                                
                                            </div>
                                        </div>
                                        <input type="hidden" id="cur_adduser" name="cur_adduser" value="">
                                        <!--                                            <span class="input-group-addon btn btn-primary"><i class="fa fa-plus"></i></span>-->
                                    </div> 
                                    <div class="form-group col-xs-12">
                                        <!-- <label>Total User</label> -->

                                        <div class="input-group">
                                            <input type="hidden" class=" form-control" id="tot_user" name="tot_user" value="" readonly>
                                            <!--<span class="input-group-addon btn btn-primary"><i class="fa fa-plus"></i></span>-->
                                        </div>
                                    </div> 
                                    <div class="pricingContent">

                                    </div>
                                </div>
                                <div class="col-xs-12 pricingTable">
                                    <!-- <p class="btn-primary">ACTIVE</p> -->
                                    <p align="left" id="new_ppplan" class="testval"></p>
                                    <p hidden align="left" id="c_user" class="testval"></p>
                                    <p align="left" id="unit_cost" class="testval"></p>
                                    <p align="left" id="pre_rem_days" class="testval"></p>
                                    <p align="left" id="pre_tot_days" class="testval"></p>
                                    <p align="left" id="precost_perdayuser" class="testval"></p>
                                    <p align="left" id="balcost_peruser" class="testval"></p>
                                    <p align="left" id="balcost_alluser" class="testval"></p>
                                    <p hidden align="left" id="balcost_allusers" class="testval"></p>
                                    <p align="left" id="user_comput_for" class="testval"></p>
                                    <p align="left" id="cur_cost" class="testval"></p>
                                    <p align="left" id="tot_comput_cost" class="testval"></p>
                                    <p align="left" id="nowpaid_cost" class="testval"></p>
                                    <p align="left" id="prorata" class="testval"></p>

                                    <a id="active" class="btn btn-primary btn-sm">Activate</a>
                                </div>
                            </div>


                        </section>
                    </div>
                </div>
            </div>
            <form id="subscriptiondetail" method="post" action="subscriptiondetail">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                 <input type="hidden" id="new_plan" name="new_plan"/>
                <input type="hidden" id="new_planval" name="new_planval"/>
                <input type="hidden" id="new_freq" name="new_freq"/>
                <input type="hidden" id="newtot_user" name="newtot_user"/>
                <input type="hidden" id="old_ssub_id" name="old_ssub_id"/>

                
                <!-- 
                <input type="hidden" id="cur_user" name="cur_user"/>
                <input type="hidden" id="new_freqid" name="new_freqid"/>
                <input type="hidden" id="newtot_cost" name="newtot_cost"/>
                <input type="hidden" id="freqq_detail" name="freqq_detail"/>
                <input type="hidden" id="ccuser" name="ccuser"/>
                <input type="hidden" id="carry_costalluser" name="carry_costalluser"/>
                <input type="hidden" id="prorata_to" name="prorata_to"/>
                <input type="hidden" id="nowpaid_cost_to" name="nowpaid_cost_to"/>

                <input type="hidden" id="freqdesc_detail" name="freqdesc_detail"/> -->

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
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script>
$(document).ready(function () {
    if($("#freq").text()=="30 DAY TRIAL" && $("#c_cost").text()=="0.00")
    {
        $("#renew").hide()
    }
    else
    {
        $("#renew").show()
    }   
    $("#message").fadeIn(2000, function ()
            {
            $(this).delay(4000).fadeOut(2000);
    });
    $("#message-err").fadeIn(2000, function ()
            {
            $(this).delay(4000).fadeOut(2000);
    });
    $("#add_up").click(function (e) {
//alert("add up")
        $("#add_user").val(parseInt($("#add_user").val()) + 1);
    });
    $("#add_down").click(function (e) {
//alert("add down")
        var cur = $("#add_user").val();
        if (cur == 1)
        {
            $("#add_user").val(cur)
        }
        else if (cur == 0)
        {
            $("#add_user").val(parseInt($("#add_user").val()) + 1)
        } 
  
        else
        {

            $("#add_user").val(parseInt($("#add_user").val()) - 1)
        }

    });
    $("#renew").click(function (e) {
        var confirm_msg = confirm("Do You Want to Renew Your Existing Plan?");
        if (confirm_msg)
        {
            var sub_id = parseInt($("#sub_id").text());
            var user_count = parseInt($("#user_count").text());
            var next_renewdate = $("#next_renew").val();
            var cur_cost = $("#c_cost").text()
            
            var csrf_token = $('#renew_token').val();
            $.ajax({
                url: 'renewplan',
                type: 'post',
                data: {_token: csrf_token, sub_id: sub_id, user_count: user_count, next_renewdate: next_renewdate, cur_cost: cur_cost},
                success: function (response)
                {

                    if(response.data == "false")
                     {
                            $("#plan_err").show().html(response.message + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').delay(4000).fadeOut(2000);
                            $('html, body').animate({
                                scrollTop: ($('.container').offset().top - 500)
                            }, 0);
                           return false;
                     }
                     else
                     {
                        window.location.href  =  response;
                     }
                },
                error: function (e)
                {
                    console.log("error");
                }
            });
        }
    });

    $("#search-slide").slideUp(0);
    $("#tot_user").val($("#user_count").text());
    var exist_user = $("#add_user").val();

    $(".calc").click(function (e) {
        var current_adduser = $("#add_user").val();
        var newuser_count = 0;
        if (exist_user < current_adduser)
        {

            $("#tot_user").val(parseInt($("#user_count").text()) + parseInt($("#add_user").val()));
        } else
        {

            $("#tot_user").val(parseInt($("#user_count").text()) - parseInt($("#add_user").val()));
        }
        var tot_user = $("#add_user").val();
        var plan_val = $("#planchange").attr('planchange');
        var freq_desc = $("#frequency").attr('freqdesc');
        var freq_int = $("#frequency").attr('freqq');
        var add_user = $("#add_user").val();
        var user_count = parseInt($("#user_count").text());
        var sub_id = parseInt($("#sub_id").text());
        $("#cur_adduser").val(current_adduser);
        var csrf_token = $('#token').val();
        $.ajax({
            url: 'subscription_data',
            type: 'post',
            dataType: 'json',
            data: {_token: csrf_token, plan_val: plan_val, freq_desc: freq_desc, freq_int: freq_int, add_user: add_user, sub_id: sub_id, user_count: user_count, tot_user: tot_user},
            success: function (response)
            {
                if (response.res_msg == 0)
                {
                    //alert(response.message)
                    $("#plan_err").show().html(response.message + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').delay(4000).fadeOut(2000);
                    $('html, body').animate({
                        scrollTop: ($('.container').offset().top - 500)
                    }, 0);
                    return false;
                } else if (response.res_msg == 5)
                {
                    //alert(response.message)
                    $("#msg_data").show().html(response.message + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').delay(4000).fadeOut(2000);
                    $('html, body').animate({
                        scrollTop: ($('.container').offset().top - 500)
                    }, 0);
                    return false;
                } else if (response.res_msg == 1)
                {
                    $("#new_ppplan").html("New Plan:" + $("#planchange").val());
                    $("#tot_comput_cost").html(response.tot_comput_cost);
                    $("#nowpaid_cost").html(response.nowpaid_cost);
                    //$("#prorata").html(response.nowpaid_cost);
                    $("#prorata").html(response.prorata_cost);

                    $("#pre_rem_days").html("Previoues Remaining Days:" + response.pre_rem_days);
                    $("#pre_tot_days").html("Previous Total Days:" + response.pre_tot_days);
                    $("#precost_perdayuser").html("Previous Cost/Day/User:" + response.precost_perdayuser);
                    $("#balcost_peruser").html("Balance Cost/User:" + response.balcost_peruser);
                    $("#balcost_alluser").html("Balance Cost/AllUsers:" + response.balcost_alluser);
                    $("#balcost_allusers").html(response.balcost_alluser);
                    $("#cur_cost").html("Current Cost:" + response.cur_cost);
                    $("#user_comput_for").html("User Compute For:" + response.user_comput_for);
                    $("#unit_cost").html("Unit Cost:" + response.unit_cost);
                    $("#c_user").html(response.carry_user);
                } else if (response.res_msg == 2)
                {
                    $("#new_ppplan").html("New Plan:" + $("#planchange").val());
                    $("#tot_comput_cost").html(response.tot_comput_cost);
                    $("#nowpaid_cost").html(response.nowpaid_cost);
                    $("#prorata").html(response.nowpaid_cost);
                    $("#pre_rem_days").html("Previoues Remaining Days:" + response.pre_rem_days);
                    $("#pre_tot_days").html("Previous Total Days:" + response.pre_tot_days);
                    $("#precost_perdayuser").html("Previous Cost/Day/User:" + response.precost_perdayuser);
                    $("#balcost_peruser").html("Balance Cost/User:" + response.balcost_peruser);
                    $("#balcost_alluser").html("Balance Cost/AllUsers:" + response.balcost_alluser);
                    $("#balcost_allusers").html(response.balcost_alluser);
                    $("#cur_cost").html("Current Cost:" + response.cur_cost);
                    $("#user_comput_for").html("Remaining Users:" + response.user_comput_for);
                    $("#unit_cost").html("Unit Cost:" + response.unit_cost);
                    $("#c_user").html(response.carry_user);
                }
            },
            error: function (e)
            {
                console.log("error");
            }
        });
    });

    $("#active").click(function (e) {
        $("#new_plan").val($("#planchange").val());
        $("#new_planval").val($("#planchange").attr('planchange'));
        $("#new_freq").val($("#frequency").val());
        $("#new_freqid").val($("#frequency").val());
        $("#old_ssub_id").val($("#sub_id").text());
       

        $("#newtot_user").val($("#add_user").val());
        $("#cur_user").val($("#cur_adduser").val());
        $("#newtot_cost").val($("#tot_comput_cost").text())
        $("#freqq_detail").val($("#frequency").attr('freqq'));
        $("#freqdesc_detail").val($("#frequency").attr('freqdesc'));
        $("#ccuser").val($("#c_user").text());
        $("#carry_costalluser").val($("#balcost_allusers").text());
        $("#prorata_to").val($("#prorata").text());
        $("#nowpaid_cost_to").val($("#nowpaid_cost").text());

//$("#subscriptiondetail").submit();
        if ($("#new_plan").val() == "" && $("#new_freq").val() == "")
        {
            msg = " Please Choose New Plan. ";
            $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').delay(4000).fadeOut(2000);
            $('html, body').animate({
                scrollTop: ($('.container').offset().top - 500)
            }, 0);
            return false;
        } else if ((parseInt($("#user_count").text()) == $("#add_user").val()) && ($("#plan_name").text() == $("#planchange").val()) && ($("#freq").text() == $("#frequency").val()))
        {

            msg = " You are already in a same plan.Click RENEW.. ";
            $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').delay(4000).fadeOut(2000);
            $('html, body').animate({
                scrollTop: ($('.container').offset().top - 500)
            }, 0);
            return false;
        } else
        {

            $("#subscriptiondetail").submit();
        }
    });

    $(".sub_list").click(function (e) {
        $("#planchange").val($(this).attr('data-list'))
        var plan_id = $(this).attr('data-list-id')
        $("#planchange").attr('planchange', plan_id)
        $("#frequency").val($(this).attr('data-sub'))
        var freq_id = $(this).attr('data-interval')
        $("#frequency").attr('freqq', freq_id)
        var freq_desc = $(this).attr('data-desc')
        $("#frequency").attr('freqdesc', freq_desc)
        if($(this).attr('data-list-id') == 1)
        {
            $('#add_user').val('1')
           /* $('#add_up').attr("disabled","disabled");
            $('#add_down').attr("disabled", "disabled");*/
             $('#add_up').hide();
            $('#add_down').hide();
        }
        else
        {
            $('#add_user').val($("#user_count").text())
            $('#add_up').show();
            $('#add_down').show();
        }
    });
});
</script>
<script>
    $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
        var $target = $(e.target);
        var $tabs = $target.closest('.nav-tabs-responsive');
        var $current = $target.closest('li');
        var $parent = $current.closest('li.dropdown');
        $current = $parent.length > 0 ? $parent : $current;
        var $next = $current.next();
        var $prev = $current.prev();
        var updateDropdownMenu = function ($el, position) {
            $el
                    .find('.dropdown-menu')
                    .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                    .addClass('pull-xs-' + position);
        };
        $tabs.find('>li').removeClass('next prev');
        $prev.addClass('prev');
        $next.addClass('next');
        updateDropdownMenu($prev, 'left');
        updateDropdownMenu($current, 'center');
        updateDropdownMenu($next, 'right');
    });
</script>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function () {
            this.classList.toggle("active");
            $(this).parents(".accrsec").next().toggleClass("show");
        }
    }
</script>
</body>

</html>