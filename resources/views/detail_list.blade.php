<style type="text/css">.pac-logo{z-index: 999999;}</style>
@include('header')

@include('sidebar')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            @if(!empty($detail_list_data))
            <div class="content-header col-xs-12">
                <div class="input-group mb searching col-sm-6 hidden-md hidden-lg">
                    <div class="input-group-btn search-panel">
                        <select class="btn btn-primary">
                            <option value="">Filter</option>
                            <option value="1">Inventory</option>
                            <option value="2">Custom</option>
                            <option value="3">Dealers</option>
                            <option value="4">Cars</option></select>
                    </div>
                    <input type="hidden" name="search_param" value="all" id="search_param">         
                    <input type="text" class="form-control" name="x" placeholder="Search term...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">{{$detail_list_data['make']}}</li>
                </ol>
            </div>

            <div class="col-xs-12 detail-page">
                <div class="col-xs-12 col-md-9">Listing Id:{{$detail_list_data['car_id']}} | Listing Date: {{$detail_list_data['created_at']}} </div>
                @if(isset($detail_list_data['listing_error_msg'])&&$detail_list_data['listing_error_msg']!='')<div class="col-md-3 col-xs-12 highlight-txt"> {{$detail_list_data['listing_error_msg']}}
                
                </div>@endif
                <div class="row detail-head">

                    <input type="hidden" name="id" id="car_id" value="{{$detail_list_data['car_id']}}">
                    <input type="hidden" name="dealer_id" id="dealer_id" value="{{$detail_list_data['dealer_id']}}">

                    <input type="hidden" name="make" id="make" value="{{$detail_list_data['make']}}">
                    <input type="hidden" name="model_name" id="model_name" value="{{$detail_list_data['model']}}">

                    <input type="hidden" name="regyear" id="regyear" value="{{$detail_list_data['registration_year']}}">

                    <input type="hidden" name="fuel" id="fuel" value="{{$detail_list_data['fuel_type']}}">

                    <input type="hidden" name="city_name" id="city_name" value="{{$dealer_info['d_city']}}">
                    
                    <input type="hidden" name="variant" id="variant" value="{{$detail_list_data['variant']}}">
                    <input type="hidden" name="title" id="title" value="{{$detail_list_data['make']}} {{$detail_list_data['model']}} {{$detail_list_data['variant']}}">

                    <div class="col-sm-7 col-xs-12"><span class="detail-title1">{{$detail_list_data['model']}} {{$detail_list_data['variant']}} {{$detail_list_data['registration_year']}} <img src="{{$detail_list_data['site_image']}}" alt=""></span></div>
                    
                    
                    <div class="col-xs-5 col-sm-3"><span class="rate-detail detail-title1">Rs. {{$detail_list_data['price']}}</span></div>
                    @if($detail_list_data['listing_page']=='1')
                    <div class="col-xs-7 col-sm-2">
                        <ul class="detail-share detail-title1 pull-right">

                            <li id="email-alert-send"><span><i class="fa fa-bell alertlisting @if($detail_list_data['count_dealer_alert_cars']==1) {{'detail-wishlist-active'}} @endif" data-toggle="tooltip" title="" data-original-title="Alert" data-placement="top" data-car-id="{{$detail_list_data['car_id']}}"  data-make="{{$detail_list_data['make']}}" data-model-name="{{$detail_list_data['model']}}" data-regyear="{{$detail_list_data['registration_year']}}" data-variant="{{$detail_list_data['make']}}" data-fuel="{{$detail_list_data['fuel_type']}}" data-city="{{$detail_list_data['car_city']}}"></i></span></li>

                            <li><a data-toggle="modal" data-target="#myModal" title="Share"><i class="fa fa-share"></i></a></li>
                            @if($detail_list_data['count_dealer_saved_cars']==1)
                            <li><a data-toggle="modal" title="WatchList"><i class="fa fa-heart saved_car detail-wishlist-active" data-car-id="{{$detail_list_data['car_id']}}"></i></a></li>
                            @else
                            <li><a data-toggle="modal" title="WatchList"><i class="fa fa-heart saved_car" data-car-id="{{$detail_list_data['car_id']}}"></i></a></li>
                            @endif
                            <!-- <li><a data-toggle="modal" title="Email Alert" data-target="#myEmail"><i class="fa  fa-money"></i></a></li> -->
                            @if($detail_list_data['auction']==1)
                            <li><a data-toggle="modal" class="biding_car" title="Bidding Car" data-target="#bidding_popup" data-car-id="{{$detail_list_data['car_id']}}" data-dealer-id="{{$detail_list_data['dealer_id']}}"><i class="fa  fa-money"></i></a></li>
                            @endif

                        </ul></div>
                    @endif
                </div>
                <div class="hr-dashed"></div>
                <div class="row detail-top">
                    <div class="col-sm-7 col-xs-12">
                        <div class="col-xs-6 col-sm-2">
                            <div class="buylist-box">
                                <h4>Owner</h4>
                                <p title="{{$detail_list_data['owner_type']}}">{{$detail_list_data['owner_type']}}</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-2">
                            <div class="buylist-box">
                                <h4>Color</h4>
                                <p title="{{$detail_list_data['colors']}}">{{$detail_list_data['colors']}}</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-2">
                            <div class="buylist-box">
                                <h4>Fuel</h4>
                                <p title="{{$detail_list_data['fuel_type']}}">{{$detail_list_data['fuel_type']}}</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-2">
                            <div class="buylist-box">
                                <h4>Seats</h4>
                                <p title="{{$detail_list_data['seating_capacity']}}">
                                    @if(empty($detail_list_data['seating_capacity']))
                                    0
                                    @else
                                    {{$detail_list_data['seating_capacity']}}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-2">
                            <div class="buylist-box">
                                <h4>Transmission</h4>
                                <p title="{{$detail_list_data['transmission']}}">{{$detail_list_data['transmission']}}</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-2">
                            <div class="buylist-box">
                                <h4>Place</h4>
                                <p title="{{$detail_list_data['car_city']}}">{{$detail_list_data['car_city']}}</p>
                            </div>
                        </div>
                        <div id="jssor_1" class="slider-style">
                            <!-- Loading Screen -->

                            <div data-u="slides" class="main-slide">
                                @if(!empty($detail_list_data['image_url']))
                                @foreach($detail_list_data['image_url'] as $key => $value)
                                <div>
                                    <img data-u="image" src="{{$value['imagelink']}}" />
                                    <p class="text-slider">{{$value['imagename']}}</p>
                                    <img data-u="thumb" src="{{$value['imagelink']}}" />
                                </div>
                                @endforeach
                                @endif
                                @if(!empty($detail_list_data['video_url']))
                                @foreach($detail_list_data['video_url'] as $key => $value)
                                <div>
                                    <video class="video-responsive" controls>
                                        <source src="{{$value}}" type="video/mp4">
                                        <img data-u="image" src="{{$value}}" />
                                        <img data-u="thumb" src="{{$value}}" />
                                </div>
                                @endforeach
                                @endif


                            </div>
                            <!-- Thumbnail Navigator -->
                            <div data-u="thumbnavigator" class="jssort01" data-autocenter="1">
                                <!-- Thumbnail Item Skin Begin -->
                                <div data-u="slides" style="cursor: default;">
                                    <div data-u="prototype" class="p">
                                        <div class="w">
                                            <div data-u="thumbnailtemplate" class="t"></div>
                                        </div>
                                        <div class="c"></div>
                                    </div>
                                </div>
                                <!-- Thumbnail Item Skin End -->
                            </div>
                            <!-- Arrow Navigator -->
                            <span data-u="arrowleft" class="jssora05l" style="top:158px;left:8px;width:40px;height:40px;"></span>
                            <span data-u="arrowright" class="jssora05r" style="top:158px;right:8px;width:40px;height:40px;"></span>
                        </div></div>
                    @if($detail_list_data['listing_page']==1)
                    <div class="col-sm-5">
                        @else
                        <div class="col-sm-5" style="display: none;">
                            @endif
                            <div class="col-sm-12 col-xs-12"><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading tab-detail" role="tab">
                                            <h4 class="tabdetail-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#detailOne">
                                                    <span class="detail-span"><i class="fa fa-envelope"></i></span> Send Message to Dealer
                                                </a>
                                            </h4>
                                        </div>
                                        @if($detail_list_data['contactmessagestatus']<=0)
                                        <div id="detailOne" class="panel-collapse collapse  col-xs-12 panel-body" role="tabpanel">
                                            <div id="alertmsg"></div>

                                            <form method="get" class="form-horizontal">
                                                <div class="form-group">
                                                    <div class="col-sm-12">

                                                        <input type="text" id="contact_dealer_name" value="{{$detail_list_data['car_owner_name']}}" class="form-control" readonly="readonly" />
                                                        <input type="hidden" name="sell_price" id="sell_price" value="{{$detail_list_data['price']}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <input type="mail" id="contact_dealer_mailid" value="{{$detail_list_data['car_owner_email']}}" class="form-control"
                                                               readonly="readonly"
                                                               >
                                                    </div></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <textarea class="detail-textarea form-control" id="contact_dealer_message"></textarea>
                                                    </div></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 col-sm-offset-9">
                                                        <button class="btn btn-primary btn-sm" type="button" id="contact_dealer_button">Send</button>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                        @else
                                        <div id="detailOne" class="panel-collapse collapse  col-xs-12" role="tabpanel">
                                            Already Message Sent
                                        </div>
                                        @endif
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading tab-detail" role="tab">
                                            <h4 class="tabdetail-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#detailTwo">
                                                    <span class="detail-span"><i class="fa fa-info-circle"></i></span> Dealer Info
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="detailTwo" class="panel-collapse collapse col-xs-12 panel-body" role="tabpanel">

                                            <div class="col-sm-12">
                                                <div class="col-sm-4 col-xs-12"><img src="{{$detail_list_data['lister_logo']}}" class="img-responsive"></div>
                                                <div class="col-sm-8 col-xs-12"><h3 class="detail-address-head">{{$detail_list_data['car_owner_name']}}</h3>
                                                <p class="detail-address"><i class="fa fa-map-marker"></i> {{$detail_list_data['car_city']}}</p>
                                                <p class="detail-address"><i class="fa fa-envelope-o"></i> {{$detail_list_data['car_owner_email']}}</p>
                                                <p class="detail-address"><i class="fa fa-phone"></i> {{$detail_list_data['car_owner_mobile']}}</p></div>

                                        </div>
                                    </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading  tab-detail" role="tab">
                                            <h4 class="tabdetail-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#detailThree">
                                                    <span class="detail-span"><i class="fa fa-clone"></i></span> Get Funding to Buy
                                                </a>
                                            </h4>
                                        </div>
                                        @if(isset($fundingticket) &&  $fundingticket == "")
                                        <div id="detailThree" class="panel-collapse collapse col-xs-12 panel-body" role="tabpanel">

                                            <form method="post" id="fundingform" class="form-horizontal">
                                            
                                            <input type="hidden" name="ownermail" value="{{$detail_list_data['car_owner_email']}}">
                                            <input type="hidden" name="ownername" value="{{$detail_list_data['car_owner_name']}}">
                                            <input type="hidden" name="ownerid" value="{{$detail_list_data['dealer_id']}}">
                                            <input type="hidden" name="listingid" value="{{$detail_list_data['car_id']}}">
                                            <input type="hidden" name="car_id" value="">
                                            <input type="hidden" name="make" value="{{$detail_list_data['make']}}">
                                            <input type="hidden" name="model_name" value="{{$detail_list_data['model']}}">
                                            <input type="hidden" name="variant" value="{{$detail_list_data['variant']}}">
                                                <div class="col-xs-12 col-sm-5 get-loan">
                                                    <div class="form-group field-wrapper1">
                                                        <label>Dealership Name</label>
                                                        <input type="text" class="form-control" placeholder="Dealership name" name="dealershipname" value="{{$dealer_info['dealership_name']}}" readonly>
                                                    </div></div>
                                                <input type="hidden" class="form-control fundingamount" value="{{$detail_list_data['price']}}"  name="originalfundingamount">
                                                <div class="col-xs-12 col-sm-5 get-loan">
                                                    <div class="form-group field-wrapper1">
                                                        <label>Dealer Name</label>
                                                        <input type="text" class="form-control" placeholder="Dealer Name" name="dealername" value="{{$dealer_info['dealer_name']}}" readonly>
                                                    </div></div>
                                                <div class="col-xs-12 col-sm-5 get-loan">
                                                    <div class="form-group field-wrapper1">
                                                        <label>Email Id</label>
                                                        <input type="mail" class="form-control" placeholder="Email Id" name="emailid" value="{{$dealer_info['d_email']}}" readonly>
                                                    </div></div>
                                                <div class="col-xs-12 col-sm-5 get-loan">
                                                    <div class="form-group field-wrapper1">
                                                        <label>Mobile Number</label>
                                                        <input type="text" class="form-control" placeholder="Mobile Number" value="{{$dealer_info['d_mobile']}}"  name="mobilenumber" readonly> 
                                                    </div></div>
                                                <div class="col-xs-12 col-sm-5 get-loan">
                                                    <div class="form-group field-wrapper1">
                                                        <label>Amount required</label>
                                                        <input type="text" class="form-control data-number fundingofamount" placeholder="Amount Required" value="" name="fundingamount">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-5 get-loan">
                                                    <div class="form-group field-wrapper1">
                                                        <label>Date</label>
                                                        <input type="text" class="form-control date datetimepickerfund" placeholder="Date" name="date" readonly>
                                                        
                                                    </div></div>
                                                <div class="col-xs-12 col-sm-5 get-loan">
                                                    <div class="form-group field-wrapper1">
                                                        <label>City</label>
                                                        <input type="mail" class="form-control" placeholder="City" value="{{$dealer_info['d_city']}}"  name="place" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-3 pull-right">
                                                    <div class="form-group">
                                                        <input class="btn btn-primary" type="submit" value="Submit" name="FundingRegister">
                                                    </div></div>
                                            </form>

                                        </div>
                                        @else
                                        <div id="detailThree" class="panel-collapse collapse  col-xs-12" role="tabpanel">
                                            Inventory Funding is already applied for this vehicle. Please click here <a href="{{url('viewfunding')}}?FundingTicketid='{{$fundingticketid == ''?'':$fundingticketid}}'">{{$fundingticket == ''?'':$fundingticket}}</a> to view 
                                        </div>
                                        @endif
                                    </div>
                                <!--funding error popup start-->
                                <div class="modal fade" id="funddeleteresult" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                            <div class="modal-body">
                                                <div class="row"> 
                                                    <div class="col-xs-12">
                                                        <div class="alert alert-danger successfunding">
                                                        <a class="errorfundingalert"></a>
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!--funding error popup end-->
                                    <div class="panel panel-default">
                                        <div class="panel-heading tab-detail">
                                            <h4 class="tabdetail-title">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#detailFour" aria-expanded="true">
                                                    <span class="detail-span"><i class="fa fa-map-pin"></i></span> Get Directions
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="detailFour" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true">
                                            <div class="panel-body">
                                                <iframe src="https://maps.google.it/maps?q={{$detail_list_data['car_city']}}&amp;output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-button">
                                        <div class="chatlist-box">
                                            <select class="btn btn-primary col-xs-12 listreport">
                                                <option value=''>Report this listing</option>
                                                <option value="1" @if($detail_list_data['reporting_list_details']==1) {{'selected'}} @endif >Car Not Available</option>
                                                <option value="2" @if($detail_list_data['reporting_list_details']==2) {{'selected'}} @endif >Inaccurate Price</option>
                                                <option value="3" @if($detail_list_data['reporting_list_details']==3) {{'selected'}} @endif >Scam</option>
                                                <option value="5" @if($detail_list_data['reporting_list_details']==5) {{'selected'}} @endif >Image mismatch</option>
                                                <option value="4" @if($detail_list_data['reporting_list_details']==4) {{'selected'}} @endif >Others</option>

                                            </select>
                                        </div>
                                        <div class="chatlist-box">
                                            <button type="button" class="btn btn-primary btn-sm cometchat" data-comet-id="cometchat_userlist_{{$detail_list_data['dealer_id']}}"><span class="status-icon icon-online"></span>
                                               <aside class="pull-left"> <i class="fa fa-wechat"></i>  Chat</aside>			
                                            </button>
                                        </div>
                                        @if($detail_list_data['test_drive']==1)

                                        <div class="chatlist-box">
                                            <a data-toggle="modal" class="test_drive btn btn-primary btn-sm" title="Test Drive" data-target="#testdrive_popup" data-car-id="{{$detail_list_data['car_id']}}" data-dealer-id="{{$detail_list_data['dealer_id']}}"><i class="fa  fa-automobile"></i> Test Drive <img src="{{url('img/tick1.png')}}"></a>
                                        </div>
                                        @else
                                        <div class="chatlist-box">
                                            <a class="tabdetail-title btn btn-primary btn-sm" title="Test Drive" ><i class="fa  fa-automobile"></i> Test Drive <img src="{{url('img/wrong1.png')}}"></a>
                                        </div>
                                        @endif
<!--                                        <div class="chatlist-box">
                                            <a href="#" class="btn btn-primary btn-sm pull-right"><i class="fa fa-phone"></i> Call</a>				
                                        </div>-->
                                    </div>

                                
                            </div>
                        </div>
                        </div>
                    </div>		
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Engine<span class="pull-right detail-icon"><i class="fa fa-safari"></i></span></h3>

                                </div>
                                <div class="panel-body">
                                    <div class="row"><div class="col-xs-6">Model:</div><div class="col-xs-6">{{$detail_list_data['model']}}</div>
                                        <div class="col-xs-6">Fuel:</div><div class="col-xs-6">{{$detail_list_data['fuel_type']}}</div>
                                        <div class="col-xs-6">Owner:</div><div class="col-xs-6">{{$detail_list_data['owner_type']}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">FEATURES<span class="pull-right detail-icon"><i class="fa fa-paper-plane"></i></span></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row"><div class="col-xs-6">Color:</div><div class="col-xs-6">
                                            @if($detail_list_data['colors']!='')
                                            {{$detail_list_data['colors']}}
                                            @else
                                            -
                                            @endif
                                        </div>
                                        <div class="col-xs-6">Transmission:</div><div class="col-xs-6">
                                            @if($detail_list_data['transmission']!='')
                                            {{$detail_list_data['transmission']}}
                                            @else
                                            -
                                            @endif
                                        </div>
                                        <div class="col-xs-6">Total Distance:</div><div class="col-xs-6">
                                            @if($detail_list_data['kilometer_run']!='')
                                            {{$detail_list_data['kilometer_run']}}
                                            @else
                                            -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Comfort<span class="pull-right detail-icon"><i class="fa fa-automobile"></i></span></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row"><div class="col-xs-6">Body Type:</div><div class="col-xs-6">
                                            @if($detail_list_data['body_type']!='')
                                            {{$detail_list_data['body_type']}}
                                            @else
                                            <img src="{{url('img/wrong1.png')}}" />
                                            @endif
                                        </div>
                                        <br>
                                        <div class="col-xs-6">Seats:</div><div class="col-xs-6">
                                            @if($detail_list_data['seating_capacity']!='')
                                            {{$detail_list_data['seating_capacity']}}
                                            @else
                                            -
                                            @endif
                                        </div>
                                        <br>
                                        <div class="col-xs-6">AC:</div><div class="col-xs-6">
                                            @if($detail_list_data['air_conditioner']!='')
                                            <img src="{{url('img/tick1.png')}}" />
                                            @else
                                            <img src="{{url('img/wrong1.png')}}" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Safety<span class="pull-right detail-icon"><i class="fa fa-user-secret"></i></span></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row"><div class="col-xs-6">Air Bag:</div><div class="col-xs-6">
                                            @if($detail_list_data['airbag']==1)
                                            <img src="{{url('img/tick1.png')}}" />
                                            @else
                                            <img src="{{url('img/wrong1.png')}}" />
                                            @endif
                                        </div>
                                        <br>
                                        <div class="col-xs-6">Mileage:</div><div class="col-xs-6">{{$detail_list_data['mileage']}}</div>
                                        <br>
                                        <div class="col-xs-6">Lock:</div><div class="col-xs-6">
                                            @if($detail_list_data['central_locking']==1)
                                            <img src="{{url('img/tick1.png')}}" />
                                            @else
                                            <img src="{{url('img/wrong1.png')}}" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if(!empty($listing_features))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <!--<div class="panel-heading">Details Overview</div>-->
                                <div class="panel-body">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">SPECIFICATIONS</a></li>
                                        <li><a href="#feature" data-toggle="tab" aria-expanded="true">Features</a> 
                                        <li><a href="#overview" data-toggle="tab" aria-expanded="false">Overview</a></li>
                                        
                                        </li>
                                    </ul>
                                    <br>
                                    <div id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade" id="overview">

                                            @if($listing_features['overviewdescription']!=''&&$listing_features['overviewdescription']!='0')
                                            {{$listing_features['overviewdescription']}}
                                            @else
                                            -
                                            @endif
                                        </div>
                                        <div class="tab-pane fade  active in" id="profile">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="accordion">
                                                                Car Specification
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse collapse in colimg" role="tabpanel" aria-labelledby="headingOne">  

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Color
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$detail_list_data['colors']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Gear Box
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['gear_box']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Drive type
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                
                                                                {{$listing_features['drive_type']}}
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Seating Capacity
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                
                                                                {{$listing_features['seating_capacity']}}
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Steering type
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['steering_type']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Turning Radius
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                
                                                                {{$listing_features['turning_radius']}}
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Top Speed
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                
                                                                {{$listing_features['top_speed']}}
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Acceleration
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['acceleration']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Tyre type
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['tyre_type']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                No of doors
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['no_of_doors']}}
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed  accordion" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                Engine 
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTwo" class="panel-collapse collapse colimg" role="tabpanel" aria-labelledby="headingTwo">
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Engine Type
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['engine_type']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Displacement
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['displacement']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Max Power
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['max_power']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Max Torque
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['max_torque']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                No Of Cylinder
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['no_of_cylinder']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Valves per Cylinder
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['valves_per_cylinder']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Valve configuration
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['valve_configuration']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Fuel Supply System
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['fuel_supply_system']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Turbo Charger
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['turbo_charger']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Super Charger
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['super_charger']}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingThree">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed  accordion" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                Car Dimensions
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseThree" class="panel-collapse collapse colimg" role="tabpanel" aria-labelledby="headingThree">
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Length
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['length']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Width
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['width']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Height
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['height']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Wheel Base
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['wheel_base']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Gross Weight
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                {{$listing_features['gross_weight']}}
                                                            </div>
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="review">
                                            <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
                                        </div>
                                        <div class="tab-pane fade" id="feature">
                                            <div class="panel-group" id="accordionfeature" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordionfeature" href="#collapseonefeatures" aria-expanded="true" aria-controls="collapseonefeatures"  class="accordion">
                                                                Car Interior Features
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseonefeatures" class="panel-collapse collapse in colimg" role="tabpanel" aria-labelledby="headingonefeatures">

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Air Conditioner
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['air_conditioner']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Adjustable Steering
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['adjustable_steering']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Leather Steering Wheel
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['leather_steering_wheel']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Heater
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['heater']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Digital Clock
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['digital_clock']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>                       
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingtwofeatures">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed accordion" role="button" data-toggle="collapse" data-parent="#accordionfeature" href="#collapsetwofeatures" aria-expanded="false" aria-controls="collapsetwofeatures">
                                                                Car Comfort
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapsetwofeatures" class="panel-collapse collapse colimg" role="tabpanel" aria-labelledby="headingtwofeatures">

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Power steering
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['power_steering']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Power windows front
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['power_windows_front']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Power windows rear
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['power_windows_rear']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Remote trunk opener
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['remote_trunk_opener']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>                                                        
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Remote fuel lid opener
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['remote_fuel_lid_opener']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Low fuel warning light
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['low_fuel_warning_light']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rear reading lamp
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rear_reading_lamp']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rear seat headrest
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rear_seat_headrest']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rear seat centre arm rest
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rear_seat_centre_arm_rest']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Height adjustable front seat belts
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['height_adjustable_front_seat_belts']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Cup holders front
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['cup_holders_front']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Cup holders rear
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['cup_holders_rear']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rear ac vents
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rear_ac_vents']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Parking sensors
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['parking_sensors']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingthreefeatures">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed accordion" role="button" data-toggle="collapse" data-parent="#accordionfeature" href="#collapsethreefeatures" aria-expanded="false" aria-controls="collapsethreefeatures">
                                                                Car Safety
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapsethreefeatures" class="panel-collapse collapse colimg" role="tabpanel" aria-labelledby="headingthreefeatures">

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Anti lock braking system
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['anti_lock_braking_system']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Central locking
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['central_locking']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Child safety lock
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['child_safety_lock']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Driver airbags
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['driver_airbags']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Passenger airbag
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['passenger_airbag']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rear seat belts
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rear_seat_belts']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Seat belt warning
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['seat_belt_warning']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Adjustable seats
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['adjustable_seats']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Crash sensor
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['crash_sensor']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Anti theft device
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['anti_theft_device']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Immobilizer
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['immobilizer']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingfourfeatures">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed accordion" role="button" data-toggle="collapse" data-parent="#accordionfeature" href="#collapsefourfeatures" aria-expanded="false" aria-controls="collapsefourfeatures">
                                                                Car Exterior
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapsefourfeatures" class="panel-collapse collapse colimg" role="tabpanel" aria-labelledby="headingfourfeatures">

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Adjustable head lights
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['adjustable_head_lights']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Power adjustable exterior rear view mirror
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['power_adjustable_exterior_rear_view_mirror']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Electric folding rear view mirror
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['electric_folding_rear_view_mirror']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rain sensing wipers
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rain_sensing_wipers']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rear window wiper
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rear_window_wiper']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Alloy wheels
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['alloy_wheels']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Tinted glass
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['tinted_glass']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Front fog lights
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['front_fog_lights']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Rear window defogger
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['rear_window_defogger']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>

                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingfivefeatures">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed  accordion" role="button" data-toggle="collapse" data-parent="#accordionfeature" href="#collapsefivefeatures" aria-expanded="false" aria-controls="collapsefivefeatures">
                                                                Car Entertainment
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapsefivefeatures" class="panel-collapse collapse colimg" role="tabpanel" aria-labelledby="headingfivefeatures">

                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                CD Player
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['cdplayer']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Radio
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['radio']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Audio
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['audio']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="well well-sm col-xs-6">
                                                                Bluetooth
                                                            </div>
                                                            <div class="well well-sm col-xs-6">
                                                                @if($listing_features['bluetooth']=='1')
                                                                <img src="{{url('img/tick1.png')}}" alt=""/>
                                                                @else
                                                                <img src="{{url('img/wrong1.png')}}" alt=""/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-primary">
                                <div class="col-sm-4 col-xs-12">
                                    <h4 class="price-detail">Price Analysis</h4>
                                    <div class="hr-dashed"></div>
                                    <div class="col-xs-2 price-detail-lab">Price</div>
                                    <div class="col-xs-10"><p>Rs. 2,618 below similar cars Rs. 11,206 below MSRP</p></div>
                                </div>
                                <div class="col-sm-4 col-xs-12 price-side">
                                    <h4 class="price-detail">Condition Analysis</h4>
                                    <div class="hr-dashed"></div>
                                    <div class="col-xs-4 price-detail-lab">Mileage</div>
                                    <div class="col-xs-8"><p>{{$detail_list_data['mileage']}} KMPL below market average</p></div>
    
                                </div>
                                <div class="col-sm-4 col-xs-12 price-side">
                                    <h4 class="price-detail">History</h4>
                                    <div class="hr-dashed"></div>
                                    <div class="col-xs-4 price-detail-lab">Listed On</div>
                                    <div class="col-xs-8"><p>{{$detail_list_data['created_at']}}</p></div>
                                    <div class="col-xs-4 price-detail-lab">Price History</div>
                                    <div class="col-xs-8"><p>{{$detail_list_data['created_at']}} <span>{{$detail_list_data['price']}}</span></p></div>
                                </div></div>
    
                        </div></div> -->
                    @if($detail_list_data['auction']==1)

                    <div class="row">
                        <div class="col-xs-12" id="bid_recent">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><span><i class="fa fa-pencil-square"></i></span> Bidding Info</div>
                                <div class="panel-body">
                                    <div class="col-xs-12"><div class="col-sm-3"><p class="bid-duration">Bidders: <span class="bid-duration-span">{{$detail_list_data['bidders_count']}}</span><p></div>
                                        <div class="col-sm-3"><p class="bid-duration">Bids: <span class="bid-duration-span">{{$detail_list_data['bids_count']}}</span><p></div>
                                        <div class="col-sm-3"><p class="bid-duration">Time left: <span class="bid-duration-span time_left_duration">{{$detail_list_data['time_left']}}</span><p></div>
                                        <div class="col-sm-3"><p class="bid-duration">Duration: <span class="bid-duration-span bid_duration">{{$detail_list_data['bidding_duration']}}</span><p></div></div>
                                    <div class="col-xs-12 bid-tabel">
                                        <div class="row">
                                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead class="hidden-xs">
                                                    <tr>
                                                        <th> Bidder</th>
                                                        <th>Bidder Amount</th>
                                                        <th>Bid Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($bidding_data))
                                                    @foreach($bidding_data as $biddingfetch)
                                                    <tr>
                                                        <td  data-title="Bidder" >{{$biddingfetch['dealer_name']}}</td>
                                                        <td  data-title="Bidder Amount" >Rs. {{$biddingfetch['bidded_amount']}}</td>
                                                        <td  data-title="Bid Time" >{{$biddingfetch['delear_datetime']}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>

                                            </table>
                                        </div>
                                        <!--                                        <div class="row bid-duration">
                                                                                    <div class="col-sm-4">Bidder</div>
                                                                                    <div class="col-sm-4">Bidder Amount</div>
                                                                                    <div class="col-sm-4">Bid Time</div>
                                                                                    <div class="hr-dashed"></div>
                                                                                </div>
                                                                                @if(!empty($bidding_data))
                                                                                @foreach($bidding_data as $biddingfetch)
                                                                                <div class="row"><div class="col-sm-4">
                                                                                        {{$biddingfetch['dealer_name']}}</div>
                                                                                    <div class="col-sm-4">Rs. {{$biddingfetch['bidded_amount']}}</div>
                                                                                    <div class="col-sm-4">{{$biddingfetch['delear_datetime']}}</div>
                                                                                    <div class="hr-dashed"></div>
                                                                                </div>
                                                                                @endforeach
                                                                                @endif-->
                                    </div>
                                </div>
                            </div></div></div>
                    @endif
                    <div class="row"><div class="col-md-12"><h2 class="page-title">Similar Cars</h2>
                            <div class="col-sm-12">
                                @if(!empty($listing_details))
                                @foreach($listing_details as $document)
                                <div class="panel panel-primary alert">
                                    <div class="panel-body all-list">
                                        @if($document["saved_car"]>=1)
                                        <span class="label-list">Viewed</span>
                                        @endif
                                        <div class="col-xs-12 col-lg-4 search-image"><img src='{{$document["imagelinks"]}}' class="img-responsive style_prevu_kit" alt=""/>
                                            <p class="text-primary count-photo">{{$document["noimages"]}} photos</p>
                                        </div>
                                        <div class="col-xs-12 col-lg-8 list-text">
                                            <h4 class="text-primary buy-list">{{$document["model"]}} {{$document["variant"]}}
                                                {{$document["registration_year"]}}
                                                <?php
                                                if ($document["saved_car"] == 1) {
                                                    $saved_active_cars = 'detail-wishlist-active';
                                                } else {
                                                    $saved_active_cars = '';
                                                }
                                                if ($document["notify_car"] == 1) {
                                                    $notify_active_cars = 'detail-wishlist-active';
                                                } else {
                                                    $notify_active_cars = '';
                                                }
                                                ?>
                                            </h4>
                                            </h4>
                                            <p class="text-primary"><i class="fa fa-map-marker"></i>&nbsp;{{$document["car_locality"]}}  <span class="list-date">- {{$document["daysstmt"]}}</span></p>
                                            <p class="list-detail"><span class="text-muted">{{$document["kilometer_run"]}} km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">{{$document["registration_year"]}}</span> | <span class="text-muted">{{$document["owner_type"]}}</span></p>
                                            <p class="sale"><span class="rate"><i class="fa fa-rupee"></i></span> {{$document["price"]}}  {{$document["listing_error_msg"]}}</p>



                                            <div class="row searchbtns">
                                                <div class="pull-right col-xs-12 col-md-8 ">
                                                    <ul class="view-buttons row">
                                                        <li class="good-deal"><i data-toggle="tooltip" title="" data-original-title="Good deal" data-placement="left" class="fa fa-thumbs-o-up"></i></li>
                                                        <li><img src="{{url('img/dealerplus.png')}}" alt=""/></li>
                                                        <li><a class="btn btn-primary all-list-btn btn-sm view_similar" data-make='{{$document["make_id"]}}' data-model='{{$document["model"]}}' data-variant='{{$document["variant"]}}'>View Similar</a></li>
                                                        <li><a class="btn btn-primary all-list-btn btn-sm viewlisting" data-id='{{$document["car_id"]}}'>View More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <ul class="detail-wishlist row">
                                                        <li id="email-alert-send"><span><i class="fa fa-bell alertlisting {{$notify_active_cars}}"  data-toggle="tooltip" title="" data-original-title="Alert" data-placement="top" data-car-id='{{$document["car_id"]}}' data-make='{{$document["make"]}}' data-model-name='{{$document["model"]}}' data-regyear='{{$document["registration_year"]}}' data-variant='{{$document["variant"]}}' data-fuel='{{$document["fuel_type"]}}'
                                                                                           data-city='{{$document["car_locality"]}}'
                                                                                           ></i></span></li>
                                                        <li><a><i data-toggle="tooltip" title="" data-original-title="Saved cars" data-placement="left" class="fa fa-heart saved_car {{$saved_active_cars}}" data-car-id='{{$document["car_id"]}}'></i></a></li>

                                                        <li class="notification3"><a><i class="fa fa-balance-scale comparelisting" data-toggle="tooltip" title="" data-original-title="Compare" data-placement="top" data-car-id='{{$document["car_id"]}}'></i><span style="display: none;"><i class='fa fa-check' ></i></span></a></li>
                                                        @if($document["auction"]==1)
                                                        <li><a><i class="fa fa-legal biding_car" data-target='#bidding_popup' data-toggle='modal' title="" data-original-title="Add Bids" data-car-id='{{$document["car_id"]}}' data-dealer-id='{{$document["dealer_id"]}}' data-placement="left"></i></a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 email">
                                            <h4 class="col-xs-12 col-sm-12 email-alert">Get Email alerts for new listing this search</h4>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                                @else
                                <ul class="row">
                                    <li class="panel panel-primary alert no-cars">
                                        No Cars Found
                                    </li>
                                </ul>
                                @endif



                            </div>


                        </div>

                    </div>
                </div>

            </div>

            <!-- Share -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Share Listing</h4>
                        </div>
                        <div class="modal-body">
                            <div id="sharelistingnotification"></div>
                            <form method="post" id="sharelisting" class="form-horizontal">
                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1">
                                    <input type="hidden" name="car_id" value="{{$detail_list_data['car_id']}}">
                                        <input type="mail" name="mailto" id="mailto" placeholder="Email To" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <input type="mail" name="mailfrom" placeholder="Email From" class="form-control" value="{{$dealer_info['d_email']}}" readonly="readonly">
                                    </div></div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <textarea name="comments" id="comments" placeholder="Comments" class="form-control"></textarea>
                                    </div></div>
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-7">
                                        <!-- <a class="btn btn-social-icon btn-twitter"><span class="fa fa-twitter"></span></a>
                                        <a class="btn btn-social-icon btn-facebook"><span class="fa fa-facebook"></span></a>
                                        <a class="btn btn-social-icon btn-google"><span class="fa fa-google-plus"></span></a> -->
                                        <button type="button" class="btn btn-primary btn-sm sharelistingbutton">Send</button></div></div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
            <!-- Email Alert -->
            <div class="modal fade" id="myEmail" tabindex="-1" role="dialog" aria-labelledby="myEmail">
                <div class="modal-dialog email-pop" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title modal-title1" id="myEmail">Track Price drop for this car</h4>
                        </div>
                        <div class="modal-body">
                            <p>Notify me when the price of this listing drops.</p>
                            <form method="get" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="mail" placeholder="Email" class="form-control" value="{{$dealer_info['d_email']}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-8">
                                        <button type="button" class="btn btn-primary btn-sm alertpricedrop">Set Alert</button></div></div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
            @if($detail_list_data['auction']==1)
            <div class="btn btn-info btn-xs time-label hidden">
                <p><i class="fa fa-clock-o time-label-icon"></i></p> 
                <h4>Time Left</h4>
                <p> <span class="days">2</span> days <span class="hrs">2</span> hrs <span class="mins">02</span> mins only left</p>
            </div>
            @endif
            <div class="modal fade" id="bidding_popup" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Bidding</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form method="post">
                                    <div class="form-group col-xs-12">
                                        <div class="col-sm-12 col-xs-12 buy-message">
                                            <input type="number" class="form-control" name="dealer_funding" id="dealer_funding">
                                            <input type="hidden" class="form-control" name="dealer_id" id="dealer_id">
                                            <input type="hidden" class="form-control" name="car_id" id="car_id">
                                        </div>
                                        <div class="col-xs-4 pull-right">
                                            <input type="button" class="btn btn-primary sent-message btn-sm button_bidding" value="Add Bidding">
                                        </div>
                                    </div>    
                                </form>
                                <div class="hr-dashed"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="testdrive_popup" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Test Drive Details</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row test_drive_body">
                                @if($detail_list_data['test_drive_status']<=0)
                                <form method="post">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-sm-6 col-xs-12 park-diva">
                                            <div class="col-sm-12 col-xs-12 buy-message mt mb radio radio-primary radio-inline">
                                                @if($detail_list_data['test_driveatdoorpoint']==1)
                                                <input type="radio" name="test_drive_type" id="test_drive_type1" value="0" class="pull-left"><label for="test_drive_type1"><b> Test Drive At Door Step</b></label>
                                                @else
                                                <input type="radio" disabled="disabled"  id="test_drive_type2" name="test_drive_type" value="0"  class="pull-left"> <label for="test_drive_type2"><b> Test Drive At Door Step</b></label>
                                                @endif
                                            </div>
                                            <div class="col-sm-12 col-xs-12 buy-message">
                                                <input type="text" class="form-control" name="test_drive_address" id="test_drive_address" />
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 col-xs-12">
                                            <div class="col-sm-12 col-xs-12 buy-message mt mb radio radio-primary radio-inline">
                                                @if($detail_list_data['test_driveatdealerpoint']==1)
                                                <input type="radio" name="test_drive_type" id="test_drive_type3" value="1"  class="pull-left"> <label for="test_drive_type3"><b> Test Drive At Dealer Point</b></label>
                                                @else
                                                <input type="radio" disabled="disabled" name="test_drive_type" id="test_drive_type4" value="1"  class="pull-left"> <label for="test_drive_type4"><b> Test Drive At Dealer Point</b></label>
                                                @endif
                                            </div>
                                            <div class="col-sm-12  col-xs-12">
                                                <h3 class="detail-address-head">{{$detail_list_data['car_owner_name']}}</h3>
                                                <p class="detail-address"><i class="fa fa-map-marker"></i> {{$detail_list_data['car_city']}}</p>
                                                <p class="detail-address"><i class="fa fa-envelope-o"></i> {{$detail_list_data['car_owner_email']}}</p>
                                                <p class="detail-address"><i class="fa fa-phone"></i> {{$detail_list_data['car_owner_mobile']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 pull-right">
                                            <input type="button" class="btn btn-primary sent-message btn-sm button_test_drive" value="Apply Test Drive">
                                        </div>
                                    </div>    
                                </form>
                                @else
                                Already Test Drive Applied
                                @endif
                                <div class="hr-dashed"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>
        @include('footer')
    </div>



    <form method="post" id="view_car_managelist" action="{{url('detail_car_listing')}}">
        <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="car_view_id" name="car_view_id">
        <input type="hidden" name="city_name" id="city_name" value="{{$city_name}}">
    </form>

    <form method="post" id="similar_car_managelist" action="{{url('searchcarlisting')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="page_name" name="page_name" value="similar_searchpage">
        <input type="hidden" name="city_name" id="city_name_similar" value="{{$city_name}}">
        <input type="hidden" id="model" name="model">
        <input type="hidden" id="make_id" name="make_id">
    </form>
    <input type="hidden" name="time_left_duration" id="time_left_duration" @if(isset($detail_list_data['time_left']))value="{{$detail_list_data['time_left']}}" @endif>
           <input type="hidden" name="created_at" id="created_at" @if(isset($detail_list_data['created_at'])) value="{{$detail_list_data['created_at']}}"@endif>
           <!-- Loading Scripts -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('js/fileinput.js')}}"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="{{URL::asset('js/view-slider.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/slider.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDQV38f_h_p7mEF42XKoJTdKqdoE71v7Ak&region-in"></script>
    <script type="text/javascript">

$(document).ready(function () {
    $('.viewlisting').click(function () {
        $('#car_view_id').val($(this).attr('data-id'));
        $('#view_car_managelist').submit();
    });

    $(function () {
         $('.datetimepickerfund').datetimepicker("setDate", new Date());
         $('.datetimepickerfund').datetimepicker("setEndDate", new Date());
         $('.datetimepickerfund').datetimepicker("setStartDate", new Date());
           });

    $('.view_similar').click(function () {
        $('#model').val($(this).attr('data-model'));
        $('#make_id').val($(this).attr('data-make'));
        $('#similar_car_managelist').submit();
    });
    $('.saved_car').click(function () {
        var carid = $(this).attr('data-car-id');
        var csrf_token = $('#token').val();
        var thisid = this;
        $.ajax({
            url: 'save_car',
            type: 'post',
            data: {_token: csrf_token, carid: carid},
            success: function (response)
            {
                //alert(response);
                if (response == 1)
                {
                    $(thisid).addClass('detail-wishlist-active');
                } else
                {
                    $(thisid).removeClass('detail-wishlist-active');
                }
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    });

    $('.listreport').change(function () {
        var carid = $('#car_id').val();
        var dealer_id = $('#dealer_id').val();
        var csrf_token = $('#token').val();
        var report_listing_type_type_id = $(this).val();
        var thisid = this;
        $.ajax({
            url: 'reporting_listing',
            type: 'post',
            data: {_token: csrf_token, carid: carid,dealer_id:dealer_id,report_listing_type_type_id:report_listing_type_type_id},
            success: function (response)
            {
                alert('Successfully Reported The Listing');
            },
            error: function (e)
            {
                //console.log(e.responseText);
            }
        });
    });

    $('.biding_car').click(function () {
        var dealer_id = $(this).attr('data-dealer-id');
        var car_id = $(this).attr('data-car-id');
        //var make_model_variant = $(this).attr('data-make-model-variant');
        $('#dealer_id').val(dealer_id);
        $('#car_id').val(car_id);
        //$('#make_model_variant').val(make_model_variant);
    });
    $('.button_bidding').click(function () {
        var dealer_id = $('#dealer_id').val();
        var car_id = $('#car_id').val();
        var make_model_variant = '';
        var bidded_amount = $('#dealer_funding').val();
        $.ajax({
            url: 'bidding_car',
            type: 'post',
            data: {car_id: car_id, dealer_id: dealer_id, make_model_variant: make_model_variant, bidded_amount: bidded_amount},
            success: function (response)
            {
                alert(response);
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    });

    $('.test_drive').click(function () {
        var dealer_id = $(this).attr('data-dealer-id');
        var car_id = $(this).attr('data-car-id');
        $('#dealer_id').val(dealer_id);
        $('#car_id').val(car_id);
    });

    $('.button_test_drive').click(function () {

        var contact_dealer_name = $("#contact_dealer_name").val();
        var test_drive = '';
        if ($('input:radio[name=test_drive_type]:checked').val() == 0)
        {
            var contact_dealer_message = 'Requested Test Drive At Door Step';
            test_drive = 'Requested Test Drive At Door Step';
            var test_drive_address = $("#test_drive_address").val();
            if (test_drive_address == '')
            {
                alert('Please Enter Address');
                return false;
            }
            contact_dealer_message = contact_dealer_message + ' Address:' + test_drive_address;
        } else if ($('input:radio[name=test_drive_type]:checked').val() == 1)
        {
            test_drive = 'Requested Test Drive At Dealer Point';
            var contact_dealer_message = 'Requested Test Drive At Dealer Point';
        } else
        {
            alert('Please select Type of Test Drive');
            return false;
        }
        var contact_dealer_mailid = $("#contact_dealer_mailid").val();
        var car_id = $("#car_id").val();
        var dealer_id = $("#dealer_id").val();
        var csrf_token = $('#token').val();
        var title = $('#title').val();
        var sell_price = $('#sell_price').val();
        //alert(csrf_token);
        //return false;
        //alert(dealer_id);
        $.ajax({
            type: 'POST',
            url: "{{url('test_drive_update')}}",
            data: {_token: csrf_token, 'contact_dealer_name': contact_dealer_name, 'contact_dealer_message': contact_dealer_message, 'contact_dealer_mailid': contact_dealer_mailid, 'car_id': car_id, 'dealer_id': dealer_id, 'make_model_variant': title, sell_price: sell_price, test_drive: test_drive}, //
            //dataType:'JSON',
            success: function (response)
            {
                $('.test_drive_body').html('Successfully Applied For Test Drive. Please visit My Queries.');
                $('#testdrive_popup .close').click();
            },
            error: function (jqxhr) {
            }
        });


    });
    var to_input = document.getElementById('test_drive_address');
    var place;
    var options = {
        componentRestrictions: {country: "in"}
    };
    var autocomplete = new google.maps.places.Autocomplete(to_input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        place = autocomplete.getPlace();
        $("#test_drive_address").focus();
    });

    $("#contact_dealer_button").click(function () {
        //alert();
        $("#loadspinner").css("display", "block");
        var contact_dealer_name = $("#contact_dealer_name").val();
        var contact_dealer_message = $("#contact_dealer_message").val();
        var contact_dealer_mailid = $("#contact_dealer_mailid").val();
        var car_id = $("#car_id").val();
        var dealer_id = $("#dealer_id").val();
        var csrf_token = $('#token').val();
        var title = $('#title').val();
        var sell_price = $('#sell_price').val();
        //alert(dealer_id);
        $.ajax({
            type: 'POST',
            url: "{{url('ajaxcontactdealermessage')}}",
            data: {_token: csrf_token, 'contact_dealer_name': contact_dealer_name, 'contact_dealer_message': contact_dealer_message, 'contact_dealer_mailid': contact_dealer_mailid, 'car_id': car_id, 'dealer_id': dealer_id, 'make_model_variant': title, sell_price: sell_price}, //
            //dataType:'JSON',
            success: function (response)
            {
                $("#loadspinner").css("display", "none");
                $('#alertmsg').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Success!</strong> Message Sent</div>');
                $("#contact_dealer_message").val('');
                $('#detailOne').html('Message Sent Successfully. Please visit My Queries.');
                //setTimeout($('#detailOne').removeClass('in'), 5000);
                //console.log(response);
            },
            error: function (jqxhr) {

                //alert(jqxhr.responseText); // @text = response error, it is will be errors: 324, 500, 404 or anythings else
                //console.log(jqxhr.responseText);
            }
        });
    });
    
    $('.alertpricedrop').click(function () {
        var listingid = $('#car_id').val();
        var make = $('#make').val();
        var model_name = $('#model_name').val();
        var variant = $('#variant').val();
        var regyear = $('#regyear').val();
        var fuel = $('#fuel').val();
        var city_name = $('#city_name').val();
        var csrf_token = $('#token').val();
        var alert_type = 'Price';
        var thisid = this;
        $.ajax({
            url: 'alertsearch',
            type: 'post',
            data: {_token: csrf_token, listingid: listingid, make: make, model_name: model_name, variant: variant, regyear: regyear, fuel: fuel, city_name: city_name,alert_type:alert_type},
            success: function (response)
            {                
                //alert(response);
            },
            error: function (e)
            {
                //console.log(e.responseText);
            }
        });

    });
    $('.alertlisting').click(function () {
        var listingid = $(this).attr('data-car-id');
        var make = $(this).attr('data-make');
        var model_name = $(this).attr('data-model-name');
        var variant = $(this).attr('data-variant');
        var regyear = $(this).attr('data-regyear');
        var fuel = $(this).attr('data-fuel');
        var city_name = $(this).attr('data-city');
        var csrf_token = $('#token').val();
        var thisid = this;
        $.ajax({
            url: 'alertsearch',
            type: 'post',
            data: {_token: csrf_token, listingid: listingid, make: make, model_name: model_name, variant: variant, regyear: regyear, fuel: fuel, city_name: city_name},
            success: function (response)
            {
                if (response == 1)
                {
                    $("." + listingid).slideDown(1000);
                    $(thisid).addClass('detail-wishlist-active');
                } else
                {
                    $("." + listingid).slideUp(1000);
                    $(thisid).removeClass('detail-wishlist-active');
                }
                //alert(response);
            },
            error: function (e)
            {
                //console.log(e.responseText);
            }
        });

    });

    
    getTimeRemaining();
    auction_duration();
    $('[name="fundingamount"]').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
    var originalamount;
    var fundingamountvalue;
    $('body').ready(function()
    {
        originalamount      =   $('[name="originalfundingamount"]').val();
        $('[name="fundingamount"]').val(originalamount);
    });
    //APPLY FUNDING FINAL REGISTER
$("body").on('submit', '#fundingform', function (fundevent) {
    fundevent.preventDefault();
        fundingamountvalue  =   $('.fundingofamount').val();
        if(fundingamountvalue <= originalamount)
        {
            //return true;
        }
        else
        {
            var errormessage    =   "Please enter value less than or equal to Rs."+originalamount+"";
            $('#funddeleteresult').modal({
                show: 'true'
            });
            $(".errorfundingalert").html(errormessage);
            return false;
        }
        var valamount           =   parseFloat($('[name="fundingamount"]').val());
        if (isNaN(valamount) || (valamount === 0))
        {
            var errormessage    =   "Please enter valid amount";
            $('#funddeleteresult').modal({
                show: 'true'
            });
            $(".errorfundingalert").html(errormessage);
            return false;
        }
        
    $("#loadspinner").css("display", "block");
    $.ajax({
        url: "{{url('dobuyfundingregister')}}",
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response)
        {            
            if (response.message == "Funding Applied Successfully")
            {
                
                $("#loadspinner").css("display", "none");
                $("#detailThree").html('Inventory Funding is applied successfully for this vehicle. Please click here <a href="{{url("viewfunding")}}?FundingTicketid='+response.ticketid+'">'+response.fundticketid+'</a> to view');
                $('.successfunding').removeClass('alert-danger');
                $('.successfunding').addClass('alert-success');
                $('#funddeleteresult').modal({
                    show: 'true'
                });
                $(".errorfundingalert").html('Inventory Funding is applied successfully for this vehicle. Please click here <a href="{{url("viewfunding")}}?FundingTicketid='+response.ticketid+'">'+response.fundticketid+'</a> to view');
                setTimeout($('#detailThree').removeClass('in'), 5000);
            } else if(response.message == "Funding Amount is Exceeded") {
                $("#loadspinner").css("display", "none");
                var errormessage    =   response.success;
                $('#funddeleteresult').modal({
                    show: 'true'
                });
                $(".errorfundingalert").html(errormessage);
            }
            else
            {
                $("#loadspinner").css("display", "none");
            }
        },
        error: function (e)
        {
            $("#loadspinner").css("display", "none");
        }
    });
});

$('.sharelistingbutton').click(function(){
    $("#loadspinner").css("display", "block");
    var mailto = $("#mailto").val();
    $("#sharelistingnotification").html('');            
    if(mailto=='')
    {
        alert('Please Enter Mail Id to Share Listing');
        $("#loadspinner").css("display", "none");
        return false;
    }
    var form_data = new FormData($('#sharelisting')[0]);
    $.ajax({
        url: "{{url('sharelisting')}}",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        allowedTypes: "jpg,png,gif,jpeg",
        multiple: true,
        type: 'post',
        success: function (response) {
            console.log(response);
            $("#loadspinner").css("display", "none");
            $("#sharelistingnotification").html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Success!</strong>Listing Shared Successfully</div>'); 
            setTimeout(function(){ $("#sharelistingnotification .close").click(); } ,5000)        
            $("#mailto,#comments").val('');
        },
        error: function () {
            $("#loadspinner").css("display", "none");
        }
    });    
});
});

function getTimeRemaining() {
    var endtime = new Date($('#time_left_duration').val());

    //console.log(endtime);
    var t = endtime - Date.parse(new Date());
    if (t > 0)
    {
        var seconds = Math.floor((parseFloat(t) / 1000) % 60);
        var minutes = Math.floor((parseFloat(t) / 1000 / 60) % 60);
        var hours = Math.floor((parseFloat(t) / (1000 * 60 * 60)) % 24);
        var days = Math.floor(parseFloat(t) / (1000 * 60 * 60 * 24));
        setTimeout(getTimeRemaining, 1000);
    } else
    {
        var seconds = 0;
        var minutes = 0;
        var hours = 0;
        var days = 0;
    }
    $(".days").text(days);
    $(".hrs").text(hours);
    $(".mins").text(minutes);
    $(".time_left_duration").text(days + ' days ' + hours + ' hrs ' + minutes + ' mins');
    //console.log(endtime+'-'+t+'-'+days);

}
function auction_duration() {
    var endtime = new Date($('#time_left_duration').val());
    var created_at = new Date($('#created_at').val());
    //console.log(endtime);
    var t = endtime - created_at;
    var seconds = Math.floor((parseFloat(t) / 1000) % 60);
    var minutes = Math.floor((parseFloat(t) / 1000 / 60) % 60);
    var hours = Math.floor((parseFloat(t) / (1000 * 60 * 60)) % 24);
    var days = Math.floor(parseFloat(t) / (1000 * 60 * 60 * 24));
    //$(".days").text(days);
    //$(".hrs").text(hours);
    //$(".mins").text(minutes);
    $(".bid_duration").text(days + ' days ' + hours + ' hrs ' + minutes + ' mins');
    //console.log(endtime+'-'+t+'-'+days);
    //setInterval(getTimeRemaining, 1000);
}
setTimeout(cometchatuserstatus,5000);

    </script>
</body>


</html>