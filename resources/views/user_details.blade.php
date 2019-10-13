                        <div class="tab-pane fade active in" id="all">
                            <table id="zctb" class="display table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">

                                <thead class="hidden-xs">

                                    <tr>
                                        <th>User Name </th>
                                        <th>User Id</th>
                                        <th>Role</th>
                                        <th>Branch Access</th>
                                        <th>Edit</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>
                                <tfoot class="hidden-xs">

                                    <tr>
                                        <th>User Name </th>
                                        <th>User Id</th>
                                        <th>Role</th>
                                        <th>Branch Access</th>
                                        <th>Edit</th>
                                        <th>Status</th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($user_list as $fetch)                                           
                                
                                    <tr>
                                        <td data-title="User Id">{{$fetch->user_name}}</td>
                                        @if($fetch->user_role == 1)
                                        <td data-title="User Id">{{$fetch->user_email}}

                                            <p>(Primary user)</p></td>

                                        @else
                                        <td data-title="User Id">{{$fetch->user_email}}</td>
                                        @endif
                                            @foreach($compact_array['user_type'] as $fetch_user)
                                            @if($fetch_user->master_role_id == $fetch->user_role) 
                                                 <td data-title="Role">{{$fetch_user->master_role_name}} <span><i class="fa fa-question-circle"  data-toggle="tooltip" title="" data-original-title="Please enter a short description here exceeding no lionger than 100 characters" data-placement="top"></i></span></td>                                                
                                            @endif
                                        @endforeach
                                        <td data-title="Branch Access">
                                            All Branches</td>
                                        @if($fetch->user_role == 1)                                             
                                        <td  data-title="Edit">
                                            <a href="{{url('myeditaccount')}}" class="btn btn-sm btn-success " data-id="{{$fetch->user_id}}" dealer_tbl_id = "{{$fetch->dealer_id}}"><i class="fa fa-pencil"></i></a>  
                                        </td>
                                        <td  data-title="Remove">               <!--  <a  class="" data-id="{{$fetch->user_id}}" dealer_tbl_id = "{{$fetch->dealer_id}}">Active</a> -->
                                        <div class="onoffswitch"><input type="checkbox" class="onoffswitch-checkbox" id="myonoffswitch{{++$i}}" checked="" disabled="">
                                            <label class="onoffswitch-label" for="myonoffswitch{{$i}}">
                                                <span class="onoffswitch-inner-status"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>                                    
                                        </td>
                                        @else
                                        <td  data-title="Edit">
                                            <a  class="btn btn-sm btn-danger edit_user" data-id="{{$fetch->user_id}}" dealer_tbl_id = "{{$fetch->dealer_id}}"><i class="fa fa-remove"></i></a>
                                        </td>

                                        <td  data-title="Remove">                  
                                            <div class="onoffswitch">
                                            @if($fetch->status == 'Active')
                                            <input type="checkbox" class="onoffswitch-checkbox" id="myonoffswitch{{++$i}}" data-id="{{$fetch->user_id}}" dealer_tbl_id = "{{$fetch->dealer_id}}" checked="">
                                            @else
                                            <input type="checkbox" class="onoffswitch-checkbox {{$fetch->user_id}}" id="myonoffswitch{{++$i}}" data-id="{{$fetch->user_id}}" dealer_tbl_id = "{{$fetch->dealer_id}}">

                                            @endif
                                                <label class="onoffswitch-label delete_user" data-id="{{$fetch->user_id}}" dealer_tbl_id = "{{$fetch->dealer_id}}" data-status-check='0'  for="myonoffswitch{{$i}}">
                                                    <span class="onoffswitch-inner-status"></span>
                                                    <span class="onoffswitch-switch-status"></span>
                                                </label>
                                            </div>
                                        </td>


                                        @endif
                                    </tr>
                                
                                @endforeach
                                </tbody>                                            
                            </table>
                        </div>
 <form method="post" id="update" action="{{url('edituser')}}">
    <input type="hidden" name="edit_id" id="edit_id">
    <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
</form>

                        </script>
<script> $(document).ready(function () {
        $("#search-slide").slideUp(0);
        $('.maxuser').click(function(){            
            $('.maxusers_alert').html('<div class="alert alert-danger alert-dismissable" id="name_error"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>For You Plan User Limit is Exceeded</div>');
            $('#name_error').delay(2000).fadeOut(2000);
        });

        $('.edit_user').click(function () {
            if(confirm('Are You Sure Need To Delete User'))
            {
                var edit_id = $(this).attr('data-id');
                var token = $('#token').val();
                $('#edit_id').val(edit_id);
                $('#token').val(token);
                $('#update').submit();
            }
        });

        $('.delete_user').click(function () {
            var delete_user = $(this).attr('data-id');
            var delete_dealer = $(this).attr('dealer_tbl_id');
            var data_statuscheck = $(this).attr('data-status-check');
            if(data_statuscheck==0)
            {
                var thisid = this;            
                $.ajax({
                    url: "{{url('deleteuser')}}",
                    type: "post",
                    data:{delete_user:delete_user,delete_dealer:delete_dealer},
                    success:function(data)
                    {
                        /*console.log(data);
                        return false;*/
                        if(data == 0)
                        {
                            /*$('.onoffswitch-label').prop('checked',false);*/                    
                             window.location.reload();
                        }
                        else if(data == 1)
                        {
                            /*$(thisid).prop('checked',true);*/                        
                             window.location.reload();
                        }
                        else if(data == 2)
                        {
                            /*$(thisid).prop('checked',false);*/      
                            $(thisid).attr('data-status-check',1);
                             $(thisid).click();
                             $('.inactive_alert').html('<div class="alert alert-danger alert-dismissable" id="name_error"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>Alert!... You Plan User Limit is Exceeded</div>');
                             $('#name_error').delay(2000).fadeOut(2000);                  
                             

                             /*window.location.reload();*/
                        }
                    }
                });
            }
            else
            {
                $(this).attr('data-status-check',0);
            }
        });


    });</script>
