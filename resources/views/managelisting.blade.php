
        @include('header')
        <form method="post" id="view_car_managelist" action="{{url('view')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="car_view_id" name="car_view_id">
        </form>
        <form method="post" id="marketform" action="{{url('marketing')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="inventory_id" name="inventory_id">
        </form>
        <form method="post" id="sold_managelist" action="{{url('dosoldview')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="sold_id" name="sold_id">
        </form>
        <form method="get" id="view_managelisting" action="{{url('managelisting')}}">
            <input type="hidden" id="sort_change_id" val="0" name="car_view_id">
        </form>
        <form method="post" id="car_post" action="{{url('my_inventory_mongo')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="car_push_mongo" name="car_push_mongo">
        </form>

           @include('sidebar')
            <div class="content-wrapper">
                <div class="container-fluid footer-fixed">

                    <div class="row">
                        <div class="content-header col-sm-12">
                            <div>
                                <ol class="breadcrumb">
                                    <li><a href="{{url('managelisting')}}"><i class="fa fa-dashboard"></i> Sell</a></li>
                                    <li class="active">My Inventory</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-sm-12 mongoresponse"></div>
                            <h2 class="page-title">My Inventory</h2>
                            <div class="col-xs-12">
                               <div class="hidden-md hidden-lg">
                                            <select class="col-xs-12  btn btn-primary" id="sortchangemobile">
                                                <option value="">Sort By</option>
                                                <optgroup label="Price">
                                                    <option value="0">High To Low</option>
                                                    <option value="1">Low To High</option>
                                                </optgroup>
                                                <optgroup label="Mileage">
                                                    <option value="2">High To Low</option>
                                                    <option value="3">Low To High</option>
                                                </optgroup>
                                                <optgroup label="Year">
                                                    <option value="4">Old to New</option>
                                                    <option value="5">New To Old</option>
                                                </optgroup>
                                                <!-- <optgroup label="View">
                                                    <option value="">Most Viewed</option>
                                                    <option value="">least Viewed</option>
                                                </optgroup> -->
                                            </select></div>
                                            <div class="hidden-md hidden-lg">
                                                <a href="{{url('add_listing_tab')}}" class="add-list col-xs-12 btn btn-primary"><i class="fa fa-plus-square"></i>&nbsp;Add Inventory</a>
                                        </div> 
                                </div>
                            <div class="hr-dashed"></div>
                            <!-- Zero Configuration Table -->
                            <div class="row">
                                <div class="col-md-12" id="no-more-tables" class="pushmongo">
                                    @if (Session::has('mongomessage'))
                                    <div class="alert alert-success">{{ Session::get('mongomessage') }}</div>
                                    @endif
                                    @if (Session::has('add_listmessage'))
                                    <div class="alert alert-success">{{ Session::get('add_listmessage') }}</div>
                                    @endif
                                    @if (Session::has('message'))
                                        <div class="alert alert-success" id="message-err">{{ Session::get('message') }}
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                                    @endif
                                    @if (Session::has('message-err'))
                                        <div class="alert alert-danger" id="message-err">{{ Session::get('message-err') }}
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
                                    @endif
                                    <ul class="nav nav-tabs inventory-list">
                                        <li class="commontab {{$type=='alllisting'?'active':''}}" data-value="alllisting"><a href="#all" data-toggle="tab" aria-expanded="true">All</a></li>
                                        <li class="commontab" data-value="parkandsell"><a href="#profile" data-toggle="tab" aria-expanded="false">Park & Sell</a></li>
                                        <li class="commontab" data-value="own"><a href="#profile" data-toggle="tab" aria-expanded="true">Own</a></li>
                                        <!-- <li class="commontab" data-value="hasviews"><a href="#profile" data-toggle="tab" aria-expanded="true">Has Views</a></li> -->
                                        <li class="commontab {{$type=='draft'?'active':''}}" data-value="draft"><a href="#profile" data-toggle="tab" aria-expanded="true">Draft</a></li>
                                        <li class="commontab {{$type=='sold'?'active':''}}" data-value="sold"><a href="#profile" data-toggle="tab" aria-expanded="true">Sold</a></li>
                                        <li class="commontab" data-value="deleted"><a href="#profile" data-toggle="tab" aria-expanded="true">Deleted</a></li>
                                        <li class="pull-right hidden-xs hidden-sm"><a href="{{url('add_listing_tab')}}" class="add-list  btn btn-primary"><i class="fa fa-plus-square"></i>&nbsp;Add Inventory</a>
                                        </li>
                                        
                                        <li class="pull-right  hidden-xs hidden-sm">
                                            <select class="btn btn-primary" id="sortchange">
                                                <option value="">Sort By</option>
                                                <optgroup label="Price">
                                                    <option value="0">High To Low</option>
                                                    <option value="1">Low To High</option>
                                                </optgroup>
                                                <optgroup label="Mileage">
                                                    <option value="2">High To Low</option>
                                                    <option value="3">Low To High</option>
                                                </optgroup>
                                                <optgroup label="Year">
                                                    <option value="4">Old to New</option>
                                                    <option value="5">New To Old</option>
                                                </optgroup>
                                                <!-- <optgroup label="View">
                                                    <option value="">Most Viewed</option>
                                                    <option value="">least Viewed</option>
                                                </optgroup> -->
                                            </select></li>
                                    </ul>
                                    <input type="hidden" name="selectedtab" id="selectedtab" value="{{$type}}">
                                    <br>
                                    <!-- ALL TAB START-->
                                    <div class="tab-content"> 
                                        <div class="tab-pane fade active in" id="profile">
                                        </div>                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('footer')
            </div>
        

        <!-- delete listing popup -->
                        <div id="listdeleteresult" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <form method="get" id="exitinevntory" action="">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Listing is published Already So You Cannot Delete this Listing.</h4>
                              </div>
                            </div> 
                          </div>
                        </div>
        <!-- delete listing popup -->

        <!-- delete listing alert popup start-->
                            <div id="deletepopup" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Are you sure to delete this listing?</h4>
                                  </div>
                                    <h4 class="listingmessage"></h4>
                                  <div class="modal-footer soldresponse"></div>
                                  <div class="modal-footer">
                                  <input type="hidden" class="yesdeleteid" value="">
                                  <input type="button" class="btn btn-default deleteyes" value="Yes">
                                    <button type="button" class="btn btn-default eventchange" data-dismiss="modal">No</button>
                                  </div>
                                </div>
                              </div>
                            </div>
        <!-- delete listing alert popup end-->
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="{{URL::asset('js/dealerplus.js')}}"></script>
        <script type="text/javascript">
        $(document).ready(function () {
            $('.update').click(function () {
                $('#car_id').val($(this).attr('data-id'));
                $('#edit_car_managelist').submit();
            });
        });

        $(document).on('click', '.viewlisting', function () {
            $('#car_view_id').val($(this).attr('data-id'));
            $('#view_car_managelist').submit();            
        });
        $(document).on('click', '#push_mongo', function () {
            $('#car_push_mongo').val($(this).attr('data-id'));
            $('#car_post').submit();
        });

        $(document).ready(function () {
            $('.delete').click(function () {
                $('#car_delete_id').val($(this).attr('data-id'));
                $('#delete_car_managelist').submit();
            });
        });

        $("body").ready(function()
        {
        	var statusvalue = $(".statuschange").val();
        	var duplicate 	= $(".statuschange").data("duplicateid");
        	if(statusvalue == "")
        	{
        		$(".showmongo_post").hide();
        	}
        });
        

        $('body').on("change",".savefloppy",function(){
            $('.mongo_push_data'+$(this).attr("data-duplicateid")).hide();
            var duplicateidvalue = $(this).attr("data-duplicateid");
            $("#statuschange"+duplicateidvalue).css("display","block");
        });

        $('body').on("click",".soldform",function(){
                $('#sold_id').val($(this).attr('data-id'));
                $('#sold_managelist').submit();
                return false;
            });

        $('body').on("click",".marketbutton",function(){
                $('#inventory_id').val($(this).attr('data-id'));
                $('#marketform').submit();
                return false;
            });
        $('body').on("click",".statuschange",function(){
                var duplicateid_onserver = $(this).attr("data-id");
                var status = $('.save_'+duplicateid_onserver).val();
                var thisid = this;
                if(status=='sold')
                {
                    $('#sold_id').val($(this).attr('data-id'));
                    $('#sold_managelist').submit();
                    return false;
                }
                //alert(duplicateid_onserver);
                //alert(status);
                $.ajax({
                    url: "managelisting_status",
                    type: "post",
                    data: {status: status,duplicateid:duplicateid_onserver},
                    success: function (data)
                    {
                        //alert(data);
                        if(data=='sessionout')
                        {
                            window.location.replace("{{url('login')}}");
                            return false;
                        }
                        var response = $.parseJSON(data);

                        if(data == 1){
                            $('.mongoresponse').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Success!</strong>Status Changed</div>');
                            $(thisid).hide();
                            if(status=='readyforsale')
                            {
                                $('.mongo_push_data'+duplicateid_onserver).show();
                                $('.save_'+duplicateid_onserver).empty();
                                var myOptions = {
                                                    readyforsale : 'Ready For Sale',
                                                    sold : 'Sold',
                                                    delete:'Delete'
                                                };
                                var mySelect = $('.save_'+duplicateid_onserver);
                                $.each(myOptions, function(val, text) {
                                mySelect.append(
                                $('<option></option>').val(val).html(text)
                                );
                                });
                                
                            }
                            else if(status=='sold')
                            {
                                $('.save_'+duplicateid_onserver).empty();
                                var myOptions = {
                                                    sold : 'Sold',
                                                    delete:'Delete'
                                                };
                                var mySelect = $('.save_'+duplicateid_onserver);
                                $.each(myOptions, function(val, text) {
                                mySelect.append(
                                $('<option></option>').val(val).html(text)
                                );
                                });
                            }
                            else if(status=='delete')
                            {
                                $('.save_'+duplicateid_onserver).empty();
                                var myOptions = {
                                                    delete:'Delete'
                                                };
                                var mySelect = $('.save_'+duplicateid_onserver);
                                $.each(myOptions, function(val, text) {
                                mySelect.append(
                                $('<option></option>').val(val).html(text)
                                );
                                });
                            }
                        }
                        else if(data == 2){
                           $('.mongoresponse').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>Image Tab is not Filled</div>');
                        }
                        else if(data == 3){
                           $('.mongoresponse').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>Sale Price is Rs.0. Please enter value other than 0</div>');
                        }
                        else if(data == 4){
                           $('.mongoresponse').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>Image Tab and Sale Price is Rs.0. Please enter value other than 0</div>');
                        }
                        else
                        {
                           $('.mongoresponse').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>Pls Try Again After Some Time</div>');
                        }
                        $("html, body").animate({scrollTop: 0}, 600);
                        //setTimeout($('.alert .close').click(), 10000);
                    },                    
                     error:function(e)
                     {
                        $('.mongoresponse').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>Pls Try Again After Some Time</div>');
                     }
                });
        });


        

        $('body').on("change", "#sortchange,#sortchangemobile", function () {
                
                var sort = $(this).val();
                
                $('#sortchangemobile,#sortchange').val(sort);
                ajaxpage();
        });

        
        </script>
        <script>
            //$("body").on('load','.commontabfirst',function(){
            $(document).ready(function () {
                $("div#profile").css('display', 'none');
                $("#loadspinner").css("display", "block");
                $.ajax({
                    url: "managelistingtab",
                    type: "post",
                    data: {tabcategory: '{{$type}}' },
                    success: function (data)
                    {
                        if(data=='sessionout')
                        {
                            window.location.replace("{{url('login')}}");
                            return false;
                        }
                        $("#loadspinner").css("display", "none");
                        $("div#profile").css('display', 'block');
                        $('#profile').html(data);
                    },
                    error:function(e)
                     {
                        $("#loadspinner").css("display", "none");
                        $("div#profile").css('display', 'block');
                        $('.mongoresponse').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Sorry!</strong>Some Thing Went Wrong Please Try Again</div>');
                     }
                });
            });
        </script>
        <script>
            $("body").on('click', '.commontab', function () {
                $('#selectedtab').val($(this).attr('data-value'));
                ajaxpage();
            });

            function ajaxpage(page=1)
            {
                $("div#profile").css('display', 'none');
                $("#loadspinner").css("display", "block");                
                var sort = $('#sortchange').val();                
                var datavalue = $('#selectedtab').val();
                $.ajax({
                    url: "managelistingtab",
                    type: "post",
                    data: {tabcategory: datavalue,sortorder:sort,page:page},
                    success: function (data)
                    {

                        
                        if(data=='sessionout')
                        {
                            //window.location.replace("{{url('login')}}");
                            return false;
                        }
                        $("#loadspinner").css("display", "none");
                        $("div#profile").css('display', 'block');
                        $('#profile').html(data);
                        console.log(data);
                        return false;
                    },
                    error:function(e)
                     {
                        $("#loadspinner").css("display", "none");
                        $("div#profile").css('display', 'block');
                        $('.mongoresponse').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Failed!</strong>Some Thing Went Wrong Please Try Again</div>');
                     }
                });
            }
            
            $("body").on('click', '.pagination li a', function (event) {
                    var paginate_link = $(this).attr('href');
                    var paginate_link_split = paginate_link.split("page=");
                    var pageno = paginate_link_split[1];
                    ajaxpage(pageno);
                    event.preventDefault();

                });
        </script>         
    </body>
</html>
