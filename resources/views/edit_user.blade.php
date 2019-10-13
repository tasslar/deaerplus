        @include('header')  
        
        <div class="ts-main-content">
            @include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="container-fluid">
                    <div class="content-header col-sm-12">
                        <ol class="breadcrumb">
                            <li><a href="{{url('manageuser')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                            <li class="active">Edit User</li>
                        </ol>
                    </div>
                    @if(Session::has('sucess_msg'))
                        <div class="alert alert-success" id="message-err">{{ Session::get('sucess_msg') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                    @endif
                    <div class="col-xs-12">
                        <h2 class="page-title">Edit User</h2>
                        <form method="post" action="{{url('updateuser')}}" id="updateuservalue">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="row">
                            <div class="col-sm-3"><input class="form-control" type="text" value="{{$compact_array['fetch_user']->user_name}}" name="user_name" id="name_user" /></div>
                            <div class="col-sm-3"><input class="form-control" type="text" value="{{$compact_array['fetch_user']->user_moblie_no}}" name="user_mob" id="mob_user"/></div>
<!--                            <div class="col-sm-2"><input class="form-control" type="mail" value="Mail Id" disabled /></div>-->
                            <div class="col-sm-3"><a href="#" data-email_id = "{{$compact_array['fetch_user']->user_email}}" class="btn btn-primary add-list resetpassword"><i class="fa fa-key"></i>&nbsp; Reset Password</a></div>
                        <div class="col-sm-2  pull-right">
                            <input type="hidden" name="user_id" value="{{$compact_array['fetch_user']->user_id}}">
                            <input type="hidden" name="user_email" value="{{$compact_array['fetch_user']->user_email}}">
                            <a class="btn btn-success add-list updateuser" data-user_id="{{$compact_array['fetch_user']->user_id}}" data-email_id = "{{$compact_array['fetch_user']->user_email}}">Update</a>
                        </div>
                        </div>
                        </form>
                        <div class="hr-dashed"></div>
                        <!-- <div class="row">
                            <div class="col-md-12" id="no-more-tables">
                                <table id="zctb" class="display table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">

                                    <thead class="hidden-xs">

                                        <tr class="hidden-xs">
                                            <th class="text-center"><input type="Checkbox" checked="" />Select All</th>
                                            <th class="text-center">Branch Name</th>
                                            <th class="text-center">Users</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Remove</th>
                                        </tr>

                                    </thead>
                                    <tbody class="vert-align text-center">
                                        <tr>
                                            <td><input type="Checkbox" checked="" /></td>
                                            <td data-title="Branch Name">Anna Nagar</td>
                                            <td data-title="Users">
                                                8</td>                                             
                                            <td  data-title="Role">
                                                <select type="text">
                                                    <option value="0">Role</option>
                                                    <option value="1">Manager</option>
                                                    <option value="2">Viewer</option>
                                                    <option value="3">Editor</option>
                                                </select>
                                            </td>
                                            <td  data-title="Remove">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>

                                        </tr>
                                        <tr>
                                             <td><input type="Checkbox" checked="" /></td>
                                            <td data-title="Branch Name">Anna Nagar</td>
                                            <td data-title="Users">
                                                8</td>                                             
                                            <td  data-title="Role">
                                                <select type="text">
                                                    <option value="0">Role</option>
                                                    <option value="1">Manager</option>
                                                    <option value="2">Viewer</option>
                                                    <option value="3">Editor</option>
                                                </select>
                                            </td>
                                            <td  data-title="Remove">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                             <td><input type="Checkbox" checked="" /></td>
                                            <td data-title="Branch Name">Anna Nagar</td>
                                            <td data-title="Users">
                                                8</td>                                             
                                            <td  data-title="Role">
                                                <select type="text">
                                                    <option value="0">Role</option>
                                                    <option value="1">Manager</option>
                                                    <option value="2">Viewer</option>
                                                    <option value="3">Editor</option>
                                                </select>
                                            </td>
                                            <td  data-title="Remove">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                             <td><input type="Checkbox" checked="" /></td>
                                            <td data-title="Branch Name">Anna Nagar</td>
                                            <td data-title="Users">
                                                8</td>                                             
                                            <td  data-title="Role">
                                                <select type="text">
                                                    <option value="0">Role</option>
                                                    <option value="1">Manager</option>
                                                    <option value="2">Viewer</option>
                                                    <option value="3">Editor</option>
                                                </select>
                                            </td>
                                            <td  data-title="Remove">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="col-md-12"><div class="col-sm-2 col-lg-1 pull-right"><button class="btn btn-primary" type="submit">Save</button></div>
                                    <div class="col-sm-2 col-lg-1 pull-right"><button class="btn btn-danger" type="submit">Cancel</button></div></div>
                                    <div class="hr-dashed"></div>
                            </div>
                        </div> -->
                    </div>
                </div>
                @include('footer')                
            </div>
        </div>
        <form method="post" action="{{url('userresetpassword')}}" id="resetlink">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="user_email" id="user_email">
        </form>
        <!-- <form method="post" action="{{url('updateuser')}}" id="updateuservalue">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form> -->
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <script> $(document).ready(function () {
                          $("#search-slide").slideUp(0);
            });</script>
        <script type="text/javascript">
            $('.BSbtninfo').filestyle({

                buttonName: 'btn-info',

                buttonText: ' Upload Documents'
            });
            $(function () {
                $('.date').datetimepicker();
            });
        </script>
        
        <script src="js/menu.js"></script>
        <script>
           $(".search-click").click(function () {
               $("#search-slide").slideToggle();
            });
            $(".dropdown-toggle").click(function(){
               $(this).parent(".dropdown").ToggleClass("open");
//               $(this).children(".dropdown-menu").slideToggle();
            });
            $(document).ready(function(){
                $('.resetpassword').click(function(){
                    var email_id = $(this).attr("data-email_id");
                    $('#user_email').val(email_id);
                    $('#resetlink').submit();

                });
                $('.updateuser').click(function(){
                    $('#updateuservalue').submit();
                });
                $('#message-err').delay(1000).fadeOut(3000);
            });
        </script>
    </body> 

</html>