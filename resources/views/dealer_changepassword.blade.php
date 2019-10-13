
        @include('header')
        <div class="ts-main-content">
            @include('sidebar')
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="content-header col-xs-12">
                            <ol class="breadcrumb">
                                <li><a href="{{url('/myeditaccount')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                                <li class="active">Change Password</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">
<!--                            <h2 class="page-title">Change Password</h2>-->
                            <div class="col-sm-8 col-xs-12 col-sm-offset-2">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Change Password</div>
                                    <div class="notificationdiv">
                                        @if (Session::has('message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('message') }}
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                        </div>
                                        @endif
                                        @if (Session::has('messageerr'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('messageerr') }}
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                        </div>
                                        @endif
                                         @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                            @endforeach                                
                                        </div>
                                        @endif
                                    </div>
                                    <div class="panel-body">
                                        <form id="changepassword" action="{{url('dealer_change_password_process')}}" method="POST" class="mt">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="id" value="">
                                            <div class="form-group">
                                                <label for="" class="text-uppercase text-sm">Current Password</label>
                                                <input type="password" name="oldpassword" id="oldpassword" placeholder="Old Password" class="form-control mb data-password" value="" maxlength="16" data-validation="reqired" data-validation-optional="false">
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="text-uppercase text-sm">New Password</label>
                                                <input type="password" name="newpassword" id="newpassword" placeholder="New Password" maxlength="16" class="form-control mb data-password" data-validation="strength" data-validation-strength="2">
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="text-uppercase text-sm">Confirm New Password</label>
                                                <input type="password" maxlength="16" name="confirmnewpassword" id="confirmnewpassword" placeholder="Confirm New Password" class="form-control mb data-password" data-validation="confirmation">
                                            </div>

                                            <button class="btn btn-primary" id="submitbutton" type="submit">Submit</button>
                                            <a class="btn btn-danger btn-close" href="{{ url('cancelform') }}">Cancel</a>



                                        </form>
<!-- @if($errors->any())
<ol style = "color:red">
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach
</ol>
@endif -->
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
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/main.js"></script>
        
        <script src="{{URL::asset('js/dealerplus.js')}}"></script>
        <script type="text/javascript">
$("document").ready(function () {
        $("#newpassword").prop('readonly',true);
        $("#confirmnewpassword").prop('readonly',true);
        $("#submitbutton").prop('disabled',true);
        $("#oldpassword,#newpassword,#confirmnewpassword").change(function () {
            var oldpassword = $("#oldpassword").val();
            var newpassword = $("#newpassword").val();
            var newpasswordcount = newpassword.length;
            var confirmnewpassword = $("#confirmnewpassword").val();
            $(".notificationdiv").html('');            
            if(oldpassword!=''&&newpassword==''&&confirmnewpassword=='')
            {
                $("#newpassword").prop('readonly',false);
                $("#confirmnewpassword").prop('readonly',true);
                $("#submitbutton").prop('disabled',true);
            }
            else if(oldpassword!=''&&newpassword!=''&&confirmnewpassword==''&&(newpasswordcount>=8&&newpasswordcount<=16))
            { 
                $("#confirmnewpassword").val('');  
                $("#confirmnewpassword").prop('readonly',false);
                $("#submitbutton").prop('disabled',true);
            }
            else if(oldpassword!=''&&newpassword!=''&&confirmnewpassword==''&&!(newpasswordcount<8&&newpasswordcount>16))
            {   
                $(".notificationdiv").html('<div class="alert alert-danger">Password Should be  Minimum  8 Characters<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>');
                $("#confirmnewpassword").prop('readonly',true);
                $("#submitbutton").prop('disabled',true);
            }
            else if(oldpassword!=''&&newpassword!=''&&confirmnewpassword!=''&&newpassword==confirmnewpassword)
            {
                $("#submitbutton").prop('disabled',false);
            }
            else if(oldpassword!=''&&newpassword!=''&&confirmnewpassword!=''&&newpassword!=confirmnewpassword)
            {
                $(".notificationdiv").html('<div class="alert alert-danger">New and Confirm Passwords are in Mismatch<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>');
                $("#submitbutton").prop('disabled',true);
            }
            else
            {
                $("#newpassword,#confirmnewpassword").val('');
                $("#newpassword").prop('readonly',true);
                $("#confirmnewpassword").prop('readonly',true);
                $("#submitbutton").prop('disabled',true);
            }
        });
        //
        //    $("#dealer_changepassword").validate({
        //        rules: {
        //            'oldpassword': {
        //                required: true,
        //
        //            },
        //            'newpassword': {
        //                required: true,
        //                //minlength: 8,
        //                //maxlength:16
        //
        //
        //            },
        //            'confirmnewpassword': {
        //                required: true,
        //                //minlength: 8,
        //                //maxlength: 16
        //
        //            },
        //
        //        },
        //
        //        highlight: function (input) {
        //            $(input).addClass('error');
        //        }, errorPlacement: function (error, element) {}
        //
        //    });
        //});
        $.validate({
        modules: 'security',
                onModulesLoaded: function () {

                // Show strength of password
                $('input[name="confirmnewpassword"]').displayPasswordStrength();
                }
        });
        });
        </script>



    </body>

</html>