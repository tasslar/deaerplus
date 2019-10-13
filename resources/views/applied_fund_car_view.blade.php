
@include('header')
@include('sidebar')            
<div id="loadspinner" class="spinner_manage" style="display:none">
    <img id="img-spinner" src="{{url('ajax-loader.gif')}}" alt="Loading"/>
</div> 
<div class="content-wrapper">
    <div class="container-fluid footer-fixed">
        <div class="row">
            <div class="content-header col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="{{url('viewfunding')}}"><i class="fa fa-dashboard"></i> Funding</a></li>
                    <li class="active">Inventory Funding</li>
                </ol>
            </div>
            <div class="col-xs-12">

                <h2 class="page-title col-sm-5 col-md-5">Inventory Funding</h2>
                <a  href="{{url('/funding_excel')}}" class="pull-right btn btn-primary col-xs-12 col-md-3 col-sm-3 add-list"><i class="glyphicon glyphicon-export"></i>&nbsp; Export Excel</a>
                <a  href="{{url('addfund')}}" class="pull-right btn btn-primary col-xs-12 col-sm-3 col-md-2 add-list"><i class="fa fa-plus-square"></i>&nbsp; Apply Funding</a>

                <div class="hr-dashed"></div>
                <div class="row">
                    <div class="col-xs-12 table-overflow" id="no-more-tables">

                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead class="hidden-xs">
                                <tr>
                                    <th>Dealership Name</th>
                                    <th>Mobile No</th>
                                    <th>Email Id</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>City</th>
                                    <th>Branch Name</th>
                                    <th>Listing Id</th>
                                    <th>Ticket Id</th>
                                    <th>Ticket Status</th>
                                    <!--<th>View</th>-->
                                    <!--<th>Cancel</th>-->
                                </tr>
                            </thead>
                            <tfoot class="hidden-xs">
                                <tr>
                                    <th>Dealership Name</th>
                                    <th>Mobile No</th>
                                    <th>Email Id</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>City</th>
                                    <th>Branch Name</th>
                                    <th>Listing Id</th>
                                    <th>Ticket Id</th>
                                    <th>Ticket Status</th>
                                    <!--<th>View</th>-->
                                    <!--<th>Cancel</th>-->
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(!empty($compact_array['fundingdata']))
                                @foreach($compact_array['fundingdata'] as $fetch)
                                <tr>
                                    <td data-title="Dealership Name">{{$fetch['dealername']}}</td>
                                    <td data-title="Mobile No">{{$fetch['dealermobileno']}}</td>
                                    <td data-title="Email Id">{{$fetch['dealermailid']}}</td>
                                    <td data-title="Amount">{{$fetch['requested_amount']}}</td>
                                    <td data-title="Date">{{$fetch['created_date']}}</td>
                                    <td data-title="City">{{$fetch['dealercity']}}</td>
                                    <td data-title="Branch Name">{{$fetch['branchname']}}</td>
                                    <td data-title="Listing Id">{{$fetch['branchname'] ==	""?$fetch['dealer_listing_id']:""}}</td>
                                    <td data-title="Ticket Id">{{$fetch['dealer_funding_ticket_id']}}</td>
                                    <td data-title="Ticket Status" class="revokeditmes">{{$fetch['status']}}</td>
                                    <!--<td data-title="View"><a href="#"><i class="fa fa-eye btn btn-sm btn-primary view_employee" data-id="1"></i></a></td>-->
                                    <!--<td data-title="Cancel"><i class="btn btn-sm btn-danger fa {{$fetch['status']=='Revoked'?'fa-trash-o':'fa-remove'}}  {{$fetch['status']=='Revoked'?'':'revokefunding'}}" data-revokeid="{{$fetch['fundingid']}}"></i></td>-->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td data-title="No Data" colspan="10">No Funds Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <span class="getloanid" fundingid="{{$compact_array['Fundingticket']}}"></span>
                    </div>
                </div>
            </div>
        </div>               
    </div>
    @include('footer')
</div>
</div>
<!--CANCEL FUNDING MODAL -->
<div class="modal fade" id="funddeleteresult" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are you sure to want revoke this Funding?</h4>
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



<!--popup-->

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
<link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">

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

    var valueoffundingid   =   $(".getloanid").attr('fundingid');
    $(".input-sm").val(valueoffundingid);
    $('input[type="search"]').trigger('focus');
    $('input[type="search"]').trigger('keyup');

    var fundingvalue;
    var getrow;
    $("body").on('click', '.revokefunding', function () {
        fundingvalue = $(this).data('revokeid');
        getrow = $(this).closest('tr');
        $("[name='idoffunging']").val(fundingvalue);
        $('#funddeleteresult').modal({
            show: 'true'
        });
    });

    //delete particular car
    $("body").on("click", ".deleteyes", function () {
        var fundingvalue = $("[name='idoffunging']").val();
        if (fundingvalue == "")
        {
            return false;
        }
        $("#loadspinner").css("display", "block");
        $.ajax({
            url: "{{url('dofundingrevoke')}}",
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
    $('.button_funding').click(function () {
        var dealershipname = $('#dealershipname').val();
        var dealername = $('#dealername').val();
        var dealermailid = $('#dealermailid').val();
        var dealermobileno = $('#dealermobileno').val();
        var dealerdate = $('#dealerdate').val();
        var dealercity = $('#dealercity').val();
        var dealerarea = $('#dealerarea').val();
        var requested_amount = $('#requested_amount').val();
        $.ajax({
            url: 'apply_fund',
            type: 'post',
            data: {dealershipname: dealershipname, dealername: dealername, dealermailid: dealermailid, dealermobileno: dealermobileno, dealerdate: dealerdate, dealercity: dealercity, dealerarea: dealerarea, requested_amount: requested_amount},
            success: function (response)
            {
                $('#alertmsg').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Success!</strong> Applied Funding</div>');
                $('#dealershipname,#dealername,#dealermailid,#dealermobileno,#dealerdate,#dealercity,#dealerarea,#requested_amount').val('');
                //alert(response);
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    });
    $('#dealercity').autocomplete({
        source: '{!!URL::route('autocompletecity')!!}',
        minlenght: 1,
        autoFocus: true,
        select: function (e, ui) {
            //alert(ui);
        }
    });
});
$(function () {
    $('#dealerdate').datetimepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        startView: "month",
        minView: "month",
        maxView: "decade"
    });
});
</script>
</body>

</html>
