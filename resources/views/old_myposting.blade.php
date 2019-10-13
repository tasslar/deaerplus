<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>DMS</title>

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
                                <li class="active">My Posting</li>
                            </ol>
                        </div>
                        <div class="col-md-12">

                            <div class="col-sm-12"><h2>My Posting</h2></div>
                            
                            <div class="hr-dashed"></div>

                            <!-- Zero Configuration Table -->
                            <div class="row">
                                <div class="col-md-12" id="no-more-tables">
<table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#details" class="btn btn-sm btn-primary">Details</a>
                                                         </td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr class="row" style="display:none;"><td class="col-sm-12"><table><tbody><tr><td><input class="form-control" type="text" placeholder="Listing Id"></td>
                                                        <td><input class="form-control" type="text" placeholder="Listing Platform"></td>
                                                               <td>2016-04-21</td>
                                                              <td><select class="form-control"><option value="">Category</option><option value="1">Free</option><option value="2">Premium</option></select></td>
                                                               <td><select class="form-control"><option value="">List Status</option><option value="1">Active</option><option value="1">Expired</option></select></td>
                                                               <td><a class="btn btn-primary btn-sm">Delete</a></td>
                                                               <td><a class="btn btn-primary btn-sm"><i data-toggle="tooltip" title="" data-original-title="Saved cars" class="fa fa-refresh"></i></a></td>
                                                                    </tr></tbody></table></td></tr>
                                                

                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invent-width"><input type="Checkbox" class="form-control" checked=""></td>
                                                        <td><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                                                        <td><h4>Maruti(2.9)</h4>
                                                            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
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
                                                        
                                                        <td><select class="invent-select">
                                                                <option value="">Status</option>
                                                                 <option value="1">Ready For Sale</option>
                                                                <option value="2">Drafts</option>
                                                                <option value="3">On Hold</option>
                                                                <option value="3">Sold</option>
                                                                <option value="4">Delete</option>
                                                            </select></td>
                                                        <td class="">
                                                           <a href="#" class="btn btn-sm btn-primary">Details</a></td>
                                                        <td class="view"><a href="#" class="btn btn-sm btn-primary">Post</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                    <div class="col-xs-12">
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
        
    </body>
    

</html>