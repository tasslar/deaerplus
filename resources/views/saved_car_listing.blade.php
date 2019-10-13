
        @include('header')
        @include('sidebar')        
        <div class="content-wrapper">
            <div class="container-fluid footer-fixed">

                <div class="row">
                    <div class="content-header col-sm-12">
                        <ol class="breadcrumb">
                            <li><a href="{{url('/buy')}}"><i class="fa fa-dashboard"></i> Buy</a></li>
                            <li class="active">Saved cars</li>
                        </ol>
                    </div>
                    <div class="col-xs-12">


                        <!--<h2 class="page-title">Buy Listings</h2>-->


                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <!--<div class="grid-buttons">
                            <div class="btn-group">
                   <a href="search.html" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
                     </span>List</a> 
                               <a href="search2.html" id="grid" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th"></span>Grid</a>
                </div>
                        </div>-->

                            <ul id="listing">
                                @if(!empty($compact_array['listing_details']))
                                    @foreach($compact_array['listing_details'] as $document)

                                    <li class="panel panel-primary alert saved_car{{$document['car_id']}} ">

                                        <div class="panel-body all-list">
                                            @if($document["view_car"]>=1)
                                            <span class="label-list">Viewed</span>
                                            @endif
                                            <div class="col-xs-12 col-lg-4 search-image"><img src="{{$document['imagelinks']}}" class="img-responsive style_prevu_kit" alt=""/>
                                                <p class="text-primary count-photo">{{$document['noimages']}} photos</p>
                                            </div>
                                            <div class="col-xs-12 col-lg-8 list-text">
                                                <h4 class="text-primary buy-list">{{$document["model"]}} {{$document["variant"]}}
                                                    {{$document["registration_year"]}}
                                                    <?php
                                                    if ($document["saved_car"] == 1) {
                                                        $saved_active_cars = 'detail-wishlist-active';
                                                    } else {
                                                        $saved_active_cars = '';
                                                    }

                                                    if ($document["notify_car"] == 1) {
                                                        $notify_active_cars = 'detail-wishlist-active';
                                                    } else {
                                                        $notify_active_cars = '';
                                                    }
                                                    
                                                    ?>
                                                </h4>

                                                <p class="text-primary"><i class="fa fa-map-marker"></i>&nbsp{{$document["car_locality"]}} <span class="list-date">- {{$document["daysstmt"]}}</span></p>
                                                <p class="list-detail"><span class="text-muted">{{$document["kilometer_run"]}} km</span> | <span class="text-muted">{{$document["fuel_type"]}}</span> | <span class="text-muted">{{$document["registration_year"]}}</span> | <span class="text-muted">{{$document["owner_type"]}}</span></p>
                                                <p class="sale"><span class="rate"><i class="fa fa-rupee"></i></span> {{$document["price"]}} {{$document["listing_error_msg"]}}</p>
                                                <div class="row searchbtns">
                                                    <div class="pull-right col-xs-12 col-md-8 ">
                                                        <ul class="view-buttons row">
                                                            <!--<li class="good-deal"><i data-toggle="tooltip" title="" data-original-title="Good deal" data-placement="top" class="fa fa-thumbs-o-up"></i></li>-->
                                                            <li><img src="{{$document['site_image']}}" alt=""/></li>
                                                            <li><a class="btn all-list-btn btn-sm btn-primary view_similar" data-make='{{$document["make_id"]}}' data-model='{{$document["model"]}}' data-variant='{{$document["variant"]}}'>View Similar</a></li>
                                                            <li><a class="btn btn-primary all-list-btn btn-sm viewlisting" data-id='{{$document["car_id"]}}'>View More</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                         <ul class="detail-wishlist row">
                                                            <li id="email-alert-send"><span><i class="fa fa-bell alertlisting {{$notify_active_cars}}"  data-toggle="tooltip" title="" data-original-title="Alert" data-placement="top" data-car-id='{{$document["car_id"]}}' data-make='{{$document["make"]}}' data-model-name='{{$document["model"]}}' data-regyear='{{$document["registration_year"]}}' data-variant='{{$document["variant"]}}' data-fuel='{{$document["fuel_type"]}}'
                                                            data-city='{{$document["car_locality"]}}'
                                                            ></i></span></li>
                                                            <li><a><i data-toggle="tooltip" title="" data-original-title="Saved cars" data-placement="top" class="fa fa-heart saved_car {{$saved_active_cars}}" data-car-id='{{$document["car_id"]}}'></i></a></li>

                                                            @if($document["auction"]==1)
                                                            <li><a><i class="fa fa-legal biding_car" data-target='#bidding_popup' data-toggle='modal' title="" data-original-title="Add Bids" data-car-id='{{$document["car_id"]}}' data-dealer-id='{{$document["dealer_id"]}}' data-placement="top"></i></a></li>
                                                            @endif
                                                            <li class="notification3"><a><i class="fa fa-balance-scale comparelisting" data-toggle="tooltip" title="" data-original-title="Compare" data-placement="top" data-car-id='{{$document["car_id"]}}'></i><span style="display: none;"><i class='fa fa-check' ></i></span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 email {{$document['car_id']}}">
                                                <h4 class="col-xs-12 col-sm-12 email-alert">Get Email Alerts similar to this listing</h4>
                                            </div>
                                        </div>

                                    </li>
                                    @endforeach
                                    @else
                                    <li class="panel panel-primary alert">
                                        No Cars Found
                                    </li>
                                    @endif
                        </div>


                    </div>
                </div>
                <nav aria-label="...">
                    <ul class="pagination pagination-md">
                        {{$paginatelink}}
                    </ul>
                </nav>
            </div>
            @include('footer')

        </div>
    </div>
    <div class="modal fade" id="bidding_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Bidding</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form method="post">
                            <div class="form-group col-xs-12">
                                <div class="col-sm-12 col-xs-12 buy-message">
                                    <input type="number" class="form-control" name="dealer_funding" id="dealer_funding">
                                    <input type="hidden" class="form-control" name="dealer_id" id="dealer_id">
                                    <input type="hidden" class="form-control" name="car_id" id="car_id">
                                </div>
                                <div class="col-xs-4 pull-right">
                                    <input type="button" class="btn btn-primary sent-message btn-sm button_bidding" value="Add Bidding">
                                </div>
                            </div>    
                        </form>
                        <div class="hr-dashed"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="view_car_managelist" action="{{url('detail_car_listing')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="car_view_id" name="car_view_id">
    </form>

    <form method="post" id="similar_car_managelist" action="{{url('searchcarlisting')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="page_name" name="page_name" value="similar_searchpage">
        <input type="hidden" name="city_name" id="city_name_similar" value="">
        <input type="hidden" id="model" name="model">
        <input type="hidden" id="make_id" name="make_id">
    </form>


    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
$("#email-alert-send").click(function () {
    //$(".email").slideToggle(1000);
});
$(document).ready(function () {
    $('.viewlisting').click(function () {
        $('#car_view_id').val($(this).attr('data-id'));
        $('#view_car_managelist').submit();
    });

    $('.view_similar').click(function () {
        $('#model').val($(this).attr('data-model'));
        $('#make_id').val($(this).attr('data-make'));
        $('#similar_car_managelist').submit();
    });
    $('.saved_car').click(function () {
        var carid = $(this).attr('data-car-id');
        var csrf_token = $('#token').val();
        var thisid = this;
        $.ajax({
            url: 'save_car',
            type: 'post',
            data: {_token: csrf_token, carid: carid},
            success: function (response)
            {
                if (response == '1')
                {
                    $(thisid).addClass('detail-wishlist-active');

                } else
                {
                    $(thisid).removeClass('detail-wishlist-active');
                    $(".saved_car" + carid).remove()
                }
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    });

    $('.biding_car').click(function () {
        var dealer_id = $(this).attr('data-dealer-id');
        var car_id = $(this).attr('data-car-id');
        //var make_model_variant = $(this).attr('data-make-model-variant');
        $('#dealer_id').val(dealer_id);
        $('#car_id').val(car_id);
        //$('#make_model_variant').val(make_model_variant);
    });
    $('.button_bidding').click(function () {
        var dealer_id = $('#dealer_id').val();
        var car_id = $('#car_id').val();
        var make_model_variant = '';
        var bidded_amount = $('#dealer_funding').val();
        $.ajax({
            url: 'bidding_car',
            type: 'post',
            data: {car_id: car_id, dealer_id: dealer_id, make_model_variant: make_model_variant, bidded_amount: bidded_amount},
            success: function (response)
            {
                //alert(response);
                $('#dealer_funding').val('');
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    });
    $('.alertlisting').click(function () {
        var listingid = $(this).attr('data-car-id');
        var make = $(this).attr('data-make');
        var model_name = $(this).attr('data-model-name');
        var variant = $(this).attr('data-variant');
        var regyear = $(this).attr('data-regyear');
        var fuel = $(this).attr('data-fuel');
        var city_name = $(this).attr('data-city');
        var csrf_token = $('#token').val();
        var thisid = this;
        $.ajax({
            url: 'alertsearch',
            type: 'post',
            data: {_token: csrf_token, listingid: listingid,make:make,model_name:model_name,variant:variant,regyear:regyear,fuel:fuel,city_name:city_name},
            success: function (response)
            {
                if (response == 1)
                {
                    $("."+listingid).slideDown(1000);
                    $(thisid).addClass('detail-wishlist-active');
                } else
                {
                    $("."+listingid).slideUp(1000);
                    $(thisid).removeClass('detail-wishlist-active');
                }
                //alert(response);
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
        
    });

    
});
    </script>
    <script>
        $(".list-offer").click(function () {
            $(this).parent().parent().parent().parent().children(".all-list-bid").slideDown(1000);
        });
        $(".close1").click(function () {
            $(this).parent().hide();
        });
        $("#close-bid").click(function () {
            $(this).parent().parent().parent().parent().parent().hide();
            $(this).parent().parent().parent().parent().parent().parent().children(".all-list").children(".list-detail").children(".sale").children(".list-offer").html("Bid Posted");
            $(this).parent().parent().parent().parent().parent().removeClass("all-list-bid");
        });
    </script>
</body>

</html>