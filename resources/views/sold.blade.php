@include('header')
@include('sidebar')
<div class="content-wrapper myprofile">
    <div class="container-fluid">
        <div class="content-header">

            <ol class="breadcrumb">
                <li><a href="{{url('managelisting')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Sold</li>
            </ol>
        </div>
        @if (Session::has('message'))
            <div class="alert alert-success" id="message-err">{{ Session::get('message') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
        @endif
        @if (Session::has('message-err'))
            <div class="alert alert-danger" id="message-err">{{ Session::get('message-err') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
        @endif
        <div class="col-xs-12 ">
            <form method="post" action="{{url('dosaleinventory')}}" enctype="multipart/form-data">
                <h2>{{$compact_array['modelname']}} {{$compact_array['variant_name']}} {{$compact_array['registration_year']}}</h2>
                <div class="row">
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5"><label>V.I.N</label></div>
                        <div class="col-sm-7 form-group">  <input type='text' class="form-control" name="vinno" value="{{$compact_array['salesdetails']['vinno']}}" readonly/>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5"><label>Registration No</label></div>
                        <div class="col-sm-7 form-group">  <input type='text' class="form-control" name="registrationno" value="{{$compact_array['salesdetails']['registrationno']}}" readonly />
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5"><label>Original Purchase Price</label></div>
                        <div class="col-sm-7 form-group">  <input type='text' class="form-control" name="purchaseprice" value="{{$compact_array['salesdetails']['purchaseprice']}}" readonly />
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5"> <label>Sale Price</label></div>
                        <div class="col-sm-7 form-group">   <input type='text' class="form-control" name="saleprice" value="{{$compact_array['salesdetails']['saleprice']}}" readonly />
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5">  <label>Sale Date</label></div>
                        <div class="col-sm-7  form-group ">    
                            <div class="input-group date">
                                <input type='text' name="saledate" value="{{$compact_array['salesdetails']['saledate']}}" class="form-control" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5"><label>Sales Person</label></div>
                        <div class="col-sm-7 form-group">  <input type='text' name="salesperson" value="{{$compact_array['salesdetails']['salesperson']}}" class="form-control"/>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5"><label>Purchaser</label></div>
                        <div class="col-sm-7 form-group">   <input type='text' name="purchaser" value="{{$compact_array['salesdetails']['purchaser']}}" class="form-control"/>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12"><div class="col-sm-5"><label>Dealer MarkUp Price</label></div>
                        <div class="col-sm-7 form-group">  <input type='text' name="dealer_markup_price" value="{{$compact_array['salesdetails']['dealer_markup_price']}}" class="form-control" readonly="readonly" />
                        </div>
                    </div> 
                </div>
                <div class="hr-dashed"></div>
                <h4>Expenses</h4>
                <div class="col-sm-6 col-xs-12 park-div no-more-table">
                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Requirement</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compact_array['expense_info'] as $labelkey => $value)
                            <tr>
                                <td>{{$labelkey+1}}</td>
                                <td data-title="Car Name">{{$value->expense_desc}}</td>
                                <td>{{$value->expense_amount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6 col-xs-12"><div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">   
                                <div class="form-group">
                                    <input type="text" name="document[0]" class="form-control" placeholder="Document Name" 
                                           @if(isset($compact_array['salesdocuments'][0]['document_name'])) value="{{$compact_array['salesdocuments'][0]['document_name']}}" @endif>
                                </div> 
                            </div>
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <input type="file" name="documentupload[0]" class="BSbtninfo" /></div>
                            @if(isset($compact_array['salesdocuments'][0]['filepath']))
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <a href="{{$compact_array['salesdocuments'][0]['filepath']}}" download="download"><i class="fa fa-download" aria-hidden="true"></i></a></div>
                            @endif
                        </div></div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">   
                                <div class="form-group">
                                    <input type="text" name="document[1]" class="form-control" placeholder="Document Name" @if(isset($compact_array['salesdocuments'][1]['document_name'])) value="{{$compact_array['salesdocuments'][1]['document_name']}}" @endif>
                                </div> 
                            </div>
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <input type="file" name="documentupload[1]" class="BSbtninfo" /></div>
                            @if(isset($compact_array['salesdocuments'][1]['filepath']))
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <a href="{{$compact_array['salesdocuments'][1]['filepath']}}" download="download"><i class="fa fa-download" aria-hidden="true"></i></a></div>
                            @endif
                        </div></div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">   
                                <div class="form-group">
                                    <input type="text" name="document[2]" class="form-control" placeholder="Document Name" @if(isset($compact_array['salesdocuments'][2]['document_name'])) value="{{$compact_array['salesdocuments'][2]['document_name']}}" @endif>
                                </div> 
                            </div>
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <input type="file" name="documentupload[2]" class="BSbtninfo" /></div>
                            @if(isset($compact_array['salesdocuments'][2]['filepath']))
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <a href="{{$compact_array['salesdocuments'][2]['filepath']}}" download="download"><i class="fa fa-download" aria-hidden="true"></i></a></div>
                            @endif
                        </div></div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">   
                                <div class="form-group">
                                    <input type="text" name="document[3]" class="form-control" placeholder="Document Name" @if(isset($compact_array['salesdocuments'][3]['document_name'])) value="{{$compact_array['salesdocuments'][3]['document_name']}}" @endif>
                                </div> 
                            </div>
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <input type="file" name="documentupload[3]" class="BSbtninfo" /></div>
                            @if(isset($compact_array['salesdocuments'][3]['filepath']))
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <a href="{{$compact_array['salesdocuments'][3]['filepath']}}" download="download"><i class="fa fa-download" aria-hidden="true"></i></a></div>
                            @endif
                        </div></div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">    
                                <div class="form-group">
                                    <input type="text" name="document[4]" class="form-control" placeholder="Document Name" @if(isset($compact_array['salesdocuments'][4]['document_name'])) value="{{$compact_array['salesdocuments'][4]['document_name']}}" @endif>
                                </div> 
                            </div>
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <input type="file" name="documentupload[4]" class="BSbtninfo" @if(isset($compact_array['salesdocuments'][4]['document_name'])) value="{{$compact_array['salesdocuments'][4]['document_name']}}" @endif/></div>
                            @if(isset($compact_array['salesdocuments'][4]['filepath']))
                            <div class="col-sm-3 col-xs-12" title="Add Document">
                                <a href="{{$compact_array['salesdocuments'][4]['filepath']}}" download="download"><i class="fa fa-download" aria-hidden="true"></i></a></div>
                            @endif
                        </div></div>
                    <div class="col-xs-12">
                        <div class="add-list-buttons">
                            <div class="comm-button">
                                <button type="submit" class="btn btn-circle btn-lg btn-primary basic_info update_car_list" data-specific='save'  data-toggle="tooltip" data-original-title="Save" data-placement="left"><i class="fa fa-save"></i></button> 
                                <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                                <input type="hidden" name="inventory_id" id="inventory_id" value="{{$compact_array['inventory_id']}}">
                            </div>

                            <div class="comm-button">
                                <button class="btn btn-circle btn-lg btn-primary cancelbutton" data-basic="basic_info_next" value="1" type="button" data-toggle="tooltip" data-original-title="Cancel" data-placement="left"><i class="fa fa-remove" aria-describedby="tooltip721074"></i></button> 
                            </div>
                        </div>
                        <!--                                    <div class="row">
                                                                <input type="submit" class="btn btn-primary update_car_list" value="Save" data-specific='save'>
                                                                <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                                                                <input type="hidden" name="inventory_id" id="inventory_id" value="{{$compact_array['inventory_id']}}">
                                                            </div>-->
                    </div>

                </div>
            </form>
        </div>
    </div>
    @include('footer')
</div>
</div>

<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dealerplus.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script type="text/javascript">
$("body").on("click", ".cancelbutton", function () {
window.location.replace("{{url('managelisting')}}");
});
$('.BSbtninfo').filestyle({

buttonName: 'btn-info',

buttonText: ''
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

</body> 

</html>