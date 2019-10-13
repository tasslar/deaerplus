
@include('header')
@include('sidebar')            
<div class="content-wrapper">
    <div class="container-fluid footer-fixed">

        <div class="row">
            <div class="content-header col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="{{url('buy')}}"><i class="fa fa-dashboard"></i> Buy</a></li>
                    <li class="active">My Query</li>
                </ol>
            </div>
            <div class="col-xs-12">


                <h2 class="page-title">My Queries</h2>

                <div class="row">
                    <div class="col-md-12" id="no-more-tables">
                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead class="hidden-xs">
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Details</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Reply</th>

                                </tr>
                            </thead>
                            <tfoot class="hidden-xs">
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Details</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Reply</th>

                                </tr>
                            </tfoot>
                            <tbody>
                                @if(!empty($compact_array['queriesdata']))
                                @foreach($compact_array['queriesdata'] as $fetch)
                                <tr>
                                    <td data-title="Product Image"><img src="{{$fetch['imagelink']}}" class="img-responsive table-img" alt=""/></td>
                                    <td data-title="Product Detail"><h4>{{$fetch['make']}}</h4>
                                        <p>Rs.{{$fetch['price']}}</p>
                                        @if($fetch['listing_type']==0)
                                        <p class="text-center btn-vk view" data-id='{{$fetch["car_id"]}}'>Listing</p>
                                        @else
                                        <p class="text-center btn-adn view" data-id='{{$fetch["car_id"]}}'>Auction</p>
                                        @endif
                                        <img src="http://dev.dealerplus.in/dev/public/img/dealerplus.png" alt="">
                                    </td>
                                    <td data-title="From">{{$fetch['from_dealer_id']}}</td>
                                    <td data-title="To">{{$fetch['to_dealer_name']}}</td>
                                    <td data-title="Title">{{$fetch['title']}}</td>
                                    <td data-title="Message">{{$fetch['message']}}
                                        @if($fetch['status']==1)
                                        <span class="query-id">New <i class="fa fa-external-link-square"></i></span>
                                        @endif
                                    </td>
                                    <td data-title="Reply"><a class="btn btn-primary btn-sm message_list" data-dealer-id='{{$fetch["to_dealer_id"]}}' data-car-id='{{$fetch["car_id"]}}' data-make-model-variant='{{$fetch["title"]}}' data-last-message='{{$fetch["message"]}}' data-dealer-name='{{$fetch["dealer_name"]}}' data-dealer-email='{{$fetch["dealer_email"]}}' data-contact-transactioncode='{{$fetch["contact_transactioncode"]}}'>Reply</a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td data-title="No Data" colspan="7">No Queries Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div>{{$paginatelink}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
</div>

<div class="modal fade" id="funding_popup" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Funding</h4>
            </div>
            <div class="modal-alert-msg"></div>
            <div class="modal-body">
                <div class="row">
                    <form method="post">
                        <div class="form-group col-xs-12">
                            <div class="col-sm-12 col-xs-12 buy-message">
                                <input type="number" class="form-control" name="dealer_funding" id="dealer_funding">
                                <input type="hidden" class="form-control" name="dealer_id" id="dealer_id">
                                <input type="hidden" class="form-control" name="car_id" id="car_id">
                                <input type="hidden" class="form-control" name="make_model_variant" id="make_model_variant">
                            </div>
                            <div class="col-xs-4 pull-right">
                                <input type="button" class="btn btn-primary sent-message btn-sm button_loan" value="Add Funding">
                            </div>
                        </div>    
                    </form>
                    <div class="hr-dashed"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="post" id="sentqueries_form" action="{{url('sentQueries')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" id="reply_carid" name="reply_carid" value="">
    <input type="hidden" name="to_dealer_id" id="to_dealer_id">
    <input type="hidden" name="contact_transactioncode" id="contact_transactioncode">

</form>
<form method="post" id="view_car_managelist" action="{{url('detail_car_listing')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" id="car_view_id" name="car_view_id">
</form>
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
$(".send-again").click(function () {
$("#bid-hide").slideDown(1000);
});
$(document).ready(function () {
$('.view').click(function () {
$('#car_view_id').val($(this).attr('data-id'));
$('#view_car_managelist').submit();
});
$('.message_list').click(function ()
{

var to_dealer_id = $(this).attr('data-dealer-id');
var car_id = $(this).attr('data-car-id');
var last_message = $(this).attr('data-last-message');
var title = $(this).attr('data-make-model-variant');
var dealer_email = $(this).attr('data-dealer-email');
var dealer_name = $(this).attr('data-dealer-name');
var contact_transactioncode = $(this).attr('data-contact-transactioncode');
$('#reply_carid').val(car_id);
$('#to_dealer_id').val(to_dealer_id);
$('#contact_transactioncode').val(contact_transactioncode);

$('#sentqueries_form').submit();

});

});

</script>
</body>

</html>