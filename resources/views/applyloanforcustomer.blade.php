@include('header')
@include('sidebar')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="content-header col-sm-12">
                <div class="row top-search" id="search-slide">
                    <div class="input-group-btn search-panel">
                        <select class="col-xs-12 col-sm-12 btn btn-primary">
                            <option value="">Filter</option>
                            <option value="1">Inventory</option>
                            <option value="2">Customer</option>
                            <option value="3">Dealers</option>
                            <option value="4">Cars</option>
                        </select>
                    </div>
                    <input type="hidden" name="search_param" value="all" class="" id="search_param">         
                    <input type="text" class="form-control" name="x" placeholder="Search term...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span></div>
                <ol class="breadcrumb">
                    <li><a href="{{url('viewloan')}}"><i class="fa fa-dashboard"></i> Loan</a></li>
                    <li class="active">Apply Loan For Customer</li>
                </ol>
            </div>
            <div class="col-xs-12">
                <h2 class="page-title">Apply Loan For Customer</h2>
                <div class="hr-dashed"></div>
                <div class="row">
					<div class="alert alert-danger errormessage" style="display:none">
                    </div>
				<form id="loanapplyregister">
                    <div class="col-md-12" id="no-more-tables">
                        <div class="row">
                                @if(!empty($compact_array['dealerdetails']) && count($compact_array['dealerdetails']) >= 0)
                                @foreach($compact_array['dealerdetails'] as $dealerdata)
                                <div class="col-xs-12">
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Customer Name</label>
                                            <select class="form-control customername" name="customername" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Select Customer Name">
                                                <option value="">Select Customer</option>
                                                @if(!empty($compact_array['customername']))
                                                @foreach($compact_array['customername'] as $key=>$value)
                                                <option value = "{{$value->contact_management_id}}" customermobile="{{($value->contact_phone_1 ==! '')?$value->contact_phone_1:''}}" customeremailid="{{($value->contact_email_1 ==! '')?$value->contact_email_1:''}}" pancard="{{($value->pan_number ==! "")?$value->pan_number:''}}">{{$value->contact_first_name}},{{$value->contact_phone_1}},{{$value->contact_email_1}}</option>   
                                                @endforeach
                                                @endif
                                            </select>
                                            <!--<div class="input-group">
                                                <span data-toggle="modal" data-target="#popup" title="Chooce customer" class="input-group-addon btn btn-primary">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            </div>-->
                                        </div></div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Mobile Number</label>
                                            <input type="text" name="mobilenumber" class="form-control" data-validation="required,length" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="2-11" maxlength="11" data-validation-error-msg="Mobilenumber" value="" placeholder="Mobile Number" readonly>
                                        </div></div>

                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Email Id</label>
                                            <input type="mail" name="emailid" class="form-control" data-validation="email" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max35" maxlength="35" data-validation-error-msg="Emailid" value="" placeholder="Email Id" readonly>
                                        </div></div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Pan Number</label>
                                            <input type="text" name="pannumber" class="form-control data-name" data-validation="alphanumeric"  data-validation-optional="true"   data-validation-error-msg="Please Enter Pan Number" value="" placeholder="Pan Number" maxlength="10">
                                        </div></div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="input-group date field-wrapper1 datetimepickerfund">
                                            <label class="">Date</label>
                                            <input type="text" name="date" class="form-control datepicker"  placeholder="Date" readonly>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>City <span><a class="clearcites"></a></span></label>
                                            <select class="form-control place cityselect" name="place" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Select Your City">
                                                <option value="">Select City</option>
                                                @if(!empty($compact_array['dealercityname']))
                                                @foreach($compact_array['dealercityname'] as $key=>$value)
                                                <option value = "{{$value->city_id}}">{{$value->city_name}}</option> 
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group field-wrapper1">
                                            <label>Branch</label>
                                            <select class="form-control branch" name="branch" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Select Your Branch">
                                                <option value="">Select Branch</option>
                                                @if(isset($branch))
                                                @foreach($branch as $key=>$value)
                                                <option value = "{{$value->branch_id}}" data-branchname="{{$value->dealer_name}}">{{$value->dealer_name}}</option>   
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        <div class="card col-xs-12">
                            <div class="col-sm-6 col-xs-10"><div class="input-group">
                                    <input type="text" name="searchcar" class="form-control searchcaritems" placeholder="Enter Make | Model | Variant" disabled>
                                    <span data-toggle="modal" data-target="" title="Chooce Cars" class="input-group-addon btn btn-primary car_list" disabled>
                                        <i id="seticon" class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-3 col-xs-12"><div class="input-group">
                                    <span class="input-group-addon">
                                        Total Rs.
                                    </span>
                                    <input type="text" name="fundingamount" class="form-control data-number fundingamount" data-validation="required,length" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="1-16"  data-validation-error-msg="Your Loan amount is required">
                                </div></div>
                            <div class="col-sm-2 col-xs-12"><button class="btn btn-primary col-xs-12">Apply Loan</button></div>
                        </div>
                        <div class="card1 col-xs-12">
                            <div class=" col-xs-12 col-sm-6">
                            <ul class="auto-select col-xs-12 appendsearchcar">
                            </div></div>
                        <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                            <tbody class="fundinglistmainpage">
                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--popup-->
<div class="modal fade" id="car_list" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Select Cars</h4>
            </div>
            <form name="fundingform" id="submitform">
                <input type="hidden" name="branch" value="" class="btn btn-primary branchname">
                <div class="modal-body">
					<div class="row"><br/>
						<div class="col-sm-4 searchcarname"></div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control modalvalue" placeholder="Search here"  data-validation-optional="true" maxlength="15" data-validation-error-msg="Please Enter data">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-search searchcarmodel"></span>
                                    </span>
                                </div>
							</div>
					</div><br/>
                    <div class="row">
                        <table id="zctb" class="display table inventory-table car-fund" cellspacing="0" width="100%">
                            <tbody class="tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-6">
                            <input type="submit" name="addfunding" value="Ok" class="btn btn-primary addfundbutton"></button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- delete listing popup -->
<div class="modal fade" id="funddeleteresult" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are you sure to delete this Car?</h4>
            </div>
            <form name="fundingform" id="submitform">
                <div class="modal-body">
                    <span class="successdelete"></span>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default deleteyes" value="Yes">
                    <button type="button" class="btn btn-default deleteno" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('footer')
<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
<script src="js/dealerplus.js"></script>
<script src="js/label-slide.js" type="text/javascript"></script>
<script>	
        
    
$(document).ready(function ()
{
    $(function () {
         $('.datetimepickerfund').datetimepicker("setDate", new Date());
         $('.datetimepickerfund').datetimepicker("setEndDate", new Date());
         $('.datetimepickerfund').datetimepicker("setStartDate", new Date());
           });
    $(".btn-adding").click(function () {
		$(this).parent().parent().hide();
	});
	$("body").on('keyup', '.searchcaritems', function () {
		var searchvalue 	=	$(this).val();
		if(searchvalue != "")
		{
			$(".car_list").attr('title','Search Car');
			$("#seticon").attr('class','fa fa-search');
			$("#seticon").addClass('lookupcaritmes');
			$(".car_list").attr('data-target', '');
		}
		else
		{
			$(".car_list").attr('data-target', '#car_list');
			$("#seticon").attr('class','fa fa-eye');
			$("#seticon").removeClass('lookupcaritmes');
		}
	});	

	$("body").on('change', '.customername', function () {
		var pannumber 	= 	$('option:selected', this).attr('pancard');
		var mobnumber 	= 	$('option:selected', this).attr('customermobile');
		var emailid 	= 	$('option:selected', this).attr('customeremailid');
		$('[name="pannumber"]').val(pannumber);
		$('[name="mobilenumber"]').val(mobnumber);
		$('[name="emailid"]').val(emailid);
	});
	
	var appendcar	=	[];
	$("body").on('click', '.clearcites', function () {
		$("[name='place']").removeAttr('disabled', 'disabled');
		$("[name='place']").val('');
		$(this).text('');
		$("[name='branch']").val('');
		$(".fundingamount").val('');
		$(".fundinglistmainpage").empty();
		$(".appendsearchcar").empty();
		$(".tbody").empty();
		appendcar.length	=	0;
		$(".car_list").attr('disabled', true);
		$(".searchcaritems").attr('disabled', true);
		$(".car_list").attr('data-target', '');
		$(".errormessage").css("display", "none");
	});
	
	$("body").on('click', '.removecaritmes', function () {
		$(".appendsearchcar").empty();
	});
	
	$("body").on('click', '.showallerror', function () {
		$(".errormessage").css("display", "none");
	});

	//GET CAR DETAILS WHEN CHANGE PLACE ELEMENT
	$("body").on('change', '.cityselect', function () {
		var city_id 		= 	$('[name="place"]').val();
		var branch 			= 	$('[name="branch"]').val();
		var customername 	= 	$('[name="customername"]').val();
		var typeofrequest 	= 	"Loanpage";
		var csrf_token = $('#token').val();
		var i = 0;
		if (city_id == "")
		{
			$('[name="branch"]').val('');
			$(".searchcaritems").val('');
			return false;
		} else
		{
			//$("[name='place']").attr('disabled', 'disabled');
		}
		$("#loadspinner").css("display", "block");
		$(".errormessage").css("display", "none");
		$(".tbody").empty();
		$('[name="branch"]').empty();
		$(".car_list").attr('disabled', true);
		$(".searchcaritems").attr('disabled', true);
		$(".car_list").attr('data-target', '');
		$.ajax({
			url: "{{url('dofetch_cardetails')}}",
			type: 'post',
			dataType: 'json',
			data: {_token: csrf_token, city_id: city_id, branch: branch,typeofrequest:typeofrequest,customerid:customername},
			success: function (response)
			{
				if (response.result == "No Car Founds")
				{
					$(".tbody").html('<tr><td class="col-md-12 alert alert-danger"><h3><center>' + response.result + '</center></h3></td></tr>');
					$(".car_list").removeAttr('disabled');
					$(".car_list").attr('data-target', '#car_list');
					$("#loadspinner").css("display", "none");
					$(".addfundbutton").hide();
				} else
				{
					$('[name="branch"]').append($('<option>', {value: '', text: 'Select Branch'}));
					$.each(response.branch, function (arrayID, group) {
						$('[name="branch"]').append($('<option>', {value: group.branch_id, branchname: group.dealer_name, text: group.dealer_name}));
					});

					/*$.each(response.carmodel, function (arrayID, group) {
					 $(".tbody").append('<tr><td class="col-sm-1"><div class="radibox radiobox-info"><input type="radio" id="bCheckbox'+i+'" class="fundingcheck" name="carid[]" value="' + group.car_id + '"><label for="bCheckbox'+i+'"></label></div></td><td class="col-sm-3"><img src="' + group.image + '" alt="" class="img-responsive table-img"/></td><td class="col-sm-8"><h4>' + group.make + ',' + group.model + ',' + group.varient + ',' + group.registration_year + '</h4><h5>Rs.' + group.price + '</h5><p class="list-detail"><span class="text-muted">' + group.kms_done + 'km</span> | <span class="text-muted">' + group.fuel_type + '</span> | <span class="text-muted">' + group.registration_year + '</span> | <span class="text-muted">' + group.owner_type + ' Owners</span></p></td></tr>');
					 i++;
					 });*/
					//$(".car_list").removeAttr('disabled');
					//$(".car_list").attr('data-target', '#car_list');
					$("#loadspinner").css("display", "none");
					$(".addfundbutton").show();
				}
			},
			error: function (e)
			{
				//console.log(e.responseText);
			}
		});
	});


	//GET CAR DETAILS WHEN CHANGE BRANCH ELEMENT
	$("body").on('change', '[name="branch"]', function () {
		var city_id 		= 	$('[name="place"]').val();
		var branch 			= 	$(this).val();
		var branchname 		= 	$('option:selected', this).attr('branchname');
		var customername 	= 	$('[name="customername"]').val();
		var typeofrequest 	= 	"Loanpage";
		$(".branchname").val(branchname);
		if (branch == "" || city_id == "")
			{
				$(this).val('');
				$(".searchcaritems").val('');
				return false;
			}
			var appendid 				= 	0;
			$('.fundinglistmainpage').find('input[type=hidden]').each(function(){
					appendcar[appendid++]	=	$(this).val();
			});
			appendcar				=	$.unique(appendcar);
		var csrf_token = $('#token').val();
		$(".tbody").empty();
		$(".car_list").attr('disabled', true);
		$(".searchcaritems").attr('disabled', true);
		$(".searchcaritems").val('');
		$(".appendsearchcar").empty();
		$(".car_list").attr('data-target', '');
		$("#loadspinner").css("display", "block");
		$(".errormessage").css("display", "none");
		$.ajax({
			url: "{{url('dofetch_cardetails')}}",
			type: 'post',
			dataType: 'json',
			data: {_token: csrf_token, city_id: city_id, branch: branch,appendcar:appendcar,typeofrequest:typeofrequest,customerid:customername},
			success: function (response)
			{
				if (response.result == "No Car Founds")
				{
					$(".searchcarname").html('');
					$(".tbody").html('<tr><td class="col-md-12 alert alert-danger"><h3><center>' + response.result + '</center></h3></td></tr>');
					$(".car_list").removeAttr('disabled');
					$(".searchcaritems").removeAttr('disabled');
					$(".car_list").attr('data-target', '#car_list');
					$("#loadspinner").css("display", "none");
					$(".addfundbutton").hide();
				} else
				{
					$(".searchcarname").html('');
					$(".searchcaritems").val('');
					$.each(response.carmodel, function (arrayID, group) {
						$(".tbody").append('<tr><td class="col-sm-1"><div class="radio radio-primary radio-inline"><input type="radio" class="fundingcheck" name="carid[]" value="' + group.car_id + '"><label for="car1"></label></div></td><td class="col-sm-3"><img src="' + group.image + '" alt="" class="img-responsive table-img"/></td><td class="col-sm-8"><h4>' + group.model + ' ' + group.varient + ' ' + group.registration_year + '</h4><h5>Rs.' + group.price + '</h5><p class="list-detail"><span class="text-muted">' + group.kms_done + 'km</span> | <span class="text-muted">' + group.fuel_type + '</span> | <span class="text-muted">' + group.registration_year + '</span> | <span class="text-muted">' + group.owner_type + ' Owner</span></p></td></tr>');
					});
					$(".car_list").removeAttr('disabled');
					$(".searchcaritems").removeAttr('disabled');
					$(".car_list").attr('data-target', '#car_list');
					$("#loadspinner").css("display", "none");
					$(".addfundbutton").show();
				}
			},
			error: function (e)
			{
				//console.log(e.responseText);
			}
		});
	});
	
	//delete car list from appended value
	var getrow;
	var fundingamount = 0;
	var getcurrentfundingammount;
	$("body").on('click', '.currentprice', function () {
		getrow = $(this).closest('tr');
		getcurrentfundingammount = $(this).data('currentprice');
		$('#funddeleteresult').modal({
			show: 'true'
		});
	});
	
	var searchcar;
	//delete particular car
	$("body").on("click", ".deleteyes", function () {
		$(getrow).remove();
		$(".fundingamount").val(0);
		$('#funddeleteresult').modal("hide");
		var append = 0;
		$('.fundinglistmainpage').find('input[type=hidden]').each(function(){
				appendcar[append++]	=	$(this).val();
		});
		if($(".tbody").empty())
		{
			appendcar.length 	=	0;
			$('[name="fundingamount"]').attr('data-validation-error-msg','Your Loan amount is required');
		}
	});
	
	$("body").on('click', '.lookupcaritmes,.searchcarmodel', function () {
		var city_id 			= 	$('[name="place"]').val();
		var branch 				= 	$('[name="branch"]').val();
		var append = 0;
		$('.fundinglistmainpage').find('input[type=hidden]').each(function(){
				appendcar[append++]	=	$(this).val();
		});
		var typeofrequest 		= 	"Loanpage";
		appendcar				=	$.unique(appendcar);
		var branchname 			= 	$('option:selected', '[name="branch"]').attr('branchname');
		var searchvalue 		=	$('.searchcaritems').val();
		var popupsearchvalue	=	$('.modalvalue').val();
		var customername 		= 	$('[name="customername"]').val();
		if(searchvalue	==	"")
		{
			searchcar	=	popupsearchvalue;
		}
		if(popupsearchvalue	==	"")
		{
			searchcar	=	searchvalue;
		}
		$(".branchname").val(branchname);
		if (branch == "" || city_id == "")
		{
			$(this).val('');
			return false;
		}
		var csrf_token = $('#token').val();
		$(".car_list").attr('disabled', true);
		$(".searchcaritems").attr('disabled', true);
		$(".searchcaritems").val('');
		$(".car_list").attr('data-target', '');
		$("#loadspinner").css("display", "block");
		$(".errormessage").css("display", "none");
		$.ajax({
				url: "{{url('dofetch_cardetails')}}",
				type: 'post',
				dataType: 'json',
				data: {_token: csrf_token, city_id: city_id, branch: branch,searchcar:searchcar,appendcar:appendcar,typeofrequest:typeofrequest,customerid:customername},
				success: function (response)
				{
					if (response.result == "No Car Founds")
					{
						$(".tbody").empty();
						$(".searchcarname").html('Search for '+searchcar);
						$(".tbody").html('<tr><td class="col-md-12 alert alert-danger"><h3><center>' + response.result + '</center></h3></td></tr>');
						$(".car_list").removeAttr('disabled');
						$(".searchcaritems").removeAttr('disabled');
						$(".car_list").attr('data-target', '#car_list');
						$("#loadspinner").css("display", "none");
						$(".addfundbutton").hide();
						$("#seticon").attr('class','fa fa-eye');
						$('.modalvalue').val('');
					} else
					{
						$(".tbody").empty();
						$(".searchcarname").html('Search for '+searchcar);
						$.each(response.carmodel, function (arrayID, group) {
							$(".tbody").append('<tr><td class="col-sm-1"><div class="radio radio-primary radio-inline"><input type="radio" class="fundingcheck" name="carid[]" value="' + group.car_id + '"><label for="car1"></label></div></td><td class="col-sm-3"><img src="' + group.image + '" alt="" class="img-responsive table-img"/></td><td class="col-sm-8"><h4>' + group.model + ' ' + group.varient + ' ' + group.registration_year + '</h4><h5>Rs.' + group.price + '</h5><p class="list-detail"><span class="text-muted">' + group.kms_done + 'km</span> | <span class="text-muted">' + group.fuel_type + '</span> | <span class="text-muted">' + group.registration_year + '</span> | <span class="text-muted">' + group.owner_type + ' Owner</span></p></td></tr>');
						});
						$(".car_list").removeAttr('disabled');
						$(".searchcaritems").removeAttr('disabled');
						$(".car_list").attr('data-target', '#car_list');
						$("#loadspinner").css("display", "none");
						$(".addfundbutton").show();
						$("#seticon").attr('class','fa fa-eye');
						$('.modalvalue').val('');
					}
				},
				error: function (e)
				{
					//console.log(e.responseText);
				}
		});
	});


	//ADD CAR DETAILS SAME PAGE FROM POPUP DATA
	$("body").on('submit', '#submitform', function (fundevent) {
		fundevent.preventDefault();
		var car_id 			= 	$('[name="carid"]').val();
		var checkfndingadd 	= 	$(".fundingcheck").is(":checked");
		if (checkfndingadd == false)
		{
			//alert("Select any one Car to Add Funding");
			return false;
		}
		if (car_id == "")
		{
			return false;
		}
		$("#loadspinner").css("display", "block");
		$(".errormessage").css("display", "none");
		$.ajax({
			url: "{{url('doAddfundingcar')}}",
			type: 'post',
			dataType: 'json',
			data: $(this).serialize(),
			success: function (response)
			{
				if (response.result == "No Cars Added")
				{
					$(".fundinglistmainpage").empty();
					$(".fundinglistmainpage").html('<tr><td class="col-md-12 alert alert-danger"><h3><center>' + response.result + '</center></h3></td></tr>');
					$("#loadspinner").css("display", "none");
					$('.fade').modal('hide');
					$(".car_list").removeAttr('disabled');
					$(".searchcaritems").removeAttr('disabled');
					$(".car_list").attr('data-target', '#car_list');
				} else {
					$(".fundinglistmainpage").empty();
					$(".searchcaritems").val('');
					$.each(response, function (arrayID, group) {
						$(".fundingamount").val(group.price);
						$(".fundinglistmainpage").append('<tr><input type="hidden" class="currentprice" name="carid[]" value="' + group.car_id + '"><td class="invent-width"><span class="btn btn-xs btn-adding btn-circle btn-danger currentprice" data-currentprice="' + group.price + '"><i class="fa fa-plus"></i></span></td><td><img src="' + group.image + '" alt="" class="img-responsive table-img"/></td><td><h4>' + group.make + ',' + group.model + ',' + group.varient + ',' + group.registration_year + '</h4><h5>Rs.' + group.price + '</h5><p class="list-detail"><span class="text-muted">' + group.kms_done + ' km</span> | <span class="text-muted">' + group.fuel_type + '</span> | <span class="text-muted">' + group.registration_year + '</span> | <span class="text-muted">' +group.owner_type+ ' Owner</span></p></td><td><div>Branch: ' + group.branch + '</div></td><td class=""><div><span><input type="Checkbox" checked=""></span>Document</div></td><td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked><div><span><input type="Checkbox" checked=""></span>Images</div></td></tr>');
						$('table tr').find('.fundingcheck:checked').parents("tr").remove();
						$(".clearcites").html('[Change]');
						var append = 0;
						$('.fundinglistmainpage').find('input[type=hidden]').each(function(){
								appendcar[append++]	=	$(this).val();
						});
					});
					$('.fade').modal('hide');
					$("#loadspinner").css("display", "none");
				}
			},
			error: function (e)
			{
				//console.log(e.responseText);
			}
		});
	});
	
	$('[name="fundingamount"]').keyup(function () { 
    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	var validateamount 	=	"";
	//APPLY LOAN FINAL REGISTER
	$("body").on('submit', '#loanapplyregister', function (fundevent) {
		fundevent.preventDefault();
		if(appendcar.length == 0)
		{
			alert("Add minimum one car for Apply Loan");
			return false;
		}
		var checkamount = 0;
		$('.fundinglistmainpage').find('tr td span.currentprice').each(function(){
				validateamount	=	$(this).data('currentprice');
		});
		var fundingamountvalue 	=	$('[name="fundingamount"]').val();
		if(validateamount >= fundingamountvalue)
		{
			
		}
		else
		{
			var stylecolor 		=	"border-color: rgb(185, 74, 72);";
			var errormessage 	=	"Please enter value less than or equal to Rs."+validateamount+"";
			$('[name="fundingamount"]').removeClass('valid');
			$('[name="fundingamount"]').parent().closest('div').removeClass('has-success');
			$('[name="fundingamount"]').parent().closest('div').addClass('has-error');
			$('[name="fundingamount"]').addClass('error');
			$('[name="fundingamount"]').attr('data-validation-error-msg',errormessage);
			$('[name="fundingamount"]').attr('style',stylecolor);
			$('[name="fundingamount"]').after('<span class="help-block form-error">Please enter value less than or equal to Rs.'+validateamount+'</span>');
			return false;
		}
		var valamount = parseFloat($('[name="fundingamount"]').val());
		if (isNaN(valamount) || (valamount === 0))
		{
			var stylecolor 		=	"border-color: rgb(185, 74, 72);";
			var errormessage 	=	"Please enter valid amount";
			$('[name="fundingamount"]').removeClass('valid');
			$('[name="fundingamount"]').parent().closest('div').removeClass('has-success');
			$('[name="fundingamount"]').parent().closest('div').addClass('has-error');
			$('[name="fundingamount"]').addClass('error');
			$('[name="fundingamount"]').attr('data-validation-error-msg',errormessage);
			$('[name="fundingamount"]').attr('style',stylecolor);
			$('[name="fundingamount"]').after('<span class="help-block form-error">Please enter valid amount</span>');
			return false;
		}
		
		$("#loadspinner").css("display", "block");
		$.ajax({
			url: "{{url('applyloanregister')}}",
			type: 'post',
			dataType: 'json',
			data: $(this).serialize(),
			success: function (response)
			{
				if (response.message == "Loan Applied Successfully")
				{
					window.location.href = "{{url('viewloan')}}?Loanid="+response.loanid;
				} else {
					$("#loadspinner").css("display", "none");                
				}
			},
			error: function (e,status,error)
			{
				if(e.status 	==	"400")
				{
					var errorread = $.parseJSON(e.responseText);
					$("#loadspinner").css("display", "none");
					$(".errormessage").css("display", "block");
					$(".errormessage").html("<a href='#' class='close showallerror' aria-label='close'>&times;</a><center>"+errorread.errormsg+"</center>");
				}
				else
				{
					$("#loadspinner").css("display", "none");
					$(".errormessage").css("display", "block");
					$(".errormessage").html("<a href='#' class='close showallerror' aria-label='close'>&times;</a><center>All Fields are required or Invalid data sending...</center>");
				}
			}
		});
	});

	});

/*$("body").on('submit', '#submitformloan', function (fundevent) {
    fundevent.preventDefault();
    var car_id = $('[name="addnewcar"]').val();
    var branch = $('[name="branch"]').val();
    var checkfndingadd = $(".loancheck").is(":checked");
    if (checkfndingadd == false)
    {
        alert("Select any one Car to Add Funding");
        return false;
    }
    if (car_id == "")
    {
        return false;
    }
    $("#loadspinner").css("display", "block");
    $.ajax({
        url: "{{url('doAddfundingcar')}}",
        type: 'post',
        dataType: 'json',
        data: {car_id: car_id, branch: branch},
        success: function (response)
        {
            if (response.result == "No Cars Added")
            {
                $(".fundinglistmainpage").empty();
                $(".fundinglistmainpage").html('<tr><td class="col-md-12 alert alert-danger"><h3><center>' + response.result + '</center></h3></td></tr>');
                $("#loadspinner").css("display", "none");
                $('.fade').modal('hide');
                $(".car_list").removeAttr('disabled');
                $(".searchcaritems").removeAttr('disabled');
                $(".car_list").attr('data-target', '#car_list');
            } else {
                $(".fundinglistmainpage").empty();
                $.each(response, function (arrayID, group) {
                    $(".fundingamount").val(group.price);
                    $(".fundinglistmainpage").append('<tr><td class="invent-width"><button class="btn btn-xs btn-adding btn-circle btn-danger currentprice" data-currentprice="' + group.price + '"><i class="fa fa-plus"></i></button></td><input type="hidden" class="currentprice" name="carid[]" value="' + group.car_id + '"><td><img src="' + group.image + '" alt="" class="img-responsive table-img"/></td><td><h4>' + group.make + ',' + group.model + ',' + group.varient + ',' + group.registration_year + '</h4><h5>Rs.' + group.price + '</h5><p class="list-detail"><span class="text-muted">' + group.kms_done + ' km</span> | <span class="text-muted">' + group.fuel_type + '</span> | <span class="text-muted">' + group.registration_year + '</span> | <span class="text-muted">' + group.owner_type + ' Owners</span></p></td><td><div>' + group.branch + '</div></td><td class=""><div><span><input type="Checkbox" checked=""></span>Document</div></td><td class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked><div><span><input type="Checkbox" checked=""></span>Images</div></td></tr>');
                });
                $('.fade').modal('hide');
                //$(".tbody").empty();
                $("#loadspinner").css("display", "none");
                //$(".car_list").attr('disabled', true);
                //$(".car_list").attr('data-target', '');
                //$(".addfundbutton").hide();
            }
        },
        error: function (e)
        {
            //console.log(e.responseText);
        }
    });
});*/

//SEARCH CAR ITEMS 
	
/*	$("body").on('focusout', '.searchcaritems', function (fundevent) {
		fundevent.preventDefault();
		var car_id 	= 	$('[name="searchcar"]').val();
		var city_id = 	$('[name="place"]').val();
		var branch 	= 	$('[name="branch"]').val();
		if (car_id 	== "")
		{
			$(".appendsearchcar").empty();
			return false;
		}
		$("#loadspinner").css("display", "block");
		$(".appendsearchcar").empty();
		$.ajax({
			url: "{{url('doSearchloancar')}}",
			type: 'post',
			dataType: 'html',
			data: {car_name:car_id,city_id: city_id, branch: branch},
			success: function (response)
			{
				$(".appendsearchcar").append(response);
				$("#loadspinner").css("display", "none");
				/*if (response.result == "No Cars Found")
				{
					$(".fundinglistmainpage").empty();
					$(".appendsearchcar").html('<li><p class="col-md-12"><h3><center>' + response.result + '</center></h3></p></li>');
					$(".appendsearchcar").html();
					$("#loadspinner").css("display", "none");
				} else {
					$(".fundinglistmainpage").empty();
					$.each(response, function (arrayID, group) {
						$(".fundingamount").val(fundingamount);
						$(".appendsearchcar").append('<li class="row"><div class="col-sm-1"><div class="radio radio-primary radio-inline"><input type="radio" name="searchcar" value="'+ group.car_id +'"><label for="car1"></label></div></div><div class="col-sm-3"><img src="' + group.image + '" alt="" class="img-responsive table-img"></div><div class="col-sm-8"><h4>' + group.make + ',' + group.model + ',' + group.varient + ',' + group.registration_year + '</h4><h5>Rs.' + group.price + '</h5><p class="list-detail"><span class="text-muted">' + group.kms_done + ' km</span> | <span class="text-muted">' + group.fuel_type + '</span> | <span class="text-muted">' + group.registration_year + '</span> | <span class="text-muted">' + group.owner_type + ' Owners</span></p></div></li>');
						$("#loadspinner").css("display", "none");
				});
			
			},
			error: function (e)
			{
				console.log(e.responseText);
			}
		});
	});*/
</script>
</body>
</html>           
