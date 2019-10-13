        @include('header')
        @include('sidebar')
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="content-header col-sm-12">
                        <ol class="breadcrumb">
                            <li><a href="{{url('buy')}}"><i class="fa fa-dashboard"></i> Buy</a></li>
                            <li class="active">Search</li>
                            <li class="all-list-info">
                            @if($compact_array['mongo_carlisting_count']<10)
                            1 - {{$compact_array['mongo_carlisting_count']}}
                            @else
                            1 - 10
                            @endif on {{$compact_array['mongo_carlisting_count']}} Used Cars Found
                            </li>
                            
                        </ol>
                    </div>

                    <div class="col-xs-12">
                        <form method="post" action="searchcarlisting">
                            <div class="top-filters container-fluid">
                                <div class="col-sm-4 col-xs-12"><select class="form-control" id="selectcity" name="city_name">
                                        <option value="">Select City</option>
                                        @foreach($compact_array['master_city'] as $fetch)
                                            @if($compact_array['city_name']==$fetch->city_name)
                                            <option data-id="{{$fetch->city_name}}" value="{{$fetch->city_name}}" selected="selected">{{$fetch->city_name}}</option>
                                            @else
                                            <option data-id="{{$fetch->city_name}}" value="{{$fetch->city_name}}">{{$fetch->city_name}}</option>
                                            @endif
                                        @endforeach</select>
                                </div>
                                <input type="hidden" name="page_name" value="detail_searchpage">
                                <div class="col-sm-4 col-xs-12"><div class="input-group">
                                        <input type="text" class="form-control" id="searchtext_detailpage" name="search_listing" placeholder="Make or Model or Variant" value="{{$compact_array['search_listing']}}">
                                        <span class="input-group-btn"><input type="submit" class="btn btn-primary btn-md" value="Search"><i class="fa fa-search"></i></button></span>
                                    </div>
                                </div>
                                <div class="pull-right col-sm-2 col-xs-12 small-filter"><select class="form-control" id="budgetsorting" onchange="ajaxfetchcarlisting();">
                                        <option value="">Sort By</option>
                                        <optgroup label="Price">
                                            <option value="0">High To Low</option>
                                            <option value="1">Low To High</option>
                                        </optgroup>
                                        <optgroup label="KM Run">
                                            <option value="2">High To Low</option>
                                            <option value="3">Low To High</option>
                                        </optgroup>
                                        <optgroup label="Year">
                                            <option value="4">Old to New</option>
                                            <option value="5">New To Old</option>
                                        </optgroup>
                                        <optgroup label="Relavance">
                                            <option value="6">Recent to Old</option>
                                            <option value="7">Old To Recent</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!--<h2 class="page-title">Buy Listings</h2>-->


                        <div class="col-xs-12 col-sm-8">
                            <!--<div class="grid-buttons">
                            <div class="btn-group">
                   <a href="search.html" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
                     </span>List</a> 
                               <a href="search2.html" id="grid" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th"></span>Grid</a>
                </div>
                        </div>-->
                            <div class="row">
                                <div class="col-xs-12 tags-top">
                                    <ul class="tag">
                                    </ul>
                                </div>
                            </div>
                            <div id="listing">
                                @include('buysearchlistingajax')
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 filter">
                            <div class="panel panel-default">
                                <div class="panel-heading">Narrow Your Search for Used Car <span class="text-center btn-vk btn-xs resetsearch pull-rigth">Reset <i class="fa fa-filter"></i></span></div>
                                <div class="panel-body">
                                    <form method="get" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Car Sites:</label><label class="col-xs-4 control-label"><a class="clearsites">[Clear]</a></label>
                                            <div class="col-xs-12" id="api_sites">
                                                <select title="Car Sites" class="selectpicker" multiple data-selected-text-format="count" id="vehiclesite">
                                                <?php $indexid=0; ?>
                                                    @foreach($compact_array['api_sites'] as $fetch)
                                                        @if(in_array($fetch['description'], $compact_array['car_sites']))
                                                            <option id="sites-{{$indexid++}}" data-id="{{$fetch['description']}}" value="{{$fetch['description']}}" selected>{{$fetch['description']}}({{$fetch['count']}})</option>
                                                        @else
                                                            <option id="sites-{{$indexid++}}" data-id="{{$fetch['description']}}" value="{{$fetch['description']}}">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                        @endif
                                                    @endforeach
                                                    
                                                </select>
                                                <input type="hidden" name="city_name" id="city_name_narrow_search" value="{{$compact_array['city_name']}}">
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Listing Type:</label><label class="col-xs-4 control-label"><a class="clearlistingtype">[Clear]</a></label>
                                            <div class="col-xs-12" id="listingtypediv">
                                                <select title="Listing Type" class="selectpicker" multiple data-selected-text-format="count" id="listingtype">
                                                    @foreach($compact_array['listingtype'] as $fetch)
                                                        <option id="list-{{$fetch['id']}}" data-id="{{$fetch['id']}}" data-name="{{$fetch['description']}}" value="{{$fetch['id']}}">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Car Make:</label><label class="col-xs-4 control-label"><a class="clearmake">[Clear]</a></label>
                                            <div class="col-xs-12" id="carmake">
                                                <select title="Car Make" class="selectpicker" multiple data-selected-text-format="count" id="vehiclemake">
                                                    <option value="">Select Make</option>
                                                    @foreach($compact_array['make'] as $fetch)
                                                        @if($compact_array['vehicle_make']==$fetch['id'])
                                                            <option id="opt-{{$fetch['id']}}" data-id="{{$fetch['id']}}" data-name="{{$fetch['description']}}" value="{{$fetch['id']}}" selected="selected">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                        @else
                                                            <option id="opt-{{$fetch['id']}}" data-id="{{$fetch['id']}}" data-name="{{$fetch['description']}}" value="{{$fetch['id']}}">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Car Model:</label><label class="col-xs-4 control-label"><a class="clearmodel">[Clear]</a></label>
                                            <div class="col-xs-12">
                                                <select title="Car Model" class="form-control selectpicker" id="vehiclemodel" onchange="ajaxfetchcarlisting();">
                                                    <option value="">Select Model</option>
                                                    @foreach($compact_array['model'] as $fetch)
                                                        @if($compact_array['vehicle_model']==$fetch['description'])
                                                            <option id="opt-{{$fetch['description']}}" data-id="{{$fetch['description']}}" data-name="{{$fetch['description']}}" value="{{$fetch['description']}}" selected="selected">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                        @else
                                                            <option id="opt-{{$fetch['description']}}" data-id="{{$fetch['description']}}" data-name="{{$fetch['description']}}" value="{{$fetch['description']}}">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Car Year:</label><label class="col-xs-4 control-label"><a class="clearyear">[Clear]</a></label>
                                            <div class="col-xs-12">
                                                <select class="form-control selectpicker" id="registration_year" onchange="ajaxfetchcarlisting();">
                                                    <option value="">Select Year</option>
                                                    @foreach($compact_array['reg_year'] as $fetch)
                                                        <option data-id="{{$fetch['description']}}" value="{{$fetch['description']}}">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Transmission:</label><label class="col-xs-4 control-label"><a class="cleartransmission">[Clear]</a></label>
                                            <div class="col-xs-12">
                                                <select class="form-control selectpicker" id="transmission_type" onchange="ajaxfetchcarlisting();">
                                                    <option value="">Select Transmission</option>
                                                    @foreach($compact_array['transmission'] as $fetch)
                                                        <option data-id="{{$fetch['description']}}" value="{{$fetch['description']}}">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Fuel Type:</label><label class="col-xs-4 control-label"><a class="clearfuel_type">[Clear]</a></label>
                                            <div class="col-xs-12">
                                                <select class="form-control selectpicker" id="fuel_type" onchange="ajaxfetchcarlisting();">
                                                    <option value="">Select Fuel</option>
                                                    @foreach($compact_array['fuel_type'] as $fetch)
                                                        <option data-id="{{$fetch['description']}}" value="{{$fetch['description']}}">{{$fetch['description']}}({{$fetch['count']}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Price Range:
                                                <br>
                                            </label><label class="col-xs-4 control-label"><a class="clearpricerange">[Clear]</a></label>

                                            <div class="col-xs-12">
                                            <?php $sno = 0; ?>
                                                @foreach($compact_array['price_filter'] as $fetch)
                                                
                                                <div class="checkbox checkbox-info">
                                                    <input type="radio" id="fCheckbox{{$sno}}" name="pricefilter" value="{{$fetch['description']}}" data-min="{{$fetch['minvalue']}}" data-max="{{$fetch['maxvalue']}}" onclick="ajaxfetchcarlisting();" @if($fetch['value']==$compact_array['car_budget']) {{ 'checked' }} @endif>
                                                    <label for="fCheckbox{{$sno}}">
                                                        {{$fetch['description']}}<span class="text-warning price{{$sno}}">({{$fetch['count']}})</span>
                                                    </label>
                                                </div>
                                                <?php $sno++; ?>
                                                @endforeach
                                                
                                            </div>
                                        </div>

                                        <div class="hr-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-xs-8 control-label">Body Type:
                                                <br>
                                            </label><label class="col-xs-4 control-label"><a class="clearbodytype">[Clear]</a></label>
                                            <div class="col-xs-12">
                                                <?php $sno = 0; ?>
                                                @foreach($compact_array['body_types'] as $fetch)

                                                   
                                                   
                                                <?php $sno++; ?>

                                                <div class="checkbox checkbox-info">
                                                    @if($compact_array['vehicle_type']==$fetch['category_description'])
                                                        <input type="checkbox" id="bCheckbox{{$sno}}" name="body_type" value="{{$fetch['category_description']}}" onclick="ajaxfetchcarlisting();" checked="checked">
                                                    @else
                                                        <input type="checkbox" id="bCheckbox{{$sno}}" name="body_type" value="{{$fetch['category_description']}}" onclick="ajaxfetchcarlisting();">
                                                    @endif

                                                    <label for="bCheckbox{{$sno}}">
                                                        {{$fetch['category_description']}} <span class="text-warning {{$fetch['category_description']}}">({{$fetch['categorycount']}})</span>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            @include('footer')
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
            <input type="hidden" name="city_name" id="city_name_similar" value="{{$compact_array['city_name']}}">
            <input type="hidden" id="model" name="model">
            <input type="hidden" id="make_id" name="make_id">
        </form>

        <form method="post" id="paginate_car_managelist" action="{{url('searchcarlisting')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="page_name" name="page_name" value="similar_searchpage">
            <input type="hidden" name="city_name" id="city_name_similar" value="{{$compact_array['city_name']}}">
            <input type="hidden" id="model" name="model">
            <input type="hidden" id="make_id" name="make_id">
        </form>
        
        <!-- Loading Scripts -->
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
        <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{URL::asset('js/fileinput.js')}}"></script>
        <!-- <script src="{{URL::asset('js/main.js')}}"></script>
        <script src="{{URL::asset('js/menu.js')}}"></script> -->
        <script src="{{URL::asset('js/dealerplus.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>

        <script>
            $("#email-alert-send").click(function () {
                
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

                $('#vehiclesite,#listingtype').change(function () {
                    ajaxfetchcarlisting();
                });

                $('#vehiclemake').change(function () {
                    var makeselect = [];
                    $('.dropdown-menu .selected').each(function (i, selected) {
                        makeselect[i] = $(this).attr('data-original-index');
                        //console.log($(this).attr('data-original-index'));
                    });
                    ajaxfetchcarlisting();
                    
                    //console.log(makeselect);
                    //var make=$(this).val();
                    /*alert();*/
                    /*var csrf_token = $('#token').val();
                    $('#vehiclemodel').empty();
                    $.ajax({
                        url: 'fetch_model',
                        type: 'post',
                        data: {_token: csrf_token, make: makeselect},
                        success: function (response)
                        {
                            //alert(response);
                            var json = $.parseJSON(response);
                            $('#vehiclemodel').append($('<option>', {value: '', text: 'Select Model'}));
                            $.each(json, function (arrayID, group) {
                                $('#vehiclemodel').append($('<option>', {value: group.model_name, text: group.model_name}));
                            });
                            $('#vehiclemodel').selectpicker('refresh');
                            ajaxfetchcarlisting();

                        },
                        error: function (e)
                        {
                            console.log(e.responseText);
                        }
                    });*/
                    
                });
            });
            function ajaxfetchcarlisting(page = 1)
            {
                $("#loadspinner").css("display", "block");
                var makeselect = [];
                
                $('#carmake .bootstrap-select .open .dropdown-menu .selected').each(function (i, selected) {
                    makeselect[i] = $(this).attr('data-original-index');
                    //console.log($(this).attr('data-original-index'));
                });
                var sites = [];
                $('#api_sites .bootstrap-select .open .dropdown-menu .selected').each(function (i, selected) {
                    sites[i] = $('#sites-'+$(this).attr('data-original-index')).attr('data-id');

                    //console.log($(this).attr('data-original-index'));
                });
                var listypeselect = [];
                $('#listingtypediv .bootstrap-select .open .dropdown-menu .selected').each(function (i, selected) {
                    listypeselect[i] = $(this).attr('data-original-index');
                    //console.log($(this).attr('data-original-index'));
                });

                var body_type = [];
                $('input[name=body_type]:checked').each(function (i, selected) {
                    body_type[i] = $(this).val();
                    //console.log($(this).attr('data-original-index'));
                });
                //console.log(makeselect);
                var vehiclemodel = $('#vehiclemodel').val();
                var fuel_type = $('#fuel_type').val();
                var registration_year = $('#registration_year').val();
                var transmission_type = $('#transmission_type').val();
                var price_filter = $('input[name=pricefilter]:checked').val();
                var maxvalue_filter = $('input[name=pricefilter]:checked').attr('data-max');
                var minvalue_filter = $('input[name=pricefilter]:checked').attr('data-min');
                //var body_type = $('input[name=body_type]:checked').val();
                var city_name = $('input[name=city_name]').val();
                var budgetsorting = $('#budgetsorting').val();
                //alert(price_filter);
                var csrf_token = $('#token').val();
                var search_listing = $('#searchtext_detailpage').val();
                $.ajax({
                    url: 'view_searchcarlisting',
                    type: 'post',
                    data: {_token: csrf_token, vehicle_make: makeselect, vehicle_model: vehiclemodel, fuel_type: fuel_type, registration_year: registration_year, transmission_type: transmission_type, price_filter: price_filter, body_type: body_type, city_name: city_name, maxvalue_filter: maxvalue_filter, minvalue_filter: minvalue_filter, budgetsorting: budgetsorting, page: page, sites: sites,listypeselect:listypeselect,search_listing:search_listing},
                    success: function (response)
                    {
                        if(response=='sessionout')
                        {
                            window.location.replace("{{url('login')}}");
                            return false;
                        }
                        $("#loadspinner").css("display", "none");
                        //console.log(response.length);
                        //console.log(response);
                        $('#listing').empty().append(response);
                        //alert(response);
                        //console.log(response);
                        $('.viewlisting').click(function () {
                            $('#car_view_id').val($(this).attr('data-id'));
                            $('#view_car_managelist').submit();
                        });
                        $('.view_similar').click(function () {
                            $('#model').val($(this).attr('data-model'));
                            $('#make_id').val($(this).attr('data-make'));
                            $('#similar_car_managelist').submit();
                        });
                        
                        pagination_link();
                        showselectedtags();
                         $("html, body").animate({ scrollTop: 0 }, "slow");
                    },
                    error: function (e)
                    {
                        console.log(e.responseText);
                    }
                });
                $.ajax({
                        url: 'narrowsearchcount',
                        type: 'post',
                        data: {_token: csrf_token, vehicle_make: makeselect, vehicle_model: vehiclemodel, fuel_type: fuel_type, registration_year: registration_year, transmission_type: transmission_type, price_filter: price_filter, body_type: body_type, city_name: city_name, maxvalue_filter: maxvalue_filter, minvalue_filter: minvalue_filter, budgetsorting: budgetsorting, page: page, sites: sites,listypeselect:listypeselect,search_listing:search_listing},
                        success: function (response)
                        {
                            var json = $.parseJSON(response);
                            $('#vehiclemake,#vehiclesite,#fuel_type,#listingtype,#transmission_type,#registration_year').empty();
                            $.each(json, function(arrayID,group) 
                            {
                                //console.log(arrayID);
                                if(arrayID=='make')
                                {   
                                    $('#vehiclemake').append($('<option>', {value:'', text:'Select Make'}));
                                    
                                    $.each(group, function(makeid,makeobj) {

                                       if(makeobj.selected=='selected')
                                       {
                                        $('#vehiclemake').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.id,id:'opt-'+makeobj.id,'selected':"'aaaa"+makeobj.selected+"'",'value':makeobj.id, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                        else
                                        {
                                         $('#vehiclemake').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.id,id:'opt-'+makeobj.id,'value':makeobj.id, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                    });
                                    $('#vehiclemake').selectpicker('refresh');
                                }
                                else if(arrayID=='sites')
                                {                                    
                                    $.each(group, function(makeid,makeobj) {

                                       if(makeobj.selected=='selected')
                                       {
                                        $('#vehiclesite').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'sites-'+makeid,'selected':"'"+makeobj.selected+"'",'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                        else
                                        {
                                         $('#vehiclesite').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'sites-'+makeid,'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                    });
                                    $('#vehiclesite').selectpicker('refresh');
                                }
                                else if(arrayID=='fuel_array')
                                {                
                                    $('#fuel_type').append($('<option>', {value:'', text:'Select Fuel Type'}));
                                    $.each(group, function(makeid,makeobj) {

                                       if(makeobj.selected=='selected')
                                       {
                                        $('#fuel_type').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'sites-'+makeobj.id,'selected':"'"+makeobj.selected+"'",'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                        else
                                        {
                                         $('#fuel_type').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'opt-'+makeobj.id,'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                    });
                                    $('#fuel_type').selectpicker('refresh');
                                }
                                else if(arrayID=='listingtype_array')
                                {                                    
                                    $.each(group, function(makeid,makeobj) {

                                       if(makeobj.selected=='selected')
                                       {
                                        $('#listingtype').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.id,id:'list-'+makeobj.id,'selected':"'"+makeobj.selected+"'",'value':makeobj.id, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                        else
                                        {
                                         $('#listingtype').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.id,id:'list-'+makeobj.id,'value':makeobj.id, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                    });
                                    $('#listingtype').selectpicker('refresh');
                                }
                                else if(arrayID=='transmission_array')
                                {
                                    $('#transmission_type').append($('<option>', {value:'', text:'Select Transmission'}));                                  
                                    $.each(group, function(makeid,makeobj) {

                                       if(makeobj.selected=='selected')
                                       {
                                        $('#transmission_type').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'list-'+makeobj.id,'selected':"'"+makeobj.selected+"'",'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                        else
                                        {
                                         $('#transmission_type').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'list-'+makeobj.id,'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                    });
                                    $('#transmission_type').selectpicker('refresh');
                                }
                                else if(arrayID=='reg_year_array')
                                {      
                                    $('#registration_year').append($('<option>', {value:'', text:'Select Year'}));                              
                                    $.each(group, function(makeid,makeobj) {

                                       if(makeobj.selected=='selected')
                                       {
                                        $('#registration_year').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'list-'+makeobj.id,'selected':"'"+makeobj.selected+"'",'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                        else
                                        {
                                         $('#registration_year').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.description,id:'list-'+makeobj.id,'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                    });
                                    $('#registration_year').selectpicker('refresh');
                                }
                                else if(arrayID=='model_array')
                                {
                                    $('#vehiclemodel').empty();
                                    $('#vehiclemodel').append($('<option>', {value:'', text:'Select Model'}));                              
                                    $.each(group, function(makeid,makeobj) {

                                       if(makeobj.selected=='selected')
                                       {
                                        $('#vehiclemodel').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.id,id:'list-'+makeobj.id,'selected':"'"+makeobj.selected+"'",'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                        else
                                        {
                                         $('#vehiclemodel').append($('<option>', {'data-name':makeobj.description,'data-id':makeobj.id,id:'list-'+makeobj.id,'value':makeobj.description, 'text':makeobj.description+'('+makeobj.count+')'}));
                                        }
                                    });
                                    $('#vehiclemodel').selectpicker('refresh');
                                }
                                else if(arrayID=='listing_category_array')
                                {      
                                    $.each(group, function(makeid,makeobj) {
                                       $('.'+makeobj.category_description).text('('+makeobj.categorycount+')'); 
                                       //console.log(makeid+'-'+makeobj.categorycount);
                                    });
                                }
                                else if(arrayID=='price_filter')
                                {      
                                    $.each(group, function(makeid,makeobj) {
                                       $('.price'+makeid).text('('+makeobj.count+')'); 
                                       //console.log(makeid+'-'+makeobj.categorycount);
                                    });
                                }
                                else if(arrayID=='mongo_carlisting_count')
                                {                                     
                                    var startno = 1+(parseInt(page-1)*10);
                                    var endno = 10+(parseInt(page-1)*10)
                                    if(endno>group)
                                    {
                                        endno=group;
                                    }
                                    var pagemsg = startno+' - '+endno+' of '+group+' Used Cars Found';     
                                    $('.all-list-info').html(pagemsg);
                                }
                            });
                        }
                    });
            }
            setTimeout(showselectedtags,1000);
            function showselectedtags()
            {
                var showselected = '';
                var makeselect = [];
                var vehiclemodel = $('#vehiclemodel').val();
                var fuel_type = $('#fuel_type').val();
                var city_name = $('input[name=city_name]').val();
                var registration_year = $('#registration_year').val();
                var transmission_type = $('#transmission_type').val();
                var price_filter = $('input[name=pricefilter]:checked').val();
                var body_type = $('input[name=body_type]:checked').val();
                var search_listing = $('#searchtext_detailpage').val();
                var sites = [];

                $('#api_sites .bootstrap-select .open .dropdown-menu .selected').each(function (i, selected) {
                    var sites_id = $(this).attr('data-original-index');
                    //alert(sites_id);
                    var sites_name = $('#sites-' + sites_id).attr('data-id');
                    //alert(sites_name);
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close sitesclose" data-dismiss="alert" data-id="' + sites_id + '"><i class="fa fa-remove"></i></button><p title="' + sites_name + '"><span class="filter-tag">Sites</span><br/>' + sites_name + '</p></li>';
                    //console.log($(this).attr('data-original-index'));
                });

                $('#listingtypediv .bootstrap-select .open .dropdown-menu .selected').each(function (i, selected) {
                    var listypeselect_id = $(this).attr('data-original-index');
                    var listing_name = $('#list-' + listypeselect_id).attr('data-name');
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close listingclose" data-dismiss="alert" data-id="' + listypeselect_id + '"><i class="fa fa-remove"></i></button><p title="' + listing_name + '"><span class="filter-tag">Listing</span><br/>' + listing_name + '</p></li>';
                    //console.log($(this).attr('data-original-index'));
                });

                $('#carmake .bootstrap-select .open .dropdown-menu .selected').each(function (i, selected) {
                    var make_id = $(this).attr('data-original-index');
                    var make_name = $('#opt-' + make_id).attr('data-name');
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close makeclose" data-dismiss="alert" data-id="' + make_id + '"><i class="fa fa-remove"></i></button><p title="' + make_name + '"><span class="filter-tag">Make</span><br/>' + make_name + '</p></li>';
                    //console.log($(this).attr('data-original-index'));
                });

                
                if (vehiclemodel != '' && vehiclemodel != null)
                {
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close modelclose" data-dismiss="alert" data-id="' + vehiclemodel + '"><i class="fa fa-remove"></i></button><p title="' + vehiclemodel + '"><span class="filter-tag">Model</span><br/>' + vehiclemodel + '</p></li>';
                }

                if (search_listing != '' && search_listing != null)
                {
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close modelclose" data-dismiss="alert" data-id="' + search_listing + '"><i class="fa fa-remove"></i></button><p title="' + search_listing + '"><span class="filter-tag">Search</span><br/>' + search_listing + '</p></li>';
                }

                
                $('input[name=body_type]:checked').each(function (i, selected)
                {
                    body_type=$(this).val();
                    body_type_id=$(this).attr('id');
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close body_type" data-dismiss="alert" data-id="' + body_type_id + '"><i class="fa fa-remove"></i></button><p title="' + body_type + '"><span class="filter-tag">Body Type</span><br/>' + body_type + '</p></li>';
                });
                if (transmission_type != '' && transmission_type != 'undefined')
                {
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close transmission_type" data-dismiss="alert" data-id="' + transmission_type + '"><i class="fa fa-remove"></i></button><p title="' + transmission_type + '"><span class="filter-tag">Transmission</span><br/>' + transmission_type + '</p></li>';
                }
                $('input[name=pricefilter]:checked').each(function (i, selected)                                                            
                {
                    //alert($(this).val());
                    //showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close price_filter" data-dismiss="alert" data-id="' + $(this).val() + '"><i class="fa fa-remove"></i></button><p><span class="filter-tag">Budget</span>' + $(this).val() + '</p></li>';
                });
                
                if (price_filter != ''&&price_filter != null)
                {
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close pricefilter" data-dismiss="alert" data-id="' + price_filter + '"><i class="fa fa-remove"></i></button><p title="' + price_filter + '"><span class="filter-tag">Price</span><br/>' + price_filter + '</p></li>';
                }
                if (fuel_type != '')
                {
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close fuelclose" data-dismiss="alert" data-id="' + fuel_type + '"><i class="fa fa-remove"></i></button><p title="' + fuel_type + '"><span class="filter-tag">Fuel</span><br/>' + fuel_type + '</p></li>';
                }
                if (registration_year != '')
                {
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close regclose" data-dismiss="alert" data-id="' + registration_year + '"><i class="fa fa-remove"></i></button><p title="'+ registration_year + '"><span class="filter-tag">Year</span><br/>' + registration_year + '</p></li>';
                }
                if (city_name != '')
                {
                    showselected = showselected + '<li class="alert alert-default col-xs-2"><button type="button" class="close cityclose" data-dismiss="alert" data-id="' + city_name + '"><i class="fa fa-remove"></i></button><p title="' + city_name + '"><span class="filter-tag">City</span><br/>' + city_name + '</p></li>';
                }
                $('.tag').empty().append(showselected);
                $(".makeclose").click(function () {
                    var makeclose_id = $(this).attr('data-id');
                    var selected_make = '0';
                    $('#carmake .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                        var make_id = $(this).parent().attr('data-original-index');
                        selected_make++;
                        if (make_id == makeclose_id)
                        {
                            $(this).click();
                            selected_make--;
                            //$(this).trigger('click');
                        }
                    });
                    $('#vehiclemodel').selectpicker('refresh');
                    ajaxfetchcarlisting();
                });

                $(".sitesclose").click(function () {
                    var close_id = $(this).attr('data-id');
                    var selected_make = '0';
                    $('#api_sites .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                        var site_id = $(this).parent().attr('data-original-index');
                        selected_make++;
                        if (site_id == close_id)
                        {
                            $(this).click();
                            selected_make--;
                            //$(this).trigger('click');
                        }
                    });
                    ajaxfetchcarlisting();
                });

                $(".listingclose").click(function () {
                    var close_id = $(this).attr('data-id');
                    var selected_make = '0';
                    $('#listingtypediv .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                        var listing_id = $(this).parent().attr('data-original-index');
                        selected_make++;
                        if (listing_id == close_id)
                        {
                            $(this).click();
                            selected_make--;
                            //$(this).trigger('click');
                        }
                    });
                    ajaxfetchcarlisting();
                });


                $(".modelclose").click(function () {
                    $('#vehiclemodel').val('');
                    ajaxfetchcarlisting();
                });
                $(".fuelclose").click(function () {
                    $('#fuel_type').val('');
                    ajaxfetchcarlisting();
                });
                $(".regclose").click(function () {
                    $('#registration_year').val('');
                    ajaxfetchcarlisting();
                });

                $(".body_type").click(function () {                    
                    $('#'+$(this).attr('data-id')).attr('checked',false);
                    ajaxfetchcarlisting();
                });

                $(".transmission_type").click(function () {
                    $('#transmission_type').val('');
                    ajaxfetchcarlisting();
                });

                $(".pricefilter").click(function () {
                    $('input:radio[name=pricefilter]').attr('checked',false);
                    ajaxfetchcarlisting();
                });

                $(".cityclose").click(function () {
                    $('input[name=city_name]').val('');
                    ajaxfetchcarlisting();
                });

            }
            $(".resetsearch").click(function () {                 
                $('#api_sites .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                    $(this).click();
                });
                $('#listingtypediv .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                    $(this).click();
                });
                $('#carmake .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                    $(this).click();
                });
                $('#vehiclemodel').val('');
                $('#registration_year').val('');
                $('#transmission_type').val('');
                $('#fuel_type').val('');
                $('input:radio[name=pricefilter]').attr('checked',false);
                $('input:checkbox[name=body_type]').attr('checked',false);
                ajaxfetchcarlisting();
            });                                            

            $(".clearsites").click(function () {                 
                $('#api_sites .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                    $(this).click();
                });
                ajaxfetchcarlisting();
            });

            $(".clearlistingtype").click(function () {                 
                $('#listingtypediv .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                    $(this).click();
                });
                ajaxfetchcarlisting();
            });

            $(".clearmake").click(function () {                 
                $('#carmake .bootstrap-select .open .dropdown-menu .selected a').each(function (i, selected) {
                    //$(this).removeClass('selected');    
                    $(this).click();
                });
                ajaxfetchcarlisting();
            });

            $(".clearmodel").click(function () {                 
                $('#vehiclemodel').val('');
                ajaxfetchcarlisting();
            });

            $(".clearyear").click(function () {                 
                $('#registration_year').val('');
                ajaxfetchcarlisting();
            });

            $(".clearfuel_type").click(function () {                 
                $('#fuel_type').val('');
                ajaxfetchcarlisting();
            });

            $(".clearpricerange").click(function () {                 
                $('input:radio[name=pricefilter]').attr('checked',false);
                ajaxfetchcarlisting();
            });

            $(".clearbodytype").click(function () {                 
                $('input:checkbox[name=body_type]').attr('checked',false);
                ajaxfetchcarlisting();
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
            
            pagination_link();
            function pagination_link()
            {
                $(".pagination li a").click(function (event) {
                    var paginate_link = $(this).attr('href');
                    var paginate_link_split = paginate_link.split("page=");
                    var pageno = paginate_link_split[1];
                    ajaxfetchcarlisting(pageno);
                    event.preventDefault();

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
                            if (response == 1)
                            {
                                $(thisid).addClass('detail-wishlist-active');
                            } else
                            {
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

                

            }
            
        </script>
<!--        <script>

            $('.savedcarslink').on('click', function () {
                //Scroll to top if cart icon is hidden on top
                $('html, body').animate({
                    'scrollTop': $(".savedlist").position().top
                });
                //Select item image and pass to the function
                var itemImg =  $(this).parent().parent().parent().parent().parent().find("img").eq(0);
                flyToElement($(itemImg), $('.savedlist'));
            });


            function flyToElement(flyer, flyingTo) {
                var $func = $(this);
                var divider = 3;
                var flyerClone = $(flyer).clone();
                $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
                $('body').append($(flyerClone));
                var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width() / divider) / 2;
                var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height() / divider) / 2;
                $(flyerClone).animate({
                    opacity: 1,
                    left: 0,
                    top: $(flyingTo).offset().top,
                    width: $(flyer).width() / divider,
                    height: $(flyer).height() / divider
                }, 2000,
                        function () {
                            $(flyingTo).fadeOut('fast', function () {
                                $(flyingTo).fadeIn('fast', function () {
                                    $(flyerClone).fadeOut('fast', function () {
                                        $(flyerClone).remove();
                                    });
                                });
                            });
                        });
            }
        </script>-->
    </body>

</html>