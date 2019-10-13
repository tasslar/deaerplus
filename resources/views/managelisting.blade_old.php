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

    </head>

    <body>
        
       @include('header')
            <form method="post" id="view_car_managelist" action="{{url('view')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="car_view_id" name="car_view_id">
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
                <div class="container-fluid">

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

                            <div class="col-sm-10"><h2>My Inventory</h2></div>
                            <div class="col-sm-2">
                                <a href="{{url('add_listing')}}" class="btn btn-primary add-list"><i class="fa fa-plus-square"></i>&nbsp; Add Inventory</a>
                            </div>
                            <div class="hr-dashed"></div>

                            <!-- Zero Configuration Table -->
                            <div class="row">
                                <div class="col-md-12" id="no-more-tables">
                                 @if (Session::has('mongomessage'))
                <div class="alert alert-success">{{ Session::get('mongomessage') }}</div>
            @endif
            @if (Session::has('add_listmessage'))
                <div class="alert alert-success">{{ Session::get('add_listmessage') }}</div>
            @endif
                                    <ul class="nav nav-tabs inventory-list">
                                        <li class="btn btn-sm btn-primary"><input type="Checkbox" checked=""></li>
                                        <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">All</a></li>
                                        <li><a href="#profile" data-toggle="tab" aria-expanded="false">Park & Sell</a></li>
                                        <li><a href="#review" data-toggle="tab" aria-expanded="true">Own</a></li>
                                        <li><a href="#feature" data-toggle="tab" aria-expanded="true">Has Views</a></li>
                                        <li><a href="#feature" data-toggle="tab" aria-expanded="true">Deleted</a></li>
                                        <li class=" pull-right"><span>Sort by</span> <select class="btn btn-primary">
                                    <optgroup label="Price">
													<option>High To Low</option>
													<option>Low To High</option>
													</optgroup>
												<optgroup label="Mileage">
													<option>High To Low</option>
													<option>Low To High</option>
												</optgroup>
                                                  <optgroup label="Year">
													<option>Old to New</option>
													<option>New To Old</option>
												</optgroup>
                                                    <optgroup label="View">
                                                    <option>Most Viewed</option>
                                                    <option>least Viewed</option>
                                                </optgroup>
											</select></li>
                                    </ul>
                                    <br>
                                    <div id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade active in" id="all">
                                            <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                                            <tbody>
                                            @foreach($select as $fetch)
                                                <tr>
                                                    <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                    <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                    <td><h4>{{$fetch->make}}{{$fetch->model}}{{$fetch->variant}}{{$fetch->registration_year}}</h4>
                                                        <h5>Rs.{{$fetch->price}}</h5>
                                                        <p class="list-detail"><span class="text-muted">{{$fetch->kms_done}} km</span> | <span class="text-muted">{{$fetch->fuel_type}}</span> | <span class="text-muted">{{$fetch->registration_year}}</span> | <span class="text-muted">{{$fetch->owner_type}}</span></p>
                                                    </td>
                                                    <td class="uploads">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                <p>Image</p>
                                                                <p>Videos</p>
                                                                <p>Docs</p>
                                                            </div>
                                                            <div class="col-xs-1 count">
                                                                <p>0</p>
                                                                <p>1</p>
                                                                <p>5</p>
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <p>Views</p>
                                                                <p>Saved</p>
                                                                <p>Leads</p>
                                                            </div>
                                                            <div class="col-xs-1 count">
                                                                <p>2</p>
                                                                <p>0</p>
                                                                <p>1</p>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                                        <label class="onoffswitch-label" for="myonoffswitch">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label></td>
                                                    <td><select class="invent-select">
                                                            <option value="">Status</option>
                                                            <option value="1">Ready For Sale</option>
                                                            <option value="2">Drafts</option>
                                                            <option value="3">On Hold</option>
                                                            <option value="3">Sold</option>
                                                            <option value="4">Delete</option>
                                                        </select></td>
                                                    <td class="">
                                                            <ul class="customize"><li><a  class="btn btn-sm btn-success"><i class="fa fa-eye" data-id="{{$fetch->car_id}}"></i></a></li>
                                                                <li><a href="#" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                                                            </ul></td>
                                                    <td class="view"><a id="push_mongo" data-id="{{$fetch->car_id}}" class="btn btn-sm btn-primary">Post</a></td>
                                                </tr>
                                                </form>
                                                 @endforeach   
                                             </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
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
        $(document).ready(function(){
            $('.update').click(function(){
                $('#car_id').val($(this).attr('data-id'));
                $('#edit_car_managelist').submit();
            });
        });

        $(document).ready(function(){
            $('.fa-eye').click(function(){                
                $('#car_view_id').val($(this).attr('data-id'));
                    $('#view_car_managelist').submit();
            });
        });
        $(document).on('click','#push_mongo',function(){
            $('#car_push_mongo').val($(this).attr('data-id'));
                $('#car_post').submit();
        });

        $(document).ready(function(){
            $('.delete').click(function(){
                $('#car_delete_id').val($(this).attr('data-id'));
                $('#delete_car_managelist').submit();
            });
        });
    </script>
    </body>


</html>