

	@include('header')

	<div class="ts-main-content">
		@include('sidebar')
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">My Account</h2>
					
						<div class="panel panel-default">
							@if (Session::has('message'))
   								<div class="alert alert-danger">{{ Session::get('message') }}</div>
							@endif
							<div class="panel-heading">Account Details</div>
							<div class="panel-body">
							<form method="" action="" class="form-horizontal">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group">
										<!-- <label class="col-sm-2 control-label">Name</label> -->
										<div class="col-sm-10">
											<input type="hidden" value="" class="form-control mb" disabled="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Mail Id</label>
										<div class="col-sm-10">
											<input type="mail" value="{{$data['d_email']}}" class="form-control mb" disabled="">
										</div>
									</div>
									<div class="form-group">
												<label class="col-sm-2 control-label">Password</label>
												<div class="col-sm-10">
													<input value="{{$data['d_password']}}" class="form-control" name="password" disabled="">
												</div>
											</div>
									<!-- <div class="hr-dashed"></div> -->
									<!-- <div class="form-group">
												<label class="col-sm-2 control-label">Gender
													<br>
												</label>
												<div class="col-sm-10">
													<div class="checkbox checkbox-inline checkbox-info">
														<input type="radio" id="inlineCheckbox1" value="Male" name="gender" checked disabled="">
														<label for="inlineCheckbox1"><i class="fa fa-male"></i> Male </label>
													</div>
													</div>
											</div> -->
									
									<div class="hr-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Contact Number</label>

										<div class="col-sm-10">
											<div class="input-group mb"><span class="input-group-addon">+91</span>
												<input type="tel" value="{{$data['d_mobile']}}" class="form-control" disabled="">
											</div>
											
										</div>
									</div>

									<div class="hr-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Address</label>

										<div class="col-sm-10">
											<textarea class="form-control" rows="3" disabled="" style="resize:none">{{$data['address']}}</textarea>
										</div>
									</div>
									<div class="hr-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Pincode</label>

										<div class="col-sm-10">
											<input type="text" value="{{$data['pincode']}}" class="form-control" disabled="">
										</div>
									</div>
									
								<div class="hr-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Other Details</label>
										<div class="col-sm-10">
											<textarea class="form-control" rows="3" disabled="" style="resize:none">{{$data['otherinformation']}}</textarea>
										</div>
									</div>
									<div class="hr-dashed"></div>
									<div class="form-group">
									<label class="col-sm-2 control-label">Image</label>
									                <img src="{{$data['logo']}}" alt="" width="100" height="100"/>
									              </div>
              						<!-- <div class="hr-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Select</label>
										<div class="col-sm-10">
											<select class="selectpicker" disabled="">
												<optgroup label="Picnic">
													<option>Mustard</option>
													<option>Ketchup</option>
													<option>Relish</option>
												</optgroup>
												<optgroup label="Camping">
													<option>Tent</option>
													<option>Flashlight</option>
													<option>Toilet Paper</option>
												</optgroup>
											</select>
									</div>
									</div> -->
									<div class="hr-dashed"></div>
									
								</form>

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

</body>

</html>