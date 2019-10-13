@include('header')
<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="content-header col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{url('/manage_invoice')}}"><i class="fa fa-dashboard"></i> Accounts</a></li>
                <li class="active">Edit Invoice</li>
            </ol>
        </div>
        <form method="post" action="{{url('edit_invoice')}}">
            <input type="hidden" name="txt_invoice_id" value="{{$invoice_main[0]->invoice_id}}">
            <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
            <div class="col-sm-12 col-xs-12">
                <h3 class="page-title">Edit Invoice</h3>
                <div class="row">
                    <div class="col-sm-4  col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Select Your Client</label>
                            <select class="form-control required-des" name="ddl_client" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" disabled="disabled">
                                <option value="" disabled="disabled" selected="selected">Select Your Client</option>
                                @foreach($compact_array['client'] as $clients)
                                    <option value="{{$clients->contact_management_id}}" <?php  if ($clients->contact_management_id == $invoice_main[0]->contact_id) echo 'selected="selected"' ?>>{{$clients->contact_first_name}},{{$clients->contact_phone_1}},{{$clients->contact_email_1}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Invoice Code & Number</label>
                            <input type='text' placeholder="Reference" class="form-control" name="txt_invoice_code" readonly data-validation="required" data-validation-optional="true" data-validation-error-msg="Please Enter Number" value="{{$invoice_main[0]->invoice_number}}"  />
                        </div>
                    </div>
                </div><!-- end outer row -->
                <div class="row">
                    <div class="col-sm-4  col-xs-12">
                        <div class='input-group date field-wrapper1 invoiceStartDates'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Date</label>
                            <input type='text' class="form-control invoiceStartDate" name="txt_date1"  data-validation="date" data-validation-optional="true" placeholder="Estimate Date" value="{{$invoice_main[0]->invoice_date}}" maxlength="15" data-validation-error-msg="Please Enter Valid Date"  readonly>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class='input-group date field-wrapper1' id="invoiceEndDates">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Due Date</label>
                            <input type='text' placeholder="Due Date" name="txt_date2" class="form-control currentDate invoiceEndDate"  data-validation="date"  data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" value="{{$invoice_main[0]->due_date}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="hr-dashed"></div>
                <div class="row">
                    <div class="col-xs-12" id="no-more-tables">
                        <table id="zctb tblOne" class="display clone-row table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">
                            <thead class="hidden-xs">
                                <tr class="hidden-xs">
                                    <th>Sl No</th>
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
                                @foreach($compact_array['invoice_sub'] as $i => $invoice_sub_det)
                                <tr class="">
                                    <input type="hidden" name="txt_invoice_sub_id[]" id="invoice_item_id" value="{{$invoice_sub_det->invoice_item_id}}">
                                    <td data-title="Crt" class="sno">{{$i+1}}</td>
                                    <td data-title="Product">
                                        <select class="form-control registration_year required-des watermark car_listing testclass" name="ddl_product[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" invoiceid="{{$invoice_sub_det->invoice_id}}" dataid="1" onchange="fun('fun{{$i}}',this)">
                                            <option class="option1" value="" disabled="disabled" selected="selected">Choose</option>
                                            @foreach($compact_array['car_lisitng'] as $fetch_car)
                                                <option value="{{$fetch_car->car_id}}" car_id ="{{$fetch_car->car_id}}" <?php if ($invoice_sub_det->product_id == $fetch_car->car_id) echo 'selected="selected"' ?>>{{$fetch_car->model_name}},{{$fetch_car->variant_name}}</option>
                                            @endforeach 
                                        </select>
                                    <br/>
                                        <textarea class="form-control" name="txtar_description[]" placeholder="Description">{{$invoice_sub_det->notes}}</textarea>
                                    </td>
                                    <td  data-title="Quantity" class="col-xs-12 col-sm-1">
                                        <input class="form-control data-number quantity" id="quantity{{$i}}" type="text" name="txt_quantity[]" max-length="3" value="1" disabled="disabled">
                                        <input type="hidden" name="txt_quantity[]" value="1">
                                    </td>
                                    <td  data-title="Price"  class="col-xs-12 col-sm-1 ">
                                        <input class="form-control data-number carprice invent-select" id="test{{$i}}" value="{{$invoice_sub_det->cost}}" type="text" name="txt_price[]" max-length="3" onkeypress="return validatedecimalKeyPress(this,event);">

                                        <input class="form-control data-number carsaleprice invent-select" id="carsaleprice{{$i}}" value="{{$invoice_sub_det->cost}}" type="text" name="carsaleprice[]" max-length="3" readonly>

                                    </td>
                                    <td  data-title="Tax Rate"  class="col-xs-12 col-sm-1">
                                        <select class="form-control invent-select registration_year required-des watermark tax_rate" name="ddl_taxrate[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" id="tax_rate{{$i}}" >
                                            @if($invoice_sub_det->tax_rate1 == 10.00)
                                            <option value="" disabled="disabled" selected="selected" class="option2">Choose</option>
                                            <option value="10" selected="selected">10%</option>
                                            <option value="20">20%</option>
                                            @elseif($invoice_sub_det->tax_rate1 == 20.00)
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
                                        <input class="form-control data-decimal sub_Discount discount disInp " id="discount{{$i}}" type="text" max-length="3" name="txt_discount_sub[]"  value="{{$invoice_sub_det->discount}}" onkeypress="return validatedecimalKeyPress(this,event);">
                                    </td>
                                    <td  data-title="Type"  class="col-xs-12 col-sm-1 discType">
                                        <select class="form-control invent-select registration_year required-des watermark amt_type" name="ddl_discount_type[]" data-validation="required" id="amt_type{{$i}}" data-validation-optional="false" data-validation-error-msg="Please Select One Option" >
                                             @if($invoice_sub_det->discount_type == "Amount")
                                            <option value="" class="option3" disabled="">Choose</option>
                                            <option value="1" selected="selected">Amount</option>
                                            <option value="2">%</option>
                                            @elseif($invoice_sub_det->discount_type == "%")
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
                                        <input class="form-control data-number sub_total" id="sub_total{{$i}}" type="text" max-length="3" name="txt_subtototal[]" value="{{$invoice_sub_det->sub_total}}" readonly>
                                        <input type="hidden" name="totalval" class="totalval" id="totalval"  value="" >
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div class="col-xs-12 col-sm-6 form-inline">
                                            <label>Invoice Discount</label>
                                            <input type="text" name="txt_invoiceDiscount" class="form-control totalinvdist" autocomplete="off" placeholder="Invoice Discount" value="{{$invoice_main[0]->discount}}" id="totalinvdist" onkeypress="return validatedecimalKeyPress(this,event);">
                                        </div>
                                        <div class="col-xs-12 col-sm-6 form-inline">
                                            <label>Invoice Discount Type</label>
                                            <select name="ddl_invoiceDiscountType" id="totaldisct_typ" class="form-control solsoEvent totaldisct_typ" data-parsley-id="5711">
                                            @if($invoice_main[0]->invoice_discount_type == "Amount")
                                                <option value="">choose</option>
                                                <option value="1" selected="selected">Amount</option>
                                                <option value="2">%</option>
                                            @else if($invoice_main[0]->invoice_discount_type == "%")
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
                                                <input type="text" name="txt_grand_total" class="form-control grand_total" autocomplete="off" placeholder="Invoice Discount" id="grand_total" value="{{$invoice_main[0]->amount}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <h3 class="pull-left">Final Discount</h3>
                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>
                                                <input type="text" class="form-control" autocomplete="off" placeholder="Final Discount" id="finaldiscount" name="txt_finalDiscount" value="{{$invoice_main[0]->po_number}}" readonly>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="add-list-buttons">
                        <div class="comm-button">
                            <button type="submit" name="btn_update" class="btn btn-circle btn-lg btn-primary basic_info" data-basic="" value="Save"  data-toggle="tooltip" data-original-title="Save" data-placement="left"><i class="fa fa-save"></i></button> 
                        </div>

                        <div class="comm-button">
                            <button class="btn btn-circle btn-lg btn-primary cancelbutton" data-basic="basic_info_next" value="1" type="button"  data-toggle="tooltip" data-original-title="Cancel" data-placement="left"><i class="fa fa-remove" aria-describedby="tooltip721074"></i></button> 
                        </div>
                    </div>
                    <div class="hr-dashed"></div>
                    <div class="col-xs-12 col-sm-6 text-areaheig">
                        <label>Invoice Extra Information (This Text Will Not Apear On PDF Document)</label>
                        <textarea class="col-xs-12 col-sm-12 form-control" name="txtar_extra_inform" type="text">{{$invoice_main[0]->terms}}</textarea>
                    </div>
                    <div class="hr-dashed"></div>
                    @include('footer')
                </div>
            </div>
            <input type="hidden" name="editid" value="{{$compact_array['invoiceid']}}">
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
            $('.date').datetimepicker('setStartDate', '{{$compact_array["today"]}}');
            $("body").on("click", ".cancelbutton", function () {
                window.location.replace("{{url('manage_invoice')}}");
            });
            // $(document).ready(function(){
            //     $('#totaldisct_typ').change(function(){
            //         var total = 0;
            //         var grand_total = 0;
            //         var totaldisct_typ  = $(this).val();
            //          $('.subtotal').each(function (key) {
            //             var data = $(this).find('.sub_total').val();
            //             total = parseFloat(total) + parseFloat(data);
            //         });
            //         var totalinvdist    = $('.totalinvdist').val();
            //         if(totaldisct_typ == 1)
            //         {
            //             console.log(totalinvdist);
            //             grand_total = parseInt(total) - parseInt(totalinvdist);
            //         }
            //         else if(totaldisct_typ  == 2)
            //         {
            //             if(totalinvdist > 100)
            //             {
            //                 $('.totalinvdist').val("0");
            //             }
            //             else
            //             {
            //                 if(totalinvdist == 0)
            //                 {
            //                     grand_total = total;
            //                 }
            //                 else
            //                 {
            //                     grand_total =  percentcalc(totalinvdist,total);
            //                 }
            //             }
            //         }
            //         console.log(grand_total);
            //         $('#grand_total').val(grand_total);
            //     });
            // });
            // $(document).ready(function(){
            //     $('.est_date').change(function(){
            //         $('.exp_date').val('');
            //         var est_date  = $(this).val();
            //         $('.date').datetimepicker('setStartDate', est_date);
            //     });
            //     $('.est_date').click(function(){
            //         $('.date').datetimepicker('setStartDate', '{{$compact_array["today"]}}');
            //     });
            // });
        </script>
        </body>
        </html>