<!doctype html>
<html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>DMS</title>

        <!-- Font awesome -->
        <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}">
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-social.css')}}">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-select.css')}}">
        <!-- Bootstrap file input -->
        <link rel="stylesheet" href="{{URL::asset('css/fileinput.min.css')}}">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="{{URL::asset('css/awesome-bootstrap-checkbox.css')}}">
        <!-- Admin Stye -->
        <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">

        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>

    <body>
        @include('header')
        <div class="ts-main-content">
            @include('sidebar')
            <div class="content-wrapper">
                <div class="container-fluid">


                    <div class="row">
                        <div class="content-header col-xs-12">
                            <div class="input-group mb searching col-xs-6"><span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" placeholder="Search here..." ></div>
                            <ol class="breadcrumb">
                                <li><a href="index.html"><i class="fa fa-dashboard"></i> Home</a></li>
                                <li class="active">Mahindra Scorpio</li>
                            </ol>
                        </div>
                        <div class="col-md-12 detail-page">

                            <h2 class="page-title">Car Details</h2>
                            <div class="row detail-top">
                                <div class="col-sm-6"><div id="myCarousel" class="carousel slide" data-ride="carousel">
                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#myCarousel" data-slide-to="1"></li>
                                            <li data-target="#myCarousel" data-slide-to="2"></li>

                                        </ol>

                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner" role="listbox">
                                            <div class="item active">
                                                <img src="{{URL::asset('img/slider.jpg')}}" alt="Chania" width="460" height="345">
                                            </div>

                                            <div class="item">
                                                <img src="{{URL::asset('img/slider.jpg')}}" alt="Chania" width="460" height="345">
                                            </div>

                                            <div class="item">
                                                <img src="{{URL::asset('img/slider.jpg')}}" alt="Flower" width="460" height="345">
                                            </div>
                                        </div>

                                        <!-- Left and right controls -->

                                    </div></div>
                                <input type="hidden" name="id" value="{{$update->car_id}}">
                                <input type="hidden" name="dealer_id" value="{{$update->dealer_id}}">
                                <div class="col-sm-6">
                                    <div class="col-sm-12"><h2 class="page-title">{{$update->make}}</h2>
                                        <p class="text-primary pull-right"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p>
                                        <p class="detail-rate">{{$update->max_exp_price}} - {{$update->min_exp_price}}</p>
                                        <!-- Button trigger modal -->
                                        <div class="pull-left"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-phone"></i>
                                                Contact Dealer
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Contact Dealer</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="get" class="form-horizontal">
                                                                <div class="form-group">
                                                                    <div class="col-sm-10 col-sm-offset-1">
                                                                        <input type="text" placeholder="Name" name="contact_dealer_name" id="contact_dealer_name" class="form-control">
                                                                        <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-sm-10 col-sm-offset-1">
                                                                        <input type="mail" placeholder="Mail Id" name="contact_dealer_mailid" id="contact_dealer_mailid" class="form-control">
                                                                    </div></div>
                                                                <div class="form-group">
                                                                    <div class="col-sm-10 col-sm-offset-1">
                                                                        <textarea placeholder="Enter Your Message" name="contact_dealer_message" id="contact_dealer_message" class="form-control"></textarea>
                                                                    </div></div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="contact_dealer_button" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></div><div class="pull-right">
                                            <ul class="detail-share"><li><a href="#"><i class="fa fa-share" title="share"></i></a></li>
                                                <li><a href="#"><i class="fa fa-film" title="video"></i></a></li></ul>
                                        </div>


                                    </div>
                                </div>

                            </div>		
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Engine<span class="pull-right detail-icon"><i class="fa fa-safari"></i></span></h3>

                                        </div>
                                        <div class="panel-body">
                                            <div class="row"><div class="col-xs-6">Model:</div><div class="col-xs-6">{{$update->model}}</div>
                                                <div class="col-xs-6">Fuel:</div><div class="col-xs-6">{{$update->fuel_capacity}}</div>
                                                <div class="col-xs-6">Owner:</div><div class="col-xs-6">{{$update->owner_type}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Dimension<span class="pull-right detail-icon"><i class="fa fa-paper-plane"></i></span></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row"><div class="col-xs-6">Color:</div><div class="col-xs-6">{{$update->colors}}</div>
                                                <div class="col-xs-6">Transmission:</div><div class="col-xs-6">{{$update->transmission}}</div>
                                                <div class="col-xs-6">Kilometer:</div><div class="col-xs-6">{{$update->kilometer_run}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Comfort<span class="pull-right detail-icon"><i class="fa fa-automobile"></i></span></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row"><div class="col-xs-6">Body:</div><div class="col-xs-6">{{$update->body_type}}</div>
                                                <div class="col-xs-6">Seats:</div><div class="col-xs-6">{{$update->seatingcapacity}}</div>
                                                <div class="col-xs-6">AC:</div><div class="col-xs-6">Available</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Safety<span class="pull-right detail-icon"><i class="fa fa-user-secret"></i></span></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row"><div class="col-xs-6">Air Bag:</div><div class="col-xs-6">
                                                    @if($update->airbag==1)
                                                    yes
                                                    @else
                                                    NO
                                                    @endif
                                                </div>
                                                <div class="col-xs-6">Mileage:</div><div class="col-xs-6">{{$update->mileage}}</div>
                                                <div class="col-xs-6">Lock:</div><div class="col-xs-6">NO</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Details Overview</div>
                                        <div class="panel-body">
                                            <ul class="nav nav-tabs">
                                                <li><a href="#overview" data-toggle="tab" aria-expanded="false">Overview</a></li>
                                                <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">FEATURES & SPECIFICATIONS</a></li>
                                                <li><a href="#review" data-toggle="tab" aria-expanded="true">Reviews</a></li>
                                                <li><a href="#feature" data-toggle="tab" aria-expanded="true">Features</a> 
                                                </li>
                                            </ul>
                                            <br>
                                            <div id="myTabContent" class="tab-content">
                                                <div class="tab-pane fade" id="overview">
                                                    <p>The Mahindra Scorpio is a four-wheel drive compact SUV manufactured by Mahindra & Mahindra Limited, the flagship company of the Indian Mahindra Group. It was the first SUV from the company built for a global market. The Scorpio has been successfully accepted in international markets across the globe, and will shortly be launched in the United States.</p>
                                                    <p>The Scorpio was conceptualized and designed by the in-house integrated design and manufacturing team of M&M. The car has been the recipient of t</p>
                                                </div>
                                                <div class="tab-pane fade active in" id="profile">
                                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingOne">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        Engine
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                                <div class="panel-body">

                                                                    4 cylinder mHawk CRDe diesel engine                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                                <h4 class="panel-title">
                                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                        Weight
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                                <div class="panel-body">
                                                                    1850kg
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingThree">
                                                                <h4 class="panel-title">
                                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                        Transmiison
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                                <div class="panel-body">
                                                                    Manual
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="review">
                                                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
                                                </div>
                                                <div class="tab-pane fade" id="feature">
                                                    <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading"><span><i class="fa fa-mobile"></i></span> Dealer Contact</div>
                                        <div class="panel-body">
                                            <div class="col-sm-3"><h3>{{$update->car_owner_name}}</h3></div>
                                            <div class="col-sm-3"><ul class="detail-cont"><li><i class="fa fa-map-marker"></i></li><li>{{$update->car_address_1}}</li></ul></div>
                                            <div class="col-sm-3"><ul  class="detail-cont"><li><i class="fa fa-envelope-o"></i></li><li>{{$update->car_owner_email}}</li></ul></div>
                                            <div class="col-sm-3"><ul  class="detail-cont"><li><i class="fa fa-phone"></i></li><li>{{$update->car_owner_mobile}}</li></ul></div>
                                        </div>
                                    </div>
                                </div></div>	
                            <div class="row">
                                <div class="clearfix pt pb">
                                    <div class="col-md-12">
                                        <em>Designed by <a href="#">Falconnect</a></em>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Loading Scripts -->
                <script src="{{URL::asset('js/jquery.min.js')}}"></script>
                <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
                <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
                <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
                <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
                <script src="{{URL::asset('js/Chart.min.js')}}"></script>
                <script src="{{URL::asset('js/fileinput.js')}}"></script>
                <script src="{{URL::asset('js/chartData.js')}}"></script>
                <script type="text/javascript">
        $(document).ready(function () {
            $("#contact_dealer_button").click(function () {
                var contact_dealer_name = $("#contact_dealer_name").val();
                var contact_dealer_message = $("#contact_dealer_message").val();
                var contact_dealer_mailid = $("#contact_dealer_mailid").val();
                var car_id = $("#car_id").val();
                var dealer_id = $("#dealer_id").val();
                var csrf_token = $('#token').val();
                //alert(csrf_token);
                $.ajax({
                    type: 'POST',
                    url: "{{url('ajaxcontactdealermessage')}}",
                    data: {_token: csrf_token, 'contact_dealer_name': contact_dealer_name, 'contact_dealer_message': contact_dealer_message, 'contact_dealer_mailid': contact_dealer_mailid, 'car_id': car_id, 'dealer_id': dealer_id}, //
                    //dataType:'JSON',
                    success: function (response)
                    {
                        alert(response);
                    },
                    error: function (jqxhr) {
                        //alert(jqxhr.responseText); // @text = response error, it is will be errors: 324, 500, 404 or anythings else
                        console.log(jqxhr.responseText);
                    }
                });
            });
        });
                </script>

                </body>

                </html>