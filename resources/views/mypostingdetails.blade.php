@include('header')
@include('sidebar')
<form method="post" id="view_car_managelist" action="{{url('view')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" id="car_view_id" name="car_view_id">
</form>
<div class="content-wrapper">
    <div class="container-fluid footer-fixed">

        <div class="row">
            <div class="content-header col-sm-12">

                <ol class="breadcrumb">
                    <li><a href="{{url('managelisting')}}"><i class="fa fa-dashboard"></i> Sell</a></li>
                    <li class="active">My Posting details</li>
                </ol>
            </div>
            <div class="col-xs-12">
                <h2 class="page-title">{{$detail_list_data['model']}} {{$detail_list_data['variant']}} {{$detail_list_data['registration_year']}}</h2>
                <div class="row">                        
                    <div class="col-xs-12 mb-2x">
                        <div class="col-sm-3 col-xs-12 mypostingimg viewlisting" data-id="{{$detail_list_data['car_id']}}">
                            @if(!empty($detail_list_data['image_url']))
                                <img src="{{$detail_list_data['image_url'][0]}}" class="img-responsive"/>
                            @endif
                        </div>
                        <div class="col-sm-9 col-xs-12 seven-cols">                           
                            <div class="col-md-1"><div class="buylist-box" id="fuel">
                                    <h4>Fuel</h4>
                                    <p>{{$detail_list_data['fuel_type']}}</p>
                                </div></div>
                            <div class="col-md-1"><div class="buylist-box" id="kms">
                                    <h4>Kms</h4>
                                    <p>{{$detail_list_data['kilometer_run']}}</p>
                                </div></div>
                            <div class="col-md-1"><div class="buylist-box" id="mileage">
                                    <h4>Mileage</h4>
                                    <p>{{$detail_list_data['mileage']}}</p>
                                </div></div>
                            <div class="col-md-1"><div class="buylist-box" id="seats">
                                    <h4>Seats</h4>
                                    <p>{{$detail_list_data['seatingcapacity']}}</p>
                                </div></div>
                            <div class="col-md-1"> <div class="buylist-box" id="colour">
                                    <h4>Colour</h4>
                                    <p>{{$detail_list_data['colors']}}</p>
                                </div></div>
                            <div class="col-md-1"> <div class="buylist-box" id="owner">
                                    <h4>Owner</h4>
                                    <p>{{$detail_list_data['owner_type']}}</p>
                                </div></div>
                            <div class="col-md-1"> <div class="buylist-box" id="">
                                    <h4>Place</h4>
                                    <p>{{$detail_list_data['car_locality']}}</p>
                                </div></div>

                        </div>
                    </div>
                    <div class="col-xs-12" id="no-more-tables">
                        <table id="zctb" class="display table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Listing Id</th>
                                    <th>Listing Platform</th>
                                    <th>Listing Details</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>List Price</th>
                                    <th>List Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot class="hidden-xs">
                                <tr>
                                    <th>Listing Id</th>
                                    <th>Listing Platform</th>
                                    <th>Listing Details</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>List Price</th>
                                    <th>List Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($listing_array as $sitesfetch)

                                <tr class="onerow">
                                    <td data-title="Listing Id">{{$sitesfetch['listing_id']}}</td>
                                    <td data-title="Listing Platform">

                                        <img src="img/dealerplus.png"/>
                                    </td>
                                    <td data-title="Listing Details"><h4>{{$detail_list_data['model']}}, {{$detail_list_data['variant']}}, {{$detail_list_data['registration_year']}}</h4>
                                        <p class="list-detail"><span class="text-muted">{{$detail_list_data['kilometer_run']}} km</span> | <span class="text-muted">{{$detail_list_data['fuel_type']}}</span> | <span class="text-muted">{{$detail_list_data['registration_year']}}</span> | <span class="text-muted">{{$detail_list_data['owner_type']}} Owners</span></p>
                                    </td>
                                    <td data-title="Date">{{$sitesfetch['createddate']}}</td>
                                    <td data-title="Category">{{$sitesfetch['listing_category']}}</td>
                                    <td data-title="List Price">Rs. {{$detail_list_data['price']}}</td>
                                    <td data-title="List Status" id="status{{$detail_list_data['car_id']}}">{{$sitesfetch['listing_status']}}</td>
                                    <td data-title="Action">
                                        @if($sitesfetch['listing_status']=='Active')
                                        <a data-inventory="{{$detail_list_data['car_id']}}" data-listing-id="{{$sitesfetch['listing_id']}}" class="btn btn-sm btn-danger deleteonline delete{{$detail_list_data['car_id']}}">Delete</a>

                                        <a data-inventory="{{$detail_list_data['car_id']}}" data-listing-id="{{$sitesfetch['listing_id']}}" class="btn btn-sm btn-primary repost repost{{$detail_list_data['car_id']}}" style="display: none;">Repost</a>
                                        @else
                                        <a data-inventory="{{$detail_list_data['car_id']}}" data-listing-id="{{$sitesfetch['listing_id']}}" class="btn btn-sm btn-danger deleteonline delete{{$detail_list_data['car_id']}}" style="display: none;">Delete</a>

                                        <a data-inventory="{{$detail_list_data['car_id']}}" data-listing-id="{{$sitesfetch['listing_id']}}" class="btn btn-sm btn-primary repost repost{{$detail_list_data['car_id']}}">Repost</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="hr-dashed"></div>

            </div>
        </div>

    </div>
    @include('footer')
</div>

<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dealerplus.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).on('click', '.viewlisting', function () {
    $('#car_view_id').val($(this).attr('data-id'));
    $('#view_car_managelist').submit();
});
$('.BSbtninfo').filestyle({
    buttonName: 'btn-info',
    buttonText: ' Upload Documents'
});
$(function () {
    $('.date').datetimepicker();
});
var getrow;
$(".deleteonline").click(function ()
{
    var inventory_id = $(this).data("inventory");
    var listing_id = $(this).data("listing-id");

    $("#loadspinner").show();
    $.ajax({
        url: "myposting_delete",
        type: "POST",
        data: {inventory_id: inventory_id, listing_id: listing_id},
        success: function (data)
        {

            $("#loadspinner").hide();
            $(".repost" + inventory_id).show();
            $(".delete" + inventory_id).hide();
            $("#status" + inventory_id).text('Inactive');
        }
    });


});

$(".repost").click(function ()
{
    var inventory_id = $(this).data("inventory");
    var listing_id = $(this).data("listing-id");

    $("#loadspinner").show();
    $.ajax({
        url: "myposting_repost",
        type: "POST",
        data: {inventory_id: inventory_id, listing_id: listing_id},
        success: function (data)
        {


            $("#loadspinner").hide();
            $(".repost" + inventory_id).hide();
            $(".delete" + inventory_id).show();
            $("#status" + inventory_id).text('Active');

        }
    });


});



$("body").on("click", ".deleteyes", function () {
    var duplicateid = $('.platformlist').val();
    $("#loadspinner").show();
    $.ajax({
        url: "myposting_delete",
        type: "POST",
        dataType: 'json',
        data: {duplicate_id: duplicateid, inventorystatus: 'deleteplatform'},
        success: function (data)
        {
            if (data.result == 'success') {
                $('#listdeleteresult').modal("hide");
                $(getrow).hide();
                $("#loadspinner").hide();
            } else
            {
                $(".successdelete").html("<p>Not Delete successfully</p>");
                $("#loadspinner").hide();
            }
        }
    });
});
</script>

</body> 

</html>