@include('header')
        <div class="ts-main-content">
                @include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="container-fluid">
                    <div class="row">
                        <div class="content-header col-sm-12">
                            <ol class="breadcrumb">
                                <li><a href="{{url('/manage_invoice')}}"><i class="fa fa-dashboard"></i> Accounts</a></li>
                                <li class="active">Quotes</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">
                                @if (Session::has('message'))
                                <div class="alert alert-success" id="message-err">{{ Session::get('message') }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                                @endif
                                @if (Session::has('message-err'))
                                <div class="alert alert-danger" id="message-err">{{ Session::get('message-err') }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                                @endif
                            <h2 class="page-title col-sm-5 col-md-5">Quotes</h2>
                                <a href="{{url('/export_quotes_excel')}}" class="pull-right btn btn-primary col-xs-12 col-md-3 col-sm-3 add-list"><i class="glyphicon glyphicon-export"></i>&nbsp; Export Excel</a>
                                <a href="{{url('addquotes')}}" class="pull-right btn btn-primary col-xs-12 col-sm-3 col-md-2 add-list"><i class="fa fa-plus-square"></i>&nbsp;Add Quotes</a>

                                <div class="hr-dashed"></div>
                            
                            <div class="row">
                                <div class="col-md-12" id="no-more-tables">
                                    <!-- <ul class="nav nav-tabs inventory-list">
                                        <li class="active"><a href="#create" data-toggle="tab" aria-expanded="true">Quotes Created <span class="count-tab">(20)</span></a></li>
                                        <li><a href="#receive" data-toggle="tab" aria-expanded="false">Quotes Received <span class="count-tab">(10)</span></a></li>
                                        
                                    </ul> -->
                                    <br>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="create">
                                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead class="hidden-xs">
                                                    <tr>
                                                        <th>Crt</th>
                                                        <th>Client</th>
                                                        <!-- <th>Estimate</th> -->
                                                        <th>Reference</th>
                                                        <th>Amount</th>
                                                        <th>Estimate Date</th>
                                                        <th>Expiry Date</th>
                                                        <th>Created At</th>
                                                        <th>Status</th>
                                                        <!-- <th>View</th> -->
                                                        <th>Action</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tfoot class="hidden-xs">
                                                    <tr>
                                                        <th>Crt</th>
                                                        <th>Client</th>
                                                        <!-- <th>Estimate</th> -->
                                                        <th>Reference</th>
                                                        <th>Amount</th>
                                                        <th>Estimate Date</th>
                                                        <th>Expiry Date</th>
                                                        <th>Created At</th>
                                                        <th>Status</th>
                                                        <!-- <th>View</th> -->
                                                        <th>Action</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                @if(count($compact_array['dealer_invoice'])>0)
                                                    @foreach($compact_array['dealer_invoice'] as $fetch)
                                                    <tr>
                                                        <td data-title="Crt">{{$fetch->sno}}</td>
                                                        
                                                        <td data-title="Client">{{$fetch->contact_id}}</td>
                                                        
                                                        <!-- <td data-title="Estimate">Estimate 1</td> -->
                                                        <td data-title="Reference">{{$fetch->reference}}</td>
                                                        <td data-title="Amount">{{$fetch->amount}}</td>
                                                        <td data-title="Estimate Date">{{$fetch->start_date}}</td>
                                                        <td data-title="Expiry Date">{{$fetch->end_date}}</td>
                                                        <td data-title="Created At">{{$fetch->created_at}}</td>
                                                        <td data-title="Status"><p class="label label-success" data-id = "{{$fetch->invoice_id}}">
                                                        @foreach($compact_array['status'] as $status)
                                                        @if($status->id == $fetch->invoice_status_id)
                                                        {{$status->name}}
                                                        @endif
                                                        @endforeach
                                                        </p></td>
                                                        <!-- <td data-title="View" data-id = "{{$fetch->invoice_id}}"><a href="#"><i class="fa fa-eye btn btn-sm btn-primary"></i></a></td> -->
                                                        <td  class="view action-button" data-title="Edit Status">
                                                        <!-- <a href="" data-toggle="modal" data-target="#popup">    <i data-toggle="tooltip" data-original-title="Edit Status" data-placement="top" class="fa fa-pencil btn btn-sm btn-circle btn-default"></i>
                                                        </a>
                                                        <a href="#myModal" data-toggle="modal" id="{{$fetch->invoice_id}}" data-target="#popup1"><i data-toggle="tooltip" data-original-title="Edit Due Date" data-placement="top" class="fa fa-calendar btn btn-sm btn-circle btn-default"></i></a>

                                                        <a href="#" data-toggle="modal" data-target="#popup2"><i data-toggle="tooltip" data-original-title="Add Payment" data-placement="top" class="fa fa-money btn btn-sm btn-circle btn-default"></i></a> -->

                                                        <a href="#open_mail_mail" data-id="{{$fetch->invoice_id}}" id="{{$fetch->invoice_id}}" data-toggle="modal" data-target="#open_mail_mail" class="open-model-mail mail_id">
                                                        <i data-toggle="tooltip" data-original-title="Email to Client" data-placement="top" class="fa fa-envelope btn btn-sm btn-circle btn-default" data-id = "{{$fetch->invoice_id}}"></i></a>

                                                        <a href="{{url('exportquotes/'.$fetch->pdfvalue)}}" data-id="{{$fetch->invoice_id}}" target="_blank" id="{{$fetch->invoice_id}}" class=""><i data-toggle="tooltip" data-original-title="Print" data-placement="top" class="fa fa-print btn btn-sm btn-circle btn-default" data-id = "{{$fetch->invoice_id}}"></i></a>

                                                    </td>
                                                        <td data-title="Edit"><a class="editquotes" data-id = "{{$fetch->invoice_id}}"><i class="fa fa-pencil btn btn-sm btn-success"></i></a></td>
                                                        <td data-title="Delete"><a class="deletequotes" data-id = "{{$fetch->invoice_id}}" data-id_value="{{$fetch->invoice_id}}" data-toggle="modal" data-target="#deleteModel"><i class="fa fa-trash btn btn-sm btn-danger"></i></a></td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal fade" id="open_mail_mail" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <form method="post" action="{{url('sendquotesemail')}}">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Send Email</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="quotes_id" id="quotesemail_id" value=""/>
                        <div class="col-xs-12 col-sm-12">
                            <label>Email Content</label>
                            <!-- <textarea class="form-control"  placeholder="Email Message" ></textarea> -->
                             <div class="col-sm-12 col-xs-12">  
                                    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                                        
                                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" disabled="disabled">
                                    </div>

                                    <div id="editor" disabled="disabled"></div>

                                    <textarea rows="2" name="email_subject" id="email_subject"
    cols="20" style="display:none; " > Enter your text here.. </textarea>

                                </div>
                            <p>You are about to send pdf invoice via email to this user.</p>

                            <p>Do you want to proceed ?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_send_email" value="Yes" class="btn btn-primary">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="deleteModel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{url('deletequotes')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Are You Sure Do You Want To Delete?
                    <input type="hidden" value="" id="deletevalue" name="deletequotes">
                </div>
                <div class="modal-footer">
                    <input type="submit" name="" value="Delete" class="btn btn-default">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
        @include('footer')
            </div>
        </div>
        <form method="post" action="{{url('editquotes')}}" id="editquotes">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="editquotes" id="editvalue">
        </form>
        <!-- <form method="post" action="{{url('deletequotes')}}" id="deletequotes">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="deletequotes" id="deletevalue">
        </form> -->
        <form method="post" action="{{url('exportquotes')}}" id="exportquotes">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="exportquotes" id="exportvalue">
        </form>
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/dealerplus.js"></script>
        <script src="js/jquery.hotkeys.js"></script>
        <script src="js/rte.js"></script>
        <script src="js/bootstrap-wysiwyg.js"></script>
        <script type="text/javascript">
            $(document).on('click','.editquotes', function(){
                var edit_id = $(this).attr('data-id');
                $('#editvalue').val(edit_id);
                $('#editquotes').submit();
            });
            /*$(document).on('click','.deletequotes', function(){
                var deletequotes = $(this).attr('data-id');
                $('#deletevalue').val(deletequotes);
                $('#deletequotes').submit();
            });*/
            /*$(document).on('click','.deletequotes',function () {
                var confirmgg = confirm("Are You Sure... Do You Want to Delete...");
                if (confirmgg)
                {
                    var delete_id = $(this).attr('data-id');
                    $('#deletevalue').val(delete_id);
                    $('#deletequotes').submit();
                }
            });*/
            $(document).on('click','.exportquotes',function(){
                var exportquotes = $(this).attr('data-id');
                $('#exportvalue').val(exportquotes);
                $('#exportquotes').submit();
            });

            $(document).on('click','.mail_id',function(){
                var mail_id  = $(this).attr('data-id');
                $('#quotesemail_id').val(mail_id);
            });
            $('#message-err').delay(1000).fadeOut(3000);        
        </script>
        <script type="text/javascript">
            $('#open_mail_mail').on('show.bs.modal', function (e)
            {
                $("#loadspinner").css("display", "block");
                $('#editor').html("");
                var token, data;
                var $modal = $(this),
                        value = e.relatedTarget.id;
                //alert(esseyId);
                token = "{{ csrf_token() }}";

                data = {id: value};
                console.log(data);
                //alert(data);
                $.ajax({
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': token},
                    url: "{{url('emailmsg')}}",
                    data: {quotes_id: value},
                    success: function (response)
                    {
                       $("#loadspinner").css("display", "none");
                       $('#editor').html(response);
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#editor').attr("contenteditable","false");
            });
             $('#deleteModel').on('show.bs.modal', function (e)
                {                    
                    var id_value = e.relatedTarget.dataset.id_value;
                    $("#deletevalue").val(id_value);
                });
        </script>
    </body>

</html>