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
	<div class="brand clearfix">
		<a href="index.html" class="logo"><img src="img/logo.jpg" class="img-responsive" alt=""></a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li><a href="#">Help</a></li>
			<li><a href="#">Settings</a></li>
			<li class="ts-account">
				<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="myaccount.html">My Account</a></li>
							<li><a href="myaccount-e.html">Edit Account</a></li>
					<li><a href="#">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>

	<div class="ts-main-content">
		<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">
				<li class="ts-label">Search</li>
				<li>
					<input type="text" class="ts-sidebar-search" placeholder="Search here...">
				</li>
				<li class="ts-label">Main</li>
				<li class="open"><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
				<li><a href="#"><i class="fa fa-desktop"></i> All Listing</a>
					<ul>
						<li><a href="managelisting.html">Manage Listing</a></li>
						<!--<li><a href="lisiting.html">Buy Listing</a></li>-->
						<!--<li><a href="notifications.html">Notifications</a></li>
						<li><a href="typography.html">Typography</a></li>
						<li><a href="icon.html">Icon</a></li>
						<li><a href="grid.html">Grid</a></li>-->
					</ul>
				</li>
				<!--<li><a href="tables.html"><i class="fa fa-table"></i> Tables</a></li>
				<li><a href="forms.html"><i class="fa fa-edit"></i> Forms</a></li>
				<li><a href="charts.html"><i class="fa fa-pie-chart"></i> Charts</a></li>
				<li><a href="#"><i class="fa fa-sitemap"></i> Multi-Level Dropdown</a>
					<ul>
						<li><a href="#">2nd level</a></li>
						<li><a href="#">2nd level</a></li>
						<li><a href="#">3rd level</a>
							<ul>
								<li><a href="#">3rd level</a></li>
								<li><a href="#">3rd level</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="#"><i class="fa fa-files-o"></i> Sample Pages</a>
					<ul>
						<li><a href="blank.html">Blank page</a></li>
						<li><a href="login.html">Login page</a></li>
					</ul>
				</li>-->

				<!-- Account from above -->
				<ul class="ts-profile-nav">
					<li class="ts-account">
						<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
						<ul>
							<li><a href="myaccount.html">My Account</a></li>
							<li><a href="myaccount-e.html">Edit Account</a></li>
							<li><a href="#">Logout</a></li>
						</ul>
					</li>
				</ul>

			</ul>
		</nav>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Buy Listings</h2>
					<div class="row">
							<div class="col-xs-12 tags-top"><ul class="tag"><li class="alert alert-info col-xs-2">
											<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
											<p>Audi</p>
										</li>
										<li class="alert alert-info col-xs-2">
											<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
											<p>BMW</p>
										</li>
										<li class="alert alert-info col-xs-2">
											<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
											<p>Diesel</p>
										</li>
										<li class="alert alert-info col-xs-2">
											<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
											<p>2018</p>
										</li>
										<li class="alert alert-info col-xs-2">
											<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
											<p>Cochin</p>
										</li>
										
										</ul></div>
							
								<div class="col-sm-7">
								<ul id="listing">
								<li class="panel panel-primary alert">
								<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
									<div class="panel-heading">
										<h1 class="panel-title listing"><a href="#"><i class="fa fa-car"></i>&nbsp;Brand Name</a></h1>
									</div>
									<div class="panel-body all-list">
										<div class="col-xs-4"><img src="img/car1.jpg" class="img-responsive style_prevu_kit" alt=""/></div>
										<div class="col-xs-8"><div class="row"><div class="pull-left"><h4 class="text-primary buy-list"><i class="fa fa-rupee"></i> 3.5 Lakh</h4>
										<p class="text-primary"><i class="fa fa-map-marker"></i>&nbsp;Alandur, Chennai-600090</p>
										</div>
                                        <p class="text-primary pull-right"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p></div>
										<div class="row">
										<div class="col-xs-3 buylist-box"><h4>Model</h4>
										<p>Audi</p>
										</div>
										<div class="col-xs-3 buylist-box"><h4>Color</h4>
										<p>Blue</p>
										</div>
										<div class="col-xs-3 buylist-box"><h4>Fuel</h4>
										<p>Diesel</p>
										</div>
										<div class="col-xs-3 buylist-box"><h4>Seats</h4>
										<p>5</p>
										</div>
										<div class="col-xs-3 buylist-box"><h4>Year</h4>
										<p>2016</p>
										</div>
										<div class="col-xs-3 buylist-box"><h4>Owner</h4>
										<p>First</p>
										</div>
										</div>
										
										<!--<p><a href="#" class="btn btn-default pull-right all-list-btn">View More</a></p>-->
										</div>
										
										</div>
								</li>

								<li class="panel panel-primary alert">
								<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
									<div class="panel-heading">
										<h3 class="panel-title listing"><a href="#"><i class="fa fa-car"></i>&nbsp;Brand Name</a></h3>
									</div>
									<div class="panel-body all-list">
										<div class="col-xs-4"><img src="img/car1.jpg" class="img-responsive style_prevu_kit" alt=""/></div>
										<div class="col-xs-8"><h4 class="text-primary"><i class="fa fa-rupee"></i> 3.5 Lakh</h4>
										<p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span></p>
										<p class="text-primary pull-left"><i class="fa fa-map-marker"></i>&nbsp;Alandur, Chennai-600090</p>
										<p><a href="#" class="btn btn-default pull-right all-list-btn">View More</a></p>
										</div>
										
										</div>
								</li>

								<li class="panel panel-primary alert">
								<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
									<div class="panel-heading">
										<h3 class="panel-title listing"><a href="#"><i class="fa fa-car"></i>&nbsp;Brand Name</a></h3>
									</div>
									<div class="panel-body all-list">
										<div class="col-xs-4"><img src="img/car1.jpg" class="img-responsive style_prevu_kit" alt=""/></div>
										<div class="col-xs-8"><h4 class="text-primary"><i class="fa fa-rupee"></i> 3.5 Lakh</h4>
										<p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span></p>
										<p class="text-primary pull-left"><i class="fa fa-map-marker"></i>&nbsp;Alandur, Chennai-600090</p>
										<p><a href="#" class="btn btn-default pull-right all-list-btn">View More</a></p>
										</div>
										
										</div>
								</li>
								<li class="panel panel-primary alert">
								<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
									<div class="panel-heading">
										<h3 class="panel-title listing"><a href="#"><i class="fa fa-car"></i>&nbsp;Brand Name</a></h3>
									</div>
									<div class="panel-body all-list">
										<div class="col-xs-4"><img src="img/car1.jpg" class="img-responsive style_prevu_kit" alt=""/></div>
										<div class="col-xs-8"><h4 class="text-primary"><i class="fa fa-rupee"></i> 3.5 Lakh</h4>
										<p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span></p>
										<p class="text-primary pull-left"><i class="fa fa-map-marker"></i>&nbsp;Alandur, Chennai-600090</p>
										<p><a href="#" class="btn btn-default pull-right all-list-btn">View More</a></p>
										</div>
										
										</div>
								</li>

								<li class="panel panel-primary alert">
								<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
									<div class="panel-heading">
										<h3 class="panel-title listing"><a href="#"><i class="fa fa-car"></i>&nbsp;Brand Name</a></h3>
									</div>
									<div class="panel-body all-list">
										<div class="col-xs-4"><img src="img/car1.jpg" class="img-responsive style_prevu_kit" alt=""/></div>
										<div class="col-xs-8"><h4 class="text-primary"><i class="fa fa-rupee"></i> 3.5 Lakh</h4>
										<p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span></p>
										<p class="text-primary pull-left"><i class="fa fa-map-marker"></i>&nbsp;Alandur, Chennai-600090</p>
										<p><a href="#" class="btn btn-default pull-right all-list-btn">View More</a></p>
										</div>
										
										</div>
								</li></ul>
							</div>
							<div class="col-sm-5 filter">
							<div class="panel panel-default">
									<div class="panel-heading">NARROW YOUR SEARCH FOR USED CAR</div>
									<div class="panel-body">
										<form method="get" class="form-horizontal">
											<div class="form-group">
										<label class="col-xs-4 control-label">Car Make:</label>
										<div class="col-xs-8">
											<select class="selectpicker" multiple data-selected-text-format="count">
												<option value="15">Audi</option><option value="2">BMW</option><option value="13">Chevrolet</option><option value="3">Ferarri</option><option value="21">Fiat</option><option value="11">Ford</option><option value="19">Honda</option><option value="10">Hyundai</option><option value="6">Jaguar</option><option value="22">Jeep</option><option value="14">Land Rover</option><option value="20">Mahindra</option><option value="4">Maruti Suzuki</option><option value="16">Mercedes Benz</option><option value="17">Mitsubishi</option><option value="1">Nissan</option><option value="8">Renault</option><option value="7">Skoda</option><option value="5">TATA</option><option value="9">Toyota</option><option value="18">Volkswagen</option>
											</select>
										</div>
									</div>

									<div class="hr-dashed"></div>
									<div class="form-group">
										<label class="col-xs-4 control-label">Car Sites:</label>
										<div class="col-xs-8">
											<select class="selectpicker" multiple data-selected-text-format="count">
												<option value="">Cardekho</option><option value="">Quickr</option><option value="">Carwale</option><option value="">OLX</option>
											</select>
										</div>
									</div>
									<div class="hr-dashed"></div>
											<div class="form-group">
										<label class="col-xs-4 control-label">Car Model:</label>
										<div class="col-xs-8">
											<select class="selectpicker">
												<option value="15">Audi R8</option><option value="2">Audi A3</option><option value="13">Audi A3 Cabriolet</option>
											</select>
										</div>
									</div>
                                    <div class="hr-dashed"></div>
											<div class="form-group">
										<label class="col-xs-4 control-label">Car Year:</label>
										<div class="col-xs-8">
											<select class="selectpicker">
												<option value="15">2015</option><option value="2">2014</option><option value="13">2016</option><option value="13">2013</option><option value="13">2012</option><option value="13">2011</option>
											</select>
										</div>
									</div>
									<div class="hr-dashed"></div>
									<div class="form-group">
										<label class="col-xs-4 control-label">Transmission:</label>
										<div class="col-xs-8">
											<select class="selectpicker btn-success">
												<option value="15">Manual</option><option value="2">Transmission</option><option value="13">Automatic</option>
											</select>
										</div>
									</div>
									<div class="hr-dashed"></div>
											<div class="form-group">
										<label class="col-xs-4 control-label">Fuel Type:</label>
										<div class="col-xs-8">
											<select class="selectpicker btn-success">
												<option value="15">Gasoline</option><option value="2">Diesel</option><option value="13">Petrol</option>
											</select>
										</div>
									</div>
									<div class="hr-dashed"></div>
									<div class="form-group">
												<label class="col-sm-4 control-label">Price Range:
													<br>
												</label>
												<div class="col-sm-9">
													<div class="checkbox checkbox-info">
														<input type="radio" id="fCheckbox1" name="price-filter">
														<label for="fCheckbox1">
															Rs. 1 LAKH - Rs. 3 LAKH
														</label>
													</div>
													<div class="checkbox checkbox-info">
														<input type="radio" id="fCheckbox2" name="price-filter">
														<label for="fCheckbox2">
															Rs. 3 LAKH - Rs. 5 LAKH
														</label>
													</div>
													<div class="checkbox checkbox-info">
														<input type="radio" id="fCheckbox3" name="price-filter">
														<label for="fCheckbox3">
															Rs. 5 LAKH - Rs. 10 LAKH
														</label>
													</div>
													<div class="checkbox checkbox-info">
														<input type="radio" id="fCheckbox4" name="price-filter">
														<label for="fCheckbox4">
															Rs. 10 LAKH - Rs. 20 LAKH
														</label>
													</div>
													
												</div>
											</div>

									<div class="hr-dashed"></div>
									
											<div class="form-group">
												<label class="col-sm-4 control-label">Body Type:
													<br>
												</label>
												<div class="col-sm-9">
													<div class="checkbox checkbox-info">
														<input type="radio" id="bCheckbox1" name="price-filter">
														<label for="bCheckbox1">
															Sedan <span class="text-warning">(12)</span>
														</label>
													</div>
													<div class="checkbox checkbox-info">
														<input type="radio" id="bCheckbox2" name="price-filter">
														<label for="bCheckbox2">
															Hatchback <span class="text-warning">(7)</span>
														</label>
													</div>
													<div class="checkbox checkbox-info">
														<input type="radio" id="bCheckbox3" name="price-filter">
														<label for="bCheckbox3">
															Suv <span class="text-warning">(112)</span>
														</label>
													</div>
													<div class="checkbox checkbox-info">
														<input type="radio" id="bCheckbox4" name="price-filter">
														<label for="bCheckbox4">
															Coupe <span class="text-warning">(73)</span>
														</label>
													</div>
													
												</div>
											</div>
											</form>
									</div>
								</div>
							</div>

							</div>
						</div>

					</div>
				
				
				<div class="row">
					<div class="clearfix pt pb">
						<div class="col-md-12">
							<em>Designed by <a href="#">Falconnect</a></em>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

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

</body>

</html>