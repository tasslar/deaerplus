<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">
        <title>Dealer Plus</title>
        <link rel='shortcut icon' href="{{URL::asset('img/dealerplus_fav.ico')}}" type='image/x-icon'/ >
              <!-- Font awesome -->
              <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}">
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-social.css')}}">
        <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-select.css')}}">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="{{URL::asset('css/awesome-bootstrap-checkbox.css')}}">
        <!-- Admin Stye -->
        <!-- picedit plugin -->
        <link rel="stylesheet" href="{{URL::asset('css/picedit.css')}}">
        <link rel="stylesheet" href="{{URL::asset('css/img-edit.css')}}">

        <link type="text/css" href="{{URL::asset('cometchat/cometchatcss.php')}}" rel="stylesheet" charset="utf-8">
        <style type='text/css'>
            .spinner_manage {
                position: fixed;
                text-align:center;
                z-index:2000;
                overflow: auto;
                width: 100%;
                height: 100%;
                opacity: .4;
                background-color:rgba(0, 0, 0, 0.5);
                padding-top:20%;
            }
            .title{height: 600px;
            position: relative;
            top: 0;
            left: 0;
            display: table;
            width: 100%;
            }
            .errortitle{height: 60px;
            position: relative;
            top: 0;
            left: 0;
            display: table;
            width: 100%;
            }
            .err-cont{
                display: table-cell;
                vertical-align: middle;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
            }
            .err-contmsg{
                margin-top: -100px;
                vertical-align: middle;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
            }
        </style>        
    <div id="loadspinner" class="spinner_manage"  style="display:none">
        <img id="img-spinner" src="{{url('ajax-loader.gif')}}" alt="Loading" />
    </div>
    <script type="text/javascript" src="{{URL::asset('cometchat/cometchatjs.php')}}" charset="utf-8"></script>
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="brand container">
        
        <div class="row">
            <div class="col-sm-2 col-xs-7 hidden-logo"><a href="{{url('dashboard')}}" class="logo"><img src="{{url('img/logo.png')}}" class="img-responsive" alt=""></a></div>
            <div class="col-sm-2 col-xs-3 show-logo hidden-xs hidden-lg hidden-md hidden-sm"><a href="{{url('dashboard')}}" class="logo"><img src="{{url('img/logo-mob.png')}}" class="img-responsive" alt=""></a></div>
            <div class="col-sm-9"><div class="row"><span class="menu-btn"><i class="fa fa-bars"></i></span>
                    <span class="searching-click hidden-md hidden-lg"><a href="#" class="search-click"><i class="fa fa-search"></i></a></span>
                    <span class="searching-click hidden-md hidden-lg notification"><a href="#" class="msg-3-res"><i class="fa fa-bell"></i><span>{{$header_data['alert_count']}}</span></a></span>
                    <span class="searching-click hidden-md hidden-lg notification"><a href="#" class="msg-1-res"><i class="fa fa-envelope"></i><span>{{$header_data['email_count']}}</span></a></span>
                    <span class="searching-click hidden-md hidden-lg notification"><a href="#" class="msg-2-res"><i class="fa fa-laptop"></i><span>{{$header_data['dealer_notification']}}</span></a></span>
                </div></div>
                <div class="col-sm-10 col-xs-9 hidden-xs hidden-sm"><ul class="ts-profile-nav row">
                    <li class=""><a href="{{url('dashboard')}}">Dashboard</a></li>
                    <li class=""><a href="{{url('buy')}}">Buy</a></li>
                    <li class=""><a href="{{url('managelisting')}}">Sell</a></li>
                    <li class=""><a href="{{url('myeditaccount')}}">Manage</a></li>
                    <li class=""><a href="{{url('viewfunding')}}">Funding</a></li>
                    <li class=""><a href="{{url('manage_invoice')}}">Accounts</a></li>
                    <li><a href="{{url('/reports')}}">Reports</a></li>
                    <li><a href="#" class="search-click"><i class="fa fa-search"></i></a></li>
                    @if($header_data['alert_count'] == 0)
                    <li class="notification" id="msg-3"><a href="{{url('alert')}}"><i class="fa fa-bell"></i></a></li>
                    @else
                    <li class="notification" id="msg-3"><a href="{{url('alert')}}"><i class="fa fa-bell"></i><span id="b_alert">{{$header_data['alert_count']}}</span></a></li>
                    @endif
                    @if($header_data['dealer_notification'] == 0)
                    <li class="notification" id="msg-1"><a href="#"><i class="fa fa-envelope"></i></a></li>
                    @else
                    <li class="notification" id="msg-1"><a href="#"><i class="fa fa-envelope"></i><span>{{$header_data['dealer_notification']}}</span></a></li>
                    @endif
                    @if($header_data['email_count'] == 0)
                    <li class="notification" id="msg-2"><a href="{{url('system_notification')}}"><i class="fa fa-laptop"></i></a></li>
                    @else
                    <li class="notification" id="msg-2"><a href="{{url('system_notification')}}"><i class="fa fa-laptop"></i><span>{{$header_data['email_count']}}</span></a></li>
                    @endif
                    <li class="ts-account">
                        <a href="#"><img src="{{url($header_data['logo'])}}" class="ts-avatar hidden-side" alt=""> Hi {{$header_data['dealer_name']}}  <i class="fa fa-angle-down hidden-side"></i></a>
                        <ul>
                            <li><a href="{{url('myeditaccount')}}">My Account</a></li>
                            <li><a href="{{url('dealerchangepassword')}}">Change Password</a></li>
                            <li><a href="{{url('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul></div>
        </div>

        <div class="container" id="search-slide" style="display: block;">
            <div class="row top-search">
                <form method="post" action="dealer_search" id="search_values" enctype="multipart/form-data">
                    <input type="hidden" name="search_listing" class="dealer_value" value="">
                    <input type="hidden" name="page_name" value="detail_searchpage">    
                    <input type="hidden" name="search_listing" id="car_searchs" value="">
                    <div class="input-group-btn search-panel">
                        <select class="col-xs-12 col-sm-12 btn btn-primary select_value" name="filter">
                            <option value="1">Dealers</option>
                            <option value="2">Cars</option>
                        </select>
                    </div>
                    <input data-validation="required, length" data-validation-length="min3" data-validation-optional="false" type="text" class="form-control search_value input_search" minlength="4"  placeholder="Search term..." name="search_listing">
                    <input type="hidden" name="" class="" id="search_param">
                    <span class="input-group-btn">
                        <button class="btn btn-primary search" type="button" id="serach_btn"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                    <input type="hidden" name="page_name" value="detail_searchpage">
                    <span class="searchspan">(Minimum 3 Characters)</span>
                </form>
            </div>
        </div>
        <div class="sys-notify col-sm-4 col-xs-12">
            <div class="row">
                <div><p class="col-sm-12 col-md-12 col-xs-12 text-center noti-heading">Inbox</p></div>
                <ul class="col-xs-12 col-sm-12 notify-msg">
                    @if(!empty($header_data['dealer_notification_list']))
                    @foreach($header_data['dealer_notification_list'] as $key)
                    <li>
                        @if($key['notification_type']=='1')
                        <a href="{{url('sentQueries')}}?i={{$key['contact_transactioncode']}}">
                        @else
                        <a href="{{url('ReceiveQueries')}}?i={{$key['contact_transactioncode']}}">
                        @endif
                            <div class="col-xs-3 tag-chat"><span class="label label-success">{{$key['notification_type']}}</span></div>
                            <div class="col-xs-8 {{$key['notification_type']}}"><p class="text-notify">{{Carbon\Carbon::parse($key['created_at'])->format('d-m-Y')}}  {{$key['title']}}</p></div>
                        </a>
                    </li>
                    @endforeach
                    @else
                    <li>
                        <div class="col-xs-12 msg-not">You do not have any new notifications.</div>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="row chat-button"><div class="col-sm-4 col-md-2 col-xs-12 btn btn-primary"><a href="#">Bids</a></div>
                <div class="col-sm-8 col-md-5 col-xs-12 btn btn-primary"><a href="{{url('doQueriesReceived')}}"> Queries Received</a></div>
                <div class="col-sm-12 col-md-5 col-xs-12 btn btn-primary"><a href="{{url('queries_car')}}">Sent Queries</a></div></div>
        </div>
        <div class="sys-notify-msg col-sm-3 col-xs-12">
            <div class="row">
                <div><p class="col-sm-12 col-md-12 col-xs-12 text-center noti-heading">Dealerplus Notification</p></div>
                <ul class="col-xs-12 col-sm-12 notify-msg">
                    @if(!empty($header_data['sys_notification_list']))
                    @foreach($header_data['sys_notification_list'] as $key)
                    <li>
                      <a href="{{url('system_notification')}}" data-id="{{$key['tid']}}">
                      <div class="col-xs-3 tag-chat"><span class="label label-success">{{Carbon\Carbon::parse($key['created_at'])->format('d-m-Y')}}</span></div>
                      <div class="col-xs-8 msg-not">{{$key['title']}}</div>
                      </a>
                    </li>
                    @endforeach
                    @else
                    <li>
                        <div class="col-xs-12 msg-not">You do not have any new notifications.</div>
                    </li>
                    @endif
                </ul>
                <div><a href="{{url('system_notification')}}" class="col-sm-12 col-md-12 col-xs-12 btn btn-primary">View All Notifications</a></div>
            </div>
        </div>
        <div class="sys-notify-alert col-sm-3 col-xs-12">
            <div class="row">
                <div><p class="col-sm-12 col-md-12 col-xs-12 text-center noti-heading">Alerts</p></div>
                <ul class="col-xs-12 col-sm-12 notify-msg">
                    @if(!empty($header_data['dealer_alert_list']))
                    @foreach($header_data['dealer_alert_list'] as $key)
                    <li>
                        <a href="{{url('detail_car_listing/'.$key['alert_listingid'])}}"><div class="col-xs-3 tag-chat"><span class="label label-success">{{$key['alert_type']}}</span></div>
                            <div class="col-xs-9 {{$key['alert_type']}}"><p class="text-notify">{{$key['alert_title']}}</p></div></a>
                    </li>
                    @endforeach
                    @else
                    <li>
                        <div class="col-xs-12 msg-not">You do not have any new Alerts.</div>
                    </li>
                    @endif
                </ul>
                <div><a href="{{url('alert')}}" class="col-sm-12 col-md-12 col-xs-12 btn btn-primary">Manage My Alerts</a></div>
            </div>
        </div>
    </div>
    <form method="post" id="car_search" action="searchcarlisting">
        <input type="hidden" name="page_name" value="detail_searchpage">    
        <input type="hidden" name="search_listing" id="car_searchs" value="">
    </form>

    
        <div class="container-fluid">
            <div class="row">
            <div class="container">
                <div class="content">
                    <div class="title">
                    <div class="err-cont"><img src="{{url('img/icon-error.png')}}"></img></div>
                </div>
            <div class="errortitle">
                <div class="err-contmsg">Some error occurred. Please try again.</div>
            </div>
            </div>
        </div>
        </div>
        </div>
    </body>
    @include('footer')
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/fileinput.js')}}"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="{{URL::asset('js/Chart.min.js')}}"></script>
</html>
