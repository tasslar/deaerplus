@include('header')
<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="content-header col-sm-12">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Accounts</a></li>
                <li class="active">New Quotes</li>
            </ol>
        </div>
        <form method="post" action="{{url('insertquotes')}}">
            <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
            <div class="col-sm-12 col-xs-12">
                <h3 class="page-title">New Quotes</h3>
                <div class="row">
                    @if(Session::has('message'))
                                <div class="alert alert-danger" id="message-err">{{ Session::get('message') }}
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                </div>
                                @endif
                    <div class="col-sm-4  col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Select Your Client</label>
                            <select class="form-control required-des" name="client" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                <option value="" disabled="disabled" selected="selected">Select Your Client</option>
                                @foreach($compact_array['client'] as $fetch)
                                <option value="{{$fetch->contact_management_id}}">{{$fetch->contact_first_name}},{{$fetch->contact_phone_1}},{{$fetch->contact_email_1}}</option>
                                @endforeach
                                <!-- <input type="hidden" name="client"> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Reference</label>
                            <input type='text' placeholder="Reference" class="form-control" name="reference" data-validation="required" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Reference" />
                        </div>

                    </div>
                </div><!-- end outer row -->
                <div class="row">
                    <div class="col-sm-4  col-xs-12">
                        <!-- <div class="form-group field-wrapper1">
                            <label>Estimate</label>
                            <input type='text' placeholder="Estimate" name="estimate" class="form-control data-number"  data-validation="date" data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" />
                        </div> -->
                        <div class='input-group date field-wrapper1'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Estimate Date</label>
                            <input type='text' class="form-control est_date" name="estimate_date"  data-validation="date" data-validation-optional="true" placeholder="Estimate Date" value="{{$compact_array['date']}}" maxlength="15" data-validation-error-msg="Please Enter Valid Date" readonly />
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class='input-group field-wrapper1 date' id="datetimepickerfund">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <label>Expiry Date</label>
                            <input type='text' placeholder="Expiry Date" name="expiry_date" class="form-control exp_date"  data-validation="date"  data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" readonly  value="{{$compact_array['last_day_this_month']}}" />
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-sm-4  col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label class="show">Currency</label>
                            <input type='text' placeholder="Currency" name="currency" value="Rs" class="form-control" disabled="" />
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="form-group field-wrapper1">
                            <label>Reference</label>
                            <input type='text' placeholder="Reference" class="form-control" name="reference" data-validation="required" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Reference" />
                        </div>
                    </div>
                </div> -->
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="vert-align text-center invoicebody tbodydata">
                                <tr class="tr_clone">
                                    <td data-title="Crt" class="sno">1</td>
                                    <td data-title="Product"><select class="form-control registration_year required-des watermark car_listing testclass" name="product[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" onchange="fun(this)">
                                            <option class="option1" value="" disabled="disabled" selected="selected">Choose</option>
                                            @foreach($compact_array['car_listing'] as $fetch_car)
                                            <option value="{{$fetch_car->car_id}}" car_id ="{{$fetch_car->car_id}}">{{$fetch_car->model_name}},{{$fetch_car->variant_name}}</option>@endforeach                                        
                                        </select>
                                        <br/>
                                        <textarea class="form-control cardescription" name="cardescription[]" placeholder="Description"></textarea>
                                    </td>
                                    <td  data-title="Quantity" class="col-xs-12 col-sm-1">
                                        <input class="form-control data-number quantity" id="quantity0" type="text" name="quantity[]" max-length="3" value="1" disabled="disabled">
                                        <input type="hidden" name="quantity[]" value="1">
                                    </td>
                                    <td  data-title="Price"  class="col-xs-12 col-sm-1 ">
                                        <input class="form-control data-number carprice invent-select" id="test0" value="" type="text" name="price[]" max-length="3" onkeypress="return validatedecimalKeyPress(this,event);">
                                    </td>
                                    <td  data-title="Tax Rate"  class="col-xs-12 col-sm-1">
                                        <select class="form-control invent-select form-control registration_year required-des watermark tax_rate" name="taxrate[]" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option" id="tax_rate0" >
                                            <option value="" disabled="disabled">Choose</option>
                                            <option value="10" selected="selected">10%</option>
                                            <option value="20">20%</option>
                                        </select>
                                    </td>
                                    <td  data-title="Discount"  class="col-xs-12 col-sm-1">
                                        <input class="form-control data-number discount" id="discount0" type="text" max-length="3" name="discount[]" value="0" onkeypress="return validatedecimalKeyPress(this,event);">
                                    </td>
                                    <!-- <td  data-title="Type"  class="col-xs-12 col-sm-1">
                                        <select class="form-control invent-select form-control registration_year required-des watermark amt_type" name="type[]" data-validation="required" id="amt_type" data-validation-optional="false" data-validation-error-msg="Please Select One Option" onchange="fundis(this, 'amt_type')">
                                            <option value="" class="option3" disabled="">Choose</option>
                                            <option vlaue="1" selected="selected">Amount</option>
                                            <option vlaue="2">%</option>
                                        </select>
                                    </td> -->
                                    <td  data-title="Type"  class="col-xs-12 col-sm-1">
                                        <select class="invent-select registration_year required-des watermark amt_type" name="type[]" data-validation="required" id="amt_type0" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                            <option value="" class="option3" disabled="">Choose</option>
                                            <option value="1" selected="selected">Amount</option>
                                            <option value="2">%</option>
                                        </select>
                                    </td>
                                    <td class="subtotal">                                        
                                        <input class="form-control data-number sub_total" id="sub_total0" type="text" max-length="3" name="subtotal[]" value="0.00" onkeypress="return validatedecimalKeyPress(this,event);">
                                        <input type="hidden" name="totalval" class="totalval" id="totalval"  value="">
                                    </td>
                                    <td><button class="btn btn-sm btn-danger remove-item"  disabled=""><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div class="col-xs-12 col-md-5 form-inline">
                                            <label>Discount</label>
                                            <input type="text" name="invoiceDiscount" class="form-control totalinvdist" autocomplete="off" placeholder="Invoice Discount" value="0" id="totalinvdist" onkeypress="return validatedecimalKeyPress(this,event);">
                                        </div>
                                        <div class="col-xs-12 col-md-3 form-inline">
                                            <label>Discount type</label>
                                            <select name="invoiceDiscountType" class="form-control solsoEvent totaldisct_typ" id="totaldisct_typ" data-parsley-id="5711">
                                                <option value="">choose</option>
                                                <option value="1" selected="selected">Amount</option>
                                                <option value="2">%</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-md-4 form-inline">
                                            <br/><button class="tr_clone_add btn btn-primary clear_total" type="button">Add New Product</button></div>
                                    </td>
                                    <td colspan="5">
                                        <div class="col-xs-12"><h3 class="pull-left">Total</h3>
                                            <!-- <h3 class="pull-right">
                                            <span class="solsoTotal">
                                                 <input type="text" name="grand_total" class="form-control grand_total" autocomplete="off" placeholder="Invoice Discount" id="grand_total" value="0.00">
    
                                            </span>
                                            </h3> -->
                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>
                                                <input type="text" name="grand_total" class="form-control grand_total" autocomplete="off" placeholder="Invoice Discount" id="grand_total" value="0.00" onkeypress="return validatedecimalKeyPress(this,event);">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <h3 class="pull-left">Final Discount</h3>

                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>
                                                <input type="text" class="form-control" name="finaldiscounts" autocomplete="off" placeholder="Final Discount" id="finaldiscount" onkeypress="return validatedecimalKeyPress(this,event);">
                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="display: none;">
                                            <h3 class="pull-left">Final Amount</h3>

                                            <div class='pull-right input-group field-wrapper1 col-xs-6'>
                                                <span class="input-group-addon">
                                                    Rs.
                                                </span>
                                                <input type="text" class="form-control finalamount" autocomplete="off" placeholder="Final Amount">
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
                    <div class="text-center"> </div>
                    <div class="hr-dashed"></div>
                    <div class="col-xs-12 col-sm-6 text-areaheig">
                        <label>Description</label>
                        <textarea class="col-xs-12 col-sm-12 form-control" name="description" type="text"></textarea></div>
                    <div class="col-xs-12 col-sm-6  text-areaheig">
                        <label>Terms & Conditions</label>
                        <textarea class="col-xs-12 col-sm-12 form-control" name="term_cond" type="text"></textarea>
                    </div>
                    <div class="hr-dashed"></div>
                   <!--  <div class="col-xs-12"><button class="btn btn-primary">Submit</button></div> -->
                    <div class="hr-dashed"></div>
                    @include('footer')
                </div>
            </div>
        </form>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/label-slide.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/dealerplus.js"></script>
        <script type="text/javascript" src="js/calculation.js"></script>
        <script type="text/javascript">
            function validatedecimalKeyPress(el, evt) {
                    var charCode = (evt.which) ? evt.which : event.keyCode;
                    var number = el.value.split('.');
                    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    //just one dot
                    if (number.length > 1 && charCode == 46) {
                        return false;
                    }
                    //get the carat position
                    var caratPos = getSelectionStart(el);
                    var dotPos = el.value.indexOf(".");
                    if (caratPos > dotPos && dotPos > -1 && (number[1].length > 1)) {
                        return false;
                    }
                    return true;
                }
            $('.date').datetimepicker('setStartDate', '{{$compact_array["date"]}}');
            $("body").on("click", ".cancelbutton", function () {
                    window.location.replace("{{url('managequotes')}}");
                });
            $('#message-err').delay(1000).fadeOut(1000);
            /*$(document).('onchange','.est_date',function(){
                var est_date =$(this).val();
                console.log(est_date);
            });*/
            $(document).ready(function(){
                $('.est_date').change(function(){
                    $('.exp_date').val('');
                    var est_date  = $(this).val();
                    $('.date').datetimepicker('setStartDate', est_date);
                });
                $('.est_date').click(function(){
                    $('.date').datetimepicker('setStartDate', '{{$compact_array["date"]}}');
                });
            });
        </script>
        </body>
        </html>