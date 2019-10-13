@include('header')
<style>
    .remove-img{ 
        height: 25px;
        z-index: 999;
        bottom: -5px;
        /*right: -6px;*/
        cursor: pointer;
        border: 1px dotted #fff;text-align: center;
    }
    .save-img{  
        height: 25px;border: 1px dotted #fff;
        position: absolute;
        z-index: 999;color:#fff;
        bottom: -5px;text-align: center;
        /*right: 18px;*/  
        cursor: pointer;
        background-color: #333;
    }
    .cancelsavecover{width:100px;position: absolute;top: 20px;right: 0px;}

</style>

<div class="ts-main-content">           
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="container-fluid">
            <div class="row">

                <div class="content-header col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('/myeditaccount')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                        <li class="active">My Business Profile</li>

                        @if (Session::has('message'))
                        <div class="alert alert-success" id="message-err">{{ Session::get('message') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                        @endif
                        @if (Session::has('message-err'))
                        <div class="alert alert-danger" id="message-err">{{ Session::get('message-err') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                        @endif
                        @if(Session::has('profile_none'))
                        <div class="alert alert-danger" id="message-err">{{ Session::get('profile_none') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        @endif
                    </ol>
                    <form method="post" id="view_car_managelist" action="{{url('view')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" id="car_view_id" name="car_view_id">
                    </form>
                </div>

                <!-- @if (Session::has('message'))
               <div class="alert alert-success">{{ Session::get('message') }}
                   <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
               @endif
               @if (Session::has('message-err'))
               <div class="alert alert-danger">{{ Session::get('message-err') }}
                   <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
               @endif -->
                <div class="col-xs-12">

                    <div class="profile-head row" id="replace_cover" style="background-image:url({{$compact_array['dealer_deatails']->coverphoto_logo}})">
                        <div class="cancelsavecover">
                            <span class="remove-img col-xs-6" id="cmp_cov_cancel" style="display: none"><i class="fa fa-close" ></i></span>
                            <span class="save-img col-xs-6" id="cmp_cov_save" style="display: none"><i class="fa fa-save cmp_cov_save" ></i></span>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12 profile-headdiv">

                            <div class="profile-headimg">
                                <img src="{{$compact_array['dealer_deatails']->company_logo}}" class="img-responsive image" alt="Dealer Name"/>   
                                <div id="savecancelbtn">

                                </div>
                                <input type="hidden" name="logo_empty" class="logo_empty">
                                <div class="fileUpload btn-primary profile-headimgbtn">
                                    <span id="image_size">Change Image</span>
                                    <form method="post" id="logo" action="{{url('company_logo')}}" enctype="multipart/form-data">
                                        <input type="file" class="upload com_logo"  name="logo" onchange="return ValidateFileUpload()" id="fileChooser"/> 
                                    </form>
                                </div>
                            </div> 


                            @if($compact_array['dealer_deatails']->status == "Active")           
                            <p><i class="fa fa-check-square-o" aria-hidden="true"></i> Verified</p>
                            @endif
                            <h5>{{$compact_array['dealer_deatails']->dealer_name}}</h5>
                            <p>{{$compact_array['dealer_deatails']->dealership_name}}</p>
                            <p class="btn btn-primary" id="flip">View Contact Details <i class="fa fa-hand-o-left" aria-hidden="true"></i></p>
                            <ul id="panel">
                                @if(!empty($compact_array['dealer_deatails']->landline_no))
                                <li><span class="glyphicon glyphicon-phone-alt"></span>{{$compact_array['dealer_deatails']->landline_no}}</li>
                                @endif
                                <li><span class="glyphicon glyphicon-phone"></span>{{$compact_array['dealer_deatails']->d_mobile}}</li>
                                <li><span class="glyphicon glyphicon-envelope"></span><a href="#" title="mail">{{$compact_array['dealer_deatails']->d_email}}</a></li>
                            </ul>
                            <span class="btn btn-primary col-xs-6">
                                @if($compact_array['count'] == 0)
                                No Car
                                @elseif($compact_array['count'] == 1)
                                {{$compact_array['count']}} Car
                                @else
                                {{$compact_array['count']}} Cars 
                                @endif </span>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-xs-12 profile-info pull-right">
                            <div class="addcover pull-right">
                                <ul><li><i class="fa fa-camera" aria-hidden="true"></i></li></ul>
                                <ul class="addcoverul">
                                    <li><a>
                                            <div class="fileUpload">
                                                <span><i class="fa fa-retweet" aria-hidden="true"></i> Change Cover Photo</span>
                                                <form method="post" id="cover_photo" action="{{url('cover_image')}}" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <input type="file" name="cover_images" class="upload cover_image insert_cover" />
                                                    <input type="hidden" class="remove_cover_image" name="remove_cover_image">
                                                </form>
                                            </div></a></li>
                                    <li class="remove_cover"><a><i class="fa fa-times" aria-hidden="true"></i> Remove Cover Photo</a></li>
                                </ul>
                            </div>
                            <div class="social pull-right">
                                <ul class="social-network social-circle">
                                    <li style="display: none;"><a href="@if($compact_array['dealer_deatails']->facebook_link)
                                           {{'http://'.$compact_array['dealer_deatails']->facebook_link}}
                                           @else
                                           {{'https://www.facebook.com/dealerplusin/'}}
                                           @endif
                                           " target="_blank" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                    <li style="display: none;"><a href="@if($compact_array['dealer_deatails']->twitter_link)
                                           {{'http://'.$compact_array['dealer_deatails']->twitter_link}}
                                           @else
                                           {{'https://twitter.com/dealerplusin'}}
                                           @endif" target="_blank" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li style="display: none;"><a href="@if($compact_array['dealer_deatails']->linkedin_link)
                                           {{'http://'.$compact_array['dealer_deatails']->linkedin_link}}
                                           @else
                                           {{'https://www.linkedin.com/'}}
                                           @endif" target="_blank" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="@if($compact_array['dealer_deatails']->dealership_website)
                                           {{'http://www.'.$compact_array['dealer_deatails']->dealership_website}}
                                           @else
                                           {{'http://www.dealerplus.in/'}}
                                           @endif
                                           " target="_blank" class="icoLinkedin" title="WebSite"><i class="fa fa-globe"></i></a></li>
                                </ul>

                                <!-- <a  target="_blank"><i class="fa fa-globe" aria-hidden="true"> Web Site</i></a>  -->
                            </div>
                        </div>
                    </div>
                    <div id="sticky">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-menu" role="tablist">
                            <li class="active">
                                <a href="#profile" role="tab" data-toggle="tab">
                                    <i class="fa fa-male"></i> Profile
                                </a>
                            </li>
                            <li><a href="#change" role="tab" data-toggle="tab">
                                    <i class="fa fa-key"></i> Edit Profile
                                </a>
                            </li>
                            <li><a href="#document" role="tab" data-toggle="tab">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i> Documents
                                </a>
                            </li>
                        </ul><!--nav-tabs close-->

                        <!-- Tab panes -->
                        <div class="tab-content col-xs-12">
                            <div class="tab-pane fade active in row card" id="profile">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4 class="pro-title">My Business Profile</h4>
                                        </div><!--col-md-12 close-->


                                        <div class="col-sm-8 col-xs-12">
                                            @if($compact_array['count'] == 0)
                                            <li class="panel panel-primary alert no-cars">
                                                Please Add Your Inventory Listing
                                            </li>
                                            @else
                                            @foreach($compact_array['car_listing'] as $fetch)
                                            <ul id="listing">
                                                <li class="panel panel-primary alert">
                                                    <div class="panel-body all-list">
                                                        <span class="label-list">Viewed</span>
                                                        @if(!empty($fetch->car_image))
                                                        <div class="col-xs-12 col-sm-4 search-image"><img src="{{$fetch->car_image}}" class="img-responsive style_prevu_kit" alt=""/>
                                                            <p class="text-primary count-photo">{{$fetch->car_image_count}} 
                                                                @if($fetch->car_image_count == 1)
                                                                photo
                                                                @else
                                                                photos
                                                                @endif</p>
                                                        </div>
                                                        @else
                                                        <div class="col-xs-12 col-sm-4 search-image"><img src="{{URL::asset('img/default-car.png')}}" class="img-responsive style_prevu_kit" alt=""/>
                                                            <p class="text-primary count-photo">{{$fetch->car_image_count}} 
                                                                @if($fetch->car_image_count == 1)
                                                                photo
                                                                @else
                                                                photos
                                                                @endif</p>
                                                        </div>
                                                        @endif

                                                        <div class="col-xs-12 col-sm-8 list-text"><h4 class="text-primary buy-list">
                                                                @foreach($compact_array['model'] as $fetch_model)
                                                                @if($fetch_model->model_id == $fetch->model_id)
                                                                {{$fetch_model->model_name}} 
                                                                @endif
                                                                @endforeach
                                                                @foreach($compact_array['variant'] as $fetch_variant)
                                                                @if($fetch_variant->variant_id == $fetch->variant)
                                                                {{$fetch_variant->variant_name}}
                                                                @endif
                                                                @endforeach
                                                            </h4>
                                                            <p class="text-primary"><i class="fa fa-map-marker"></i>&nbsp;
                                                                @foreach($compact_array['city'] as $fetch_city)
                                                                @if($fetch_city->city_id == $fetch->car_city)
                                                                {{$fetch_city->city_name}}
                                                                @endif
                                                                @endforeach <span class="list-date">- listed @if($fetch->day == 0)
                                                                    {{'Today'}}
                                                                    @else
                                                                    {{$fetch->day}}
                                                                    days ago
                                                                    @endif
                                                                </span></p>                        
                                                            <p class="list-detail"><span class="text-muted">{{$fetch->kms_done}} Km</span> | <span class="text-muted">{{$fetch->fuel_type}}</span> | <span class="text-muted">{{$fetch->registration_year}}</span> | <span class="text-muted">{{$fetch->owner_type}}</span></p>
                                                            <p class="sale"><span class="rate"><i class="fa fa-rupee"></i></span> {{$fetch->price}}</p>
                                                            <ul class="view-buttons pull-right">
                                                                <li><a class="btn btn-primary all-list-btn btn-sm viewlisting" data-id="{{$fetch->car_id}}">View More</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-xs-12 email">
                                                            <h4 class="col-xs-12 col-sm-12 email-alert">Get Email alerts for new listing this search</h4>
                                                        </div>
                                                    </div>

                                                </li>

                                            </ul>
                                            @endforeach
                                            {{$compact_array['car_listing']->links()}}
                                            @endif
                                        </div><!--col-md-6 close-->

                                        <div class="col-sm-4 col-xs-12  businesscon">
                                            <div class="col-xs-12 card">
                                                <div class="panel-heading"><b>About Us</b></div>
                                                <p>{{$compact_array['dealer_deatails']->about_us}}</p>
                                            </div>
                                            <!-- <div class="col-xs-12 card">
                                                <div class="panel-heading"><b>Map View </b></div>
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d7775.259104962695!2d80.25971612276848!3d12.995529463360684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sfalconnect!5e0!3m2!1sen!2sin!4v1480317457160" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                                            </div> -->

                                            <div class="col-xs-12 card">
                                                <div class="panel-heading"><b>Map View </b></div>
                                                <!-- @if(!empty($compact_array['dealer_branches']->branch_address))
                                                <iframe src="https://maps.google.it/maps?q=
                                                        {{$compact_array['dealer_branches']->branch_address}}
                                                        &output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen>
                                                </iframe>
                                                @else
                                                <iframe src="https://maps.google.it/maps?q=
                                                        chennai
                                                        &output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen>
                                                </iframe>
                                                @endif -->
                                                @if($compact_array['headquarter'])
                                                <iframe src="https://maps.google.it/maps?q=
                                                        {{$compact_array['headquarter']->branch_address}}
                                                        &output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                                                @else
                                                @foreach($compact_array['city'] as $fetch_city)
                                                @if($fetch_city->city_id == $compact_array['dealer_deatails']->d_city)
                                                <iframe src="https://maps.google.it/maps?q=
                                                        {{$fetch_city->city_name}}
                                                        &output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                                                @endif
                                                @endforeach
                                                @endif
                                            </div>


                                            <div class="col-xs-12 card">
                                                <div class="panel-heading"><b>Private Details</b></div>
                                                <div class="row">
                                                    <label class="col-lg-5 col-xs-12">Line of Business</label>
                                                    <p class="col-lg-7 col-xs-12">
                                                        @foreach($compact_array['lineof_business'] as $fetch)
                                                        @if($fetch->l_id == $compact_array['dealer_deatails']->line_of_business)
                                                        {{$fetch->business_name}}</p>
                                                    @endif
                                                    @endforeach
                                                </div>
                                                <div class="row">
                                                    <label class="col-lg-5 col-xs-12">Company status</label>
                                                    <p class="col-lg-7 col-xs-12">
                                                        @foreach($compact_array['company_type'] as $fetch)
                                                        @if($fetch->company_type_id == $compact_array['dealer_deatails']->company_status)
                                                        {{$fetch->company_type_name}}</p>
                                                    @endif
                                                    @endforeach
                                                </div>
                                                <div class="row">
                                                    <label class="col-lg-5 col-xs-12">Dealership Started</label>
                                                    <p class="col-lg-7 col-xs-12">{{$compact_array['dealer_deatails']->dealership_started}}</p>
                                                </div>
                                                <div class="row">
                                                    <label class="col-lg-5 col-xs-12">PAN Number</label>
                                                    <p class="col-lg-7 col-xs-12">{{$compact_array['dealer_deatails']->pan_no}}</p>
                                                </div>
                                                <div class="row">
                                                    <label class="col-lg-5 col-xs-12">Dealership Type</label>
                                                    <p class="col-lg-7 col-xs-12">Used Cars</p>
                                                </div>
                                                <div class="row">
                                                    <label class="col-lg-5 col-xs-12">Company Incorporation Documents</label>
                                                    <p class="col-lg-7 col-xs-12">Document.doc</p>
                                                </div>

                                            </div>
                                        </div><!--col-md-6 close-->
                                    </div><!--row close-->
                                </div><!--container close-->
                            </div><!--tab-pane close-->
                            <div class="tab-pane fade  row" id="change">
                                <div class="col-xs-12 fom-main card">

                                    <h2>Manage Your Business Profile</h2>
                                    <br />
                                    <form method="post" action="{{url('business_insert')}}" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="col-xs-12">
                                            <div class="row">
                                                <div class="form-horizontal main_form text-left" action=" " method="post"  id="contact_form">
                                                    <fieldset>
                                                        <!-- Text input-->
                                                        <div class="col-xs-12">
                                                            <div class="row">
                                                                <h3 class="inn-head">Dealer Information</h3>
                                                                <div class="col-xs-12 col-sm-6">

                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Dealership Name</label>
                                                                            <input type="text" name="dealership_name" placeholder="Dealership Name" class="form-control data-name validate-space" maxlength="50" tabindex="4" data-validation="alphanumeric,required" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-error-msg="Please Enter Dealershipname" value="{{$compact_array['dealer_deatails']->dealership_name}}" >
                                                                        </div> 
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-12 col-sm-6">                                                              
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Dealer Name</label> 
                                                                            <input type="text" name="dealer_name" placeholder="Dealer Name" class="form-control data-name validate-space"  maxlength="50" tabindex="1" data-validation="alphanumeric,required" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-error-msg="Please Enter Dealername" value="{{$compact_array['dealer_deatails']->dealer_name}}">                              
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-6">     
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Profile Name</label> 
                                                                            <input  name="profile_name" placeholder="Profile Name" id="profile_name" class="form-control check_name validate-space data-name"  type="text" data-validation="alphanumeric,length" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max20" data-validation-error-msg="Please Enter Profile Name" maxlength="20"  value="{{$compact_array['dealer_deatails']->profile_name}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-6">
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <span class="">www.dealerplus.in/ <i class="bussiness_name">{{$compact_array['dealer_deatails']->profile_name}}</i><img src="{{URL::asset('img/speed2.gif')}}" id="loaderDiv" style="display:none" width="15" height="15"> <img src="{{URL::asset('img/sucess.png')}}" id="sucess_logo" style="display:none" width="15" height="15">
                                                                                <img src="{{URL::asset('img/warning.png')}}" id="warning_logo" style="display:none" width="15" height="15">
                                                                            </span>
                                                                        </div>
                                                                        <!-- <span id="profiles" class="" style="display:none"></span>  -->
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-xs-12 col-sm-6">
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Business Domain</label> 
                                                                            <div class="input-group">
                                                                            <span class="input-group-addon">www.dealerplus.in/</span> 
                                                                                <input name="business_domain" placeholder="Business Domain" disabled="" class="form-control bussiness_name" id="check_name" type="text" value="{{$compact_array['dealer_deatails']->business_domain}}">
                                                                                  
                                                                            </div>
            
            
                                                                            
                                                                        </div>
            
                                                                        <input type="hidden" name="_token" value="{{csrf_token()}}" id="checkname">
            
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="row">
                                                                <!-- Text input-->
                                                                <h3 class="inn-head">Contact Information</h3>
                                                                <div class="col-xs-12 col-sm-6">                                                              
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Landline Number</label> 
                                                                            <input type="tel" name="landline" placeholder="Landline Number" class="form-control data-number" value="{{$compact_array['dealer_deatails']->landline_no}}" maxlength="11" tabindex="2" data-validation="required,length" data-validation-optional="false" data-validation-length="8-11" data-validation-error-msg="Enter Landline number">                                                                   
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <!-- Text input-->

                                                                <div class="col-xs-12 col-sm-6">                                                              
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Fax Number</label>  
                                                                            <input name="fax" placeholder="Fax Number" class="form-control" type="text" value="{{$compact_array['dealer_deatails']->fax_no}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Text input-->

                                                                <div class="col-xs-12 col-sm-6">
                                                                    <div class="inputGroupContainer">
                                                                        <!-- <div class="form-group field-wrapper1">
                                                                            <label>Mobile Number</label>  
                                                                            <input name="mobile" placeholder="Mobile Number" class="form-control phonenumbers" type="text" value="{{$compact_array['dealer_deatails']->d_mobile}}" onclick="funClick('phonenumbers')">
                                                                        </div> -->
                                                                        <div class="input-group field-wrapper1">
                                                                            <label>Mobile Number</label>  
                                                                            <span class="input-group-addon">+91</span>
                                                                            <input type="tel" name="mobile" value="{{$compact_array['dealer_deatails']->d_mobile}}"  maxlength="10" placeholder="Mobile Number" class="form-control data-number" data-validation="required,length" data-validation-optional="false" data-validation-length="8-11" maxlength="11" data-validation-error-msg="Please Enter Contact Number">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Text input-->

                                                                <div class="col-xs-12 col-sm-6">                                                              
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Email Id</label> 
                                                                            <input name="email" placeholder="Email Id" class="form-control" type="text" disabled="" value="{{$compact_array['dealer_deatails']->d_email}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="row">
                                                                <h3 class="inn-head">Company Information</h3>
                                                                <div class="col-xs-12 col-sm-6"> 
                                                                    <div class="col-xs-12 selectContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Line Of Business</label>
                                                                            <select name="line_of_business" class="form-control">
                                                                                <option  value="">Select Line Of Business</option>
                                                                                @foreach($compact_array['lineof_business'] as $fetch) 
                                                                                @if($compact_array['dealer_deatails']->line_of_business == $fetch->l_id)       
                                                                                <option selected="" value="{{$fetch->l_id}}">{{$fetch->business_name}}</option>       
                                                                                @else
                                                                                <option value="{{$fetch->l_id}}">{{$fetch->business_name}}</option>   
                                                                                @endif    
                                                                                @endforeach                                  
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>                                                          

                                                                <div class="col-xs-12 col-sm-6">
                                                                    <div class="col-md-12 selectContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Company Status</label>
                                                                            <select name="company_status" class="form-control">
                                                                                <option value="">Select Company Status</option>
                                                                                @foreach($compact_array['company_type'] as $fetch)
                                                                                @if($compact_array['dealer_deatails']->company_status == $fetch->company_type_id)
                                                                                <option selected="" value="{{$fetch->company_type_id}}">{{$fetch->company_type_name}}</option>
                                                                                @else
                                                                                <option value="{{$fetch->company_type_id}}">{{$fetch->company_type_name}}</option>
                                                                                @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Text input-->
                                                                <!-- 
                                                                                                                                <div class="col-xs-12 col-sm-6">
                                                                                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                                                                                        <div class="form-group field-wrapper1">
                                                                                                                                            
                                                                                                                                            <input name="dealership_started" placeholder="Dealership Started" class="form-control" type="text" > 
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                -->

                                                                <div class="col-sm-6 col-xs-12">
                                                                    <div class='input-group date field-wrapper1' >
                                                                        <label>Dealership Started</label>  
                                                                        <input type='text' name="dealership_started" class="form-control" placeholder="Dealership Started" data-validation="date" data-validation-optional="true" data-validation-error-msg="Please Select Valid Date" value="{{$compact_array['dealerdata'][0]->dealership_started}}"  readonly />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <!-- Text input-->

                                                                <div class="col-xs-12 col-sm-6">                                               
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                    <div class="inputGroupContainer">
                                                                        <div class="input-group field-wrapper1 form-group">
                                                                            <label>Dealership Website</label>

                                                                            <span class="input-group-addon">www</span>
                                                                            <input name="dealership_website" placeholder="Dealership Website" class="form-control" type="text" value="{{$compact_array['dealer_deatails']->dealership_website}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>

                                                                <!-- Text input-->
                                                                <div class="col-xs-12 col-sm-6">                                                              
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>PAN Number</label> 
                                                                            <input name="pan" placeholder="PAN Number" class="form-control data-name" type="text" value="{{$compact_array['dealer_deatails']->pan_no}}" maxlength="10">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Text input-->

                                                                <div class="col-xs-12 col-sm-6"  style="display: none;">                                                  
                                                                    <div class="col-xs-12 inputGroupContainer"> 
                                                                        <div class="input-group field-wrapper1 form-group">
                                                                            <label>Facebook Link</label>
                                                                            <span class="input-group-addon">www.facebook.com/</span>
                                                                            <input name="facebook" placeholder="Facebook Link" class="form-control" type="text" value="{{str_replace('www.facebook.com/', ' ',$compact_array['dealer_deatails']->facebook_link)}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Text input-->

                                                                <div class="col-xs-12 col-sm-6" style="display: none;">                                                  
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="input-group field-wrapper1 form-group">
                                                                            <label>Twitter Link</label>

                                                                            <span class="input-group-addon">www.twitter.com/</span>
                                                                            <input name="twitter" placeholder="Twitter Link" class="form-control" type="text" value="{{str_replace('twitter.com/', ' ',$compact_array['dealer_deatails']->twitter_link)}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Text input-->

                                                                <div class="col-xs-12 col-sm-6" style="display: none;">                                                 
                                                                    <div class="col-xs-12 inputGroupContainer">    
                                                                        <div class="input-group field-wrapper1 form-group">
                                                                            <label>LinkedIn Link</label>
                                                                            <span class="input-group-addon">www.linkedin.com/</span>
                                                                            <input name="linkedin" placeholder="LinkedIn Link" class="form-control" type="text" value="{{str_replace('www.linkedin.com/', ' ',$compact_array['dealer_deatails']->linkedin_link)}}">
                                                                        </div>
                                                                    </div>                                                         
                                                                </div>                                                         

                                                                <div class="col-xs-12">
                                                                    <div class="col-xs-12 inputGroupContainer">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>About Us</label>
                                                                            <textarea class="form-control" name="comment" value="" placeholder="About Us" >{{$compact_array['dealer_deatails']->about_us}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="row">
                                                                <!-- upload profile picture -->
                                                                <!--  <h3 class="inn-head">Uploads</h3>
                                                                 <div class="col-xs-12 col-sm-6 mt">
                                                                     <label> Upload Company Logo</label>
                                                                     <input type="file" id=""  name="company_logo" class="BSbtninfo upload" data-validation-optional="true"  data-validation-allowing="jpg, png" data-validation-error-msg="Please Upload Images">
 
 
 
 
 
                                                                 </div> -->
                                                                <!-- 
 
                                                                <!-- Button -->
                                                                <div class="form-group col-xs-10 mt">
                                                                    <div class="col-xs-6">
                                                                        <button type="submit" class="btn btn-primary submit-button" >Save</button>
                                                                        <button type="reset" class="btn btn-primary submit-button" >Cancel</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div><!--row close-->
                                        </div><!--container close -->   
                                    </form>       
                                </div><!--tab-pane close-->
                            </div><!--tab-content close-->
                            <div class="tab-pane fade  row card" id="document">
                                <div class="col-xs-12">
                                    <form method="post" id="bus_doc1" action="{{url('business_documnet')}}" enctype="multipart/form-data">                                 
                                        <div class="col-xs-12 col-sm-5">   
                                            <div class="form-group field-wrapper1">
                                                <label>Document Name</label>
                                                @if($compact_array['document_doc_1'])
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['document_doc_1']->file_type}}">
                                                @else
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="">
                                                @endif
                                                <!-- </form> -->
                                            </div> 
                                        </div>                              
                                        <div class="col-sm-5 col-xs-12 mt">
                                            <input type="file" name="contact_document" class="BSbtninfo1 document1 fileuploadrestriction" data-size="2" onchange="funChange('cancel1', 'save1', 'alertmessage1')" data-placeholder="My place holder" />
                                            <input type="hidden" name="file_id" value="1">
                                        </div>
                                    </form>
                                    <div class="col-sm-2 col-xs-12 mt">
                                        <a class="btn btn-primary save1 hidden" onclick="funClick('download1', 'save1', 'cancel1', 'bus_doc1', 'alertmessage1')"><i class="fa fa-upload"></i></a>
                                        <a class="btn btn-primary cancel1 hidden" onclick="funcancel('save1', 'cancel1', 'alertmessage1')"><i class="fa fa-ban"></i></a>
                                        @if($compact_array['document_doc_1'])
                                        <a href="{{$compact_array['document_doc_1']->file_url}}" download="{{$compact_array['document_doc_1']->file_name}}" class="btn btn-primary download1"><i class="fa fa-download"></i></a>
                                        @else
                                        <a href="" download="" class="btn btn-primary download1 hidden"><i class="fa fa-download"></i></a>
                                        @endif
                                        <span class="hidden" id="alertmessage1"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <form method="post" id="bus_doc2" action="{{url('business_documnet')}}" enctype="multipart/form-data">                                 
                                        <div class="col-xs-12 col-sm-5">   
                                            <div class="form-group field-wrapper1">
                                                <label>Document Name</label>
                                                @if($compact_array['document_doc_2'])
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['document_doc_2']->file_type}}">
                                                @else
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id">
                                                @endif
                                            </div> 
                                        </div>                              
                                        <div class="col-sm-5 col-xs-12 mt">
                                            <input type="file" name="contact_document" class="BSbtninfo2 fileuploadrestriction" data-size="2"  onchange="funChange('cancel2', 'save2', 'alertmessage2')" />
                                            <input type="hidden" name="file_id" value="2">

                                        </div>
                                    </form>
                                    <div class="col-sm-2 col-xs-12 mt">
                                        <a class="btn btn-primary save2 hidden" onclick="funClick('download2', 'save2', 'cancel2', 'bus_doc2', 'alertmessage2')"><i class="fa fa-upload"></i></a>
                                        <a class="btn btn-primary cancel2 hidden"><i class="fa fa-ban" onclick="funcancel('save2', 'cancel2')"></i></a>
                                        @if($compact_array['document_doc_2'])
                                        <a href="{{$compact_array['document_doc_2']->file_url}}" download="{{$compact_array['document_doc_2']->file_name}}" class="btn btn-primary download2"><i class="fa fa-download"></i></a>
                                        @else
                                        <a href="" download="download" class="btn btn-primary download2 hidden"><i class="fa fa-download"></i></a>
                                        @endif
                                        <span class="hidden" id="alertmessage2"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <form method="post" id="bus_doc3" action="{{url('business_documnet')}}" enctype="multipart/form-data">    
                                        <div class="col-xs-12 col-sm-5">   
                                            <div class="form-group field-wrapper1">
                                                <label>Document Name</label>
                                                @if($compact_array['document_doc_3'])
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['document_doc_3']->file_type}}">
                                                @else
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id">
                                                @endif
                                            </div> 
                                        </div>                              
                                        <div class="col-sm-5 col-xs-12 mt">
                                            <input type="file" name="contact_document" class="BSbtninfo3 fileuploadrestriction" data-size="2" onchange="funChange('cancel3', 'save3', 'alertmessage3')" />
                                            <input type="hidden" name="file_id" value="3">
                                        </div>
                                    </form>
                                    <div class="col-sm-2 col-xs-12 mt">
                                        <a class="btn btn-primary save3 hidden" onclick="funClick('download3', 'save3', 'cancel3', 'bus_doc3', 'alertmessage3')"><i class="fa fa-upload"></i></a>
                                        <a  class="btn btn-primary cancel3 hidden" onclick="funcancel('save3', 'cancel3')"><i class="fa fa-ban"></i></a>
                                        @if($compact_array['document_doc_3'])
                                        <a  href="{{$compact_array['document_doc_3']->file_url}}" download="{{$compact_array['document_doc_3']->file_name}}" class="btn btn-primary download3"><i class="fa fa-download"></i></a>
                                        @else
                                        <a  href="" download="download" class="btn btn-primary download3 hidden"><i class="fa fa-download"></i></a>
                                        @endif
                                        <span class="hidden" id="alertmessage3"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <form method="post" id="bus_doc4" action="{{url('business_documnet')}}" enctype="multipart/form-data">   
                                        <div class="col-xs-12 col-sm-5">   
                                            <div class="form-group field-wrapper1">
                                                <label>Document Name</label>
                                                @if($compact_array['document_doc_4'])
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['document_doc_4']->file_type}}">
                                                @else
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id">
                                                @endif
                                            </div> 
                                        </div>                              
                                        <div class="col-sm-5 col-xs-12 mt">
                                            <input type="file" name="contact_document" class="BSbtninfo4 fileuploadrestriction" data-size="2" onchange="funChange('cancel4', 'save4', 'alertmessage4')" />
                                            <input type="hidden" name="file_id" value="4">
                                        </div>
                                    </form>
                                    <div class="col-sm-2 col-xs-12 mt">
                                        <a  class="btn btn-primary save4 hidden" onclick="funClick('download4', 'save4', 'cancel4', 'bus_doc4', 'alertmessage4')"><i class="fa fa-upload"></i></a>
                                        <a  class="btn btn-primary cancel4 hidden" onclick="funcancel('save4', 'cancel4', 'alertmessage4')"><i class="fa fa-ban"></i></a>
                                        @if($compact_array['document_doc_4'])
                                        <a href="{{$compact_array['document_doc_4']->file_url}}" download="{{$compact_array['document_doc_4']->file_name}}" class="btn btn-primary download4"><i class="fa fa-download"></i></a>
                                        @else
                                        <a href="" download="download" class="btn btn-primary download4 hidden"><i class="fa fa-download"></i></a>
                                        @endif
                                        <span class="hidden" id="alertmessage4"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <form method="post" id="bus_doc5" action="{{url('business_documnet')}}" enctype="multipart/form-data">   
                                        <div class="col-xs-12 col-sm-5">   
                                            <div class="form-group field-wrapper1">
                                                <label>Document Name</label>
                                                @if($compact_array['document_doc_5'])
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id" value="{{$compact_array['document_doc_5']->file_type}}">
                                                @else
                                                <input type="text" class="form-control" name="documt_name" placeholder="Document Name" data-validation="alphanumeric" data-validation-optional="true" data-validation="length" data-validation-length="max15"  data-validation-error-msg="Please Enter Valid Id">
                                                @endif
                                            </div> 
                                        </div>                              
                                        <div class="col-sm-5 col-xs-12 mt">
                                            <input type="file" name="contact_document" class="BSbtninfo5 fileuploadrestriction" data-size="2" onchange="funChange('cancel5', 'save5', 'alertmessage5')" />
                                            <input type="hidden" name="file_id" value="5">
                                        </div>
                                    </form>
                                    <div class="col-sm-2 col-xs-12 mt">
                                        <a  class="btn btn-primary save5 hidden" onclick="funClick('download5', 'save5', 'cancel5', 'bus_doc5', 'alertmessage5')"><i class="fa fa-upload"></i></a>
                                        <a  class="btn btn-primary cancel5 hidden" onclick="funcancel('save5', 'cancel5', 'alertmessage5')"><i class="fa fa-ban"></i></a>
                                        @if($compact_array['document_doc_5'])
                                        <a href="{{$compact_array['document_doc_5']->file_url}}" download="{{$compact_array['document_doc_5']->file_name}}" class="btn btn-primary download5"><i class="fa fa-download"></i></a>
                                        @else
                                        <a href="" download="download" class="btn btn-primary download5 hidden"><i class="fa fa-download"></i></a>
                                        @endif
                                        <span class="hidden" id="alertmessage5"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><!--container close-->
                </div>
            </div>
        </div>

    </div>
    @include('footer')
</div>            

</div>

<!-- Loading Scripts -->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
<script src="{{URL::asset('js/common.js')}}"></script>
<script src="{{URL::asset('js/business_profile.js')}}"></script>
<script>
                                           $(".addcoverul").css({
                                           'height': '0px',
                                                   'opacity': '0'
                                                   });
                                           $('.date').datetimepicker('setEndDate', new Date());
                                           var i = 0;
                                           $(".addcover").click(function () {
                                           if (i == 0) {
                                           $(".addcoverul").css({
                                           'height': 'auto',
                                                   'opacity': '1'
                                           });
                                           i = 1;
                                           } else if (i == 1) {
                                           $(".addcoverul").css({
                                           'height': '0px',
                                                   'opacity': '0'
                                           });
                                           i = 0;
                                           }
                                           });</script>
<script>
    $("#panel").slideUp(0);
    $("#flip").click(function () {
    $("#panel").slideToggle("5000");
    });
    $('.BSbtninfo1').filestyle({
    buttonName: 'btn-info',
            buttonText: ' Select a File',
            @if (isset($compact_array['document_doc_1'] -> file_name))
            placeholder: "{{$compact_array['document_doc_1']->file_name}}"
            @endif
    });
    $('.BSbtninfo2').filestyle({
    buttonName: 'btn-info',
            buttonText: ' Select a File',
            @if (isset($compact_array['document_doc_2'] -> file_name))
            placeholder: "{{$compact_array['document_doc_2']->file_name}}"
            @endif
    });
    $('.BSbtninfo3').filestyle({
    buttonName: 'btn-info',
            buttonText: ' Select a File',
            @if (isset($compact_array['document_doc_3'] -> file_name))
            placeholder: "{{$compact_array['document_doc_3']->file_name}}"
            @endif
    });
    $('.BSbtninfo4').filestyle({
    buttonName: 'btn-info',
            buttonText: ' Select a File',
            @if (isset($compact_array['document_doc_4'] -> file_name))
            placeholder: "{{$compact_array['document_doc_4']->file_name}}"
            @endif
    });
    $('.BSbtninfo5').filestyle({
    buttonName: 'btn-info',
            buttonText: ' Select a File',
            @if (isset($compact_array['document_doc_5'] -> file_name))
            placeholder: "{{$compact_array['document_doc_5']->file_name}}"
            @endif
    });</script>
<script type="text/javascript">
    $(document).ready(function () {
    $(document).on('click', '.cpy_logo_save', function(){
    $('#logo').submit();
    });
    $(document).on('click', '.viewlisting', function () {
    $('#car_view_id').val($(this).attr('data-id'));
    $('#view_car_managelist').submit();
    });
    $(".check_name").keyup(function () {
    var name = $(this).val();
    $('.bussiness_name').html(name);
    var profile_name = "{{$compact_array['dealer_deatails']->profile_name}}";
    /*var bussiness_name = $('.bussiness_name').val(name);  */
    var thisid = this;
    /*$(this).addClass('addloading');*/
    if (name.length >= 4)
    {
    $.ajax({
    url: "{{url('check_name')}}",
            type: "post",
            data: {check_name: name, },
            beforeSend: function () {
            $("#loaderDiv").show();
            $('#sucess_logo').hide();
            $('#warning_logo').hide();
            },
            success: function (data)
            {
            if (data == 0)
            {
            $("#loaderDiv").hide();
            $(this).val('');
            $('.bussiness_name').html(profile_name);
            $('#profile_name').val(profile_name);
            $('#sucess_logo').hide();
            $('#warning_logo').show();
            } else
            {
            $("#loaderDiv").hide();
            $("#gif_image").css("display", "none");
            $("div#gif_image").css('display', 'block');
            $('#warning_logo').hide();
            $('#sucess_logo').show();
            $('#profiles').delay(4000).fadeOut(2000);
            }

            }
    });
    }
    });
    });</script>
<script>

    $(function () {
    $('#fileChooser').change(function (e) {
    var img = URL.createObjectURL(e.target.files[0]);
    $('.image').attr('src', img);
    });
    $(".profile-headimg").mouseenter(function () {
    $(".profile-headimgbtn").css({
    'opacity': '0.8',
            'width': '100%',
            'height': '100%'
    });
    });
    $(".profile-headimg").mouseleave(function () {
    $(".profile-headimgbtn").css({
    'opacity': '0',
            'width': '0%',
            'height': '0%'
    });
    });
    $(function () {
    $('#profile_name').on('keypress', function (e) {
    if (e.which == 32)
            return false;
    });
    });
    });</script>
<!-- <script>
    $(".remove-img").click(function () {
        var img = "{{URL::asset('img/noimage.jpg')}}";

        $('.image').attr('src', img);
        $('#image_replace').val(img);
        $('.logo_empty').val(img);

    });
</script> -->
<script type="text/javascript">
    /* $(function () {
     $('.cover_image').change(function(){
     var img = URL.createObjectURL(e.target.files[0]);
     alert('hi');
     return false;
     });
     });*/
    $(function () {
    $('.cover_image').change(function (e) {
    var img = URL.createObjectURL(e.target.files[0]);
    /*var image = "{{URL::asset('img/noimage.jpg')}}";*/
    //return fasle;          
    console.log(img);
    $('.profile-head').css('background-image', 'url(' + img + ')');
    });
    });</script>
<script type="text/javascript">
    $(function () {
    $('.remove_cover').click(function (e) {
    var img = "{{URL::asset('img/noimage.jpg')}}";
    $('.profile-head').css('background-image', 'url(' + img + ')');
    $('.remove_cover_image').val(img);
    });
    });</script>
<SCRIPT type="text/javascript">
    function ValidateFileUpload() {

    var fuData = document.getElementById('fileChooser');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
    alert("Please upload an image");
    } else {
    var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
    if (Extension == "gif" || Extension == "png" || Extension == "bmp"
            || Extension == "jpeg" || Extension == "jpg") {


    if (fuData.files && fuData.files[0]) {

    var size = fuData.files[0].size;
    console.log(size);
    if (size > 2097152){
    $('#image_size').removeClass('fa fa-hand-o-down');
    $('#image_size').html('<h4 style="color: red;font-size: 13px; font-weight: bold" id="error_msg" >(Maximum file size exceeds change image!..)</h4> ');
    $('#savecancelbtn').html('');
    var img = "{{URL::asset('img/noimage.jpg')}}";
    /*$('.image').attr('src', img);
     $('#image_replace').val(img);  */
    return false;
    } else{
    /*var reader = new FileReader();
     
     reader.onload = function(e) {
     $('#blah').attr('src', e.target.result);
     }
     
     reader.readAsDataURL(fuData.files[0]);*/
    $('#image_size').html('upload');
    $('#image_size').addClass('fa fa-hand-o-down');
    $('#savecancelbtn').html('<span class="remove-img col-xs-6 cpy_logo_cancel logo_cancel" style="display: none"><i class="fa fa-close"></i></span><span class="save-img col-xs-6 cpy_logo_save" style="display: none"><i class="fa fa-save"></i></span>');
    $('#fileChooser').change(function (e) {
    var img = URL.createObjectURL(e.target.files[0]);
    $('.image').attr('src', img);
    });
    }
    }

    }


 else {
    alert("Photo only allows file types of GIF, PNG, JPG, JPEG and BMP. ");
    }
    }}
</SCRIPT>
<script type="text/javascript">

</script>
</body>

</html>