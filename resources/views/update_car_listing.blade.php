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
	<link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap-social.css')}}">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap-select.css')}}">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="{{URL::asset('')}}css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="{{URL::asset('css/awesome-bootstrap-checkbox.css')}}">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="{{URL::asset('css/style.css')}}">

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	@include('header')
	<div class="ts-main-content">
		@include('sidebar')
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="content-header col-xs-12">
        				 <div class="input-group mb searching col-xs-6"><span class="input-group-addon"><i class="fa fa-search"></i></span>
							<input type="text" class="form-control" placeholder="Search here..." >
						 </div>
				          <ol class="breadcrumb">
				            <li><a href="{{url('index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
				            <li class="active">Add List</li>
				          </ol>
        			</div>
					<div class="col-md-12">
						<h2 class="page-title"><span class="detail-title1">Add Your Products</span></h2>
						<form method="post" action="{{url('edit_car_listing')}}">
						<input type="hidden" name="id" value="{{$update->car_id}}">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="panel-group add-list" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
        							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Engine</a>
     							 	</h4>
								</div>
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<div class="col-sm-3">	
                               			<div class="form-group">
											<input type="text" value="{{$update->mileage}}" name="mileage" class="form-control" placeholder="Mileage">
										</div>    
									</div>
									<div class="col-sm-3">	
                              			<div class="form-group">
											<input type="text" name="transmission" value="{{$update->transmission}}" class="form-control" placeholder="Transmission">
										</div>
								    </div>
									<div class="col-sm-3">	
                              			<div class="form-group">
											<input type="text" value="{{$update->engine_displacement}}" name="engine_displacement" class="form-control" placeholder="Engine Displacement">
										</div>
								    </div>
									<div class="col-sm-3">	
                               			<div class="form-group">
											<input type="text" value="{{$update->kilometer_run}}" name="kilometer_run" class="form-control" placeholder="Kms Run">
										</div>
									</div>
									<div class="col-sm-3">	
                              			<div class="form-group">
											<input type="text" value="{{$update->days_to_sell}}" class="form-control" name="days_to_sell" placeholder="Days to sell">
										</div> 
									</div>
									<div class="col-sm-3">	
                               			<div class="form-group">
											<input type="text" value="{{$update->vin}}" class="form-control" name="vin" placeholder="Vin">
										</div>
									</div>
									<div class="col-sm-3">	
                               			<div class="form-group">
											<select class="form-control" name="seatingcapacity">
												<option>Seating Capacity</option>
												<option>8</option>
												<option>9</option>
												<option>6</option>
												<option>4</option>
											</select>
										</div> 
									</div>
									<div class="col-sm-3">	
                              			 <div class="form-group">
											<select class="form-control" value="{{$update->status}}" name="status">
												<option>Car Status</option>
												<option>Good</option>
												<option>Medium</option>
												<option>Excellent</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<input type="text" name="peak_power" class="form-control" value="{{$update->peak_power}}" placeholder="Peak Power">
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<input type="text" name="peaktorque" value="{{$update->peaktorque}}" class="form-control" placeholder="Peak Torque">
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<input type="text" value="{{$update->steering_adjustment}}" name="steering_adjustment" class="form-control" placeholder="Steering Adjustment">
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->body_type}}" name="body_type">
												<option>Body Type</option>
												<option>Sedan</option>
												<option>Hatchback</option>
												<option>Suv</option>
												<option>Coupe</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<input type="text" value="{{$update->fuel_capacity}}" name="fuel_capacity" class="form-control" placeholder="Fuel Capacity">
									</div>     </div>
											<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->registration_year}}" name="registration_year">
												<option>Registration Year</option>
												<option>2012</option>
												<option>2011</option>
												<option>2010</option>
												<option>2009</option>
												<option>2008</option>
											</select>
									</div>     </div>      
<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->make}}" name="make">
												<option>Make</option>
												<option>Renault</option>
												<option>Audi</option>
												<option>BMW</option>
											</select>
									</div>     </div>   
<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->model}}" name="model">
												<option>Model</option>
												<option>Duster</option>
												<option>Captur</option>
												<option>Lodgy</option>
											</select>
									</div>     </div>   
<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->variant}}" name="variant">
												<option>Variant</option>
												<option>First Edition</option>
												<option>Prestige</option>
											</select>
									</div>     </div>   
<div class="col-sm-3">	
                               <div class="form-group">
										<input type="text" value="place" class="form-control" name="place" placeholder="Place">
									</div>     </div>      
<div class="col-sm-3">	
                               <div class="form-group">
										<input type="text" class="form-control" value="kms_done" name="kms_done" placeholder="Kms Done">
									</div>     </div>   
<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->colors}}" name="colors">
												<option>Color</option>
												<option>Gray</option>
												<option>Green</option>
												<option>Lavender</option>
											</select>
									</div>     </div>   
<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->owner_type}}" name="owner_type">
												<option>Ownership</option>
												<option>First Owner</option>
												<option>Second Owner</option>
											</select>
									</div>     </div> 
									<div class="col-sm-3">	
                               <div class="form-group">
										<select value="{{$update->air_conditioner}}" class="form-control" name="air_conditioner">
												<option>Air Conditioner</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->central_locking}}" name="central_locking">
												<option>Central Locking</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<select value="{{$update->cd_player}}" class="form-control" name="cd_player">
												<option>CD Player</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->power_steering}}" name="power_steering">
												<option>Power Steering</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->power_windows}}" name="power_windows">
												<option>Power Windows</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">	
                               <div class="form-group">
										<select class="form-control" value="{{$update->steering_mounted_controls}}" name="steering_mounted_controls">
												<option>Steering Controls</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">
									 <div class="form-group">
										<select class="form-control" value="{{$update->rear_ac_vent}}" name="rear_ac_vent">
												<option>Rear AC Vent</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">
									 <div class="form-group">
										<select class="form-control" value="{{$update->rear_wiper}}" name="rear_wiper">
												<option>Rear Wiper</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">
									 <div class="form-group">
										<select class="form-control" value="{{$update->leather_seats}}" name="leather_seats">
												<option>Leather Seats</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">
									 <div class="form-group">
										<select class="form-control" value="{{$update->electrically_adjustable_mirrors}}" name="electrically_adjustable_mirrors">
												<option>Electrical mirror</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>
									<div class="col-sm-3">
									 <div class="form-group">
										<select class="form-control" value="{{$update->airbag}}" name="airbag">
												<option>Air bag</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
												</select>
									</div>     </div>

<div class="form-group"><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseTwo"><button class="btn btn-primary pull-right" type="submit">Next</button></a> </div>									
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingTwo">
											<h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseTwo">
          Product Details
        </a>
      </h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
											<div class="panel-body">
											<div class="col-sm-6">
												<div class="form-group">
<label class="col-sm-2 control-label">photo</label>
                <input class="btn btn-primary btn-file" name="" type="file" multiple><br/>
				<img id="myImg" src="img/slider.jpg" class="img-responsive">
				<div class="hr-dashed"></div>
				
              </div></div>
			  <div class="col-sm-6"><h3 class="page-title">Price Range</h3>
			  <div class="form-group">
											<div class="row">
												<div class="col-xs-6">
													<input type="text" value="{{$update->max_exp_price}}" name="max_exp_price" class="form-control" placeholder="Max.Expected Price">
												</div>
												<div class="col-xs-6">
													<input value="{{$update->min_exp_price}}" type="text" name="min_exp_price" class="form-control" placeholder="Min.Expected Price">
												</div>
												
											</div></div>
											<div class="form-group"><textarea name="car_address_1" class="form-control" value="{{$update->car_address_1}}" placeholder="Address1"></textarea></div>
											<div class="form-group"><textarea name="car_address_2" value="{{$update->car_address_2}}" class="form-control" placeholder="Address 2"></textarea></div>
											<div class="form-group"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" title="Continue" aria-expanded="false" aria-controls="collapseThree"><button class="btn btn-primary pull-right" type="submit">Next</button></a></div>
</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingThree">
											<h4 class="panel-title">
					        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
					          Contact Information
					        </a>
					      </h4>
										</div>
										<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
											<div class="panel-body">			
												<div class="col-xs-3">
												<div class="form-group">
													<input type="text" value="{{$update->car_owner_name}}" name="car_owner_name" class="form-control" placeholder="Name">
												</div></div>
												<div class="col-xs-3">
												<div class="form-group">
													<input type="mail" value="{{$update->car_owner_email}}" name="car_owner_email" class="form-control" placeholder="E-mail">
												</div></div>
												<div class="col-xs-3">
												<div class="form-group">
													<input type="tel" value="{{$update->car_owner_mobile}}" name="car_owner_mobile" class="form-control" placeholder="Mobile Number">
												</div></div>
												<div class="col-xs-3">
												<div class="form-group">
													<input type="text" value="{{$update->car_locality}}" name="car_locality" class="form-control" placeholder="Location">
												</div></div>
												<div class="col-xs-3">
												<div class="form-group">
													<input type="text" name="car_latitude" class="form-control" value="{{$update->car_latitude}}" placeholder="Latitude">
												</div></div>
												<div class="col-xs-3">
												<div class="form-group">
													<input type="text" value="{{$update->car_longitude}}" name="car_longitude" class="form-control" placeholder="Longitude">
												</div>
												</div>
											<div class="form-group"><a class="collapsed" role="button" data-toggle="tooltip"><button class="btn btn-primary pull-right" type="submit">Submit</button></a></div>
			 
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
		</div>
	</div>
<!--<div class="container-fluid">
<div class="row dash-footer">
					<div class="clearfix pt pb">
						<div class="col-md-12">
							<em>Designed by <a href="#">Falconnect</a></em>
						</div>
					</div>
				</div></div>-->
	<!-- Loading Scripts -->
	<script src="{{URL::asset('js/jquery.min.js')}}"></script>
	<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
	<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('js/Chart.min.js')}}"></script>
	<script src="{{URL::asset('js/fileinput.js')}}"></script>
	<script src="{{URL::asset('js/chartData.js')}}"></script>
	<script src="{{URL::asset('js/main.js')}}"></script>
	<script src="{{URL::asset('js/upload.js')}}"></script>
	
</body>

</html>