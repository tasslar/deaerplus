@if($compact_array['dealer_search_count'] == 0)
                 <li class="panel panel-primary alert no-cars">
                    No Dealer Found
                </li>
                 @else
                @foreach($compact_array['dealer_search'] as $fetch)
                    <div class="box col-xs-12">
                        <div class="col-lg-4 col-md-12 col-sm-3 col-xs-12">
                            <div class="box-icon col-xs-12">
                            @if(empty($fetch->logo))
                            <img src="{{URL::asset('img/no-image7.jpg')}}"/>
                            @else
                            <img src="{{$fetch->logo}}"/>
                            @endif
                            </div>


                        </div>
                        <div class="info col-lg-8 col-md-12 col-sm-9 col-xs-12 ">
                            <h3>{{$fetch->dealer_name}}</h3>
                            <div class="col-sm-6 col-xs-12 dealerseachlist">
                                <ul>
                                    @if($fetch->dealership_name)
                                    <li><span class="fa fa-user"></span>{{$fetch->dealership_name}}</li>
                                    @endif
                                    @if($fetch->landline_no)
                                    <li><span class="glyphicon glyphicon-phone-alt"></span>{{$fetch->landline_no}}</li>
                                    @endif
                                    @if($fetch->fax_no)
                                    <li><span class="glyphicon glyphicon-print"></span>{{$fetch->fax_no}}</li>
                                    @endif
                                    @if($fetch->d_mobile)
                                    <li><span class="glyphicon glyphicon-phone"></span> {{$fetch->d_mobile}}</li>
                                    @endif
                                    <li><span class="glyphicon glyphicon-envelope"></span>{{$fetch->d_email}}</li>
                                    @if($fetch->d_city)
                                    <li><span class="fa fa-map-marker"></span>
                                    @foreach($compact_array['dealer_citys'] as $fetch_city)
                                    @if($fetch_city->city_id == $fetch->d_city)
                                    {{$fetch_city->city_name}}
                                    @endif
                                    @endforeach
                                    </li>
                                    @endif
                                </ul>
                                <!--<a href=""><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact Now</a>-->
                            </div>
                            <div class="col-sm-6 col-xs-12 text-center">
                                <ul class="social-network social-circle">
                                    @if($fetch->facebook_link)
                                    <li><a href="{{$fetch->facebook_link}}" class="icoFacebook" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                    @endif
                                    @if($fetch->twitter_link)
                                    <li><a href="{{$fetch->twitter_link}}" class="icoTwitter" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    @endif
                                    @if($fetch->linkedin_link)
                                    <li><a href="{{$fetch->linkedin_link}}" class="icoLinkedin" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    @endif
                                </ul>
                                <div class="dealerseachlist-cont col-xs-12">
                                @if($fetch->carlisting_count)
                                {{$fetch->carlisting_count}} cars
                                @else
                                {{'No'}} car
                                @endif
                                </div>
                            </div>

                        </div>  
                        <div class="col-xs-12 dealerseachlist pull-right">
                               <!--  <a class="cometchat" data-comet-id="cometchat_userlist_{{$fetch->d_id}}"><i class="fa fa-wechat" aria-hidden="true"></i> Chat Now</a> -->
                               <button type="button" class="btn btn-primary btn-sm cometchat" data-comet-id="cometchat_userlist_{{$fetch->d_id}}"><span class="status-icon icon-online" style="background: rgb(255, 255, 255);"></span>
                                               <aside class="pull-left"> <i class="fa fa-wechat"></i>  Chat</aside>         
                                            </button>
                                <a class="dealer_profile" data-id='{{$fetch->d_id}}'><i class="fa fa-eye"  aria-hidden="true"></i> View Profile</a>
                            </div>
                    </div>
                @endforeach
                {{$compact_array['dealer_search']->links()}}  
                @endif