
@include('header')
@include('sidebar')
<form method="post" id="view_car_managelist" action="{{url('detail_car_listing')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" id="car_view_id" name="car_view_id">
</form>
<div class="content-wrapper myprofile">
    <div class="content-header col-sm-12">
        <div class="row top-search" id="search-slide">
            <div class="input-group-btn search-panel">
                <select class="col-xs-12 col-sm-12 btn btn-primary">
                    <option value="">Filter</option>
                    <option value="1">Inventory</option>
                    <option value="2">Customer</option>
                    <option value="3">Dealers</option>
                    <option value="4">Cars</option>
                </select>
            </div>
            <input type="hidden" name="search_param" value="all" class="" id="search_param">         
            <input type="text" class="form-control" name="x" placeholder="Search term...">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </span></div>
        <ol class="breadcrumb">
            <li><a href="{{url('buy')}}"><i class="fa fa-dashboard"></i> Buy</a></li>
            <li class="active">Compare</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <h2 class="page-title">Used Car Comparison</h2>

        @if(!empty($compact_array['compare_data']['listingprice']))
        <div class="row">
            <div class="col-xs-12">
                <div class="compare col-xs-12">
                    <div class="leftcompare col-xs-3"></div>
                    <div class="{{$compact_array['compare_class']}} rightcompare col-xs-9 text-center">
                        @foreach($compact_array['compare_data']['listingprice'] as $comparekey=>$comparevalue)
                        <div class="carcompareimage">
                            <div class="carcompareimg">
                                <img src="{{$compact_array['compare_data']['mainimagelinks'][$comparekey]}}"/>
                            </div>
                            <b>{{$compact_array['compare_data']['listingname'][$comparekey]}}</b>
                            <p>{{$comparevalue}}</p>
                            <a class="btn btn-primary btn-sm viewlisting" data-id="{{$compact_array['compare_data']['listingid'][$comparekey]}}" >Get Seller Details</a>
                            <span class="arrow"></span>
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">OVERVIEW</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Picture</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['countphoto'] as $comparedata=>$comparevalue)
                                    <div data-toggle="modal" data-target="#picture{{$comparedata}}" style="cursor: pointer">{{$comparevalue}} (View Now)</div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="compare col-xs-12">
                                <div class="leftcompare">Selling Price</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['listingprice'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- <div class="compare col-xs-12">
                                <div class="leftcompare">Ex-showroom Price(*New Car)</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['listingprice'] as $comparedata=>$comparevalue)
                                        <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div> -->
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Registration City</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['registration_city'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="compare col-xs-12">
                                <div class="leftcompare">Model Year</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['model_year'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">No. of Owners</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['noofowners'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                 
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">KMs Driven</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['kms_driven'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                     
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Fuel Type</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['fuel_type'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Mileage</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['mileagecity'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- <div class="compare col-xs-12">
                                <div class="leftcompare">Mileage-Highway(*New Car)</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['mileagehighway'] as $comparedata=>$comparevalue)
                                        <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div> -->
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Transmission</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['transmission'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Insurance</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['insurance'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- <div class="compare col-xs-12">
                                <div class="leftcompare">Finance</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['insurance'] as $comparedata=>$comparevalue)
                                        <div>Yes <a href="">APPLY NOW</a></div>
                                    @endforeach
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-xs-12 accordsec">
                        <button class="accordion">CAR SPECIFICATION</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Color</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['colors'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Gear Box</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Gear_box'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Drive type</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Drive_Type'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Seating Capacity</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['seatingcapacity'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Steering type</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Steering_type'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                   
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Turning Radius</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Turning_Radius'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Top Speed</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Top_Speed'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Acceleration</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Acceleration'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Tyre type</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Tyre_Type'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">No of doors</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['No_of_Doors'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">ENGINE</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Engine Type</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Engine_Type'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Displacement</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['engine_displacement'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Max Power</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['max_power'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                                             
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Max Torque</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['max_torque'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                                             
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">No Of Cylinders</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['No_of_Cylinders'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Valves per Cylinder</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Valves_Per_Cylinder'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Valve configuration</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Valves_configure'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                   
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Fuel Supply System</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Fuel_Supply_System'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach                   
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Turbo Charger</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Turbo_Charger'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Super Charger</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Super_Charger'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">CAR DIMENSIONS</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Length</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Length'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Width</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Width'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Height</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Height'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Wheel Base</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Wheel_Base'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Gross Weight</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Gross_Weight'] as $comparedata=>$comparevalue)
                                    <div>{{$comparevalue}}</div>
                                    @endforeach
                                </div>
                            </div>                                    
                        </div>
                    </div>
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">CAR INTERIOR FEATURES</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Air Conditioner</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['air_conditioner'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Adjustable Steering</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['steering_adjustment'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                              
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Leather Steering Wheel</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Leather_Steering_Wheel'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Heater</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Heater'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                  
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Digital Clock</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Digital_Clock'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">CAR COMFORT</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Power steering</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Power_Steering'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Power windows front</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Power_windows_front'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                  
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Power windows rear</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Power_windows_rear'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Remote trunk opener</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Remote_Trunk_Opener'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Remote fuel lid opener</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Remote_Fuel_Lid_Opener'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                              
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Low fuel warning light</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Low_Fuel_Warning_Light'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rear reading lamp</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_Reading_Lamp'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rear seat headrest</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_Seat_Headrest'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rear seat center arm rest</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_Seat_Center_Arm_Rest'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Height adjustable front seat belts</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Height_Adjustable_Front_Seat_Belts'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Cup holders front</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Cup_Holders_Front'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Cup holders rear</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Cup_Holders_Rear'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rear a/c vents</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_A_C_Vents'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Parking sensors</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Parking_Sensors'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">CAR SAFETY</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Anti lock braking system</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Anti_Lock_Braking_System'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                   
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Central locking</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Central_Locking'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                  
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Child safety lock</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Child_Safety_Locks'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                 
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Driver airbags</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Driver_Airbag'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                  
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Passenger airbag</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Passenger_Airbag'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                 
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rear seat belts</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_Seat_Belts'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                 
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Seat belt warning</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Seat_Belt_Warning'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Adjustable seats</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Adjustable_Seats'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                 
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Crash sensor</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Crash_Sensor'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Anti theft device</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Anti_Theft_Alarm'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Immobilizer</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Engine_Immobilizer'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">CAR EXTERIOR</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Adjustable Head lights</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Adjustable_Head_lights'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Power adjustable exterior rear view mirror</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Power_adjustable_exterior_rear_view_mirror'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Electric folding rear view mirror</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Electric_folding_rear_view_mirror'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                              
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rain sensing wipers</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rain_sensing_wipers'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rear window wiper</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_window_wiper'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                  
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Alloy wheels</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Alloy_wheels'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach  
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Tinted glass</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Tinted_glass'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Front fog lights</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Front_fog_lights'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                             
                                </div>
                            </div>
                            <!-- <div class="compare col-xs-12">
                                <div class="leftcompare">Rear window wiper</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_window_wiper'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div> -->
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Rear window defogger</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Rear_window_defogger'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                 
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 accordsec">
                        <button class="accordion">CAR ENTERTAINMENT</button>
                        <div class="panel">
                            <div class="compare col-xs-12">
                                <div class="leftcompare">CD Player</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['CD_Player'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Radio</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['FM_AM_Radio'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Audio</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Audio_System_Remote_Control'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                                  
                                </div>
                            </div>
                            <div class="compare col-xs-12">
                                <div class="leftcompare">Bluetooth</div>
                                <div class="{{$compact_array['compare_class']}} rightcompare">
                                    @foreach($compact_array['compare_data']['Bluetooth_Connectivity'] as $comparedata=>$comparevalue)
                                    @if($comparevalue==1)
                                    <div><i class="fa fa-check" aria-hidden="true"></i></div>
                                    @else
                                    <div><i class="fa fa-close" aria-hidden="true"></i></div>
                                    @endif
                                    @endforeach                                               
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    No Cars for Compare
                </div>
                @endif
            </div>
        </div>
        @foreach($compact_array['compare_data']['viewimagelinks'] as $comparedata=>$comparevalue)
        <div class="modal fade" id="picture{{$comparedata}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Picture Name</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="carousel-example-generic{{$comparedata}}" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    @foreach($comparevalue as $imagedata=>$imagevalue)
                                    <li data-target="#carousel-example-generic{{$comparedata}}" data-slide-to="{{$imagedata}}" @if($imagedata==0) class="active" @endif ></li>

                                    @endforeach
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    @foreach($comparevalue as $imagedata=>$imagevalue)
                                    <div class="item @if($imagedata==0) active @endif">
                                        <img src="{{$imagevalue}}" alt="...">
                                        <div class="carousel-caption">
                                            {{$compact_array['compare_data']['viewimagenames'][$comparedata][$imagedata]}}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Controls -->
                                <a class="left carousel-control" href="#carousel-example-generic{{$comparedata}}" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic{{$comparedata}}" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/main.js"></script>
        <script src="js/menu.js"></script>
        <script src="{{URL::asset('js/dealerplus.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
        <script>

$('.viewlisting').click(function () {
    $('#car_view_id').val($(this).attr('data-id'));
    $('#view_car_managelist').submit();
});

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function () {
        $('.accordsec .panel').removeClass("show");
        $('.accordsec .accordion').removeClass("active");

        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("show");
    }
}

$(function () {
    $('.date').datetimepicker();
});
        </script>
        </body>

        </html>