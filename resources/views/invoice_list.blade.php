@include('header')
@include('sidebar')

        <div class="ts-main-content">

            <div class="content-wrapper myprofile">
                <div class="content-header col-sm-12">
                   <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Accounts</a></li>
                        <li class="active">New Invoices</li>
                    </ol>
                </div>
                <div class="col-sm-12 col-xs-12">                    
                    <h3 class="page-title">New Invoices</h3>
                    <div class="row">
                        <div class="col-sm-4  col-xs-12">
                            <div class="form-group field-wrapper1">
                                <label>Select Your Client</label>
                                <select class="form-control registration_year required-des" name="registration_year" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option"> 
                                    <option value="">Select Your Client</option>
                                    <option vlaue="1">Client1</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class='input-group  field-wrapper1'>
                                <span class="input-group-addon">
                                    S0S0
                                </span>
                                <label>Invoice Code & Number</label>
                                <input type='text'  placeholder="Invoice Code & Number" class="form-control data-number"  data-validation="required" data-validation-optional="false"  maxlength="15" data-validation-error-msg="Please Enter Number" />
                            </div>
                        </div>
                    </div><!-- end outer row -->
                    <div class="row">
                        <div class="col-sm-4  col-xs-12">
                            <div class="form-group field-wrapper1">
                                <label>Currency</label>
                                <input type='text' placeholder="Currency" value="Rs" class="form-control" disabled="" />
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class='input-group date field-wrapper1'>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <label>Date</label>
                                <input type='text' class="form-control" placeholder="Date" data-validation="date" data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" />
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class='input-group date field-wrapper1'>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <label>Due Date</label>
                                <input type='text' class="form-control" placeholder="Due Date" data-validation="date" data-validation-optional="true"  maxlength="15" data-validation-error-msg="Please Enter Valid Date" />
                            </div>
                        </div>
                    </div>
                    <div class="hr-dashed"></div>
                    <div class="row">
                        <div class="col-xs-12" id="no-more-tables">
                            <table id="zctb" class="display table  clone-row table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">
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
                                <tbody class="vert-align text-center invoicebody">
                                    <tr class="tr_clone">
                                        <td data-title="Crt" class="sno">1</td>
                                        <td data-title="Product">
                                            <select class="form-control registration_year required-des watermark" name="registration_year" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option"> 
                                                <option value="">Choose</option>
                                                <option vlaue="1">1</option>
                                                <option vlaue="2">2</option>
                                            </select>
                                        </td>
                                        <td  data-title="Quantity" class="col-xs-12 col-sm-1">
                                            <input class="form-control data-number" type="text" max-length="3">
                                        </td>
                                        <td  data-title="Price"  class="col-xs-12 col-sm-1">
                                            <input class="form-control data-number" type="text" max-length="3">
                                        </td>
                                        <td  data-title="Tax Rate"  class="col-xs-12 col-sm-1">
                                            <select class="form-control registration_year required-des watermark" name="registration_year" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option"> 
                                                <option value="">Choose</option>
                                                <option vlaue="1">10%</option>
                                                <option vlaue="2">20%</option>
                                            </select>
                                        </td>
                                        <td  data-title="Discount"  class="col-xs-12 col-sm-1">
                                            <input class="form-control data-number" type="text" max-length="3">
                                        </td>
                                        <td  data-title="Type"  class="col-xs-12 col-sm-1">
                                            <select class="form-control registration_year required-des watermark" name="registration_year" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option"> 
                                                <option value="">Choose</option>
                                                <option vlaue="1">Amount</option>
                                                <option vlaue="2">%</option>
                                            </select>
                                        </td>
                                        <td  data-title="Sub-Total">0.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger remove-item" disabled=""><i class="fa fa-remove"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <div class="col-xs-12 col-sm-6 form-inline">
                                                <input type="text" name="invoiceDiscount" class="form-control" autocomplete="off" placeholder="Invoice Discount">
                                            </div>
                                            <div class="col-xs-12 col-sm-6 form-inline">
                                                <select name="invoiceDiscountType" class="form-control solsoEvent" data-parsley-id="5711">
                                                    <option value="" selected="">choose</option>
                                                    <option value="1">Amount</option>
                                                    <option value="2">%</option>
                                                </select>							
                                            </div>
                                        </td>
                                        <td colspan="5">
                                            <h3 class="pull-left">TOTAL</h3>
                                            <h3 class="pull-right">
                                                <span class="solsoTotal">0.00</span>
                                            </h3>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="text-center">
                            <button class="tr_clone_add btn btn-primary">Add New Product</button>
                        </div>
                        <div class="hr-dashed"></div>
                        <div class="col-xs-12 col-sm-6 text-areaheig">
                            <label>Invoice Extra Information (This Text Will Not Apear On PDF Document)</label>
                            <textarea class="col-xs-12 col-sm-12 form-control" type="text"></textarea></div>
                        <div class="col-xs-12 col-sm-6">
                            <label>Add Payment</label>
                            <h6 class="page-title">Next fields are not mandatory, you can insert first/total payment for this invoice</h6>
                            <div class="row"><div class="col-xs-12 col-sm-4">
                                    <div class="form-group field-wrapper1">
                                        <label>Amount Paid</label>
                                        <input type="text" class="form-control"  placeholder="Amount Paid">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group field-wrapper1">
                                        <label>Date</label>
                                        <input type="text" class="form-control date"  placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group field-wrapper1">
                                        <label>Payment Method</label>
                                        <input type="text" class="form-control"  placeholder="Payment Method">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-dashed"></div>
                        <div class="col-xs-12"><button class="btn btn-primary">Submit</button></div>
                        <div class="hr-dashed"></div>

@include('footer')
                    </div>
                </div>
                <div class="modal fade" id="popup" tabindex="-1" role="dialog" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="myModalLabel">Create New Product</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form method="post">

                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group field-wrapper1">
                                                <label> Name</label>
                                                <input type="text" class="form-control" placeholder="Name">
                                            </div></div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group field-wrapper1">
                                                <label>Code</label>
                                                <input type="text" class="form-control" placeholder="Code">
                                            </div></div>


                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group field-wrapper1">
                                                <label>Price</label>
                                                <input type="text" class="form-control data-number" placeholder="Price">
                                            </div></div>

                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group field-wrapper1">
                                                <label>Description</label>
                                                <textarea class="form-control">Description</textarea>
                                            </div></div>



                                    </form></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary send-again">Submit</button>
                                <button type="button" class="btn btn-primary">Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Loading Scripts -->
                <script src="js/jquery.min.js"></script>
                <script src="js/bootstrap-select.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/fileinput.js"></script>
                <script src="js/label-slide.js"></script>
                <script src="js/dealerplus.js"></script>
                <script src="js/menu.js"></script>
               
                <script src="js/bootstrap-datetimepicker.min.js"></script>
                <script>

            $(document).on('click', ".remove-item", function () {
                $(this).parent().parent().remove();
                $(".sno").each(function (index) {
                    console.log(index + 1);
                    $(this).text(index + 1);
                });
            });
            $(".tr_clone_add").on('click', function () {
                var $tr = $(".clone-row").children().children('.tr_clone');
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $clone.removeClass('tr_clone');
                $clone.find('[disabled]').removeAttr("disabled");
                $('.invoicebody').append($clone);
                $(".sno").each(function (index) {
                    console.log(index + 1);
                    $(this).text(index + 1);
                });
            });
