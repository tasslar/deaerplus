
<!doctype html>
<html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>DMS</title>
        <style>
            body{margin: 0px;padding: 0px;}
            .whole_body{float:left;width: 80%;padding: 0px;margin:2px 10%;background: #fff;font-family: arial;}
            p{line-height: 22px;font-size: 12px;}
            input{width: 100%;outline: none;}
            .body_content{float: left;width:90%;background: #fff;margin:4%;padding: 0% 1% 1% 1%;border: 10px solid #23527c;}
            .logodiv{float: left;width:96%;margin: 0px 2% 0px 2%;}
            .logodiv1{width: 30%;float: left;margin-top: 15px;}.logodiv2{width:30%;float:right;text-align: right;margin-top: 15px;}
            .logodiv .logo{max-width: 225px;float: left;}
            .logodiv2 img{width: 25px; }
            .logodiv2 a{text-decoration: none;margin-top: 10px;}
            .logodiv2 a span{margin-top: 5px;float: right;margin-left: 5px;color: #23527c;font-weight: bold;
                             text-transform: uppercase;font-size: 14px;}
            .logodiv .logo img{max-width: 90%;}
            .logodiv .logo1 img{max-width: 90%;}
            .logocenter{width: 40%;float:left;background: #23527c;position: relative;}
            .logocenter p{color:#fff;text-align: center;text-transform: uppercase;font-weight: bold;font-size: 20px;}
            .car_price{float: left;width:86%;margin:10px 2% 0px 2%;background: #23527c;padding:15px 5%;position: relative;
                       color:#fff;}
            .car_details{width: 50%;float: left;border-right: 1px solid #fff;}
            .car_details p{font-size: 20px;text-transform: uppercase;margin: 8px 0px;letter-spacing: 1px;}
            .car_name p{font-size: 26px;margin: 50px 0px;;}
            .car_name{width: 44%;padding-left: 5%;float: left;}
            .car_specifications{float: left;width:94%;margin:10px 2% 0px 2%;padding:15px 1%;}
            .specific_div{width:14.6667%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;}
            .specific_div h5{text-align: center;font-weight: normal;margin: 10px 0px;}
            .specific_div input{width: 97%;outline: none;font-size: 16px;text-align: center;font-weight: bold;text-transform: capitalize;}
            .arrow {position: absolute;display: block;width: 0;height: 0;border-color: transparent;border-style: solid;
                    top: -12px;left: 44%;margin-left: -11px;border-bottom-width: 0;border-width: 11px;}
            .arrow:after {content: "";border-width: 10px;top: -10px;margin-right: 0px;border-color: rgba(169, 7, 7, 0);
                          border-style: solid;border-bottom-color: #d3d3d4;border-top-width: 0px;position: absolute;display: block;
                          width: 0;border-top-color: transparent;height: 0;}
            .car_specifications{position: relative;}
            .car_specifications h3{margin: 0px;padding: 10px 0px;color:#fff;text-transform: uppercase;
                                   font-weight: normal;font-size: 24px;letter-spacing: 0.5px;}
            .car_specifications h3 span{background: #23527c;text-align: left;padding: 10px 40px 10px 10px;}
            .car_specifications textarea{width: 100%;resize: none;margin-top: 5px;height: 100px;outline: none;
                                         font-size: 16px;text-align: left;font-weight: bold;}
            .sepfivdetails{width: 50%;float:left;}
            .sepdetails{width: 94%;border:1px solid #ccc;float: left;padding: 0px 2%;margin-left: 1%;}
            .sepdetails p{width: 50%;font-size: 15px;font-weight: bold;float: left;}
            .sepdetails input{width: 97%;outline: none;font-size: 16px;text-align: left;font-weight: bold;}
            button{padding: 10px;border: none;background: #ee1b24;color: #fff;font-weight: bold;margin: auto;left:0;right: 0;outline: none;cursor: pointer;}
            .footerdiv{float: left;width: 70%;background: transparent;margin: 0px 5% 10px 5%;padding: 0px 10% 10px 10%;text-align: center;}
            .footerdiv img{max-width: 200px}
            .leftarrow {position: absolute;display: block;width: 0;height: 0;border-color: transparent;border-style: solid;
                        top: -1px;left: -62px;margin-left: -11px;border-bottom-width: 0;border-width: 11px;}
            .leftarrow:after {content: "";border-width: 62px;top: -10px;margin-right: 0px;border-color: rgba(169, 7, 7, 0);
                              border-style: solid;border-bottom-color: #fff;border-top-width: 0px;position: absolute;display: block;
                              width: 0;border-top-color: transparent;height: 0;}
            .rightarrow {position: absolute;display: block;width: 0;height: 0;border-color: transparent;border-style: solid;
                         top: -1px;left: 310px;margin-left: -11px;border-bottom-width: 0;border-width: 11px;}
            .rightarrow:after {content: "";border-width: 62px;top: -10px;margin-right: 0px;border-color: rgba(169, 7, 7, 0);
                               border-style: solid;border-bottom-color: #fff;border-top-width: 0px;position: absolute;display: block;
                               width: 0;border-top-color: transparent;height: 0;}
            .specificarrow {position: absolute;display: block;width: 0;height: 0;border-color: transparent;border-style: solid;
                         top: -1px;left: 208px;margin-left: -11px;border-bottom-width: 0;border-width: 11px;background: none!important;}
            .specificarrow:before {content: "";border-width: 47px;top: 5px;margin-right: 0px;border-color: rgba(169, 7, 7, 0);
                               border-style: solid;border-bottom-color: #23527c;border-top-width: 0px;position: absolute;display: block;
                               width: 0;border-top-color: transparent;height: 0;}
            @media only screen and (max-width: 992px) {.leftarrow,.rightarrow{display: none;}.sepfivdetails{width: 100%;}
            .specific_div{width: 27%;margin: 2.5%;}}
            @media only screen and (max-width: 768px) {.car_details{width: 100%;border: none;}
            .car_name{width: 100%;}.car_details p{font-size: 14px;margin: 2px 0px;letter-spacing: 0.4px;text-transform: capitalize;}
            .car_name p{margin: 10px 0px;}.specific_div{width: 44%;margin: 2.5%;}.car_specifications h3{font-size: 14px;}
            .specificarrow:before{display: none;}.logodiv1,.logocenter{width: 100%;text-align: center;}
            .logodiv2{width: 100%;}.whole_body{width: 90%;margin: 2px 5%;}}
            </style>
        </head>
     <body>
        <form id="inventorylist_stickerpdf" name="" method="post" action="{{url('inventorylist_stickerpdf')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="whole_body">
            <div class="body_content">
                <div class="logodiv">
                    <div class="logodiv1">
                        <a href="" class="logo"><img src="{{URL::asset('img/logo.png')}}" class="img-responsive" alt=""></a>
                    </div>
                    <div class="logocenter"><p>For Sale</p></div>
                    <div class="logodiv2">
                        <a id="printpdf" href="#"><img src="{{url('img/print.png')}}" class="img-responsive" alt=""><span>Print</span></a>
                        <div>
                        <p><img src="{{url($basic_info['logo'])}}" class="ts-avatar hidden-side" alt="">{{$basic_info['dealername']}}</p>
                        <p>{{$basic_info['email']}}</p>
                        <p>{{$basic_info['mobile']}}</p>
                        </div>
                    </div>
                </div>
                <div class="car_content">
                    <div class="car_price">
                        <div class="car_details">
                            <p><b>{{$basic_info['registration_year']}}</b></p>
                            <p><b>{{$basic_info['make']}} {{$basic_info['model']}}</b></p>
                            <p>{{$basic_info['variant']}}</p>
                            <p>{{$basic_info['mileage']}} KMPL,{{$basic_info['kilometer_run']}} KMS</p>
                        </div>
                        <div class="car_name">
                            <p>Sales Prices : <b>{{$basic_info['price']}}</b></p>
                        </div>
                    </div>
                    <div class="car_specifications">
                        <div class="specific_div"><h5>Fuel Type</h5>
                            <input type="text" name="fuel_type" value='{{$basic_info['fuel_type']}}' readonly/><span class="arrow"></span>
                        </div>
                        <div class="specific_div"><h5>Body Style</h5>
                            <input type="text" name="body_type" value='{{$basic_info['body_type']}}' readonly/><span class="arrow"></span>
                        </div>
                        <div class="specific_div"><h5>Drivetrain</h5>
                            <input type="text" name="drivetrain" value='' /><span class="arrow"></span>
                        </div>
                        <div class="specific_div"><h5>Certified & Warranty</h5>
                            <input type="text" name="certified" value='' /><span class="arrow"></span>
                        </div>
                        <div class="specific_div"><h5>No. Of Owners</h5>
                            <input type="text" name="owners" value='{{$basic_info['owner_type']}}' readonly/><span class="arrow"></span>
                        </div>
                        <div class="specific_div"><h5>Transmissions</h5>
                            <input type="text" name="transmission" value='{{$basic_info['transmission']}}' readonly /><span class="arrow"></span>
                        </div>
                    </div>
                    <div class="car_specifications">
                        <h3><span class="specificarrow"></span><span>Specifications</span></h3>
                        <div class="sepfivdetails">
                            <div class="sepdetails">
                                <p>Displacement:</p>
                                <p><input type="text" name="displacement" value='{{$feature_info['displacement']}}' name="displacement" readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Cylinders:</p>
                                @if($feature_info['no_of_cylinder']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="cylinders" value='{{$feature_val}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Mileage:</p>
                                <p><input type="text" name="mileage" value='{{$basic_info['mileage']}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Air Conditioner:</p>
                                @if($feature_info['air_conditioner']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="air_conditioner" value='{{$feature_val}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Central Locking:</p>
                                 @if($feature_info['central_locking']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="central_locking" value='{{$feature_val}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Cruise Control:</p>
                                <p><input type="text" name="cruise_control" value='' /></p>
                            </div>
                            <div class="sepdetails">
                                <p>Max Power:</p>
                                <p><input type="text" name="max_power" value='{{$feature_info['max_power']}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Max Torque:</p>
                                <p><input type="text" name="max_torque" value='{{$feature_info['max_torque']}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Fuel Tank Cap:</p>
                                <p><input type="text" name="fuel_tank" value='' /></p>
                            </div>
                        </div>
                        <div class="sepfivdetails">
                            <div class="sepdetails">
                                <p>Power Steering:</p>
                                 @if($feature_info['power_steering']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="power_steering" value='{{$feature_val}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Anti-lock Braking:</p>
                                @if($feature_info['anti_lock_braking_system']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="anti_lock" value='{{$feature_val}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>ICE System:</p>
                                <p><input type="text" name="ice_system" value='' /></p>
                            </div>
                            <div class="sepdetails">
                                <p>Gear Box:</p>
                                @if($feature_info['gear_box']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="gear_box" value='{{$feature_val}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Clutch Type:</p>
                                <p><input type="text" name="clutch_type" value='' /></p>
                            </div>
                            <div class="sepdetails">
                                <p>Tyre Type:</p>
                                 @if($feature_info['tyre_type']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="tyre_type" value='{{$feature_val}}' readonly/></p>
                            </div>
                            <div class="sepdetails">
                                <p>Power Windows:</p>
                                 @if($feature_info['power_windows_front']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="power_windows_front" value='{{$feature_val}}' readonly /></p>
                            </div>
                            <div class="sepdetails">
                                <p>Airbags:</p>
                                 @if($feature_info['driver_airbags']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="driver_airbags" value='{{$feature_val}}' readonly /></p>
                            </div>
                            <div class="sepdetails">
                                <p>Alloy Wheels:</p>
                                 @if($feature_info['alloy_wheels']==1)
                                  @php ($feature_val = "YES")
                                @else
                                  @php ($feature_val = "NO")
                                @endif 
                                <p><input type="text" name="alloy_wheels" value='{{$feature_val}}' readonly/></p>
                            </div>
                        </div>
                    </div>
                    <div class="car_specifications"> 
                        <button type="button">Comments:</button>
                        <textarea name="comments"></textarea>
                    </div>
                </div>
                <div class="footerdiv">
                    <a href="" class="logo"><img src="{{URL::asset('img/logo.png')}}" class="img-responsive" alt=""></a>
                </div>
            </div>
        </div>
        <input type="hidden" name="listid" value="{{$basic_info['listid']}}">
        </form>

<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/fileinput.js')}}"></script>
<script>
    $(document).ready(function () {
        //$('Input[type="text"]').prop('readonly',true);
        $("#printpdf").click(function(e){
            //alert("sfsdfsdf")
            $("#inventorylist_stickerpdf").submit();
        });

    });
</script> 
    </body> 

</html>