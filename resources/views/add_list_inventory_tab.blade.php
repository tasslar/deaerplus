@include('header')
@include('sidebar')
<div class="content-wrapper add-product">  
    <div class="container-fluid">
        <div class="content-header col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{url('managelisting')}}"><i class="fa fa-dashboard"></i> Sell</a></li>
                <li class="active">Add Listing</li>
            </ol>
        </div>
        <div class="col-md-12" id="errormsg"></div>
        <div class="col-md-12">
            <h2 class="page-title">Add Listing</h2>
            <br/>
            <form method="post" action="{{url('add_inventory_save')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                <div class="row">
                    <!--                <div class="col-sm-6 col-sm-offset-6">
                                            <div class="progress progress-striped active" style="display: block;">
                                                                                                <div class="progress-bar" style="width: 45%">45%</div>
                                                                                            </div>
                                        <div class="progress progress-complete">
                                            <div class="progress-bar progress-bar-success" style="width: 40%">
                                                <span>Basic Info (40%)</span>
                                            </div>
                                            <div class="progress-bar  progress-bar-warning" style="width: 25%">
                                                <span>Pricing (25%)</span>
                                            </div>
                                            <div class="progress-bar progress-bar-danger" style="width: 15%">
                                                <span>Images (15%)</span>
                                            </div>
                                        </div>
                                    </div>-->
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div id="success_faliure_notification"></div>
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                All Field are Required. Please Fill This Fields
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach                                
                            </div>
                            @endif
                            <div class="panel-body">
                                <h3 class="invent-title">VIN Lookup</h3>
                                <div id="vin-look"> 

                                    <div class="col-sm-3"> 
                                        <div class="form-group field-wrapper1">
                                            <label>Registration Number</label>
                                            <input type="text" class="form-control" name="registration_number" id="registration_number" value="{{$fetchedvalues['basic_info']['registration_number']}}" placeholder="Registration Number">
                                        </div>     
                                    </div>
                                    <div class="col-sm-3"> 
                                        <div class="form-group field-wrapper1">
                                            <label>Engine Number</label>
                                            <input type="text" id="engine_number" name="engine_number" class="form-control" value="{{$fetchedvalues['basic_info']['engine_number']}}" placeholder="Engine Number">
                                        </div>     
                                    </div>
                                    <div class="col-sm-3"> 
                                        <div class="form-group field-wrapper1">
                                            <label>Chassis Number</label>
                                            <input type="text" id="chassis_number" name="chassis_number" class="form-control" value="{{$fetchedvalues['basic_info']['chassis_number']}}" placeholder="Chassis Number">
                                        </div>     
                                    </div>
                                    <div class="col-sm-1 col-xs-3"> 
                                        <div class="form-group field-wrapper1">
                                            <button class="btn btn-primary resetvininfo" type="button">Reset</button>
                                        </div>     
                                    </div> 
                                    <div class="col-sm-1 col-xs-3"> 
                                        <div class="form-group field-wrapper1">
                                            <button class="btn btn-primary fetchdetailsofregno"  type="button">Fetch</button>  
                                            <button class="hide popupfastlane"  type="button" data-toggle="modal" data-target="#fastlane_details"></button>  
                                        </div>     
                                    </div> 
                                </div>
                            </div>

                            <div class="panel-body">

                                <h3 class="invent-title">Basic Info</h3>
                                <h2 class="commontab" style="display:none;color:red;"></h2>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Registration Year</label>
                                            <select class="form-control registration_year required-des thirdpartyfetch" name="registration_year" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option"> 
                                                <option value="">Select Registration Year</option>
                                                @foreach($compact_array['year'] as $fetch_year)
                                                @if($fetchedvalues['basic_info']['registration_year']==$fetch_year->master_reg_year)
                                                <option value="{{$fetch_year->master_reg_year}}" selected>{{$fetch_year->master_reg_year}}</option>
                                                @else
                                                <option value="{{$fetch_year->master_reg_year}}">{{$fetch_year->master_reg_year}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>     
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Make</label>
                                            <select class="form-control make required-des thirdpartyfetch" name="make" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                <option value="">Select Make</option>            
                                                @foreach($make as $key=>$value)
                                                @if($fetchedvalues['basic_info']['make']==$value->make_id)
                                                <option value = "{{$value->make_id}}" selected>{{$value->makename}}</option>  
                                                @else
                                                <option value = "{{$value->make_id}}">{{$value->makename}}</option>  
                                                @endif
                                                @endforeach        
                                            </select>
                                        </div>     
                                    </div> 

                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Model</label>
                                            <select class="form-control model required-des thirdpartyfetch" name="model" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                <option value="">Select Model</option>
                                                @foreach($model as $key=>$value)
                                                @if($value->model_id == $fetchedvalues['basic_info']['model'])
                                                <option value = "{{$value->model_id}}" selected>{{$value->model_name}}</option>
                                                @else
                                                <option value = "{{$value->model_id}}">{{$value->model_name}}</option>   
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>   

                                    <div class="col-sm-3">  
                                        <div class="form-group field-wrapper1">
                                            <label>Select Variant</label>
                                            <select class="form-control variant required-des thirdpartyfetch" name="variant" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                <option value="">Select Variant</option>
                                                @foreach($Variant as $key=>$value)
                                                @if($value->variant_id == $fetchedvalues['basic_info']['variant'])   
                                                <option value = "{{$value->variant_id}}" selected>{{$value->variant_name}}</option> 
                                                @else
                                                <option value = "{{$value->variant_id}}">{{$value->variant_name}}</option>   
                                                @endif   
                                                @endforeach
                                            </select>
                                        </div>     
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Body Type</label>
                                            <select class="form-control category_id required-des" name="category_id">
                                                <option value = "">Select Body Type</option>
                                                @foreach($selectcategory as $key=>$value)
                                                @if($fetchedvalues['basic_info']['category_id']==$value->category_id)
                                                <option value = "{{$value->category_id}}" selected>{{$value->category_description}}</option>
                                                @else
                                                <option value = "{{$value->category_id}}">{{$value->category_description}}</option>
                                                @endif
                                                @endforeach        
                                            </select>
                                        </div>     
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Transmission</label>
                                            <input type="text" class="form-control transmission" name="transmission" value="{{$fetchedvalues['basic_info']['transmission']}}" placeholder="Select Transmission" readonly>
                                        </div>     
                                    </div> 

                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Total Distance</label>
                                            <input type="text" maxlength='6' value="{{$fetchedvalues['basic_info']['kms_done']}}" name="kms_done" placeholder="Total Distance" class="kmsdone form-control data-number required-des thirdpartyfetch" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Enter Number">        
                                            <input type="hidden" maxlength='6' value="{{$fetchedvalues['listing_id']}}" name="listing_id" placeholder="Total Distance" class="kmsdone form-control data-number">        
                                        </div>     
                                    </div>  
                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Mileage</label>         
                                            <input type="text" maxlength='5' name="mileage" value="{{$fetchedvalues['basic_info']['mileage']}}" placeholder="Mileage" class="form-control milles two-decimals data-decimal required-des thirdpartyfetch" onchange="validateFloatKeyPress(this);" max='100' data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Enter Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">  
                                        <div class="form-group field-wrapper1">
                                            <label>Select Ownership</label>
                                            <select class="form-control owner_type required-des thirdpartyfetch" name="owner_type" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                @foreach($Ownership as $key=>$value)
                                                @if($fetchedvalues['basic_info']['owner_type']==$key)
                                                <option selected value = "{{$key}}" selected>{{$value}}</option>
                                                @else
                                                <option value = "{{$key}}">{{$value}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>     
                                    </div> 

                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Car Status</label>
                                            <select class="form-control status required-des" name="status" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                @foreach($CarStatus as $key=>$value)
                                                @if($fetchedvalues['basic_info']['status']==$key)
                                                <option selected value = "{{$key}}">{{$value}}</option>
                                                @else
                                                <option value = "{{$key}}">{{$value}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>     
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Color</label>
                                            <select class="form-control colors required-des thirdpartyfetch" name="colors" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                <option value="">Select Color</option>
                                                @foreach($color as $key=>$value)
                                                @if($fetchedvalues['basic_info']['colors']==$value->colour_id)
                                                <option selected value = "{{$value->colour_id}}">{{$value->colour_name}}</option>   
                                                @else
                                                <option value = "{{$value->colour_id}}">{{$value->colour_name}}</option>   
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>     
                                    </div>   
                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Location</label>
                                            <select class="form-control place required-des thirdpartyfetch" name="place" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                <option value="">Select Location</option>
                                                @foreach($compact_array['city'] as $fetch) 
                                                @if($fetchedvalues['basic_info']['car_city']==$fetch->city_id)
                                                <option selected value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                @else
                                                <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                @endif                              
                                                @endforeach
                                            </select>
                                        </div>     
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Select Branch</label>
                                            <select class="form-control branch" name="branch">
                                                <option value="">Select Branch</option>
                                                @if(isset($branch))

                                                @foreach($branch as $key=>$value)
                                                @if($value->branch_id == $fetchedvalues['basic_info']['branch_id'])
                                                <option value = "{{$value->branch_id}}" selected>{{$value->dealer_name}}</option>
                                                @else
                                                <option value = "{{$value->branch_id}}">{{$value->dealer_name}}</option>   
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>     
                                    </div>  

                                    <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Fuel Type</label>

                                            <input type="text" value="{{$fetchedvalues['basic_info']['fuel_type']}}" name="fuel_type" placeholder="Fuel Type" class="fueltyperesponse fuel_type form-control data-number" readonly>
                                        </div>     
                                    </div> 
                                </div>
                            </div>
                            <div class="panel-body">
                                <h3 class="invent-title">Pricing Info</h3>
                                <div class="row">

                                    <div class="col-sm-4"><h4>Type of Inventory</h4></div>
                                    <div class="form-group col-sm-6">

                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" class="inventory_type_own" id="own" value="OWN" name="inventory_type" @if($fetchedvalues['prince_info']['inventory_type']=='OWN') checked="checked" @endif >
                                                   <label for="own"> Own </label>
                                        </div>
                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" id="park" class="inventory_type_park" value="PARKANDSELL" name="inventory_type" @if($fetchedvalues['prince_info']['inventory_type']=='PARKANDSELL') checked="checked" @endif>
                                            <!-- <input type="hidden"  value="0" name="inventory_type"> -->
                                                   <label for="park"> Park and Sell </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch1" @if($fetchedvalues['prince_info']['test_drive']=='1') checked @endif>
                                               <label class="onoffswitch-label" for="myonoffswitch1">
                                            <span class="onoffswitch-inner onoffswitch-inner1 testdrivepoint-inner"></span>
                                            <span class="onoffswitch-switch onoffswitch-switch2 testdrivepoint"></span>
                                        </label>
                                        <div class="testdrive" @if($fetchedvalues['prince_info']['test_drive']==0) style="display: none;" @endif>
                                             <input type="checkbox" class="testdrivedealer" name="test_drive_dealer" value="1" @if($fetchedvalues['prince_info']['testdrive_dealerpoint']=='1') checked @endif @if($fetchedvalues['prince_info']['inventory_type']=='') checked="checked" @endif> At Dealer Point</input>
                                            <br/>
                                            <input type="checkbox" class="testdrivedoor" name="test_drive_door" value="1" @if($fetchedvalues['prince_info']['testdrive_doorstep']=='1') checked @endif @if($fetchedvalues['prince_info']['inventory_type']=='') checked="checked" @endif> At Door Step</input>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-sm-6  col-xs-12 own-div" @if($fetchedvalues['prince_info']['inventory_type']=='OWN') style="display: block;" @endif>
                                             <h4 class="page-title1">Purchase Information</h4>
                                            <div class="row"><div class="col-sm-4"><label>Purchased From</label></div>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <select class="form-control required-des purchased_from" name="ownpurchased_from">
                                                                @foreach($selectdeleare as $key=>$value)
                                                                @if($fetchedvalues['prince_info']['ownpurchased_from']==$value)
                                                                <option value = "{{$value}}" selected>{{$value}}</option>
                                                                @else
                                                                <option value = "{{$value}}">{{$value}}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <input type="text" name="ownreceived_from_name" value="{{$fetchedvalues['prince_info']['ownreceived_from_name']}}" class="form-control data-name validate-space ownname required-des" placeholder="Name" data-validation="alphanumeric" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="30" data-validation-error-msg="Please Enter  name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="hr-dashed"></div>
                                            <div class="row"> 
                                                <div class="col-sm-4"><label>Purchase Price</label></div>
                                                <div class="col-sm-6"><input type="text" name="ownpurchased_price" class="price-format form-control commonvalue purchased_price required-des data-decimal" value="{{$fetchedvalues['prince_info']['ownpurchased_price']}}" onkeypress="return validatedecimalKeyPress(this, event);"></div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row"> 
                                                <div class="col-sm-4"><label>Purchased Date</label></div>
                                                <div class="col-sm-6">
                                                    <div class='input-group date' id='datetimepicker4'>
                                                        <input type='text' name="ownpurchase_date" placeholder="DD-MM-YYYY" class="form-control purchase_date_own required-des" value="{{$fetchedvalues['prince_info']['ownpurchase_date']}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row">
                                                <div class="col-sm-4"><label>Keys Received</label></div>
                                                <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="keyy" class="keys_available_own_yes" value="1" name="ownkey_received" @if($fetchedvalues['prince_info']['ownkey_received']==1) checked="checked" @endif>
                                                               <label for="keyy"> Yes </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="keyn" value="0" class="keys_available_own_no" name="ownkey_received" @if($fetchedvalues['prince_info']['ownkey_received']==0) checked="checked" @endif>
                                                               <label for="keyn">No</label>
                                                    </div></div></div>
                                            <div class="hr-dashed"></div>
                                            <div class="row">
                                                <div class="col-sm-4"><label>Document Received</label></div>
                                                <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="docuy" class="documents_received_own_set" value="1" name="owndocuments_received" @if($fetchedvalues['prince_info']['owndocuments_received']==1) checked="checked" @endif>
                                                               <label for="docuy"> Yes </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" class="documents_received_own_no_set" id="docun" value="0" name="owndocuments_received" @if($fetchedvalues['prince_info']['owndocuments_received']==0) checked="checked" @endif>
                                                               <label for="docun">No</label>
                                                    </div></div></div>
                                        </div>  
                                        <div class="col-xs-12 col-sm-6 park-div" @if($fetchedvalues['prince_info']['inventory_type']=='OWN') style="display: none;" @endif >
                                             <h4 class="page-title1">Purchase Information</h4>
                                            <div class="row"><div class="col-sm-4"><label>Received From </label></div>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-5"><select class="form-control required-des received_from" name="received_from_own">
                                                                @foreach($selectdeleare as $key=>$value)
                                                                @if($fetchedvalues['prince_info']['received_from_own']==$value)
                                                                <option value = "{{$value}}" selected>{{$value}}</option>
                                                                @else
                                                                <option value = "{{$value}}">{{$value}}</option>
                                                                @endif
                                                                @endforeach
                                                            </select></div>
                                                        <div class="col-sm-7">
                                                            <input type="text" name="received_from_name" value="{{$fetchedvalues['prince_info']['received_from_name']}}" class="form-control data-name validate-space parkname required-des" placeholder="Name" data-validation="alphanumeric" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="30" data-validation-error-msg="Please Enter  name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="hr-dashed"></div>

                                            <div class="row"> 
                                                <div class="col-sm-4"><label>From Date</label></div>
                                                <div class="col-sm-6"><div class="input-group date" id="datetimepicker4">
                                                        <input type='text' name="purchase_date" placeholder="DD-MM-YYYY" class="form-control purchase_date_own required-des" value="{{$fetchedvalues['prince_info']['purchase_date']}}" />
                                                        <span class="input-group-addon testdrivepoint-outer">
                                                            <span class="glyphicon glyphicon-calendar testdrivepoint-outer"></span>
                                                        </span>
                                                    </div></div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row"> 

                                                <div class="col-sm-4"><label>Starting Km</label></div>
                                                <div class="col-sm-6">
                                                    <input type='text' name="starting_kms" class="form-control data-number starting_kms required-des data-decimal"  data-validation="required" data-validation-optional="false"  maxlength="7" data-validation-error-msg="Please Enter Number"  value="{{$fetchedvalues['prince_info']['starting_kms']}}"/>
                                                </div>

                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row"> 
                                                <div class="col-sm-4"><label>Fuel Indication</label></div>
                                                <div class="col-sm-6">

                                                    <select name="fuel_indicator" class="form-control fuel_indicator">
                                                        <option value="1" @if($fetchedvalues['prince_info']['fuel_indication']==1) selected @endif>Yes</option>
                                                        <option value="0" @if($fetchedvalues['prince_info']['fuel_indication']==0) selected @endif>No</option>
                                                    </select>

                                                    <input type="hidden" name="fuel_capacity" >
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row"> 
                                                <div class="col-sm-4"><label>Customer Asking Price</label></div>
                                                <div class="col-sm-6"><div class='input-group'>
                                                        <span class="input-group-addon">
                                                            Rs.
                                                        </span>
                                                        <input type='text' name="customer_asking_price" class="form-control commonvalue customer_asking_price data-decimal required-des"  data-validation="required" data-validation-optional="false"  maxlength="15" data-validation-error-msg="Please Enter Number"  value="{{$fetchedvalues['prince_info']['customer_asking_price']}}" onkeypress="return validatedecimalKeyPress(this, event);" />
                                                    </div></div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row"> 
                                                <div class="col-sm-4"><label>Dealer Markup Price</label></div>
                                                <div class="col-sm-6"><div class='input-group'>
                                                        <span class="input-group-addon">
                                                            Rs.
                                                        </span>
                                                        <input type='text' name="dealer_markup_price" class="form-control commonvalue dealer_mark_price data-decimal required-des" data-validation="required" data-validation-optional="false"  maxlength="15" data-validation-error-msg="Please Enter Number"  value="{{$fetchedvalues['prince_info']['dealer_markup_price']}}"  onkeypress="return validatedecimalKeyPress(this, event);"/>
                                                    </div></div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row">
                                                <div class="col-sm-4"><label>Keys Received</label></div>
                                                <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="keyy" value="1" name="keys_available" class="keys_available_yes" @if($fetchedvalues['prince_info']['keys_available']==1) checked="checked" @endif>
                                                               <label for="keyy"> Yes </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="keyn" class="keys_available_no" value="0" name="keys_available" @if($fetchedvalues['prince_info']['keys_available']==0) checked="checked" @endif>
                                                               <label for="keyn">No</label>
                                                    </div></div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="row">
                                                <div class="col-sm-4"><label>Document Received</label></div>
                                                <div class="col-sm-8"><div class="radio radio-primary radio-inline">

                                                        <input type="radio" id="docuy" value="1" name="documents_received" class="documents_received_first" @if($fetchedvalues['prince_info']['documents_received']==1) checked="checked" @endif>
                                                               <label for="docuy"> Yes </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="docun" class="documents_received_second" value="0" name="documents_received" @if($fetchedvalues['prince_info']['documents_received']==0) checked="checked" @endif>
                                                               <label for="docun">No</label>
                                                    </div></div></div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 expenses">
                                            <h4 class="page-title1">Expenses</h4>
                                            <div class="row">
                                                <div class="col-sm-4"><label>Refurbishment Cost</label></div>
                                                <div class="col-sm-6"><div class='input-group'>
                                                        <span class="input-group-addon">
                                                            Rs.
                                                        </span>
                                                        <input type='text' name="expense_desc" class="form-control commonvalue data-decimal rembusmentcost expense_amount required-des"  data-validation="required" data-validation-optional="false"  maxlength="7" data-validation-error-msg="Please Enter Number" @if(isset($fetchedvalues['expense_info'][0])) value="{{$fetchedvalues['expense_info'][0]->expense_amount}}" @else value="{{$fetchedvalues['prince_info']['expense_desc']}}" @endif  onkeypress="return validatedecimalKeyPress(this,event);"/>
                                                    </div></div></div>

                                            <div class="hr-dashed"></div>
                                            <div class="row">
                                                <div class="col-sm-4"><label>Transport Cost</label></div>
                                                <div class="col-sm-6"><div class='input-group'>
                                                        <span class="input-group-addon">
                                                            Rs.
                                                        </span>
                                                        <input type='text' name="expense_amount"  class="form-control commonvalue data-decimal transpostcost expense_amount required-des" data-validation="required" data-validation-optional="false"  maxlength="7" data-validation-error-msg="Please Enter Number" @if(isset($fetchedvalues['expense_info'][1]))  value="{{$fetchedvalues['expense_info'][1]->expense_amount}}" @else value="{{$fetchedvalues['prince_info']['expense_amount']}}" @endif  onkeypress="return validatedecimalKeyPress(this,event);"/>
                                                    </div></div>
                                            </div>
                                            <div class="priceextraadd">
                                                <div id="field1"><div class="hr-dashed"></div>
                                                    <div class="row expense_desc_div">
                                                        <div class="filedlist">
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control data-name validate-space expense_desc" placeholder="Enter Expenses" data-validation="alphanumeric" data-validation-allowing="\s_-" data-validation-optional="true" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please Enter Expenses name" name="extra[]" />
                                                            </div>
                                                            <div class="col-sm-6"><div class='input-group'>
                                                                    <span class="input-group-addon">
                                                                        Rs.
                                                                    </span>
                                                                    <input type="text" name="extrarupee[]"  class="form-control commonvalue data-decimal expense_amount extrasfieldamount" data-validation="required" data-validation-optional="true"  maxlength="7" data-validation-error-msg="Please Enter Number" value="" placeholder="0"  onkeypress="return validatedecimalKeyPress(this, event);" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2"><button class="btn btn-info addextras" type="button">+</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach($fetchedvalues['expense_info'] as $labelkey => $value)
                                                @if($value->expense_desc!='Transport Cost'&&$value->expense_desc!='Refurbishment Cost')
                                                <div id="field1"><div class="hr-dashed"></div>
                                                    <div class="row expense_desc_div">
                                                        <div class="filedlist removecount">
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control data-name validate-space expense_desc required-des" placeholder="" data-validation="alphanumeric" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please Enter Dealership name" name="extra[]" value="{{$value->expense_desc}}" />
                                                            </div>
                                                            <div class="col-sm-6"><div class='input-group'>
                                                                    <span class="input-group-addon">
                                                                        Rs.
                                                                    </span>
                                                                    <input type="text" name="extrarupee[]"  class="form-control commonvalue data-decimal expense_amount extrasfieldamount" data-validation="required" data-validation-optional="false"  maxlength="7" data-validation-error-msg="Please Enter Number" value="{{$value->expense_amount}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2"><button class="btn btn-danger closerow" type="button">X</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach

                                                @foreach($oldexpense as $labelkey => $value)
                                                
                                                <div id="field1"><div class="hr-dashed"></div>
                                                    <div class="row expense_desc_div">
                                                        <div class="filedlist removecount">
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control data-name validate-space expense_desc required-des" placeholder="" data-validation="alphanumeric" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please Enter Dealership name" name="extra[]" value="{{$labelkey}}" />
                                                            </div>
                                                            <div class="col-sm-6"><div class='input-group'>
                                                                    <span class="input-group-addon">
                                                                        Rs.
                                                                    </span>
                                                                    <input type="text" name="extrarupee[]"  class="form-control commonvalue data-decimal expense_amount extrasfieldamount" data-validation="required" data-validation-optional="false"  maxlength="7" data-validation-error-msg="Please Enter Number" value="{{$value}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2"><button class="btn btn-danger closerow" type="button">X</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @endforeach



                                            </div>
                                        </div>
                                    </div>

                                    <div class="hr-dashed1 col-xs-12"></div>
                                    <div class="col-xs-12">

                                        <div class="col-sm-6">
                                            <ul class="nav nav-tabs">
                                                <li  class="active"><a href="#ibb" data-toggle="tab" class="employee_tab" aria-expanded="true">IBB</a></li>
                                                <li><a href="#obv" class="employee_tab" data-toggle="tab" aria-expanded="true">OBV</a></li>
                                            </ul>
                                            <div id="myTabContent" class="tab-content">
                                                <div class="tab-pane fade active in" id="ibb">
                                                    <div class="col-xs-12 card">
                                                        <h4 class="page-title1"><span>IBB Pricing</span> <img src="{{url('img/indianbluebook.png')}}"/></h4>

                                                        <div class="col-sm-3 ibb-des">Price Type</div>
                                                        <div class="col-sm-3 ibb-des">Fair Price</div>
                                                        <div class="col-sm-3 ibb-des">Good Price</div>
                                                        <div class="col-sm-3 ibb-des">Great Price</div>

                                                        <div class="col-sm-3 ibb-des">Private Price</div>
                                                        <div class="col-sm-3 ibb-des privatefairprice">NA</div>
                                                        <div class="col-sm-3 ibb-des privategoodprice">NA</div>
                                                        <div class="col-sm-3 ibb-des privategreatprice">NA</div>

                                                        <div class="col-sm-3 ibb-des">Retail Price</div>
                                                        <div class="col-sm-3 ibb-des retailfairprice">NA</div>
                                                        <div class="col-sm-3 ibb-des retailgoodprice">NA</div>
                                                        <div class="col-sm-3 ibb-des retailgreatprice">NA</div>


                                                        <div class="col-sm-3 ibb-des">Trade In Price</div>
                                                        <div class="col-sm-3 ibb-des tipfairprice">NA</div>
                                                        <div class="col-sm-3 ibb-des tipgoodprice">NA</div>
                                                        <div class="col-sm-3 ibb-des tipgreatprice">NA</div>

                                                        <div class="col-sm-3 ibb-des">CPO Price</div>
                                                        <div class="col-sm-3 ibb-des cpofairprice">NA</div>
                                                        <div class="col-sm-3 ibb-des cpogoodprice">NA</div>
                                                        <div class="col-sm-3 ibb-des cpogreatprice">NA</div>


                                                    </div>
                                                    <input type="hidden" name="hypothacation_type" id="hypothacation_type">
                                                    <input type="hidden" name="finacier_name" id="finacier_name">
                                                    <input type="hidden" name="fla_finacier_name" id="fla_finacier_name">
                                                    <input type="hidden" name="from_date" id="from_date">

                                                    <input type="hidden" name="comp_cd_desc" id="comp_cd_desc">
                                                    <input type="hidden" name="fla_insurance_name" id="fla_insurance_name">
                                                    <input type="hidden" name="insurance_type_desc" id="insurance_type_desc">
                                                    <input type="hidden" name="insurance_from" id="insurance_from">
                                                    <input type="hidden" name="insurance_upto" id="insurance_upto">                              

                                                </div>
                                                <div class="tab-pane fade" id="obv">
                                                    <div class="col-xs-12 card">
                                                        <h4 class="page-title1"><span>OBV Pricing</span> <img src="{{url('img/logo-obv-2.png')}}"/></h4>
                                                        <div class="col-sm-4 ibb-des">Price Type</div>
                                                        <div class="col-sm-4 ibb-des">Range From</div>
                                                        <div class="col-sm-4 ibb-des">Range To</div>                                                        

                                                        <div class="col-sm-4 ibb-des">Fair</div>
                                                        <div class="col-sm-4 ibb-des obvfairrangefrom">NA</div>
                                                        <div class="col-sm-4 ibb-des obvfairrangeto">NA</div>                                                        

                                                        <div class="col-sm-4 ibb-des">Good</div>
                                                        <div class="col-sm-4 ibb-des obvgoodrangefrom">NA</div>
                                                        <div class="col-sm-4 ibb-des obvgoodrangeto">NA</div>

                                                        <div class="col-sm-4 ibb-des">Excellent</div>
                                                        <div class="col-sm-4 ibb-des obvexcellentrangefrom">NA</div>
                                                        <div class="col-sm-4 ibb-des obvexcellentrangeto">NA</div>
                                                    </div>
                                                    <input type="hidden" name="hypothacation_type" id="hypothacation_type">
                                                    <input type="hidden" name="finacier_name" id="finacier_name">
                                                    <input type="hidden" name="fla_finacier_name" id="fla_finacier_name">
                                                    <input type="hidden" name="from_date" id="from_date">

                                                    <input type="hidden" name="comp_cd_desc" id="comp_cd_desc">
                                                    <input type="hidden" name="fla_insurance_name" id="fla_insurance_name">
                                                    <input type="hidden" name="insurance_type_desc" id="insurance_type_desc">
                                                    <input type="hidden" name="insurance_from" id="insurance_from">
                                                    <input type="hidden" name="insurance_upto" id="insurance_upto">                              

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <h4 class="page-title1">Markup Price</h4>
                                            <div class="form-group">
                                                <div class="radio radio-primary radio-inline">
                                                    <input type="radio" class="percentage_price percentage_show" id="per" value="option1" name="rate" @if($fetchedvalues['prince_info']['markup_condition']=='option1') checked @endif>
                                                           <label for="per"> Percentage </label>  </div>
                                                <div class="radio radio-primary radio-inline ">
                                                    <input type="radio" id="abs" class="absolute_price absolute_show"  name="rate" value="option2" @if($fetchedvalues['prince_info']['markup_condition']=='option2') checked @endif>
                                                           <label for="abs"> Absolute</label>
                                                </div>
                                            </div>
                                            <div class="form-group  col-sm-6 percentage_cost" @if($fetchedvalues['prince_info']['markup_condition']=='option2') style="display:none;" @endif>
                                                 <label>&nbsp;</label>
                                                <div class="input-group ">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                                    <input type="text"  class="form-control data-decimal percentagevalue percentagevalidation required-des" placeholder="with in 100" data-validation="required" data-validation-optional="false"  maxlength="3" data-validation-error-msg="Please Enter Number" id="percentagevalue" name="percentage" value="{{$fetchedvalues['prince_info']['markup_percentage']}}">
                                                </div> </div>
                                            <div class="form-group  col-sm-6 rupees_cost"  @if($fetchedvalues['prince_info']['markup_condition']=='option1') style="display:none;" @endif>
                                                 <label>&nbsp;</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        Rs.
                                                    </span>
                                                    <input type="text" class="form-control absolute_amount data-decimal percentagevalue required-des" placeholder="" data-validation="required" data-validation-optional="false" maxlength="7"  data-validation-error-msg="Please Enter Number" id="percentagevalue" name="markup_amount" value="{{$fetchedvalues['prince_info']['markup_value']}}" onkeypress="return validatedecimalKeyPress(this, event);">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6"><label>Sale Price</label>

                                                <input type="text" name="pricelist" id="sale_price" disabled  class="form-control finalsaleprice absolute_amount data-decimal percentagevalue" placeholder="" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Enter Number" id="percentagevalue" value="{{$fetchedvalues['prince_info']['saleprice']}}" />
                                                <input type="hidden" name="price" value="{{$fetchedvalues['prince_info']['saleprice']}}"  class="form-control finalsalepricecorrect absolute_amount data-number percentagevalue expense_amount" placeholder="" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Enter Number" id="percentagevalue"/></div>

                                        </div>
                                    </div> 
                                    <div class="add-list-buttons">
                                        <div class="comm-button">
                                            <button type="submit" class="btn btn-circle btn-lg btn-primary basic_info" data-basic="" value="Save"  data-toggle="tooltip" data-original-title="Save" data-placement="left"><i class="fa fa-save"></i></button> 
                                        </div>

                                        <div class="comm-button">
                                            <button class="btn btn-circle btn-lg btn-primary cancelbutton" data-basic="basic_info_next" value="1" type="button"  data-toggle="tooltip" data-original-title="Cancel" data-placement="left"><i class="fa fa-remove" aria-describedby="tooltip721074"></i></button></a> 
                                        </div>
                                    </div>
                                </div>








                            </div></div></div> </div>
            </form>

        </div></div>

    <div class="modal fade" id="fastlane_details" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Vehicle Details</h4>
                    <div class="col-sm-2 col-xs-3"> 
                        <div class="form-group field-wrapper1">
                            <button class="btn btn-primary populateclick" type="button">Populate</button>  
                        </div>     
                    </div>
                    <div class="col-sm-2 col-xs-3"> 
                        <div class="form-group field-wrapper1">
                            <button class="btn btn-primary" type="button" onclick="$('#fastlane_details .close').click();">Cancel</button>  
                        </div>     
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row test_drive_body">
                        <div class="theft-title registration_mod" id="registration_mod">Registration
                            Module</div>
                        <div class="theft-pad" id="regn_num">
                            <table class="theft-table" id="regn_num_tmp">
                                <tbody>
                                    <tr>
                                        <td width="25%;"><b>Registration Number</b></td>
                                        <td width="25%;" id="regn_no"></td>
                                        <td width="25%;"><b>Engine Number</b></td>
                                        <td width="25%;" id="eng_no"></td>
                                    </tr>

                                    <tr>
                                        <td><b>State Code</b></td>
                                        <td id="state_cd"></td>
                                        <td><b>Date of Registration</b></td>
                                        <td id="regn_dt"></td>
                                    </tr>
                                    <tr>
                                        <td><b>RTO Code</b></td>
                                        <td id="rto_cd"></td>
                                        <td><b>Date of Purchase</b></td>
                                        <td id="purchase_dt"></td>
                                    </tr>
                                    <tr>
                                        <td><b>RTO Name</b></td>
                                        <td id="rto_name"></td>
                                        <td><b>Vehicle Class</b></td>
                                        <td id="vh_class_desc"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Chassis Number</b></td>
                                        <td id="chasi_no"></td>
                                        <td style="background: #ffe482;"><b>FLA Vehicle Class*</b></td>
                                        <td style="background: #ffe482;" id="fla_vh_class_desc"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="theft-title advanced_registration_module" id="advanced_registration_module">Advanced Registration
                            Module</div>
                        <div class="theft-pad">
                            <table class="theft-table">
                                <tbody>
                                    <tr>
                                        <td width="25%;"><b>Used vehicle Indicator</b></td>
                                        <td width="25%;" id="owner_sr"></td>
                                        <td width="25%;"><b>Registration Type Code</b></td>
                                        <td width="25%;" id="regn_type"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Owner Type</b></td>
                                        <td id="owner_cd_desc"></td>
                                        <td><b>Registration Type Description</b></td>
                                        <td id="regn_type_desc"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="theft-title address_module" id="address_module">Address
                            Module</div>
                        <div class="theft-pad">
                            <table class="theft-table">
                                <tbody>
                                    <tr>
                                        <td width="25%;"><b>Registered Address - City</b></td>
                                        <td width="25%;" id="c_city"></td>
                                        <td width="25%;"><b>Permanent Address - City</b></td>
                                        <td width="25%;" id="p_city"></td>

                                    </tr>
                                    <tr>
                                        <td width="25%;"><b>Registered Address - Pincode</b></td>
                                        <td width="25%;" id="c_pincode"></td>
                                        <td width="25%;"><b>Permanent Address - Pincode</b></td>
                                        <td width="25%;" id="p_pincode"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="theft-title vehicle_module" id="vehicle_module">Vehicle
                            Module</div>
                        <div class="theft-pad">
                            <table class="theft-table">
                                <tbody>
                                    <tr>
                                        <td width="25%;"><b>Brand</b></td>
                                        <td width="25%;" id="maker_desc"></td>
                                        <td width="25%;"><b>Fuel Type</b></td>
                                        <td width="25%;" id="fuel_type_desc"></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #ffe482;"><b>FLA Brand*</b></td>
                                        <td style="background: #ffe482;" id="fla_maker_desc"></td>
                                        <td style="background: #ffe482;"><b>FLA Fuel Type*</b></td>
                                        <td style="background: #ffe482;" id="fla_fuel_type_desc"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Model</b></td>
                                        <td id="maker_model"></td>
                                        <td><b>Cubic Capacity</b></td>
                                        <td id="cubic_cap"></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #ffe482;"><b>FLA Model*</b></td>
                                        <td style="background: #ffe482;" id="fla_model_desc"></td>
                                        <td style="background: #ffe482;"><b>FLA Cubic Capacity*</b></td>
                                        <td style="background: #ffe482;" id="fla_cubic_cap"></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #ffe482;"><b>FLA Variant*</b></td>
                                        <td style="background: #ffe482;" id="fla_variant"></td>
                                        <td><b>Manufacturer Year</b></td>
                                        <td id="manu_yr"></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #ffe482;"><b>FLA Subvariant*</b></td>
                                        <td style="background: #ffe482;" id="fla_sub_variant"></td>
                                        <td><b>Number of Seats</b></td>
                                        <td id="seat_cap"></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #ffe482;"><b>Series*</b></td>
                                        <td style="background: #ffe482;" id="series"></td>
                                        <td style="background: #ffe482;"><b>FLA Number of Seats*</b></td>
                                        <td style="background: #ffe482;" id="fla_seat_cap"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                        <td><b>Color</b></td>
                                        <td id="color"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="theft-title hypothecation_module" id="hypothecation_module">Hypothecation Module</div>
                        <div class="theft-pad">
                            <table class="theft-table">
                                <tbody>
                                    <tr>
                                        <td width="25%"><b>Hypothecation Date</b></td>
                                        <td width="75%" id="from_dt"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Hypothecation Type</b></td>
                                        <td id="hp_type"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Financier Name</b></td>
                                        <td id="fncr_name"></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #ffe482;"><b>FLA Financier Name*</b></td>
                                        <td style="background: #ffe482;" id="fla_fncr_name"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="theft-title insurance_module" id="insurance_module">Insurance
                            Module</div>
                        <div class="theft-pad">
                            <table class="theft-table">
                                <tbody>
                                    <tr>
                                        <td width="25%"><b>Insurance Date</b></td>
                                        <td width="75%" id="ins_from"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Insurance Type</b></td>
                                        <td id="ins_type_desc"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Insurance Company</b></td>
                                        <td id="comp_cd_desc"></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #ffe482;"><b>FLA Insurance
                                                Company*</b></td>
                                        <td style="background: #ffe482;" id="fla_ins_name"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <input type="hidden" name="fast_make_id" class="fast_make_id" id="fast_make_id" value="1">
    <input type="hidden" name="fast_model_id" class="fast_model_id" id="fast_model_id" value="1">
    <input type="hidden" name="fast_variant_id" class="fast_variant_id" id="fast_variant_id" value="1">
    <input type="hidden" name="fast_city_id" class="fast_city_id" id="fast_city_id" value="1">
    <input type="hidden" name="fast_seat_cap" class="fast_seat_cap" id="fast_seat_cap" value="1">
    <input type="hidden" name="fast_manu_yr" class="fast_manu_yr" id="fast_manu_yr" value="1">
    <input type="hidden" name="fast_owner_type" class="fast_owner_type" id="fast_owner_type" value="1">

    <input type="hidden" name="fast_hypothacation_type" class="fast_hypothacation_type" id="fast_hypothacation_type" value="1">
    <input type="hidden" name="fast_finacier_name" class="fast_finacier_name" id="fast_finacier_name" value="1">
    <input type="hidden" name="fast_fla_finacier_name" class="fast_fla_finacier_name" id="fast_fla_finacier_name" value="1">
    <input type="hidden" name="fast_from_date" class="fast_from_date" id="fast_from_date" value="1">
    <input type="hidden" name="fast_comp_cd_desc" class="fast_comp_cd_desc" id="fast_comp_cd_desc" value="1">

    <input type="hidden" name="fast_fla_insurance_name" class="fast_fla_insurance_name" id="fast_fla_insurance_name" value="1">
    <input type="hidden" name="fast_insurance_type_desc" class="fast_insurance_type_desc" id="fast_insurance_type_desc" value="1">
    <input type="hidden" name="fast_insurance_from" class="fast_insurance_from" id="fast_insurance_from" value="1">
    <input type="hidden" name="fast_insurance_upto" class="fast_insurance_upto" id="fast_insurance_upto" value="1">


    <input type="hidden" name="onloadmakechange" class="onloadmakechange" id="onloadmakechange" value="1">
    <input type="hidden" name="onloadmodelchange" class="onloadmodelchange" id="onloadmodelchange" value="1">
    <input type="hidden" name="onloadvariantchange" class="onloadvariantchange" id="onloadvariantchange" value="1">
    <input type="hidden" name="onloadbranchchange" class="onloadbranchchange" id="onloadbranchchange" value="1">
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
    <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="{{URL::asset('js/upload.js')}}"></script> 
    <script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>


    <script>
                                                                        $(document).ready(function () {
                                                                            $("body").on("click", ".cancelbutton", function () {
                                                                                window.location.replace("{{url('managelisting')}}");
                                                                            });

                                                                            $('.absolute_price').on('click', function (e) {
                                                                                $('.percentage_show').attr('checked', false);
                                                                                $(".percentage_cost").css("display", "none");
                                                                                $(".rupees_cost").css("display", "block");
                                                                                $(".percentage_cost div input").val('');
                                                                                $('.finalsaleprice').val('');
                                                                                $('.finalsalepricecorrect').val('');
                                                                            });

                                                                            $('.percentage_price').on('click', function (e) {
                                                                                $(".percentage_cost").css("display", "block");
                                                                                $(".rupees_cost").css("display", "none");
                                                                                $(".percentage_cost div input").val('');
                                                                                $('.finalsaleprice').val('');
                                                                                $('.finalsalepricecorrect').val('');
                                                                            });

                                                                            $('.testdrivepoint-inner').find('')
                                                                            $("span").removeClass("testdrivepoint-inner").addClass("testdrivepoint-outer");
                                                                            $("#park").click(function () {
                                                                                $(".own-div").hide();
                                                                                $(".park-div").show();
                                                                            });
                                                                            $("#own").click(function () {
                                                                                $(".own-div").show();
                                                                                $(".park-div").hide();
                                                                            });
                                                                            $("#deal2").click(function () {
                                                                                $(".add-auction").slideDown();
                                                                            });
                                                                            $("#deal1").click(function () {
                                                                                $(".add-auction").slideUp();
                                                                            });
                                                                        });
                                                                        $("body").on('click', '.onoffswitch-inner, .onoffswitch-switch', function () {
                                                                            if (!$('#myonoffswitch1').prop("checked"))
                                                                            {
                                                                                $('.testdrive').show();
                                                                            } else
                                                                            {
                                                                                $('.testdrive').hide();
                                                                            }
                                                                        });

                                                                        $("body").on('click', '.resetvininfo', function () {
                                                                            $('#registration_number,#engine_number,#chassis_number').val('');
                                                                        });
                                                                        $("body").on('click', '.fetchdetailsofregno', function () {
                                                                            var registration_number = $('#registration_number').val();
                                                                            var csrf_token = $('#token').val();
                                                                            if(registration_number!='')
                                                                            {
                                                                                $.ajax({
                                                                                    url: "{{url('fastlaneapicall')}}",
                                                                                    type: 'post',
                                                                                    dataType: "json",
                                                                                    data: {_token: csrf_token, registration_number: registration_number},
                                                                                    success: function (response)
                                                                                    {
                                                                                        //var json = $.parseJSON(response);
                                                                                        if (response.message == 'failure')
                                                                                        {
                                                                                            $('#fastlane_details .close').click();
                                                                                            $('#success_faliure_notification').html('<div class="alert alert-danger alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> Registration Number is not Available in system</div>');
                                                                                            setTimeout(function(){ $('#success_faliure_notification .close').click(); }, 5000);
                                                                                            return false;
                                                                                        }
                                                                                        $('.popupfastlane').click();
                                                                                        $('#success_faliure_notification').html('<div class="alert alert-success alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Retrieved the values for this vehicle</div>');
                                                                                        setTimeout(function(){ $('#success_faliure_notification .close').click(); }, 5000);
                                                                                        $.each(response.data, function (key, val) {

                                                                                            if (val != '')
                                                                                            {
                                                                                                $('#' + key).prev().addClass('show');
                                                                                            }
                                                                                            $('#' + key).val(val);
                                                                                        });

                                                                                        $.each(response.modaldata, function (key, val) {
                                                                                            $('#' + key).text(val);
                                                                                        });

                                                                                        $.each(response.modaldata, function (key, val) {
                                                                                            $('#' + key).text(val);
                                                                                        });

                                                                                        $.each(response.datawithids, function (key, val) {
                                                                                            $('#' + key).val(val);
                                                                                        });

                                                                                    },
                                                                                    error: function (e)
                                                                                    {
                                                                                        //console.log(e.responseText);
                                                                                    }
                                                                                });
                                                                            }
                                                                            else
                                                                            {
                                                                                $('#success_faliure_notification').html('<div class="alert alert-danger alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong>Please Enter Registration Number for fetch</div>');
                                                                                setTimeout(function(){ $('#success_faliure_notification .close').click(); }, 5000);
                                                                                return false;
                                                                            }
                                                                        });
                                                                        $('.populateclick').click(function () {
                                                                            var fast_make_id = $('#fast_make_id').val();
                                                                            var fast_model_id = $('#fast_model_id').val();
                                                                            var fast_variant_id = $('#fast_variant_id').val();
                                                                            var fast_seat_cap = $('#fast_seat_cap').val();
                                                                            var fast_manu_yr = $('#fast_manu_yr').val();
                                                                            var fast_owner_type = $('#fast_owner_type').val();
                                                                            var fast_hypothacation_type = $('#fast_hypothacation_type').val();
                                                                            var fast_finacier_name = $('#fast_finacier_name').val();
                                                                            var fast_fla_finacier_name = $('#fast_fla_finacier_name').val();
                                                                            var fast_from_date = $('#fast_from_date').val();

                                                                            var fast_comp_cd_desc = $('#fast_comp_cd_desc').val();
                                                                            var fast_fla_insurance_name = $('#fast_fla_insurance_name').val();
                                                                            var fast_insurance_type_desc = $('#fast_insurance_type_desc').val();
                                                                            var fast_insurance_from = $('#fast_insurance_from').val();
                                                                            var fast_insurance_upto = $('#fast_insurance_upto').val();

                                                                            var csrf_token = $('#token').val();
                                                                            $('.registration_year').val(fast_manu_yr);
                                                                            $('.finacier_name').val(fast_owner_type);

                                                                            $('#hypothacation_type').val(fast_hypothacation_type);
                                                                            $('#finacier_name').val(fast_finacier_name);
                                                                            $('#fla_finacier_name').val(fast_fla_finacier_name);
                                                                            $('#from_date').val(fast_from_date);
                                                                            $('#comp_cd_desc').val(fast_comp_cd_desc);
                                                                            $('#fla_insurance_name').val(fast_fla_insurance_name);
                                                                            $('#insurance_type_desc').val(fast_insurance_type_desc);
                                                                            $('#insurance_from').val(fast_insurance_from);
                                                                            $('#insurance_upto').val(fast_insurance_upto);


                                                                            if (fast_make_id != 0)
                                                                            {
                                                                                $('[name="make"]').val(fast_make_id);
                                                                                $('[name="model"]').empty();
                                                                                $.ajax({
                                                                                    url: "{{url('fetch_model_car')}}",
                                                                                    type: 'post',
                                                                                    data: {_token: csrf_token, make: fast_make_id},
                                                                                    success: function (response)
                                                                                    {
                                                                                        var json = $.parseJSON(response);
                                                                                        $('[name="model"]').append($('<option>', {value: '', text: 'Select Model'}));
                                                                                        $.each(json, function (arrayID, group) {

                                                                                            $('[name="model"]').append($('<option>', {value: group.model_id, text: group.model_name}));
                                                                                        });


                                                                                        if (fast_model_id != 0)
                                                                                        {
                                                                                            $('[name="model"]').val(fast_model_id);
                                                                                            $('[name="variant"]').empty();
                                                                                            $.ajax({
                                                                                                url: "{{url('fetch_variant')}}",
                                                                                                type: 'post',
                                                                                                data: {_token: csrf_token, variant: fast_model_id},
                                                                                                success: function (response)
                                                                                                {
                                                                                                    var json = $.parseJSON(response);
                                                                                                    $('[name="variant"]').append($('<option>', {value: '', text: 'Select Variant'}));
                                                                                                    $.each(json, function (arrayID, group) {

                                                                                                        $('[name="variant"]').append($('<option>', {value: group.variant_id, text: group.variant_name}));
                                                                                                    });

                                                                                                    if (fast_variant_id != 0)
                                                                                                    {
                                                                                                        $('[name="variant"]').val(fast_variant_id);
                                                                                                        $.ajax({
                                                                                                            url: "{{url('fetch_category')}}",
                                                                                                            type: 'post',
                                                                                                            data: {_token: csrf_token, category: fast_variant_id},
                                                                                                            success: function (response)
                                                                                                            {
                                                                                                                var json = $.parseJSON(response);
                                                                                                                $.each(json, function (arrayID, group)
                                                                                                                {
                                                                                                                    if (arrayID == '0')
                                                                                                                    {
                                                                                                                        $('[name="category_id"]').val(group.category_id);
                                                                                                                    }
                                                                                                                    if (arrayID == 1) {
                                                                                                                        $('.fueltyperesponse').val(group.fuel_type);
                                                                                                                    }
                                                                                                                    if (arrayID == 2) {
                                                                                                                        $('.transmission').val(group.Transmission_Type);
                                                                                                                    }
                                                                                                                });
                                                                                                            },
                                                                                                        });
                                                                                                    }
                                                                                                },
                                                                                            });
                                                                                        }
                                                                                    },
                                                                                });
                                                                            }
                                                                            $('#fastlane_details .close').click();
                                                                        });

                                                                        $("body").on('change', '[name="make"]', function () {
                                                                            var make = $(this).val();
                                                                            var csrf_token = $('#token').val();
                                                                            if ($('.onloadmakechange').val() != 1)
                                                                            {
                                                                                $('[name="model"]').empty();
                                                                                $.ajax({
                                                                                    url: "{{url('fetch_model_car')}}",
                                                                                    type: 'post',
                                                                                    data: {_token: csrf_token, make: make},
                                                                                    success: function (response)
                                                                                    {
                                                                                        var json = $.parseJSON(response);
                                                                                        $('[name="model"]').append($('<option>', {value: '', text: 'Select Model'}));
                                                                                        $.each(json, function (arrayID, group) {

                                                                                            $('[name="model"]').append($('<option>', {value: group.model_id, text: group.model_name}));
                                                                                        });
                                                                                    },
                                                                                    error: function (e)
                                                                                    {
                                                                                        //console.log(e.responseText);
                                                                                    }
                                                                                });
                                                                            } else {
                                                                                $('.onloadmakechange').val(0);
                                                                            }
                                                                        });
                                                                        $("body").on('change', '[name="model"]', function () {
                                                                            var variant = $(this).val();
                                                                            var csrf_token = $('#token').val();
                                                                            if ($('.onloadmodelchange').val() != 1)
                                                                            {
                                                                                $('[name="variant"]').empty();
                                                                                $.ajax({
                                                                                    url: "{{url('fetch_variant')}}",
                                                                                    type: 'post',
                                                                                    data: {_token: csrf_token, variant: variant},
                                                                                    success: function (response)
                                                                                    {
                                                                                        var json = $.parseJSON(response);
                                                                                        $('[name="variant"]').append($('<option>', {value: '', text: 'Select Variant'}));
                                                                                        $.each(json, function (arrayID, group) {

                                                                                            $('[name="variant"]').append($('<option>', {value: group.variant_id, text: group.variant_name}));
                                                                                        });
                                                                                    },
                                                                                    error: function (e)
                                                                                    {
                                                                                        console.log(e.responseText);
                                                                                    }
                                                                                });
                                                                            } else
                                                                            {
                                                                                $('.onloadmodelchange').val(0)
                                                                            }
                                                                        });

                                                                        $("body").on('change', '[name="variant"]', function () {
                                                                            var category = $(this).val();
                                                                            var csrf_token = $('#token').val();
                                                                            if ($('#onloadvariantchange').val() != 1)
                                                                            {
                                                                                //$('[name="category_id"]').empty();
                                                                                $.ajax({
                                                                                    url: "{{url('fetch_category')}}",
                                                                                    type: 'post',
                                                                                    data: {_token: csrf_token, category: category},
                                                                                    success: function (response)
                                                                                    {
                                                                                        var json = $.parseJSON(response);
                                                                                        $.each(json, function (arrayID, group)
                                                                                        {
                                                                                            if (arrayID == '0')
                                                                                            {
                                                                                                $('[name="category_id"]').val(group.category_id);
                                                                                            }
                                                                                            if (arrayID == 1) {
                                                                                                $('.fueltyperesponse').val(group.fuel_type);
                                                                                                //console.log(group.fuel_type);
                                                                                            }
                                                                                            if (arrayID == 2) {
                                                                                                $('.transmission').val(group.Transmission_Type);
                                                                                                //console.log(group.fuel_type);
                                                                                            }
                                                                                        });
                                                                                    },
                                                                                    error: function (e)
                                                                                    {
                                                                                        //console.log(e.responseText);
                                                                                    }
                                                                                });
                                                                            } else
                                                                            {
                                                                                $('.onloadvariantchange').val(0)
                                                                            }
                                                                        });


                                                                        $("body").on('change', '.thirdpartyfetch', function () {
                                                                            var registration_year = $('[name="registration_year"]').val();
                                                                            var make = $('[name="make"]').val();
                                                                            var model = $('[name="model"]').val();
                                                                            var variant = $('[name="variant"]').val();
                                                                            var kms_done = $('[name="kms_done"]').val();
                                                                            var colors = $('[name="colors"]').val();
                                                                            var owner_type = $('[name="owner_type"]').val();
                                                                            var place = $('[name="place"]').val();
                                                                            if(registration_year!=''&&make!=''&&model!=''&&variant!=''&&kms_done!=''&&colors!=''&&owner_type!=''&&place!='')
                                                                            {
                                                                                var csrf_token = $('#token').val();
                                                                                $.ajax({
                                                                                    url: "{{url('IBBpricing')}}",
                                                                                    type: 'post',
                                                                                    data: {_token: csrf_token, registration_year: registration_year, make: make, model: model, variant: variant, kms_done: kms_done, colors: colors, owner_type: owner_type, place: place},
                                                                                    success: function (response)
                                                                                    {
                                                                                        var json = $.parseJSON(response);
                                                                                        $.each(json, function (arrayID, group)
                                                                                        {
                                                                                            if (arrayID == 0) {
                                                                                                $('.privatefairprice').html('Rs. ' + group.Low);
                                                                                                $('.privategoodprice').html('Rs. ' + group.Medium);
                                                                                                $('.privategreatprice').html('Rs. ' + group.Good);
                                                                                            } else if (arrayID == 1) {
                                                                                                $('.retailfairprice').html('Rs. ' + group.Low);
                                                                                                $('.retailgoodprice').html('Rs. ' + group.Medium);
                                                                                                $('.retailgreatprice').html('Rs. ' + group.Good);
                                                                                            } else if (arrayID == 2) {
                                                                                                $('.tipfairprice').html('Rs. ' + group.Low);
                                                                                                $('.tipgoodprice').html('Rs. ' + group.Medium);
                                                                                                $('.tipgreatprice').html('Rs. ' + group.Good);
                                                                                            } else if (arrayID == 3) {
                                                                                                $('.cpofairprice').html('Rs. ' + group.Low);
                                                                                                $('.cpogoodprice').html('Rs. ' + group.Medium);
                                                                                                $('.cpogreatprice').html('Rs. ' + group.Good);
                                                                                            }
                                                                                            else if (arrayID == 4) {
                                                                                                $('.obvfairrangefrom').html('Rs. ' + group.range_from);
                                                                                                $('.obvfairrangeto').html('Rs. ' + group.range_to);
                                                                                            }
                                                                                            else if (arrayID == 5) {
                                                                                                $('.obvgoodrangefrom').html('Rs. ' + group.range_from);
                                                                                                $('.obvgoodrangeto').html('Rs. ' + group.range_to);
                                                                                            }
                                                                                            else if (arrayID == 6) {
                                                                                                $('.obvexcellentrangefrom').html('Rs. ' + group.range_from);
                                                                                                $('.obvexcellentrangeto').html('Rs. ' + group.range_to);
                                                                                            }
                                                                                        });
                                                                                    },
                                                                                    error: function (e)
                                                                                    {
                                                                                        //console.log(e.responseText);
                                                                                    }
                                                                                });
                                                                            }
                                                                        });

                                                                        $("body").on('change', '[name="place"]', function () {
                                                                            var city_id = $(this).val();
                                                                            var csrf_token = $('#token').val();
                                                                            if ($('#onloadbranchchange').val() != 1)
                                                                            {
                                                                                $('[name="branch"]').empty();
                                                                                $.ajax({
                                                                                    url: "{{url('fetch_citybranch')}}",
                                                                                    type: 'post',
                                                                                    data: {_token: csrf_token, city_id: city_id},
                                                                                    success: function (response)
                                                                                    {
                                                                                        var json = $.parseJSON(response);
                                                                                        $('[name="branch"]').append($('<option>', {value: '', text: 'Select Branch'}));
                                                                                        $.each(json, function (arrayID, group) {

                                                                                            $('[name="branch"]').append($('<option>', {value: group.branch_id, text: group.dealer_name}));
                                                                                        });
                                                                                    },
                                                                                    error: function (e)
                                                                                    {
                                                                                        //console.log(e.responseText);
                                                                                    }
                                                                                });
                                                                            } else
                                                                            {
                                                                                $('.onloadbranchchange').val(0)
                                                                            }
                                                                        });

                                                                        $("body").on('keyup', '.percentagevalue,.commonvalue', function () {
                                                                            if ($('.percentagevalue').val() > 100) {
                                                                                return false;
                                                                            }
                                                                            var price;
                                                                            var remb_cost;
                                                                            var trans_cost;
                                                                            var extra_cost;
                                                                            var absolute_amount;
                                                                            var percent_value;
                                                                            var purchased_price;
                                                                            price = $('.dealer_mark_price').val();
                                                                            remb_cost = $('.rembusmentcost').val();
                                                                            trans_cost = $('.transpostcost').val();
                                                                            extra_cost = $('.extrasfieldamount').val();
                                                                            absolute_amount = $('.absolute_amount').val();
                                                                            percent_value = $('.percentagevalue').val();
                                                                            purchased_price = $('.purchased_price').val();

                                                                            var extra_field_sum = 0;
                                                                            $('.extrasfieldamount').each(function () {
                                                                                if ($(this).val() != '')
                                                                                {
                                                                                    extra_field_sum += parseFloat($(this).val());
                                                                                }
                                                                            });

                                                                            price = $('.dealer_mark_price').val();
                                                                            remb_cost = $('.rembusmentcost').val();
                                                                            trans_cost = $('.transpostcost').val();
                                                                            extra_cost = $('.extrasfieldamount').val();
                                                                            if ($('.inventory_type_own').prop('checked')) {
                                                                                if ($('.percentage_show').prop('checked')) {
                                                                                    var result = (parseFloat(purchased_price) + parseFloat(remb_cost) + parseFloat(trans_cost) + parseFloat(extra_field_sum)) + ((parseFloat(purchased_price) + parseFloat(remb_cost) + parseFloat(trans_cost) + parseFloat(extra_field_sum)) * (parseFloat(percent_value) / 100));
                                                                                }
                                                                                if ($('.absolute_show').prop('checked')) {
                                                                                    var result = parseFloat(purchased_price) + parseFloat(remb_cost) + parseFloat(trans_cost) + parseFloat(extra_field_sum) + parseFloat(absolute_amount);
                                                                                }
                                                                            }
                                                                            if ($('.inventory_type_park').prop('checked')) {
                                                                                if ($('.percentage_show').prop('checked')) {
                                                                                    var ps_cost = (parseFloat(price) + parseFloat(remb_cost) + parseFloat(trans_cost) + parseFloat(extra_field_sum));
                                                                                    var profit = ps_cost * (parseFloat(percent_value) / 100);
                                                                                    var result = ps_cost + profit;
                                                                                }
                                                                                if ($('.absolute_show').prop('checked')) {
                                                                                    var result = parseFloat(price) + parseFloat(remb_cost) + parseFloat(trans_cost) + parseFloat(extra_field_sum) + parseFloat(absolute_amount);
                                                                                }
                                                                            }
                                                                            if (isNaN(parseFloat(result)))
                                                                            {
                                                                                result = 0;
                                                                            }
                                                                            $('.finalsaleprice').val(parseFloat(result).toFixed(2));
                                                                            $('.finalsalepricecorrect').val(parseFloat(result).toFixed(2));
                                                                        });

                                                                        $(document).on('click', '.addextras', function () {
                                                                            var expensecheck = $(".expense_desc:last").val();
                                                                            if (expensecheck == "")
                                                                            {
                                                                                $(".expense_desc:nth-last-child(1)").addClass("errorform");
                                                                                $(".expense_amount:nth-last-child(1)").addClass("errorform");
                                                                                return false;
                                                                            } else {
                                                                                $(".expense_desc:nth-last-child(1)").removeClass("errorform");
                                                                                $(".expense_amount:nth-last-child(1)").removeClass("errorform");
                                                                                $('.priceextraadd').append('<div id="field1"><div class="hr-dashed"></div><div class="row expense_desc_div"><div class="filedlist removecount"><div class="col-sm-4"><input type="text" class="form-control data-name validate-space expense_desc" placeholder="Enter Expenses" data-validation="alphanumeric" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please Enter Expense" name="extra[]"/></div><div class="col-sm-6"><div class="input-group"><span class="input-group-addon">Rs.</span><input type="text" name="extrarupee[]"  value="" class="form-control commonvalue data-decimal expense_amount extrasfieldamount" placeholder="" data-validation="required" data-validation-optional="false"  maxlength="7" data-validation-error-msg="Please Enter Number" value=""/></div></div><div class="col-sm-2"><button class="btn btn-danger closerow" type="button">X</button></div></div></div></div></div>');
                                                                            }
                                                                        });

                                                                        $(document).on('click', '.closerow', function () {
                                                                            $(this).closest('div #field1').remove();
                                                                            $('.finalsaleprice').val('');
                                                                            $('.percentagevalue').val('');
                                                                            return false;
                                                                        });

                                                                        $('.date').datetimepicker('setEndDate', new Date());

                                                                        function validateFloatKeyPress(el) {
                                                                            var v = parseFloat(el.value);
                                                                            if (v > 100) {
                                                                                alert('Kindly Enter Less than 100');
                                                                                $('.milles').val('');
                                                                                return false;
                                                                            }
                                                                            var splict = el.value.split('.');
                                                                            var count = splict.length;
                                                                            //console.log(splict);
                                                                            //console.log(count);
                                                                            if (count > 1) {
                                                                                if (splict[0] > 99) {
                                                                                    alert('Kindly Enter Less than 100');
                                                                                    $('.milles').val('');
                                                                                    return false;
                                                                                }
                                                                                if (splict[1] > 99) {
                                                                                    alert('Kindly Enter Less than 100');
                                                                                    $('.milles').val('');
                                                                                    return false;
                                                                                }
                                                                            }
                                                                        }

                                                                        function validatedecimalKeyPress(el, evt) {
                                                                            var charCode = (evt.which) ? evt.which : event.keyCode;
                                                                            var number = el.value.split('.');
                                                                            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                                                                                return false;
                                                                            }
                                                                            //just one dot
                                                                            if (number.length > 1 && charCode == 46) {
                                                                                return false;
                                                                            }
                                                                            //get the carat position
                                                                            var caratPos = getSelectionStart(el);
                                                                            var dotPos = el.value.indexOf(".");
                                                                            if (caratPos > dotPos && dotPos > -1 && (number[1].length > 1)) {
                                                                                return false;
                                                                            }
                                                                            return true;
                                                                        }

                                                                        //thanks: http://javascript.nwbox.com/cursor_position/
                                                                        function getSelectionStart(o) {
                                                                            if (o.createTextRange) {
                                                                                var r = document.selection.createRange().duplicate()
                                                                                r.moveEnd('character', o.value.length)
                                                                                if (r.text == '')
                                                                                    return o.value.length
                                                                                return o.value.lastIndexOf(r.text)
                                                                            } else
                                                                                return o.selectionStart
                                                                        }
    </script>