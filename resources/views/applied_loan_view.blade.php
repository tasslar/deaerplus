
@include('header')
@include('sidebar')            
<div class="content-wrapper">
    <div class="container-fluid footer-fixed">

        <div class="row">
            <div class="content-header col-sm-12">

                <ol class="breadcrumb">
                    <li><a href="{{url('viewfunding')}}"><i class="fa fa-dashboard"></i> Funding</a></li>
                    <li class="active">Loan For Customers</li>
                </ol>
            </div>
            <div class="col-xs-12">
                <h2 class="page-title col-sm-5 col-md-5">Loan For Customers</h2>

                <p class="btn pull-right btn-primary col-xs-12 col-md-2 col-sm-3 add-list" data-toggle="modal" data-target="#calculate"><i class="fa fa-calculator"></i>&nbsp; Calculate EMI</p> 
                <a href="{{url('loanforcustomer')}}" class="btn pull-right btn-primary col-xs-12 col-md-2 col-sm-3 add-list"><i class="fa fa-plus-square"></i>&nbsp; Apply Loans</a>

                <a href="{{url('/export_excel_loan')}}" class="btn pull-right btn-primary col-xs-12 col-md-2 col-sm-3 add-list"><i class="glyphicon glyphicon-export"></i>&nbsp; Export Excel</a>

                <div class="hr-dashed"></div>
                <div class="row">

                    <div class="col-md-12  table-overflow" id="no-more-tables">

                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead class="hidden-xs">
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Mobile</th>
                                    <th>Customer Email</th>
                                    <th>Customer PAN</th>
                                    <th>Vehicle Details</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>City</th>
                                    <th>Branch Name</th>
                                    <th>Ticket Id</th>
                                    <th>Ticket Status</th>
                                    <!--<th>View</th>-->
                                    <!--<th>Cancel</th>-->
                                </tr>
                            </thead>
                            <tfoot class="hidden-xs">
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Mobile</th>
                                    <th>Customer Email</th>
                                    <th>Customer PAN</th>
                                    <th>Vehicle Details</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>City</th>
                                    <th>Branch Name</th>
                                    <th>Ticket Id</th>
                                    <th>Ticket Status</th>
                                    <!--<th>View</th>-->
                                    <!--<th>Cancel</th>-->
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(!empty($compact_array['loandata']))
                                @foreach($compact_array['loandata'] as $fetch)
                                <tr>
                                    <td data-title="Customer Name">{{$fetch->customername}}</td>
                                    <td data-title="Customer Mobile">{{$fetch->customermobileno}}</td>
                                    <td data-title="Customer Mail">{{$fetch->customermailid}}</td>
                                    <td data-title="Customer PAN">{{$fetch->customerpannumber}}</td>
                                    <td data-title="Vehicle Details">{{$fetch->vehicle_details}}</td>
                                    <td data-title="Amount">{{$fetch->requested_amount}}</td>
                                    <td data-title="Date">{{$fetch->created_date}}</td>
                                    <td data-title="City">{{$fetch->customercity}}</td>
                                    <td data-title="Branch Name">{{$fetch->branchname}}</td>
                                    <td data-title="Ticket Id">{{$fetch->dealer_loan_ticket_id}}</td>
									<td data-title="Ticket Status" class="revokeditmes">{{$fetch->ticketstatus}}</td>
                                    <!--<td data-title="View"><a href="#"><i class="fa fa-eye btn btn-sm btn-primary view_employee" data-id="1"></i></a></td>-->
                                    <!--<td data-title="Cancel"><i class="btn btn-sm btn-danger fa {{$fetch->ticketstatus =='Revoked'?'fa-trash-o':'fa-remove'}} {{$fetch->ticketstatus=='Revoked'?'':'revokefunding'}}" data-revokeid="{{$fetch->dealer_customer_loan_id}}" </i></a></td>-->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td data-title="From" colspan="12">No Loans Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <span class="getloanid" loanid="{{$compact_array['loanid']}}"></span>
                    </div>
                </div>

            </div>
        </div>


    </div>
    @include('footer')
</div>


<!--popup-->
<!--CANCEL LOAN MODAL -->
<div class="modal fade" id="funddeleteresult" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are you sure to want revoke this Loan?</h4>
            </div>
            <form name="fundingform" id="submitform">
                <div class="modal-body">
                    <span class="successdelete"></span>
                    <input type="hidden" name="idoffunging" value="">
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default deleteyes" value="Yes">
                    <button type="button" class="btn btn-default deleteno" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="calculate" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Calculate EMI</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="calculator-loan">
                            <div class="thirty form col-xs-12 col-sm-6">

                            </div>

                            <div class="thirty col-xs-12 col-sm-6">
                                <p><label>Results:</label></p>
                                <div class="results"></div>
                            </div>
                        </div>

                    </div></div></div></div></div></div>
<!-- Loading Scripts -->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/fileinput.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script src="{{URL::asset('js/jquery.accrue.min.js')}}"></script>
<script>

$(".send-again").click(function () {
    $("#bid-hide").slideDown(1000);
});
$(document).ready(function () {
    
    $(".add-list").click(function () {
        $(".accrue-field-term .term").removeClass('data-number');
        $(".accrue-field-term .term").addClass('data-number-y-m');
    }); 
    
    var valueofloanid   =   $(".getloanid").attr('loanid');
    $(".input-sm").val(valueofloanid);
    $('input[type="search"]').trigger('focus');
    $('input[type="search"]').trigger('keyup');

	var fundingvalue;
	var getrow;
	$("body").on('click', '.revokefunding', function () {
		fundingvalue	=	$(this).data('revokeid');
		getrow 	= 	$(this).closest('tr');
		$("[name='idoffunging']").val(fundingvalue);
		$('#funddeleteresult').modal({
			show: 'true'
		});
	});
	
	//delete particular car
	$("body").on("click", ".deleteyes", function () {
		var fundingvalue	=	$("[name='idoffunging']").val();
		if(fundingvalue	==	"")
		{
			return false;
		}
		$("#loadspinner").css("display", "block");
		$.ajax({
			url: "{{url('doloanrevoke')}}",
			type: 'post',
			dataType: 'json',
			data: {fundingvalue: fundingvalue},
			success: function (response)
			{
				if (response.message == "success")
				{
					$(getrow).find('td.revokeditmes').html('Revoked');
					$(getrow).find('td i.revokefunding').removeClass('revokefunding');
					$(getrow).find('td i.fa-remove').removeClass('fa-remove').addClass('fa-trash-o');
					$('#funddeleteresult').modal("hide");
					$("#loadspinner").css("display", "none");
				} else
				{
					$('#funddeleteresult').modal("hide");
					alert(response.message);
					$("#loadspinner").css("display", "none");
				}
			},
			error: function (e)
			{
				//console.log(e.responseText);
			}
		});
	});
// set up normal loan calculation
    $(".calculator-loan").accrue();

});
$(document).ready(function () {
    $('.button_loan').click(function () {
        var customername = $('#customername').val();
        var customercontactno = $('#customercontactno').val();
        var customermailid = $('#customermailid').val();
        var customermobileno = $('#customermobileno').val();
        var customerdate = $('#customerdate').val();
        var customercity = $('#customercity').val();
        var customerarea = $('#customerarea').val();
        var requested_amount = $('#requested_amount').val();
        $.ajax({
            url: 'apply_loan',
            type: 'post',
            data: {customername: customername, customercontactno: customercontactno, customermailid: customermailid, customermobileno: customermobileno, customerdate: customerdate, customercity: customercity, customerarea: customerarea, requested_amount: requested_amount},
            success: function (response)
            {
                $('#alertmsg').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Success!</strong> Applied Loan</div>');
                $('#customername,#customercontactno,#customermailid,#customermobileno,#customerdate,#customercity,#customerarea,#requested_amount').val('');
                //alert(response);
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    });
});
$(function () {
    $('#customerdate').datetimepicker({
        format: 'dd-mm-yyyy'
    });

    $(document).on('keydown', '.data-number-y-m', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110,77,89]) !== -1 ||
                // Allow: Ctrl+A, Command+A

                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {

                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.keyCode === 32 || e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
                if(isNaN($(this).val()))
                {
                    $(this).val(0);
                }
            });

});

</script>
</body>

</html>
