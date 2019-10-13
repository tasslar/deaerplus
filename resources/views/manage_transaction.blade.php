@include('header')
@include('sidebar')

<div class="content-wrapper">
<div class="container-fluid">

    <div class="row">
        <div class="content-header col-sm-12">

            <ol class="breadcrumb">
                <li><a href="{{url('/myeditaccount')}}"><i class="fa fa-dashboard"></i>Manage</a></li>
                <li class="active">Transaction</li>
            </ol>
        </div>
        <div class="col-xs-12">
            <h2 class="page-title col-xs-12">Transaction</h2>
            <div class="hr-dashed"></div>
            <div class="row">
            <div class="col-xs-12 mb ">
                <div class="col-sm-6 col-xs-12 pull-right text-center creditsdiv">
                                <h4>Current Plan : <span class="btn-sm">{{$current_plan['plan_type_name']}} &nbsp;&nbsp;{{$current_plan['freq_desc']}}</span></h4>
                                <span class="btn-sm">Current Plan Duration:
                                {{Carbon\Carbon::parse($cur_detail['cur_startdate'])->format('d/m/Y')}}  -  {{Carbon\Carbon::parse($cur_detail['cur_enddate'])->format('d/m/Y')}}</span>
                                <p></p>
                                <span class="btn-sm creditspan">Available Credit Balance Rs.{{$cur_detail['cur_credit']}}</span>
                            </div>
            </div>
            
                <div class="col-xs-12" id="no-more-tables">
                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead class="hidden-xs">
                            <tr>
                                <th rowspan="2">Order Id</th>
                                <th rowspan="2">Amount</th>
                                <th rowspan="2">Plan</th>
                                <th rowspan="2">Transaction Date</th>
                                <th rowspan="2">Payment Mode</th>
                                <th rowspan="2">Payment Status</th>
                                <th colspan="2" scope="colgroup">Validity(From-Upto)(Days)</th>
                                <th rowspan="2">Print Invoice</th>
                            </tr>
                            <tr>
                                <th>Plan Details</th>
                               <!--  <th>To Date</th> -->
                                <th>Period</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($fetch_dealerdata))
                            @foreach($fetch_dealerdata as $key)
                            <tr>
                                <td data-title="History_id">{{$key->history_id}}</td>
                                <td data-title="Amount">{{$key->payable_amount}}</td>
                               
                                <td data-title="Plan">{{$key->planname}}</td>
                               
                                <td data-title="Transaction Date">{{$key->billing_date}}</td>
                                <td data-title="Mode">{{$key->mode}}</td>
                                <td data-title="Payment Status">{{$key->bill_status}}</td>
                                <td data-title="Date"><b>From - </b>{{$key->subscription_start_date}}<br> <b>To - </b> {{$key->subscription_end_date}}<br>{{$key->description}}</td>
                                <td data-title="Period">{{$key->period}}</td>
                                @if($key->bill_status == "success")
                                <td data-title="Print Invoice" class="printvoice">
                                <a href="{{url('pdf/'.$key->encryptedkey)}}" data-toggle="tooltip" title="Print" target="_blank"  class="btn btn-sm btn-primary"><i class="fa fa-print"></i></a>
                                <a href="{{url('invoicePdfDownload/'.$key->encryptedkey)}}" class="btn btn-sm btn-primary"  data-toggle="tooltip"  title="Download"><i class="fa fa-download"></i></a></td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                  <td data-title="No Data" colspan="7">No Transactions Found</td>
                                </tr>
                            @endif
                            {{$fetch_dealerdata->links()}}  
                      </tbody>
                    </table>



                </div>
            </div>

        </div>
    </div>


</div>
@include('footer')
</div>
</div>

<!--popup-->
<div class="modal fade" id="popup" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Apply Loan For Customer</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <form method="post" id="transaction">
                    <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>Customer Name</label>
                                <input type="text" class="form-control" placeholder="Customer Name">
                            </div></div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" placeholder="Contact Number">
                            </div></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>Email Id</label>
                                <input type="mail" class="form-control" placeholder="Email Id">
                            </div></div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" placeholder="Mobile Number">
                            </div></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>Amount required</label>
                                <input type="mail" class="form-control" placeholder="Amount Required">
                            </div></div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>Date</label>
                                <input type="text" class="form-control" id='datetimepicker4' placeholder="Date">
                            </div></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>City</label>
                                <input type="mail" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group field-wrapper1">
                                <label>Area</label>
                                <input type="text" class="form-control" placeholder="Area">
                            </div></div>
                    </div>
                </form></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary send-again">Submit</button>
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
<script src="js/fileinput.js"></script>
<script src="js/dealerplus.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/label-slide.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
$('#datetimepicker4').datetimepicker({
    autoclose: true,
    format: "yyyy-mm-dd",
    startView: "month",
    minView: "month",
    maxView: "decade"
});


});

</script>

</body>

</html>