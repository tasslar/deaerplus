@include('header')
@include('sidebar')

<div class="ts-main-content">
    <div class="content-wrapper myprofile">
        <div class="content-header col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{url('/manage_invoice')}}"><i class="fa fa-dashboard"></i> Accounts</a></li>
                <li class="active">New Invoices</li>
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
        <form method="post" action="{{url('/addinvoicelist')}}" id="everything">
            <div class="col-sm-12 col-xs-12">
                <h3 class="page-title">New Invoices</h3>
                <div class="row">
                    <div class="col-sm-4  col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Select Your Client</label>
                            <select  class="form-control registration_year required-des required" name="ddl_client" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" id="ddl_client"> 
                                <option value="0" disabled>Select Your Client</option>
                                @foreach($compact_array['client'] as $clients)
                                    <option value="{{$clients->contact_management_id}}">{{$clients->contact_first_name}},{{$clients->contact_phone_1}},{{$clients->contact_email_1}}</option>
                                @endforeach
                            </select>
                            <div style="color:red;" id="msg_id"></div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class='input-group  field-wrapper1'>
                            <span class="input-group-addon">
                                S0S0
                            </span>
                            <label>Invoice Code & Number</label>
                            <input type='text'  placeholder="Invoice Code & Number" class="form-control data-number"  data-validation="required" data-validation-optional="false"  maxlength="15" data-validation-error-msg="Please Enter Number" value="{{$compact_array['invoicecode']}}" name="txt_invoice_code" readonly>
                        </div>
                    </div>
                </div><!-- end outer row -->
                <div class="row">
                    <!-- <div class="col-sm-4  col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Currency</label>
                            <input type='text' placeholder="Currency" value="Rs" class="form-control" disabled="" >
                        </div>
                    </div> -->
                    <div class="col-sm-4 col-xs-12">
                        <div class='input-group date field-wrapper1 invoiceStartDates'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Date</label>
                            <input type='text' name="txt_date1" class="form-control invoiceStartDate" placeholder="Date" data-validation="date" data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" value="{{$compact_array['first_day_this_month']}}" required readonly>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class='input-group date field-wrapper1' id="invoiceEndDates">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Due Date</label>
                            <input type='text' name="txt_date2" class="form-control invoiceEndDate" placeholder="Due Date" data-validation="date" data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" value="{{$compact_array['last_day_this_month']}}" required readonly>
                        </div>
                    </div>
                </div>
                <div class="hr-dashed"></div>
                <div class="row">
                    <div class="col-xs-12" id="no-more-tables">
                        <table class="display table  clone-row table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">
                            <thead class="hidden-xs">
                                <tr class="hidden-xs">
                                    <th>Crt</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Tax Rate</th>
                                    <th>Discount</th>
                                    <th>Type</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="vert-align text-center invoicebody tbodydata" >
                                <tr class="tr_clone">
                                    <td data-title="Crt" class="sno">1</td>
                                    <td data-title="Product">
                                        <select class="form-control registration_year required-des watermark car_listing testclass" name="ddl_product[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" onchange="fun(this)">
                                            <option class="option1" value="" disabled="disabled" selected="selected">Choose</option>
                                            @foreach($compact_array['car_lisitng'] as $fetch_car)
                                                <option value="{{$fetch_car->car_id}}" car_id ="{{$fetch_car->car_id}}">{{$fetch_car->model_name}},{{$fetch_car->variant_name}}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <textarea class="form-control cardescription" placeholder="Description" name="txtar_description[]"></textarea>
                                    </td>
                                    <td  data-title="Quantity" class="col-xs-12 col-sm-1">
                                        <input class="form-control data-number quantity" id="quantity0" type="text" name="txt_quantity[]" max-length="3" value="1" disabled="disabled">
                                    </td>
                                    <td  data-title="Price"  class="col-xs-12 col-sm-1 ">
                                        <input class="form-control data-number carprice invent-select" id="test0" value="" type="text" name="txt_price[]" max-length="3" onkeypress="return validatedecimalKeyPress(this,event);">
                                        <input class="form-control data-number carsaleprice invent-select" id="carsaleprice0" value="" type="text" name="carsaleprice[]" max-length="3" readonly>
                                    </td>
                                    <td  data-title="Tax Rate"  class="col-xs-12 col-sm-1">
                                        <select class="form-control invent-select registration_year required-des watermark tax_rate" name="ddl_taxrate[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" id="tax_rate0" >
                                            <option value="" disabled="disabled">Choose</option>
                                            <option value="10" selected="selected">10%</option>
                                            <option value="20">20%</option>
                                        </select>
                                    </td>
                                    <td  data-title="Discount"  class="col-xs-12 col-sm-1 subDiscount">
                                        <input class="form-control data-decimal sub_Discount discount disInp " id="discount0" type="text" max-length="3" name="txt_discount_sub[]"  value="0" onkeypress="return validatedecimalKeyPress(this,event);">
                                    </td>
                                    <td  data-title="Type"  class="col-xs-12 col-sm-1">
                                        <select class="form-control invent-select registration_year required-des watermark amt_type" name="ddl_discount_type[]" data-validation="required" id="amt_type0" data-validation-optional="false" data-validation-error-msg="Please Select One Option" >
                                            <option value="" class="option3" disabled="">Choose</option>
                                            <option value="1" selected="selected">Amount</option>
                                            <option value="2">%</option>
                                        </select>
                                    </td>
                                    <td class="subtotal">
                                        <input class="form-control data-number sub_total" id="sub_total0" type="text" max-length="3" name="txt_subtototal[]" value="0.00" readonly>
                                        <input type="hidden" name="totalval" class="totalval" id="totalval"  value="">
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger remove-item"  disabled=""><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div class="col-xs-12 col-md-5 form-inline">
                                            <label>Discount</label>
                                            <input type="text" name="txt_invoiceDiscount" class="form-control totalinvdist" autocomplete="off" placeholder="Invoice Discount" value="0" id="totalinvdist" onkeypress="return validatedecimalKeyPress(this,event);">
                                        </div>
                                        <div class="col-xs-12 col-md-3 form-inline">
                                            <label>Discount type</label>
                                            <select name="ddl_invoiceDiscountType" class="form-control solsoEvent totaldisct_typ" id="totaldisct_typ" data-parsley-id="5711" onchange="change(this)">
                                                <option value="">choose</option>
                                                <option value="1" selected="selected">Amount</option>
                                                <option value="2">%</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-md-4 form-inline">
                                            <br>
                                            <button class="tr_clone_add btn btn-primary clear_total" type="button">Add New Product</button>
                                        </div>
                                    </td>
                                    <td colspan="5">
                                        <div class="col-xs-12">
                                            <h3 class="pull-left">Total</h3>
                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>

                                                <input type="text" name="txt_grand_total" class="form-control grand_total" autocomplete="off" placeholder="Invoice Discount" id="grand_total" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <h3 class="pull-left">Final Discount</h3>

                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>
                                                <input type="text" class="form-control" autocomplete="off" name="txt_finalDiscount" placeholder="Final Discount" id="finaldiscount" readonly>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- <div class="text-center">
                            <button type="button" class="tr_clone_add btn btn-primary">Add New Product</button>
                    </div> -->
                    <div class="add-list-buttons">
                        <div class="comm-button">
                            <button type="submit" class="btn btn-circle btn-lg btn-primary basic_info" data-basic="" value="Save" data-toggle="tooltip" data-original-title="Save" data-placement="left" name="btn_save"><i class="fa fa-save"></i></button> 
                        </div>

                        <div class="comm-button">
                            <button class="btn btn-circle btn-lg btn-primary cancelbutton" data-basic="basic_info_next" value="1" type="button" data-toggle="tooltip" data-original-title="Cancel" data-placement="left"><i class="fa fa-remove" aria-describedby="tooltip721074"></i></button> 
                        </div>
                    </div>
                    <div class="hr-dashed"></div>
                    <div class="col-xs-12 col-sm-6 text-areaheig">
                        <label>Invoice Extra Information (This Text Will Not Apear On PDF Document)</label>
                        <textarea class="col-xs-12 col-sm-12 form-control" type="text" name="txtar_extra_inform"></textarea>
                    </div>
                     <div class="col-xs-12 col-sm-6">
                        <label>Add Payment</label>
                        <h6 class="page-title">Next fields are not mandatory, you can insert first/total payment for this invoice</h6>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group field-wrapper1">
                                    <label>Amount Paid</label>
                                    <input type="text" name="txt_payment_paid" class="data-decimal form-control"  placeholder="Amount Paid" onkeypress="return validatedecimalKeyPress(this,event);">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class='input-group date field-wrapper1'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    <label>Date</label>
                                    <input type='text' name="txt_payment_date" class="form-control" placeholder="Date" data-validation="date" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Date" readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group field-wrapper1">
                                    <label>Payment Method</label>
                                    <select class="form-control" name="ddl_payment_method">
                                        <option value="0" disabled="">---SELECT---</option>
                                        <option value="1">CHEQUE</option>
                                        <option value="2">CASH</option>
                                        <option value="3">BANK TRANSFER</option>	
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-dashed"></div>
                    {!!csrf_field()!!}
                    <!-- <div class="col-xs-12">
                            <input type="submit" value="save" name="btn_save" class="btn btn-primary">
                    </div> -->
                    <div class="hr-dashed"></div>
                    @include('footer')
                </div>
            </div>
            <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
        </form>
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/label-slide.js"></script> 
        <script src="js/fileinput.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/dealerplus.js"></script>
        <script type="text/javascript" src="js/calculation.js"></script>

        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script>
        $("body").on("click", ".cancelbutton", function () {
            window.location.replace("{{url('manage_invoice')}}");
        });
        $('.date').datetimepicker('setStartDate', '{{$compact_array["current_day_this_month"]}}');
        </script>
        <script type="text/javascript">
            $("#everything").submit(function(e){
            var department = $("#msg_id");
            var msg = "Please Select Client";
            if ($('#ddl_client').val() == "0") {
                department.append(msg);
                e.preventDefault();
                return false;
            }
            });
        </script>