@include('header')       
<div class="ts-main-content">
    @include('sidebar')       
    <div class="content-wrapper myprofile">
        <div class="container-fluid">
            <div class="row">
                <div class="content-header col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('manageEmployee')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                        <li class="active">Employee</li>
                    </ol>
                </div>

                <div class="col-xs-12">
                    <h2 class="page-title col-xs-12">Manage Employee</h2>
                    <div class="row">
                        <div class="col-xs-12 subscription">
                            @if(Session::has('message'))
                            <div class="alert alert-danger" id="message-err">{{ Session::get('message') }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                            @endif
                            <div class="alert alert-success message_sucess" id="message_sucess" style="display:none">
                                Employee Updated Successfully
                                <a href="#" class="close showallerror" data-dismiss="alert" aria-label="close">&times;</a>
                            </div>
                            <div class="alert alert-danger message_err" id="message-err" style="display:none">
                                    Please enter all mandatory fields
                                    <a href="#" class="close showallerror" data-dismiss="alert" aria-label="close">&times;</a>
                            </div>
                            <div class="panel-body row">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#details"  data-toggle="tab" aria-expanded="false">Employee Details</a></li>
                                    <li ><a href="#documents" id="documents_tab" data-toggle="tab" aria-expanded="true">Documents</a></li>
                                </ul>
                                <br>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane fade active in" id="details">
                                        <form method="post" id="employee_details" action="{{url('insertemployee')}}" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="hidden" name="employee_insert" class="employee_insert">
                                            <input type="hidden" name="employee_management_id" value="{{$compact_array['fetch_employee_mgmt']->employee_management_id}}">
                                            <div class="col-xs-12 card">
                                                <div class="row">
                                                    <div class="col-sm-2 col-xs-12">
                                                        <div class="addimage">
                                                            <div class="form-group">
                                                                <div>
                                                                    @if($compact_array['fetch_employee_mgmt']->employee_user_image)
                                                                    <img src="{{$compact_array['fetch_employee_mgmt']->employee_user_image}}" class="image">
                                                                    @else
                                                                    <img src="img/noimage.jpg" class="image">
                                                                    @endif
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="fileUpload btn-primary">
                                                            <span>Change Image</span>
                                                            <input type="file" name="contact_image" class="upload"  id="profile_image" data-validation-optional="true"  data-validation-allowing="jpg, png" data-validation-error-msg="Please Upload Images" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <h3 class="inn-head">Basic Information</h3>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-xs-12">   
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Select employee Type</label>
                                                                            <select class="form-control required-des" name="contact_type_id" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Select One Option">
                                                                                <option disabled="" value="" selected="selected">Select employee Type</option>
                                                                                @foreach($compact_array['employee_type'] as $fetch)
                                                                                @if($fetch->employee_type_id == $compact_array['fetch_employee_mgmt']->employee_type)
                                                                                <option value="{{$fetch->employee_type_id}}" selected="selected">{{$fetch->employee_type}}</option>  
                                                                                @else
                                                                                <option value="{{$fetch->employee_type_id}}">{{$fetch->employee_type}}</option>
                                                                                @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>     
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">    
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>First Name</label>
                                                                            <input type="text" name="contact_first_name" value="{{$compact_array['fetch_employee_mgmt']->employee_first_name}}" class="form-control required-des" placeholder="First Name"  data-validation-optional="false" placeholder="First Name" data-validation="length,required" data-validation-length="max50" data-validation-error-msg="Please Enter Valid Name">
                                                                        </div>     
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">    
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Last Name</label>
                                                                            <input type="text" name="contact_last_name" class="form-control" value="{{$compact_array['fetch_employee_mgmt']->employee_last_name}}" placeholder="Last Name" data-validation="length" data-validation-optional="true" data-validation-length="max50" data-validation-error-msg="Please Enter Valid Name">
                                                                        </div>     
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">    
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Select Designation</label>
                                                                            <select class="form-control" name="contact_designation"  data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                <option value="" disabled=" selected">Select Designation</option>
                                                                                @if($compact_array['fetch_employee_mgmt']->employee_designation == "mr")
                                                                                <option value="mr" selected="selected">Mr</option>
                                                                                <option value="mrs">Mrs</option>
                                                                                <option value="miss">Miss</option>
                                                                                <option value="dr">Dr</option>
                                                                                @elseif($compact_array['fetch_employee_mgmt']->employee_designation == "mrs")
                                                                                <option value="mr">Mr</option>
                                                                                <option value="mrs" selected="selected">Mrs</option>
                                                                                <option value="miss">Miss</option>
                                                                                <option value="dr">Dr</option>
                                                                                @elseif($compact_array['fetch_employee_mgmt']->employee_designation == "miss")
                                                                                <option value="mr">Mr</option>
                                                                                <option value="mrs">Mrs</option>
                                                                                <option value="miss" selected="selected">Miss</option>
                                                                                <option value="dr">Dr</option>
                                                                                @elseif($compact_array['fetch_employee_mgmt']->employee_designation == "dr")
                                                                                <option value="mr">Mr</option>
                                                                                <option value="mrs">Mrs</option>
                                                                                <option value="miss">Miss</option>
                                                                                <option value="dr" selected="selected">Dr</option>
                                                                                @else
                                                                                <option value="mr">Mr</option>
                                                                                <option value="mrs">Mrs</option>
                                                                                <option value="miss">Miss</option>
                                                                                <option value="dr">Dr</option>
                                                                                @endif
                                                                            </select>
                                                                        </div>     
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">    
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Select Gender</label>
                                                                            <select class="form-control" name="contact_gender"  data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                <option value="" selected="" disabled="disabled">Select Gender</option>
                                                                                @if($compact_array['fetch_employee_mgmt']->employee_gender == "male")
                                                                                <option value="1" selected="selected">Male</option>
                                                                                <option value="2">Female</option>
                                                                                @elseif($compact_array['fetch_employee_mgmt']->employee_gender == "female")
                                                                                <option value="1">Male</option>
                                                                                <option value="2" selected="selected">Female</option>
                                                                                @endif
                                                                            </select>
                                                                        </div>     
                                                                    </div>
                                                                </div></div>
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Mobile Number</label>
                                                                            <input maxlength="10" type="text" name="contact_phone_1"  class="form-control data-number required-des" placeholder="Mobile Number" data-validation="required,length" data-validation-length="8-11" data-validation-optional="false" data-validation-error-msg="Please Enter Valid Number" value="{{$compact_array['fetch_employee_mgmt']->employee_moblie_no}}">
                                                                        </div>  
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Landline Number</label>
                                                                            <input maxlength="13" type="text" name="contact_phone_2"  class="form-control data-number" placeholder="Landline Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number" value="{{$compact_array['fetch_employee_mgmt']->employee_landline_no}}">
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Email Id</label>
                                                                            <input type="email" name="contact_email_1"  class="form-control required-des" placeholder="Email Id" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email" value="{{$compact_array['fetch_employee_mgmt']->employee_email_1}}">
                                                                        </div>  
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Other Email Id</label>
                                                                            <input type="email" name="contact_email_2"  class="form-control" placeholder="Other Email Id" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email" value="{{$compact_array['fetch_employee_mgmt']->employee_email_2}}">
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12">
                                                                <h3 class="inn-head">Additional Information</h3>
                                                                <div class="row">
                                                                    <div  id="contactemail">
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing Address</label>
                                                                                <input type="text" value="{{$compact_array['fetch_employee_mgmt']->employee_mailing_address}}" class="form-control " id="addre" placeholder="Mailing Address"  data-validation-optional="true" data-validation-length="max100" name="mailing_address" data-validation-error-msg="Please Enter Valid Address">
                                                                            </div>  
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing Locality</label>
                                                                                <input type="hidden" value="chennai" class="form-control" placeholder="Mailing Locality" data-validation="alphanumeric,length" data-validation-optional="true" data-validation-length="max100" name="mailing_locality" data-validation-error-msg="Please Enter Valid Place">
                                                                            </div> 
                                                                        </div>
                                                                        <div class="col-xs-12">    
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing State</label>
                                                                                <select class="form-control sta" name="contact_mailing_state" data-validation-optional="true" data-validation="alphanumeric, length" data-validation-length="max100" data-validation-error-msg="Please Select One Option">
                                                                                    <option value="" disabled="selected">Select State</option>
                                                                                    @foreach($compact_array['state'] as $fetch)
                                                                                    @if($fetch->id == $compact_array['fetch_employee_mgmt']->employee_state)
                                                                                    <option selected="selected" value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>     
                                                                        </div>
                                                                        <div class="col-xs-12">    
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing City</label>
                                                                                <select name="contact_mailing_city"  class="form-control" id="citys" data-validation-optional="true" data-validation="alphanumeric, length" data-validation-length="max100" data-validation-error-msg="Please Select One Option"> 
                                                                                    <option value="">Select City</option>
                                                                                    @foreach($compact_array['city'] as $fetch)
                                                                                    @if($compact_array['fetch_employee_mgmt']->employee_city == $fetch->city_id)
                                                                                    <option selected="selected" value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>     
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing Pincode</label>
                                                                                <input maxlength="6" name="contact_mailing_pincode" type="text" class="form-control  data-number" placeholder="Mailing Pincode" placeholder="Mailing Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode" value="{{$compact_array['fetch_employee_mgmt']->employee_mailing_pincode}}">
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary col-sm-3 col-lg-2 update_employee">Save</button>
                                                <button type="button" class="btn btn-danger col-sm-3 col-lg-2 back">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="documents">
                                        <div  class="col-xs-12 card">
                                            <h2 class="page-title col-xs-12"><span class="detail-title1">Document Details</span></h2>
                                                <form method="post" id="document_insert" action="{{url('update_document')}}" enctype="multipart/form-data">
                                            <div id="contactdocument">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <input type="hidden" name="employee_management_id" value="{{$compact_array['fetch_employee_mgmt']->employee_management_id}}">
                                                    @if($compact_array['document_count'] > 0)
                                                    <input type="hidden" name="document_id" value="{{$compact_array['fetch_employee_doc']->dealer_employee_doc_mgmt_id}}">
                                                    @endif
                                                    <div id="contactdocumentClones" class="cloneSet contactAddressC">
                                                        <input type="hidden" name="last_id" class="last_id">
                                                        <input type="hidden" name="document" value="{{$compact_array['document_count']}}">
                                                        <div class="col-xs-12 document">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <div class="panel panel-info">
                                                                        <div class="panel-heading">
                                                                            <h4 class="panel-title">Id</h4>
                                                                        </div>
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-4">    
                                                                                    @if($compact_array['document_count'] == 0)
                                                                                    <div class="form-group field-wrapper1">
                                                                                        <label>ID Type</label>
                                                                                        <select class="form-control" name="document_id_type" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                            <option value="">Select Id Type</option>
                                                                                            <option value="">Passport</option>
                                                                                            <option value="">Driving License</option>
                                                                                            <option value="">Voter Id</option>
                                                                                        </select>
                                                                                    </div>  
                                                                                    @else
                                                                                    <div class="form-group field-wrapper1">
                                                                                        <label>ID Type</label>
                                                                                        <select class="form-control" name="document_id_type" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                            <option value="" selected="selected" disabled="disabled">Select Id Type</option>
                                                                                            @if($compact_array['fetch_employee_doc']->employee_document_id_type == 1)
                                                                                            <option value="1" selected="selected">Passport</option>
                                                                                            <option value="2">Driving License</option>
                                                                                            <option value="3">Voter Id</option>
                                                                                            @elseif($compact_array['fetch_employee_doc']->employee_document_id_type == 2)
                                                                                            <option value="1">Passport</option>
                                                                                            <option value="2" selected="selected">Driving License</option>
                                                                                            <option value="3">Voter Id</option>
                                                                                            @elseif($compact_array['fetch_employee_doc']->employee_document_id_type == 3)
                                                                                            <option value="1">Passport</option>
                                                                                            <option value="2">Driving License</option>
                                                                                            <option value="3" selected="selected">Voter Id</option>
                                                                                            @else
                                                                                            <option value="1">Passport</option>
                                                                                            <option value="2">Driving License</option>
                                                                                            <option value="3">Voter Id</option>
                                                                                            @endif
                                                                                        </select>
                                                                                    </div> 
                                                                                    @endif  
                                                                                </div>
                                                                                @if($compact_array['document_count'] == 0)
                                                                                <div class="col-xs-12 col-sm-4">   <div class="form-group field-wrapper1">
                                                                                        <label>ID Number</label>
                                                                                        <input type="text" class="form-control" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15" data-validation-error-msg="Please Enter Valid Id">
                                                                                    </div> 
                                                                                </div>
                                                                                @else
                                                                                <div class="col-xs-12 col-sm-4">   <div class="form-group field-wrapper1">
                                                                                        <label>ID Number</label>
                                                                                        <input type="text" class="form-control" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15" data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['fetch_employee_doc']->employee_document_id_number}}">
                                                                                    </div> 
                                                                                </div>
                                                                                @endif
                                                                                @if($compact_array['document_count'] == 0)
                                                                                <div class="col-sm-4 col-xs-12"><div class='input-group date field-wrapper1' id='datetimepicker5'>
                                                                                        <label>Date of Birth</label>
                                                                                        <input type='text' name="document_dob" class="form-control" readonly placeholder="D.O.B" />
                                                                                        <span class="input-group-addon">
                                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                @else
                                                                                <div class="col-sm-4 col-xs-12"><div class='input-group date field-wrapper1' id='datetimepicker5'>
                                                                                        <label>Date of Birth</label>
                                                                                        <input type='text' readonly name="document_dob" class="form-control" placeholder="D.O.B" value="{{$compact_array['fetch_employee_doc']->employee_document_dob}}" />
                                                                                        <span class="input-group-addon">
                                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-xs-12 mt">
                                                                    <input type="file" id="clear_data" name="employee_document" class="BSbtninfo"/>
                                                                </div>
                                                                <div class="col-sm-6 col-xs-12 mt iddocuments" >
                                                                </div>
                                                                @if($compact_array['document_count'] == 1)
                                                                <a href="{{$compact_array['fetch_employee_doc']->employee_doc_url}}"  download="{{$compact_array['fetch_employee_doc']->employee_document_name}}">download</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>  
                                            <div class="col-xs-12 text-left">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-danger back">Back</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="interaction">
                                        <div id="contactDocuments" class="col-xs-12 card">
                                            <h2 class="page-title col-xs-12"><span class="detail-title1">Interactions</span></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('footer')
            </div>
        </div>
    </div>
</div>
<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
<script src="js/dealerplus.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('js/common.js')}}"></script>
<!-- <script src="js/label-slide.js" type="text/javascript"></script> -->
<script type="text/javascript">
$(document).ready(function () {
    $('.back').click(function () {
            window.location.replace("{{url('manageEmployee')}}");
        }); 
    $('#message-err').delay(1000).fadeOut(3000);
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = d.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;
        $('#datetimepicker5').datetimepicker("setEndDate", new Date());
        //$('.date').datetimepicker('setStartDate', '2017-05-02');
        $('.date').datetimepicker('setEndDate',output );
    $('.back').click(function () {
        window.location.replace("{{url('manageEmployee')}}");
    });
    $('.update_employee').click(function () {
        $("#loadspinner").css("display", "block");
        var form_data = new FormData($('#employee_details')[0]);
        $.ajax({
            url: "{{url('updateEmployee')}}",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            allowedTypes: "jpg,png,gif,jpeg",
            multiple: true,
            type: 'post',
            success: function (response) {
                $("#loadspinner").css("display", "none");
                $('#documents_tab').click();
                $('.last_id').val(response);
                $('.employee_insert').val(response);
                $('#message_sucess').css("display", "block");
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            },
            error: function (response) {
                $("#loadspinner").css("display", "none");
                $(".message_err").css("display", "block");
            }
        });

    });
});

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.update_document').click(function () {
            $("#loadspinner").css("display", "block");
            var form_data = new FormData($('#document_insert')[0]);
            $.ajax({

                url: "{{url('update_document')}}",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                allowedTypes: "jpg,png,gif,jpeg",
                multiple: true,
                type: 'post',
                success: function (response) {
                    console.log(response);
                    $("#loadspinner").css("display", "none");
                    $('#documents_tab').click();
                    $('#clear_data').val('');
                    $('#message_sucess').css("display", "block");
                    //$('.iddocuments').html('<a href="' + response + '" download="download">Download File</a>');     
                    window.location.replace("{{url('manageEmployee')}}");
                    return false;
                },
                error: function () {
                    $("#loadspinner").css("display", "none");

                }
            });
        });
    });
</script>

<script>
    $(function () {
        $('#profile_image').change(function (e) {
            var img = URL.createObjectURL(e.target.files[0]);
            $('.image').attr('src', img);
        });
    });
    $('.BSbtninfo').filestyle({

        buttonName: 'btn-info',

        buttonText: ' Select a File',

        @if ($compact_array['document_count'] > 0)
        placeholder:'@if(!empty($compact_array["fetch_employee_doc"]->employee_document_name)){{$compact_array["fetch_employee_doc"]->employee_document_name}}@endif'
        @endif
    });

</script>
</body> 

</html>