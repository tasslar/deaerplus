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
                    <!--<h2 class="page-title col-xs-12">Manage Contacts</h2>-->
                    <h2 class="page-title">Manage Contacts</h2>
                    @if(Session::has('message'))
                    <div class="alert alert-danger" id="message-err">{{ Session::get('message') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-12 subscription">
                            <div class="panel-body row">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#details"  data-toggle="tab" aria-expanded="false" id="contact_list">Contact Details</a></li>
                                    <li><a id="lead_tab" href="#leadstatus" id="leadstatus_tab" data-toggle="tab" aria-expanded="true">Lead Details</a></li>
                                    @if($compact_array['document']>0)
                                    <li ><a href="#documents" id="documents_tab" data-toggle="tab" aria-expanded="true">Documents</a></li>
                                    @endif
                                    <!-- <li><a href="#interaction" data-toggle="tab" aria-expanded="true">Interactions</a></li> -->
                                    <!--                                    <li><as href="#leadstatus" data-toggle="tab" aria-expanded="true">Lead Details</a></li>-->
                                </ul>
                                <br>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane fade active in" id="details">
                                            <div class="col-xs-12 card">
                                                <div class="row">
                                                 <form method="get" id="contact_tab" action="{{url('managecontact')}}" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                                <input type="hidden" name="documetcount" value="{{$compact_array['document']}}" id="document_count">
                                                    <div class="col-md-3 col-lg-2 col-xs-12">
                                                        <div class="addimage">
                                                            <div class="form-group">
                                                                <div>
                                                                @if($compact_array['contact_count'] <= 0)
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
                                                            @if($compact_array['contact_count'] <= 0)
                                                            <input type="file" name="contact_image" class="upload contact_image" disabled="disabled" id="profile_image" data-validation-optional="true"  data-validation-allowing="jpg, png" data-validation-error-msg="Please Upload Images"/>
                                                            @else
                                                            <input type="file" name="contact_image" class="upload contact_image"  id="profile_image" data-validation-optional="true"  data-validation-allowing="jpg, png" data-validation-error-msg="Please Upload Images" disabled="disabled" />
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
                                                                            @if($compact_array['contact_count'] <= 0)
                                                                            <select class="form-control contact_type_id checkcontact" name="contact_type_id" data-validation="required" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                                <option value="" selected="true" disabled="disabled">Select Contact Type</option>
                                                                                @foreach($compact_array['contact_type_id'] as $fetch)
                                                                                <option value="{{$fetch->contact_type_id}}">
                                                                                {{$fetch->contact_type}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control checkcontact"  name="contact_type_id" data-validation="required" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
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
                                                                            @if($compact_array['contact_count'] <= 0)
                                                                            <input type="text" name="contact_owner" class="form-control contact_owner" placeholder="Contact Owner" data-validation="length" data-validation-optional="true" data-validation-length="max100"  data-validation-error-msg="Please Enter Correct Owner" disabled="disabled">
                                                                            @else
                                                                            <input type="text" value="{{$compact_array['fetch_contact_data']->contact_owner}}" name="contact_owner" class="form-control" placeholder="Contact Owner" data-validation="length" data-validation-optional="true" data-validation-length="max100"  data-validation-error-msg="Please Enter Correct Owner" disabled="disabled">
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
                                                                            @if($compact_array['contact_count'] <= 0)
                                                                            <input type="text" name="contact_first_name" value="" placeholder="First Name" class="form-control data-name contact_first_name required-des" data-validation-optional="false" placeholder="First Name" data-validation="alphanumeric,length,required" data-validation-allowing="\s_-" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name" disabled="disabled">
                                                                            @else
                                                                            <input type="text" value="{{$compact_array['fetch_contact_data']->contact_first_name}}" name="contact_first_name" value="" class="form-control data-name" placeholder="First Name" data-validation-optional="false" placeholder="First Name" data-validation="alphanumeric,length,required" data-validation-allowing="\s_-" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name" disabled="disabled">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Last Name</label>
                                                                             @if($compact_array['contact_count'] <= 0)
                                                                            <input type="text" name="contact_last_name" class="form-control data-name contact_last_name" placeholder="Last Name" data-validation="length" data-validation-optional="true" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name" disabled="disabled">
                                                                            @else
                                                                            <input type="text" value="{{$compact_array['fetch_contact_data']->contact_last_name}}" name="contact_last_name" class="form-control data-name" placeholder="Last Name" data-validation="length" data-validation-optional="true" data-validation-length="max50"  data-validation-error-msg="Please Enter Valid Name" disabled="disabled">
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
                                                                             @if($compact_array['contact_count'] <= 0)
                                                                            <select class="form-control contact_designation" name="contact_designation" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                                <option value="">Select Designation</option>
                                                                                <option value="mr">Mr</option>
                                                                                <option value="mrs">Mrs</option>
                                                                                <option value="miss">Miss</option>
                                                                                <option value="dr">Dr</option>
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control" name="contact_designation" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option" disabled="disabled">
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
                                                                            @if($compact_array['contact_count'] <= 0)
                                                                            <select class="form-control contact_gender" name="contact_gender" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                                <option value="">Select Gender</option>
                                                                                <option value="male">Male</option>
                                                                                <option value="female">Female</option>
                                                                            </select>
                                                                            @else
                                                                             <select class="form-control" name="contact_gender"  data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                                @if('male' == $compact_array['fetch_contact_data']->contact_gender)
                                                                                <option selected="true">{{$compact_array['fetch_contact_data']->contact_gender}}</option>
                                                                                <option>Female</option>
                                                                                @elseif('female' == $compact_array['fetch_contact_data']->contact_gender)
                                                                                <option selected="true">{{$compact_array['fetch_contact_data']->contact_gender}}</option>
                                                                                <option>Male</option>
                                                                                @else
                                                                                <option value="" selected disabled>Select Gender</option>
                                                                                <option>Male</option>
                                                                                <option>Female</option>
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
                                                                            @if($compact_array['contact_count'] <= 0)
                                                                            <select class="form-control contact_lead_source" name="contact_lead_source" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                                <option value="" disabled="disabled">Select Lead Source</option>
                                                                                <option value="1">Lead Source</option>
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                            </select>
                                                                            @else
                                                                            <select class="form-control" name="contact_lead_source"  data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                                @if($compact_array['fetch_contact_data']->contact_lead_source == '1')  
                                                                                <option selected="true" value="1">Lead Source</option>
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == "2")
                                                                                <option value="1">Lead Source</option>
                                                                                <option selected="true" value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == '3')
                                                                                <option value="1">Lead Source</option>
                                                                                <option value="2">Advertisement</option>
                                                                                <option selected="true" value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == '4')
                                                                                <option value="1">Lead Source</option>
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option selected="true" value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == "5")
                                                                                <option value="1">Lead Source</option>
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option selected="true" value="5">External Referral</option>
                                                                                <option value="6">Tradeshow</option>
                                                                                @elseif($compact_array['fetch_contact_data']->contact_lead_source == 6)
                                                                                <option value="1">Lead Source</option>
                                                                                <option value="2">Advertisement</option>
                                                                                <option value="3">Cold call</option>
                                                                                <option value="4">Employee Referral</option>
                                                                                <option value="5">External Referral</option>
                                                                                <option selected="true" value="6">Tradeshow</option>
                                                                                @else
                                                                                <option value="" disabled="disabled">Select Lead Source</option>                     
                                                                                <option value="1">Lead Source</option>
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
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <input id="EmailOptOut" name="contact_email_opt_out" class="onlinep contact_email_opt_out" type="checkbox" value="1" checked="" disabled="disabled">
                                                                        @else
                                                                        @if($compact_array['fetch_contact_data']->contact_email_opt_out == "1")
                                                                            <input id="EmailOptOut" name="contact_email_opt_out"" class="onlinep" type="checkbox" value="1" checked="" disabled="disabled">
                                                                            @else
                                                                            <input id="EmailOptOut" name="contact_email_opt_out"" class="onlinep" type="checkbox" value="1" disabled="disabled"> 
                                                                            @endif
                                                                        @endif
                                                                        <label for="EmailOptOut" class="onlinepcheck">
                                                                            Email Subscribed
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-12"><div class="checkbox checkbox-primary mt-2x">
                                                                    @if($compact_array['contact_count'] <= 0)
                                                                    <input id="SmsOptOut" name="contact_sms_opt_out" class="onlinep contact_sms_opt_out" type="checkbox" value="1" checked="" disabled="disabled">
                                                                    @else
                                                                     @if($compact_array['fetch_contact_data']->contact_sms_opt_out == "1")
                                                                        <input id="SmsOptOut" name="contact_sms_opt_out" class="onlinep" type="checkbox" value="1" checked="" disabled="disabled">
                                                                     @else
                                                                        <input id="SmsOptOut" name="contact_sms_opt_out" class="onlinep" type="checkbox" value="1" disabled="disabled">
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
                                                                    @if($compact_array['contact_count'] <= 0)
                                                                    <input type="text" name="contact_phone_1" value="" class="form-control data-number contact_phone_1" placeholder="Contact Number" data-validation="required,length" data-validation-length="8-11" data-validation-optional="false" data-validation-error-msg="Please Enter Valid Number" disabled="disabled">
                                                                    @else
                                                                    <input type="text" name="contact_phone_1"  value="{{ $compact_array['fetch_contact_data']->contact_phone_1}}" class="form-control data-number" placeholder="Contact Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number" disabled="disabled">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-xs-12 col-sm-4">
                                                                <div class="form-group field-wrapper1">
                                                                    <label>Mobile Number</label>
                                                                    @if($compact_array['contact_count'] <= 0)
                                                                    <input type="text" name="contact_phone_2" value="" class="form-control data-number contact_phone_2" placeholder="Mobile Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number" disabled="disabled">
                                                                    @else
                                                                     <input type="text" name="contact_phone_2" value="{{ $compact_array['fetch_contact_data']->contact_phone_2}}" class="form-control data-number" placeholder="Mobile Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number" disabled="disabled">
                                                                    @endif
                                                                </div>
                                                            </div> -->
                                                            <div class="col-xs-12 col-sm-4">
                                                                <div class="form-group field-wrapper1">
                                                                    <label>Landline Number</label>
                                                                    @if($compact_array['contact_count'] <= 0)
                                                                    <input type="text" name="contact_phone_3" value="" class="form-control data-number contact_phone_3" placeholder="Landline Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number" disabled="disabled">
                                                                    @else
                                                                    <input type="text" name="contact_phone_3" value="{{$compact_array['fetch_contact_data']->contact_phone_3}}" class="form-control data-number" placeholder="Landline Number" data-validation="length" data-validation-length="8-11" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Number" disabled="disabled">
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
                                                                    @if($compact_array['contact_count'] <= 0)
                                                                    <input type="text" name="contact_email_1" value="" class="form-control contact_email_1" placeholder="Email Id" data-validation="email" data-validation-optional="false" data-validation-error-msg="Please Enter Valid Email" disabled="disabled">
                                                                    @else
                                                                    <input type="mail" name="contact_email_1" value="{{ $compact_array['fetch_contact_data']->contact_email_1}}" class="form-control" placeholder="Email Id" data-validation="email" data-validation-optional="false" data-validation-error-msg="Please Enter Valid Email" disabled="disabled">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6">
                                                                <div class="form-group field-wrapper1">
                                                                    <label>Other Email Id</label>
                                                                    @if($compact_array['contact_count'] <= 0)
                                                                    <input type="text" name="contact_email_2" value="" class="form-control contact_email_2" placeholder="Other Email Id" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email" disabled="disabled">
                                                                    @else
                                                                    <input type="email" value="{{ $compact_array['fetch_contact_data']->contact_email_2}}" name="contact_email_2" value="" class="form-control" placeholder="Other Email Id" data-validation="email" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Email" disabled="disabled">
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
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <input type="text" name="contact_mailing_address"  class="form-control addr contact_mailing_address" id="addre" placeholder="Mailing Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address" disabled="disabled">
                                                                        @else
                                                                        <input type="text" name="contact_mailing_address"  class="form-control addr contact_mailing_address" id="addre" placeholder="Mailing Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address" value="{{ $compact_array['fetch_contact_data']->contact_mailing_address}}" disabled="disabled">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-xs-12">
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Add Mailing City</label>
                                                                        <input type="text" name="contact_mailing_city" class="form-control" placeholder="Mailing City">
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-xs-12">
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Add Mailing State</label>
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <select class="form-control sta contact_mailing_state" name="contact_mailing_locality" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                            <option value="">Select State</option>
                                                                            @foreach($compact_array['state'] as $fetch)
                                                                            <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @else
                                                                        <select class="form-control sta contact_mailing_state" name="contact_mailing_city" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
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
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <select class="form-control contact_mailing_city" name="contact_mailing_city" data-validation="alphanumeric" data-validation-optional="true" id="citys"  data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                            <option value="">Select City</option>
                                                                            @foreach($compact_array['city'] as $fetch)
                                                                            <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @else
                                                                        <select class="form-control contact_mailing_city" name="contact_mailing_city" data-validation="alphanumeric" data-validation-optional="true" id="citys"  data-validation-error-msg="Please Select One Option" disabled="disabled"> 
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
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <input name="contact_mailing_pincode" type="text" class="form-control data-number contact_mailing_pincode" placeholder="Mailing Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode" disabled="disabled">
                                                                        @else
                                                                        <input name="contact_mailing_pincode" type="text" value="{{$compact_array['fetch_contact_data']->contact_mailing_pincode}}" class="form-control data-number" placeholder="Mailing Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode" disabled="disabled">
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
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <input type="text" name="contact_other_address"  class="form-control other_address contact_other_address" id="other_address" placeholder="Other Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address" disabled="disabled">
                                                                        @else
                                                                        <input type="text" name="contact_other_address"  class="form-control other_address contact_other_address" id="other_address" placeholder="Other Address" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Valid Address" value="{{$compact_array['fetch_contact_data']->contact_other_address}}" disabled="disabled">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!--                                      div>-->
                                                                <div class="col-xs-12">
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Add Mailing State</label>
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <select class="form-control sta contact_other_state" name="contact_other_locality" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled" disabled="disabled">
                                                                            <option value="">Select State</option>
                                                                            @foreach($compact_array['state'] as $fetch)
                                                                            <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @else
                                                                        <select class="form-control sta contact_other_state" name="contact_other_locality" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" disabled="disabled">
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
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <select class="form-control contact_other_city" name="contact_other_city" data-validation="alphanumeric" id="citys" data-validation-optional="true" data-validation-error-msg="Please Select One Option" disabled="disabled">
                                                                            <option value="">Select City</option>
                                                                            @foreach($compact_array['city'] as $fetch)
                                                                            <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @else
                                                                        <select class="form-control contact_other_city" name="contact_other_city" data-validation="alphanumeric" id="citys" data-validation-optional="true" data-validation-error-msg="Please Select One Option" disabled="disabled">
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
                                                                        @if($compact_array['contact_count'] <= 0)
                                                                        <input name="contact_other_pincode" type="text"  class="form-control data-number contact_other_pincode" placeholder="Other Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode" disabled="disabled">
                                                                        @else
                                                                        <input name="contact_other_pincode" type="text" value="{{$compact_array['fetch_contact_data']->contact_other_pincode}}"  class="form-control data-number" placeholder="Other Pincode" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pincode" disabled="disabled">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <!--                                                                <div class="form-group field-wrapper1">
                                                            <label>Business Name</label>
                                                            <input type="text" name="contact_business_name" class="form-control contact_business_name" placeholder="Business Name" data-validation="length" data-validation-optional="true" data-validation-length="max100" data-validation-error-msg="Please Enter Business Name">
                                                        </div> -->
                                                        @if($compact_array['contact_count'] <= 0)
                                                        <h3 class="inn-head">Employement Information</h3>
                                                        <div class="row">
                                                            <div class="col-sm-4 col-xs-12">
                                                                <div class="form-group field-wrapper1">
                                                                    <label>Pan Number</label>
                                                                    <!-- <input name="pan_number" type="text"  class="form-control data-number" placeholder="Pan Number" data-validation-length="6" data-validation="length,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pancard Number"> -->
                                                                     <input name="pan_number" type="text"  class="form-control" placeholder="Pan Number" data-validation-length="6" data-validation="alphanumeric,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pancard Number" name="pan_number" value="" disabled="disabled">
                                                                </div>
                                                            </div>
                                                        <div class="col-sm-8 col-xs-12 hidden info_type">
                                                            <div class="checkbox checkbox-primary mt-2x">
                                                                <div class="checkbox checkbox-primary  checkbox-inline">
                                                                    <input type="radio" id="Business" value="1" name="employee_information_type" disabled="disabled">
                                                                    <label for="Business"> Business </label>
                                                                </div>
                                                                <div class="checkbox checkbox-primary  checkbox-inline">
                                                                    <input type="radio" id="Employee" value="2" name="employee_information_type" disabled="disabled">
                                                                    <label for="Employee"> Employee </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-xs-12 disp-employe">
                                                            <div class="form-group field-wrapper1">
                                                                <label>Employee Type</label>
                                                                <select class="form-control" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                    <option value="">Select Employee Type</option>
                                                                    <option value="1">Type1</option>
                                                                    <option value="2">Type2</option>
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-xs-12 disp-employe employee_div">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Employee Type</label>
                                                                        <select class="form-control emp_type" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="employeetype" disabled="disabled">
                                                                            <option value="" disabled="disabled" selected="selected">Select Employee Type</option>
                                                                            <option value="1">Private Limited Company</option>
                                                                            <option value="2">One Person Company</option>
                                                                            <option value="3">Govt</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Salary </label>
                                                                        <input name="salary" type="text"  class="form-control data-text salary_val" placeholder="Salary per month" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data" disabled="disabled">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 disp-busi business_div">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Business Type</label>
                                                                        <select class="form-control business_type_val" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="business_type" disabled="disabled">
                                                                            <option value="" disabled="" selected="">Select Business Type</option>
                                                                            <option value="1">Private Limited Company</option>
                                                                            <option value="2">One Person Company</option>
                                                                            <option value="3">Govt</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Business Name</label>
                                                                        <input name="contact_business_name" type="text"  class="form-control data-text businessname" placeholder="Business Name" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data" disabled="disabled">
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
                                                                    <input disabled="disabled" name="pan_number" type="text"  class="form-control" placeholder="Pan Number" data-validation-length="6" data-validation="alphanumeric,number" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Pancard Number" name="pan_number" value="{{$compact_array['fetch_contact_data']->pan_number}}">
                                                                </div>
                                                            </div>
                                                      @if($compact_array['contact_type_lead'] == 1 || $compact_array['contact_type_customer'] == 1)
                                                            <div class="col-sm-8 col-xs-12  info_type">
                                                                <div class="checkbox checkbox-primary mt-2x">
                                                                    @if($compact_array['fetch_contact_data']->employee_information_type == "Business")
                                                                    <div class="checkbox checkbox-primary  checkbox-inline">
                                                                        <input disabled="disabled" type="radio" id="Business" value="1" name="employee_information_type" checked="">
                                                                        <label for="Business"> Business </label>
                                                                    </div>
                                                                    <div class="checkbox checkbox-primary  checkbox-inline employeechecked">
                                                                         <input disabled="disabled" type="radio" id="Employee" value="2" name="employee_information_type" >
                                                                        <label for="Employee"> Employee </label>
                                                                    </div>
                                                                    @elseif($compact_array['fetch_contact_data']->employee_information_type == "Employee")
                                                                    <div class="checkbox checkbox-primary  checkbox-inline busesschecked">
                                                                        <input disabled="disabled" type="radio" id="Business" value="1" name="employee_information_type">
                                                                        <label for="Business"> Business </label>
                                                                    </div>
                                                                    <div class="checkbox checkbox-primary  checkbox-inline">
                                                                         <input disabled="disabled" type="radio" id="Employee" value="2" name="employee_information_type" checked="">
                                                                        <label for="Employee"> Employee </label>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-xs-12 disp-employe">
                                                                <div class="form-group field-wrapper1">
                                                                    <label>Employee Type</label>
                                                                    <select class="form-control" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option">
                                                                        <option value="">Select Employee Type</option>
                                                                        <option value="1">Type1</option>
                                                                        <option value="2">Type2</option>
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                                            @if($compact_array['fetch_contact_data']->employee_information_type == "Employee")
                                                                   <div class="col-xs-12 employeehide">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Employee Type</label>
                                                                                <select class="form-control emp_type" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="employeetype" disabled="disabled">
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
                                                                                <input name="Business Name" type="text"  class="form-control data-text salary_val" placeholder="Salary per month" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data" name="salary_per_month" value="{{$compact_array['fetch_contact_data']->salary_per_month}}" disabled="disabled">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-12 disp-busi business_div">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Business Type</label>
                                                                                <select class="form-control business_type_val" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="business_type" disabled="disabled">
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
                                                                                <input name="contact_business_name" type="text"  class="form-control data-text businessname" placeholder="Business Name" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data" disabled="disabled">
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
                                                                                <select disabled="disabled" class="form-control emp_type" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="employeetype">
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
                                                                                <input disabled="disabled" name="salary" type="text"  class="form-control data-text salary_val" placeholder="Salary per month" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-12 buinesshide">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-xs-12">
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>Business Type</label>
                                                                                <select disabled="disabled" class="form-control business_type_val" data-validation="alphanumeric" data-validation-optional="true"  data-validation-error-msg="Please Select One Option" name="business_type">
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
                                                                                <input disabled="disabled" name="Business Name" type="text"  class="form-control data-text businessname" placeholder="Business Name" data-validation-length="6" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Enter Valid Data" name="contact_business_name" value="{{$compact_array['fetch_contact_data']->contact_business_name}}">
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
                                            <!-- <button type="button" href="#documents">Submit</button> -->
                                            <!-- <span href="#documents" type="button" class="btn btn-primary">Submit</span> -->
                                            <!-- <button type="submit" class="btn btn-danger updatecontact">Close</button> -->
                                             @if($compact_array['document']>0)
                                            <button type="button" class="btn btn-primary back document_edit">Next</button>
                                            @endif
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
                                                            <option value="">Select City</option>
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
                                                </div><!-- end inner row -->
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
                                                <!-- <div class="col-sm-6 col-xs-12">
                                                    <h4 class="page-title">Buy From</h4>
                                                    <ul>
                                                        <li>
                                                            <div class="checkbox checkbox-primary">
                                                                <input id="Agents" type="checkbox" >
                                                                <label for="Agents">
                                                                    Agents
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox checkbox-primary">
                                                                <input id="Customers" type="checkbox" >
                                                                <label for="Customers">
                                                                    Customers
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="checkbox checkbox-primary">
                                                                <input id="Dealers" type="checkbox" >
                                                                <label for="Dealers">
                                                                    Dealers
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div> -->
                                            </div><!-- end inner row -->
                                        </div>
                                    </div><!-- end outer row -->
                                    <hr>
                                    <!-- end outer row -->
                                    <div class="col-xs-12 text-left">
                                   
                                    <button type="button" class="btn btn-danger leadbacks">Back</button>
                                    <button type="button" class="btn btn-primary document_tabs">Next</button>
                                    </div>
                                </form> 
                            </div>
                        </div>
                        <div class="tab-pane fade" id="documents">
                            <div  class="col-xs-12 card">
                                <!--<h2 class="page-title col-xs-12"><span class="detail-title1">Document Details</span></h2>-->
                                <div id="contactdocument">
                                    <!--  <button type="button" class="btn btn-primary pull-right cloneAdd" title="Add New Address"  name="Submit"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> -->
                                    <div id="contactdocumentClones" class="cloneSet contactAddressC">
                                        <form method="post" id="insert_document" action="{{url('insertcontact')}}" enctype="multipart/form-data">
                                        <input type="hidden" name="documetcount" value="{{$compact_array['document']}}" id="document_count">
                                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                            <div class="col-xs-12 document">
                                                <div class="col-xs-12">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group field-wrapper1">
                                                                <label>ID Type</label>
                                                                @if($compact_array['contact_count'] <= 0)
                                                                <select disabled="disabled" class="form-control" name="document_id_type" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option">
                                                                    <option>Select Id Proof</option>
                                                                    @foreach($compact_array['document_id'] as $fetch)
                                                                    <option value="{{$fetch->doc_id}}">{{$fetch->doc_id_name}}</option>
                                                                    @endforeach
                                                                    <!-- <option value="">Select Id Type</option>
                                                                    <option value="">Passport</option>
                                                                    <option value="">Driving License</option>
                                                                    <option value="">Voter Id</option> -->
                                                                </select>
                                                                @else
                                                                <select class="form-control" name="document_id_type" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="Please Select One Option" disabled="disabled">

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
                                                                                    <!-- <option value="">Select Id Type</option>
                                                                                    <option value="">Passport</option>
                                                                                    <option value="">Driving License</option>
                                                                                    <option value="">Voter Id</option> -->
                                                                                </select>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="last_id" class="last_id">
                                                        <input type="hidden" name="last_doc_id" class="last_doc_id">
                                                        <div class="col-xs-12 col-sm-6">   <div class="form-group field-wrapper1">
                                                            <label>ID Number</label>
                                                            @if($compact_array['contact_count'] <= 0)
                                                            <input type="text" disabled="disabled" class="form-control data-number" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id">
                                                            @else
                                                             @if($compact_array['document']>0)
                                                                            <div class="form-group field-wrapper1">
                                                                                <label>ID Number</label>
                                                                                <input type="text" class="form-control data-number" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['fetch_contact_document_data']->document_id_number}}">
                                                                            </div> 
                                                                        </div>
                                                                        <input type="hidden" name="contact_mgmt_id" value="{{$compact_array['fetch_contact_data']->contact_management_id}}">
                                                                        @else
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>ID Number</label>
                                                                            <input disabled="disabled" type="text" class="form-control data-number" name="document_id_number" placeholder="ID Number" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="">
                                                                            <input type="hidden" name="contact_mgmt_id" value="{{$compact_array['fetch_contact_data']->contact_management_id}}">
                                                                        </div> 
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- <div class="row"> -->
                                                    <!-- <div class="col-xs-12 col-sm-6">
                                                        <div class="form-group field-wrapper1">
                                                            <label>Document Name</label>
                                                            <input type="text" name="document" class="form-control" placeholder="Document Name">
                                                        </div>
                                                    </div> -->
                                                    <div class="col-sm-6 col-xs-12 mt">
                                                        <div class='input-group date field-wrapper1' id='datetimepicker5'>
                                                            <label>Date of Birth</label>
                                                            @if($compact_array['contact_count'] <= 0)
                                                            <input type='text' name="document_dob" class="form-control" placeholder="D.O.B" data-validation="date" data-validation-optional="true" data-validation-error-msg="Please Select Valid Date" disabled="disabled"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                            @else
                                                               @if($compact_array['document']>0)
                                                                            <label>Date of Birth</label>
                                                                            <input type='text' disabled="disabled" name="document_dob" class="form-control" placeholder="D.O.B" data-validation="date" data-validation-optional="true" data-validation-error-msg="Please Select Valid Date" value="{{$compact_array['fetch_contact_document_data']->document_dob}}
                                                                                   " />
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        @else
                                                                            <label>Date of Birth</label>
                                                                            <input type='text' name="document_dob" class="form-control" placeholder="D.O.B" data-validation="date" data-validation-optional="true" data-validation-error-msg="Please Select Valid Date" value="" disabled="disabled"/>
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                        @endif
                                                            <!--  -->
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xs-12 mt iddocuments" >
                                                        <!-- <div class="input-group"> -->
                                                        <!-- </div> -->
                                                    </div>
                                                    <!--  <div class="col-sm-1 col-xs-12"> <button type="button" class="btn btn-danger pull-right cloneRemove" title="Remove Last Address"  name="Submit"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                                    </div> -->
                                                    <!-- </div> -->
                                                    <!--  <div class="col-sm-6 col-xs-12 mt">
                                                                <div class='field-wrapper1'>
                                                                    <label></label>
                                                                </div>
                                                                <input type="file" name="contact_document" class="BSbtninfo"/>
                                                            </div> -->
                                                    @if($compact_array['contact_count'] > 0)
                                                        @if($compact_array['document']>0)
                                                        @foreach($compact_array['document_id'] as $fetch)
                                                        @if($compact_array['fetch_contact_document_data']->document_id_type == $fetch->doc_id) 
                                                         <div class="col-sm-6 col-xs-12 mt">
                                                            <input disabled="disabled" type="file" name="contact_document" class="BSbtninfo"/>
                                                             <a href="{{$compact_array['fetch_contact_document_data']->doc_link_fullpath}}" download="{{$fetch->doc_id_name}}">Download</a>
                                                        </div>             
                                                        @endif
                                                        @endforeach
                                                        @else
                                                         <div class="col-sm-6 col-xs-12 mt">
                                                            <div class='field-wrapper1'>
                                                                <label></label>
                                                            </div>
                                                            <input  type="file" name="contact_document" class="BSbtninfo" disabled="disabled"/>
                                                        </div>     
                                                        @endif 
                                                        @else
                                                        <div class="col-sm-6 col-xs-12 mt">
                                                            <div class='field-wrapper1'>
                                                                <label></label>
                                                            </div>
                                                            <input  type="file" name="contact_document" class="BSbtninfo" disabled="disabled" />
                                                        </div>   
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary document_edit">Back</button>
                                <!-- <button type="button" class="btn btn-danger cancel_doc">Close</button> -->
                            </form>
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
<div class="modal fade" id="car_list" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Cars</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td class="col-sm-1"><div class="checkbox checkbox-info"><input type="radio" id="car1" name="price-filter">
                        <label for="car1"></label>
                    </div></td>
                    <td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                    <td class="col-sm-8"><h4>Make, Model, Varient, Year</h4>
                        <h5>Rs.3,60,000</h5>
                        <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-1"><div class="checkbox checkbox-info"><input type="radio" id="car6" name="price-filter">
                    <label for="car6"></label>
                </div></td>
                <td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
                <td class="col-sm-8"><h4>Make, Model, Varient, Year</h4>
                    <h5>Rs.3,60,000</h5>
                    <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
                </td>
            </tr>
            <tr>
                <td class="col-sm-1"><div class="checkbox checkbox-info"><input type="radio" id="car2" name="price-filter">
                <label for="car2"></label>
            </div></td>
            <td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
            <td class="col-sm-8"><h4>Make, Model, Varient, Year</h4>
                <h5>Rs.3,60,000</h5>
                <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
            </td>
        </tr>
        <tr>
            <td class="col-sm-1"><div class="checkbox checkbox-info"><input type="radio" id="car3" name="price-filter">
            <label for="car3"></label>
        </div></td>
        <td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
        <td class="col-sm-8"><h4>Make, Model, Varient, Year</h4>
            <h5>Rs.3,60,000</h5>
            <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
        </td>
    </tr>
    <tr>
        <td class="col-sm-1"><div class="checkbox checkbox-info"><input type="radio" id="car4" name="price-filter">
        <label for="car4"></label>
    </div></td>
    <td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
    <td class="col-sm-8"><h4>Make, Model, Varient, Year</h4>
        <h5>Rs.3,60,000</h5>
        <p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>
    </td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="employee_list" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Select Employee</h4>
</div>
<div class="modal-body">
<table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
<tbody>
<tr>
<td class="col-sm-1"><div class="checkbox checkbox-info"><input type="checkbox" id="employee1" name="price-filter">
<label for="car1"></label>
</div></td>
<td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
<td class="col-sm-8"><h4>Employee Name</h4>
<!--                                            <h5>Rs.3,60,000</h5>-->
<!--<p class="list-detail"><span class="text-muted">9,990 km</span> | <span class="text-muted">Petrol</span> | <span class="text-muted">2015</span> | <span class="text-muted">2 Owners</span></p>-->
</td>
</tr>
<tr>
<td class="col-sm-1"><div class="checkbox checkbox-info"><input type="checkbox" id="employee6" name="price-filter">
<label for="car6"></label>
</div></td>
<td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
<td class="col-sm-8"><h4>Employee Name</h4>
</td>
</tr>
<tr>
<td class="col-sm-1"><div class="checkbox checkbox-info"><input type="checkbox" id="employee2" name="price-filter">
<label for="car2"></label>
</div></td>
<td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
<td class="col-sm-8"><h4>Employee Name</h4>
</td>
</tr>
<tr>
<td class="col-sm-1"><div class="checkbox checkbox-info"><input type="checkbox" id="employee3" name="price-filter">
<label for="car3"></label>
</div></td>
<td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
<td class="col-sm-8"><h4>Employee Name</h4>
</td>
</tr>
<tr>
<td class="col-sm-1"><div class="checkbox checkbox-info"><input type="checkbox" id="employee4" name="price-filter">
<label for="car4"></label>
</div></td>
<td class="col-sm-3"><img src="img/car1.jpg" alt="" class="img-responsive table-img"/></td>
<td class="col-sm-8"><h4>Employee Name</h4>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<!-- <form method="get" id="leads" action="{{url('managecontact')}}">
<input type="hidden">
</form>   -->
<!-- Loading Scripts -->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script src="{{URL::asset('js/label-slide.js')}}"></script>
<script src="{{URL::asset('js/common.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- <script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script> -->
 <script src="js/bootstrap-select.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {
$('.back').click(function () {
$('#leads').submit()
});
$('.document_edit').click(function(){
    $('#lead_tab').click();
    $("html, body").animate({ scrollTop: 0 }, "slow");
});
$('.backhome').click(function(){
    $('#contact_tab').submit();
});
$('.leadbacks').click(function(){
    $("#contact_list").click();
    $("html, body").animate({ scrollTop: 0 }, "slow");
});
$('.document_tabs').click(function(){
    $("#documents_tab").click();
    $("html, body").animate({ scrollTop: 0 }, "slow");
});
$('.cancel_doc').click(function(){
    window.location.replace("{{url('managecontact')}}");
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
@if($compact_array['document']>0)
placeholder:'@if(count(explode("document/",$compact_array["fetch_contact_document_data"]->doc_link_fullpath))>1){{explode("document/",$compact_array["fetch_contact_document_data"]->doc_link_fullpath)[1]}}@endif'
@endif
});
</script>
<!--  <script>
//Render selected item to the screen
$('#dataCombo').change(function () {
$('#dataOutput').html('');
var values = $('#dataCombo').val();
for (var i = 0; i < values.length; i += 1) {
$('#dataOutput').append("<p class='removeable'><span class='reel'>" + values[i] + "</span> </p>")
}
});
$("#dataCombo").selectpicker({
multiple: true
});
</script> -->
</body>
</html>