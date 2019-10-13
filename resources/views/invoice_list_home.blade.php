@include('header')
@include('sidebar')

<div class="ts-main-content">
    <div class="content-wrapper myprofile">
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
                            <button class="btn btn-primary" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="{{url('/manage_invoice')}}"><i class="fa fa-dashboard"></i> Accounts</a></li>
                        <li class="active">Invoices</li>
                    </ol>
                </div>
                <div class="clearfix"></div>
                @if (Session::has('message'))
                    <div class="alert alert-success" id="message-err">{{ Session::get('message') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                @endif
                @if (Session::has('message-err'))
                    <div class="alert alert-danger" id="message-err">{{ Session::get('message-err') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                @endif
                <div class="col-xs-12">
                    <h2 class="page-title col-sm-5 col-md-5">Invoices</h2>
                    <a href="{{url('/export_invoice_excel')}}" class="pull-right btn btn-primary col-xs-12 col-md-3 col-sm-3 add-list"><i class="glyphicon glyphicon-export"></i>&nbsp; Excel Export 
                    </a>
                    <a href="{{url('/addinvoicelist')}}" class="pull-right btn btn-primary col-xs-12 col-sm-3 col-md-2 add-list"><i class="fa fa-plus-square"></i>&nbsp; Add Invoice
                    </a>

                    <div class="hr-dashed"></div>
                    <div class="row">
                        <div class="col-md-12" id="no-more-tables">
                            <!-- <ul class="nav nav-tabs inventory-list">
                                <li class="active"><a href="#create" data-toggle="tab" aria-expanded="true">Invoices Created <span class="count-tab">(20)</span></a></li>
                            </ul> -->
                            <!-- <br> -->
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="create">
                                    <table id="zctb" class="display table table-striped table-bordered table-hover invoice-tab" cellspacing="0" width="100%">
                                        <thead class="hidden-xs">
                                            <tr>
                                                <th>S.no</th>
                                                <th>Number</th>
                                                <th>Client</th>
                                                <th>Amount</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <!-- <th>View</th> -->
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                @foreach($compact_array['dealer_invoice'] as $i => $fetch)
                                                    <tr>
                                                        <td  class="view" data-title="Crt">{{++$i}}</td>
                                                        <td  class="view" data-title="Number">
                                                            {{$fetch->invoice_number}}
                                                        </td>
                                                        <td data-title="Client">
                                                            @foreach($compact_array['client'] as $client)
                                                                @if($client->contact_management_id == $fetch->contact_id)
                                                                    {{$client->contact_first_name}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td data-title="Amount">{{$fetch->invoiceAmount}}</td>
                                                        <td  class="view" data-title="Paid">{{$fetch->totalPaidAmount}}</td>
                                                        @php
                                                            $balanceAmount  = ($fetch->invoiceAmount)-($fetch->totalPaidAmount);
                                                        @endphp
                                                        <td  class="view"  data-title="Balance">
                                                            {{$balanceAmount}}
                                                        </td>
                                                        <td  class="view"  data-title="Due Date">{!!$fetch->invoiceDuedate!!}</td>

                                                        <td data-title="Status">
                                                            @foreach($compact_array['invoice_status'] as $status)
                                                                @if($fetch->invoice_status_id == $status->id)
                                                                    <p class="label label-success" data-id = "{{$fetch->invoice_status_id}}">{{$status->name}}</p>
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td  class="view action-button" data-title="Edit Status">
                                                            <a href="#myModal" data-toggle="modal" id="{{$fetch->invoice_id}}" data-target="#popup"><i data-toggle="tooltip" data-original-title="Edit Status" data-placement="top" class="fa fa-pencil btn btn-sm btn-circle btn-default"></i>
                                                            </a>

                                                            <a href="#myModal" data-toggle="modal" id="{{$fetch->invoice_id}}" data-target="#popup1"><i data-toggle="tooltip" data-original-title="Edit Due Date" data-placement="top" class="fa fa-calendar btn btn-sm btn-circle btn-default"></i></a>

                                                            <a href="#myModal" data-toggle="modal" id="{{$fetch->invoice_id}}" data-yourparameter="{{$fetch->invoice_id}}" data-target="#popup2">
                                                                <i data-toggle="tooltip" data-original-title="Add Payment" data-placement="top" class="fa fa-money btn btn-sm btn-circle btn-default"></i>
                                                            </a>

                                                            <a data-id="{{$fetch->invoice_id}}" id="{{$fetch->invoice_id}}" class="exportinvoice"><i data-toggle="tooltip" data-original-title="Print" data-placement="top" class="fa fa-print btn btn-sm btn-circle btn-default"></i></a>

                                                            <a href="#open_mail_mail" data-id="{{$fetch->invoice_id}}" data-toggle="modal" id="{{$fetch->invoice_id}}" data-target="#open_mail_mail" class="open-model-mail"><i data-toggle="tooltip" data-original-title="Email to Client" data-placement="top" class="fa fa-envelope btn btn-sm btn-circle btn-default"></i></a>
                                                        </td>
                                                        <!-- <td  class="view" data-title="View">
                                                            <a data-id="{{$fetch->invoice_id}}" id="{{$fetch->invoice_id}}" class="viewinvoice"><i class="fa fa-eye btn btn-sm btn-primary"></i></a>
                                                        </td> -->
                                                            @if($fetch->invoice_status_id == "1")
                                                                <td  class="view" data-title="Edit">
                                                                    <a  data-id="{{$fetch->invoice_id}}" id="{{$fetch->invoice_id}}" class="viewinvoice"><i class="fa fa-pencil btn btn-sm btn-success"></i></a> 
                                                                </td>
                                                                @else
                                                                    <td  class="view" data-title="Edit">
                                                                        <a  data-id="{{$fetch->invoice_id}}" id="{{$fetch->invoice_id}}" class="viewinvoice disable_ahref"><i class="fa fa-pencil btn btn-sm btn-success"></i></a> 
                                                                    </td>
                                                            @endif
                                                        <td  class="view" data-title="Delete">
                                                            <a data-id="{{$fetch->invoice_id}}" data-yourparameter="{{$fetch->invoice_id}}" id="{{$fetch->invoice_id}}" class="deleteinvoice" data-toggle="modal" data-target="#deleteModel"><i class="fa fa-trash btn btn-sm btn-danger"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="post" action="{{url('/edit_invoice')}}" id="viewinvoice">
    <input type="text" name="viewinvoice" id="view_invoice">
    {{csrf_field()}}
</form>

<form method="post" action="{{url('/export_invoice')}}" id="exportinvoice">
    <input type="text" name="exportinvoice" id="export_invoice">
    {{csrf_field()}}
</form>
<div class="modal fade" id="popup1" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Invoice Due Date</h4>
            </div>
            <form method="post" action="{{url('/update_invoice_date')}}">
                {{csrf_field()}}
                <div class="modal-body edit-content">
                    <div class="row">
                        <input type="hidden" name="txt_invoice_id" id="txt_invoice_id">
                        <div class="col-xs-12 col-sm-12">
                            <div class='input-group date field-wrapper1' id="invoiceDuedate1">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <label>Due Date</label>
                                <input type='text' name="txt_due_date" class="form-control"  data-validation="date" data-validation-optional="true" id="txt_due_date" placeholder="Due Date" maxlength="15" data-validation-error-msg="Please Enter Valid Date" value="" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="Submit" name="btn_save_date" value="save" class="btn btn-primary send-again">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="popup2" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <form method="post" action="{{url('/getInvoicePayments')}}">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Payment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="append_data"></div>
                        <?php //<input type="hidden" name="" id="txt_invoiceBalAmount" value="{{$balanceAmount}}"> ?>
                        <input type="hidden" name="txt_invoice_id1" value="" id="txt_invoice_id1">
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group field-wrapper1">
                                <label>Amount</label>
                                <input type="text" class="form-control" placeholder="Amount" id="txt_payments_amount" name="txt_payments_amount">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class='input-group date field-wrapper1'>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <label>Date</label>
                                <input type='text' class="form-control"  data-validation="date" data-validation-optional="true" placeholder="Payment Date" maxlength="15" data-validation-error-msg="Please Enter Valid Date" id="txt_payments_date" name="txt_payments_date" readonly />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group field-wrapper1">
                                <label>Payment Method</label>
                                <select class="form-control registration_year required-des" name="ddl_payment_method" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" id="ddl_payment_method"> 
                                    <option value="">Payment Method</option>
                                    <option value="1" selected>CHEQUE</option>
                                    <option value="2">CASH</option>
                                    <option value="3">BANK TRANSFER</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                    <input type="submit" name="btn_add_payment" value="Add Payment" class="btn btn-primary"> 
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="open_mail_mail" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <form method="post" action="{{url('/invoiceEmailSend')}}">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Send Email</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="quotes_id" id="quotesemail_id" value=""/>
                    <div class="row">
                        <input type="hidden" name="txt_invoice_id_email" id="invoice_id" value=""/>
                        <div class="col-xs-12 col-sm-12">
                            <label>Email Content</label>
                            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                                        
                                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" disabled="disabled">
                                    </div>

                                    <div id="editor" disabled="disabled"></div>
                            <p>You are about to send pdf invoice via email to this user.</p>
                            <textarea rows="2" name="txt_email_subject" id="email_subject"
    cols="20" style="display:none; " > Enter your text here.. </textarea>

                            <p>Do you want to proceed ?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_send_email" value="Yes" class="btn btn-primary">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="popup" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <form method="post" action="{{url('/getInvoiceStatus')}}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Invoice Change Status</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group field-wrapper1">
                                <input type="hidden" name="txt_invoice_status_id" id="txt_invoice_status_id">
                                {{csrf_field()}}
                                <label>Select Status</label>
                                <select class="form-control registration_year required-des" name="ddl_invoice_status" data-validation="required" id="ddl_invoice_status" data-validation-optional="false" data-validation-error-msg="Please Select One Option"> 
                                    <option value="">Select Status</option>
                                    <!-- <option value="1">Paid</option>
                                    <option value="2">Unpaid</option>
                                    <option value="3">Partialy Paid</option> -->
                                    @foreach($compact_array['invoice_status'] as $invoiceStatus)
                                        @if($invoiceStatus->id != "8")
                                            <option value="{{$invoiceStatus->id}}">{{$invoiceStatus->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_invoice_status_change" value="Submit" class="btn btn-primary">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="deleteModel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{url('/delete_invoice')}}">
                {{csrf_field()}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Do You Want To Delete?
                    <input type="hidden" value="" id="txt_invoice_iddelete" name="deleteinvoice">
                </div>
                <div class="modal-footer">
                    <input type="submit" name="" value="Delete" class="btn btn-default">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script> 
<script src="js/fileinput.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/dealerplus.js"></script>

<script type="text/javascript">
$('#invoiceDuedate1').datetimepicker("setStartDate", new Date());
$(function () {
    $('.date').datetimepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        startView: "month",
        minView: "month",
        maxView: "decade"
    });
});
</script>
<script type="text/javascript">
    // var balance = $("#txt_invoiceBalAmount").val();
    // var myamnt  = $("#txt_invoiceBalAmount").val();
    // $('#txt_payments_amount').keyup(function() {
    // if ($('#txt_payments_amount').val() < $('#txt_invoiceBalAmount').val()) 
    // {
    //     alert('Same Value');
    //     return false;
    //     } 
    //     else 
    //         { 
    //             return true; 
    //         }
    // });
//     $('#txt_payments_amount').keyup(function(){
//   if ($(this).val() < balance){
//     //alert("No numbers above 100");
//     $(this).val(balance);
//   }
// });
</script>
<style type="text/css">
    a.disable_ahref {
   pointer-events: none;
   cursor: default;
}
</style>
<script type="text/javascript">
    $(document).on('click', '.viewinvoice', function ()
    {
        var edit_id = $(this).attr('data-id');
        $('#view_invoice').val(edit_id);
        //alert(edit_id);
        $('#viewinvoice').submit();
    });
    $(document).on('click', '.deleteinvoice', function () {
        var edit_id = $(this).attr('data-id');
        $('#delete_invoice').val(edit_id);
        $('#deleteinvoice').submit();
    });
    $(document).on('click', '.exportinvoice', function () {
        var edit_id = $(this).attr('data-id');
        $('#export_invoice').val(edit_id);
        $('#exportinvoice').submit();
    });
</script>
<script type="text/javascript">
    $('#popup').on('show.bs.modal', function (e)
    {
        var token, data;
        var $modal = $(this),
                esseyId = e.relatedTarget.id;
        //alert(esseyId);
        token = "{{ csrf_token() }}";

        data = {id: esseyId};

        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            url: "{{url('/getInvoiceStatus')}}",
            data: {id: esseyId},
            datatype: 'JSON',
            success: function (data)
            {
                $("#ddl_invoice_status").val(data[0].invoice_status_id);
                $("#txt_invoice_status_id").val(data[0].invoice_id);
            }
            // error: function () 
            // {
            //     alert();
            // }
        });
    });
</script>
<script type="text/javascript">
    $('#popup1').on('show.bs.modal', function (e)
    {
        var token, data;
        var $modal = $(this),
        esseyId = e.relatedTarget.id;
        //alert(esseyId);
        token = "{{ csrf_token() }}";

        data = {id: esseyId};
        //alert(data);
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            url: "{{url('getdateinvoice')}}",
            data: {id: esseyId},
            datatype: 'JSON',
            success: function (data)
            {
                $("#txt_invoice_id").val(data[0].invoice_id);
                $("#txt_due_date").val(data[0].due_date);
                $('#invoiceDuedate1').datetimepicker("setStartDate", data[0].due_date);
            }
            // error: function () 
            // {
            //     alert();
            // }
        });
    });
</script>
<script type="text/javascript">
    $('#popup2').on('show.bs.modal', function (e)
    {
        var yourparameter = e.relatedTarget.dataset.yourparameter;

        $("#txt_invoice_id1").val(yourparameter);

        var token, data;
        var $modal = $(this),
        esseyId = e.relatedTarget.id;
        //alert(esseyId);
        token = "{{ csrf_token() }}";

        data = {id: esseyId};
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            url: "{{url('getInvoicePayments')}}",
            data: {id: esseyId},
            datatype: 'JSON',
            success: function (data)
            {
                //$("#txt_invoice_id1").val(data[0].invoice_id);
                $("#append_data").html("");
                $.each(data, function(index, value) 
                {
                    if(data[index].amount != "0.00")
                    {
                        $("#append_data").append("<input type='text' class='col-md-3' value='"+data[index].amount+"'>");
                        $("#append_data").append("<input type='text' class='col-md-3' value='"+data[index].payment_date+"'>");
                        if(data[index].payment_type_id == "1")
                        {
                            $("#append_data").append("<input type='text' class='col-md-3' value='CHECK'>");
                        }
                        else if(data[index].payment_type_id == "2")
                        {
                            $("#append_data").append("<input type='text' class='col-md-3' value='CASH'>");
                        }
                        else if(data[index].payment_type_id == "3")
                        {
                            $("#append_data").append("<input type='text' class='col-md-3' value='BANK TRANSFER'>");
                        }
                        $("#append_data").append("<div class='clearfix'></div>");
                    }
                });
            }
            // error: function () 
            // {
            //     alert();
            // }
        });
    });
</script>
<script type="text/javascript">
    $('#open_mail_mail').on('show.bs.modal', function (e)
    {
        var token, data;
        $('#editor').html("");
        var $modal = $(this),
        value = e.relatedTarget.id;
        //alert(esseyId);
        token = "{{ csrf_token() }}";

        data = {id: value};
        console.log(data);
        //alert(data);
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            url: "{{url('emailMsgInvoice')}}",
            data: {quotes_id: value},
            success: function (response)
            {
                $("#loadspinner").css("display", "none");
               $('#editor').html(response);
            }
        });
    });
</script>
<script type="text/javascript">
    $('#deleteModel').on('show.bs.modal', function (e)
    {
        var yourparameter = e.relatedTarget.dataset.yourparameter;

        $("#txt_invoice_iddelete").val(yourparameter);
    });
</script>
<script type="text/javascript">
    $(document).on("click", ".open-model-mail", function () {
        var myId = $(this).data('id');
        $(".modal-body #invoice_id").val(myId);
    });
</script>
</body>