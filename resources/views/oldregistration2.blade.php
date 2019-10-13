<!Doctype html>
<html lang="en" class="no-js">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Registration</title>

<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="css/guest-style.css" type="text/css">
<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">



</head>

<body>
<div class="container-fluid body">
    <div class="row">
        <header class="col-xs-12">
            <div class="row">
                <div class="guestheader_div col-xs-12">
                    <div class="container">
                        <div class="col-sm-4 col-xs-8">
                            <a href="index.html"><img src="img/logo.png" alt="Logo" title="Logo" class="img-responsive guestlogo" width="250"/></a>
                        </div>
                        <div class="col-xs-4 hidden-lg hidden-md hidden-sm guestnavres">
                            <div class="navbar-header">
                                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <nav class="navbar row guestnav">
                                <div class="collapse navbar-collapse js-navbar-collapse">
                                    <ul class="nav navbar-nav">
                                        <li><a href="<?=URL::to('/login')?>">Sign In <i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
                                    </ul>

                                </div><!-- /.nav-collapse -->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="col-xs-12 bk-img">
            <form id="register" method="POST" action="store">
                <div class="login-page">
                    <div class="col-xs-12 bk-light">
                        <h2 class="text-center"><i class="fa fa-credit-card" aria-hidden="true"></i> Buy Plan</h2>
                        <div class="col-xs-12 card">
                            <ul class="nav nav-tabs row" role="tablist" name="plan">
                                <?php
                                    /*$sno='';
                                    $d_planlist=DB::connection('mastermysql')->table('master_plans')->get();
                                foreach ($d_planlist as $plan) { 
                                    $d_plan=$plan->plan_type_id;
                                    $sno++;
                                    $activestatus='';
                                    if($sno=='1')
                                    {
                                        $activestatus='active';
                                    }
                                    global $plan_name=$plan->plan_type_name;*/
                                ?>
                                  
                                    <li role="presentation" class="plan <?php //echo $activestatus; ?>" id="<?php //echo $d_plan;?>" value="<?php //echo $d_plan;?>" >
                                    <a href="#<?php //echo $plan->plan_type_name;?>" aria-controls="fyear" role="tab" data-toggle="tab"><?php //echo $plan->plan_type_name;?></a>
                                    </li>

                                <?php
                                 //}
                                ?>  

                                <!-- <li role="presentation" class="active"><a href="#basic" aria-controls="fyear" role="tab" data-toggle="tab">Basic</a></li>
                                <li role="presentation"><a href="#gold" aria-controls="tyear" role="tab" data-toggle="tab">Gold</a></li>
                                <li role="presentation"><a href="#premium" aria-controls="oyear" role="tab" data-toggle="tab">Premium</a></li>
                                <li role="presentation"><a href="#trial" aria-controls="oyear" role="tab" data-toggle="tab">Trial</a></li> -->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content ">
                            <?php
                            /*$d_plan='';
                            $sno=0;
                            $frequency_listno='0';
                            foreach ($d_planlist as $plan) { 
                                    global $d_plan;
                                    $d_plan=$plan->plan_type_id;
                                    $sno++;
                                    $activestatus='';
                                    if($sno=='1')
                                    {
                                        $activestatus='active';
                                    }
                                    */
                                    ?>

                                    <div role="tabpanel" class="tab-pane <?php //echo $activestatus; ?> col-xs-12" id="<?php //echo $plan->plan_type_name; ?>">
                                    <div class="radiostyle">
                                    <?php
                             /*$frequency_list = DB::connection('mastermysql')->table('master_plan_frequency')
                                              ->whereIn('frequency_id',function($query){
                                                global $d_plan;
                                                $query -> select('frequency_id')
                                                        -> from('master_subscription_plans')
                                                        ->where('master_subscription_plans.plan_type_id',$d_plan);
                                              })->get();  
                                              if(!empty($frequency_list)){
                                                foreach ($frequency_list as $frequency_listkey) {
                                                    $frequency_listno++;
                                                    global $frequency_id;
                                                    $frequency_id=$frequency_listkey->frequency_id;

                             $plan_amount=Db::connection('mastermysql')->table('master_subscription_plans')
                                            ->where('plan_type_id',$d_plan)
                                            ->where('frequency_id',$frequency_id)
                                            ->get();*/

                                            ?>
                                            <div class="col-xs-12 col-sm-3">
                                                <div class="radiostylebtn">
                                                    <input type="radio" name="period" id="<?php //echo $frequency_listkey->frequency_id.'_'.$frequency_listkey->frequency_name.'_'.$frequency_listno;?>" value="<?php //echo $frequency_listkey->frequency_id;?>">
                                                    <label for="<?php //echo $frequency_listkey->frequency_id.'_'.$frequency_listkey->frequency_name.'_'.$frequency_listno;?>"><?php //echo $frequency_listkey->frequency_id.' '.$frequency_listkey->frequency_name; ?></label>
                                                    <div class="check"></div>
                                                    <span><?php //echo $plan_amount[0]->total_cost; ?></span>

                                                </div>
                                            </div>
                                                    <?php
                                                //}
                                            //}
                            ?>
                            </div>
                            </div>
                            <?php
                            //}
                            ?>
                                
                            </div>
                        </div>
                    </div> 
                </div> 
                <div class="login-page">
                    <div class="col-xs-12 bk-light">
                        <div class="col-sm-6 col-xs-12 ordersum selectbuy">
                            <h2 class="text-center"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registration</h2>
                            <div class="col-xs-12 card">
                                <div class="col-xs-10 col-xs-offset-1 bk-light">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                    <input type="text" id="dealer_name" name="dealer_name"  placeholder="Dealer Company Name" class="form-control" maxlength="15">
                                    <input type="mail" id="d_email" name="d_email" placeholder="Email Id" class="form-control">
                                    <input type="tel" name="d_mobile" placeholder="Contact Number" class="form-control" maxlength="10">
                                    
                                    <div class="form-group">
                                        <select class="form-control" name="d_city">
                                            <option>Select your City</option>
                                               <!--  <?php
                                                    /*$d_citylist=DB::table('master_city')->get();
                                                foreach ($d_citylist as $city) { 
                                                    $d_city=$city->city_id;*/
                                                ?> -->
                                                @foreach($master_city as $fetch)
                                                <option>{{$fetch->city_name}}</option>
                                                @endforeach
                                                    <option value="<?php //echo $d_city;?>"><!-- <?php //echo $city->city_name;?></option>
                                                <?php
                                                 //}
                                                ?>       -->
                                        </select>
                                    </div>
                                    <p>Already Have An Account? <a href="<?=URL::to('/login')?>">Login Now.</a></p>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12 ordersum selectorder">
                            <h2 class="text-center"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Summary</h2>
                            <div class="col-xs-12 card">
                                <div class="row orderdiv">
                                    <em>Your Purchasing</em>
                                    <p><mark> <?php //echo $plan_name;?></mark> Four Year <i class="fa fa-arrow-circle-right"></i><span>Rs 4000</span></p>

                                </div>
                                <div class="row orderdiv">
                                    <input type="text" placeholder="Have a coupon ?"/>
                                    <button>APPLY</button>
                                </div>
                                <hr>
                                <h4>Your Order Totel</h4>
                                <hr>
                                <div class="row orderdiv">
                                    <p>sub Totel<span>Rs 3299.0</span></p>
                                    <p>Coupon Discount<span>Rs 0</span></p>
                                    <hr>
                                    <p>Payable Amount<span>Rs 0<i>(Inclusive of taxes)</i></span></p>
                                </div>
                                <hr>
                                <div class="row orderdiv">
                                    <input type="checkbox"/><span>Terms and Conditions</span>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 ">
                            <div class="bk-light">
                                <button class="btn btn-primary" type="submit">PROCEED TO PAYMENT</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </section>


        <!--</section>-->


        <footer class="col-xs-12 footer">
            <div class="container">
                <div class="col-xs-12 col-md-6 leftfooter">
                    <!--                            <em>&copy; 2016 <a href="#">Falconnect</a></em>
                                                <p>All right Reversed</p>-->
                </div>
                <div class="col-xs-12 col-md-6 rightfooter">
                    <div class="col-md-12">
                        <ul class="social-network social-circle pull-right col-xs-12">
                            <!--<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>-->
                            <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                            <!--<li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>-->
                            <li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                        </ul>   
                        <p>87-654321</p>
                        <p>Address</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Loading Scripts -->
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script type='text/javascript'>
    // <![CDATA[
jQuery(document).ready(function () {

        $('input:radio[name="period"]').change(function () {

            $('.ordersum').removeClass("selectbuy");
            $('.ordersum').removeClass("selectorder");

        });




$('.plan').click(function(){


var plan_id=$(this).val();
var csrf_token=$('#token').val();
$('[name="frequency_list"]').empty();
$.ajax({
    url:'frequency_get',
    type:'post',
    data:{_token:csrf_token,plan_id:plan_id},
    success:function(response)
    {
        //console.log(response);

        var json = $.parseJSON(response);
        
        $.each(json, function(arrayID,frequency_list) {
                   
            $('[name="frequency_list"]').append($('<option>', {value:frequency_list.frequency_id, text:frequency_list.frequency_id+' '+frequency_list.frequency_name}));
        });
    },
    error:function(e)
    {
        console.log(e.responseText);
    }
});

});
});

    // ]]>
</script>
</body>

</html>