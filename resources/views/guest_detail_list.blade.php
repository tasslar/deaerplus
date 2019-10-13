
@include('index_header')


<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">


            <div class="col-xs-12 detail-page">
                 <div class="row detail-head">

                    <input type="hidden" name="id" id="car_id" value="{{$detail_list_data['car_id']}}">
                    <input type="hidden" name="dealer_id" id="dealer_id" value="{{$detail_list_data['dealer_id']}}">
                    <input type="hidden" name="title" id="title" value="{{$detail_list_data['make']}} {{$detail_list_data['model']}} {{$detail_list_data['variant']}}">

                    
                    
                    <div class="col-xs-5 col-sm-3"><span class="rate-detail detail-title1">Rs. {{$detail_list_data['price']}}</span></div>
                    
                </div>
                <div class="hr-dashed"></div>
                <div class="col-xs-12 col-md-9">Listing Id:{{$detail_list_data['car_id']}} | Listing Date: {{$detail_list_data['created_at']}} </div>
               <div class="col-sm-7 col-xs-12"><span class="detail-title1">{{$detail_list_data['model']}} {{$detail_list_data['variant']}} {{$detail_list_data['registration_year']}} <img src="{{url($detail_list_data['site_image'])}}" alt=""></span></div>
                    
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
                    
                    <div class="col-sm-5">                            
                            <div class="col-sm-12 col-xs-12"><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
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
                                                <h3 class="detail-address-head">{{$detail_list_data['car_owner_name']}}</h3>
                                                <p class="detail-address"><i class="fa fa-map-marker"></i> {{$detail_list_data['car_city']}}</p>
                                                <p class="detail-address"><i class="fa fa-envelope-o"></i> {{$detail_list_data['car_owner_email']}}</p>
                                                <p class="detail-address"><i class="fa fa-phone"></i> {{$detail_list_data['car_owner_mobile']}}</p></div>

                                        </div>
                                    </div>
                                    
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
                                            {{$listing_features['overviewdescription']}}
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
                                                                @if($listing_features['height']!=''&&$listing_features['height']!=0)
                                                                {{$listing_features['height']}}
                                                                @else
                                                                -
                                                                @endif
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
                            </div>


                        </div>

                    </div>
                </div>

            </div>            
        </div>
        @include('footer')
    </div>

           <!-- Loading Scripts -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/Chart.min.js')}}"></script>
    <script src="{{URL::asset('js/fileinput.js')}}"></script>
    <script src="{{URL::asset('js/chartData.js')}}"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="{{URL::asset('js/view-slider.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/slider.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script>
</body>


</html>