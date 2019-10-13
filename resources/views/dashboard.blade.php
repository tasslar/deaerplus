<!--<meta http-equiv="refresh" content="120">-->
@include('header')
@include('sidebar')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 content-header">
                <h2 class="page-title">Dashboard</h2>
                <div class="row add-report">
                    <div class="col-sm-6 col-md-3">
                        <div class="panel panel-default bk-black text-light">

                            <div class="add-panel-title text-uppercase col-xs-9">Inventory <span>({{$compact_array['inventorycount']}})</span></div>
                            <div class="add-panel-icon col-xs-3"><a href="{{url('add_listing_tab')}}"><i class="fa fa-plus"></i></a></div>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="panel panel-default bk-black text-light">
                            <div class="add-panel-title text-uppercase col-xs-9">Leads <span>({{$compact_array['leadcount']}})</span></div>
                            <div class="add-panel-icon col-xs-3"><a href="{{url('addcontact/'.$compact_array['contact_value'])}}"><i class="fa fa-plus"></i></a></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="panel panel-default bk-black text-light">
                            <div class="add-panel-title text-uppercase col-xs-9">Customers <span>({{$compact_array['custmoercount']}})</span></div>
                            <div class="add-panel-icon col-xs-3"><a href="{{url('addcontact/'.$compact_array['contact_value'])}}"><i class="fa fa-plus"></i></a></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="panel panel-default bk-black text-light">
                            <div class="add-panel-title text-uppercase col-xs-9">Funding Request <span>({{$compact_array['fundingcount']}})</span></div>
                            <div class="add-panel-icon col-xs-3"><a href="{{url('addfund')}}"><i class="fa fa-plus"></i></a></div>
                        </div>
                    </div>
                </div>

                <div class="hr-dashed"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-sm-3 dashboard">
                                <div class="panel panel-default">
                                    <a href="{{url('managelisting')}}?type=live">
                                        <div class="panel-body bk-primary text-light">
                                            <span class="meter-icon hidden-sm hidden-md hidden-xs"><i class="fa fa-car"></i></span>
                                            <div class="stat-panel text-left">
                                                <div class="stat-panel-number h1 ">{{$compact_array['livecount']}}</div>
                                                <div class="stat-panel-title">View More</div>
                                                <div class="stat-panel-title">In Stock (live) </div>
                                                <div class="stat-panel-date">as of {{$compact_array['currentdate']}}</div>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-sm-3 dashboard">
                                <div class="panel panel-default">
                                    <a href="{{url('managelisting')}}?type=draft">
                                        <div class="panel-body bk-success text-light">
                                            <p class="meter-icon meter-icon1 hidden-sm hidden-md hidden-xs"><i class="fa fa-car"></i></p>
                                            <p class="meter-icon hidden-sm hidden-md hidden-xs"><i class="fa fa-car"></i></p>
                                            <div class="stat-panel text-left">
                                                <div class="stat-panel-number h1">{{$compact_array['draftcount']}}</div>
                                                <div class="stat-panel-title">View More</div>
                                                <div class="stat-panel-title">In Progress</div>
                                                <div class="stat-panel-date">as of {{$compact_array['currentdate']}}</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-sm-3 dashboard">
                                <div class="panel panel-default">
                                    <a href="{{url('managelisting')}}?type=sold">
                                        <div class="panel-body bk-info text-light">
                                            <span class="meter-icon rupees hidden-sm hidden-md hidden-xs"><i class="fa fa-rupee"></i></span>
                                            <div class="stat-panel text-left">
                                                <div class="stat-panel-number h1 ">{{$compact_array['soldcount']}}</div>
                                                <div class="stat-panel-title">View More</div>
                                                <div class="stat-panel-title">Sold This Month</div>
                                                <div class="stat-panel-date">as of {{$compact_array['currentdate']}}</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-sm-3 dashboard">
                                <div class="panel panel-default">
                                    <a href="{{url('doQueriesReceived')}}">
                                        <div class="panel-body bk-warning text-light">
                                            <span class="meter-icon hidden-sm hidden-md hidden-xs"><i class="fa fa-envelope"></i></span>
                                            <div class="stat-panel text-left">
                                                <div class="stat-panel-number h1 ">{{$compact_array['quriescount']}}</div>
                                                <div class="stat-panel-title">View More</div>
                                                <div class="stat-panel-title">Queries Received</div>
                                                <div class="stat-panel-date">as of {{$compact_array['currentdate']}}</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="hr-dashed"></div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-car text-success"></i> Inventory Summary <p class="pull-right"><a href="managelisting" class="">View More</a></p></div>
                            <div class="panel-body">
                                <div class="col-5">
                                    <h3 class="text-center text-5x mt-2x">Total Inventory</h3>
                                    <p class="text-danger text-7x text-center mb-2x">{{$compact_array['inventorycount']}}</p>
                                    <p class="text-center"><a href="{{url('managelisting')}}">View</a></p>
                                    <p class="text-center">Park & Sell : <span class="text-success">{{$compact_array['parksellcount']}}({{$compact_array['roundofparksell']}})%</span></p>
                                    <p class="text-center">Self Own : <span class="text-success">{{$compact_array['owncount']}}({{$compact_array['roundofown']}})%</span> </p>
                                    <p class="text-center">Sold : <span class="text-success">{{$compact_array['soldcountinventory']}}({{$compact_array['roundofsold']}})%</span></p>
                                </div>


                                <div class="col-5">
                                    <div class="chart chart-doughnut" id="photoselement">
                                        <canvas id="chart-area3" />

                                    </div>
                                    <p class="text-center text-primary text-3x"><i class="fa fa-picture-o"></i></p>
                                    <p class="text-1x text-center text-danger">{{$compact_array['roundofphotos']}}% With Images</p>
                                    <ul class="chart-dot-list">
                                        <li class="a1">Without Images</li>
                                        <li class="a2">All Images</li>
                                        <li class="a3">Less Than 5 Images</li>
                                    </ul>
                                </div>


                                <div class="col-5">
                                    <div class="chart chart-doughnut" id="documentelement">
                                        <canvas id="chart-area6" />
                                    </div>
                                    <p class="text-center text-primary text-3x"><i class="fa fa-file-text"></i></p>
                                    <p class="text-1x text-center text-danger">{{$compact_array['roundofdocuments']}}% With Documents</p>
                                    <ul class="chart-dot-list">
                                        <li class="a1">Without Documents</li>
                                        <li class="a2">All Documents</li>
                                        <li class="a3">Less Than 5 Documents</li>
                                    </ul>
                                </div>

                                <div class="col-5">
                                    <div class="chart chart-doughnut" id="pricingelement">
                                        <canvas id="chart-area5" />
                                    </div>
                                    <p class="text-center text-primary text-3x"><i class="fa fa-money"></i></p>
                                    <p class="text-1x text-center text-danger">Pricing Info</p>
                                    <ul class="chart-dot-list">
                                        <li class="a1">Pricing With Own</li>
                                        <li class="a2">Pricing With Park & Sell</li>
                                    </ul>
                                </div>
                                <div class="col-5">

                                    <div class="chart chart-doughnut" id="inventoryelement">
                                        <canvas id="chart-area4" />

                                    </div>
                                    <p class="text-center text-primary text-3x"><i class="fa fa-sellsy"></i></p>
                                    <p class="text-1x text-center text-danger">Inventory Status</p>
                                    <ul class="chart-dot-list">
                                        @if(isset($compact_array['dyanmicinventorystatus']) && count($compact_array['dyanmicinventorystatus']) >= 0)
                                        @foreach($compact_array['dyanmicinventorystatus'] as $colorlabel)
                                        <li class="dynamic-color{{$colorlabel['color']}}">{{$colorlabel['label']}}</li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="hr-dashed"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Sales Report</div>
                            <div class="panel-body">
                                <div class="col-sm-6">
                                    <h3>Number of Sales <span class="label-success label pull-right">{{$compact_array['countsoldsixmonth']}}</span></h3>
                                    <div class="chart">
                                        <canvas id="dashReport" height="310" width="600"></canvas>
                                    </div>
                                    <div id="legendDiv"></div>
                                </div>
                                <div class="col-sm-6">
                                    <h3>Amount of Sales <span class="label-success label pull-right"><i class="fa fa-rupee"></i>{{$compact_array['soldpriceamount']}}</span></h3>
                                    <div class="chart">
                                        <canvas id="dashReport1" height="310" width="600"></canvas>
                                    </div>
                                    <div id="legendDiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Top Listing</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-9">
                                            <div class="chart chart-doughnut">
                                                <canvas id="chart-area7" width="1200" height="900" />
                                            </div>
                                        </div>
                                        <!--                                        <div class="col-md-4">
                                                                                    <ul class="chart-dot-list">
                                                                                                                                        @if(isset($compact_array['newpiechartdyncolor']) && count($compact_array['newpiechartdyncolor']) >= 0)
                                                                                                                                        @foreach($compact_array['newpiechartdyncolor'] as $colorlabel)
                                                                                                                                                <li class="a{{$colorlabel['color']}}">{{$colorlabel['label']}}</li>
                                                                                                                                        @endforeach
                                                                                                                                        @endif
                                                                                    </ul>
                                                                                </div>-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 chart-progress">
                                            <h3>Total Year Views <span class="label-success label pull-right">{{$compact_array['viewcarscount']}}</span></h3>
                                            <div class="hr-dashed"></div>
                                            @if(!empty($compact_array['newpiechartdyncolor']) && count($compact_array['newpiechartdyncolor']) >= 0)
                                            @foreach($compact_array['newpiechartdyncolor'] as $cardms)
                                            <div class="row">
                                                <div class="col-xs-12"><span>{{$cardms['label']}}</span>
                                                    <p class="label col-md-1 progress-a{{$cardms['color']}} pull-right">{{$cardms['progress']}}%</p>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="progress active" style="display: block;">
                                                        <div class="progress-bar progress-a{{$cardms['color']}}" style="width: {{$cardms['progress']}}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach   
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    @if(!empty($compact_array['carvieweddetails']) && count($compact_array['carvieweddetails']) >= 1)
                                    @foreach($compact_array['carvieweddetails'] as $cardms)
                                    <div class="product-summary summary{{$cardms['id']}}">
                                        <img src="{{$cardms['image']}}" class="img-responsive" alt=''/>
                                        <h4 class='text-center'>{{$cardms['model']}} - {{$cardms['varient']}} - {{$cardms['registration_year']}}</h4>
                                        <p class="list-detail"><span class="text-muted">{{$cardms['kmsdone']}} km</span> | <span class="text-muted">{{$cardms['fuel_type']}}</span> | <span class="text-muted">{{$cardms['registration_year']}}</span> | <span class="text-muted">{{$cardms['owner_type']}} Owner</span></p>
                                        <p class="text-muted">Rs. {{$cardms['price']}}</p>
                                        @foreach($compact_array['newpiechartdyncolor'] as $carcount)
                                        @if($carcount['color'] == $cardms['id'])
                                        <button class="btn progress-a{{$carcount['color']}} btn-sm">Views {{$carcount['countcar']}}</button>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endforeach

                                    @elseif(!empty($compact_array['getalllive']) && count($compact_array['getalllive']) >= 1)
                                    <p class="text-center">None of them viewed your Listings.</p>
                                    @else
                                    <p class="text-center">You have not added any Listings in Live. <a href="managelisting" class="">Please Click Here to post.</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include('footer')
<!-- Loading Scripts -->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/fileinput.js')}}"></script>
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script src="{{URL::asset('js/Chart.min.js')}}"></script>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
          <script src="//code.jquery.com/jquery-1.10.2.js"></script>
          <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
<script>
var swirlData = {
labels: {!!$compact_array['showlastsixmonth']!!},
        datasets: [
        {
        label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: {!!$compact_array['graphsoldcount']!!}
        }
        ]
};
//sold amount graph
var swirlData1 = {
labels: {!!$compact_array['showlastsixmonth']!!},
        datasets: [
        {
        label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: {!!$compact_array['graphsoldamount']!!}
        }
        ]
};
//PHOTOS
var doughnutphotos = [
        {
        value: {{$compact_array['photosnorecordscount']}},
                color:"#F7464A",
                highlight: "#FF5A5E",
                label: "Without Images"
                },
        {
        value: {{$compact_array['photoscountallrecords']}},
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "All Images"
                },
        {
        value: {{$compact_array['photoscountwithfive']}},
                color: "#FDB45C",
                highlight: "#FFC870",
                label: "Less Than 5 Images"
                }
]

function checkvaluesempty(arryobject)
{
    var getvalues   =   new Array();
    for (var index  =   0; index < arryobject.length; ++index) 
    {
        getvalues[index]  =   arryobject[index].value;
    }
    return getvalues;
}

var countphotosvalues    =   checkvaluesempty(doughnutphotos);

function counttotalvalues(arryobject)
{
    var values     =   0;
    for(var index  =   0; index < arryobject.length; ++index) 
    {
        values      +=   arryobject[index];
    }
    return values;
}
var photosvaluesempty   =   counttotalvalues(countphotosvalues);

//DOCUMENTS
        var doughnutdocument = [
        {
        value: {{$compact_array['documentnorecordscount']}},
                color:"#F7464A",
                highlight: "#FF5A5E",
                label: "Without Documents"
        },
        {
        value: {{$compact_array['documentscountallrecords']}},
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "All Documents"
        },
        {
        value: {{$compact_array['documentscountwithfive']}},
                color: "#FDB45C",
                highlight: "#FFC870",
                label: "Less Than 5 Documents"
        }
        ]

var countdocumentvalues =   checkvaluesempty(doughnutdocument);
var documentvaluesempty =   counttotalvalues(countdocumentvalues);
//PRICING
        var doughnutpricing = [
        {
        value: {{$compact_array['parksellcount']}},
                color:"#46BFBD",
                highlight: "#5AD3D1",
                label: "Pricing With Park & Sell"
        },
        {
        value: {{$compact_array['owncount']}},
                color: "#F7464A",
                highlight: "#FF5A5E",
                label: "Pricing With Own"
        }
        ];
var countpricingvalues  =   checkvaluesempty(doughnutpricing);
var pricingvaluesempty  =   counttotalvalues(countpricingvalues);

var pieData = {!!$compact_array['piechart']!!};
var polarData = {!!$compact_array['inventorystatus']!!};
var countinventorystatusvalues  =   checkvaluesempty(polarData);
var inventorystatusempty        =   counttotalvalues(countinventorystatusvalues);
</script>
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>

window.onload = function () {

// Line chart from swirlData for dashReport
var ctx = document.getElementById("dashReport").getContext("2d");
window.myLine = new Chart(ctx).Line(swirlData, {
responsive: true,
        scaleShowVerticalLines: false,
        scaleBeginAtZero: true,
        multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
        });
var ctx = document.getElementById("dashReport1").getContext("2d");
window.myLine = new Chart(ctx).Line(swirlData1, {
responsive: true,
        scaleShowVerticalLines: false,
        scaleBeginAtZero: true,
        multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
        });
// Pie Chart from doughutData
var doctx = document.getElementById("chart-area7").getContext("2d");
window.myDoughnut = new Chart(doctx).Pie(pieData, {responsive: true});
// Dougnut Chart from doughnutData
var doctx = document.getElementById("chart-area3").getContext("2d");
if(photosvaluesempty    ==  0)
{
    document.getElementById("photoselement").innerHTML = "No data !!!";
}
else
{
    window.myDoughnut = new Chart(doctx).Doughnut(doughnutphotos, {responsive: true});    
}
var doctx = document.getElementById("chart-area4").getContext("2d");

if(inventorystatusempty    ==  0)
{
    document.getElementById("inventoryelement").innerHTML = "No data !!!";
}
else
{
    window.myDoughnut = new Chart(doctx).Doughnut(polarData, {responsive: true});
}

var doctx = document.getElementById("chart-area5").getContext("2d");
if(pricingvaluesempty    ==  0)
{
    document.getElementById("pricingelement").innerHTML = "No data !!!";
}
else
{
    window.myDoughnut = new Chart(doctx).Doughnut(doughnutpricing, {responsive: true});
}
var doctx = document.getElementById("chart-area6").getContext("2d");
    if(documentvaluesempty    ==  0)
    {
        document.getElementById("documentelement").innerHTML = "No data !!!";
    }
    else
    {
        window.myDoughnut = new Chart(doctx).Doughnut(doughnutdocument, {responsive: true});
    }
}
</script>
<style>
    .dashbord-home .ts-sidebar:first-child
    {
        display:none;
    }
    .dashbord-home .content-wrapper {
        margin-left: 0px !important;
    }
</style>

</body>

</html>
