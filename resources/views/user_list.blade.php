              
@include('header')
<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="container-fluid footer-fixed">

            <div class="row">
                <div class="content-header col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('/myeditaccount')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                        <li class="active">My User</li>
                    </ol>
                </div>
                <div class="col-xs-12">
                 @if(Session::has('sucess_msg'))
                        <div class="alert alert-success" id="message-err">{{ Session::get('sucess_msg') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                    @endif

                    <h2 class="page-title col-sm-5 col-md-5">My User</h2>

                    <a  class="pull-right btn btn-primary col-xs-12 col-sm-3 col-md-3  add-list id_pass"><i class="glyphicon glyphicon-export"></i>&nbsp; Export Excel</a>
                    @if( $compact_array['limited_users'] == $compact_array['max_user'] )
                    <a href="#" class="pull-right btn btn-primary col-xs-12 col-md-2 col-sm-3  add-list maxuser"><i class="fa fa-plus-square"></i>&nbsp; Add User</a>
                    @elseif($compact_array['limited_users'] < $compact_array['max_user'])
                    <a href="{{url('adduser')}}" class="pull-right btn btn-primary col-md-2 col-xs-12 col-sm-3  add-list"><i class="fa fa-plus-square"></i>&nbsp; Add User</a>
                    @else
                    <a href="#" class="pull-right btn btn-primary col-xs-12 col-md-2  col-sm-3 add-list maxuser"><i class="fa fa-plus-square"></i>&nbsp; Add User</a>
                    @endif
                    <div class="clearfix"></div>
                    @if(Session::has('successdata'))
                    <div class="alert alert-success">{{ Session::get('successdata') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                    @endif
                    @if(Session::has('faildata'))
                    <div class="alert alert-danger">{{ Session::get('faildata') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                    @endif

                    <div class="col-sm-12 maxusers_alert"></div>
                    <div class="col-sm-12 inactive_alert"></div>
                    <div class="row">
                        <div class="col-xs-12  text-center">
                            <a href="{{url('managesubscription')}}" class="btn pull-right  btn-facebook col-xs-12 col-md-3 col-sm-3 ">View My Subscription</a>

                        </div>
                    </div>

                    <div class="hr-dashed"></div>
                    <div class="row">
                        <div class="col-md-12" id="no-more-tables">
                            <ul class="nav nav-tabs inventory-list">
                                <!-- <li  class="active"><a href="#all" data-toggle="tab" aria-expanded="true">All <span class="count"></span></a></li> -->

                                        <!-- <a href="#1" id="employee_tab" class="employee_tab 1" tab_value="1" data-toggle="tab" aria-expanded="true">Manager(1)<span class="count employee_tab"></span></a> -->

                                <li  class="active"><a href="#{{0}}" id="employee_tab" data-toggle="tab" class="employee_tab 0 user_tab_all" aria-expanded="true" tab_value="0">All({{$compact_array['total_count']}}) <span class="count"></span></a></li>

                                @foreach($compact_array['user_type'] as $fetch)
                                <li><a href="#{{$fetch->master_role_id}}" id="employee_tab" class="employee_tab {{$fetch->master_role_id}}" tab_value="{{$fetch->master_role_id}}" data-toggle="tab" aria-expanded="true">{{$fetch->master_role_name}}({{$fetch->type_count}})<span class="count employee_tab"></span></a></li>

                                @endforeach

                            </ul>

                            <br>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="profile"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>

<!-- <form method="post" id="delete" action="{{url('deleteEmployee')}}">
    <input type="hidden" name="delete_employee_id" id="remove_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
<form method="post" id="edit_employe" action="{{url('editEmployee')}}">
    <input type="hidden" name="update_employee" id="update_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
<form method="post" id="view_employe" action="{{url('viewEmployee')}}">
    <input type="hidden" name="view_employee" id="views_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form> -->
<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/dealerplus.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("div#profile").css('display', 'none');
        $("#loadspinner").css("display", "block");
        $('.customer_status').click(function () {
            var customer_status = $(this).attr('data-id');
            var thisid = this;
            $.ajax({
                url: 'status_update',
                type: 'POST',
                data: {customer_status: customer_status},
                success: function (response)
                {
                    console.log(response);
                    if (response = 0)
                    {
                        $(thisid).addClass('label-success');
                        $(thisid).removeClass('label-danger');
                        $(thisid).html('Active');
                    } else
                    {
                        $(thisid).addClass('label-danger');
                        $(thisid).removeClass('label-danger');
                        $(thisid).html('Deactive');
                    }
                }
            });

        });
        /*$('.edit_employee').click(function () {
         var edit_employee = $(this).attr('data-id');
         $('#update_employee').val(edit_employee);
         $('#edit_employe').submit();
         });
         $('.delete_employee').click(function () {
         var delete_id = $(this).attr('data-id');
         $('#remove_employee').val(delete_id);
         $('#delete').submit();
                 
         });
         $('.view_employee').click(function () {
         var view_employee = $(this).attr('data-id');
         $('#views_employee').val(view_employee);
         $('#view_employe').submit();
         });*/
        var all = $('.user_tab_all').attr('tab_value');
        $.ajax({
            url: "user_type",
            type: "post",
            data: {user_type: all},
            success: function (response)
            {
                $("#loadspinner").css("display", "none");
                $("div#profile").css('display', 'block');
                $('#profile').html(response);
                $('.id_pass').attr('href', "{{url('/export-users/0')}}");
                $('#zctb').DataTable();
            }
        });
        $('.employee_tab').click(function () {
            $("#loadspinner").css("display", "block");
            var user_type = $(this).attr('tab_value');
            $.ajax({
                url: "user_type",
                type: "post",
                data: {user_type: user_type},
                success: function (response)
                {
                    $("#loadspinner").css("display", "none");
                    $("div#profile").css('display', 'block');
                    $(".1").removeClass('active in');
                    $('#profile').html(response);
                    $('.id_pass').attr('href', "{{url('/export-users/')}}" + "/" + user_type);
                    $('#zctb').DataTable();
                }
            });
        });
    });
</script>  
<script> $(document).ready(function () {
    $('#message-err').delay(1000).fadeOut(3000);
        $("#search-slide").slideUp(0);
        $('.maxuser').click(function () {
            $('.maxusers_alert').html('<div class="alert alert-danger alert-dismissable" id="name_error"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>For You Plan User Limit is Exceeded</div>');
            $('#name_error').delay(2000).fadeOut(2000);
        });


        

    });</script>      
</body>

</html>
