<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>DealerPlus-managelisting</title>

        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <!-- Bootstrap file input -->
        <link rel="stylesheet" href="css/fileinput.min.css">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <!-- Admin Stye -->
        <link rel="stylesheet" href="css/style.css">

        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
        </style>
    </head>
    <body>
        <div id="loadspinner" class="spinner_manage" style="display:none">
            <img id="img-spinner" src="{{url('ajax-loader.gif')}}" alt="Loading"/>
        </div>        
        @include('header')
        <form method="post" id="view_car_managelist" action="{{url('view')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="car_view_id" name="car_view_id">
        </form>
        <form method="get" id="view_managelisting" action="{{url('managelisting')}}">
            <input type="hidden" id="sort_change_id" val="0" name="car_view_id">
        </form>
        <form method="post" id="car_post" action="{{url('my_inventory_mongo')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="car_push_mongo" name="car_push_mongo">
        </form>

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
                                        <!--<ul class="dropdown-menu">
                                          <li><a href="#">2nd level dropdown</a></li>
                                          <li><a href="#">2nd level dropdown</a></li>
                                          </ul>-->
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
            <div class="content-wrapper">
                <div class="container-fluid footer-fixed">

                    <div class="row">
                        <div class="content-header col-sm-12">
                            <div class="input-group mb searching col-sm-6 hidden-md hidden-lg">
                                <div class="input-group-btn search-panel">
                                    <select class="btn btn-primary">
                                        <option value="">Filter</option>
                                        <option value="1">Inventory</option>
                                        <option value="2">Customer</option>
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
                                <li><a href="inventory.html"><i class="fa fa-dashboard"></i> Sell</a></li>
                                <li class="active">My Inventory</li>
                            </ol>
                        </div>
                        <div class="col-md-12">

                            <div class="col-sm-10 mongoresponse"></div>
                            <div class="col-sm-10"><h2>My Inventory</h2></div>
                            <div class="col-sm-2">
                            <?php //$id='DMS_'.strtotime(date('Y-m-d H:i:s'));?>
                            <!-- {{url('add_listing',array('dplid'=>'DPLID_'.strtotime(date('Y-m-d H:i:s'))))}} -->
                            <?php //echo Session::put('dplid','DPLID_'.strtotime(date('Y-m-d H:i:s')));
                            ?>
                                <a href="{{url('add_listing_tab',array('dplid'=>'DPLID_'.strtotime(date('Y-m-d H:i:s'))))}}" class="btn btn-primary add-list">Add Inventory</a>
                            </div>
                            <div class="hr-dashed"></div>
                            <!-- Zero Configuration Table -->
                            <div class="row">
                                <div class="col-md-12" id="no-more-tables" class="pushmongo">
                                    @if (Session::has('mongomessage'))
                                    <div class="alert alert-success">{{ Session::get('mongomessage') }}</div>
                                    @endif
                                    @if (Session::has('add_listmessage'))
                                    <div class="alert alert-success">{{ Session::get('add_listmessage') }}</div>
                                    @endif
                                    <ul class="nav nav-tabs inventory-list">
                                        <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">All LISTINGS</a></li>
                                        <li><a href="#profile" data-toggle="tab" aria-expanded="false">Park & Sell</a></li>
                                        <li><a href="#review" data-toggle="tab" aria-expanded="true">Own</a></li>
                                        <li><a href="#hasview" data-toggle="tab" aria-expanded="true">Viewed</a></li>
                                        <li><a href="#feature" data-toggle="tab" aria-expanded="true">Deleted</a></li>
                                        <li><a href="#draftstatus" data-toggle="tab" aria-expanded="true">Draft</a></li>
                                        <li class=" pull-right">
                                        <select class="btn btn-primary sortchange">
                                                <option value="">Sort By</option>
                                                <optgroup label="Price">
                                                    <option value="0">High To Low</option>
                                                    <option value="1">Low To High</option>
                                                </optgroup>
                                                <optgroup label="Mileage">
                                                    <option value="2">High To Low</option>
                                                    <option value="3">Low To High</option>
                                                </optgroup>
                                                <optgroup label="Year">
                                                    <option value="4">Old to New</option>
                                                    <option value="5">New To Old</option>
                                                </optgroup>
                                                <optgroup label="View">
                                                    <option value="">Most Viewed</option>
                                                    <option value="">least Viewed</option>
                                                </optgroup>
                                            </select></li>
                                    </ul>
                                    <br>
                                    <!-- ALL TAB START-->
                                    <div  id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade active in" id="all">
                                            <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                                                <tbody>
                                                <!-- {{@$checkcount = count(isset($InventoryAllDetails))}} -->
                                                    @if(count(isset($InventoryAllDetails)) >= 0)
                                                        @if(!empty($InventoryAllDetails))
                                                            @foreach ($InventoryAllDetails as $key => $cardms)
                                                                <tr>
                                                                    <td class="invent-width"><input type="Checkbox" class="form-control" checked></td>
                                                                    <td>
                                                @foreach ($cardms as $imagekey => $image_value)
                                                 @if($imagekey == "images")
                                                   @foreach ($image_value as $val) 
                                                     @if($val->s3_bucket_path)
                                                       <img src="{{$val->s3_bucket_path}}" alt="" class="img-responsive table-img"/>
                                                     @else
                                                        <img class="img-responsive" src="img/noimage.jpg" alt="No images"/>
                                                     @endif
                                                    @endforeach
                                                  @endif
                                                @endforeach
                                                </td>
                                                <td><h4> 
                        @foreach($master_make as $masterid)
                            @if($masterid->make_id == $cardms['make'])
                               {{$masterid->makename}} 
                            @endif
                        @endforeach
                        <br/>
                        @foreach($master_model as $modelid)
                            @if($modelid->model_id == $cardms['model'])
                               {{$modelid->model_name}} 
                            @endif
                        @endforeach
                        <br/>
                        @foreach($master_variant as $varientid)
                            @if($varientid->variant_id == $cardms['variant'])
                               {{$varientid->variant_name}} 
                            @endif
                        @endforeach
                         - {{ $cardms['registration_year']}}</h4>
                <h5><i class="fa fa-inr"></i> {{$cardms['price']}} 
                    </h5>
                <p class="list-detail"><span class="text-muted">{{$cardms['kms_done']}} km</span> | <span class="text-muted">{{$cardms['mileage']}} KMPL</span> | <!-- <span class="text-muted">{{$cardms['registration_year']}}</span> | <span class="text-muted">{{$cardms['owner_type']}}</span> --> <span class="text-muted">{{$cardms['fuel_type']}}</span></p>
                                                                    </td>
                                                                    <td class="uploads">
                                                                        <div class="row">
                                                                            <div class="col-xs-3">
                                                                                <p>Image</p>
                                                                                <p>Videos</p>
                                                                                <p>Docs</p>
                                                                            </div>
                                                                            <div class="col-xs-1 count">
                                                                                <p>
                            @foreach ($cardms as $imagekey => $image_value)
                                @if($imagekey == "photos")
                                    {{count($image_value)}}
                                @endif
                            @endforeach
                            </p>
                            <p>
                            @foreach ($cardms as $imagekey => $image_value)
                                @if($imagekey == "videos")
                                   {{count($image_value)}}
                                @endif
                            @endforeach
                            </p>
                            <p>
                            @foreach ($cardms as $imagekey => $image_value)
                                @if($imagekey == "documents")
                                    {{count($image_value)}}
                                @endif
                            @endforeach
                            </p>
                            </div>
                            <div class="col-xs-3">
                                <p>Views</p>
                                <!-- <p>Saved</p>
                                <p>Leads</p> -->
                            </div>
                            <div class="col-xs-1 count">
                            <p>
                            @foreach ($cardms as $imagekey => $image_value)
                                @if($imagekey == "carviews")
                                    {{count($image_value)}}
                                @endif
                            @endforeach
                            </p>
                                    <!-- <p>0</p>
                                    <p>1</p> -->
                                </div>
                            </div>
                            </td>
                            <td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                <label class="onoffswitch-label" for="myonoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </td>
                            <td><select  class="invent-select statuschange" data-duplicateid="{{$cardms['duplicate_id']}}">
                                <option value="">Live</option>
                                <option value="1">Ready For Sale</option>
                                <option value="2">Drafts</option>
                                <option value="3">On Hold</option>
                                <option value="5">Sold</option>
                                <option value="4">Delete</option>
                            </select></td>
                            <td class="">
                                <ul class="customize"><li><a  class="btn btn-sm btn-success"><i class="fa fa-eye" data-id="{{$cardms['duplicate_id']}}"></i></a></li>
                            @if ($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                            <!-- **************** -->
                                <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                            @endif
                            </ul>
                        </td>
                        @if($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                            <td class="view showmongo_post mongo_push_data{{$cardms['duplicate_id']}}" data-duplicateid="{{$cardms['duplicate_id']}}"><a href="add_listing_tab/{{$cardms['duplicate_id']}}?portal=mongo" data-id="{{$cardms['duplicate_id']}}" class="btn btn-sm btn-primary">Post</a></td>
                        @endif
                        <!-- sendmongo -->
                        </tr>
                        @endforeach
                        @endif
                        @endif
                        </tbody>
                            </table>
                        </div>
                                        <!-- ALL TAB-->
                                                                            
                                        <!-- PARK AND SELL TAB-->
                                        <div class="tab-pane fade in" id="profile">
                                            <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                                                <tbody>
                                                    <!-- $checkcount = count(isset($CarParkSell));
                                                     -->
                                                     @if(count(isset($CarParkSell)) >= 0)
                                                        @if(!empty($CarParkSell))
                                                            @foreach($CarParkSell as $key => $cardms)
                                                                <tr>
                                                                    <!--<td class="invent-width"><input type="Checkbox" class="form-control" checked></td>-->
                                                                    <td>
                                            @foreach ($cardms as $imagekey => $image_value)
                                                @if ($imagekey == "images")
                                                    @foreach ($image_value as $val)
                                                        @if($val->s3_bucket_path)
                                                            <img src="{{$val->s3_bucket_path}}" alt="" class="img-responsive table-img"/>
                                                        @else
                                                            <img class="img-responsive" src="img/noimage.jpg" alt="No images"/>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                                                    </td>
                                                                    <td>
                                                                    <h4>
                        @foreach($master_make as $masterid)
                            @if($masterid->make_id == $cardms['make'])
                               {{$masterid->makename}} 
                            @endif
                        @endforeach
                        <br/>
                        @foreach($master_model as $modelid)
                            @if($modelid->model_id == $cardms['model'])
                               {{$modelid->model_name}} 
                            @endif
                        @endforeach
                        <br/>
                        @foreach($master_variant as $varientid)
                            @if($varientid->variant_id == $cardms['variant'])
                               {{$varientid->variant_name}} 
                            @endif
                        @endforeach
                          {{ $cardms['registration_year']}}</h4>
                            <h5>Rs.{{$cardms['price']}}</h5>
                            <p class="list-detail"><span class="text-muted">{{$cardms['kms_done']}} km</span> | <span class="text-muted">{{$cardms['fuel_type']}}</span> | <span class="text-muted">{{ $cardms['registration_year']}}</span> | <span class="text-muted">{{$cardms['owner_type']}}</span></p>
                            </td>
                                            <td class="uploads">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <p>Image</p>
                                                        <p>Videos</p>
                                                        <p>Docs</p>
                                                    </div>
                                                    <div class="col-xs-1 count">
                                                        <p>
                                @foreach ($cardms as $imagekey => $image_value)
                                    @if($imagekey == "photos")
                                        {{count($image_value)}}
                                    @endif
                                @endforeach
                                </p>
                                <p>
                                @foreach ($cardms as $imagekey => $image_value)
                                    @if($imagekey == "videos")
                                        {{count($image_value)}}
                                    @endif
                                @endforeach
                                </p>
                                <p>
                                @foreach($cardms as $imagekey => $image_value)
                                    @if($imagekey == "documents")
                                        {{count($image_value)}}
                                    @endif
                                @endforeach
                                </p>
                                        </div>
                                        <div class="col-xs-3">
                                            <p>Views</p>
                                            <!-- <p>Saved</p>
                                            <p>Leads</p> -->
                                        </div>
                                        <div class="col-xs-1 count">
                                            <p>
                        @foreach($cardms as $imagekey => $image_value)
                            @if($imagekey == "carviews")
                                {{count($image_value)}}
                            @endif
                        @endforeach
                    </p>
                                        </div>
                                    </div>
                                    </td>

                                    <td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                        <label class="onoffswitch-label" for="myonoffswitch">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label></td>
                                    <td><select class="invent-select statuschange" data-duplicateid="{{$cardms['duplicate_id']}}">
                                            <option value="">Status</option>
                                            <option value="1">Ready For Sale</option>
                                            <option value="2">Drafts</option>
                                            <option value="3">On Hold</option>
                                            <option value="5">Sold</option>
                                            <option value="4">Delete</option>
                                        </select></td>
                                    <td class="">
                                        <ul class="customize">
                                        <li><a  class="btn btn-sm btn-success"><i class="fa fa-eye" data-id="{{$cardms['duplicate_id']}}"></i></a></li>
                                            @if ($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                                                 <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                                            @endif
                                        </ul>
                                    </td>
                                    @if($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                                        <td class="view showmongo_post mongo_push_data{{$cardms['duplicate_id']}}"><a data-id="{{$cardms['duplicate_id']}}" class="btn btn-sm btn-primary sendmongo">Post</a></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
                                        <!-- PARK AND SELL TAB-->
                                        <!-- OWN TAB-->
                <div class="tab-pane fade in" id="review">
                <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                <tbody>
                    @if(count(isset($CarOwnSellView)) >= 0)
                        @if(!empty($CarOwnSellView))
                            @foreach($CarOwnSellView as $key => $cardms)
                                <tr>
                                    <!--<td class="invent-width"><input type="Checkbox" class="form-control" checked></td>-->
                                    <td>
                @foreach($cardms as $imagekey => $image_value)
                    @if($imagekey == "images")
                        @foreach ($image_value as $val)
                            @if($val->s3_bucket_path)
                                <img src="{{$val->s3_bucket_path}}" alt="" class="img-responsive table-img"/>
                            @else
                                <img class="img-responsive" src="img/noimage.jpg" alt="No images"/>
                            @endif
                            </td>
                        @endforeach
                    @endif
                @endforeach
                <td>
                <h4> 
                @foreach($master_make as $masterid)
                    @if($masterid->make_id == $cardms['make'])
                        {{$masterid->makename}} 
                    @endif
                @endforeach
                <br/>
                @foreach($master_model as $modelid)
                    @if($modelid->model_id == $cardms['model'])
                        {{$modelid->model_name}} 
                    @endif
                @endforeach
                <br/>
                @foreach($master_variant as $varientid)
                    @if($varientid->variant_id == $cardms['variant'])
                        {{$varientid->variant_name}} 
                    @endif
                @endforeach
                {{$cardms['registration_year']}}
                </h4>
                        <h5>Rs.{{$cardms['price']}}</h5>
                        <p class="list-detail"><span class="text-muted">{{$cardms['kms_done']}} km</span> | <span class="text-muted">{{$cardms['fuel_type']}}</span> | <span class="text-muted">{{$cardms['registration_year']}}</span> | <span class="text-muted">{{$cardms['owner_type']}}</span></p>
                        </td>
                        <td class="uploads">
                <div class="row">
                    <div class="col-xs-3">
                        <p>Image</p>
                        <p>Videos</p>
                        <p>Docs</p>
                    </div>
                    <div class="col-xs-1 count">
                    <p>
                @foreach($cardms as $imagekey => $image_value)
                    @if ($imagekey == "photos")
                        {{count($image_value)}}
                    @endif
                @endforeach
                </p>
                <p>
                @foreach($cardms as $imagekey => $image_value)
                @if($imagekey == "videos")
                    {{count($image_value)}}
                @endif
                @endforeach
                </p>
                <p>
                @foreach ($cardms as $imagekey => $image_value)
                @if($imagekey == "documents")
                    {{count($image_value)}}
                @endif
                @endforeach
                </p>
                    </div>
                    <div class="col-xs-3">
                        <p>Views</p>
                        <!-- <p>Saved</p>
                        <p>Leads</p> -->
                    </div>
                    <div class="col-xs-1 count">
                <p>
                @foreach($cardms as $imagekey => $image_value)
                @if($imagekey == "carviews")
                    {{count($image_value)}}
                @endif
                @endforeach
                </p>
                                                <!-- <p>0</p>
                                <p>1</p> -->
                            </div>
                        </div>
                    </td>

                    <td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                        <label class="onoffswitch-label" for="myonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label></td>
                    <td><select class="invent-select statuschange" data-duplicateid="{{$cardms['duplicate_id']}}">
                            <option value="">Status</option>
                            <option value="1">Ready For Sale</option>
                            <option value="2">Drafts</option>
                            <option value="3">On Hold</option>
                            <option value="5">Sold</option>
                            <option value="4">Delete</option>
                        </select></td>
                    <td class="">
                        <ul class="customize"><li><a  class="btn btn-sm btn-success"><i class="fa fa-eye" data-id="{{$cardms['duplicate_id']}}"></i></a></li>
                    @if($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                                 <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                    @endif
                        </ul>
                    </td>
                @if($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                    <td class="view showmongo_post mongo_push_data{{$cardms['duplicate_id']}}"><a data-id="{{$cardms['duplicate_id']}}" class="btn btn-sm btn-primary sendmongo">Post</a></td>
                @endif
                </tr>
@endforeach
@endif
@endif
</tbody>
</table>
                </div>
<!-- OWN TAB END-->

                                        <!-- HAS VIEW TAB-->    

                <div class="tab-pane fade in" id="hasview">
                    <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                        <tbody>
                @if(count(isset($newimages)) >= 0)
                    @if(!empty($newimages))
                        @foreach($newimages as $key => $cardms)
                            <tr>
                                <!--<td class="invent-width"><input type="Checkbox" class="form-control" checked></td>-->
                                <td>
                                @foreach($cardms as $imagekey => $image_value)
                                    @if($imagekey == "images")
                                        @foreach($image_value as $val)
                                             @if($val->s3_bucket_path)

                                                <img src="{{$val->s3_bucket_path}}" alt="" class="img-responsive table-img"/>
                                             @else
                                                <img class="img-responsive" src="img/noimage.jpg" alt="No images"/>
                                             @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                </td>
                                <td><h4> 
                        @foreach($master_make as $masterid)
                            @if($masterid->make_id == $cardms['make'])
                               {{$masterid->makename}} 
                            @endif
                        @endforeach
                        <br/>
                        @foreach($master_model as $modelid){
                            @if($modelid->model_id == $cardms['model']){
                               {{$modelid->model_name}} 
                            @endif
                        @endforeach
                        <br/>;
                        @foreach($master_variant as $varientid)
                            @if($varientid->variant_id == $cardms['variant'])
                               {{$varientid->variant_name}} 
                            @endif
                        @endforeach
                         {{$cardms['registration_year']}}
                         </h4>
                            <h5>Rs.{{$cardms['price']}}</h5>
                            <p class="list-detail"><span class="text-muted">{{$cardms['kms_done']}} km</span> | <span class="text-muted">{{$cardms['fuel_type']}}</span> | <span class="text-muted">{{$cardms['registration_year']}}</span> | <span class="text-muted">{{$cardms['owner_type']}}</span></p>
                        </td>

                        <td class="uploads">
                            <div class="row">
                                <div class="col-xs-3">
                                    <p>Image</p>
                                    <p>Videos</p>
                                    <p>Docs</p>
                                </div>
                                <div class="col-xs-1 count">
                                <p>
                        @foreach($cardms as $imagekey => $image_value)
                        @if($imagekey == "photos")
                            {{count($image_value)}}
                        @endif
                        @endforeach
                        </p>
                        <p>
                        @foreach ($cardms as $imagekey => $image_value)
                        @if($imagekey == "videos")
                            {{count($image_value)}}
                        @endif
                        @endforeach
                        </p>
                        <p>
                        @foreach($cardms as $imagekey => $image_value)
                            @if($imagekey == "documents")
                                {{count($image_value)}}
                            @endif
                        @endforeach
                        </p>
                        </div>
                        <div class="col-xs-3">
                            <p>Views</p>
                            <!-- <p>Saved</p>
                            <p>Leads</p> -->
                        </div>
                        <div class="col-xs-1 count">
                        <p>
                        @foreach($cardms as $imagekey => $image_value)
                            @if($imagekey == "carviews")
                                {{count($image_value)}}
                            @endif
                        @endforeach
                        </p>
                                </div>
                            </div>
                        </td>

                        <td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                            <label class="onoffswitch-label" for="myonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label></td>
                        <td><select class="invent-select statuschange" data-duplicateid="{{$cardms['duplicate_id']}}">
                                <option value="">Status</option>
                                <option value="1">Ready For Sale</option>
                                <option value="2">Drafts</option>
                                <option value="3">On Hold</option>
                                <option value="5">Sold</option>
                                <option value="4">Delete</option>
                            </select></td>
                        <td class="">
                            <ul class="customize"><li><a  class="btn btn-sm btn-success"><i class="fa fa-eye" data-id="{{$cardms['duplicate_id']}}"></i></a></li>
                         @if($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                                     <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                        @endif
                            </ul>
                        </td>
                        @if($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                            <td class="view showmongo_post mongo_push_data{{$cardms['duplicate_id']}}"><a data-id="{{$cardms['duplicate_id']}}" class="btn btn-sm btn-primary sendmongo">Post</a></td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                    @endif
    </tbody>
</table>
</div>

                                        <!-- HAS VIEW TAB-->    

                                        <!-- DELETE TAB-->

            <div class="tab-pane fade in" id="feature">
                <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                    <tbody>
                        @if(count(isset($CarDeleteView)) >= 0)
                            @if(!empty($CarDeleteView))
                                @foreach($CarDeleteView as $key => $cardms)
                            <tr>
                                <!--<td class="invent-width"><input type="Checkbox" class="form-control" checked></td>-->
                                <td>
                @foreach($cardms as $imagekey => $image_value)
                    @if($imagekey == "images")
                        @foreach ($image_value as $val)
                            @if($val->s3_bucket_path)
                            <img src="{{$val->s3_bucket_path}}" alt="" class="img-responsive table-img"/>
                            @else
                            <img class="img-responsive" src="img/noimage.jpg" alt="No images"/>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                </td>
                <td><h4>
            {{$cardms['make']}}  {{$cardms['model']}} {{$cardms['registration_year']}}</h4>
            <h5>Rs.{{$cardms['price']}}</h5>
            <p class="list-detail"><span class="text-muted">{{$cardms['kms_done']}} km</span> | <span class="text-muted">{{$cardms['fuel_type']}}</span> | <span class="text-muted">{{$cardms['registration_year']}}</span> | <span class="text-muted">{{$cardms['owner_type']}}</span></p>
        </td>

                <td class="uploads">
                    <div class="row">
                        <div class="col-xs-3">
                            <p>Image</p>
                            <p>Videos</p>
                            <p>Docs</p>
                        </div>
                        <div class="col-xs-1 count">
                            <p>
                                @foreach ($cardms as $imagekey => $image_value)
                                    @if($imagekey == "photos")
                                        {{count($image_value)}}
                                    @endif
                                @endforeach
                                </p>
                            <p>
                                @foreach ($cardms as $imagekey => $image_value)
                                    @if($imagekey == "videos")
                                        {{count($image_value)}}
                                    @endif
                                @endforeach
                                </p>
                            <p>
                        @foreach($cardms as $imagekey => $image_value)
                            @if($imagekey == "documents")
                                {{count($image_value)}}
                            @endif
                        @endforeach
                        </p>
                        </div>
                        <div class="col-xs-3">
                            <p>Views</p>
                            <!-- <p>Saved</p>
                            <p>Leads</p> -->
                        </div>
                        <div class="col-xs-1 count">
                            <p>
                            @foreach ($cardms as $imagekey => $image_value)
                                @if($imagekey == "carviews")
                                    {{count($image_value)}}
                                @endif
                            @endforeach
                            </p>
                                                                                <!-- <p>0</p>
                                <p>1</p> -->
                            </div>
                        </div>
                    </td>

                        <td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                            <label class="onoffswitch-label" for="myonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label></td>
                        <td><select class="invent-select statuschange" data-duplicateid="{{$cardms['duplicate_id']}}">
                                <option value="">Status</option>
                                <option value="1">Ready For Sale</option>
                                <option value="2">Drafts</option>
                                <option value="3">On Hold</option>
                                <option value="5">Sold</option>
                                <option value="4">Delete</option>
                            </select></td>
                        <td class="">
                            <ul class="customize"><li><a  class="btn btn-sm btn-success"><i class="fa fa-eye" data-id="{{$cardms['duplicate_id']}}"></i></a></li>
                    @if ($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                         <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                    @endif
                        </ul>
                        </td>
                        @if ($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                            <td class="view showmongo_post mongo_push_data{{$cardms['duplicate_id']}}"><a data-id="{{$cardms['duplicate_id']}}" class="btn btn-sm btn-primary sendmongo">Post</a></td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                    @endif
                    </tbody>
                </table>
                </div>
                    <!-- DELETE TAB END-->
                    <!-- Draft Tabs -->
                    <!-- ******************  -->
                        <div class="tab-pane fade in" id="draftstatus">
                            <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                                <tbody>
                                @if(count(isset($CarDraftView)) >= 0)
                                    @if(!empty($CarDraftView))
                                        @foreach ($CarDraftView as $key => $cardms)
                                    <tr>
                                        <!--<td class="invent-width"><input type="Checkbox" class="form-control" checked></td>-->
                                        <td>
                                @foreach($cardms as $imagekey => $image_value)
                                    @if($imagekey == "images")
                                        @foreach($image_value as $val)
                                            @if($val->s3_bucket_path)
                                            <img src="{{$val->s3_bucket_path}}" alt="" class="img-responsive table-img"/> 
                                            @else
                                            <img class="img-responsive" src="img/noimage.jpg" alt="No images"/>
                                            @endif       
                                        @endforeach
                                    @endif
                                @endforeach
                                    </td>
                                    <td><h4>
    {{$cardms['make']}} {{$cardms['model']}} {{$cardms['registration_year']}}</h4>
                    <h5>Rs.{{$cardms['price']}}</h5>
                    <p class="list-detail"><span class="text-muted">{{$cardms['kms_done']}} km</span> | <span class="text-muted">{{$cardms['fuel_type']}}</span> | <span class="text-muted">{{$cardms['registration_year']}}</span> | <span class="text-muted">{{$cardms['owner_type']}}</span></p>
                </td>

                <td class="uploads">
                    <div class="row">
                        <div class="col-xs-3">
                            <p>Image</p>
                            <p>Videos</p>
                            <p>Docs</p>
                        </div>
                        <div class="col-xs-1 count">
                            <p>
                                @foreach($cardms as $imagekey => $image_value)
                                    @if($imagekey == "photos")
                                        {{count($image_value)}}
                                    @endif
                                @endforeach
                                </p>
                            <p>
                            @foreach($cardms as $imagekey => $image_value)
                                @if($imagekey == "videos")
                                   {{count($image_value)}}
                                @endif
                            @endforeach
                            </p>
                            <p>
            @foreach ($cardms as $imagekey => $image_value)
                @if($imagekey == "documents")
                    {{count($image_value)}}
                @endif
            @endforeach
            </p>
                                        </div>
                                        <div class="col-xs-3">
                                            <p>Views</p>
                                            <!-- <p>Saved</p>
                                            <p>Leads</p> -->
                                        </div>
                                        <div class="col-xs-1 count">
            <p>
                @foreach ($cardms as $imagekey => $image_value)
                @if($imagekey == "carviews")
                    {{count($image_value)}}
                @endif
                @endforeach
            </p>
                    <!-- <p>0</p>
                    <p>1</p> -->
                </div>
            </div>
        </td>

                <td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                    <label class="onoffswitch-label" for="myonoffswitch">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label></td>
                <td><select class="invent-select statuschange" data-duplicateid="{{$cardms['duplicate_id']}}">
                        <option value="2">Draft</option>
                    </select></td>
                <td class="">
                    <ul class="customize">
            @if($cardms['mongopush_status'] == 'failure' || $cardms['mongopush_status'] == "")
                             <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
            @endif
                    </ul>
                </td>
            </tr>
        @endforeach
        @endif
        @endif
</tbody>
</table>
</div>
                                        <!-- Draft Tabs End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('footer')
            </div>
        </div>


        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/chartData.js"></script>
        <script src="js/main.js"></script>
        <script src="js/endless.js"></script>
        <script src="js/menu.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
            $('.update').click(function () {
                $('#car_id').val($(this).attr('data-id'));
                $('#edit_car_managelist').submit();
            });
        });

        $(document).ready(function () {
            $('.fa-eye').click(function () {
                $('#car_view_id').val($(this).attr('data-id'));
                $('#view_car_managelist').submit();
            });
        });
        $(document).on('click', '#push_mongo', function () {
            $('#car_push_mongo').val($(this).attr('data-id'));
            $('#car_post').submit();
        });

        $(document).ready(function () {
            $('.delete').click(function () {
                $('#car_delete_id').val($(this).attr('data-id'));
                $('#delete_car_managelist').submit();
            });
        });

        $("body").ready(function()
        {
        	var statusvalue = $(".statuschange").val();
        	var duplicate 	= $(".statuschange").data("duplicateid");
        	if(statusvalue == "")
        	{
        		$(".showmongo_post").hide();
        	}
        });


        $('body').on("change", ".statuschange", function () {
            var duplicate = $(this).data("duplicateid");
            var statusvalue = $(this).val();
            if (statusvalue == "")
            {
            	$(".mongo_push_data"+duplicate).hide();
                return false;
            }
            if(statusvalue == 1)
            {
            	$(".mongo_push_data"+duplicate).show();
            	return false;
            }
            $.ajax({
                url: "managelisting_status",
                type: "POST",
                dataType: 'json',
                data: {duplicate_id: duplicate, status: statusvalue},
                success: function (res)
                {
                    window.location.href = "managelisting";
                }
            });
        });

        // $("body").ready(function()
        // {
        //     var value = $(".sortchange").val();
        //     $('#sort_change_id').val(value);
        //     $('#view_managelisting').submit();
        // });


        $('body').on("change", ".sortchange", function () {

            $("#loadspinner").css("display", "block");
            var statusvalue = $(this).val();
            if (statusvalue == "")
            {
                $("#loadspinner").css("display", "none");
                return false;
            }                
                $('#sort_change_id').val(statusvalue);
                $('#view_managelisting').submit();
                $("#loadspinner").css("display", "block");
                //return false;
            // $.ajax({
            //     url: "managesorting_list",
            //     type: "post",
            //     data: {status: statusvalue},
            //     success: function (data)
            //     {
            //         var response = $.parseJSON(data);

            //         if (response.statuscode == 0)
            //         {
            //             window.location.href = "managelisting";
            //             $("#loadspinner").css("display", "none");
            //         }
            //         if (response.statuscode == 1)
            //         {
            //             window.location.href = "managesorting_list_result";
            //             $("#loadspinner").css("display", "none");
            //         }
            //         if (response.statuscode == 2)
            //         {
            //             window.location.href = "managesorting_mileage_htl";
            //             $("#loadspinner").css("display", "none");
            //         }

            //         if (response.statuscode == 3)
            //         {
            //             window.location.href = "managesorting_mileage_lth";
            //             $("#loadspinner").css("display", "none");
            //         }

            //         if (response.statuscode == 4)
            //         {
            //             window.location.href = "managesorting_lth_year";
            //             $("#loadspinner").css("display", "none");
            //         }
            //         if (response.statuscode == 5)
            //         {
            //             window.location.href = "managesorting_htl_year";
            //             $("#loadspinner").css("display", "none");
            //         }

            //     }
            // });
        });


        // $(document).ready(function () {
        //     var statusvalue = $(".sortchange").val();
        //     $.ajax({
        //         url: "managesorting_list",
        //         type: "post",
        //         data: {status: statusvalue},
        //         success: function (data)
        //         {
        //             var response = $.parseJSON(data);
        //             /*if(response.statuscode == 0)
        //              {
        //              window.location.href = "managelisting";    
        //              }*/
        //         }
        //     });
        // });

        $("body").on("click", ".sendmongo", function () {
            var duplicate_id = $(this).data("id");
            $.ajax({
                url: "mongo_push",
                type: "post",
                data: {duplicate_id: duplicate_id},
                success: function (data)
                {
                    var response = $.parseJSON(data);
                    if (response.success == "successfully insertred mongo")
                    {
                        $('.mongoresponse').html('<center><h2>Monog Push Successfully Inserted</h2></center>');
                        window.location.href = "managelisting";
                    }
                }
            });
        });
        </script>         
    </body>
</html>
