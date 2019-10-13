@include('header')
<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="content-header col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{url('/managequotes')}}"><i class="fa fa-dashboard"></i> Accounts</a></li>
                <li class="active">Edit Quotes</li>
            </ol>
        </div>
        <form method="post" action="{{url('updatequotes')}}">
            <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
            <div class="col-sm-12 col-xs-12">
                <h3 class="page-title">Edit Quotes</h3>
                <div class="row">
                    <div class="col-sm-4  col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Select Your Client</label>
                            <select class="form-control required-des" name="" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" disabled="disabled">
                                <option value="" disabled="disabled" selected="selected">Select Your Client</option>
                                @foreach($compact_array['client'] as $fetch)
                                    @if($compact_array['editquotesvalue']->contact_id == $fetch->contact_management_id)
                                    <option selected="selected" value="{{$fetch->contact_management_id}}">{{$fetch->contact_first_name}},{{$fetch->contact_phone_1}},{{$fetch->contact_email_1}}</option>
                                    @else
                                    <option value="{{$fetch->contact_management_id}}">{{$fetch->contact_first_name}},{{$fetch->contact_phone_1}},{{$fetch->contact_email_1}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Reference</label>
                            <input type='text' placeholder="Reference" class="form-control" name="reference" data-validation="required" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Reference" value="{{$compact_array['editquotesvalue']->reference}}" />
                        </div>
                    </div>
                </div><!-- end outer row -->
                <div class="row">
                    <div class="col-sm-4  col-xs-12">
                        <div class='input-group date field-wrapper1 invoiceStartDates'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Estimate Date</label>
                            <input type='text' class="form-control est_date" name="estimate_date"  data-validation="date" data-validation-optional="true" placeholder="Estimate Date" value="{{$compact_array['editquotesvalue']->start_date}}" maxlength="15" data-validation-error-msg="Please Enter Valid Date" readonly />
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class='input-group date field-wrapper1' id="invoiceEndDates">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Expiry Date</label>
                            <input type='text' placeholder="Expiry Date" name="expiry_date" class="form-control exp_date"  data-validation="date"  data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" value="{{$compact_array['editquotesvalue']->end_date}}" readonly />
                        </div>
                    </div>
                </div>
                <div class="hr-dashed"></div>
                <div class="row">
                    <div class="col-xs-12" id="no-more-tables">
                        <table id="zctb tblOne" class="display clone-row table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">
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
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>

                            <tbody class="vert-align text-center invoicebody tbodydata">
                                @foreach($compact_array['editquotes_items'] as $i => $car_quotes)
                                <tr class="">
                                    <input type="hidden" name="quotes_id[]" id="invoice_item_id" value="{{$car_quotes->invoice_item_id}}">
                                    <td data-title="Crt" class="sno">{{$i+1}}</td>
                                    <td data-title="Product">
                                        <select class="form-control registration_year required-des watermark car_listing testclass" name="product[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" invoiceid="{{$car_quotes->invoice_id}}" dataid="1" onchange="fun('fun{{$i}}',this)">
                                            <option class="option1" value="" disabled="disabled" selected="selected">Choose</option>
                                            @foreach($compact_array['car_listing'] as $fetch_car)
                                                @if($fetch_car->car_id == $car_quotes->product_id )
                                                    <option selected="selected" value="{{$fetch_car->car_id}}" car_id ="{{$fetch_car->car_id}}">{{$fetch_car->model_name}},{{$fetch_car->variant_name}}</option>
                                                @else
                                                    <option value="{{$fetch_car->car_id}}" car_id ="{{$fetch_car->car_id}}">{{$fetch_car->model_name}},{{$fetch_car->variant_name}}</option>
                                                @endif
                                            @endforeach  
                                        </select>
                                    <br/>
                                        <textarea class="form-control" name="cardescription[]" placeholder="Description">{{$car_quotes->notes}}</textarea>
                                    </td>
                                    <td  data-title="Quantity" class="col-xs-12 col-sm-1">
                                        <input class="form-control data-number quantity" id="quantity{{$i}}" type="text" name="quantity[]" max-length="3" value="1" disabled="disabled">
                                        <input type="hidden" name="txt_quantity[]" value="1">
                                    </td>
                                    <td  data-title="Price"  class="col-xs-12 col-sm-1 ">
                                        <input class="form-control data-number carprice invent-select" id="test{{$i}}" value="{{$car_quotes->cost}}" type="text" name="price[]" max-length="3" readonly>
                                    </td>
                                    <td  data-title="Tax Rate"  class="col-xs-12 col-sm-1">
                                        <select class="form-control invent-select registration_year required-des watermark tax_rate" name="taxrate[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" id="tax_rate{{$i}}" >
                                            @if($car_quotes->tax_rate1 == 10.00)
                                            <option value="" disabled="disabled" selected="selected" class="option2">Choose</option>
                                            <option value="10" selected="selected">10%</option>
                                            <option value="20">20%</option>
                                            @elseif($car_quotes->tax_rate1 == 20.00)
                                            <option value="" disabled="disabled" selected="selected" class="option2">Choose</option>
                                            <option valaue="10">10%</option>
                                            <option value="20" selected="selected">20%</option>
                                            @else
                                            <option vlaue="" disabled="disabled" selected="selected" class="option2">Choose</option>
                                            <option value="10">10%</option>
                                            <option value="20">20%</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td  data-title="Discount"  class="col-xs-12 col-sm-1 totaldis">
                                        <input class="form-control data-decimal sub_Discount discount disInp " id="discount{{$i}}" type="text" max-length="3" name="discount[]"  value="{{$car_quotes->discount}}" onkeypress="return validatedecimalKeyPress(this,event);">
                                    </td>
                                    <td  data-title="Type"  class="col-xs-12 col-sm-1 discType">
                                        <select class="form-control invent-select registration_year required-des watermark amt_type" name="type[]" data-validation="required" id="amt_type{{$i}}" data-validation-optional="false" data-validation-error-msg="Please Select One Option" >
                                             @if($car_quotes->discount_type == "Amount")
                                            <option value="" class="option3" disabled="">Choose</option>
                                            <option value="1" selected="selected">Amount</option>
                                            <option value="2">%</option>
                                            @elseif($car_quotes->discount_type == "%")
                                            <option value="" class="option3" disabled="">Choose</option>
                                            <option value="1">Amount</option>
                                            <option value="2" selected="selected">%</option>
                                            @else
                                            <option value="" class="option3" disabled="">Choose</option>
                                            <option value="1" selected="selected">Amount</option>
                                            <option value="2">%</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class="subtotal">
                                        <input class="form-control data-number sub_total" id="sub_total{{$i}}" type="text" max-length="3" name="subtotal[]" value="{{$car_quotes->sub_total}}" readonly>
                                        <input type="hidden" name="totalval" class="totalval" id="totalval"  value="" >
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div class="col-xs-12 col-sm-6 form-inline">
                                            <label>Quotes Discount</label>
                                            <input type="text" name="invoiceDiscount" class="form-control totalinvdist" autocomplete="off" placeholder="Invoice Discount" value="{{$compact_array['editquotesvalue']->discount}}" id="totalinvdist" onkeypress="return validatedecimalKeyPress(this,event);">
                                        </div>
                                        <div class="col-xs-12 col-sm-6 form-inline">
                                            <label>Quotes Discount Type</label>
                                            <select name="invoiceDiscountType" id="totaldisct_typ" class="form-control solsoEvent totaldisct_typ" data-parsley-id="5711">
                                            @if($compact_array['editquotesvalue']->invoice_discount_type == "Amount")
                                                <option value="">choose</option>
                                                <option value="1" selected="selected">Amount</option>
                                                <option value="2">%</option>
                                            @else if($compact_array['editquotesvalue']->invoice_discount_type == "%")
                                                <option value="">choose</option>
                                                <option value="1">Amount</option>
                                                <option value="2" selected="selected">%</option>
                                            @endif
                                            </select>
                                        </div>
                                    <td colspan="5">
                                        <div class="col-xs-12"> 
                                            <h3 class="pull-left">Total</h3>
                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>
                                                <input type="text" name="grand_total" class="form-control grand_total" autocomplete="off" placeholder="Invoice Discount" id="grand_total" value="{{$compact_array['editquotesvalue']->amount}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <h3 class="pull-left">Final Discount</h3>
                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>
                                                <input type="text" class="form-control" autocomplete="off" placeholder="Final Discount" id="finaldiscount" name="finaldiscounts" value="{{$compact_array['editquotesvalue']->po_number}}" readonly>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="add-list-buttons">
                        <div class="comm-button">
                            <button type="submit" class="btn btn-circle btn-lg btn-primary basic_info" data-basic="" value="Save"  data-toggle="tooltip" data-original-title="Save" data-placement="left"><i class="fa fa-save"></i></button> 
                        </div>

                        <div class="comm-button">
                            <button class="btn btn-circle btn-lg btn-primary cancelbutton" data-basic="basic_info_next" value="1" type="button"  data-toggle="tooltip" data-original-title="Cancel" data-placement="left"><i class="fa fa-remove" aria-describedby="tooltip721074"></i></button>
                        </div>
                    </div>
                    <div class="hr-dashed"></div>
                    <div class="col-xs-12 col-sm-6 text-areaheig">
                        <label>Description</label>
                        <textarea class="col-xs-12 col-sm-12 form-control" name="description" type="text">{{$compact_array['editquotesvalue']->public_notes}}</textarea></div>
                    </div>
                    <div class="col-xs-12 col-sm-6  text-areaheig">
                        <label>Terms & Conditions</label>
                        <textarea class="col-xs-12 col-sm-12 form-control" name="term_cond" type="text">{{$compact_array['editquotesvalue']->terms}}</textarea>
                    </div>
                    <div class="hr-dashed"></div>
                    @include('footer')
                </div>
            </div>
            <input type="hidden" name="editid" value="{{$compact_array['editquotes']}}">
        </form>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/label-slide.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/dealerplus.js"></script>
        <script type="text/javascript" src="js/editInvoice.js"></script>
        <!-- <script type="text/javascript" src="js/calculation.js"></script> -->
        <script type="text/javascript">
            $('.date').datetimepicker('setStartDate', '{{$compact_array["date"]}}');
            $("body").on("click", ".cancelbutton", function () {
                window.location.replace("{{url('managequotes')}}");
            });
        </script>
        </body>
        </html>