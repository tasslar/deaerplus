@include('header')
<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="container-fluid">
            <div class="row">
                <div class="content-header col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('managecontact')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                        <li class="active">My Contacts</li>
                    </ol>
                </div>
                <div class="col-xs-12">
                    <h2 class="page-title">Manage Contacts</h2>
                    @if(Session::has('message'))
                    <div class="alert alert-danger" id="message-err">{{ Session::get('message') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                    @endif
                    <div class="alert alert-danger message_err" id="message-err" style="display:none">
                        Please enter all mandatory fields
                        <a href="#" class="close showallerror" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                    <div class="alert alert-success message_sucess" id="message_sucess" style="display:none">
                        Contact Added Successfully
                        <a href="#" class="close showallerror" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                    <div class="alert alert-success message_update" id="message_update" style="display:none">
                        Your details updated successfully
                        <a href="#" class="close showallerror" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 subscription">
                            <div class="panel-body row">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#details"  data-toggle="tab" aria-expanded="false" id="contact_list">Contact Details</a></li>
                                    <li><a id="lead_tab" href="#leadstatus" data-toggle="tab" aria-expanded="true">Lead Details</a></li>
                                    <li ><a href="#documents" id="documents_tab" data-toggle="tab" aria-expanded="true">Documents</a></li>
                                </ul>
                                <br>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane fade active in" id="details">
                                        <div class="col-xs-12 card">
                                            <div class="row">
                                                <form method="post" id="contact_tab" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                                    <input type="hidden" name="documetcount" value="{{$compact_array['document']}}" id="document_count">
                                                    <div class="col-md-3 col-lg-2 col-xs-12">
                                                        <div class="addimage">
                                                            <div class="form-group">
                                                                <div>
                                                                    @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                    <img src="{{URL::asset('img/noimage.jpg')}}" class="image">
                                                                    @else
                                                                    <img src="{{ $compact_array['fetch_contact_data']->user_image}}" class="image">
                                                                    <input type="hidden" name="contact_mgmt_id" value="{{$compact_array['fetch_contact_data']->contact_management_id}}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="fileUpload btn-primary">
                                                            <span>Change Image</span>
                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                            <input type="file" name="contact_image" class="upload contact_image"  id="profile_image" data-validation-optional="true"  data-validation-allowing="jpg, png" data-validation-error-msg="Please Upload Images"/>
                                                            @else
                                                            <input type="file" name="contact_image" class="upload contact_image"  id="profile_image" data-validation-optional="true"  data-validation-allowing="jpg, png" data-validation-error-msg="Please Upload Images"/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 col-lg-10 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <h3 class="inn-head">Basic Information</h3>
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Select Contact Type</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <select class="form-control required-des contact_type_id checkcontact" name="contact_type_id" data-validation="required" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                                <option value="0" selected="true" disabled="disabled">Select Contact Type</option>
                                                                                @foreach($compact_array['contact_type_id'] as $fetch)
                                                                                <option value="{{$fetch->contact_type_id}}">
                                                                                    {{$fetch->contact_type}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control required-des checkcontact"  name="contact_type_id" data-validation="required" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
            @foreach($compact_array['contact_type_id'] as $fetch)
            @if( $compact_array['fetch_contact_data']->contact_type_id == $fetch->contact_type_id )
            <option value="{{$fetch->contact_type_id}}" selected="true">{{$fetch->contact_type}}</option>
            @else
            <option value="{{$fetch->contact_type_id}}">{{$fetch->contact_type}}</option>
            @endif
            @endforeach
            @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Contact Owner</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input type="text" name="contact_owner" class="form-control contact_owner" placeholder="Contact Owner" data-validation="length" data-validation-optional="true" data-validation-length="max100"  data-validation-error-msg="Please Enter Correct Owner">
                                                                            @else
                                                                            <input type="text" value="{{$compact_array['fetch_contact_data']->contact_owner}}" name="contact_owner" class="form-control" placeholder="Contact Owner" data-validation="length" data-validation-optional="true" data-validation-length="max100"  data-validation-error-msg="Please Enter Correct Owner">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>First Name</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input type="text" name="contact_first_name" value="" placeholder="First Name" class="form-control data-name contact_first_name required-des" data-validation-optional="false" placeholder="First Name" data-validation="alphanumeric,length,required" data-validation-allowing="\s_-" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name">
                                                                            @else
                                                                            <input type="text" value="{{$compact_array['fetch_contact_data']->contact_first_name}}" name="contact_first_name" value="" class="form-control required-des data-name" placeholder="First Name" data-validation-optional="false" placeholder="First Name" data-validation="alphanumeric,length,required" data-validation-allowing="\s_-" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Last Name</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input type="text" name="contact_last_name" class="form-control data-name contact_last_name" placeholder="Last Name" data-validation="length" data-validation-optional="true" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name">
                                                                            @else
                                                                            <input type="text" value="{{$compact_array['fetch_contact_data']->contact_last_name}}" name="contact_last_name" class="form-control data-name" placeholder="Last Name" data-validation="length" data-validation-optional="true" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Select Designation</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <select class="form-control contact_designation" name="contact_designation" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                <option value="">Select Designation</option>
                                                                                <option value="mr">Mr</option>
                                                                                <option value="mrs">Mrs</option>
                                                                                <option value="miss">Miss</option>
                                                                                <option value="dr">Dr</option>
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control" name="contact_designation" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                @if('Mr' == $compact_array['fetch_contact_data']->contact_designation)
                                                                                <option  selected="true">{{$compact_array['fetch_contact_data']->contact_designation}}</option>
                                                                                @elseif('Mrs' == $compact_array['fetch_contact_data']->contact_designation) <option  selected="true">{{$compact_array['fetch_contact_data']->contact_designation}}</option>
                                                                                @elseif('mrs' == $compact_array['fetch_contact_data']->contact_designation)<option  selected="true">{{$compact_array['fetch_contact_data']->contact_designation}}</option>
                                                                                @elseif('miss' == $compact_array['fetch_contact_data']->contact_designation)<option  selected="true">{{$compact_array['fetch_contact_data']->contact_designation}}</option>
                                                                                @elseif('dr' == $compact_array['fetch_contact_data']->contact_designation)<option  selected="true">{{$compact_array['fetch_contact_data']->contact_designation}}</option> @else
                                                                                <option value="mr">Mr</option>
                                                                                <option value="mrs">Mrs</option>
                                                                                <option value="miss">Miss</option>
                                                                                <option value="dr">Dr</option>
                                                                                @endif
                                                                            </select>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Select Gender</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <select class="form-control contact_gender required-des" name="contact_gender" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                                <option value="0" selected disabled>Select Gender</option>
                                                                                <option value="male">Male</option>
                                                                                <option value="female">Female</option>
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control required-des" name="contact_gender"  data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                                @if('male' == $compact_array['fetch_contact_data']->contact_gender)
                                                                                <option value="male" selected="true">{{$compact_array['fetch_contact_data']->contact_gender}}</option>
                                                                                <option value="female">Female</option>
                                                                                @elseif('female' == $compact_array['fetch_contact_data']->contact_gender)
                                                                                <option value="female" selected="true">{{$compact_array['fetch_contact_data']->contact_gender}}</option>
                                                                                <option value="male">Male</option>
                                                                                @else
                                                                                <option value="" selected disabled>Select Gender</option>
                                                                                <option value="male">Male</option>
                                                                                <option value="female">Female</option>
                                                                                @endif
                                                                            </select>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-sm-4 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Lead Source</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <select class="form-control contact_lead_source" name="contact_lead_source" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                                <option value="" disabled="disabled" selected="selected">Select Lead Source</option>
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control" name="contact_lead_source"  data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                                <option value="" disabled="disabled" selected="selected">Select Lead Source</option>
                                                                                @if($compact_array['fetch_contact_data']->contact_lead_source == "2")
                                                                                <option selected="true" value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == '3')
                                                                                <option value="2">Advertisement</option>
                                                                                <option selected="true" value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == '4')
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option selected="true" value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == "5")
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option selected="true" value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == 6)
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option selected="true" value="6">Tradeshow</option>
                                                                                @else
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @endif
                                                                            </select>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4 col-xs-12"><div class="checkbox checkbox-primary mt-2x">
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input id="EmailOptOut" name="contact_email_opt_out" class="onlinep contact_email_opt_out" type="checkbox" value="1" checked="">
                                                                            @else
                                                                            @if($compact_array['fetch_contact_data']->contact_email_opt_out == "1")
                                                                            <input id="EmailOptOut" name="contact_email_opt_out"" class="onlinep" type="checkbox" value="1" checked="">
                                                                            @else
                                                                            <input id="EmailOptOut" name="contact_email_opt_out"" class="onlinep" type="checkbox" value="1"> 
                                                                            @endif
                                                                            @endif
                                                                            <label for="EmailOptOut" class="onlinepcheck">
                                                                                Email Subscribed
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4 col-xs-12"><div class="checkbox checkbox-primary mt-2x">
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input id="SmsOptOut" name="contact_sms_opt_out" class="onlinep contact_sms_opt_out" type="checkbox" value="1" checked="">
                                                                            @else
                                                                            @if($compact_array['fetch_contact_data']->contact_sms_opt_out == "1")
                                                                            <input id="SmsOptOut" name="contact_sms_opt_out" class="onlinep" type="checkbox" value="1" checked="">
                                                                            @else
                                                                            <input id="SmsOptOut" name="contact_sms_opt_out" class="onlinep" type="checkbox" value="1">
                                                                            @endif
                                                                            @endif
                                                                            <label for="SmsOptOut" checked="ture" class="onlinepcheck">
                                                                                SMS Subscribed
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <h3 class="inn-head">Contact Information</h3>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-4">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Contact Number</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input maxlength="10" type="text" name="contact_phone_1" value="" class="form-control data-number contact_phone_1 required-des" placeholder="Contact Number" data-validation="required,length" data-validation-length="8-11" data-validation-optional="false" data-validation-error-msg="Please Enter Valid Number">
                                                                            @else
                                                                            <input maxlength="10" type="text" name="contact_phone_1"  value="{{ $compact_array['fetch_contact_data']->contact_phone_1}}" class="required-des form-control data-number" placeholder="Contact Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-4">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Landline Number</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input maxlength="11" type="text" name="contact_phone_3" value="" class="form-control data-number contact_phone_3" placeholder="Landline Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number">
                                                                            @else
                                                                            <input maxlength="11" type="text" name="contact_phone_3" value="{{$compact_array['fetch_contact_data']->contact_phone_3}}" class="form-control data-number" placeholder="Landline Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Email Id</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input type="email" name="contact_email_1" maxlength="40" value="" class="form-control contact_email_1 required-des" style="text-transform: lowercase" placeholder="Email Id" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email">
                                                                            @else
                                                                            <input type="email" name="contact_email_1" maxlength="40" value="{{ $compact_array['fetch_contact_data']->contact_email_1}}" class="form-control required-des" placeholder="Email Id" style="text-transform: lowercase" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Alternate email id</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input type="email" name="contact_email_2" maxlength="40" value="" class="form-control required-des" style="text-transform: lowercase" placeholder="Alternate email id" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email">
                                                                            @else
                                                                            <input type="email" maxlength="40" value="{{ $compact_array['fetch_contact_data']->contact_email_2}}" name="contact_email_2" value="" class="form-control required-des" style="text-transform: lowercase" placeholder="Alternate email id" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6">
                                                                <div class="row">
                                                                    <div  id="contactemail">
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing Address</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <input type="text" name="contact_mailing_address"  class="form-control addr contact_mailing_address" id="addre" placeholder="Mailing Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address">
                                                                                @else
                                                                                <input type="text" name="contact_mailing_address"  class="form-control addr contact_mailing_address" id="addre" placeholder="Mailing Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address" value="{{ $compact_array['fetch_contact_data']->contact_mailing_address}}">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing State</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <select class="form-control sta contact_mailing_state" name="contact_mailing_locality" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                                    <option value="">Select State</option>
                                                                                    @foreach($compact_array['state'] as $fetch)
                                                                                    <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @else
                                                                                <select class="form-control sta contact_mailing_state" name="contact_mailing_locality" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                                    <option value="">Select State</option>
                                                                                    @foreach($compact_array['state'] as $fetch)
                                                                                    @if($fetch->id == $compact_array['fetch_contact_data']->contact_mailing_locality)
                                                                                    <option value="{{$fetch->id}}" selected="">{{$fetch->state_name}}</option>
                                                                                    @else
                                                                                    <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing City</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <select class="form-control contact_mailing_city" name="contact_mailing_city" data-validation="alphanumeric" data-validation-optional="true" id="citys"  data-validation-error-msg="Please Select One Option">
                                                                                    <option value="">Select City</option>
                                                                                    @foreach($compact_array['city'] as $fetch)
                                                                                    <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @else
                                                                                <select class="form-control contact_mailing_city" name="contact_mailing_city" data-validation="alphanumeric" data-validation-optional="true" id="citys"  data-validation-error-msg="Please Select One Option">
                                                                                    <option value="">Select City</option>
                                                                                    @foreach($compact_array['city'] as $fetch)
                                                                                    @if($fetch->city_id == $compact_array['fetch_contact_data']->contact_mailing_city)
                                                                                    <option value="{{$fetch->city_id}}" selected="">{{$fetch->city_name}}</option>
                                                                                    @else
                                                                                    <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Mailing Pincode</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <input maxlength="6" name="contact_mailing_pincode" type="text" class="form-control data-number contact_mailing_pincode" placeholder="Mailing Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode">
                                                                                @else
                                                                                <input maxlength="6" name="contact_mailing_pincode" type="text" value="{{$compact_array['fetch_contact_data']->contact_mailing_pincode}}" class="form-control data-number" placeholder="Mailing Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6">
                                                                <div class="row">
                                                                    <div  id="contactemail">
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Other Address</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <input type="text" name="contact_other_address"  class="form-control other_address contact_other_address" id="address2" placeholder="Other Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address">
                                                                                @else
                                                                                <input type="text" name="contact_other_address"  class="form-control other_address contact_other_address" id="address2" placeholder="Other Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address" value="{{$compact_array['fetch_contact_data']->contact_other_address}}">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Other Mailing State</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <select class="form-control contact_other_state" name="contact_other_locality" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" id="state2">
                                                                                    <option value="">Select State</option>
                                                                                    @foreach($compact_array['state'] as $fetch)
                                                                                    <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @else
                                                                                <select class="form-control  contact_other_state" name="contact_other_locality" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" id="state2">
                                                                                    <option value="">Select State</option>
                                                                                    @foreach($compact_array['state'] as $fetch)
                                                                                    @if($fetch->id == $compact_array['fetch_contact_data']->contact_other_locality)
                                                                                    <option selected="" value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                                    @else
                                                                                    <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Other City</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <select class="form-control contact_other_city" name="contact_other_city" data-validation="alphanumeric" id="citys2" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                    <option value="">Select City</option>
                                                                                    @foreach($compact_array['city'] as $fetch)
                                                                                    <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @else
                                                                                <select class="form-control contact_other_city" name="contact_other_city" data-validation="alphanumeric" id="citys2" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                                    <option value="">Select City</option>
                                                                                    @foreach($compact_array['city'] as $fetch)
                                                                                    @if($fetch->city_id == $compact_array['fetch_contact_data']->contact_other_city)
                                                                                    <option selected="" value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                                    @else
                                                                                    <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Add Other Pincode</label>
                                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                                <input maxlength="6" name="contact_other_pincode" type="text"  class="form-control data-number contact_other_pincode" placeholder="Other Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode">
                                                                                @else
                                                                                <input maxlength="6" name="contact_other_pincode" type="text" value="{{$compact_array['fetch_contact_data']->contact_other_pincode}}"  class="form-control data-number" placeholder="Other Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                <h3 class="inn-head">Employement Information</h3>
                                                                <div class="row">
                                                                    <div class="col-sm-4 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Pan Number</label>
                                                                            <input  type="text"  class="form-control data-name pan_number" placeholder="Pan Number" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pancard Number" name="pan_number" value="" maxlength="10" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-8 col-xs-12 hidden info_type">
                                                                        <div class="checkbox checkbox-primary mt-2x">
                                                                            <div class="checkbox checkbox-primary  checkbox-inline">
                                                                                <input type="radio" id="Business" value="1" name="employee_information_type">
                                                                                <label for="Business"> Business </label>
                                                                            </div>
                                                                            <div class="checkbox checkbox-primary  checkbox-inline">
                                                                                <input type="radio" id="Employee" value="2" name="employee_information_type">
                                                                                <label for="Employee"> Employee </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 disp-employe employee_div">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Employee Type</label>
                                                                                    <select class="form-control emp_type" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="employeetype">
                                                                                        <option value="" disabled="disabled" selected="selected">Select Employee Type</option>
                                                                                        <option value="1">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Salary </label>
                                                                                    <input maxlength="10" name="salary" type="text"  class="form-control data-number salary_val " placeholder="Salary per month" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xs-12 disp-busi business_div">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Type</label>
                                                                                    <select class="form-control business_type_val" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="business_type">
                                                                                        <option value="" disabled="disabled" selected="selected">Select Employee Type</option>
                                                                                        <option value="1">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Name</label>
                                                                                    <input name="contact_business_name" type="text"  class="form-control data-text businessname" placeholder="Business Name" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <h3 class="inn-head">Employement Information</h3>
                                                                <div class="row pannum">
                                                                    <div class="col-sm-4 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Pan Number</label>
                                                                            <input   type="text"  class="form-control pan_number" placeholder="Pan Number" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pancard Number" name="pan_number" value="{{$compact_array['fetch_contact_data']->pan_number}}" maxlength="10" >
                                                                        </div>
                                                                    </div>
                                                                    @if($compact_array['contact_type_lead'] == 0 && $compact_array['contact_type_customer'] == 0)
                                                                    <div class="col-sm-8 col-xs-12 hidden info_type">
                                                                        <div class="checkbox checkbox-primary mt-2x">
                                                                            <div class="checkbox checkbox-primary  checkbox-inline">
                                                                                <input type="radio" id="Business" value="1" name="employee_information_type">
                                                                                <label for="Business"> Business </label>
                                                                            </div>
                                                                            <div class="checkbox checkbox-primary  checkbox-inline">
                                                                                <input type="radio" id="Employee" value="2" name="employee_information_type">
                                                                                <label for="Employee"> Employee </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 disp-employe employee_div">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Employee Type</label>
                                                                                    <select class="form-control emp_type" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="employeetype">
                                                                                        <option value="" disabled="disabled" selected="selected">Select Employee Type</option>
                                                                                        <option value="1">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Salary </label>
                                                                                    <input maxlength="10" name="salary" type="text"  class="form-control data-number salary_val" placeholder="Salary per month" data-validation-length="6" data-validation="" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xs-12 disp-busi business_div">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Type</label>
                                                                                    <select class="form-control business_type_val" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="business_type">
                                                                                        <option value="" disabled="disabled" selected="selected">Select Employee Type</option>
                                                                                        <option value="1">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Name</label>
                                                                                    <input name="contact_business_name" type="text"  class="form-control data-text businessname" placeholder="Business Name" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @if($compact_array['contact_type_lead'] == 1 || $compact_array['contact_type_customer'] == 1)
                                                                    <div class="col-sm-8 col-xs-12  info_type">
                                                                        <div class="checkbox checkbox-primary mt-2x">
                                                                            @if($compact_array['fetch_contact_data']->employee_information_type == "Business")
                                                                            <div class="checkbox checkbox-primary  checkbox-inline">
                                                                                <input type="radio" id="Business" value="1" name="employee_information_type" checked="">
                                                                                <label for="Business"> Business </label>
                                                                            </div>
                                                                            <div class="checkbox checkbox-primary  checkbox-inline employeechecked">
                                                                                <input type="radio" id="Employee" value="2" name="employee_information_type" >
                                                                                <label for="Employee"> Employee </label>
                                                                            </div>
                                                                            @elseif($compact_array['fetch_contact_data']->employee_information_type == "Employee")
                                                                            <div class="checkbox checkbox-primary  checkbox-inline busesschecked">
                                                                                <input type="radio" id="Business" value="1" name="employee_information_type">
                                                                                <label for="Business"> Business </label>
                                                                            </div>
                                                                            <div class="checkbox checkbox-primary  checkbox-inline">
                                                                                <input type="radio" id="Employee" value="2" name="employee_information_type" checked="">
                                                                                <label for="Employee"> Employee </label>
                                                                            </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @if($compact_array['fetch_contact_data']->employee_information_type == "Employee")
                                                                    <div class="col-xs-12 employeehide">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Employee Type</label>
                                                                                    <select class="form-control emp_type" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="employeetype">
                                                                                        <option value="" disabled="disabled" selected="selected">Select Employee Type</option>
                                                                                        @if($compact_array['fetch_contact_data']->employeetype == 1)
                                                                                        <option value="1" selected="">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->employeetype == 2)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option selected="" value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->employeetype == 3)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option selected="" value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->employeetype == 4)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option selected="" value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->employeetype == 5)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option  value="4">Public Ltd Company</option>
                                                                                        <option selected="" value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->employeetype == 6)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option  value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option selected="" value="6">Others</option>
                                                                                        @else
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option  value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @endif
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Salary </label>
                                                                                    <input maxlength="10" name="salary" type="text"  class="form-control data-number salary_val" placeholder="Salary per month" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data" name="salary_per_month" value="{{$compact_array['fetch_contact_data']->salary_per_month}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xs-12 disp-busi business_div">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Type</label>
                                                                                    <select class="form-control business_type_val" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="business_type">
                                                                                        <option value="" disabled="" selected="">Select Business Type</option>
                                                                                        <option value="1">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Name</label>
                                                                                    <input name="contact_business_name" type="text"  class="form-control data-text businessname" placeholder="Business Name" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @if($compact_array['fetch_contact_data']->employee_information_type == "Business")
                                                                    <div class="col-xs-12 disp-employe employee_div">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Employee Type</label>
                                                                                    <select class="form-control emp_type" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="employeetype">
                                                                                        <option value="" disabled="disabled" selected="selected">Select Employee Type</option>
                                                                                        <option value="1">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Salary </label>
                                                                                    <input maxlength="10" name="salary" type="text"  class="form-control data-number salary_val" placeholder="Salary per month" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 buinesshide">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Type</label>
                                                                                    <select class="form-control business_type_val" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="business_type">
                                                                                        <option value="" disabled="" selected="">Select Business Type</option>
                                                                                        @if($compact_array['fetch_contact_data']->business_type == 1)
                                                                                        <option value="1" selected="selected">Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->business_type == 2)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option selected="selected" value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->business_type == 3)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option selected="selected" value="3">Proprietorship Company</option>
                                                                                        <option value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->business_type == 4)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option selected="selected" value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->business_type == 5)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option  value="4">Public Ltd Company</option>
                                                                                        <option selected="selected" value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @elseif($compact_array['fetch_contact_data']->business_type == 6)
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option  value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option selected="selected" value="6">Others</option>
                                                                                        @else
                                                                                        <option value="1" >Private Limited Company</option>
                                                                                        <option value="2">Partnership Firm</option>
                                                                                        <option value="3">Proprietorship Company</option>
                                                                                        <option  value="4">Public Ltd Company</option>
                                                                                        <option value="5">Govt Sector</option>
                                                                                        <option value="6">Others</option>
                                                                                        @endif
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label>Business Name</label>
                                                                                    <input name="Business Name" type="text"  class="form-control data-text businessname" placeholder="Business Name" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data" name="contact_business_name" value="{{$compact_array['fetch_contact_data']->contact_business_name}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @endif
                                                                </div>
                                                                @endif
                                                                <input type="hidden" name="last_id" class="last_id">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 text-left">
                                                        @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                        <button type="button" class="btn btn-primary contact_details">Submit</button>
                                                        @else
                                                        <button type="button" class="btn btn-primary updatecontact">Submit</button>
                                                        @endif
                                                        <!-- <button type="button" class="btn btn-danger nextbtn_contact">Next</button> -->
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="leadstatus">
                                        <div class="col-xs-12 card">
                                            <form method="post" id="leadsform"> 
                                                <input type="hidden" name="last_id" class="last_id" @if(count($compact_array['fetch_contact_data'])>0) value="{{$compact_array['fetch_contact_data']->contact_management_id}}" @endif>
                                                       <input type="hidden" name="_token" id="leadtoken" value="{{csrf_token()}}">
                                                <hr>
                                                <h3 class="page-title">Preferences</h3>
                                                <div class="row">
                                                    <div class="col-lg-7 col-xs-12 five-three">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-4 col-xs-12" style="border-right: 1px solid #ccc;">
                                                                <h4 class="page-title">Region</h4>
                                                                <div class="form-group">
                                                                    <select class="selectpicker" name="buycity[]" multiple data-selected-text-format="count">
                                                                        <option value="" disabled>Select City</option>
                                                                        @foreach($compact_array['city'] as $fetch)                  
                                                                        @if((count($compact_array['regionfetch'])>0)&&in_array('r'.$fetch->city_id.'r', $compact_array['regionfetch']))
                                                                        <option value="{{$fetch->city_id}}" selected>{{$fetch->city_name}}</option>
                                                                        @else
                                                                        <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div> 
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12" style="border-right: 1px solid #ccc;">
                                                                <h4 class="page-title">Manufacturing Make</h4>
                                                                <div class="form-group">
                                                                    <select class="selectpicker make" name="buymake[]" multiple data-selected-text-format="count">
                                                                        <option value = "" disabled>Select Make</option>  
                                                                        @foreach($compact_array['make'] as $key=>$value)
                                                                        @if((count($compact_array['makefetch'])>0)&&in_array('m'.$value->make_id.'m', $compact_array['makefetch']))
                                                                        <option value = "{{$value->make_id}}" selected>{{$value->makename}}</option>  
                                                                        @else
                                                                        <option value = "{{$value->make_id}}">{{$value->makename}}</option>  
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div> 
                                                                <hr>
                                                                <h4 class="page-title">Model</h4>
                                                                <div class="form-group">
                                                                    <select id="model" class="selectpicker model" name="buymodel[]" multiple data-selected-text-format="count">
                                                                        @foreach($compact_array['model'] as $key=>$value)
                                                                        @if((count($compact_array['modelfetch'])>0)&&in_array('mo'.$value->model_id.'mo', $compact_array['modelfetch']))
                                                                        <option value = "{{$value->model_id}}" selected>{{$value->model_name}}</option>  
                                                                        @else
                                                                        <option value = "{{$value->model_id}}">{{$value->model_name}}</option>  
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div> 
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12"  style="border-right: 1px solid #ccc;">
                                                                <h4 class="page-title">Price Range</h4>
                                                                <ul>
                                                                    @foreach($compact_array['getprice_filter'] as $key=>$value)
                                                                    <li>
                                                                        <div class="checkbox checkbox-primary">
                                                                            <input name="pricefliter[]" id="Lakh{{$key}}" type="checkbox" value="{{$value->option_id}}" @if((count($compact_array['pricefilterfetch'])>0)&&in_array('f'.$value->option_id.'f', $compact_array['pricefilterfetch'])) {{ 'checked' }} @endif>
                                                                                   <label for="Lakh{{$key}}">
                                                                                {{$value->option_desc}}
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-xs-12 five-two">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-xs-12" style="border-right: 1px solid #ccc;">
                                                                <h4 class="page-title">Timeline</h4>
                                                                <ul>
                                                                    @foreach($compact_array['gettimeline'] as $key=>$value)
                                                                    <li>
                                                                        <div class="checkbox checkbox-primary">
                                                                            <input name="timeline[]" id="timeline{{$key}}" type="radio" value="{{$value->option_id}}" @if((count($compact_array['timelinefetch'])>0)&&in_array('t'.$value->option_id.'t', $compact_array['timelinefetch'])) {{ 'checked' }} @endif >
                                                                                   <label for="timeline{{$key}}">
                                                                                {{$value->option_desc}}
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-xs-12 text-left">
                                                    <button type="button" class="btn btn-primary saveleads">Save</button>
                                                    <button type="button" class="btn btn-danger leadesback">Back</button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="documents">
                                        <div  class="col-xs-12">
                                            <div id="contactdocument">
                                                <div id="contactdocumentClones" class="cloneSet contactAddressC">
                                                @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                    <form method="post" id="insert_document" action="{{url('document_save')}}"  enctype="multipart/form-data">
                                                    @else
                                                    <form method="post" id="insert_document" action="{{url('updatecontact_doc')}}"  enctype="multipart/form-data">
                                                    @endif
                                                        <input type="hidden" name="documetcount" value="{{$compact_array['document']}}" id="document_count">
                                                        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                                        <div class="col-xs-12 document">
                                                            <div class="col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>ID Type</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <select class="form-control" name="document_id_type">
                                                                                <option>Select Id Proof</option>
                                                                                @foreach($compact_array['document_id'] as $fetch)
                                                                                <option value="{{$fetch->doc_id}}">{{$fetch->doc_id_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control" name="document_id_type" >
                                                                                <option>Select Id Proof</option>
                                                                                @if($compact_array['document']>0)
                                                                                @foreach($compact_array['document_id'] as $fetch)
                                                                                @if($compact_array['fetch_contact_document_data']->document_id_type == $fetch->doc_id)
                                                                                <option value="{{$fetch->doc_id}}" selected="">{{$fetch->doc_id_name}}</option>
                                                                                @else
                                                                                <option value="{{$fetch->doc_id}}">{{$fetch->doc_id_name}}</option>
                                                                                @endif
                                                                                @endforeach
                                                                                @else
                                                                                @foreach($compact_array['document_id'] as $fetch)
                                                                                <option value="{{$fetch->doc_id}}">{{$fetch->doc_id_name}}</option>
                                                                                @endforeach
                                                                                @endif
                                                                            </select>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="last_id" class="last_id">
                                                                    <input type="hidden" name="last_doc_id" class="last_doc_id">
                                                                    <div class="col-xs-12 col-sm-6">   <div class="form-group field-wrapper1">
                                                                            <label>ID Number</label>
                                                                            @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                            <input maxlength="20" type="text" class="form-control data-name" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" maxlength="16" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id">
                                                                            @else
                                                                            @if($compact_array['document']>0)
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>ID Number</label>
                                                                                <input type="text" class="form-control data-name" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric" data-validation-optional="true" data-validation-length="max16"  data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['fetch_contact_document_data']->document_id_number}}" maxlength="16">
                                                                            </div> 
                                                                        </div>
                                                                        <input type="hidden" name="contact_mgmt_id" value="{{$compact_array['fetch_contact_data']->contact_management_id}}">
                                                                        @else
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>ID Number</label>
                                                                            <input type="text" class="form-control data-name" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric"  data-validation-optional="true" data-validation-length="max16"  data-validation-error-msg="Please Enter Valid Id" value="">
                                                                            <input type="hidden" name="contact_mgmt_id" value="{{$compact_array['fetch_contact_data']->contact_management_id}}">
                                                                        </div> 
                                                                    </div>
                                                                    @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6 col-xs-12">
                                                                <div class='input-group date field-wrapper1' id='datetimepicker5'>
                                                                    <label>Date of Birth</label>
                                                                    @if($compact_array['contact_count'] <= $compact_array['contact_value'])
                                                                    <input type='text' readonly name="document_dob" class="form-control" placeholder="D.O.B" data-validation="date" data-validation-optional="true" data-validation-error-msg="Please Select Valid Date"/>
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                    @else
                                                                    @if($compact_array['document']>0)
                                                                    <label>Date of Birth</label>
                                                                    <input type='text' name="document_dob" readonly class="form-control" placeholder="D.O.B" value="{{$compact_array['fetch_contact_document_data']->document_dob}}
                                                                           " />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                    @else
                                                                    <label>Date of Birth</label>
                                                                    <input type='text' name="document_dob"  readonly class="form-control" placeholder="D.O.B" data-validation="date" data-validation-optional="true" data-validation-error-msg="Please Select Valid Date" value="" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                                @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xs-12 iddocuments" >
                                                        </div>
                                                        <div class="col-sm-6 col-xs-12">
                                                            <input type="file" name="contact_document" class="BSbtninfo" placeholder="11">
                                                            @if(!empty($compact_array['fetch_contact_document_data']->doc_link_fullpath))
                                                            <a href="{{$compact_array['fetch_contact_document_data']->doc_link_fullpath}}" download="{{$fetch->doc_id_name}}">Download</a>
                                                            @endif
                                                            <div class="label label-success" id="message" style="display:none;">
                                                            </div>
                                                        </div>             
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 text-left">
                                            <button type="submit" class="btn btn-primary">Save</button> </form>
                                            <button type="button" class="btn btn-danger docsback">Back</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">

<script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script src="{{URL::asset('js/label-slide.js')}}"></script>
<script src="{{URL::asset('js/common.js')}}"></script>
<script src="{{URL::asset('js/citys.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript">

</script>
<script type="text/javascript">

$(document).ready(function () {

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
        (month<10 ? '0' : '') + month + '-' +
        (day<10 ? '0' : '') + day;
    $('#datetimepicker5').datetimepicker("setEndDate", new Date());
    //$('.date').datetimepicker('setStartDate', '2017-05-02');
    $('.date').datetimepicker('setEndDate',output );
$("#Employee").click(function () {
$(".disp-busi").hide().slow;
$(".disp-employe").show().slow;
$('.businessname').val(null);
$('.business_type_val').val(null);
$('.salary_val').val(null);
$('.emp_type').val(null);
});
$("#Business").click(function () {
$(".disp-busi").show().slow;
$(".disp-employe").hide().slow;
$('.businessname').val(null);
$('.business_type_val').val(null);
$('.salary_val').val(null);
$('.emp_type').val(null);
});
});</script>
<script type="text/javascript">
$(document).ready(function(){
    $('.leadesback').click(function(){
        $('#contact_list').click();
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
    $('.docsback').click(function(){
        $('#lead_tab').click();
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
    
});
</script>
<script type="text/javascript">
    /*  $(document).ready(function () {
     $('.contact_details').click(function () {*/
    $(document).ready(function () {
    $('.contact_details').click(function () {

    var emailvalid      =   $('[name="contact_email_1"]').val();
    var emailvalidtwo   =   $('[name="contact_email_2"]').val();
    if (!ValidateEmail(emailvalid)) {
        alert("Invalid email address.");
        return false;
    }
    if(emailvalidtwo   !=   "")
    {
        if (!ValidateEmail(emailvalidtwo)) {
        alert("Invalid email address.");
        return false;
        }
    }
    
    $("#loadspinner").css("display", "block");
    var form_data = new FormData($('#contact_tab')[0]);
    $.ajax({
    url: "{{url('insertcontact')}}",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            allowedTypes: "jpg,png,gif,jpeg",
            multiple: true,
            dataType:'json',
            type: 'post',
            success: function (response) {
            $('.message_err').css("display", "none");
            $('#contact_list').css("background-color", "contact_list");
            $("#loadspinner").css("display", "none");
            $('#lead_tab').click();
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $('.last_id').val(response);
            $('#message_sucess').css("display", "block");
            //console.log(response);
            return false;
            },
            error: function (response) {
            $("#loadspinner").css("display", "none");
            $('.message_err').css("display", "block");
            /*$("#loadspinner").css("display", "none");*/
            }
    });
    });

 //    $('[name="contact_email_1"]').bind('keyup blur', function () {
 //        var getemailid  =  $(this).val();
 //        var emailchecklength    =   getemailid.split('@')[1];
 //        //$(this).val($(this).val().replace(/[_.,-?%$^&*(){}+`~=!#:;'"/\s]/g, ''));
	// });
    
    function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };

    $('.updatecontact').click(function(){
    var emailvalid 	    =	$('[name="contact_email_1"]').val();
    var emailvalidtwo   =   $('[name="contact_email_2"]').val();
    if (!ValidateEmail(emailvalid)) {
        alert("Invalid email address.");
        return false;
    }
    if(emailvalidtwo   !=   "")
    {
        if (!ValidateEmail(emailvalidtwo)) {
        alert("Invalid email address.");
        return false;
        }
    }
    $("#loadspinner").css("display", "block");
    var form_data = new FormData($('#contact_tab')[0]);
    $.ajax({
    url: "{{url('updatecontact')}}",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            allowedTypes: "jpg,png,gif,jpeg",
            multiple: true,
            type: 'post',
            success: function (response) {
            $('.message_err').css("display", "none");
            $('#message_update').css("display", "block");
            $('#contact_list').css("background-color", "contact_list");
            $("#loadspinner").css("display", "none");
            $('#lead_tab').click();
            $("html, body").animate({ scrollTop: 0 }, "slow");
            //$('.last_id').val(response);
            //console.log(response);
            return false;
            },
            error: function (response) {
            $("#loadspinner").css("display", "none");
            $('.message_err').css("display", "block");
            /*$("#loadspinner").css("display", "none");*/
            }
    });
    });
    $('.saveleads').click(function () {
    $("#loadspinner").css("display", "block");
    var form_data = new FormData($('#leadsform')[0]);
    $.ajax({
    url: "{{url('leadstatus')}}",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            allowedTypes: "jpg,png,gif,jpeg",
            multiple: true,
            type: 'post',
            success: function (response) {
            $('#contact_list').css("background-color", "contact_list");
            $("#loadspinner").css("display", "none");
            $('#documents_tab').click();
            $("html, body").animate({ scrollTop: 0 }, "slow");
            //$('.last_id').val(response);
            //console.log(response);
            return false;
            },
            error: function () {
            $("#loadspinner").css("display", "none");
            /*$("#loadspinner").css("display", "none");*/
            }
    });
    });
    });</script>
<script type="text/javascript">
    $(document).ready(function () {
    $('.document_save').click(function () {
    $("#loadspinner").css("display", "block");
    /*alert('hi');*/
    var form_data = new FormData($('#insert_document')[0]);
    $.ajax({
    url: "{{url('document_save')}}",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            allowedTypes: "jpg,png,gif,jpeg",
            multiple: true,
            type: 'post',
            success: function (response) {
            false;
            $("#loadspinner").css("display", "none");
            $(".form-control").val('');
            $(".last_doc_id").val(response.last_doc_id)
                    /*$('.iddocuments').html('<a href="' + response.link + '" download="download">Download File</a>');*/
                    window.location.href = '{{url("managecontact")}}';
            return false;
            },
            error: function () {
            $("#loadspinner").css("display", "none");
            window.location.href = '{{url("managecontact")}}';
            /*$("#loadspinner").css("display", "none");*/
            }
    });
    });
    $('.document_edit').click(function(){
    $("#loadspinner").css("display", "block");
    /*alert('hi');*/
    var form_data = new FormData($('#insert_document')[0]);
    $.ajax({
    url: "{{url('updatecontact_doc')}}",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            allowedTypes: "jpg,png,gif,jpeg",
            multiple: true,
            type: 'post',
            success: function (response) {
            false;
            $("#loadspinner").css("display", "none");
            $(".form-control").val('');
            $(".last_doc_id").val(response.last_doc_id)
                    $("#message").show().html(response.message).delay(2000).fadeOut(2000);
            $(".BSbtninfo").attr('placeholder', response.image);
            /*$('.iddocuments').html('<a href="' + response.link + '" download="download">Download File</a>');*/
            window.location.href = '{{url("managecontact")}}';
            return false;
            },
            error: function () {
            $("#loadspinner").css("display", "none");
            window.location.href = '{{url("managecontact")}}';
            /*$("#loadspinner").css("display", "none");*/
            }
    });
    });
    $('.checkcontact').change(function(){
    $('.pannumber').removeClass('hidden');
    var contact_value = $(this).val();
    if (contact_value == 1 || contact_value == 2)
    {
    $('.info_type').removeClass('hidden');
    $('.employee_div').removeClass('hidden');
    $('.business_div').removeClass('hidden');
    $('.businessname').val(null);
    $('.business_type_val').val(null);
    $('.salary_val').val(null);
    $('.emp_type').val(null);
    $('.employeehide').addClass('disp-employe employee_div');
    $('.buinesshide').addClass('disp-busi business_div');
    }
    else if (contact_value >= 3)
    {
    $('.info_type').addClass('hidden');
    $('.employee_div').addClass('hidden');
    $('.business_div').addClass('hidden');
    $('.buinesshide').addClass('hidden');
    $('.employeehide').addClass('hidden');
    $('.businessname').val(null);
    $('.business_type_val').val(null);
    $('.salary_val').val(null);
    $('.emp_type').val(null);
    }
    });
    $('.employeechecked').click(function(){
    $('.buinesshide').addClass('disp-busi business_div');
    });
    $('.busesschecked').click(function(){
    $('.employeehide').addClass('disp-employe employee_div');
    });
    });</script>
<script type="text/javascript">
    $(document).ready(function () {
    $("body").on('change', '.make', function () {
    var makeselect = [];
    $('.make .dropdown-menu .selected').each(function (i, selected) {
    makeselect[i] = $(this).attr('data-original-index');
    //console.log($(this).attr('data-original-index'));
    });
    var csrf_token = $('#leadtoken').val();
    /*if ($('.onloadmakechange').val() != 1)
     {*/
    $('#model').empty();
    $.ajax({
    url: '{{url("fetch_model")}}',
            type: 'post',
            data: {_token: csrf_token, make: makeselect},
            success: function (response)
            {
            //alert(response);
            var json = $.parseJSON(response);
            $.each(json, function (arrayID, group) {
            $('#model').append($('<option>', {value: group.model_id, text: group.model_name}));
            });
            $('#model').selectpicker('refresh');
            },
            error: function (e)
            {
            //console.log(e.responseText);
            }
    });
    /*} else {
     $('.onloadmakechange').val(0);
     }*/
    });
    $('.back').click(function () {
    window.location.replace("{{url('managecontact')}}");
    });
    });</script>
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
            @if ($compact_array['document'] > 0)
            placeholder:'@if(!empty($compact_array["fetch_contact_document_data"]->document_name)){{$compact_array["fetch_contact_document_data"]->document_name}}@endif'
            @endif
    });</script>
<script type="text/javascript">
    function changecity(){
    var state = $('#state2').val();
    $('#citys2').empty();
    $.ajax({
    url:'{{url("fetch_city")}}',
            type:'post',
            data:{state:state},
            success:function(response)
            {
            var json = $.parseJSON(response);
            $('#citys2').append($('<option>', {value:'', text:'Select City'}));
            $.each(json, function(arrayID, group) {
            $('#citys2').append($('<option>', {value:group.city_id, text:group.city_name}));
            });
            }
    });
    }
</script>
<script type="text/javascript">
    function selectCity(){
    var state = $('.sta').val();
    $('#citys').empty();
    $.ajax({

    url:'{{url("fetch_city")}}',
            type:'post',
            data:{state:state},
            success:function(response)
            {
            var json = $.parseJSON(response);
            $('#citys').append($('<option>', {value:'', text:'Select City'}));
            $.each(json, function(arrayID, group) {
            $('#citys').append($('<option>', {value:group.city_id, text:group.city_name}));
            });
            }
    });
    }
</script>

</body>
</html>