        @include('header')
        @include('sidebar')
        <div class="ts-main-content">
            
            <div class="content-wrapper myprofile">
                <div class="container-fluid footer-fixed">

                    <div class="row">
                        <div class="content-header col-xs-12">

                            <ol class="breadcrumb">
                                <li><a href="myprofile.html"><i class="fa fa-dashboard"></i> Home</a></li>
                                <li class="active">System Notifications</li>
                            </ol>
                        </div>
                        <div class="col-xs-12" id="features">
                        <h2 class="page-title">System Notifications</h2>
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
                        <form>
                        <div class="row">
                            <div class="col-md-12" id="no-more-tables">

                                <input type="hidden" name=_token value="{{csrf_token()}}">

                                <table id="zctb" class="display table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">

                                    <thead class="hidden-xs">

                                        <tr class="hidden-xs">
                                            <th>Id</th>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            
                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                    @if(count($sysnotify_data))
                                    @foreach($sysnotify_data as $key)
                                        <tr>
                                            <td data-title="Id">{{ $loop->iteration }}</td>
                                            <td data-title="Date" align="left">{{$key->created_at}}</td>
                                            <td data-title="Title" align="left">{{$key->title}}</td>
                                            <td data-title="Message" align="left">{{$key->stripemsg}}</td>
                                        </tr>
                                    @endforeach
                                        @else
                                            <tr>
                                                <td data-title="No Data" colspan="7">No Alerts Found</td>
                                            </tr>
                                        @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            </form>
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

</script>
       
</body>

</html>