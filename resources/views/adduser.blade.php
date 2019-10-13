
        @include('header')
        <div class="ts-main-content">
            @include('sidebar') 
            <div class="content-wrapper myprofile">
                <div class="container-fluid footer-fixed">
                    <div class="row">
                        <div class="content-header col-xs-12">
                            <ol class="breadcrumb">
                                <li><a href="{{url('manageuser')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                                <li class="active">My User</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">
                            <div class="alert alert-danger" id="plan_err" style="display: none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
<!--                            <h2 class="page-title">Add User</h2>-->
                            @if($errors->has('dealer_name') || $errors->has('d_email') || $errors->has('period') || Session::has('message-err'))
                            <div id="message-err" class="alert alert-danger">{{ $errors->first('dealer_name') }} {{ $errors->first('d_email') }} {{ $errors->first('period') }} {{ Session::get('message-err') }} 
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                            @endif
                            @if(Session::has('message'))
                                <div class="alert alert-danger" id="message-err">{{ Session::get('message') }}
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body myprof-tab">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Add New Users to Dealer Plus</h4>
                                                    </div>

                                                    <div class="panel-body" id="contactAddress1">

                                                        <div class="col-xs-12" id=""> 
                                                            <form method="post" id="insert_user" action="{{url('insertuser')}}">
                                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                                <div class="row">
                                                                    <h3 class="text-brand mb-2x">To benefit the most from Dealer Plus, Invite your team today.</h3>

                                                                    <div class="col-xs-12 col-sm-12">	
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Name</label>
                                                                            <input type="text" name="user_name" class="form-control validate-space required-des" id="user_name" data-validation-allowing="\s_-" placeholder="Name" data-validation="alphanumeric,required"  data-validation-optional="false"  data-validation-error-msg="Please Enter Username" maxlength="50" value="{{old('user_name')}}">
                                                                        </div>     
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12">	
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Mobile Number</label>
                                                                            <input type="tel" name="user_moblie_no" class="form-control data-number required-des" id="user_moblie_no" placeholder="Mobile Number" data-validation="required" data-validation-optional="false"  maxlength="11" data-validation-error-msg="Enter correct mobile number" value="{{old('user_moblie_no')}}">
                                                                        </div>     
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12">	
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Email Id</label>
                                                                            <input type="text" name="user_email" class="form-control required-des" id="user_email" placeholder="Email Id" data-validation="required,email" data-validation-optional="false" maxlength="50" data-validation-error-msg="Enter correct email id" value="{{old('user_email')}}">
                                                                        </div>     
                                                                    </div>
                                                                    <div class="col-sm-12 col-xs-12">	
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>Role</label>
                                                                            <select type="text" name="user_role" class="form-control required-des" data-validation="required" data-validation-optional="false"  data-validation-error-msg="Select Your Role">
                                                                                <option value="" selected="true" disabled="disabled">Select Role</option>
                                                                                @foreach($compact_array['user_role'] as $fetch)
                                                                                @if($fetch->master_role_id == '1')
                                                                               <!--  <option style="display: none;">{{$fetch->master_role_name}}</option> -->
                                                                                @else
                                                                                <option value="{{$fetch->master_role_id}}" @if(old('user_role')==$fetch->master_role_id) {{'selected'}} @endif >{{$fetch->master_role_name}}</option>
                                                                                @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>     
                                                                    </div>
                                                                    <div class="hr-dashed"></div>
                                                                    <div class="col-sm-6 col-xs-12 pull-right">
                                                                        <button type="submit" class="btn btn-primary pull-right" id="add_user">Add User</button>
                                                                    </div>											

                                                                </div>

                                                            </form>

                                                        </div>
                                                    </div>
                                                    <!-- <div class="panel-heading col-xs-12">
                                                        <div class="col-xs-12 col-sm-7"><p>7 Days to end of Trail</p></div>
                                                        <div class="col-xs-12 col-sm-5"><a href="{{url('managesubscription')}}" class="btn-danger btn btn-sm">Upgrade Account</a></div>
                                                        <div class="col-xs-12 text-center">Basic Plan (You Can add upto {{$compact_array['max_user']}} Members)</div>

                                                    </div> -->
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
            <!-- Loading Scripts -->
            <script src="{{URL::asset('js/jquery.min.js')}}"></script>
            <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
            <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
            <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
            <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
            <script src="{{URL::asset('js/label-slide.js" type="text/javascript')}}"></script>
            <script src="{{URL::asset('js/fileinput.js')}}"></script>
            <script src="{{URL::asset('js/main.js')}}"></script>
            <script src="{{URL::asset('js/menu.js')}}"></script>
            <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
            <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
            <script src="{{URL::asset('js/dealerplus.js')}}"></script>

    </body>
    <script type="text/javascript">
    $('#message-err').delay(4000).fadeOut(1000);
        $("#add_user").click(function (e) {            
       /* e.preventDefault();
        var msg = "";
        if ($('#user_name').val() == "" && $('#user_email').val() == "" && $('#user_moblie_no').val() == "")
        {
            msg = "All fields are required. ";        
            $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
            return false;*/

         {
            $("#insert_user").submit();
        }
    });
    </script>

</html>

<!-- $("#trial").click(function (e) {
    e.preventDefault();
    var msg = "";
    if ($('#dealer_name').val() == "" && $('#d_email').val() == "" && $('#d_mobileno').val() == "")
    {
    msg = "All fields are required. ";
    $("#plan_err").show().html(msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
    return false;

    } else {
    var plan_data = "14 Days";
    $("#plan_duration").val(plan_data);
    $("#payment").val('0');
    $("#subscription_plan_id").val('1');
    $("#frequency_id").val('1');
    $("#register").submit();
    }
});
 -->