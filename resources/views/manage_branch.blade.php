        @include('header')
        <div class="ts-main-content">
            @include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="container-fluid footer-fixed">

                    <div class="row">
                        <div class="content-header col-xs-12">

                            <ol class="breadcrumb">
                                <li><a href="{{url('myeditaccount')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                                <li class="active">My Branches</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">

                            <h2 class="page-title col-sm-5 col-md-5">My Branches</h2>
                            <a href="{{url('/export-branch')}}" class="pull-right btn btn-primary col-xs-12 col-md-3 col-sm-3 add-list"><i class="glyphicon glyphicon-export">&nbsp;</i>Export Excel</a>
                            <a href="{{url('addbranches')}}" class="pull-right btn btn-primary col-xs-12 col-sm-3 col-md-2 add-list"><i class="fa fa-plus-square"></i>&nbsp; Add Branch</a>
                            
                          
                            <!-- <div class="col-sm-4 col-xs-12 text-center"><a href="subscription.html" class="btn btn-facebook col-xs-12">Buy Plan</a></div> -->
                            
                            
                            <div class="hr-dashed"></div>
                            <div class="row">

                                <div class="col-md-12">

                                    <div class="panel-body myprof-tab">
                                        <div class="row">
                                            @if(Session::has('successdata'))
                                                <div class="alert alert-success" id="message-err">{{ Session::get('successdata') }}
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                </div>
                                                @endif
                                                @if(Session::has('editdata'))
                                                <div class="alert alert-success" id="message-err">{{ Session::get('editdata') }}
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                </div>
                                                @endif
                                                @if(Session::has('faildata'))
                                                <div class="alert alert-danger" id="message-err">{{ Session::get('faildata') }}
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                </div>
                                                @endif
                                            <form method="post" id="update_branch" name="edit_branch_id" action="{{url('editbranches')}}">
                                                <input type="hidden" name="edit_branch" id="edit_id">
                                                
                                            </form>
                                            @if(!empty($compact_array['branch_null']))
                                            @foreach($compact_array['manage_branch'] as $fetch)
                                            <div class="row"><div class="col-xs-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Branch In @foreach($compact_array['city'] as $city) 
                                                        @if($city->city_id == $fetch->dealer_city)
                                                        {{$city->city_name}}
                                                        @endif
                                                        @endforeach
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        @if($fetch->headquarter == 1)
                                                        <span class="label-list1">Headquarter</span>
                                                        @endif
                                                        <div class="col-sm-4">
                                                            <h3 class="page-title">{{$fetch->dealer_name}}</h3>
                                                            <p class="branch-text"><span class="text-primary"><i class="fa fa-map-marker"></i></span> {{$fetch->branch_address}},
                                                            @foreach($compact_array['state'] as $state)
                                                            @if($state->id == $fetch->dealer_state)
                                                             {{$state->state_name}}
                                                             @endif
                                                             @endforeach, India</p>
                                                            <p class="branch-text"><span class="text-primary"><i class="fa fa-phone"></i></span> {{$fetch->dealer_contact_no}}</p>
                                                            @if($fetch->dealer_mail)
                                                            <p class="branch-text"><span class="text-primary"><i class="fa fa-envelope"></i></span> {{$fetch->dealer_mail}}</p>
                                                            @endif
                                                            @if($fetch->dealer_service)
                                                            <p class="branch-text"><span class="text-primary"><i class="fa fa-wrench"></i></span>       Service centre</p>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-8  branch-border"><iframe src="https://maps.google.it/maps?q={{$fetch->branch_address}}&output=embed" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe></div>
                                                    </div>
                                                    <div class="panel-footer row">
                                                        <div class="col-xs-12">
                                                            <div class="col-sm-4 col-xs-12 text-center pull-left">
                                                                @php 
                                                                    $branchid = Crypt::encrypt($fetch->branch_id);
                                                                @endphp
                                                                <a href="{{url('/editbranches/'.$branchid)}}"  class="btn btn-success col-xs-12 edit_id">Edit</a>
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12 text-center pull-right"><a data-id="{{$fetch->branch_id}}" id="delete" class="btn btn-danger col-xs-12 delete_branch">Delete</a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                            {{ $compact_array['manage_branch']->links() }}
                            @else
                            <li class="panel panel-primary alert no-cars">
                                No Branch Found
                            </li>
                            @endif
                        </div>
                    </div>
                </div>
                @include('footer')
            </div>
        </div>
    </div>
</div>

<!-- Loading Scripts -->
<form method="post" id="delete_branch" action="{{url('delete_branch')}}">
    <input type="hidden" name=_token value="{{csrf_token()}}">
    <input type="hidden" name="delete_id" id="delete_id">
</form>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dealerplus.js" type="text/javascript"></script>
<!--<script src="js/jquery.dataTables.min.js"></script>-->
<!--<script src="js/dataTables.bootstrap.min.js"></script>-->
<script src="js/label-slide.js" type="text/javascript"></script>
<script src="js/fileinput.js"></script>
<script> $(document).ready(function () {
//    $("#search-slide").slideUp(0);
    $('.edit_id').click(function () {
        /*var confirmgg = confirm("Are You Sure... Do You Want to Edit Branch...");
        if (confirmgg)
        {*/
            var edit_id = $(this).attr('data-id');
            $('#edit_id').val(edit_id);
            $('#update_branch').submit();
        /*}*/

    });
    $(".delete_branch").click(function () {
        var confirmgg = confirm("Are You Sure... Do You Want to Delete Branch...");
        if (confirmgg)
        {
            var delete_branch = $(this).attr('data-id')
            $('#delete_id').val(delete_branch);
            $('#delete_branch').submit();
        }
    });
    $('#message-err').delay(1000).fadeOut(1000);
});
</script>
       
</body>

</html>