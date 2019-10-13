@include('header')
        <div class="ts-main-content">
        @include('sidebar')           
            <div class="content-wrapper myprofile">
                <div class="container-fluid">
                    <div class="row">
                        <div class="content-header col-sm-12">
                            <ol class="breadcrumb">
                                <li><a href="myprofile.html"><i class="fa fa-dashboard"></i> Manage</a></li>
                                <li class="active">My Business Profile</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">
                            <div class="profile-head row" style="background-image:url({{$compact_array['dealer_deatails']->coverphoto_logo}})">
                                <div class="col-lg-4 col-sm-4 col-xs-12 profile-headdiv">
                                    <div class="profile-headimg">
                                        <img src="{{$compact_array['dealer_deatails']->company_logo}}" class="img-responsive" alt="Dealer Name"/>
                                    </div>
                                    @if($compact_array['dealer_deatails']->status == "Active")
                                    <p><i class="fa fa-check-square-o" aria-hidden="true"></i> Verified</p>
                                    @endif
                                    <h5>{{$compact_array['dealer_deatails']->dealer_name}}</h5>
                                    <p>{{$compact_array['dealer_deatails']->dealership_name}}</p>
                                    <p class="btn btn-primary" id="flip">View Contact Details <i class="fa fa-hand-o-left" aria-hidden="true"></i></p>
                                    <ul id="panel">
                                    @if(!empty($compact_array['dealer_deatails']->landline_no))
                                     <li><span class="glyphicon glyphicon-phone-alt"></span>{{$compact_array['dealer_deatails']->landline_no}}</li>
                                    @endif                                        
                                    <li><span class="glyphicon glyphicon-phone"></span>{{$compact_array['dealer_deatails']->d_mobile}}</li>
                                    <li><span class="glyphicon glyphicon-envelope"></span><a href="#" title="mail">{{$compact_array['dealer_deatails']->d_email}}</a></li>
                                    </ul>
                                    <span class="btn btn-primary col-xs-6">
                                    @if($compact_array['car_listing_count'] == 0)
                                    No Car
                                    @elseif($compact_array['car_listing_count'] >=1)
                                    {{$compact_array['car_listing_count']}} Cars
                                    @endif
                                </span>
                                </div>
                                <div class="col-lg-8 col-sm-8 col-xs-12 profile-info pull-right">                                    
                                    <div class="social pull-right">
                                        <ul class="social-network social-circle">
                                        <li><a href="@if($compact_array['dealer_deatails']->facebook_link)
                                            {{'http://'.$compact_array['dealer_deatails']->facebook_link}}
                                            @else
                                            {{'https://www.facebook.com/dealerplusin/'}}
                                            @endif
                                        " target="_blank" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="@if($compact_array['dealer_deatails']->twitter_link)
                                        {{'http://'.$compact_array['dealer_deatails']->twitter_link}}
                                        @else
                                        {{'https://twitter.com/dealerplusin'}}
                                        @endif" target="_blank" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="@if($compact_array['dealer_deatails']->linkedin_link)
                                        {{'http://'.$compact_array['dealer_deatails']->linkedin_link}}
                                        @else
                                        {{'https://www.linkedin.com/'}}
                                        @endif" target="_blank" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="@if($compact_array['dealer_deatails']->dealership_website)
                                        {{'http://www.'.$compact_array['dealer_deatails']->dealership_website}}
                                        @else
                                        {{'http://www.dealerplus.in/'}}
                                        @endif
                                        " target="_blank" class="icoLinkedin" title="WebSite"><i class="fa fa-globe"></i></a></li>
                                    </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="sticky" class="row">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-menu" role="tablist">
                                    <li class="active">
                                        <a href="#profile" role="tab" data-toggle="tab">
                                            <i class="fa fa-male"></i> Profile
                                        </a>
                                    </li>
                                    <!-- <li><a href="#change" role="tab" data-toggle="tab">
                                            <i class="fa fa-key"></i> Edit Profile
                                        </a>
                                    </li> -->
                                </ul><!--nav-tabs close-->

                                <!-- Tab panes -->
                                <div class="tab-content col-xs-12">
                                    <div class="tab-pane fade active in row card" id="profile">
                                        <div class="col-xs-12">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h4 class="pro-title">My Business Profile</h4>
                                                </div><!--col-md-12 close-->


                                                <div class="col-sm-8 col-xs-12">
                                            @if($compact_array['car_listing'])
                                            @foreach($compact_array['car_listing'] as $fetch)
                                            <ul id="listing">
                                                <li class="panel panel-primary alert">
                                                    <div class="panel-body all-list">
                                                        <span class="label-list">Viewed</span>
                                                        @if(!empty($fetch['noimages']))
                                                        <div class="col-xs-12 col-sm-4 search-image"><img src="{{$fetch['imagelinks']}}" class="img-responsive style_prevu_kit" alt=""/>
                                                            <p class="text-primary count-photo">{{$fetch['noimages']}} 
                                                                @if($fetch['noimages'] == 1)
                                                                photo
                                                                @else
                                                                photos
                                                                @endif</p>
                                                        </div>
                                                        @else
                                                        <div class="col-xs-12 col-sm-4 search-image"><img src="{{URL::asset('img/default-car.png')}}" class="img-responsive style_prevu_kit" alt=""/>
                                                            <p class="text-primary count-photo">{{$fetch['noimages']}} 
                                                                @if($fetch['noimages'] == 1)
                                                                photo
                                                                @else
                                                                photos
                                                                @endif</p>
                                                        </div>
                                                        @endif

                                                        <div class="col-xs-12 col-sm-8 list-text"><h4 class="text-primary buy-list">
                                                                {{$fetch['model']}}
                                                                {{$fetch['variant']}}
                                                            </h4>
                                                            <p class="text-primary"><i class="fa fa-map-marker"></i>&nbsp;
                                                                {{$fetch['car_locality']}} <span class="list-date">- listed {{$fetch['daysstmt']}}
                                                                </span></p>                        
                                                            <p class="list-detail"><span class="text-muted">{{$fetch['kilometer_run']}}</span> | <span class="text-muted">{{$fetch['fuel_type']}}</span> | <span class="text-muted">{{$fetch['registration_year']}}</span> | <span class="text-muted">{{$fetch['owner_type']}}</span></p>
                                                            <p class="sale"><span class="rate"><i class="fa fa-rupee"></i></span> {{$fetch['price']}}</p>
                                                            <ul class="view-buttons pull-right">
                                                                <li><a class="btn btn-primary all-list-btn btn-sm viewlisting" data-id="{{$fetch['car_id']}}">View More</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-xs-12 email">
                                                            <h4 class="col-xs-12 col-sm-12 email-alert">Get Email alerts for new listing this search</h4>
                                                        </div>
                                                    </div>

                                                </li>

                                            </ul>
                                            @endforeach
                                            {{$compact_array['mongodb_cardetails']->links()}}
                                            @else
                                            <li class="panel panel-primary alert no-cars">
                                                No Listing
                                            </li>
                                            @endif
                                                </div><!--col-md-6 close-->

                                                <div class="col-sm-4 col-xs-12  businesscon">
                                                     <div class="col-xs-12 card">
                                                        <div class="panel-heading"><b>About Us</b></div>
                                                        <p>{{$compact_array['dealer_deatails']->about_us}}</p>
                                                    </div>
                                                    <div class="col-xs-12 card">
                                                        <div class="panel-heading"><b>Map View </b></div>
                                                       @if($compact_array['headquarter'])
                                                       <iframe src="https://maps.google.it/maps?q=
                                                        {{$compact_array['headquarter']->branch_address}}
                                                        &output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen>
                                                       @else
                                                       @foreach($compact_array['master_city'] as $fetch_city)
                                                        @if($fetch_city->city_id == $compact_array['dealer_deatails']->d_city)
                                                        <iframe src="https://maps.google.it/maps?q=
                                                        {{$fetch_city->city_name}}
                                                        &output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                </iframe>
                                                    </div>                              
                                                </div><!--col-md-6 close-->
                                            </div><!--row close-->
                                        </div><!--container close-->
                                    </div><!--tab-pane close-->
                                    <!--tab-content close-->
                                </div><!--container close-->
                            </div>
                        </div>
                    </div>
                </div>
                @include('footer')
            </div>

        </div>
        <form method="post" id="view_car_managelist" action="{{url('detail_car_listing')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="car_view_id" name="car_view_id">
        </form>
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dealerplus.js"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/label-slide.js" type="text/javascript"></script>
        <script src="js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
        <script>
                        $(".addcoverul").css({
                            'height': '0px',
                            'opacity': '0'
                        });
                        var i = 0;
                        $(".addcover").click(function () {
                            if (i == 0) {
                                $(".addcoverul").css({
                                    'height': 'auto',
                                    'opacity': '1'
                                });
                                i = 1;
                            } else if (i == 1) {
                                $(".addcoverul").css({
                                    'height': '0px',
                                    'opacity': '0'
                                });
                                i = 0;
                            }
                        });
        </script>
        <script>
        /*$(document).on('click', '.viewlisting', function () {
            $('#car_view_id').val($(this).attr('data-id'));
            $('#view_car_managelist').submit();
        });*/
            $("#panel").slideUp(0);
            $("#flip").click(function () {
                $("#panel").slideToggle("5000");
            });
            $('.BSbtninfo').filestyle({
                buttonName: 'btn-info',
                buttonText: ' Select a File'
            });

        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.viewlisting').click(function () {
                $('#car_view_id').val($(this).attr('data-id'));
                $('#view_car_managelist').submit();
                });
            });
        </script>
    </body>

</html>