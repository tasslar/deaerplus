
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
            p{margin: 0px;padding: 0px;line-height: 22px;font-size: 12px;}
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            body{margin: 0px;padding: 0px;}
            tr,td,th{border: none;}

        </style>
    </head>
    <body>
        <table align="center" width="100%" cellspacing="0" cellpadding="0"  class="tbl" style="border: 3px solid #23527c;">
            <tbody>
                <tr>
                    <td>
                        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td align="left" valign="middle" style="padding:0;margin:0;font-size:0;line-height:0;width: 33%;"><a href="http://www.codexworld.com/" target="_blank"><img src="{{URL::asset('img/logo.png')}}" style="width: 170px;"></a></td>
                                    <td style="width: 29%;"><p style="color: #fff;text-align: center;text-transform: uppercase;font-weight: bold;font-size: 20px;background:#23527c;padding:10px">For Sale</p></td>
                                    <td  style="width: 4%;"></td>
                                    <td style="width: 29%;text-align: right">
                                        <p style="margin-top:10px;  "><img src="{{url($basic_info['logo'])}}" class="ts-avatar hidden-side" alt="" style="max-height: 20px;">   {{$basic_info['dealername']}}</p>
                                        <p style="">{{$basic_info['email']}}</p>
                                        <p style="">{{$basic_info['mobile']}}</p></td>
                                    <td  style="width: 2%;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background:#23527c;margin-top:10px;margin-bottom: 10px;padding: 10px 0px;">
                            <tbody>
                                <tr>
                                    <td style="width: 2%"></td>
                                    <td style="width: 48%;border-right: 1px solid #fff;font-size: 16px;text-transform: uppercase;margin: 8px 0px;letter-spacing: 1px;color: #fff;font-weight: bold">
                                        <p>{{$basic_info['registration_year']}}</b></p>
                                        <p>{{$basic_info['make']}} {{$basic_info['model']}}</p>
                                        <p>{{$basic_info['variant']}}</p>
                                        <p>{{$basic_info['mileage']}} KMPL,{{$basic_info['kilometer_run']}} KMS</p>
                                    </td>
                                    <td style="width:2%"></td>
                                    <td style="width: 46%;">
                                        <p style="font-size: 26px;margin: 50px 0px;color: #fff;font-weight: bold">Sales Prices : <b>{{$basic_info['price']}}</b></p>
                                    </td>
                                    <td style="width:2%"></td>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>    
                        <table style="width: 100%;margin-top:10px;margin-bottom: 10px;" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td style="width: 2%"></td>
                                    <td style="width:15.16%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 5px 0.5%;position: relative;border:1px solid #ccc">
                                        <h5 style="text-align: center;margin:5px 0px;">Fuel Type</h5>
                                        <p style="text-align: center;">{{$basic_info['fuel_type']}}</p>
                                    </td>
                                    <td style="width: 1%"></td>
                                    <td style="width:15.16%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 5px 0.5%;position: relative;border:1px solid #ccc">
                                        <h5 style="text-align: center;margin:5px 0px;">Body Style</h5>
                                        <p style="text-align: center;">{{$basic_info['body_type']}}</p></td>
                                    <td style="width: 1%"></td>
                                    <td style="width:15.16%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 5px 0.5%;position: relative;border:1px solid #ccc">
                                        <h5 style="text-align: center;margin:5px 0px;">Drivetrain</h5>
                                        <p style="text-align: center;">{{$basic_info['drivetrain']}}</p></td>
                                    <td style="width: 1%"></td>
                                    <td style="width:15.16%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 5px 0.5%;position: relative;border:1px solid #ccc">
                                        <h5 style="text-align: center;margin:5px 0px;">Certified & Warranty</h5>
                                        <p style="text-align: center;">{{$basic_info['certified']}}</p></td>
                                    <td style="width: 1%"></td>
                                    <td style="width:15.16%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 5px 0.5%;position: relative;border:1px solid #ccc">
                                        <h5 style="text-align: center;margin:5px 0px;">No. Of Owners</h5>
                                        <p style="text-align: center;">{{$basic_info['owners']}}</p></td>
                                    <td style="width: 1%"></td>
                                    <td style="width:15.16%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 5px 0.5%;position: relative;border:1px solid #ccc">
                                        <h5 style="text-align: center;margin:5px 0px;">Transmissions</h5>
                                        <p style="text-align: center;">{{$basic_info['transmission']}}</p></td>
                                    <td style="width:2%"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%;margin:10px 0px;" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td style="width: 5%;float: left;"></td>
                                    <td style="width: 40%;float: left;">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Displacement </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['displacement']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Cylinders </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['cylinders']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Mileage </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['mileage']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Air Conditioner </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['air_conditioner']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Central Locking </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['central_locking']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Cruise Control </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['cruise_control']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Max Power </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['max_power']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Max Torque </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['max_torque']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Fuel Tank Cap </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['fuel_tank']}}</p>                                                      
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="width: 5%;float: left;"></td>                                  
                                    <td style="width: 40%;float: left;">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Power Steering </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['power_steering']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Anti-lock Braking </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['anti_lock']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">ICE System </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['ice_system']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Gear Box </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['gear_box']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Clutch Type </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['clutch_type']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Tyre Type </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['tyre_type']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Power Windows </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['power_windows_front']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Airbags </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['driver_airbags']}}</p>                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="font-weight: bold;text-align:center">Alloy Wheels </p>
                                                    </td>
                                                    <td style="box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                                        <p style="text-align:center">{{$basic_info['alloy_wheels']}}</p>                                                      
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>                                    
                                    <td style="width: 5%;float: left;"></td>
                                </tr>
                            </tbody>
                        </table> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>                                    
                                    <td style="width: 5%;float: left;"></td>
                                    <td style="width: 90%;float: left;box-shadow: 0px 0px 1px #000;margin: 0.5%;padding: 0.5%;position: relative;border:1px solid #ccc">
                                        <p style="font-weight: bold">Comments:</p>
                                        <p>{{$basic_info['comments']}}</p>
                                    </td>
                                    <td style="width: 5%;float: left;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;" >
                        <a href="" ><img src="{{URL::asset('img/logo.png')}}"  style="width: 170px;margin-bottom: 10px;"></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>     
</html>