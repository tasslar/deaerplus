@include('header')
@include('sidebar')

<div class="content-wrapper">
    <div class="container-fluid">
        <form method="post" action="{{url('/inventory-age-report')}}">
            {!!csrf_field()!!}
            <div class="row">
                <div class="content-header col-sm-12">
                    <div class="row top-search" id="search-slide">
                        <div class="input-group-btn search-panel">
                            <select class="col-xs-12 col-sm-12 btn btn-primary" name="ddl_sort_type">
                                <option value="0">---SELECT---</option>
                                <option value="1">ASCENDING</option>
                                <option value="2">DESCENDING</option>
                            </select>
                        </div>
                        <input type="text" class="form-control" name="x" placeholder="Search term...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="{{url('/reports')}}"><i class="fa fa-dashboard"></i> Reports</a></li>
                        <li class="active">Inventory Age Reports</li>
                    </ol>
                </div>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 mt mb">
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label>Ascending or Descending Date</label>
                                    <select class="form-control" name="ddl_sort_type" data-validation="alphanumeric" data-validation-optional="true">
                                        <option value="1" selected="">Ascending</option>
                                        <option value="2">Descending</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="clearfix"></div>
                            @foreach($checkbox as $k => $chk)
                            <div class="col-sm-3 col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="caramt{{$k}}" class="" type="checkbox" name="chk_name[]" value="{!!$k!!}" @if(in_array($k,$fetchparams)) checked @endif @if(empty($fetchparams)) checked @endif>
                                    <label for="caramt{{$k}}" class="">
                                        &nbsp;{{$chk}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-xs-12">
                            <input type="submit" name="btn_generate" value="VIEW" class="btn btn-primary">
                            <input type="submit" name="btn_download" value="DOWNLOAD" class="btn btn-primary">
                        </div>
                        <div class="clearfix"></div><br>

                        <div class="col-xs-12 mt">
                             @include('reportsbody')
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('footer')
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
