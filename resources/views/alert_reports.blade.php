@include('header')
@include('sidebar')
<div class="ts-main-content">
    <div class="content-wrapper myprofile">
        <div class="container-fluid footer-fixed">
            <div class="row">
                <div class="col-xs-12" id="features">

                    <div class="content-header col-sm-12">

                        <div class="row top-search" id="search-slide">
                            <div class="input-group-btn search-panel">
                                <select class="col-xs-12 col-sm-12 btn btn-primary">
                                    <option value="">Filter</option>
                                    <option value="1">Inventory</option>
                                    <option value="2">Customer</option>
                                    <option value="3">Dealers</option>
                                    <option value="4">Cars</option>
                                </select>
                            </div>
                            <input type="hidden" name="search_param" value="all" class="" id="search_param">

                            <input type="text" class="form-control" name="x" placeholder="Search term...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="{{url('/reports')}}"><i class="fa fa-dashboard"></i> Reports</a></li>
                            <li class="active">Alert Report</li>
                        </ol>
<!--                        <h2 class="page-title col-md-9">Alerts</h2>
                        <div class="col-md-3">
                            <a href="{{url('/')}}" class="btn btn-primary pull-right">
                                <i class="glyphicon glyphicon-export"></i>&nbsp;Export Excel
                            </a>
                        </div>-->
                    </div>
                    <form method="post">
                        <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                        <div class="col-sm-3 col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input class="" type="checkbox" name="cb_alert[]" value="alert_type" @if(in_array('alert_type',$fetchparams)) checked @endif @if(empty($fetchparams)) checked @endif>
                                <label for="caramt" class="">
                                    Alert Type
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input class="" type="checkbox" name="cb_alert[]" value="alert_date" @if(in_array('alert_date',$fetchparams)) checked @endif @if(empty($fetchparams)) checked @endif>
                                <label for="caramt" class="">
                                    Alert Date
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input class="" type="checkbox" name="cb_alert[]" value="Product" @if(in_array('Product',$fetchparams)) checked @endif @if(empty($fetchparams)) checked @endif>
                                <label for="caramt" class="">
                                    Product
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input class="" type="checkbox" name="cb_alert[]" value="alert_city" @if(in_array('alert_city',$fetchparams)) checked @endif @if(empty($fetchparams)) checked @endif>
                                <label for="caramt" class="">
                                    Location
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input class="" type="checkbox" name="cb_alert[]" value="alert_email_status" @if(in_array('alert_email_status',$fetchparams)) checked @endif @if(empty($fetchparams)) checked @endif>
                                <label for="caramt" class="">
                                    Email Status
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input class="" type="checkbox" name="cb_alert[]" value="alert_sms_status" @if(in_array('alert_sms_status',$fetchparams)) checked @endif @if(empty($fetchparams)) checked @endif>
                                <label for="caramt" class="">
                                    SMS Status
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-xs-12">
                            <input type="submit" name="btn_view" value="VIEW" class="btn btn-primary">
                            <input type="submit" name="btn_download" value="DOWNLOAD" class="btn btn-primary">
                        </div>
                    </form>
                    <div class="col-xs-12 mt">
                            @include('reportsbody')
                    </div>
                </div>
            </div>
        </div>
        @include('footer')
    </div>
</div>

<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/dealerplus.js"></script>
</body>

</html>