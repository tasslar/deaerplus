<ul>
    @if(!empty($compact_array['listing_details']))
    @foreach($compact_array['listing_details'] as $document)

    <li class="panel panel-primary alert">

    <div class="panel-body all-list">
        @if($document["view_car"]>=1)
        <span class="label-list">Viewed</span>
        @endif
        <div class="col-xs-12 col-lg-4 search-image"><img src="{{$document['imagelinks']}}" class="img-responsive style_prevu_kit" alt=""/>
            <p class="text-primary count-photo">{{$document['noimages']}} photos</p>
        </div>
        <div class="col-xs-12 col-lg-8 list-text">
            <span class="pull-right col-xs-12 col-sm-4"><img src="{{$document['site_image']}}" alt=""/></span>
            
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
                <div class="pull-right col-xs-12 col-md-7">
                    <ul class="view-buttons row">
                        <!--<li class="good-deal"><i data-toggle="tooltip" title="" data-original-title="Good deal" data-placement="top" class="fa fa-thumbs-o-up"></i></li>-->
                        
                        <li><a class="btn all-list-btn btn-sm btn-primary view_similar" data-make='{{$document["make_id"]}}' data-model='{{$document["model"]}}' data-variant='{{$document["variant"]}}'>View Similar</a></li>
                        <li><a class="btn btn-primary all-list-btn btn-sm viewlisting" data-id='{{$document["car_id"]}}'>View More</a></li>
                    </ul>
                </div>
                <div class="col-md-5 col-xs-12">
                     <ul class="detail-wishlist row">
                        <li id="email-alert-send"><span><i class="fa fa-bell alertlisting {{$notify_active_cars}}"  data-toggle="tooltip" title="" data-original-title="Alert" data-placement="top" data-car-id='{{$document["car_id"]}}' data-make='{{$document["make"]}}' data-model-name='{{$document["model"]}}' data-regyear='{{$document["registration_year"]}}' data-variant='{{$document["variant"]}}' data-fuel='{{$document["fuel_type"]}}'
                        data-city='{{$document["car_locality"]}}'
                        ></i></span></li>
                        <li class="savedcarslink"><a><i data-toggle="tooltip" title="" data-original-title="Saved cars" data-placement="top" class="fa fa-heart saved_car {{$saved_active_cars}}" data-car-id='{{$document["car_id"]}}'></i></a></li>

                        @if($document["auction"]==1)
                        <li><a><i class="fa fa-legal biding_car" data-target='#bidding_popup' data-toggle='modal' title="" data-original-title="Add Bids" data-car-id='{{$document["car_id"]}}' data-dealer-id='{{$document["dealer_id"]}}' data-placement="top"></i></a></li>
                        @endif
                        <li class="savedcarslink notification3"><a>
                                <i class="fa fa-balance-scale comparelisting" data-toggle="tooltip" title="" data-original-title="Compare" data-placement="top" data-car-id='{{$document["car_id"]}}'></i><span style="display: none;"><i class='fa fa-check' ></i></span></a></li>
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
    </ul>
    <nav aria-label="...">
    <ul class="pagination pagination-md">

    {{ $compact_array['paginate_link'] }}
    </ul>
    </nav>