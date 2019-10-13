@include('header')
@include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="container-fluid footer-fixed">
                    <div class="content-header col-sm-12">                        
                        <ol class="breadcrumb">
                            <li><a href="{{url('/myeditaccount')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                            <li class="active">Group</li>
                        </ol>
                    </div>

                    <div class="col-xs-12">
                        <h2 class="page-title col-sm-8">Group</h2>
                        <a class="btn pull-right btn-primary col-xs-12 col-sm-3 col-md-2" data-toggle='modal' data-target='#addcometchatgroup'><i class="fa fa-user-plus"></i> Add Group </a>
                        
                        <div class="hr-dashed"></div>
                            <div class="row">
                            @if(Session::has('success'))
                        <div class="alert alert-success" id="message-err">{{ Session::get('success') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        @endif

                        @if(Session::has('warning'))
                        <div class="alert alert-danger" id="message-err">{{ Session::get('warning') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        @endif
                            <div class="col-xs-12" id="no-more-tables">
                                <table id="zctb" class="display table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Group Id</th>
                                            <th>Group Name</th>
                                            <!-- <th>Date Created</th> -->
                                            <th>Members</th>
                                            <!-- <th>Edit</th> -->
                                            <th>Remove</th>
                                            <th>Send Message</th>
                                        </tr>
                                    </thead>
                                    <tbody class="vert-align text-center">
                                        @if(!empty($compact_array['cometchat_group']))
                                            @foreach($compact_array['cometchat_group'] as $fetch)
                                                <tr>
                                                    <td data-title="Group Id">{{$fetch['groupid']}}</td>
                                                    <td data-title="Group Name">
                                                        {{$fetch['groupname']}}
                                                    </td>                                            
                                                    <!-- <td  data-title="Date Created">
                                                        27-Dec-2016<br/>
                                                        9.00AM
                                                    </td> -->
                                                    <td  data-title="Members">
                                                        {{$fetch['groupusercount']}}
                                                    </td>
                                                    <!-- <td data-title="Edit">
                                                        <a href="editgroup.html" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                                                    </td> -->
                                                    <td data-title="Remove">
                                                        <a class="btn btn-sm btn-danger deletegroup" data-id="{{$fetch['groupid']}}"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                    <td data-title="Send Message">
                                                        <a  class="btn btn-sm btn-primary cometchat" data-comet-id="cometchat_grouplist_{{$fetch['groupid']}}">Send Message</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                              <td colspan="5">No Records Found</td>  
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div></div>
                </div>
                @include('footer')
            </div>
        </div>
        <!-- Email Alert -->
        <div class="modal fade" id="addcometchatgroup" tabindex="-1" role="dialog" aria-labelledby="myEmail">
            <div class="modal-dialog email-pop" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title modal-title1" id="myEmail">Add Chat Group</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="form-horizontal" id="addgroupform" action="addgroupform">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" placeholder="Chat Group Name" id="groupname" name="groupname" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-sm-offset-8">
                                    <button type="submit" class="btn btn-primary btn-sm addgroup">Add Group</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" id="deletegroup_chat" action="{{url('deletegroup_chat')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="deletegroup_id" name="deletegroup_id">
        </form>
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dealerplus.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $('body').on("click",".deletegroup",function(){
                var r = confirm("Please confirm need to delete to group");
                if (r == true) {
                    $('#deletegroup_id').val($(this).attr('data-id'));
                    $('#deletegroup_chat').submit();
                    return false;
                }                
            });
            
            $('body').on("click",".addgroup",function(){
                var groupname = $('#groupname').val();
                if (groupname == '')
                {
                    alert('Please Enter Group Name');
                    return false;
                }
                $.ajax({
                    url: 'addgroupform',
                    data: {groupname:groupname},
                    type: 'post',
                    success: function (response) {
                        console.log(response);
                    }
                });
            });
            $(function () {
                $('.date').datetimepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd",
                    startView: "month",
                    minView: "month",
                    maxView: "decade"
                }); 
                
            });
        </script>
    </body> 
</html>