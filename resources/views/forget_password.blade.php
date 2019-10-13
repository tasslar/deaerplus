<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>DealerPlus-Forget Password</title>
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
		    #forgetpassword label.error{
		    		color:red;
		    	}
		    #forgetpassword input.error{
		    		border: 1px solid red;
		    	}
			/*.error {
				    	border: 1px solid red;
					}*/
	</style>

</head>

<body>
	<div class="home-brand clearfix">
		<a href="<?=URL::to('http://www.dealerplus.in/index.html')?>"><img src=" {{URL::asset('img/logo.png')}}" alt="Logo" title="Logo" class="img-responsive guestlogo" width="250"/></a>
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
						
						<div class="well row pt-2x pb-3x bk-light mb-4x mt-4x">
						
							<div class="col-md-8 col-md-offset-2">
							 <div class="alert alert-danger" id="msg_err" style="display: none;">
                        		</div>
								@if (Session::has('message'))
								 <div class="flash-message">
			  						<div class="alert alert-danger" id="ses_msg">{{ Session::get('message') }}
			  						<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			  						</div>
			  					  </div>
								{{Session::forget('message')}}
								@endif

							<h2 class="page-title">Password Assistance</h2>
								<p>Enter the email address associated with your DMS account.</p>
								<form id="forgetpassword" method="post" action="{{url('forgetpasswordprocess')}}" class="mt">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<label for="" class="text-uppercase text-sm">Enter your Mail id</label>
									<input type="mail" id="mailid" name="mailid" placeholder="Mail Id" class="form-control mb">
									<button class="btn btn-primary btn-block" id="forget" type="submit">Submit</button>

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
	<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('js/Chart.min.js')}}"></script>
	<script src="{{URL::asset('js/fileinput.js')}}"></script>
	<script src="{{URL::asset('js/chartData.js')}}"></script>
	<script src="{{URL::asset('js/main.js')}}"></script>
	<script src="{{URL::asset('js/jquery.validate.js')}}"></script>
	<script src="{{URL::asset('js/jquery.validate.min.js')}}"></script>
	<script src="{{URL::asset('js/additional-methods.min.js')}}"></script>
	<script type="text/javascript">
	$("document").ready(function(){
			/*$("#forgetpassword").validate({
				rules:{
					'mailid':{
						required:true,
						email:true,
					}
					
				},
				messages:{
					'mailid':{
						required:"Enter valid email id.",
					}
					
				}
				
		});*/

			$("#forget").click(function(){

				if($("#mailid").val()=="")
				{
					$("#msg_err").html("Enter Valid Email Id."+'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').show(function(){
						$("#msg_err").delay(2000).hide(500)
					});
					return false;
				}
				if($("#mailid").val()=="" && $("#ses_msg").html()!="")
				{
					
					$("#ses_msg").show(function(){
						$("#ses_msg").delay(2000).hide(500)
					});

				}
				else
				{
					$("#forgetpassword").submit();
				}	

			});
			
	});
</script>



</body>

</html>