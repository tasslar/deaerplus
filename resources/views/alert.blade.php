@include('header')
@include('sidebar')
<div class="ts-main-content">

    <div class="content-wrapper myprofile">
        <div class="container-fluid footer-fixed">

            <div class="row">
                <div class="content-header col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="{{url('buy')}}"><i class="fa fa-dashboard"></i> Buy</a></li>
                        <li class="active">Manage Alert</li>
                    </ol>
                </div>
                <div class="col-xs-12" id="features">
                    <h2 class="page-title col-md-8 col-sm-8 col-xs-12">Alerts</h2>
                    <a href="{{url('/exportalert')}}" class="btn btn-primary col-xs-12 col-sm-3 col-md-3 add-list pull-right"><i class="glyphicon glyphicon-export"></i>&nbsp; Export Excel</a></div>
                <!-- <div class="col-sm-2 col-xs-12 pull-right">
                    <label class="checkbox">
                                            <input name="features[2]" value="1" type="checkbox">Email 
                                            <i></i> </label>
                </div> -->
                <!-- <div class="col-sm-2 col-xs-12 pull-right">
                    <label class="checkbox">
                                            <input name="features[2]" value="1" type="checkbox">SMS
                                            <i></i> </label>
                </div> -->
                <div class="hr-dashed"></div>
                <div class="col-xs-12">
                    <form>
                        <div class="row">
                            <div class="col-md-12" id="no-more-tables">

                                <input type="hidden" name=_token value="{{csrf_token()}}">

                                <table id="zctb" class="display table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">

                                    <thead class="hidden-xs">

                                        <tr class="hidden-xs">
                                            <th>Id</th>
                                            <th>Alert Type</th>
                                            <th>Dealer Name</th>
                                            <th>Alert Date</th>
                                            <th>Product</th>
                                            <th>Location</th>
                                            <th>Alert On / Off</th>
                                            <th>Email On / Off</th>
                                            <th>Sms On / Off</th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                        @if(count($alertData))
                                        @foreach($alertData as $key)
                                        <tr>
                                            <td data-title="Id">{{$key->alertid}}</td>
                                            <td data-title="Alert Type"><h4>{{$key->alert_type}}</h4></td>
                                            <td data-title="Dealer Name"><h4>{{$key->dealername}}</h4></td><td data-title="Alert Date">{{$key->alert_date}}</td>                                             
                                            <td data-title="Product">
                                                <h4>{{$key->alert_model}}{{$key->alert_variant}}{{$key->alert_fueltype}}</h4>

                                            </td>
                                            <td data-title="Location"><h4>{{$key->alert_city}}</h4></td>

                                            <td data-title="Alert On / Off" class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                                <label class="checkbox">
                                                    @if($key->alert_status)    
                                                    <input class="status_alert" data-id="{{$key->   alert_listingid}}" id="{{$key->alertid}}" name="status_alert-{{$key->alertid}}" data-type="status_one" value="1" type="checkbox" checked="checked">
                                                    @else
                                                    <input class="status_alert" data-id="{{$key->   alert_listingid}}" id="{{$key->alertid}}" name="status_alert-{{$key->alertid}}" data-type="status_one" value="0" type="checkbox">
                                                    @endif
                                                    <i></i> </label>&nbsp;
                                            </td>

                                            <td data-title="Alert On / Off" class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                                <label class="checkbox">
                                                    @if($key->alert_email_status)    
                                                    <input class="status_alert" data-id="{{$key->   alert_listingid}}" id="{{$key->alertid}}" name="status_alert-{{$key->alertid}}" data-type="status_two" value="1" type="checkbox" checked="checked">
                                                    @else
                                                    <input class="status_alert" data-id="{{$key->   alert_listingid}}" id="{{$key->alertid}}" name="status_alert-{{$key->alertid}}" data-type="status_two" value="0" type="checkbox">
                                                    @endif
                                                    <i></i> </label>&nbsp;
                                            </td>
                                            <td data-title="Alert On / Off" class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                                <label class="checkbox">
                                                    @if($key->alert_sms_status)    
                                                    <input class="status_alert" data-id="{{$key->   alert_listingid}}" id="{{$key->alertid}}" name="status_alert-{{$key->alertid}}" data-type="status_three" value="1" type="checkbox" checked="checked">
                                                    @else
                                                    <input class="status_alert" data-id="{{$key->   alert_listingid}}" id="{{$key->alertid}}" name="status_alert-{{$key->alertid}}" data-type="status_three" value="0" type="checkbox">
                                                    @endif
                                                    <i></i> </label>&nbsp;
                                            </td>

                                            <td data-title="Action"><a data-id="{{$key->alertid}}" class="btn btn-sm btn-danger alert-del"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td data-title="No Data" colspan="10">No Alerts Found</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

    $('.status_alert').on('click', function () {

        var stat_id = $(this).attr('id');
        var stat_val = $(this).val();
        var stat_type = $(this).attr('data-type');

        $.ajax({
            url: 'manage_alertstatus',
            type: 'post',
            dataType: 'json',
            data: {stat_id: stat_id, stat_val: stat_val, stat_type: stat_type},
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

    $(".alert-del").on('click', function (e) {

        //alert($(this).attr('data-id'))
        var id = $(this).attr('data-id');
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
                    if (response.message == "success")
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