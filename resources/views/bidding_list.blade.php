
        @include('header')
        @include('sidebar')
            <div class="content-wrapper">
                 <div style="position: fixed;
    background-color: rgba(51, 51, 51, 0.42);
    width: 97%;
    margin-top:21px;
    height: 100%;
    z-index: 1000;"><p style="font-size: 60px;
    transform: rotate(320deg);
    color: rgb(255, 255, 255);
    position: relative;
    top: 147px;
    width: 600px;
    left: 300px;
    opacity: 0.5;">COMING SOON</div>
                <div class="container-fluid footer-fixed">

                    <div class="row">
                        <div class="content-header col-sm-12">
                            <ol class="breadcrumb">
                                <li><a href="index.html"><i class="fa fa-dashboard"></i> Buy</a></li>
                                <li class="active">Bids Posted</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">


                            <h2 class="page-title">Bids Posted</h2>

                            <div class="row">
                                <div class="col-md-12" id="no-more-tables">
                                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead class="hidden-xs">
                                            <tr>
                                                <th>Car Name</th>
                                                <th>Image</th>
                                                <th>Last Bid Mmount</th>
                                                <th>Status</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="hidden-xs">
                                            <tr>
                                                <th>Car Name</th>
                                                <th>Image</th>
                                                <th>Last Bid Amount</th>
                                                <th>Status</th>
                                                <th>View</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(!empty($compact_array['biddingdata']))
                                            @foreach($compact_array['biddingdata'] as $document)  
                                                <tr>
                                                    <td data-title="Car Name">{{$document["make"]}} {{$document["model"]}} {{$document["variant"]}}</td>
                                                    <td data-title="Image"><img class="img-responsive" width="50px;" src='{{$document["imagelink"]}}' alt=""/></td>
                                                    <td data-title="Last Bid Amount">{{$document["bidded_amount"]}}</td>
                                                    <td data-title="Status"><p class="label label-success">Completed</p></td>
                                                    <td data-title="View"><a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#popup"><i class="fa fa-eye bidding_details" data-car-id='{{$document["car_id"]}}'
                                                    data-car-link='{{$document["imagelink"]}}'
                                                     data-dealer-id='{{$document["dealer_id"]}}'></i></a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td data-title="From" colspan="6">No Bids Found</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                @include('footer')
            </div>
        
        
        <div class="modal fade" id="popup" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Bid Product Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="bid-hide">
                            <div class="form-group col-xs-12">
                                <div class="col-sm-10 col-xs-8">
                                    <input type="text" placeholder="Bid Your Amount Here" id="dealer_funding" class="form-control">
                                    <input type="hidden" name="dealer_id" id="dealer_id">
                                    <input type="hidden" name="car_id" id="car_id">
                                </div>
                                <div class="col-xs-2"><button type="button"  class="btn btn-primary bidding button_bidding">Submit</button>

                                </div>
                            </div>
                            <div class="hr-dashed"></div></div>

                        <div class="row">
                            <div class="col-xs-4"><p class="text-center"><img class="img-responsive popup-img" src="img/car1.jpg" alt=""/></p></div>
                            <div class="col-xs-8 bid-title">
                                

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-primary bidding">Bid Now</button>

                    </div>
                </div>
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
        <script src="js/menu.js"></script>
        <script src="{{URL::asset('js/dealerplus.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
        <script>
            $(".bidding").click(function () {
                $("#bid-hide").slideDown(1000);
            });
            $(".bidding_details").click(function () {
                
                    var car_id = $(this).attr('data-car-id');
                    var dealer_id = $(this).attr('data-dealer-id');
                    var car_id_link = $(this).attr('data-car-link');
                    $('#car_id').val(car_id)
                    $('#dealer_id').val(dealer_id)
                    $('.popup-img').attr('src',car_id_link);
                    //alert(car_id);               
                    $.ajax({
                        url:'biddingGridView',
                        type:'post',
                        data:{car_id:car_id},
                        success:function(response)
                        {
                            $(".bid-title").empty().append(response);
                            console.log(response);
                        },
                        error:function(e)
                        {
                            console.log(e.responseText);
                        }
                    });
                $('.button_bidding').click(function(){
                    var dealer_id = $('#dealer_id').val();
                    var car_id = $('#car_id').val();
                    var make_model_variant = '';
                    var bidded_amount = $('#dealer_funding').val();
                    if(bidded_amount<=0)
                    {
                        alert('Please Enter The Bidding Amount');
                        $('#dealer_funding').focus();
                        return false;
                    }                   
                    $.ajax({
                            url:'bidding_car',
                            type:'post',
                            data:{car_id:car_id,dealer_id:dealer_id,make_model_variant:make_model_variant,bidded_amount:bidded_amount},
                            success:function(response)
                            {
                                //alert(response);
                                $('#dealer_funding').val('');
                            },
                            error:function(e)
                            {
                                console.log(e.responseText);
                            }
                        });
                });
            });
        </script>
    </body>

</html>