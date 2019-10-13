<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>DealerPlus-ChangePassword</title>
	<link rel='shortcut icon' href='img/dealerplus_fav.ico' type='image/x-icon'/ >

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
		    #changepassword label.error{
		    		color:red;
		    	}
		    #changepassword input.error{
		    		border: 1px solid red;
		    	}
			/*.error {
				    	border: 1px solid red;
					}*/
	</style>

</head>

<body>
	<div class="home-brand clearfix">
		<a href="index.html" class="logo"><img src="{{URL::asset('img/logo.png')}}" class="img-responsive" alt=""></a>
		<!--<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li><a href="#"><i class="fa fa-lock"></i> Login</a></li>
			<li><a href="#"><i class="fa fa-user-plus"></i> Register</a></li>
			</ul>-->
	</div>
	<div class="login-page bk-img" style="background-color: #333;background-size:cover;">
		<div class="form-content">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
					@if (session('message'))
    					<div class="alert alert-danger" id="err_msg">
        					{{ session('message') }}
        					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    					</div>
					@endif
						<h1 class="text-center text-bold text-light mt-4x">Set Your Password</h1>
						<div class="well row pt-2x pb-3x bk-light mb-4x">
						
							<div class="col-md-8 col-md-offset-2">
								<form id="changepassword" action="{{url('changepasswordprocess')}}" method="POST" class="mt">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<label for="" class="text-uppercase text-sm">Change Password</label>
									<input type="password" name="changepassword" maxlength="16" placeholder="New Password" class="form-control mb data-password">
									<br/>
									<label for="" class="text-uppercase text-sm">Confirm Password</label>
									<input type="password" name="confirmpassword" maxlength="16" placeholder="Confirm Password" class="form-control mb data-password">

																		
									<button class="btn btn-primary btn-block" type="submit">Submit</button>
									

								</form>
								</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	 @include('login_footer')
	<!-- Loading Scripts -->
	<script src="{{URL::asset('js/jquery.min.js')}}"></script>
	<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
	<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('js/fileinput.js')}}"></script>
	<script src="{{URL::asset('js/jquery.validate.js')}}"></script>
	<script src="{{URL::asset('js/jquery.validate.min.js')}}"></script>
	<script src="{{URL::asset('js/dealerplus.js')}}"></script>

<script type="text/javascript">
	$("document").ready(function(){
			$("#changepassword").validate({
				rules:{
					'changepassword':{
						required:true,
						minlength: 8,
                		maxlength: 16,
						
					},
					'confirmpassword':{
						required:true,
						minlength: 8,
                		maxlength: 16,		
					}
				},
				messages:{
					'changepassword':{
						required:"Password must contain 8-16 characters long.",
					},
					'confirmpassword':{
						required:"Password must contain 8-16 characters long."
					}
				}
				/*highlight: function(input) {
            		$(input).addClass('error');
        		},errorPlacement: function(error, element){}*/
		});
	});
</script>


<!-- <script type="text/javascript">
	$(document.ready(function(){
			alert("hi");
	});
</script> -->

</body>
</html>