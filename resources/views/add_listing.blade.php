<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">
        <title>Dealer Plus-Add listing</title>
        <!-- Font awesome -->        
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <!-- Bootstrap file input -->
        <link rel="stylesheet" href="css/fileinput.min.css">
        <!-- <link rel="stylesheet" href="css/font-awesome.min.css">-->
        <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-select.css')}}">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="{{URL::asset('css/awesome-bootstrap-checkbox.css')}}">
        <!-- Admin Stye -->
        <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">

        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <style type='text/css'> 
            .spinner {
                position: fixed;
                text-align:center;
                z-index:2000;
                overflow: auto;
                width: 100%; 
                height: 100%; 
                opacity: .4; 
                background-color:rgba(0, 0, 0, 10);
                padding-top:20%;
                margin-left:-17%;
            }
            .btn-file {
                position: relative;
                overflow: hidden;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
        </style>
    </head>
    <body>

        @include('header')
        <div class="brand1 clearfix hidden-md hidden-lg"><nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle mobile-view" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Main Menu</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="index.html">Buy<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="search.html">Search</a></li>
                                    <li><a href="save.html">Saved Cars</a></li>
                                    <li class="dropdown-submenu">
                                        <a class="test"  href="myquery.html">My Queries <span class="caret"></span></a>
                                        <!--<ul class="dropdown-menu">
                                          <li><a href="#">2nd level dropdown</a></li>
                                          <li><a href="#">2nd level dropdown</a></li>
                                          </ul>-->
                                    </li>
                                    <li><a href="bids.html">Bids Posted</a></li>
                                    <li><a href="fund.html">Apply Inventory Funding</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="listing.html">Sell<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="inventory.html">My Inventory</a></li>
                                    <li><a href="myposting.html">My Postings</a></li>
                                    <li class="dropdown-submenu">
                                        <a class="test" href="myauction.html">My Auctions <span class="caret"></span></a>
                                    </li>
                                    <li><a href="queries.html">Queries Received</a></li>
                                    <li><a href="apply-loan.html">Apply Loan For Customers</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="managelisting.html">Manage <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="myprofile.html">My Profile</a></li>
                                    <li><a href="mybranch.html">My Branches</a></li>
                                    <li><a href="myleads.html">My Leads</a></li>
                                    <li class="dropdown-submenu">
                                        <a class="test" href="mycustomer.html">My Customer <span class="caret"></span></a>
                                        <!--<ul class="dropdown-menu">
                                          <li><a href="#">2nd level dropdown</a></li>
                                          <li><a href="#">2nd level dropdown</a></li>
                                          </ul>-->
                                    </li>
                                    <li><a href="Mycontact.html">My Contacts</a></li>
                                    <li><a href="myuser.html">My Users</a></li>
                                    <li><a href="subscription.html">Subscriptions</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="myaccount.html">Communication <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">My Groups</a></li>
                                    <li><a href="#">Marketing</a></li>
                                    <li class="dropdown-submenu">
                                        <a class="test" href="#">Promotions<span class="caret"></span></a>
                                        <!--<ul class="dropdown-menu">
                                          <li><a href="#">2nd level dropdown</a></li>
                                          <li><a href="#">2nd level dropdown</a></li>
                                          </ul>--></li>
                                    <li><a href="#">Notifications</a></li>
                                    <li><a href="#">Messages</a></li>

                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="detail-list.html">Reports <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Sales</a></li>
                                    <li><a href="#">Inventory</a></li>
                                    <li class="dropdown-submenu">
                                        <a class="test" href="#">Expenses<span class="caret"></span></a>
                                        <!--<ul class="dropdown-menu">
                                          <li><a href="#">dropdown</a></li>
                                          <li><a href="#">dropdown</a></li>
                                          </ul>--></li>
                                    <li><a href="#">Profit & Loss</a></li>
                                    <li><a href="#">User Reports</a></li>

                                </ul>
                            </li></ul>
                    </div>
                </div>
            </nav></div>

        <div class="ts-main-content">
            @include('sell_side_bar')
            <div class="content-wrapper add-product">
                <div class="container-fluid">
                    <div id="loadspinner" class="spinner" style="display:none;">
                        <img id="img-spinner" src="{{url('ajax-loader.gif')}}" alt="Loading"/>
                    </div>        
                    <div class="row">
                        <div class="content-header col-sm-12">
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
                                <li><a href="index.html"><i class="fa fa-dashboard"></i> Buy</a></li>
                                <li class="active">Add Listing</li>
                            </ol>
                        </div>

                        <div class="col-md-12">
                            <h2 class="page-title">Listing-id : {{$dp_listid}}</h2>
                            <h2 class="page-title">Add Listing</h2>
                            <br/>
                            <!-- Modal -->
                            <div id="confirmexit" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <!-- Modal content-->
                                <form method="post" id="exitinevntory">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Listing Exit Screen</h4>
                                  </div>
                                  <div class="modal-body">
                                    <p>You Want to Continue OR Exit from this Screen</p>
                                  </div>
                                  <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
                                    <input type="submit" class="btn btn-default inventoryexit" value="Exit">
                                  </div>
                                </div>
                                </form>
                              </div>
                            </div>
                            <form method="post" action="{{url('mongo_push')}}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                                <div class="panel-group add-list" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default firsttab">
                                        <div class="panel-heading basictab"  role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Basic Info <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in basicinfohide" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <h2 class="commontab" style="display:none;color:red;"></h2>
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Registration Year</label>
                                                        <select class="form-control registration_year" name="registration_year">
                                                            @if(isset($registration_year))
                                                            @foreach($year as $value)
                                                            @if($value == $registration_year)
                                                            <option value = "{{$registration_year}}" selected>{{$registration_year}}
                                                            </option>
                                                            @else
                                                            <option value = "{{$value}}">{{$value}}</option>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($year as $value)
                                                            <option value = "{{$value}}">{{$value}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>     
                                                </div>
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Category</label>
                                                        <select class="form-control category_id" name="category_id">
                                                            <option value = "">Select Category</option>
                                                            @if(isset($category_id))
                                                            @foreach($selectcategory as $key=>$value)
                                                            @if($value->category_id == $category_id)
                                                            <option value = "{{$value->category_id}}" selected>{{$value->category_description}}</option>  
                                                            @else
                                                            <option value = "{{$value->category_id}}">{{$value->category_description}}</option>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($selectcategory as $key=>$value)
                                                            <option value = "{{$value->category_id}}">{{$value->category_description}}</option>
                                                            @endforeach
                                                            @endif        
                                                        </select>
                                                    </div>     
                                                </div> 

                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Make</label>
                                                        <select class="form-control make" name="make">
                                                            <option value="">Select Make</option>     
                                                            @if(isset($make_name))    
                                                            @foreach($make as $key=>$value)
                                                            @if($value->make_id == $make_name)
                                                            <option value = "{{$value->make_id}}" selected>{{$value->makename}}</option>  
                                                            @else
                                                            <option value = "{{$value->make_id}}">{{$value->makename}}</option>   
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($make as $key=>$value)
                                                            <option value = "{{$value->make_id}}">{{$value->makename}}</option>   
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>     
                                                </div> 
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Model</label>
                                                        <select class="form-control model " name="model">
                                                            <option value="">Select Model</option>
                                                            @if(isset($modelname))
                                                            @foreach($model as $key=>$value)
                                                            @if($value->model_id == $modelname)
                                                            <option value = "{{$value->model_id}}" selected>{{$value->model_name}}</option>
                                                            @else
                                                            <option value = "{{$value->model_id}}">{{$value->model_name}}</option>   
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($model as $key=>$value)
                                                            <option value = "{{$value->model_id}}">{{$value->model_name}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>    
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Variant</label>
                                                        <select class="form-control variant" name="variant">
                                                            <option value="">Select variant</option>
                                                            @if(isset($variant_id))
                                                            @foreach($Variant as $key=>$value)
                                                            @if($value->variant_id == $variant_id)   
                                                            <option value = "{{$value->variant_id}}" selected>{{$value->variant_name}}</option> 
                                                            @else
                                                            <option value = "{{$value->variant_id}}">{{$value->variant_name}}</option>   
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($Variant as $key=>$value)
                                                            <option value = "{{$value->variant_id}}">{{$value->variant_name}}</option>   
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>     
                                                </div>
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Kms Done</label>
                                                        @if(isset($kms_done))
                                                        <input type="text" class="form-control kms_done" name="kms_done" placeholder="Kms Done" value='{{$kms_done}}'>
                                                        @else
                                                        <input type="text" class="form-control kms_done" name="kms_done" placeholder="Kms Done" value="">
                                                        @endif
                                                    </div>     </div>  
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Mileage</label>
                                                        @if(isset($mileage))
                                                        <input type="text" class="form-control mileage" name="mileage" placeholder="Mileage" value='{{$mileage}}'>
                                                        @else
                                                        <input type="text" class="form-control mileage" name="mileage" placeholder="Mileage" value="">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Ownership</label>
                                                        <select class="form-control owner_type" name="owner_type">
                                                            @if(isset($owner_type))
                                                            @foreach($Ownership as $key=>$value)
                                                            @if($key == $owner_type)
                                                            <option value = "{{$key}}" selected>{{$value}}</option>  
                                                            @else
                                                            <option value = "{{$key}}">{{$value}}</option>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($Ownership as $key=>$value)
                                                            <option value = "{{$key}}">{{$value}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>     
                                                </div> 
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Car Status</label>
                                                        <select class="form-control status" name="status">
                                                            @if(isset($car_list_status))
                                                            @foreach($CarStatus as $key=>$value)
                                                            @if($key == $car_list_status)
                                                            <option value = "{{$key}}" selected>{{$value}}</option>  
                                                            @else
                                                            <option value = "{{$key}}">{{$value}}</option>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($CarStatus as $key=>$value)
                                                            <option value = "{{$key}}">{{$value}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>     </div>
                                                <div class="col-sm-3">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Color</label>
                                                        <select class="form-control colors" name="colors">
                                                            <option value="">Color</option>
                                                            @if(isset($colors))
                                                            @foreach($color as $key=>$value)
                                                            @if($value->colour_id == $colors)
                                                            <option value = "{{$value->colour_id}}" selected>{{$value->colour_name}}</option>
                                                            @else
                                                            <option value = "{{$value->colour_id}}">{{$value->colour_name}}</option>   
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($color as $key=>$value)
                                                            <option value = "{{$value->colour_id}}">{{$value->colour_name}}</option>   
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>     </div>   
                                                <div class="col-sm-3"> 
                                                    <div class="form-group field-wrapper1">
                                                        <label>Location</label>
                                                        <select class="form-control place" name="place">
                                                            <option>Select city</option>
                                                            @if(isset($car_city))
                                                            @foreach($City as $key=>$value)
                                                            @if($value->city_id == $car_city)
                                                            <option value = "{{$value->city_id}}" selected>{{$value->city_name}}</option>
                                                            @else
                                                            <option value = "{{$value->city_id}}">{{$value->city_name}}</option>   
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($City as $key=>$value)
                                                            <option value = "{{$value->city_id}}">{{$value->city_name}}</option>   
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>     </div>  
                                                <div class="col-sm-3"> 
                                                    <div class="form-group field-wrapper1">
                                                        <label>Fuel Type</label>
                                                        <select class="form-control fuel_type" name="fuel_type">
                                                            @if(isset($fuel_type))
                                                            @foreach($selectfuel as $key=>$value)
                                                            @if($key == $fuel_type)
                                                            <option value = "{{$key}}" selected>{{$value}}</option>  
                                                            @else
                                                            <option value = "{{$key}}">{{$value}}</option>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @foreach($selectfuel as $key=>$value)
                                                            <option value = "{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    @endif                 
                                                    </select>
                                                </div>     
                                            </div> 
                                           <!--  <div class="col-sm-3"> 
                                                <div class="form-group field-wrapper1">
                                                    <label>Location</label>
                                                    <input type="text" class="form-control" name="place" placeholder="Location">
                                                </div>     
                                                </div>       -->
                                            <div class="col-sm-6">
                                            <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                <a href="#collapsevideo" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseTwo"><button class="btn btn-primary basic_info" value="1" type="button">Save changes</button></a> </div></div>
                                        </div>
                                    </div>
                                    <!-- </form> -->

                                    <div class="panel panel-default secondtab">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a href="#collapseimages" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapsevideo">
                                Upload image <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                            </a>
                        </h4>
                    </div>

                    <div id="collapseimages" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                        <h2 class="commontab" style="display:none;color:red;"></h2>
                        <form id="inventry-images" method="post" enctype="multipart/form-data">
                            <div class="col-sm-8">
                                <label class="btn btn-primary btn-file">
                                    Browse <input type="file" name="inventry_image" id="fileupload"  style="display: none;" multiple>
                                </label>
                                <!--<input type="file" name="inventry_image" id="fileupload" multiple>-->
                                <span class="imageerror" style="color:red"></span>
                                <div id="preview"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                     @if(!empty($list_images))
                                        @foreach($list_images as $image_value)
                                    <div class="col-md-3">
                                        <a class="removeimage" data-id="{{$image_value->inventry_primary_id}}>" data-imageid="{{$image_value->photo_id}}" data-imagename="{{$image_value->photo_link}}"><img src="{{ url($image_value->photo_link_fullpath)}}" class="img-responsive "></img></a>
                                    </div>
                                    @endforeach
                                    @endif
                                        </div>
                                    </div>                           
                            </div>

                        <div class="col-sm-3">
                            <div class="form-group field-wrapper1">
                                <a href="#collapseimages"  class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseThree">
                                <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                <input type="submit" id="upload_images" name="uploadimages" class="btn btn-primary" value="Save changes">
                                </a>
                            </div>
                            <button class="btn btn-primary upload_skip_second">Skip</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                                    <div class="panel panel-default thirdtab">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <h4 class="panel-title">
                                                <a href="#collapse_video" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapsevideo">
                                                    Upload Videos <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_video" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="panel-body">
                                            <h2 class="commontab" style="display:none;color:red;"></h2>
                                        <form method="post" id="dealer_form_video" enctype="multipart/form-data">
                                                <div class="col-sm-8 image-upload">
                                                 <div id="video_drop1">
                                                    <input name="car_video_upload" id="videosname" type="file"><br/>         
                                                </div>
                                                <!-- ****************** -->
                                                <div class="row">
                                                <div class="col-md-12">
                                                @if(!empty($video_images))
                                                    @foreach($video_images as $image_value)
                                                <div class="col-md-6">
                                                    <video width="320" height="240" controls>
                                                      <source src="{{url($image_value->folder_path)}}" type="video/mp4">
                                                    </video>
                                                </div>
                                                @endforeach
                                                @endif
                                                </div>
                                                </div> 
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                <div class="form-group field-wrapper1">
                                                    <a href=""  class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseThree">
                                                    <button class="btn btn-primary vehicle_video" type="submit">Save changes</button>
                                                    </a>
                                                </div>
                                                 <button class="btn btn-primary upload_skip_third">Skip</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                    
                                <div class="panel panel-default fourthtab">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a href="#collapseThree"  class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseThree">
                                                Documents <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <form method="post" id="dealer_form" enctype="multipart/form-data">
                                        <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                            <div class="panel-body row">

                                                <div class="row">
                                                <div class="col-md-12">
                                                @if(!empty($document_images))
                                                    @foreach($document_images as $image_value)
                                                <div class="col-md-2">
                                                    <img data-source="{{$image_value->document_id}}" src="{{url($image_value->folder_path)}}" class="img-responsive" height="150px;" width="150px;"></img>
                                                </div>
                                                @endforeach
                                                @endif
                                                </div>
                                                </div>   

                                                <div class="col-sm-12 document">
                                                    <div class="col-sm-3">
                                                        <label>RC</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <input type="hidden" name="document_first" value="0"/>
                                                     <input type="file" name="dd_documents[]" class="BSbtninfo"/>
                                                    </div>
                                                    <div class="col-sm-3 prog-onile"><div class="progress progress-striped active">
                                                            <div class="progress-bar" style="width: 45%"></div>
                                                        </div></div>
                                                </div>


                                                <div class="col-sm-12 document">
                                                    <div class="col-sm-3">
                                                        <label>Insurance</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <input type="hidden" name="document_second" value="1"/>
                                                     <input type="file" name="dd_documents[]" class="BSbtninfo"/>
                                                     </div>
                                                    <div class="col-sm-3 prog-onile">
                                                        <div class="progress progress-striped active">
                                                            <div class="progress-bar" style="width: 45%"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 document">
                                                    <div class="col-sm-3">
                                                        <label>RTO</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <input type="hidden" name="document_third" value="2"/>
                                                    <input type="file" name="dd_documents[]" class="BSbtninfo"/>
                                                    </div>
                                                    <div class="col-sm-3 prog-onile"><div class="progress progress-striped active">
                                                            <div class="progress-bar" style="width: 45%"></div>
                                                        </div></div>
                                                </div>
                                                <div class="col-sm-12 document">
                                                    <div class="col-sm-3">
                                                        <label>FC</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <input type="hidden" name="document_fourth" value="3"/>
                                                    <input type="file" name="dd_documents[]" class="BSbtninfo"/>
                                                    </div>
                                                    <div class="col-sm-3 prog-onile"><div class="progress progress-striped active">
                                                            <div class="progress-bar" style="width: 45%"></div>
                                                        </div></div>
                                                </div>
                                                <div class="col-sm-12 document">
                                                    <div class="col-sm-3">
                                                        <label>NOC</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <input type="hidden" name="document_fifth" value="4"/>
                                                    <input type="file" name="dd_documents[]" class="BSbtninfo"/>
                                                    </div>
                                                    <div class="col-sm-3 prog-onile"><div class="progress progress-striped active">
                                                            <div class="progress-bar" style="width: 45%"></div>
                                                        </div></div>
                                                </div>
                                                <div class="col-sm-12 document">
                                                    <div class="col-sm-3">
                                                        <label>Permit Document</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <input type="hidden" name="document_sixth" value="5"/>
                                                    <input type="file" name="dd_documents[]" class="BSbtninfo"/>
                                                    </div>
                                                    <div class="col-sm-3 prog-onile"><div class="progress progress-striped active">
                                                            <div class="progress-bar" style="width: 45%"></div>
                                                        </div></div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <!-- #collapseFour -->
                                                        <a href="" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseFour">
                                                        <input type="submit" class="btn btn-primary vehicle_document" value="Save changes">
                                                        </a>
                                                        <button class="btn btn-primary upload_skip_fourth">Skip</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div></div></div>

                                 <div class="panel panel-default fifthtab">

                                    @if(isset($purchase_details) && count($purchase_details) !== 0)
                                        <div class="panel-heading" role="tab" id="headingFour">
                                            <h4 class="panel-title">
                                                <a href="#collapseFour" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseFour">
                                                    Pricing Information<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                                </a>
                                            </h4>
                                        </div>
                                    @foreach($purchase_details as $val)
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                    
                                    <form id="pricing_information">
                                        <div class="panel-body row">
                                            <div class="col-xs-12">
                                                <div class="col-sm-4"><h4>Type of Inventory</h4></div>
                                                <div class="form-group col-sm-6">
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="park" class="inventory_type_park" value="PARKANDSELL" name="inventory_type" {{($val->inventory_type == "PARKANDSELL")?"checked":''}}>
                                                        <!-- <input type="hidden"  value="0" name="inventory_type"> -->
                                                        <label for="park"> Park and Sell </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" class="inventory_type_own" id="own" value="own" name="inventory_type" {{($val->inventory_type == "OWN")?"checked":''}}>
                                                        <label for="own"> Own </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch1" checked>
                                                    <label class="onoffswitch-label" for="myonoffswitch1">
                                                        <span class="onoffswitch-inner onoffswitch-inner1"></span>
                                                        <span class="onoffswitch-switch onoffswitch-switch1"></span>
                                                    </label>
                                                </div>
                                            </div>  
                                            <div class="hr-dashed1 col-xs-12"></div>
                                            <div class="col-xs-12">
                                                <div class="col-xs-6 own-div">
                                                    <h4 class="page-title1">Purchase Information</h4>
                                                    <div class="row">
                                                    <div class="col-sm-4"><label>Purchased From</label>
                                                    </div>
                                                        <div class="col-sm-8">
                                                        <div class="col-sm-7">
                                                        <select class="form-control purchased_from" name="purchased_from">
                                                        @foreach($selectdeleare as $key=>$value)
                                                            @if($key == "0")
                                                                <option value = "">{{$value}}</option>
                                                            @elseif($key == $val->purchased_from)
                                                                <option value = "{{$key}}" selected>{{$value}}</option>  
                                                            @else
                                                                <option value = "{{$key}}">{{$value}}</option>   
                                                            @endif
                                                        @endforeach                           
                                                        </select>
                                                        </div>
                                                            <div class="col-sm-5"><input type="text" class="form-control" name="received_from_name" value='{{($val->received_from_name == "")?"":$val->received_from_name}}'></div>
                                                        </div>
                                                    </div> 
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Purchase Price</label></div>
                                                        <div class="col-sm-8"><input type="text" name="purchased_price" class="form-control purchased_price" value='{{($val->purchase_amount == "")?"":$val->purchase_amount}}'></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Purchased Date</label></div>
                                                        <div class="col-sm-8"><div class='input-group date' id='datetimepicker4'>
                                                                <input type='text' name="purchase_date" class="form-control purchase_date_own" value='{{($val->purchase_date == "0000-00-00 00:00:00" || "")?"":$val->purchase_date}}' />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Keys Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyy" class="keys_available_own_yes" value="1" name="duplicate_keys" {{($val->duplicate_keys == "1")?"checked":''}}>
                                                                <label for="keyy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyn" value="0" class="keys_available_own_no" name="duplicate_keys" {{($val->duplicate_keys == "0")?"checked":''}}>
                                                                <label for="keyn">No</label>
                                                            </div></div></div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Document Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="docuy" class="documents_received_own_set" value="1" name="documents_received" {{($val->documents_received == "1")?"checked":''}}>
                                                                <label for="docuy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" class="documents_received_own_no_set" id="docun" value="0" name="documents_received" {{($val->documents_received == "0")?"checked":''}}>
                                                                <label for="docun">No</label>
                                                            </div></div></div>
                                                </div>  
                                                <div class="col-xs-6  park-div">
                                                    <h4 class="page-title1">Purchase Information</h4>
                                                    <div class="row"><div class="col-sm-4"><label>Received From </label></div>
                                                        <div class="col-sm-8"><div class="col-sm-7"><select class="form-control received_from" name="received_from_own">
                                                        @foreach($selectdeleare as $key=>$value)
                                                            @if($key == "0")
                                                            <option value = "">{{$value}}</option>
                                                            @elseif($key == $val->purchased_from_own)
                                                            <option value = "{{$key}}" selected>{{$value}}</option>
                                                            @else
                                                                <option value = "{{$key}}">{{$value}}</option>   
                                                            @endif
                                                        @endforeach
                                                                </select></div>
                                                            <div class="col-sm-5"><input type="text" class="form-control" name="received_from_name" value='{{($val->received_from_name == "")?"":$val->received_from_name}}'></div>
                                                        </div>
                                                    </div> 
                                                    <div class="hr-dashed"></div>

                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>From Date</label></div>
                                                        <div class="col-sm-8"><div class='input-group date' id='datetimepicker5'>
                                                                <input type='text' name="purchase_date" class="form-control purchase_date" value='{{($val->purchase_date == "0000-00-00 00:00:00" || "")?"":$val->purchase_date}}' />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 

                                                        <div class="col-sm-4"><label>Starting Km</label></div>
                                                        <div class="col-sm-8">
                                                            <input type='text' name="kms_done" class="form-control starting_kms"  value='{{($val->starting_kms == "")?"":$val->starting_kms}}'/>
                                                        </div>

                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Fuel Indication</label></div>
                                                        <div class="col-sm-8">
                                                            <input type='text' name="fuel_indicator" class="form-control fuel_indicator" value='{{($val->fuel_indicator == "")?"":$val->fuel_indicator}}'/>
                                                            <input type="hidden" name="fuel_capacity" >
                                                        </div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Customer Asking Price</label></div>
                                                        <div class="col-sm-8"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='number' name="customer_asking_price" class="form-control customer_asking_price" value='{{($val->customer_asking_price == "")?"":$val->customer_asking_price}}'/>
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Dealer Markup Price</label></div>
                                                        <div class="col-sm-8"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='text' name="dealer_price" value='{{($val->dealer_markup_price == "")?"":$val->dealer_markup_price}}' class="form-control  dealer_markup_price" />
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Keys Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyy" value="1" name="keys_available" class="keys_available_yes" {{($val->keys_available == "1")?"checked":''}}>
                                                                <label for="keyy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyn" class="keys_available_no" value="0" name="keys_available" {{($val->keys_available == "0")?"checked":''}}>
                                                                <label for="keyn">No</label>
                                                            </div></div></div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Document Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="docuy" value="mypart" name="documents_received" class="documents_received_first"  {{($val->documents_received == "mypart")?"checked":''}}>
                                                                <label for="docuy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="docun" class="documents_received_second" value="no" name="documents_received" {{($val->documents_received == "no")?"checked":''}}>
                                                                <label for="docun">No</label>
                                                            </div></div></div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <h4 class="page-title1">Expenses</h4>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Refurbishment Cost</label></div>
                                                        <div class="col-sm-6"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='text' name="expense_desc" class="form-control" value='{{($val->expense_desc == "")?"":$val->expense_desc}}'/>
                                                            </div></div></div>

                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Transport Cost</label></div>
                                                        <div class="col-sm-6"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='text' name="expense_amount" class="form-control" value='{{($val->expense_amount == "")?"":$val->expense_amount}}'/>
                                                            </div></div>
                                                    </div>

                                                    <div id="field1"><div class="hr-dashed"></div>
                                                        <div class="row expense_desc_div">
                                                        <div class="row filedlist">
                                                            <div class="col-sm-4"><label>Extra</label></div><input type="hidden" class="form-control expense_desc" name="" />
                                                            <div class="col-sm-6"><div class='input-group'>
                                                                    <span class="input-group-addon">
                                                                        Rs.
                                                                    </span>
                                                                    <input type="text" name="extra" class="form-control expense_amount" value=''/>
                                                                </div></div>
                                                            <div class="col-sm-2"><button class="btn add-more cloneAdd" type="button">+</button></div>
                                                            </div>
                                                        </div></div>
                                                </div>
                                            </div>
                                            <div class="hr-dashed1 col-xs-12"></div>
                                            <div class="col-xs-12">

                                                <div class="col-sm-6"><img class="img-responsive" src="{{url("img/meter.png")}}" alt=""/></div>
                                                <div class="col-sm-6">
                                                    <h4 class="page-title1">Markup Price</h4>
                                                    <div class="form-group">
                <div class="radio radio-primary radio-inline">
                <input type="radio" class="percentage_price percentage_show" id="park" value="option1" name="rate" {{($val->rate == "option1")?"checked":''}}>
                    <label for="park"> Percentage </label>  </div>
                <div class="radio radio-primary radio-inline ">
                <input type="radio" id="own" class="absolute_price absolute_show"  name="rate" value="option2" {{($val->rate == "option2")?"checked":''}}>
                    <label for="own"> Absolute </label> </div>
                </div>
                <div class="form-group  col-sm-6 percentage_cost">
                    <div class="input-group ">
                        <span class="input-group-addon">%</span>
                        <input type="text" class="form-control percentage" name="percentage" value='{{($val->markup_percent == "")?"":$val->markup_percent}}'>
                    </div>
                </div>
                    <div class="form-group  col-sm-6 rupees_cost">
                    <div class="input-group ">
                    <span class="input-group-addon">
                        Rs.
                    </span>
            <input type="text" class="form-control absolute_amount" name="markup_amount" value='{{($val->markup_amount == "")?"":$val->markup_amount}}'>
            </div>
            </div>
                    <div class="form-group"><label>Sale Price</label>
                    <input type="text" name="price" class="form-control" id="sale_price" value='{{($val->sold_price == "")?"":$val->sold_price}}'/></div>
                    <div class="form-group pull-right"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <input type="submit" name="priceinformation" class="btn btn-primary pricing_info_send" value="Save changes">
                    </a></div>
                </div>
            </div> </div>
            </form>
            </div>
                @endforeach
                @else
            <div class="panel-heading" role="tab" id="headingFour">
                <h4 class="panel-title">
                    <a href="#collapseFour" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseFour">
                        Pricing Information<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                    </a>
                </h4>
            </div>
                                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <form id="pricing_information">
                                        <div class="panel-body row">
                                            <div class="col-xs-12">
                                                <div class="col-sm-4"><h4>Type of Inventory</h4></div>
                                                <div class="form-group col-sm-6">
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="park" class="inventory_type_park" value="PARKANDSELL" name="inventory_type" checked="checked">
                                                        <!-- <input type="hidden"  value="0" name="inventory_type"> -->
                                                        <label for="park"> Park and Sell </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" class="inventory_type_own" id="own" value="OWN" name="inventory_type">
                                                        <label for="own"> Own </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch1" checked>
                                                    <label class="onoffswitch-label" for="myonoffswitch1">
                                                        <span class="onoffswitch-inner onoffswitch-inner1"></span>
                                                        <span class="onoffswitch-switch onoffswitch-switch1"></span>
                                                    </label></div>
                                            </div>  
                                            <div class="hr-dashed1 col-xs-12"></div>
                                            <div class="col-xs-12">
                                                <div class="col-xs-6 own-div">
                                                    <h4 class="page-title1">Purchase Information</h4>
                                                    <div class="row"><div class="col-sm-4"><label>Purchased From</label></div>
                                                        <div class="col-sm-8"><div class="col-sm-7"><select class="form-control purchased_from" name="purchased_from">
                                                        @foreach($selectdeleare as $key=>$value)
                                                                <option value = "">{{$value}}</option>
                                                        @endforeach
                                                                </select></div>
                                                            <div class="col-sm-5"><input type="text" class="form-control" name="received_from_name" value=""></div>
                                                        </div>
                                                    </div> 
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Purchase Price</label></div>
                                                        <div class="col-sm-8"><input type="text" name="purchased_price" class="form-control purchased_price" value=""></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Purchased Date</label></div>
                                                        <div class="col-sm-8"><div class='input-group date' id='datetimepicker4'>
                                                                <input type='text' name="purchase_date" class="form-control purchase_date_own" value="" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Keys Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyy" class="keys_available_own_yes" value="1" name="duplicate_keys" checked="checked">
                                                                <label for="keyy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyn" value="0" class="keys_available_own_no" name="duplicate_keys">
                                                                <label for="keyn">No</label>
                                                            </div></div></div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Document Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="docuy" class="documents_received_own_set" value="1" name="documents_received" checked="checked">
                                                                <label for="docuy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" class="documents_received_own_no_set" id="docun" value="0" name="documents_received">
                                                                <label for="docun">No</label>
                                                            </div></div></div>
                                                </div>  
                                                <div class="col-xs-6  park-div">
                                                    <h4 class="page-title1">Purchase Information</h4>
                                                    <div class="row"><div class="col-sm-4"><label>Received From </label></div>
                                                        <div class="col-sm-8"><div class="col-sm-7"><select class="form-control received_from" name="received_from_own">
                                                        @foreach($selectdeleare as $key=>$value)
                                                                <option value = "">{{$value}}</option>
                                                        @endforeach
                                                                </select></div>
                                                            <div class="col-sm-5"><input type="text" class="form-control" name="received_from_name" value=""></div>
                                                        </div>
                                                    </div> 
                                                    <div class="hr-dashed"></div>

                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>From Date</label></div>
                                                        <div class="col-sm-8"><div class='input-group date' id='datetimepicker5'>
                                                                <input type='text' name="purchase_date" class="form-control purchase_date" value="" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 

                                                        <div class="col-sm-4"><label>Starting Km</label></div>
                                                        <div class="col-sm-8">
                                                            <input type='text' name="kms_done" class="form-control starting_kms"  value=""/>
                                                        </div>

                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Fuel Indication</label></div>
                                                        <div class="col-sm-8">
                                                            <input type='text' name="fuel_indicator" class="form-control fuel_indicator" value=""/>
                                                            <input type="hidden" name="fuel_capacity" >
                                                        </div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Customer Asking Price</label></div>
                                                        <div class="col-sm-8"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='number' name="customer_asking_price" class="form-control customer_asking_price" value=""/>
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row"> 
                                                        <div class="col-sm-4"><label>Dealer Markup Price</label></div>
                                                        <div class="col-sm-8"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='number' name="dealer_price" value="" class="form-control dealer_mark_price" />
                                                            </div></div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Keys Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyy" value="1" name="keys_available" class="keys_available_yes" checked="checked">
                                                                <label for="keyy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="keyn" class="keys_available_no" value="0" name="keys_available">
                                                                <label for="keyn">No</label>
                                                            </div></div></div>
                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Document Received</label></div>
                                                        <div class="col-sm-8"><div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="docuy" value="mypart" name="documents_received" class="documents_received_first" checked="checked">
                                                                <label for="docuy"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="docun" class="documents_received_second" value="no" name="documents_received">
                                                                <label for="docun">No</label>
                                                            </div></div></div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <h4 class="page-title1">Expenses</h4>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Refurbishment Cost</label></div>
                                                        <div class="col-sm-6"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='number' name="expense_desc" class="form-control rembusmentcost" value=""/>
                                                            </div></div></div>

                                                    <div class="hr-dashed"></div>
                                                    <div class="row">
                                                        <div class="col-sm-4"><label>Transport Cost</label></div>
                                                        <div class="col-sm-6"><div class='input-group'>
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type='number' name="expense_amount" class="form-control transpostcost" value=""/>
                                                            </div></div>
                                                    </div>
                        <div class="priceextraadd">
                            <div id="field1"><div class="hr-dashed"></div>
                                <div class="row expense_desc_div">
                                    <div class="row filedlist">
                                        <div class="col-sm-4">
                                        <input type="text" class="form-control expense_desc" name="extra[]" />
                                        </div>
                                        <div class="col-sm-6"><div class='input-group'>
                                            <span class="input-group-addon">
                                                Rs.
                                            </span>
                                <input type="number" name="extrarupee[]" class="form-control expense_amount extrasfieldamount" value=""/>
                                        </div>
                                        </div>
                                    <div class="col-sm-2"><button class="btn btn-info addextras" type="button">+</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            </div>
                                            </div>
                                            <div class="hr-dashed1 col-xs-12"></div>
                                            <div class="col-xs-12">

                                                <div class="col-sm-6"><img class="img-responsive" src="{{url("img/meter.png")}}" alt=""/></div>
                                                <div class="col-sm-6">
                                                    <h4 class="page-title1">Markup Price</h4>
                                                    <div class="form-group">
                                                        <div class="radio radio-primary radio-inline">
                                                            <input type="radio" class="percentage_price percentage_show" id="per" value="option1" name="rate" checked>
                                                            <label for="per"> Percentage </label>  </div>
                                                          <div class="radio radio-primary radio-inline ">
                                                            <input type="radio" id="abs" class="absolute_price absolute_show"  name="rate" value="option2">
                                                            <label for="abs"> Absolute</label>
                                                            </div>
                                                        </div>
                                                    <div class="form-group  col-sm-6 percentage_cost">
                                                        <div class="input-group ">
                                                            <span class="input-group-addon">
                                                                %
                                                            </span>
                                                                <input type="text" class="form-control percentagevalue" id="percentagevalue" name="percentage" value="">
                                                            </div> </div>
                                                        <div class="form-group  col-sm-6 rupees_cost">
                                                        <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    Rs.
                                                                </span>
                                                                <input type="text" class="form-control absolute_amount percentagevalue" name="markup_amount" value="">
                                                            </div>
                                                            </div>
                                                    <div class="form-group col-sm-6"><label>Sale Price</label>
                                                    <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                    <input type="text" name="price" class="form-control finalsaleprice" id="sale_price" value=""/></div>
                                                    <div class="form-group pull-right"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                    <input type="submit" name="priceinformation" class="btn btn-primary pricing_info_send" value="Save changes">
                                                    </a></div>
                                                </div>
                                            </div> </div>
                                            </form>
                                            </div>
                                          @endif
                            </div>

                                <div class="panel panel-default sixthtab">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h4 class="panel-title">
                                       <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            Engine &amp; Specification <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                    <div class="panel-body">                                
                                        <div class="col-sm-3">
                                        <div class="form-group field-wrapper1">
                                                <label>Transmission</label>
                                                <select class="form-control transmission" name="transmission">
                                                    <option value="">Select Transmission</option>
                                                        @if(count($InventoryStatus) == 1)
                                                            @foreach($transmission as $value)
                                                                @if($value == $InventoryStatus[0]->transmission)
                                                                <option value="{{$InventoryStatus[0]->transmission}}" selected>{{$InventoryStatus[0]->transmission}}</option>
                                                                @else
                                                                <option value="{{$value}}">{{$value}}</option>  
                                                                @endif
                                                            @endforeach
                                                        @else
                                                    <option value="auto">auto</option>
                                                    <option value="manual">manual</option>
                                                    @endif
                                                </select>
                                            </div>      
                                        </div>      
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Engine Displacement</label>
                                                @if(count($InventoryStatus) == 1)
                                                    <input type="text" class="form-control engine_displacement" name="engine_displacement" placeholder="Engine Displacement" value='{{$InventoryStatus[0]->engine_displacement}}'>
                                                    @else
                                                <input type="text" class="form-control engine_displacement" name="engine_displacement" placeholder="Engine Displacement">
                                                @endif
                                            </div>     </div>   
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Vin</label>
                                                @if(count($InventoryStatus) == 1)
                                                        <input type="text" class="form-control vin" name="vin" placeholder="Vin" value='{{$InventoryStatus[0]->vin}}'>
                                                    @else
                                            <input type="text" class="form-control vin" name="vin" placeholder="Vin">
                                                @endif
                                            </div>     </div>   
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Seating Capacity</label>
                                                <select class="form-control seatingcapacity" name="seatingcapacity">
                                                    <option value="">Seating Capacity</option>
                                                        @if(count($InventoryStatus) == 1)
                                                            @foreach($capacity as $value)
                                                                @if($value == $InventoryStatus[0]->seatingcapacity)
                                                                <option value="{{$InventoryStatus[0]->seatingcapacity}}" selected>{{$InventoryStatus[0]->seatingcapacity}}</option>
                                                                @else
                                                                <option value="{{$value}}">{{$value}}</option>   
                                                                @endif
                                                            @endforeach
                                                        @else
                                                    <option value="1">8</option>
                                                    <option value="2">2</option>
                                                    <option value="3">9</option>
                                                    <option value="4">6</option>
                                                    <option value="5">4</option>
                                                    @endif
                                                </select>
                                            </div>    
                                         </div> 
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Peak Power</label>
                                                @if(count($InventoryStatus) == 1)
                                                <input type="text" name="peak_power" class="form-control peak_power" placeholder="Peak Power" value='{{$InventoryStatus[0]->peak_power}}'>
                                                @else
                                            <input type="text" name="peak_power" class="form-control peak_power" placeholder="Peak Power">
                                                @endif
                                            </div></div>  
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Peak Torque</label>
                                                @if(count($InventoryStatus) == 1)
                                                    <input type="text" name="peaktorque" class="form-control peaktorque" placeholder="Peak Torque" value='{{$InventoryStatus[0]->peaktorque}}'>
                                                @else
                                            <input type="text" name="peaktorque" class="form-control peaktorque" placeholder="Peak Torque">
                                                @endif
                                            </div></div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Steering Adjustment</label>
                                                @if(count($InventoryStatus) == 1)
                                                    <input type="text" name="steering_adjustment" class="form-control steering_adjustment" placeholder="Steering Adjustment" value='{{$InventoryStatus[0]->steering_adjustment}}'>
                                                    @else
                                                <input type="text" name="steering_adjustment" class="form-control steering_adjustment" placeholder="Steering Adjustment">
                                                @endif
                                            </div>     </div> 
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1" >
                                                <label>Air Conditioner</label>
                                                <select class="form-control air_conditioner" name="air_conditioner">
                                                    <option value="">Air Conditioner</option>
                                                        @if(count($InventoryStatus) == 1){
                                                            @foreach($airconditioner as $key=>$value)
                                                                @if($key == $InventoryStatus[0]->air_conditioner)
                                                                    <option value="{{$key}}" selected>{{$value}}</option>;
                                                                @endif
                                                                @if($key !== $InventoryStatus[0]->air_conditioner)
                                                                    <option value={{$key}}>{{$value}}</option>;
                                                                @endif
                                                            @endforeach
                                                        @else
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                        @endif
                                                </select>
                                            </div>     </div>   
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1" >
                                                <label>Central Locking</label>
                                                <select class="form-control central_locking" name="central_locking">
                                                    <option value="">Central Locking</option>
                                                        @if(count($InventoryStatus) == 1)
                                                            @foreach($centrallocking as $key=>$value)
                                                                @if($key == $InventoryStatus[0]->central_locking)
                                                                    <option value={{$key}} selected>{{$value}}</option>
                                                                @endif
                                                                @if($key !== $InventoryStatus[0]->central_locking)
                                                                    <option value="'.$key.'">{{$value}}</option>;
                                                                @endif
                                                            @endforeach
                                                        @else
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    @endif
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>CD Player</label>
                                                <select class="form-control cd_player" name="cd_player">
                                                    <option value="">CD Player</option>
                                                        @if(count($InventoryStatus) == 1){
                                                            @foreach($cdplayer as $key=>$value){
                                                                @if($key == $InventoryStatus[0]->cd_player){
                                                                    <option value="{{$key}}" selected>{{$value}}</option>;
                                                                @endif
                                                                @if($key !== $InventoryStatus[0]->cd_player)
                                                                    <option value={{$key}}>{{$value}}</option>;
                                                                @endif
                                                            @endforeach
                                                        @else
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    @endif
                                                </select>
                                            </div>     </div>  
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Power Steering</label>
                                                <select class="form-control power_steering" name="power_steering">
                                                    <option value="">Power Steering</option>
                                                        @if(count($InventoryStatus) == 1)
                                                            @foreach($powersteering as $key=>$value)
                                                                @if($key == $InventoryStatus[0]->power_steering && $InventoryStatus[0]->power_steering !== NULL){
                                                                    <option value="{{$key}}" selected>{{$value}}</option>;
                                                                @endif
                                                                @if($key !== $InventoryStatus[0]->power_steering)
                                                                    <option value="{{$key}}">{{$value}}</option>;
                                                                @endif
                                                            @endforeach
                                                        @else
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    @endif
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Power Windows</label>
                                                <select class="form-control power_windows" name="power_windows">
                                                    <option value="">Power Windows</option>
                                                        <?php
                                                        if(count($InventoryStatus) == 1){
                                                            $powerwindows  = array('Yes','No');
                                                            foreach($powerwindows as $key=>$value){
                                                                if($key == $InventoryStatus[0]->power_windows && $InventoryStatus[0]->power_windows !== NULL){
                                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                                }
                                                                if($key !== $InventoryStatus[0]->power_windows){
                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                }
                                                            }
                                                        }else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    <?php } ?>
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Steering Controls</label>
                                                <select class="form-control steering_mounted_controls" name="steering_mounted_controls">
                                                    <option value="">Steering Controls</option>
                                                    <?php
                                                        if(count($InventoryStatus) == 1){
                                                            $steeringmountedcontrols  = array('Yes','No');
                                                            foreach($steeringmountedcontrols as $key => $value){
                                                                if($key == $InventoryStatus[0]->steering_mounted_controls && $InventoryStatus[0]->steering_mounted_controls !== NULL){
                                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                                }
                                                                if($key !== $InventoryStatus[0]->steering_mounted_controls){
                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                }
                                                            }
                                                        }else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    <?php } ?>
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Rear AC Vent</label>
                                                <select class="form-control rear_ac_vent" name="rear_ac_vent">
                                                    <option value="">Rear AC Vent</option>
                                                    <?php
                                                        if(count($InventoryStatus) == 1){
                                                            $rearacvent  = array('Yes','No');
                                                            foreach($rearacvent as $key=>$value){
                                                                if($key == $InventoryStatus[0]->rear_ac_vent && $InventoryStatus[0]->rear_ac_vent !== NULL){
                                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                                }
                                                                if($key !== $InventoryStatus[0]->rear_ac_vent){
                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                }
                                                            }
                                                        }else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    <?php } ?>
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Rear Wiper</label>
                                                <select class="form-control rear_wiper" name="rear_wiper">
                                                    <option value="">Rear Wiper</option>
                                                    <?php
                                                        if(count($InventoryStatus) == 1){
                                                            $rearwiper = array('Yes','No');
                                                            foreach($rearwiper as $key=>$value){
                                                                if($key == $InventoryStatus[0]->rear_wiper && $InventoryStatus[0]->rear_wiper !== NULL){
                                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                                }
                                                                if($key !== $InventoryStatus[0]->rear_wiper){
                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                }
                                                            }
                                                        }else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    <?php } ?>
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Leather Seats</label>
                                                <select class="form-control leather_seats" name="leather_seats">
                                                    <option value="">Leather Seats</option>
                                                    <?php
                                                        if(count($InventoryStatus) == 1){
                                                            $leatherseats = array('Yes','No');
                                                            foreach($leatherseats as $key=>$value){
                                                                if($key == $InventoryStatus[0]->leather_seats && $InventoryStatus[0]->leather_seats !== NULL){
                                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                                }
                                                                if($key !== $InventoryStatus[0]->leather_seats){
                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                }
                                                            }
                                                        }else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    <?php } ?>
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Electrical mirror</label>
                                                <select class="form-control electrically_adjustable_mirrors" name="electrically_adjustable_mirrors">
                                                    <option value="">Electrical mirror</option>
                                                    <?php
                                                        if(count($InventoryStatus) == 1){
                                                            $electricallyadjustablemirrors = array('Yes','No');
                                                            foreach($electricallyadjustablemirrors as $key=>$value){
                                                                if($key == $InventoryStatus[0]->electrically_adjustable_mirrors && $InventoryStatus[0]->electrically_adjustable_mirrors !== NULL){
                                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                                }
                                                                if($key !== $InventoryStatus[0]->electrically_adjustable_mirrors && $InventoryStatus[0]->electrically_adjustable_mirrors !== NULL){
                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                }
                                                            }
                                                        }else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    <?php } ?>
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">  
                                            <div class="form-group field-wrapper1">
                                                <label>Air bag</label>
                                                <select class="form-control airbag" name="airbag">
                                                    <option value="">Air bag</option>
                                                    <?php
                                                        if(count($InventoryStatus) == 1){
                                                            $airbag = array('Yes','No');
                                                            foreach($airbag as $key=>$value){
                                                                if($key == $InventoryStatus[0]->airbag && $InventoryStatus[0]->airbag !== NULL){
                                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                                }
                                                                if($key !== $InventoryStatus[0]->airbag){
                                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                                }
                                                            }
                                                        }else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                    <?php } ?>
                                                </select>
                                            </div>     </div>
                                        <div class="col-sm-3">
                                        <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                            <div class="form-group pull-left"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix"><button value="6" class="btn btn-primary update_car_list" type="submit">Save changes</button></a> </div>       
                                            <div class="form-group pull-right"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix"><button class="btn btn-primary" type="submit">Skip</button></a></div></div>
                                    </div>
                                </div>
                            </div>
                        
                        <div class="panel panel-default seventhtab">
                            @if(isset($onlineportal) && count($onlineportal) !== 0)
                                <div class="panel-heading" role="tab" id="headingSix">
                                    <h4 class="panel-title">
                                        <a role="button" data-togglle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            Online Portals <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                @foreach($onlineportal as $val)
                                <form id="dealer_online_portal">
                                    <div class="panel-body">
                                        <div class="container"><h2 class="tab-title">Dealer Plus</h2>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="deal1" class="listing_dealer" value="listing" name="dealer_selection" {{($val->dealer_selection =="listing")?"checked":''}}>
                                                        <label for="deal1"> Listing </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="deal2" class="auction_dealer" value="auction" name="dealer_selection" {{($val->dealer_selection =="auction")?"checked":''}}>
                                                        <label for="deal2"> Auction </label>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 add-auction">
                                                    <div class="col-sm-3"><input type="text" name="auction_price" class="form-control auction_price" Placeholder="Min Price" value='{{($val->auction_price == "")?"":$val->auction_price}}'/></div>
                                                    <div class="col-sm-3"><div class='input-group date' id='datetimepicker6'>
                                                            <input type="text" name="auction_startdate"  value='{{($val->auction_startdate == "0000-00-00 00:00:00")?"":$val->auction_startdate}}' class="form-control" Placeholder="Startdate" />
                                                        
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>

                                        
                                                        </div></div>
                                                    <div class="col-sm-3">
                                                        <div class='input-group date' id='datetimepicker7'>
                                                            <input type="text" name="auction_end_date"  class="form-control" value='{{($val->auction_end_date == "0000-00-00 00:00:00")?"":$val->auction_end_date}}' Placeholder="End Date" />
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4"><div class="checkbox checkbox-primary">
                                                            <input id="Auction" class="onlinep" type="checkbox" value="auction_inviation" name="auctioninviation" {{($val->auctioninviation =="auction_inviation")?"checked":''}}>
                                                            <label for="Auction" class="onlinepcheck">
                                                                Send Invitation
                                                            </label>
                                                        </div></div>
                                                </div>

                                            </div>

                                        </div>
                                        
                                        <div class="container"><h2 class="tab-title">Listings</h2>
                                            <div class="col-sm-12">
                                                <div class="col-sm-3"><div class="checkbox checkbox-primary">
                                                        <input id="checkbox1" name="listing_olx" class="onlinep listing_olx" value="olx" type="checkbox" {{($val->listing_olx =="olx")?"checked":''}}>
                                                        <label for="checkbox1" class="onlinepcheck">
                                                            OLX
                                                        </label>
                                                    </div></div>
                                                <div class="col-sm-6 prog-onile"><div class="progress progress-striped active">
                                                        <div class="progress-bar" style="width: 45%"></div>
                                                    </div></div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-3"><div class="checkbox checkbox-primary">
                                                        <input id="checkbox2" name="listing_carwale" class="onlinep listing_carwale" value="car_wale" type="checkbox" {{($val->listing_carwale =="car_wale")?"checked":''}}>
                                                        <label for="checkbox2" class="onlinepcheck">
                                                            Car Wale
                                                        </label>
                                                    </div></div>
                                                <div class="col-sm-6 prog-onile"><div class="progress progress-striped active">
                                                        <div class="progress-bar" style="width: 25%"></div>
                                                    </div></div></div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-3"><div class="checkbox checkbox-primary">
                                                        <input id="checkbox3" name="listing_cardekho" class="onlinep listing_cardekho" type="checkbox" value="cardekho" {{($val->listing_cardekho =="cardekho")?"checked":''}}>
                                                        <label for="checkbox3" class="onlinepcheck">
                                                            Car Dekho
                                                        </label>
                                                    </div></div>
                                                <div class="col-sm-6 prog-onile"><div class="progress progress-striped active">
                                                        <div class="progress-bar" style="width: 75%"></div>
                                                    </div></div></div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-3"><div class="checkbox checkbox-primary">
                                                        <input id="checkbox4" type="checkbox" value="quickr" name="listing_quickr" class="onlinep listing_quickr" {{($val->listing_quickr =="quickr")?"checked":''}}>
                                                        <label for="checkbox4" class="onlinepcheck">
                                                            Quickr
                                                        </label>
                                                    </div></div>
                                                <div class="col-sm-6 prog-onile"><div class="progress progress-striped active">
                                                        <div class="progress-bar" style="width: 60%"></div>
                                                    </div></div></div>

                                        </div>
                                        <div class="container">
                                            <div class="col-sm-12">
                                            </div></div>
                                    <div class="col-sm-12 button-online">
                                    <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                    <input type="button" value="Cancel All Changes" class="btn btn-primary cancel_online_portal">
                                    <input type="submit" class="btn btn-primary postinventry" type="submit" name="post_invertry" value="Save Changes">
                                    </div>
                                    </div>
                                    </form>
                                </div>
                                @endforeach
                                @else
                                <div class="panel-heading" role="tab" id="headingSix">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            Online Portals<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                
                                <form id="dealer_online_portal">
                                    <div class="panel-body">
                                        <div class="container"><h2 class="tab-title">Dealer Plus</h2>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="deal1" class="listing_dealer" value="listing" name="dealer_selection" checked="">
                                                        <label for="deal1">Listing </label>
                                                    </div>
                                                    <div class="radio radio-primary radio-inline">
                                                        <input type="radio" id="deal2" class="auction_dealer" value="auction" name="dealer_selection">
                                                        <label for="deal2"> Auction </label>
                                                    </div>
                                                </div>

                            <div class="col-sm-12 add-auction">
                                <div class="col-sm-3">
                                <input type="text" name="auction_price" class="form-control auction_price" Placeholder="Min Price" />
                                </div>
                                <div class="col-sm-3">
                                    <div class='input-group date' id='datetimepicker6'>
                                        <input type="text" name="auction_startdate"  value="" class="form-control" Placeholder="Startdate" />
                                    
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class='input-group date' id='datetimepicker7'>
                                        <input type="text" name="auction_end_date"  class="form-control" Placeholder="End Date" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4"><div class="checkbox checkbox-primary">
                                        <input id="Auction" class="onlinep" type="checkbox" value="auction_inviation" name="auctioninviation">
                                        <label for="Auction" class="onlinepcheck">
                                            Send Invitation
                                        </label>
                                    </div></div>
                            </div>
                        </div>
                    </div>
                                        
                    <div class="container listingmain">
                    <h2 class="tab-title">Listings</h2>
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox1" name="listing_olx" class="onlinep listing_olx" value="olx" type="checkbox">
                                <label for="checkbox1" class="onlinepcheck">
                                OLX
                                </label>
                                </div>
                            </div>
                            <div class="col-sm-6 prog-onile">
                                <div class="progress progress-striped active">
                                    <div class="progress-bar" style="width: 45%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox2" name="listing_carwale" class="onlinep listing_carwale" value="car_wale" type="checkbox">
                                    <label for="checkbox2" class="onlinepcheck">
                                        Car Wale
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6 prog-onile"><div class="progress progress-striped active">
                                    <div class="progress-bar" style="width: 25%"></div>
                                </div></div></div>
                        <div class="col-sm-12">
                            <div class="col-sm-3"><div class="checkbox checkbox-primary">
                                    <input id="checkbox3" name="listing_cardekho" class="onlinep listing_cardekho" type="checkbox" value="cardekho">
                                    <label for="checkbox3" class="onlinepcheck">
                                        Car Dekho
                                    </label>
                                </div></div>
                            <div class="col-sm-6 prog-onile"><div class="progress progress-striped active">
                                    <div class="progress-bar" style="width: 75%"></div>
                                </div></div></div>
                        <div class="col-sm-12">
                            <div class="col-sm-3"><div class="checkbox checkbox-primary">
                                    <input id="checkbox4" type="checkbox" value="quickr" name="listing_quickr" class="onlinep listing_quickr">
                                    <label for="checkbox4" class="onlinepcheck">
                                        Quickr
                                    </label>
                                </div></div>
                            <div class="col-sm-6 prog-onile"><div class="progress progress-striped active">
                                    <div class="progress-bar" style="width: 60%"></div>
                                </div></div></div>
                    </div>
                                    <div class="col-sm-12 button-online">
                                    <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                       <input type="submit" class="btn btn-primary postinventry" type="submit" name="post_invertry" value="Save">
                                       <input type="button" class="btn btn-primary save_and_post"  value="Save &amp; Post">
                                        <input type="button" class="btn btn-primary cancel_online_portal"  value="Cancel">
                                        <!--mongo-->
                                    </div>
                                    </div>
                                    </form>
                                </div>
                                @endif
                                </div>
                                </div>
                                </div>
                    </div></div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row dash-footer">
                <div class="clearfix pt pb">
                    <div class="col-md-12">
                        <em>Designed by <a href="#">Falconnect</a></em>
                    </div>
                </div>
            </div></div>
        <!-- Loading Scripts -->

        <!--popup-->
       

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remove Inventry Details</h4>
              </div>
              <div class="modal-body">
              <p>Do You want remove all details ?</p>
              <div class="row">
              <div class="col-md-6">
                <input type="submit" id="cancel_online_portal" value="yes" class="btn btn-primary">
                </div>
                <div class="col-md-6">
                <button class="btn btn-primary" data-dismiss="modal">cancel</button>
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        <!--popup-->

        <script src="{{URL::asset('js/chartData.js')}}"></script>
        <!-- <script src="{{URL::asset('js/main.js')}}"></script> -->
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script type="text/javascript">
            
            $("body").on('click','.inventory_type_own',function()
            {
                if($('.inventory_type_own').prop('checked'))
                {
                    $(".own-dev").css("display","block");
                    $(".park-dev").css("display","none");
                    $('.dealer_mark_price').val('');
                    $('.rembusmentcost').val('');
                    $('.transpostcost').val('');
                    $('.extrasfieldamount').val('');
                    $('.absolute_amount').val('');
                    $('.percentagevalue').val('');
                    $('.finalsaleprice').val('');
                    $('.purchased_price').val('');
                    
                    //$(this).closest('form').find("input[type=text], textarea").val("");
                    
                }
                else
                {
                    $(".park-dev").css("display","none");
                    $(".own-dev").css("display","block");
                    $('.dealer_mark_price').val('');
                    $('.rembusmentcost').val('');
                    $('.transpostcost').val('');
                    $('.extrasfieldamount').val('');
                    $('.absolute_amount').val('');
                    $('.percentagevalue').val('');
                    $('.finalsaleprice').val('');
                    $('.purchased_price').val('');
                    //$(this).closest('form').find("input[type=text], textarea").val("");
                }
            });

            $(document).on('click','.inventory_type_park',function()
            {
                if($('.inventory_type_park').prop('checked'))
                {
                    $(".own-dev").css("display","none");
                    $(".park-dev").css("display","block");
                    //$(this).closest('form').find("input[type=text], textarea").val("");
                    $('.dealer_mark_price').val('');
                    $('.rembusmentcost').val('');
                    $('.transpostcost').val('');
                    $('.extrasfieldamount').val('');
                    $('.absolute_amount').val('');
                    $('.percentagevalue').val('');
                    $('.finalsaleprice').val('');
                    $('.purchased_price').val('');
                }
                else
                {
                    $(".park-dev").css("display","block");
                    $(".own-dev").css("display","none");
                    // $(this).closest('form').find("input[type=text], textarea").val("");
                    $('.dealer_mark_price').val('');
                    $('.rembusmentcost').val('');
                    $('.transpostcost').val('');
                    $('.extrasfieldamount').val('');
                    $('.absolute_amount').val('');
                    $('.percentagevalue').val('');
                    $('.finalsaleprice').val('');
                    $('.purchased_price').val('');
                }
            });
            $(document).on('blur','.percentagevalue',function(){
                if($('.percentagevalue').val() > 100){
                    alert('Just Enter In a Range of 1 to 100');
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
                if(price == ''){
                    price = $('.dealer_mark_price').val('0');    
                }
                else if(remb_cost == ''){
                    remb_cost = $('.rembusmentcost').val('0');
                }
                else if(trans_cost == ''){
                    trans_cost = $('.transpostcost').val('0');
                }
                else if(extra_cost == ''){
                    extra_cost = $('.extrasfieldamount').val('0');
                }
                var extra_field_sum = 0;
                $('.extrasfieldamount').each(function(){
                    extra_field_sum += parseFloat($(this).val());
                });
                if($('.inventory_type_own').prop('checked')){
                    if($('.percentage_show').prop('checked')){
                        var result = (parseInt(purchased_price)+(parseInt(purchased_price)+parseInt(remb_cost)+parseInt(trans_cost)+parseInt(extra_field_sum)))*(parseFloat(percent_value)/100);
                    }
                    if($('.absolute_show').prop('checked')){
                        var result = parseInt(purchased_price)+parseInt(remb_cost)+parseInt(trans_cost)+parseInt(extra_field_sum)+parseInt(absolute_amount);
                    }
                }
                if($('.inventory_type_park').prop('checked')){
                    if($('.percentage_show').prop('checked')){
                     var result = (parseInt(price)+(parseInt(price)+parseInt(remb_cost)+parseInt(trans_cost)+parseInt(extra_field_sum)))*(parseFloat(percent_value)/100);
                    }
                    if($('.absolute_show').prop('checked')){
                        var result = parseInt(price)+parseInt(remb_cost)+parseInt(trans_cost)+parseInt(extra_field_sum)+parseInt(absolute_amount);
                    }

                }
                $('.finalsaleprice').val(result);
            });                
        
            $('.upload_skip_second').click(function(){
                $('.thirdtab div h4 a').trigger('click');
                return false;    
            });
            $('.upload_skip_third').click(function(){
                $('.fourthtab div h4 a').trigger('click');
                return false;    
            });
            $('.upload_skip_fourth').click(function(){
                $('.fifthtab div h4 a').trigger('click');
                return false;    
            });
        $(document).ready(function(){
            $('[name="vehicle_type"]').change(function(){
                var businesstype_id=$(this).val();
                var csrf_token=$('#token').val();
                $('[name="make"]').empty();
                $.ajax({
                    url:"{{url('fetch_make')}}",
                    type:'post',
                    data:{_token:csrf_token,businesstype_id:businesstype_id},
                    success:function(response)
                    {
                        var json = $.parseJSON(response);

                        $.each(json, function(arrayID,group) {
                                   
                            $('[name="make"]').append($('<option>', {value:group.make_id, text:group.makename}));
                        });
                    },
                    error:function(e)
                    {
                        console.log(e.responseText);
                    }
                });
            });

            $('[name="make"]').change(function(){
                var make=$(this).val(); 
                var csrf_token=$('#token').val();
                $('[name="model"]').empty();
                $.ajax({
                    url:"{{url('fetch_model_car')}}",
                    type:'post',
                    data:{_token:csrf_token,make:make},
                    success:function(response)
                    {
                        var json = $.parseJSON(response);
                        $('[name="model"]').append($('<option>', {value:'', text:'Select Model'}));
                        $.each(json, function(arrayID,group) {
                                   
                            $('[name="model"]').append($('<option>', {value:group.model_id, text:group.model_name}));
                        });
                    },
                    error:function(e)
                    {
                        console.log(e.responseText);
                    }
                });
            });

            $('[name="model"]').change(function(){
                var variant=$(this).val();
                var csrf_token=$('#token').val();
                $('[name="variant"]').empty();
                    $.ajax({
                        url:"{{url('fetch_variant')}}",
                        type:'post',
                        data:{_token:csrf_token,variant:variant},
                        success:function(response)
                        {
                            /*alert(response);*/
                            var json = $.parseJSON(response);
                        $('[name="variant"]').append($('<option>', {value:'', text:'Select Variant'}));
                        $.each(json, function(arrayID,group) {
                                   
                            $('[name="variant"]').append($('<option>', {value:group.variant_id, text:group.variant_name}));
                        });
                    },
                    error:function(e)
                    {
                        console.log(e.responseText);
                    }
                });
            });

            $('.basic_info').click(function(){ 
            $("#loadspinner").css("display", "block");               
                var registration_year = $('.registration_year').val();
                var category_id = $('.category_id').val();
                var make = $('.make').val();
                var model = $('.model').val();
                var variant = $('.variant').val();
                var kms_done = $('.kms_done').val();
                var mileage = $('.mileage').val();
                var owner_type = $('.owner_type').val();
                var status = $('.status').val();
                var colors = $('.colors').val();
                var place = $('.place').val();
                var fuel_type = $('.fuel_type').val();
                var basic_info = $('.basic_info').val();
                var dplistid = $('.dplistid').val();
                $.ajax({
                    url:"{{url('basic_info')}}",
                    type:'POST',
                    data:{registration_year:registration_year,category_id:category_id,make:make,model:model,variant:variant,kms_done:kms_done,mileage:mileage,owner_type:owner_type,status:status,colors:colors,place:place,fuel_type:fuel_type,basic_info:basic_info,dplistid:dplistid},
                        success:function(data)
                        {   
                            $('.secondtab div h4 a').trigger('click');
                            $("#loadspinner").css("display", "none");
                            $('.basictab h4 a').addClass('collapsed');                   
                        },
                        error:function(){
                            $('.firsttab div h4 a').trigger('click');
                            $("#loadspinner").css("display", "none");
                            $('.basictab h4 a').addClass('collapsed');      
                            //$(".basicinfohide").hide();
                        }
                });
            });            
            
            //$('.rupees_cost').css('display','none');
            //$('.rupees_cost div input').val('');
            $("body").ready(function()
            {
                $('.absolute_price').on('click', function(e) {
                    $('.percentage_show').attr('checked', false);
                    $(".percentage_cost").css("display","none");
                    $(".rupees_cost").css("display","block");
                    $(".percentage_cost div input").val('');
                    $('.finalsaleprice').val('');
                    $('.percentagevalue').val('');
                });

                $('.percentage_show').on('click', function(e) {
                    $(".percentage_cost").css("display","block");
                    $(".rupees_cost").css("display","none");
                    $(".rupees_cost div input").val('');
                    $('.finalsaleprice').val('');
                    $('.percentagevalue').val('');
                });

                if($('.absolute_price').prop('chceked')){
                    $('.percentage_show').attr('checked', false);
                    $(".percentage_cost").css("display","none");
                    $(".rupees_cost").css("display","block");
                    $(".percentage_cost div input").val('');
                    $('.finalsaleprice').val('');
                    $('.percentagevalue').val('');
                }

                if($('.percentage_show').prop('checked'))
                {
                    $(".percentage_cost").css("display","block");
                    $(".rupees_cost").css("display","none");
                    $(".rupees_cost div input").val('');
                    $('.finalsaleprice').val('');
                    $('.percentagevalue').val('');
                }
            }); 

            $('.pricing_info_send').click(function(){
                $("#loadspinner").css("display", "block"); 
                var datas = $("#pricing_information").serialize();
                $.ajax({
                    url:"{{url('purchase_info')}}",
                    type:"post",
                    data : datas,
                    success:function()
                    {
                        $('.sixthtab div h4 a').trigger('click');
                        $("#loadspinner").css("display", "none"); 
                    },
                    error:function(){
                        $('.fifthtab div h4 a').trigger('click');
                        $("#loadspinner").css("display", "none");
                    }
                });
                });
            $("body").ready(function()
            {
                if($('.listing_dealer').prop('checked'))
                {
                    $(".add-auction").css("display","none");
                }
                else
                {
                    $(".add-auction").css("display","block");
                }
            });

            $('.online_portal').click(function(){
                if($('.listing_dealer').prop('checked'))
                {
                    var listing_type = $('.listing_dealer').val();
                    var list_olx = $('.listing_olx').val();
                    var list_car_wale = $('.listing_carwale').val();
                    var list_car_dekho = $('.listing_cardekho').val();
                    var list_quickr = $('.listing_quickr').val();
                    /*console.log(list_olx,list_quickr,list_car_dekho,list_car_wale);
                    return false;*/
                    if($('.chola_e_auction').prop('checked'))
                    {
                        var auction_type = $('.chola_e_auction').val();                    
                    }
                    else if($('.edigg').prop('checked'))
                    {
                        var auction_type = $('.edigg').val();                    
                    } 
                    var min_price = $('.min_price').val();
                    var start_date = $('.start_date').val();
                    var end_date = $('.end_date').val();
                    $.ajax({
                    url:"{{url('online_portal')}}",
                    type:'POST',
                    data:{listing_type:listing_type,list_olx:list_olx,list_car_wale:list_car_wale,list_car_dekho:list_car_dekho,list_quickr:list_quickr,auction_type:auction_type,min_price:min_price,start_date:start_date,end_date:end_date},
                    success:function(response)
                    {    
                        //alert('i am successfully inserted');
                        window.location.replace("managelisting");
                    }
                    });
                }
                else if($('.auction_dealer').prop('checked'))
                {
                    var listing_type = $('.auction_dealer').val();
                    var list_olx = $('.listing_olx').val();
                    var list_car_wale = $('.listing_carwale').val();
                    var list_car_dekho = $('.listing_cardekho').val();
                    var list_quickr = $('.listing_quickr').val();
                    var auction_price = $('.auction_price').val();
                    var auction_startdate = $('.auction_startdate').val();
                    var auction_end = $('.auction_end').val();
                    if($('.chola_e_auction').prop('checked'))
                    {
                        var auction_type = $('.chola_e_auction').val();                    
                    }
                    else if($('.edigg').prop('checked'))
                    {
                        var auction_type = $('.edigg').val();                    
                    } 
                    var min_price = $('.min_price').val();
                    var start_date = $('.start_date').val();
                    var end_date = $('.end_date').val();

                    $.ajax({
                        url:"{{url('auction_portal')}}",
                        type:'post',
                        data:{listing_type:listing_type,list_olx:list_olx,list_car_wale:list_car_wale,list_car_dekho:list_car_dekho,list_quickr:list_quickr,auction_type:auction_type,min_price:min_price,start_date:start_date,end_date:end_date,auction_price:auction_price,auction_startdate:auction_startdate,auction_end:auction_end},
                        success:function(response)
                        {
                            /*window.location.href = "friends";*/
                        }
                    });
                }
            });
        });
        
    </script>
        <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
        <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
        <!-- <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script> -->
        <!-- <script src="{{URL::asset('js/Chart.min.js')}}"></script> -->
        <!--<script src="{{URL::asset('js/fileinput.js')}}"></script>-->
        <!-- <script src="{{URL::asset('js/main.js')}}"></script> -->
        <!--<script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script>-->
        <script src="{{URL::asset('js/custom-file-input.js')}}" type="text/javascript"></script>
         <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
         <script src="{{URL::asset('js/dealerplus.js')}}"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
        <script src="{{URL::asset('js/jquery.knob.js')}}"></script>
        <!-- jQuery File Upload Dependencies -->
        <script src="{{URL::asset('js/jquery.ui.widget.js')}}"></script>
        <script src="{{URL::asset('js/jquery.iframe-transport.js')}}"></script>
        <!--<script src="{{URL::asset('js/jquery.fileupload.js')}}"></script>-->
        <!-- Our main JS file -->
        <script src="{{URL::asset('js/script.js')}}"></script>
        <!-- <script src="{{URL::asset('js/addelement.js')}}"></script> -->
        <!-- <script type="text/javascript">
        $(document).ready(function(){
                $('.date').datetimepicker();
        });
        </script> -->

        <script>
            $(document).ready(function () {
                 $(".own-div").hide();
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

        </script>
        <script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
        
        <script src="{{URL::asset('js/image_script.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $(".onlinep").click(function () {
                    $(this).parent().parent().parent().children(".prog-onile").children(".progress").toggle(this.checked);
                });
            $(".BSbtninfo").click(function () {
                $(this).parent().parent().children(".prog-onile").children(".progress").show(2000);
            });
            });
        </script>
        <script>
            $('.update_car_list').click(function(){
                $("#loadspinner").css("display", "block");
                var transmission = $('.transmission').val();
                var update_car_list = $('.update_car_list').val();
                var engine_displacement = $('.engine_displacement').val();
                var vin = $('.vin').val();
                var seatingcapacity = $('.seatingcapacity').val();
                var peak_power = $('.peak_power').val();
                var peaktorque = $('.peaktorque').val();
                var steering_adjustment = $('.steering_adjustment').val();
                var body_type = $('.body_type').val();
                var air_conditioner = $('.air_conditioner').val();
                var central_locking = $('.central_locking').val();
                var cd_player = $('.cd_player').val();
                var power_steering = $('.power_steering').val();
                var power_windows = $('.power_windows').val();
                var steering_mounted_controls = $('.steering_mounted_controls').val();
                var rear_ac_vent = $('.rear_ac_vent').val();
                var rear_wiper = $('.rear_wiper').val();
                var leather_seats = $('.leather_seats').val();
                var electrically_adjustable_mirrors = $('.electrically_adjustable_mirrors').val();
                var airbag = $('.airbag').val();
                var dplistid = $('.dplistid').val();                    
                $.ajax({
                    url:"{{url('update_car_list')}}",
                    type:'POST',
                    data:{transmission:transmission,engine_displacement:engine_displacement,vin:vin,seatingcapacity:seatingcapacity,peak_power:peak_power,peaktorque:peaktorque,steering_adjustment:steering_adjustment,body_type:body_type,air_conditioner:air_conditioner,central_locking:central_locking,cd_player:cd_player,power_steering:power_steering,power_windows:power_windows,steering_mounted_controls:steering_mounted_controls,rear_ac_vent:rear_ac_vent,rear_wiper:rear_wiper,leather_seats:leather_seats,electrically_adjustable_mirrors:electrically_adjustable_mirrors,airbag:airbag,update_car_list:update_car_list,dplistid:dplistid
                    },
                    success:function(response)
                    {
                        $('.seventhtab div h4 a').trigger('click');
                        $("#loadspinner").css("display", "none");
                    },
                    error:function()
                    {
                        $('.sixthtab div h4 a').trigger('click');
                        $("#loadspinner").css("display", "none");
                    }
                });
            });
        </script>
        <script>
        $("body").on("click",".vehicle_document",function(){ 
            $("#loadspinner").css("display", "block");
            var serialized =  new FormData($('#dealer_form')[0]);
                $.ajax({
                    url:"{{url('dealer_docs')}}",
                    type: 'POST',
                    enctype: 'multipart/form-data',  
                    dataType:'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data : serialized, 
                    success: function(){
                            $('.fourthtab div h4 a').trigger('click');
                            $('#collapseThree').hide();
                            $("#loadspinner").css("display", "none");
                    },
                    error:function(){
                        $('.fifthtab div h4 a').trigger('click');
                        $('#collapseThree').hide();
                        $("#loadspinner").css("display", "none");
                    }
                 });
        });
        </script>
        <script>
        $("body").on("click",".vehicle_video",function(){ 
            $("#loadspinner").css("display", "block");
            var serialized =  new FormData($('#dealer_form_video')[0]);
                $.ajax({
                    url:"{{url('video_upload')}}",
                    type: 'POST',
                    enctype: 'multipart/form-data',  
                    dataType:'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data : serialized, 
                    success: function(response){
                        if(response.status == "success")
                        {
                            $('.fourthtab div h4 a').trigger('click');
                            $("#loadspinner").css("display", "none"); 
                            $("#videosname").val('');   
                            $('.commontab').css('display','none');
                        }
                        else{
                            $('.thirdtab div h4 a').trigger('click');
                            $('.commontab').css('display','block');
                            $('.commontab').text('Invalid File Format. Kindly upload MP4 format.');
                            $('.thirdtab h4 a').addClass('collapsed');
                            $("#loadspinner").css("display", "none"); 
                            $("#videosname").val('');
                        }
                    },
                    error : function(response){
                            $('.thirdtab div h4 a').trigger('click');
                            $('.commontab').css('display','block');
                            $('.commontab').text('kindly upload videos again..');
                            $("#loadspinner").css("display", "none"); 
                            $("#videosname").val('');   
                    }
                 });
        });
        </script>
        <script>
        function previewImages() {

            var preview = document.querySelector('#preview');

                if (this.files) {
                [].forEach.call(this.files, readAndPreview);
                }

            function readAndPreview(file) {

                // Make sure `file.name` matches our extensions criteria
                if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                  var invalid = "This "+file.name+" is not an image";
                  $(".imageerror").text(invalid);
                  //$("#fileupload").val(0);
                  $("#fileupload").val("");
                  return false;
                } // else...
                else
                {
                    $(".imageerror").text('');
                }

                var reader = new FileReader();
                var divclass = "<div class='remove'>";
                reader.addEventListener("load", function() {
                var div = '<div class="appdiv"><img src="' + this.result + '" class="thumb" name="' + file.name + '" height=100 /><a href="javascript:void(0);"class="remove_icon" >X</a><input type="hidden" class="postImg" name="post_image[]" value="' + file.name +'"></div>';
                image_values_all = file;    
                  $('#preview').append(div);
                  
                }, false);

                reader.readAsDataURL(file);

            }
        }
        document.querySelector('#fileupload').addEventListener("change", previewImages, false);

        $("body").on("click",".remove_icon",function()
        {
            $(this).parent().remove();
        });
         $("#upload_images").click(function(e){
            e.preventDefault(e); 
            $("#loadspinner").css("display", "block");
            var file_data = $('#fileupload').prop('files')[0];
            var dplistid  = $('.dplistid').val();
            var form_data = new FormData();
            form_data.append('inventry_image',file_data);
            form_data.append('dplistid',dplistid);
            $.ajax({
                    url:"{{url('image_upload')}}", 
                    cache       : false,
                    contentType : false,
                    processData : false,
                    data        : form_data, 
                    allowedTypes: "jpg,png,gif,jpeg",                    
                    multiple    : true,                        
                    type        : 'post',
                    success: function(response){
                            var data = $.parseJSON(response);
                            if(data.success == 'success'){
                                $('.thirdtab div h4 a').trigger('click');
                                $('.secondtab div h4 a').addClass('collapsed');
                                $("#loadspinner").css("display", "none");
                                $("#preview").css("display", "none");
                                $("#fileupload").val("");
                                $('.commontab').css('display','none');
                            }
                            else{
                                $('.secondtab div h4 a').trigger('click');
                                $('.commontab').css('display','block');
                                $('.commontab').text('kindly upload correct images format..');    
                                $('.secondtab div div').addClass('in');
                                $("#loadspinner").css("display", "none");
                                $("#preview").css("display", "none");
                                $("#fileupload").val("");
                            }
                    },
                    error: function(){
                        $('.secondtab div h4 a').trigger('click');
                        $('.commontab').css('display','block');
                        $('.commontab').text('kindly upload correct images again..');    
                        $('.secondtab div h4 a').trigger('click');
                        $("#loadspinner").css("display", "none");
                        $("#preview").css("display", "none");
                        $("#fileupload").val("");
                    }
                });
        });

        $('.removeimage').click(function(e){        
            var con = confirm("Do you want to delete this image?");
            if (con == true) {
            e.preventDefault(); 
            $("#loadspinner").css("display", "block");
            var imageid = $(this).attr("data-imageid");      
            var imagedup = $(this).attr("data-id");
            var imagename = $(this).attr("data-imagename");    
            var action = "delete";
            $(this).remove();
            $.ajax({
                url:"{{url('image_upload')}}",
                type : 'POST',
                dataType:'json',
                data : { imageid:imageid,actionname:action,dublicate_id:imagedup,imagename:imagename}, 
                success : function(res)
                {
                    if(res.success == "success")
                    {   
                        $("#loadspinner").css("display", "none");
                    }
                }
            });

            } else {
                return false;
            }
    });
    </script>
    <script>
    //exit from add inventory screen
        $('.inventoryexit').click(function(e){
                var datas = $("#exitinevntory").serialize();                
                $.ajax({
                    url:"{{url('inventoryexit')}}",
                    type:"post",
                    data : datas,
                    success:function()
                    {

                     //   window.location.href = "{{url('managelisting')}}";
                    }
                });
            });

        $('.postinventry').click(function(e){
            $("#loadspinner").css("display", "block");
                e.preventDefault();
                var datas = $("#dealer_online_portal").serialize();
                $.ajax({
                    url:"{{url('online_portal')}}",
                    type:"post",
                    data : datas,
                    success:function()
                    {
                        window.location.href = "{{url('managelisting')}}";
                    },
                    error : function(){
                        $("#loadspinner").css("display", "none");  
                    }

                });
            });
        $("body").on("click",".cancel_online_portal",function(){
        var con = confirm("Do you want to cancel all details?");
        var action = "delete";
        if (con == true) {
            $("#loadspinner").css("display", "block");
        $.ajax({
            url:"{{url('remove_all_details')}}",
            type : 'POST',
            dataType:'json',
            data : { actionname:action}, 
            success : function(res)
            {
                if(res.status == "success")
                {
                    $("#loadspinner").css("display", "none");
                    $('.commontab').css('display','none');
                }
                if(res.status == "error")
                {
                    $('.commontab').css('display','block');
                    $('.commontab').text('No records found...');
                    $("#loadspinner").css("display", "none");
                }
            }
        });

        } else {
            return false;
        }
    });
    </script>
    <script>
    $(document).ready(function(){
        $('.popupmodal').trigger('click');
    }); 
    </script>
    <script>
    /*window.location.hash="Back";
    window.location.hash="";
    window.onhashchange=function(){window.location.hash="Back";}*/
    </script>
    <script id="myclose">
    $(document).ready(function() {  
        $("body").css("z-index", "0");
        $('.ts-sidebar').click(function() {          
            var session = '<?php echo Session::get("dplid");?>';      
             $('#confirmexit').modal({
                show: 'true'
            }); 
            self.focus();
            return false;                
        });
        $('.brand').click(function(){
            $('#confirmexit').modal({
                show: 'true'
            });
            self.focus();
            return false;
        });

        $('.dash-footer').click(function(){
            $('#confirmexit').modal({
                show: 'true'
            });
            self.focus();
            return false;
        });
    });
    /*$(window).bind("beforeunload", function() { 
    return confirm("Do you really want to close?"); 
    });*/
    </script>
    <script>
      $(document).on('click','.addextras',function(){
            $('.priceextraadd').append('<div id="field1"><div class="hr-dashed"></div><div class="row expense_desc_div"><div class="row filedlist"><div class="col-sm-4"><input type="text" class="form-control expense_desc" name="extra[]" /></div><div class="col-sm-6"><div class="input-group"><span class="input-group-addon">Rs.</span><input type="number" name="extrarupee[]" class="form-control expense_amount extrasfieldamount" value=""/></div></div><div class="col-sm-2"><button class="btn btn-danger closerow" type="button">X</button></div></div></div></div></div>');
            $('.finalsaleprice').val('');
            $('.percentagevalue').val('');  
      });

      $(document).on('click','.closerow',function(){
            $(this).closest('div #field1').remove();
            $('.finalsaleprice').val('');
            $('.percentagevalue').val('');
            return false;
      });
    </script>
    </body>
</html>

