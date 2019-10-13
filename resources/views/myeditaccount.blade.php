@include('header')
@include('sidebar')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="content-header col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="{{url('myeditaccount')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                    <li class="active">My Profile</li>
                </ol>
            </div>
            <div class="col-xs-12">
                <!--<h2 class="page-title">My Profile</h2>-->
                <div class="col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
                    <div class="panel panel-primary">
                        <div class="panel-heading">My Profile</div>
                        @if (Session::has('message'))
                        <div class="alert alert-success" id="message-err">{{ Session::get('message') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                        @endif
                        @if (Session::has('message-err'))
                        <div class="alert alert-danger" id="message-err">{{ Session::get('message-err') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                        @endif
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach                                
                        </div>
                        @endif
                        <div id="maximum_file_size"></div>
                        
                        <div class="panel-body">
                            <form method="post" action="{{url('accounteditprocess')}}" class="form-horizontal" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Name</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" name="fname" value="{{$data['dealer_name']}}" placeholder="Dealer Name" class="form-control data-name validate-space" data-validation="alphanumeric,length" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please Enter Correct Name">
                                    </div>
                                </div>
                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Mail Id</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="mail" name="email" value="{{$data['d_email']}}" placeholder="Mail Id" class="form-control " readonly="" data-validation="email" data-validation-optional="false">
                                    </div>
                                </div>

                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Contact Number</label>

                                    <div class="col-sm-9 col-xs-12">
                                        <div class="input-group"><span class="input-group-addon">+91</span>
                                            <input type="tel" name="mobile" value="{{$data['d_mobile']}}"  maxlength="10" placeholder="Contact Number" class="form-control data-number required-des" data-validation="required,length" data-validation-optional="false" data-validation-length="8-11" maxlength="11" data-validation-error-msg="Please Enter Contact Number">
                                        </div>

                                    </div>
                                </div>
                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Address</label>

                                    <div class="col-sm-9 col-xs-12">
                                        <!-- <input name="address" id="addre" class="form-control addr" rows="3" style="resize:none" data-validation="required,length" data-validation-optional="true" data-validation-length="max250" maxlength="250" data-validation-error-msg="Please Enter Address" value="{{$data['address']}}"> -->

                                        <input type="text" name="address" style="resize:none" id="addre" class="form-control addr required-des" rows="3" placeholder="Address" data-validation="required,length" data-validation-optional="false" data-validation-length="max250" maxlength="250" data-validation-error-msg="Please Enter Address" value="{{$data['address']}}">

                                    </div>
                                </div>

                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">State</label>
                                    <div class="col-sm-9 col-xs-12">                 
                                        <select class="form-control stat sta required-des" name="state" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Please Select One Option">             
                                            <option value="">Select State</option>
                                            @foreach($compact_array['state'] as $fetch)
                                            @if($data['d_state'] == $fetch->id )
                                            <option value="{{$fetch->id}}" selected="" @if(old('state') == $fetch->id) {{ 'selected' }} @endif>{{$fetch->state_name}}</option>
                                            @else
                                            <option value="{{$fetch->id}}" @if(old('state') == $fetch->id) {{ 'selected' }} @endif>{{$fetch->state_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">City</label>
                                    <div class="col-sm-9 col-xs-12">                  
                                        <select class="form-control city required-des" id="citys" name="city" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Please Select One Option">             
                                            <option value="">Select City</option>
                                            @foreach($compact_array['city'] as $fetch)
                                            @if($data['d_city'] == $fetch->city_id )
                                            <option value="{{$fetch->city_id}}" selected="" @if(old('citys') == $fetch->city_id) {{ 'selected' }} @endif>{{$fetch->city_name}}</option>
                                            @else
                                            <option value="{{$fetch->city_id}}" @if(old('citys') == $fetch->city_id) {{ 'selected' }} @endif>{{$fetch->city_name}}</option>
                                            @endif
                                            @endforeach

                                        </select>
                                    </div>     

                                </div>





                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Pincode</label>
                                    <?php
                                    if ($data['pincode'] == 0) {
                                        $data['pincode'] = "";
                                    }
                                    ?>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" name="pincode" value="{{$data['pincode']}}" class="form-control data-number required-des" placeholder="Pincode" maxlength="6" data-validation="required,length" data-validation-optional="true" data-validation-length="6" data-validation-error-msg="Please Enter pincode">
                                    </div>
                                </div>

                                <!-- <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Other Details</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <textarea class="form-control" name="otherinformation" rows="3" data-validation="required length" data-validation-optional="true" data-validation-length="max250" maxlength="250">{{$data['otherinformation']}}</textarea>
                                    </div>
                                </div> -->


                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Profile Photo</label>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="addimage">
                                            <div class="form-group">
                                                <div>
                                                    <?php
                                                    if ($data['logo'] == "") {
                                                        $data['logo'] = Config::get('common.profilenoimage');
                                                    }
                                                    ?>

                                                    <img src="{{$compact_array['selectdealer']->logo}}" class="image">
                                                    <p class="remove-img" id="blah">X</p>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="fileUpload btn-primary">
                                            <span>Upload Image</span>
                                            <input class="upload"  type="file" name="userimage"  accept=".png, .jpg, .jpeg" data-validation-max-size="2M" data-validation-optional="true"  data-validation-allowing="jpg" data-validation-allowing="jpg, png" data-validation-error-msg="User name has to be an alphanumeric value (3-12 chars)" onchange="return filevalidation(event)" id="fileChooser">                                            
                                            <input type="hidden" name="image_replace" id="image_replace">
                                            
                                        </div>
                                        <div>
                                        <a><h4 class="errorredtext" >(Supported Formats:JPG,PNG and 2MB)</h4></a>
                                        </div>
                                            
                                        <a id="image_size"></a>
                                    </div>

                                </div>


                                <input type="hidden" id="lat" name="lat" class="form-control mb" val="">
                                <input type="hidden" id="lon" name="lon" class="form-control mb" val="">
                                <div class="hr-dashed"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a class="btn btn-danger btn-close" href="{{ url('cancelform') }}">Cancel</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('login_footer')
</div>
</div>

<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script src="{{URL::asset('js/common.js')}}"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDQV38f_h_p7mEF42XKoJTdKqdoE71v7Ak&region-in"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
<script>
/*$(function sreeni() {
    $('#fileChooser').change(function (e) {
        var img = URL.createObjectURL(e.target.files[0]);
        $('.image').attr('src', img);
    });
});*/
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#message-err').delay(1000).fadeOut(1000);        
    });    
</script>
<script>
    $(".remove-img").click(function(){
              var img = "{{URL::asset('img/noimage.jpg')}}";               

        $('.image').attr('src', img);
        $('#image_replace').val(img);         
        

    });   
    </script>
<SCRIPT type="text/javascript">
    function filevalidation() {

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
                if(size > 2097152){                    
                    $('#image_size').html('<h4 style="color: red;font-size: 13px; font-weight: bold" id="error_msg" >(Maximum file size exceeds!..)</h4> ');
                    $('#error_msg').delay(1000).fadeOut(2000);
                     var img = "{{URL::asset('img/noimage.jpg')}}";               
                    /*$('.image').attr('src', img);
                    $('#image_replace').val(img);  */
                    $('#fileChooser').val('');     
                    return false;
                }else{
                            var img = URL.createObjectURL(event.target.files[0]);
                            $('.image').attr('src', img);                      
                }
            }

    } 


else {
        alert("Photo only allows file types of GIF, PNG, JPG, JPEG and BMP. ");
    }
}}
</SCRIPT>
</body>
</html>