        @include('header')
        <div id="loadspinner" class="spinner_manage" style="display:none">
            <img id="img-spinner" src="{{url('ajax-loader.gif')}}" alt="Loading"/>
        </div>
        <form method="post" id="view_car_managelist" action="{{url('mypostingdetails')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="car_view_id" name="car_view_id">
        </form>
        <form method="post" id="car_post" action="{{url('my_inventory_mongo')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="car_push_mongo" name="car_push_mongo">
        </form>
        <div class="ts-main-content">
        
             @include('sidebar')
            <div class="content-wrapper">
                <div class="container-fluid footer-fixed">

                    <div class="row">
                        <div class="content-header col-sm-12">
                            
                            <ol class="breadcrumb">
                                <li><a href="{{url('managelisting')}}"><i class="fa fa-dashboard"></i> Sell</a></li>
                                <li class="active">My Postings</li>
                            </ol>
                        </div>

                        <div class="col-md-12">

                            <div class="col-sm-10 mongoresponse"></div>
                            <h2 class="page-title">My Postings</h2>
                            <center><div class="col-sm-10 mongorevert_status"></div></center>
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
                                    <br>

                                    <!-- ALL TAB START-->
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="all">
                                            <table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">
                                                <tbody>


                                                <!-- {{@$checkcount = count(isset($InventoryAllDetails))}} -->
                                                    @if(count($inventorylistingdata) > 0)
                                                        @foreach($inventorylistingdata as $cardms)
                                                                <tr>
                        <td>
                        <img src="{{$cardms['image']}}" alt="" class="img-responsive table-img"/>            
                    </td>
                    <td>
                        <h4> 
                            {{ $cardms['title']}}
                        </h4>
                        <h5><i class="fa fa-inr"></i> {{$cardms['price']}}</h5>
                        <p class="list-detail">
                            <span class="text-muted">{{$cardms['kms_done']}} km</span> | 
                            <span class="text-muted">{{$cardms['mileage']}} KMPL</span> | 
                            <span class="text-muted">{{$cardms['fuel_type']}}</span>
                        </p>
                    </td>
                        <td class="uploads">
                        <div class="row">
                            <div class="col-xs-3">
                                <p>Image</p>
                                <p>Videos</p>
                                <p>Docs</p>
                            </div>
                            <div class="col-xs-1 count">
                                <p>
                                    {{$cardms['imagecount']}}
                                </p>
                                <p>
                                    {{$cardms['videocount']}}
                                </p>
                                <p>
                                    {{$cardms['documentcount']}}
                                </p>
                            </div>
                            <div class="col-xs-3">
                                <p>Views</p>
                            </div>
                            <div class="col-xs-1 count">
                                <p>
                                {{$cardms['viewscount']}}
                                </p>
                            </div>
                        </div>
                    </td>
                            <td>
                            <p class="list-detail col-xs-1">
                            <h5>List Posted Platform</h5>
                                
                                DealerPlus
                            </p>
                            </td>
                            <td class="">
                                <ul class="customize">
                        
                            </ul>
                        </td>
                            <td class="">
                                <a class="btn btn-sm btn-primary viewmypost" data-id="{{$cardms['duplicate_id']}}">Details</a>
                            </td>

                        </tr>
                        @endforeach
                        @else
                        
                            <tr>
                                <td>No Listing Found
                                </td>
                            </tr>
                        
                        @endif
                        
                        </tbody>
                            </table>
                            <div>{{$paginatelink}}</div>
                        </div>
                                        <!-- ALL TAB-->
                                            <!-- Draft Tabs End -->
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
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/dealerplus.js"></script>
        <script src="js/fileinput.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
            $('.viewmypost').click(function () {
                $('#car_view_id').val($(this).attr('data-id'));
                $('#view_car_managelist').submit();
            });
        });

        $('body').on("change", ".statuschange", function () {
            var duplicate = $(this).data("duplicateid");
            var statusvalue = $(this).val();
            if (statusvalue == "" || statusvalue == 1)
            {
                return false;
            }
            $.ajax({
                url: "mongo_revert",
                type: "POST",
                dataType: 'text',
                data: {duplicate_id: duplicate},
                success: function (res)
                {
                    $('.mongorevert_status').html('<h1>Mongo Data Successfully Revert..</h1>');
                    window.location.href = "myposting";
                },
                error : function(res){
                    $('.mongorevert_status').html('<h1>Mongo Revert Some Problem please try again..</h1>');
                }
            });
        });
        </script> 
<style type='text/css'> 
            .spinner_manage {
                position: fixed;
                text-align:center;
                z-index:2000;
                overflow: auto;
                width: 100%; 
                height: 100%; 
                opacity: .4; 
                background-color:rgba(0, 0, 0, 0.5);
                padding-top:20%;
            }
        </style>        
    </body>
</html>
