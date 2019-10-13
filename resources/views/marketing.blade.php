        @include('header')
        @include('sidebar')
        <div class="ts-main-content">
            
            <div class="content-wrapper myprofile">
                <div class="content-header col-sm-12">                    
                    <ol class="breadcrumb">
                        <li><a href="{{url('managelisting')}}"><i class="fa fa-dashboard"></i> Sell</a></li>
                        <li class="active">Market</li>
                    </ol>
                </div>
                <form action="marketingsmsandmail" method="post">
                    <div class="col-sm-12 col-xs-12">                    
                        <h3 class="page-title">Market</h3>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3"><div class="addimage">
                                    <div class="form-group">
                                        <div>
                                            <img src="{{$compact_array['basic_info']['imagelinks']}}" class="image">
                                            <input type="hidden" name="inventory_id" id="inventory_id" value="{{$compact_array['basic_info']['inventory_id']}}">
                                            <input type="hidden" name="listing_id" id="listing_id" value="{{$compact_array['basic_info']['car_id']}}">
                                            <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                                        </div>
                                    </div> 
                                </div></div>
                            <div class="col-xs-12 col-sm-9">
                                <h4>{{$compact_array['basic_info']['model']}} {{$compact_array['basic_info']['variant']}} {{$compact_array['basic_info']['registration_year']}}</h4>
                                <h3>Rs.{{$compact_array['basic_info']['price']}}</h3>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-2 buylist-box" id="fuel"><h4>Fuel</h4>
                                        <p>{{$compact_array['basic_info']['fuel_type']}}</p>
                                    </div>
                                    <div class="col-xs-3 col-sm-2 buylist-box" id="fuel"><h4>Kms</h4>
                                        <p>{{$compact_array['basic_info']['kilometer_run']}}</p>
                                    </div>
                                    <div class="col-xs-3 col-sm-2 buylist-box" id="fuel"><h4>Mileage</h4>
                                        <p>{{$compact_array['basic_info']['mileage']}}</p>
                                    </div>
                                    <div class="col-xs-3 col-sm-2 buylist-box" id="fuel"><h4>Seats</h4>
                                        <p>{{$compact_array['listing_features']['seating_capacity']}}</p>
                                    </div>
                                </div>
                            </div>

                        </div><!-- end outer row -->
                        <hr>
                        <h3 class="page-title">SMS / Email</h3>
                            <div class="col-sm-8 col-xs-12 box-des1"  id="features">
                                <div class="col-xs-12">
                                    <h4 class="page-title col-xs-12 col-sm-12">Contact Details</h4>
                                    <!-- <div class="col-xs-6 col-sm-3 box-des">
                                        <label class="checkbox">
                                            <input name="air_conditioner" class="air_conditioner" id="air_conditioner" value="1" type="checkbox">
                                            <i></i>SMS</label>
                                    </div>
                                    <div class="col-xs-6  col-sm-3 box-des">
                                        <label class="checkbox">
                                            <input name="air_conditioner" class="air_conditioner" id="air_conditioner" value="1" type="checkbox">
                                            <i></i>Email</label>
                                    </div> -->
                                </div>
                                <ul class="col-xs-12 col-sm-6">
                                    <li>
                                        <label class="checkbox">
                                            <input name="smscheck" class="sms" id="sms" value="1" type="checkbox" checked>
                                            <i></i>SMS</label>                                
                                    </li>
                                    @foreach($compact_array['smsdata'] as $fetch)
                                        <li>
                                            <div class="checkbox checkbox-primary">
                                                <input id="email{{$fetch['contact_type_id']}}" type="checkbox" name="sms[{{$fetch['contact_type_id']}}]" value="{{$fetch['contact_type_id']}}" checked>
                                                <label for="email{{$fetch['contact_type_id']}}">
                                                   {{$fetch['contact_type']}}({{$fetch['count']}})
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="col-xs-12 col-sm-6">
                                    <li>
                                        <label class="checkbox">
                                            <input name="emailcheck" class="email" id="email" value="1" type="checkbox" checked>
                                            <i></i>Email</label>
                                            
                                    </li>
                                    @foreach($compact_array['emaildata'] as $fetch)
                                        <li>
                                            <div class="checkbox checkbox-primary">
                                                <input id="email{{$fetch['contact_type_id']}}" type="checkbox" name="email[{{$fetch['contact_type_id']}}]" value="{{$fetch['contact_type_id']}}" checked>
                                                <label for="email{{$fetch['contact_type_id']}}">
                                                   {{$fetch['contact_type']}}({{$fetch['count']}})
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="submit" name="submit" value="submit" class="btn-sm btn btn-primary pull-right">
                            </div>
<!--                    <div class="col-xs-12 col-sm-4 accordsec">
                        <button class="accordion active">Facebook Marketing</button>
                        <div class="panel panel1 show">
                           
                            <p class="text-center">Coming Soon</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 accordsec">
                        <button class="accordion active">Google Marketing</button>
                        <div class="panel panel1 show">
                             <p class="text-center">Coming Soon</p>

                        </div>
                    </div>-->
                </form>
                    </div><!-- end outer row -->
                @include('footer')
            </div>
        </div>
    </div>
</div>


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dealerplus.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/label-slide.js" type="text/javascript"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
$(function () {

    $('.status_alert').on('click', function() {
           
             var stat_id  = $(this).attr('id');
             var stat_val = $(this).val();
             var stat_type = $(this).attr('data-type');

            $.ajax({
                url: 'manage_alertstatus',
                type: 'post',
                dataType: 'json',
                data: {stat_id: stat_id, stat_val: stat_val,stat_type: stat_type},
                success: function (response)
                {
                    console.log(response.message)
                },
                error: function (e)
                {
                    console.log(response.message);
                }
        
            });
        
    });

    $(".alert-del").on('click',function(e){

        //alert($(this).attr('data-id'))
        var id=$(this).attr('data-id');
        var thisid = this;
        var confirm_msg = confirm("Do You Want to Remove Alert?");
        if (confirm_msg)
        {
            $.ajax({
                    url: 'manage_alertdelete',
                    type: 'post',
                    dataType: 'json',
                    data: {id: id},
                    success: function (response)
                    {
                        if(response.message=="success")
                         {
                           $(thisid).parent().parent().hide();
                           $('#b_alert').html(response.aler_count);
                         }   
                    },
                    error: function (e)
                    {
                        console.log("error");
                    }
            
                });
       }

    });

});
</script>
       
</body>

</html>