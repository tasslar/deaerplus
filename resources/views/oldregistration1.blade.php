<!Doctype html>
<html lang="en" class="no-js">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="description" content="">
<meta name="author" content="">

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
<link rel="stylesheet" href="{{URL::asset('css/fileinput.min.css')}}">
<!-- Awesome Bootstrap checkbox -->
<link rel="stylesheet" href="{{URL::asset('css/awesome-bootstrap-checkbox.css')}}">
<!-- Admin Stye -->
<link rel="stylesheet" href="{{URL::asset('css/style.css')}}">

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
#register label.error{
	color:red;
}
#register input.error{
	border: 1px solid red;
}

</style>

</head>

<body onload="">
<div class="home-brand clearfix">
<a href="index.html" class="logo"><img src="img/logo.png" class="img-responsive" alt=""></a>
<!--<span class="menu-btn"><i class="fa fa-bars"></i></span>
<ul class="ts-profile-nav">
	<li><a href="#"><i class="fa fa-lock"></i> Login</a></li>
	<li><a href="#"><i class="fa fa-user-plus"></i> Register</a></li>
	</ul>-->
</div>
<div class="login-page bk-img" style="background-image: url(img/login-bg.jpg);background-size:cover;">
<div class="form-content">
	<div class="container">
		<div class="row">
		
			<div class="col-md-6 col-md-offset-3">
				<h1 class="text-center text-bold text-light mt-2x">Registration</h1>
				<div class="well row pt-2x pb-3x bk-light">
					<div class="col-md-8 col-md-offset-2">
					<!-- @if($errors->has())
				   	@foreach ($errors->all() as $error)
				      <div class="alert alert-danger">{{ $error }}</div>
				  	@endforeach
					@endif -->

					@if($errors->has('dealer_name'))
					<div class="alert alert-danger">{{ $errors->first('dealer_name') }}</div>
					@endif

					@if($errors->has('d_email'))
					<div class="alert alert-danger">{{ $errors->first('d_email') }}</div>
					@endif

					@if (Session::has('message'))
						<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif

						<form id="register" method="POST" action="store" class="mt">
							<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
							<input type="text" id="dealer_name" name="dealer_name" placeholder="Dealer Company name" class="form-control mb required" maxlength="15">
							<input type="hidden" name="d_fname" placeholder="Name" class="form-control mb required">
							<input type="hidden" name="d_lname" placeholder="Last name" class="form-control mb required">
							<input type="mail" id="d_email" name="d_email" placeholder="Email Id" class="form-control mb required mailclass" required="required">
							<input type="tel" name="d_mobile" placeholder="Contact Number" class="form-control mb required telclass" maxlength="10">
							<input type="hidden" name="d_code" placeholder="Dealer Register Number" class="form-control mb required regnoclass" maxlength="6" >
							<!-- <textarea name="address" id="address" style="resize:none" cols="30" rows="3"  placeholder="Dealer Address" class="form-control mb"></textarea> -->
							<div class="form-group">
							<select class="form-control" name="d_city">
							<option>Select your City</option>
								<?php
									$d_citylist=DB::table('master_city')->get();
                            	foreach ($d_citylist as $city) { 
                            		$d_city=$city->city_id;
								?>
									<option value="<?php echo $d_city;?>"><?php echo $city->city_name;?></option>
								<?php
								 }
								?>											
							</select>
							</div>
							<input type="hidden" name="pincode" placeholder="Pincode" class="form-control mb required pincodeclass" maxlength="6">
							<!-- Plan type -->
							<div class="form-group">
							<div class="row">
							<div class="col-md-6">
							<select class="form-control" id="plan" name="plan">
							<option>Select Plan</option>
								<?php
									$d_planlist=DB::table('master_plans')->get();
                            	foreach ($d_planlist as $plan) { 
                            		$d_plan=$plan->plan_type_id;
								?>
									<option value="<?php echo $d_plan;?>"><?php echo $plan->plan_type_name;?></option>
								<?php
								 }
								?>											
							</select>
							</div>
							<!-- </div> -->
							<!-- Frequency Interval -->
							<!-- <div class="form-group"> -->
							<div class="col-md-6">
							<select class="form-control" id="frequency_list" name="frequency_list">
							<option value="">Select Frequency</option>
							</select>
							</div>
							
							</div>
							</div>
								<input type="text" id="plan_amt" name="plan_amt" class="form-control mb" readonly="readonly">
							

							<button id="submit" class="btn btn-primary btn-block" type="submit">REGISTER NOW</button>
								</form>

									<p>Already Have An Account? <a href="<?=URL::to('/login')?>">Login Now.</a></p>
					</div>
				</div>
				
			</div>
		
		</div>
	</div>
</div>
</div>
<div class="footer">
<div class="container"><p class="text-center pt-2x text-light">Copy Right 2016. Designed by Falconnect</p></div>
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
<!-- <script src="{{URL::asset('js/validation_script.js')}}"></script> -->
<script src="{{URL::asset('js/jquery.validate.js')}}"></script>
<script src="{{URL::asset('js/jquery.validate.min.js')}}"></script>
<script src="{{URL::asset('js/additional-methods.min.js')}}"></script>


<script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyC7Z6np6MylkXw87SIwICHj00EmG-Brtfo" async="" defer="defer" type="text/javascript"></script>

<script type="text/javascript">

$("document").ready(function(){

$("#register").validate({
		rules:{
			'dealer_name':{
				required:true,
				maxlenght:15,
				
			},
			
			'd_email':{
				required:true,
				email: true,
				
			},
			'd_mobile':{
				required:true,
				minlength:10,
				digits: true
			},
					
		},
		messages:{
			'dealer_name':{
				required:"Enter Dealer name.",
			},
			
			'd_email':{
				required:"Enter valid email",
			},
			'd_mobile':{
				required:"Enter valid mobile number",
			},
						
		},
		
		
});



//Plan amount calculation
$('[name="plan"]').change(function(){
		var plan_id=$(this).val();
		var csrf_token=$('#token').val();
		$('[name="frequency_list"]').empty();
		$.ajax({
			url:'frequency_get',
			type:'post',
			data:{_token:csrf_token,plan_id:plan_id},
			success:function(response)
			{
				//console.log(response);
		
				var json = $.parseJSON(response);
				$('[name="frequency_list"]').append($('<option>', {value:'', text:'Select frequency'}));
				$.each(json, function(arrayID,frequency_list) {
				           
				    $('[name="frequency_list"]').append($('<option>', {value:frequency_list.frequency_id, text:frequency_list.frequency_id+' '+frequency_list.frequency_name}));
				});
			},
			error:function(e)
			{
				console.log(e.responseText);
			}
	});

	});
//
$('[name="frequency_list"]').change(function(){
var csrf_token=$('#token').val();
var plan_id = $("#plan").val();
var frequency_id = $(this).val();

$.ajax({
	url:'plan_amount',
	type:'post',
	data:{_token:csrf_token,plan_id:plan_id,frequency_id:frequency_id},
	success:function(response)
	{
		//console.log(response);
		var json = $.parseJSON(response);
		$.each(json, function(arrayID,plan_amount) {
				           
				    /*$('[name="frequency_list"]').append($('<option>', {value:frequency_list.frequency_id, text:frequency_list.frequency_id+' '+frequency_list.frequency_name}));*/
				    $("#plan_amt").val(plan_amount.total_cost);
				});

		

	},
	error:function(response){
		console.log(response.responseText);
	}

});



});


});





</script>
</body>

</html>