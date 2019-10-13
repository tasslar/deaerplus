@include('header')

        <div class="ts-main-content">
           @include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="content-header col-sm-12">                    
                    <ol class="breadcrumb">
                        <li><a href="{{url('/myeditaccount')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                        <li class="active">Compare</li>
                    </ol>
                </div>
                <div class="col-md-8 col-xs-12">
                    <h2 class="page-title" id="counts">Dealer Search
                    @if(!empty($compact_array['dealer_search_count']))
                    ({{$compact_array['dealer_search_count']}})
                    @endif
                    </h2>
                <!-- <div class="city_response" id="city_response">
                </div> -->
                <div id="city_response">
                <div style="display: block;">
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
                            <div class="col-sm-8 col-xs-12 dealerseachlist">
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
                            <div class="col-sm-4 col-xs-12 text-center">
                                <ul class="social-network social-circle">
                                    @if($fetch->facebook_link)
                                    <li><a href="{{'http://'.$fetch->facebook_link}}" class="icoFacebook" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                    @endif
                                    @if($fetch->twitter_link)
                                    <li><a href="{{'http://'.$fetch->twitter_link}}" class="icoTwitter" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    @endif
                                    @if($fetch->linkedin_link)
                                    <li><a href="{{'http://'.$fetch->linkedin_link}}" class="icoLinkedin" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
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
                        <div class="col-xs-12 dealerseachlist pull-right mt">
                                <!-- <a class="cometchat" data-comet-id="cometchat_userlist_{{$fetch->d_id}}"><i class="fa fa-wechat" aria-hidden="true"></i> Chat Now</a> -->

                                <button type="button" class="btn btn-primary btn-sm cometchat" data-comet-id="cometchat_userlist_{{$fetch->d_id}}"><span class="status-icon icon-online" style="background: rgb(255, 255, 255);"></span>
                                               <aside class="pull-left"> <i class="fa fa-wechat"></i>  Chat</aside>         
                                            </button>
                                            
                                <a class="dealer_profile" data-id='{{$fetch->d_id}}'><i class="fa fa-eye"  aria-hidden="true"></i> View Profile</a>
                            </div>
                    </div>
                @endforeach
                {{$compact_array['dealer_search']->links()}}  
                @endif
                </div>
                </div>              
                </div>
                <div class="col-md-4 col-xs-12">
                <input type="hidden" name="search_value" id="search_value" class="search_value" value="{{$compact_array['search_value']}}">
                    <div class="col-xs-12 accordsec">
                        <button class="accordion active">City</button>
                        <div class="panel panel1 show">
                        @foreach($compact_array['dealer_city'] as $fetch_city)
                            <div class="checkbox checkbox checkbox-info" >
                                <input type="radio" id="fCheckbox{{$fetch_city->d_city}}" city_count ="{{$fetch_city->count}}" class="city_value city_id" name="city_id" value="{{$fetch_city->d_city}}">
                                <label for="fCheckbox{{$fetch_city->d_city}}">{{$fetch_city->city_name}}</label>
                                <span class="pull-right count-filter">{{$fetch_city->count}}</span>
                            </div>
                        @endforeach
                        </div>
                    </div>

<!--                    <div class="col-xs-12 accordsec">
                        <button class="accordion active">No of Lists</button>
                        <div class="panel panel1 show">
                            <div class="checkbox checkbox1 checkbox-info">
                                <input type="radio" id="bCheckbox1" name="body-type">
                                <label for="bCheckbox1">
                                    0 - 10
                                </label>
                                <span class="pull-right count-filter">200</span>
                            </div>
                            <div class="checkbox checkbox1 checkbox-info">
                                <input type="radio" id="bCheckbox2" name="body-type">
                                <label for="bCheckbox2">
                                    10 - 30
                                </label>
                                <span class="pull-right count-filter">500</span>
                            </div>
                            <div class="checkbox checkbox1 checkbox-info">
                                <input type="radio" id="bCheckbox3" name="body-type">
                                <label for="bCheckbox3">
                                    30 - 50
                                </label>
                                <span class="pull-right count-filter">1000</span>
                            </div>
                            <div class="checkbox checkbox1 checkbox-info">
                                <input type="radio" id="bCheckbox4" name="body-type">
                                <label for="bCheckbox4">
                                    50 Above
                                </label>
                                <span class="pull-right count-filter">600</span>
                            </div>

                        </div>
                    </div>-->
                    <div class="col-xs-12 accordsec">
                        <button class="accordion active">DealerPlus</button>
                        <div class="panel panel1 show">
                            <div class="checkbox checkbox1 checkbox-info dealer_status" dealer_status="{{$compact_array['verified_dealer']['active']}}">
                                <input type="radio" id="FTCheckbox1" class="dealer_ver" value="1" name="dealer_status">
                                <label for="FTCheckbox1">
                                    DealerPlus Verified
                                </label>
                                <span class="pull-right count-filter">{{$compact_array['verified_dealer']['active']}}</span>
                            </div>
                            <div class="checkbox checkbox1 checkbox-info dealer_status" dealer_status="{{$compact_array['verified_dealer']['inactive']}}">
                                <input type="radio" id="FTCheckbox2" class="dealer_ver" name="dealer_status" value="0">
                                <label for="FTCheckbox2">
                                    DealerPlus Not Verified
                                </label>
                                <span class="pull-right count-filter">{{$compact_array['verified_dealer']['inactive']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="picture" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Picture Name</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                        <img src="img/login-bg.jpg" alt="...">
                                        <div class="carousel-caption">
                                            Picture 1
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img src="img/login-bg1.jpg" alt="...">
                                        <div class="carousel-caption">
                                            Picture 2
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img src="img/inventory-management1.png" alt="...">
                                        <div class="carousel-caption">
                                            Picture 3
                                        </div>
                                    </div>
                                    ...
                                </div>

                                <!-- Controls -->
                                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
             @include('footer')
        </div>
        <form method="post" action="{{url('dealer_profile')}}" class="profile_form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="dealer_id" class="profile" value="">
            <input type="hidden" name="city_count" class="citys" value="">
        </form>
        <!-- Loading Scripts -->
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
        <script src="{{URL::asset('js/dealerplus.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script> 
        <script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script>        
        <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
        <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
        <script src="{{URL::asset('js/common.js')}}"></script>

        <script type="text/javascript">
            $('.BSbtninfo').filestyle({

                buttonName: 'btn-info',

                buttonText: ' Upload Documents'
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


        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].onclick = function () {
                    this.classList.toggle("active");
                    this.nextElementSibling.classList.toggle("show");
                }
            }
        </script>
        <script type="text/javascript">   
        $(document).ready(function(){
                $('.city_id').click(function(){
                    var city_count    = $(this).attr('city_count');
                    $('#counts').html('Dealer Search('+city_count+')');
                });

                $('.city_id').click(function(){
                   dealersearch() 
                });
                function dealersearch(pageno=1)
                {
                    $("#loadspinner").css("display", "block");
                    var city_id       =  $('input[name=city_id]:checked').val();
                    var dealer_status =  $('input[name=dealer_status]:checked').val();
                    console.log(dealer_status);
                    var status    = "";
                    if(dealer_status != "undefined")
                        {
                            var  status   = $('input[name=dealer_status]:checked').val();                            
                        }
                        else
                        {
                            var status    = "";
                        }                        
                    /*if('input[name=dealer_status]:checked')
                    {
                         
                        var city_count    = 0;
                        var search_value  = $('#search_value').val();  
                        var pageno        = pageno; 
                        $.ajax({
                         url: "{{url('status_search')}}",
                         data:{status:status,page:pageno},
                         type:'POST',
                         success: function(response){
                            console.log(response);
                            $("#loadspinner").css("display", "none");                            
                            $('#city_response').html(response);
                         },
                         error:function(){
                            $("#loadspinner").css("display", "none");
                         }
                    }); 
                    }   */
                    /*else
                    {*/
                        var city_count    = 0;
                        var search_value  = $('#search_value').val();                          
                        var pageno        = pageno;                    
                         $.ajax({
                            url: "city_search",
                            data:{city_id:city_id,search_value:search_value,city_count:city_count,page:pageno,status:status},
                            type: 'post',
                            success: function (response) {                                
                                $("#loadspinner").css("display", "none");
                                //$('#hide').css("display", "none");
                                $('#city_response').html(response);                             
                                


                            },
                            error: function () {
                                $("#loadspinner").css("display", "none");

                            }
                        });
                   /*}*/
                    
                }
               $(document).on('click',".dealer_profile",function(){
                    var dealer_id = $(this).attr("data-id");
                    var profile   = $('.profile').val(dealer_id);                    
                    $('.profile_form').submit();
                }); 
                $(document).on('click',".pagination li a",function(event){
                    var paginate_link = $(this).attr('href');
                    var paginate_link_split = paginate_link.split("page=");
                    var pageno = paginate_link_split[1];                    
                    dealersearch(pageno); 
                    event.preventDefault();
                });    
                $(document).on('click',".dealer_status",function(){
                    //var dealer_status = $('input[name=dealer_status]:checked').val();
                    var count  = $(this).attr("dealer_status");
                    $('#counts').html('Dealer Search('+count+')');
                    dealersearch() 
                });
                /*$(document).on('click',".dealer_status",function(){
                    $("#loadspinner").css("display", "block");
                    var dealer_status = $('input[name=dealer_status]:checked').val();
                    if(dealer_status == 1)
                    {
                        var  status   = "1";
                    }
                    else
                    {
                        var status    = "0";
                    }
                    $.ajax({
                         url: "{{url('status_search')}}",
                         data:{status:status},
                         type:'POST',
                         success: function(response){
                            console.log(response);
                            $("#loadspinner").css("display", "none");
                            $('#counts').html('Dealer Search');
                            $('#city_response').html(response);
                         },
                         error:function(){
                            $("#loadspinner").css("display", "none");
                         }
                    });
                });    */  
        });         
        </script>
    </body> 

</html>