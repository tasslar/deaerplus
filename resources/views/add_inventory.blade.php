@include('header')
@include('sidebar')
<div class="content-wrapper add-product">  
    <div class="container-fluid">
        <div class="content-header col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{url('managelisting')}}"><i class="fa fa-dashboard"></i> Sell</a></li>
                <li class="active">Add Listing</li>
            </ol>
        </div>
        <!--        <div class="col-md-12" id="headerdata">
                    {{$listing_headerdata['modelname']}} {{$listing_headerdata['variant_name']}} {{$listing_headerdata['registration_year']}}
                    {{$listing_headerdata['colour_name']}} -  {{$listing_headerdata['car_city']}}
                    Rs. {{$listing_headerdata['price']}} @if($listing_headerdata['listing_status']==0) <a href="{{url('add_listing_tab')}}/{{$dp_listid}}">Edit </a> @endif
                </div>-->
        <div class="col-md-12" id="errormsg"></div>
        <div class="col-md-12">
            <h2 class="page-title">Additional Info - <span id="headerdata">{{$listing_headerdata['modelname']}} {{$listing_headerdata['variant_name']}} {{$listing_headerdata['registration_year']}}
                    {{$listing_headerdata['colour_name']}} -  {{$listing_headerdata['car_city']}}
                    Rs. {{$listing_headerdata['price']}}</span>
                <span> @if($listing_headerdata['listing_status']==0) <a  class="pull-right btn btn-primary btn-sm edit-inv" href="{{url('add_listing_tab')}}/{{$dp_listid}}">Edit </a> @endif</span>
            </h2>
            <br/>

            <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
            <div class="row">
<!--                <div class="col-sm-6 col-sm-offset-6">
                        <div class="progress progress-striped active" style="display: block;">
                                                                            <div class="progress-bar" style="width: 45%">45%</div>
                                                                        </div>
                    <div class="progress progress-complete">
                        <div class="progress-bar progress-bar-success" style="width: 40%">
                            <span>Basic Info (40%)</span>
                        </div>
                        <div class="progress-bar  progress-bar-warning" style="width: 25%">
                            <span>Pricing (25%)</span>
                        </div>
                        <div class="progress-bar progress-bar-danger" style="width: 15%">
                            <span>Images (15%)</span>
                        </div>
                    </div>
                </div>-->
                <div class="col-md-12">
                    <div class="panel panel-primary">

                        <ul class="nav nav-tabs tab-inventory-info">

                            <li @if($listing_headerdata['listing_status']==0) class="active" @endif>
                                 <a href="#uploadimages1" id="uploadimagestab" data-toggle="tab" class="" aria-expanded="true">Images</a>
                            </li>
                            <!-- <li>
                                <a href="#uploadvideos1" id="uploadvideostab" data-toggle="tab" class="" onclick="tabchange('uploadvideostab','uploadvideos');" aria-expanded="true">Videos</a>
                            </li> -->
                            <li>
                                <a href="#uploaddocuments1" id="uploaddocumentstab" data-toggle="tab" class="" aria-expanded="true">Documents</a> 
                            </li>
                            <!-- <li>
                                <a href="#pricinginfo1" id="pricinginfotab" data-toggle="tab" class="" onclick="tabchange('pricinginfotab','pricinginfo');" aria-expanded="true">Pricing Information*</a> 
                            </li> -->
                            <li>
                                <a href="#certificationwarranty1" id="certificationwarrantytab" class="" data-toggle="tab" aria-expanded="true">Certification, Inspection &amp; Warranty</a> 
                            </li>
                            <li>
                                <a href="#engineandspecific1" id="engineandspecifictab" class="" data-toggle="tab" aria-expanded="true">Engine &amp; Specification</a> 
                            </li>

                            <li @if($listing_headerdata['listing_status']==1) class="active" @endif>
                                 <a href="#portals1" id="portalstab" data-toggle="tab" aria-expanded="true" class="">Online Portals</a> 
                            </li>

                        </ul>
                        <br>
                        <div id="myTabContent" class="tab-content">
                            @if($listing_headerdata['listing_status']==0)
                            <div class="tab-pane fade in active disablebutton" id="uploadimages">
                                @else
                                <div class="tab-pane fade disablebutton" id="uploadimages">
                                    @endif


                                    <div class="panel-body">
                                        <form id="inventry-images" method="post" enctype="multipart/form-data">

                                            <input class="inputfile filecount" type="hidden" value=""/>
                                            <div class="form-group col-xs-12 col-sm-12">
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit1"  name="inventry_image[profile_pic]" data-value="1" id="uploadimage1" image_type="profile_pic" accept=".png, .jpg, .jpeg" onclick="fun('imageedit1', 'myImg1', 'profile_pic')" />
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i1 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'profile_pic')
                                                    <?php $i1++; ?>
                                                    <img id="myImg1" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i1==0)
                                                    <img id="myImg1" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg1" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Profile Pic</label>
                                                    

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit2" name="inventry_image[front_view]" data-value="2" id="uploadimage2"  accept=".png, .jpg, .jpeg" onclick="fun('imageedit2', 'myImg2', 'front_view')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i2 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'front_view')
                                                    <?php $i2++; ?>
                                                    <img id="myImg2" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i2==0)
                                                    <img id="myImg2" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg2" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Front View (bumper, bonnet, fr-windshield,headlights, grill)</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit3" name="inventry_image[front_wind]" data-value="3" id="uploadimage3"  accept=".png, .jpg, .jpeg" onclick="fun('imageedit3', 'myImg3', 'front_wind')"/>
                                                    <input class="inputfile inputfile-5" type="file"/>
                                                    <?php $i3 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'front_wind')
                                                    <?php $i2++; ?>
                                                    <img id="myImg3" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i3==0)
                                                    <img id="myImg3" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg3" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Front Windscreen</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit4" name="inventry_image[front_underbody]" data-value="4" id="uploadimage4"  accept=".png, .jpg, .jpeg" onclick="fun('imageedit4', 'myImg4', 'front_underbody')"/>
                                                    <input class="inputfile inputfile-5" type="file"/>
                                                    <?php $i4 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'front_underbody')
                                                    <?php $i2++; ?>
                                                    <img id="myImg4" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i4==0)
                                                    <img id="myImg4" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg4" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Front Underbody</label>
                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit5" name="inventry_image[right_side]" data-value="5" id="uploadimage5" accept=".png, .jpg, .jpeg" onclick="fun('imageedit5', 'myImg5', 'right_side')"/>
                                                    <input class="inputfile inputfile-5" type="file"/>
                                                    <?php $i5 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'right_side')
                                                    <?php $i5++; ?>
                                                    <img id="myImg5" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i5==0)
                                                    <img id="myImg5" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg5" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Right Side (fender, doors, qtr panel)</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit6" name="inventry_image[Right_quarter]" data-value="6" id="uploadimage6" accept=".png, .jpg, .jpeg" onclick="fun('imageedit6', 'myImg6', 'Right_quarter')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i6 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'Right_quarter')
                                                    <?php $i6++; ?>
                                                    <img id="myImg6" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i5==0)
                                                    <img id="myImg6" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg6" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Right Quarter Panel</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit7" name="inventry_image[front_right]"  data-value="7" id="uploadimage7" accept=".png, .jpg, .jpeg" onclick="fun('imageedit7', 'myImg7', 'front_right')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i6 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'front_right')
                                                    <?php $i6++; ?>
                                                    <img id="myImg7" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i5==0)
                                                    <img id="myImg7" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg7" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Front Right Side Interior View</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit8" name="inventry_image[rear]" data-value="8" id="uploadimage8" accept=".png, .jpg, .jpeg" onclick="fun('imageedit8', 'myImg8', 'rear')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i8 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'rear')
                                                    <?php $i8++; ?>
                                                    <img id="myImg8" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i8==0)
                                                    <img id="myImg8" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg8" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Rear (bumper, dicky door, rr-windshield, tail lights)</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit9" name="inventry_image[left_side]"  data-value="9" id="uploadimage9" accept=".png, .jpg, .jpeg" onclick="fun('imageedit9', 'myImg9', 'left_side')"/>
                                                    <input class="inputfile inputfile-5" type="file"/>
                                                    <?php $i9 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'left_side')
                                                    <?php $i9++; ?>
                                                    <img id="myImg9" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i9==0)
                                                    <img id="myImg9" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg9" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Left Side (fender, doors, qtr Panel)</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit10" name="inventry_image[left_quarter]" data-value="10" id="uploadimage10" accept=".png, .jpg, .jpeg" onclick="fun('imageedit10', 'myImg10', 'left_quarter')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i10 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'left_quarter')
                                                    <?php $i10++; ?>
                                                    <img id="myImg10" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i10==0)
                                                    <img id="myImg10" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg10" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Left Quarter Panel</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit11" name="inventry_image[engine_compartment]" data-value="11" id="uploadimage11" accept=".png, .jpg, .jpeg" onclick="fun('imageedit11', 'myImg11', 'engine_compartment')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i11 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'engine_compartment')
                                                    <?php $i11++; ?>
                                                    <img id="myImg11" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i11==0)
                                                    <img id="myImg11" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg11" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Engine Compartment</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit12" name="inventry_image[dashboard]" data-value="12" id="uploadimage12" accept=".png, .jpg, .jpeg" onclick="fun('imageedit12', 'myImg12', 'dashboard')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i12 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'dashboard')
                                                    <?php $i12++; ?>
                                                    <img id="myImg12" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i12==0)
                                                    <img id="myImg12" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg12" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Dashboard ( from rear seat)</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit13" name="inventry_image[odometer]" data-value="13" id="uploadimage13" accept=".png, .jpg, .jpeg" onclick="fun('imageedit13', 'myImg13', 'odometer')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i13 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'odometer')
                                                    <?php $i13++; ?>
                                                    <img id="myImg13" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i13==0)
                                                    <img id="myImg13" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg13" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Odometer Reading (with engine on from driver seat)</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit14" name="inventry_image[ABCpedals]" data-value="14" id="uploadimage14" accept=".png, .jpg, .jpeg" onclick="fun('imageedit14', 'myImg14', 'ABCpedals')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i14 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'ABCpedals')
                                                    <?php $i14++; ?>
                                                    <img id="myImg14" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i14==0)
                                                    <img id="myImg14" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg14" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">ABC Pedals ( from driver seat)</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit15" name="inventry_image[frontdoor]" data-value="15" id="uploadimage15" accept=".png, .jpg, .jpeg" onclick="fun('imageedit15', 'myImg15', 'frontdoor')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i15 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'frontdoor')
                                                    <?php $i15++; ?>
                                                    <img id="myImg15" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i15==0)
                                                    <img id="myImg15" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg15" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Front Door Trim</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit16" name="inventry_image[frontright_tyre]" data-value="16" id="uploadimage16" accept=".png, .jpg, .jpeg" onclick="fun('imageedit16', 'myImg16', 'frontright_tyre')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i16 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'frontright_tyre')
                                                    <?php $i16++; ?>
                                                    <img id="myImg16" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i16==0)
                                                    <img id="myImg16" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg16" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif    
                                                    <label class="img-lab">Front Right Tyre</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit17" name="inventry_image[rearright_tyre]"  data-value="17" id="uploadimage17" accept=".png, .jpg, .jpeg" onclick="fun('imageedit17', 'myImg17', 'rearright_tyre')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i17 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'rearright_tyre')
                                                    <?php $i17++; ?>
                                                    <img id="myImg17" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i17==0)
                                                    <img id="myImg17" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg17" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Rear Right Tyre</label>


                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit18" name="inventry_image[Boot_Dicky]" data-value="18" id="uploadimage18" accept=".png, .jpg, .jpeg" onclick="fun('imageedit18', 'myImg18', 'Boot_Dicky')" />
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i18 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'Boot_Dicky')
                                                    <?php $i18++; ?>
                                                    <img id="myImg18" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i18==0)
                                                    <img id="myImg18" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg18" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Boot / Dicky</label>

                                                </div>
                                                <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit19" name="inventry_image[FrontLeft_Tyre]" data-value="19" id="uploadimage19" accept=".png, .jpg, .jpeg" onclick="fun('imageedit19', 'myImg19', 'FrontLeft_Tyre')"/>
                                                    <input class="inputfile inputfile-5" type="file" />
                                                    <?php $i19 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'FrontLeft_Tyre')
                                                    <?php $i19++; ?>
                                                    <img id="myImg19" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i19==0)
                                                    <img id="myImg19" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg19" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Front Left Tyre</label>

                                                </div>
                                                <!-- <div class="col-sm-4 imge-add">
                                                    <input class="myclass imageedit20" name="inventry_image[Odometer_reading]" data-value="20" id="uploadimage20" accept=".png, .jpg, .jpeg" onclick="fun('imageedit20', 'myImg20', 'Odometer_reading')"/>
                                                    <input class="inputfile inputfile-5" type="file" />

                                                    <?php $i20 = 0; ?>
                                                    @if(count($list_images)> 0)
                                                    @foreach($list_images as $value)
                                                    @if($value->profile_pic_name == 'Odometer_reading')
                                                    <?php $i20++; ?>
                                                    <img id="myImg20" src="{{$value->s3_bucket_path}}" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @endforeach
                                                    @if($i20==0)
                                                    <img id="myImg20" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    @else
                                                    <img id="myImg20" src="" class="img-responsive">
                                                    <span class="upload-img"><i class="fa fa-upload"></i><br/>Click to Upload</span>
                                                    @endif
                                                    <label class="img-lab">Odometer Reading (with engine on from driver seat)</label>                          

                                                </div> -->
                                            </div>

                                            <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                            <!--  <div class="col-xs-12 col-sm-4">
                                                 
                                         <div class="addimage">
                                             <div class="form-group">
                                                 <div>
                                                     <img src="http://52.221.57.201/dev/public/img/noimage.jpg" class="image">
                                                    </div>
                                             </div> 
                                         </div>
                                         <div class="fileUpload btn-primary">
                                             <span>Apply this as Water mark for all images</span>
                                             
                                         </div>
                                         
                                             
                                     
                                             </div> -->
                                            <div class="add-list-buttons">
                                                <div class="comm-button">
                                                    <a href="#collapseThree" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseThree">
                                                        <button type="submit" id="upload_images" name="uploadimages"  data-specific='save' class="btn btn-circle btn-lg btn-primary upload_images" data-toggle="tooltip" data-original-title="Save" data-placement="left"><i class="fa fa-save"></i></button>
                                                    </a> 
                                                </div>
                                                <div class="comm-button">
                                                    <a href="#collapseThree" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseThree">
                                                        <button type="button" id="upload_images" name="uploadimages"  data-specific='next' class="btn btn-circle btn-lg btn-primary upload_images" data-toggle="tooltip" data-original-title="Next" data-placement="left"><i class="fa fa-arrow-right"></i></button>
                                                    </a> 
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade disablebutton" id="uploaddocuments">
                                    <form method="post" id="dealer_form" enctype="multipart/form-data">
                                        <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                        <div class="col-sm-12 documentuplodsize"></div>
                                        <p class="col-xs-12">* Maximum File Size 2MB</p>
                                        <div class="panel-body">

                                            <div class="col-sm-12 document">
                                                <div class="col-sm-3">
                                                    <label>RC</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="hidden" name="document_first" value="0"/>
                                                    <input type="file" name="dd_documents[0]" id="rcupload" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                </div>
                                                <div class="col-sm-3 prog-onile">
                                                    <div class="active rcdocuments">
                                                        @if(!empty($document_images))
                                                        @foreach($document_images as $image_value)
                                                        @if($image_value->document_number==0)
                                                        <a href="{{$image_value->s3_bucket_path}}" download="download">Download</a>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-12 document">
                                                <div class="col-sm-3">
                                                    <label>Insurance</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="hidden" name="document_second" value="1"/>
                                                    <input type="file" name="dd_documents[1]" id="insuranceupload" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                </div>
                                                <div class="col-sm-3 prog-onile">
                                                    <div class="active insurancedocuments">
                                                        @if(!empty($document_images))
                                                        @foreach($document_images as $image_value)
                                                        @if($image_value->document_number==1)
                                                        <a href="{{$image_value->s3_bucket_path}}" download="download">Download</a>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 document">
                                                <div class="col-sm-3">
                                                    <label>RTO</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="hidden" name="document_third" value="2"/>
                                                    <input type="file" name="dd_documents[2]" id="rtoupload" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                </div>
                                                <div class="col-sm-3 prog-onile">
                                                    <div class="active rtodocuments">
                                                        @if(!empty($document_images))
                                                        @foreach($document_images as $image_value)
                                                        @if($image_value->document_number==2)
                                                        <a href="{{$image_value->s3_bucket_path}}" download="download">Download</a>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 document">
                                                <div class="col-sm-3">
                                                    <label>FC</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="hidden" name="document_fourth" value="3"/>
                                                    <input type="file" name="dd_documents[3]" id="fcupload" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                </div>
                                                <div class="col-sm-3 prog-onile">
                                                    <div class="active fcdocuments">
                                                        @if(!empty($document_images))
                                                        @foreach($document_images as $image_value)
                                                        @if($image_value->document_number==3)
                                                        <a href="{{$image_value->s3_bucket_path}}" download="download">Download</a>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 document">
                                                <div class="col-sm-3">
                                                    <label>NOC</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="hidden" name="document_fifth" value="4"/>
                                                    <input type="file" name="dd_documents[4]" id="nocupload" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                </div>
                                                <div class="col-sm-3 prog-onile">
                                                    <div class="active nocdocuments">
                                                        @if(!empty($document_images))
                                                        @foreach($document_images as $image_value)
                                                        @if($image_value->document_number==4)
                                                        <a href="{{$image_value->s3_bucket_path}}" download="download">Download</a>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 document">
                                                <div class="col-sm-3">
                                                    <label>Permit Document</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="hidden" name="document_sixth" value="5"/>
                                                    <input type="file" name="dd_documents[5]" id="permitupload" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                </div>
                                                <div class="col-sm-3 prog-onile">
                                                    <div class=" active permitdocuments">
                                                        @if(!empty($document_images))
                                                        @foreach($document_images as $image_value)
                                                        @if($image_value->document_number==5)
                                                        <a href="{{$image_value->s3_bucket_path}}" download="download">Download</a>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <h4 class="page-title1">Hypotication</h4>
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Hypothacation Type</label>
                                                            <input class="form-control" name="hypothacation_type" placeholder="Hypothacation Type" type="text" @if(count($dealer_hypothacation)>0)  value="{{$dealer_hypothacation[0]->hypothacation_type}}" @endif>
                                                    </div>     </div>      
                                                <div class="col-xs-12">
                                                    <div class="form-group field-wrapper1">
                                                        <label class="show">Finacier Name</label>
                                                        <input class="form-control" name="finacier_name" placeholder="Finacier Name" type="text" @if(count($dealer_hypothacation)>0)  value="{{$dealer_hypothacation[0]->finacier_name}}" @endif>
                                                    </div>
                                                </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Full Name of Finacier</label>
                                                        <input class="form-control" name="fla_finacier_name" placeholder="Full Name of Finacier" type="text" @if(count($dealer_hypothacation)>0)  value="{{$dealer_hypothacation[0]->fla_finacier_name}}" @endif>
                                                    </div>     </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1 input-group  date" id="datetimepickerfromdate">
                                                        <label>From Date</label>
                                                        <input class="form-control" name="from_date" placeholder="From Date" type="text" @if(count($dealer_hypothacation)>0)  value="{{$dealer_hypothacation[0]->from_date}}" @endif>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>     
                                                </div>                                                 
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <h4 class="page-title1">Insurance</h4>
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Insurance company</label>
                                                            <input class="form-control" name="comp_cd_desc" placeholder="Insurance company" type="text" @if(count($dealer_insurance)>0)  value="{{$dealer_insurance[0]->comp_cd_desc}}" @endif>
                                                    </div>     </div>      
                                                <div class="col-xs-12">
                                                    <div class="form-group field-wrapper1">
                                                        <label class="show">Insurance Name</label>
                                                        <input class="form-control" name="fla_insurance_name" placeholder="Insurance Name" type="text"  @if(count($dealer_insurance)>0)  value="{{$dealer_insurance[0]->fla_insurance_name}}" @endif>
                                                    </div>
                                                </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Insurance_Type Desc</label>
                                                        <input class="form-control" name="insurance_type_desc" placeholder="Insurance_Type Desc" type="text" @if(count($dealer_insurance)>0)  value="{{$dealer_insurance[0]->insurance_type_desc}}" @endif>
                                                    </div>     </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1 input-group date" id="datetimepickerinsurancefrom">
                                                        <label>Insurance From</label>
                                                        <input class="form-control" name="insurance_from" placeholder="Insurance From"  type="text" @if(count($dealer_insurance)>0)  value="{{$dealer_insurance[0]->insurance_from}}" @endif>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>     
                                                </div> 
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1 input-group  date" id="datetimepickerinsuranceupto">
                                                        <label>Insurance Upto</label>
                                                        <input type="text" class="form-control" name="insurance_upto" placeholder="Insurance Upto" @if(count($dealer_insurance)>0)  value="{{$dealer_insurance[0]->insurance_upto}}" @endif>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>     
                                                </div>                                                 
                                            </div>
                                            <div class="add-list-buttons">
                                                <div class="comm-button">
                                                    <button class="btn btn-primary btn-circle btn-lg backtoimages" data-toggle="tooltip" data-original-title="Back" data-placement="left" type="button"><i class="fa fa-arrow-left"></i></button>
                                                </div>
                                                <!-- #collapseFour -->
                                                <div class="comm-button">
                                                    <a href="" data-toggle="collapse" data-parent="#accordion"  aria-expanded="false" aria-controls="collapseFour">
                                                        <button type="button" class="btn btn-primary btn-circle btn-lg vehicle_document" data-toggle="tooltip" data-original-title="Save" data-placement="left" data-specific='save'><i class="fa fa-save"></i></button>
                                                    </a>
                                                </div>
                                                <div class="comm-button">
                                                    <button type="button" class="btn btn-primary btn-circle btn-lg vehicle_document" data-toggle="tooltip" data-original-title="Next" data-placement="Next" data-specific='next'><i class="fa fa-arrow-right"></i></button>
                                                </div>
                                            </div>


                                        </div> </form>
                                </div>

                                <div class="tab-pane fade disablebutton" id="certificationwarranty">
                                    <div class="panel-body">
                                        <form id="certificationwarrantyform">
                                            <div class="col-xs-12 col-sm-6">
                                                <h4 class="page-title1">Certification Report</h4>
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Inspection Agency</label>
                                                        <select class="form-control" name="inspectionagency">
                                                            <option value="" @if(count($dealer_certification)>0) @if($dealer_certification[0]->inspectionagency=='') {{'selected'}} @endif @endif>Inspection Agency</option>
                                                            <option value="1" @if(count($dealer_certification)>0) @if($dealer_certification[0]->inspectionagency==1) {{'selected'}} @endif @endif>Self</option>
                                                            <option value="2" @if(count($dealer_certification)>0) @if($dealer_certification[0]->inspectionagency==2) {{'selected'}} @endif @endif>TrustMark</option>
                                                            <option value="3" @if(count($dealer_certification)>0) @if($dealer_certification[0]->inspectionagency==3) {{'selected'}} @endif @endif>Others</option>

                                                        </select>
                                                    </div>     </div>      
                                                <div class="col-xs-12">
                                                    <div class="form-group field-wrapper1 input-group date" id='datetimepicker5'>
                                                        <!-- <label>Inspection Date</label> -->
                                                        <input type='text' class="form-control" name="inspectiondate" placeholder="Inspection Date" @if(count($dealer_certification)>0)  value="{{$dealer_certification[0]->inspectiondate}}" @else value="{{$date}}"  @endif/>
                                                               <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Certificate Id</label>
                                                        <input type="text" class="form-control" name="certificateid" placeholder="Certificate Id" @if(count($dealer_certification)>0)  value="{{$dealer_certification[0]->certificateid}}"  @endif>
                                                    </div>     </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Certificate Url</label>
                                                        <input type="text" class="form-control" name="certificateurl" placeholder="Certificate Url" @if(count($dealer_certification)>0)  value="{{$dealer_certification[0]->certificateurl}}"  @endif>
                                                    </div>     </div> 
                                                <div class="col-xs-12 document">

                                                    <label>Certificate Report</label>
                                                    <input type="file" name="certificatereport" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                    
                                                    <span id="certificatedownload">
                                                        @if(count($dealer_certification)>0)  
                                                            <a href="{{$dealer_certification[0]->certificatereport}}" download="download">Download</a>
                                                        @endif
                                                    </span>
                                                  
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <h4 class="page-title1">Service Warranty Report</h4>
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Service Agency</label>
                                                        <select class="form-control"  name="serviceagency">
                                                            <option value="" @if(count($dealer_certification)>0)  @if($dealer_certification[0]->serviceagency=='') {{'selected'}} @endif  @endif>Service Agency</option>
                                                            <option value="1" @if(count($dealer_certification)>0)  @if($dealer_certification[0]->serviceagency==1) {{'selected'}} @endif  @endif>Self</option>
                                                            <option value="2" @if(count($dealer_certification)>0)  @if($dealer_certification[0]->serviceagency==2) {{'selected'}} @endif  @endif>Others</option>

                                                        </select>
                                                    </div>     </div>      
                                                <div class="col-xs-12">
                                                    <div class="form-group field-wrapper1 input-group date" id='datetimepicker5'>
                                                        <label>Last Service Date</label>
                                                        <input type='text' class="form-control"  name="servicedate" placeholder="Inspection Date" @if(count($dealer_certification)>0)  value="{{$dealer_certification[0]->servicedate}}"  @endif/>
                                                               <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Certificate Id</label>
                                                        <input type="text" class="form-control" name="serviceid" placeholder="Certificate Id" @if(count($dealer_certification)>0)  value="{{$dealer_certification[0]->serviceid}}"  @endif>
                                                    </div>     </div>   
                                                <div class="col-xs-12">  
                                                    <div class="form-group field-wrapper1">
                                                        <label>Certificate Url</label>
                                                        <input type="text" class="form-control" name="serviceurl" placeholder="Certificate Url" @if(count($dealer_certification)>0&&$dealer_certification[0]->servicereport!='') value="{{$dealer_certification[0]->serviceurl}}"  @endif>
                                                    </div>     </div> 
                                                <div class="col-xs-12 document">

                                                    <label>Certificate Report</label>

                                                    <input type="file" name="servicereport" class="BSbtninfo fileuploadrestriction" data-size='2'/>
                                                    <span id="servicedownload">
                                                        @if((count($dealer_certification)>0)&&$dealer_certification[0]->servicereport!='')  
                                                            <a href="{{$dealer_certification[0]->servicereport}}" download="download">Download</a>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="add-list-buttons">

                                                <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                <div class="comm-button">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        <button class="btn btn-primary btn-circle btn-lg backtodocuments" data-toggle="tooltip" data-original-title="Back" data-placement="left" type="button"><i class="fa fa-arrow-left"></i></button></a>
                                                </div>
                                                <div class="comm-button">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        <button type="submit" class="btn btn-primary btn-circle btn-lg update_certificationwarranty_list" data-toggle="tooltip" data-original-title="Save" data-placement="left" data-specific='save'><i class="fa fa-save"></i></button>      </a>  
                                                </div>       
                                                <div class="comm-button">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        <button class="btn btn-primary btn-circle btn-lg update_certificationwarranty_list" type="submit" data-toggle="tooltip" data-original-title="Next" data-placement="left" data-specific="next"><i class="fa fa-arrow-right"></i></button></a>
                                                </div>
                                            </div>                                  

                                        </form>
                                    </div>
                                </div>

                                <div class="tab-pane fade disablebutton" id="engineandspecific">
                                    <div class="panel-body">
                                        <form id="engineandspecification">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#specification" data-toggle="tab" aria-expanded="true">SPECIFICATIONS</a></li>
                                                <li><a href="#feature" data-toggle="tab" aria-expanded="true">Features</a></li>
                                                <li><a href="#overview" data-toggle="tab" aria-expanded="false">Overview</a></li>

                                            </ul>
                                            <div id="myTabContent" class="tab-content">
                                                <div class="tab-pane fade" id="overview">
                                                    @if(count($dealer_listing_features)>0)
                                                    <textarea id="overviewdesc" class="overviewdesc" name="overviewdesc">{{$dealer_listing_features[0]->overviewdescription}}</textarea>
                                                    @else
                                                    <textarea id="overviewdesc" class="overviewdesc" name="overviewdesc"></textarea>
                                                    @endif


                                                </div>

                                                <div class="tab-pane fade  active in " id="specification">
                                                    <!-- Specification Start Accordion Start -->
                                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingOne">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="accordion">
                                                                        Car Specification
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <?php
                                                                                    $featuresshow = '';
                                                                                    if (count($dealer_listing_features) > 0) {
                                                                                        $featuresshow = 'show';
                                                                                    }
                                                                                    ?>

                                                                                    <label class="{{$featuresshow}}">Gear Box</label>
                                                                                    <input type="text" class="form-control gear_box specialchar" name="gear_box" placeholder="Gear Box" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->gear_box}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Drive type</label>
                                                                                    <input type="text" class="form-control drive_type specialchar" name="drive_type" placeholder="Drive type">                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Seating Capacity</label>
                                                                                    <input type="text" class="form-control seating_capacity specialchar" name="seating_capacity" placeholder="Seating Capacity" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->seating_capacity}}'
                                                                                           @endif>                                                 
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Steering type</label>
                                                                                    <input type="text" class="form-control steering_type specialchar" name="steering_type" placeholder="Steering type">                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Turning Radius</label>
                                                                                    <input type="text" class="form-control turning_radius specialchar" name="turning_radius" placeholder="Turning Radius" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->turning_radius}}'
                                                                                           @endif>                                               
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Top Speed</label>
                                                                                    <input type="text" class="form-control top_speed specialchar" name="top_speed" placeholder="Top Speed" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->top_speed}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Acceleration</label>
                                                                                    <input type="text" class="form-control acceleration specialchar" name="acceleration" placeholder="Acceleration" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->acceleration}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Tyre type</label>
                                                                                    <input type="text" class="form-control tyre_type specialchar" name="tyre_type" placeholder="Tyre type">                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">No of doors</label>
                                                                                    <input type="text" class="form-control no_of_doors specialchar" name="no_of_doors" placeholder="No of doors"@if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->no_of_doors}}'
                                                                                           @endif>                                                 
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Specification Accordion End -->
                                                        <!-- Engine Accordion Starts -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingtwo">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo"  class="accordion">
                                                                        Engine
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapsetwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Engine Type</label>
                                                                                    <input type="text" class="form-control engine_type specialchar" name="engine_type" placeholder="Engine Type" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->engine_type}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Displacement</label>
                                                                                    <input type="text" class="form-control displacement specialchar" name="displacement" placeholder="Displacement" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->displacement}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Max Power</label>
                                                                                    <input type="text" class="form-control max_power specialchar" name="max_power" placeholder="Max Power" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->max_power}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Max Torque</label>
                                                                                    <input type="text" class="form-control max_torque specialchar" name="max_torque" placeholder="Max Torque" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->max_torque}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">No Of Cylinder</label>
                                                                                    <input type="text" class="form-control no_of_cylinder specialchar" name="no_of_cylinder" placeholder="No Of Cylinder" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->no_of_cylinder}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Valves per Cylinder</label>
                                                                                    <input type="text" class="form-control valves_per_cylinder specialchar" name="valves_per_cylinder" placeholder="Valves per Cylinder" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->valves_per_cylinder}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Valve configuration</label>
                                                                                    <input type="text" class="form-control valve_configuration specialchar" name="valve_configuration" placeholder="Valve configuration" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->valve_configuration}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Fuel Supply System</label>
                                                                                    <input type="text" class="form-control fuel_supply_system specialchar" name="fuel_supply_system" placeholder="Fuel Supply System" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->fuel_supply_system}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Turbo Charger</label>
                                                                                    <input type="text" class="form-control turbo_charger specialchar" name="turbo_charger" placeholder="Turbo Charger" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->turbo_charger}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Super Charger</label>
                                                                                    <input type="text" class="form-control super_charger specialchar" name="super_charger" placeholder="Super Charger" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->super_charger}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Engine Accordion End -->
                                                        <!-- Dimensions Accordion Start -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingthree">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="true" aria-controls="collapsethree"  class="accordion">
                                                                        Dimensions
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapsethree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Length</label>
                                                                                    <input type="text" class="form-control length specialchar" name="length" placeholder="Length" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->length}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Width</label>
                                                                                    <input type="text" class="form-control width specialchar" name="width" placeholder="Width" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->width}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Height</label>
                                                                                    <input type="text" class="form-control height specialchar" name="height" placeholder="Height" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->height}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Wheel Base</label>
                                                                                    <input type="text" class="form-control wheel_base specialchar" name="wheel_base" placeholder="Wheel Base" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->wheel_base}}'
                                                                                           @endif>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <div class="form-group field-wrapper1">
                                                                                    <label class="{{$featuresshow}}">Gross Weight</label>
                                                                                    <input type="text" class="form-control gross_weight specialchar" name="gross_weight" placeholder="Gross Weight" @if(count($dealer_listing_features)>0)
                                                                                           value = '{{$dealer_listing_features[0]->gross_weight}}'
                                                                                           @endif>                                                
                                                                                </div>                                            
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Dimensions Accordion End -->
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="feature">
                                                    <!-- Interior Start Accordion Start -->
                                                    <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingfour">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapsefour" aria-expanded="true" aria-controls="collapsefour" class="accordion">
                                                                        Car Interior
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapsefour" class="panel-collapse collapse in colimg" role="tabpanel" aria-labelledby="headingfour">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="air_conditioner" class="air_conditioner" id="air_conditioner" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->air_conditioner==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Air Conditioner </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="adjustable_steering" id="adjustable_steering" class="adjustable_steering" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->adjustable_steering==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Adjustable Steering </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="leather_steering_wheel" id="leather_steering_wheel" class="leather_steering_wheel" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->leather_steering_wheel==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Leather Steering Wheel </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="heater" id="heater" class="heater" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->heater==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Heater </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="digital_clock" id="digital_clock" class="digital_clock" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->digital_clock==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Digital Clock </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Interior Accordion End -->

                                                    <!-- Comfort Start Accordion Start -->
                                                    <div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingfive">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapsefive" aria-expanded="true" aria-controls="collapsefive" class="accordion">
                                                                        Car Comfort
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapsefive" class="panel-collapse collapse in colimg" role="tabpanel" aria-labelledby="headingfive">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="power_steering" id="power_steering" class="power_steering" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->power_steering==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Power steering </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="power_windows_front" class="power_windows_front" id="power_windows_front" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->power_windows_front==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Power windows front </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="power_windows_rear" id="power_windows_rear" class="power_windows_rear" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->power_windows_rear==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Power windows rear </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="remote_trunk_opener" id="remote_trunk_opener" class="remote_trunk_opener" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->remote_trunk_opener==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Remote trunk opener </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="remote_fuel_lid_opener" id="remote_fuel_lid_opener" class="remote_fuel_lid_opener" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->remote_fuel_lid_opener==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Remote fuel lid opener </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="low_fuel_warning_light" id="low_fuel_warning_light" class="low_fuel_warning_light" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->low_fuel_warning_light==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Low fuel warning light </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_reading_lamp" id="rear_reading_lamp" class="rear_reading_lamp" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rear_reading_lamp==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear reading lamp </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_seat_headrest" id="rear_seat_headrest" class="rear_seat_headrest" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rear_seat_headrest==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear seat headrest </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_seat_centre_arm_rest" id="rear_seat_centre_arm_rest" class="rear_seat_centre_arm_rest" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rear_seat_centre_arm_rest==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear seat centre arm rest </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="height_adjustable_front_seat_belts" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->height_adjustable_front_seat_belts==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Height adjustable front seat belts </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="cup_holders_front" id="cup_holders_front" class="cup_holders_front" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->cup_holders_front==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Cup holders front </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="cup_holders_rear" id="cup_holders_rear" class="cup_holders_rear" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->cup_holders_rear==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Cup holders rear </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_ac_vents" id="rear_ac_vents" class="rear_ac_vents" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->cup_holders_rear==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear ac vents </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="parking_sensors" id="parking_sensors" class="parking_sensors" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->parking_sensors==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Parking sensors </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Comfort Accordion End -->

                                                    <!-- Safety Accordion Start -->
                                                    <div class="panel-group" id="accordion6" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingsix">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion6" href="#collapsesix" aria-expanded="true" aria-controls="collapsesix" class="accordion">
                                                                        Safety
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapsesix" class="panel-collapse collapse  in  colimg" role="tabpanel" aria-labelledby="headingsix">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="anti_lock_braking_system" id="anti_lock_braking_system" class="anti_lock_braking_system" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->anti_lock_braking_system==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Anti lock braking system </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="central_locking" id="central_locking" class="central_locking" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->central_locking==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Central locking </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="child_safety_lock" id="child_safety_lock" class="child_safety_lock" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->child_safety_lock==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Child safety lock </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="driver_airbags" id="driver_airbags" class="driver_airbags" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->driver_airbags==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Driver airbags </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="passenger_airbag" id="passenger_airbag" class="passenger_airbag" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->passenger_airbag==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Passenger airbag </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_seat_belts" id="rear_seat_belts" class="rear_seat_belts" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rear_seat_belts==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear seat belts </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="seat_belt_warning" id="seat_belt_warning" class="seat_belt_warning" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->seat_belt_warning==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Seat belt warning </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="adjustable_seats" class="adjustable_seats" id="adjustable_seats" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->adjustable_seats==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Adjustable seats </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="crash_sensor" class="crash_sensor" id="crash_sensor" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->crash_sensor==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Crash sensor </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="anti_theft_device" class="anti_theft_device" id="anti_theft_device" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->anti_theft_device==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Anti theft device </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="immobilizer" id="immobilizer" class="immobilizer" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->immobilizer==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Immobilizer </label>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Safety Accordion End -->

                                                    <!-- Exterior Accordion Start -->
                                                    <div class="panel-group" id="accordion7" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingseven">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion7" href="#collapseseven" aria-expanded="true" aria-controls="collapseseven" class="accordion">
                                                                        Exterior
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseseven" class="panel-collapse collapse in colimg" role="tabpanel" aria-labelledby="headingseven">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="adjustable_head_lights" id="adjustable_head_lights" class="adjustable_head_lights" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->adjustable_head_lights==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Adjustable head lights </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="power_adjustable_exterior_rear_view_mirror" id="power_adjustable_exterior_rear_view_mirror" class="power_adjustable_exterior_rear_view_mirror" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->power_adjustable_exterior_rear_view_mirror==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Power adjustable exterior rear view mirror </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="electric_folding_rear_view_mirror" id="electric_folding_rear_view_mirror" class="electric_folding_rear_view_mirror" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->electric_folding_rear_view_mirror==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Electric folding rear view mirror </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rain_sensing_wipers" id="rain_sensing_wipers" class="rain_sensing_wipers"  value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rain_sensing_wipers==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rain sensing wipers </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_window_wiper" id="rear_window_wiper" class="rear_window_wiper" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rear_window_wiper==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear window wiper </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="alloy_wheels" class="alloy_wheels" id="alloy_wheels" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->alloy_wheels==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Alloy wheels </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="tinted_glass" class="tinted_glass" id="tinted_glass" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->tinted_glass==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Tinted glass </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="front_fog_lights" id="front_fog_lights" class="front_fog_lights" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->front_fog_lights==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Front fog lights </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_window_wiper" id="rear_window_wiper" class="rear_window_wiper" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rear_window_wiper==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear window wiper </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="rear_window_defogger" class="rear_window_defogger" id="rear_window_defogger" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->rear_window_defogger==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Rear window defogger </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Exterior Accordion End -->

                                                    <!-- Entertainment Accordion Start -->
                                                    <div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingeight">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion8" href="#collapseeight" aria-expanded="true" aria-controls="collapseeight" class="accordion">
                                                                        Entertainment
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseeight" class="panel-collapse collapse colimg in" role="tabpanel" aria-labelledby="headingeight">  
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="columns gutters" id="features">
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="cdplayer" id="cdplayer" value="1" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->cdplayer==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>CD Player </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="radio" id="radio" value="18" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->radio==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Radio </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="audio" id="audio" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->audio==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Audio </label>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                                <label class="checkbox">
                                                                                    <input name="bluetooth" id="bluetooth" value="19" type="checkbox" @if(count($dealer_listing_features)>0)
                                                                                           @if($dealer_listing_features[0]->bluetooth==1)
                                                                                           checked
                                                                                           @endif 
                                                                                           @endif>
                                                                                           <i></i>Bluetooth </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Safety Accordion End -->
                                                </div>
                                            </div>
                                            <div class="add-list-buttons">
                                                <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                <div class="comm-button">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        <button class="btn btn-primary btn-lg btn-circle backtocerfication" data-toggle="tooltip" data-original-title="Back" data-placement="left" type="button"><i class="fa fa-arrow-left"></i></button></a>
                                                </div>
                                                <div class="comm-button">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        <button type="submit" class="btn btn-primary  btn-lg btn-circle update_car_list" data-toggle="tooltip" data-original-title="Save" data-placement="left" data-specific='save'><i class="fa fa-save"></i></button>
                                                        <!--<button value="6" class="btn btn-primary update_car_list" type="submit">Save And Next</button></a>-->
                                                </div>       
                                                <div class="comm-button">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        <button class="btn btn-primary btn-lg btn-circle update_car_list" data-toggle="tooltip" data-original-title="Next" data-placement="left" type="submit" data-specific="next"><i class="fa fa-arrow-right"></i></button>
                                                    </a>
                                                    <!-- update_car_list -->
                                                    <!-- upload_skip_fifth -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @if($listing_headerdata['listing_status']==1)
                                <div class="tab-pane fade active in disablebutton" id="portals">
                                    @else
                                    <div class="tab-pane fade disablebutton" id="portals">
                                        @endif
                                        <form id="dealer_online_portal">
                                            <div class="panel-body">
                                                <div class="container"><h2 class="tab-title">Dealer Plus</h2>
                                                    <div class="col-sm-6">
                                                    @if($listing_headerdata['price']<=0)
                                                        <div class="alert alert-danger alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Sale Price Should Be Greater Than 0</div>
                                                    @endif
                                                        <div class="form-group">
                                                            <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="deal1" class="listing_dealer" value="listing" name="dealer_selection" checked="">
                                                                <label for="deal1">Listing </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($listing_headerdata['mongopush_status']!='failure')
                                                    <div class="col-sm-6 listingsaved">
                                                        @else
                                                        <div class="col-sm-6 listingsaved" style="display: none;">
                                                            @endif
                                                            <div class="progress progress-striped active postedinventory">The Listing is already posted. Please click here to view   
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <div class="radio radio-primary radio-inline">
                                                                    <input type="radio" id="deal2" class="auction_dealer" value="auction" name="dealer_selection" disabled="">
                                                                    <label for="deal2"> Auction </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 add-auction">
                                                            <div class="col-sm-3">
                                                                <input type="text" name="auction_price" class="form-control auction_price" Placeholder="Min Price" />
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class='input-group date' id='datetimepicker6'>
                                                                    <input type="text" name="auction_startdate"  value="" class="form-control" Placeholder="Startdate" />

                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class='input-group date' id='datetimepicker7'>
                                                                    <input type="text" name="auction_end_date"  class="form-control" Placeholder="End Date" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4"><div class="checkbox checkbox-primary">
                                                                    <input id="Auction" class="onlinep" type="checkbox" value="auction_inviation" name="auctioninviation">
                                                                    <label for="Auction" class="onlinepcheck">
                                                                        Send Invitation
                                                                    </label>
                                                                </div></div>

                                                        </div>
                                                        <div class="col-sm-12 button-online">
                                                            <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                            
                                                            <input type="button" class="btn btn-primary backtoengine" type="button"  value="Back">
                                                            
                                                            <!-- <input type="submit" class="btn btn-primary postinventry" type="submit" name="post_invertry" value="Save"> -->        
                                                            
                                                            @if($listing_headerdata['price']<=0)
                                                            <input type="button" class="btn btn-primary"  value="Sale Price Should > 0" disabled>
                                                            @else
                                                            <input type="button" class="btn btn-primary saveandpost"  value="Save &amp; Post">
                                                            @endif
                                                            <input type="button" class="btn btn-primary cancelbutton"  value="Cancel">
                                                            <!--mongo-->
                                                        </div>
                                                    </div>
                                                </div>


                                                <!--                                                <div class="add-list-buttons button-online">
                                                                                                    <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                                                                    @if($listing_headerdata['mongopush_status']=='failure'&&$listing_headerdata['listing_status']==0)
                                                                                                    <div class="comm-button">
                                                                                                    <button type="button" class="btn btn-primary btn-lg btn-circle backtoengine" data-toggle="tooltip" data-original-title="Back" data-placement="left" type="button"><i class="fa fa-arrow-left"></i></button>
                                                                                                    @endif
                                                                                                    </div>
                                                                                                     <input type="submit" class="btn btn-primary postinventry" type="submit" name="post_invertry" value="Save">         
                                                                                                   <div class="comm-button">
                                                                                                    @if($listing_headerdata['mongopush_status']!='failure')
                                                                                                    
                                                                                                    <button type="button" class="btn btn-primary btn-lg btn-circle" data-toggle="tooltip" data-original-title="Save & Post" data-placement="left" disabled><i class="fa fa-save"></i></button>
                                                                                                    @else
                                                                                                    <button type="button" class="btn btn-primary btn-lg btn-circle saveandpost" data-toggle="tooltip" data-original-title="Save & Post" data-placement="left"><i class="fa fa-save"></i></button>
                                                                                                    @endif
                                                                                                    </div>
                                                                                                    <div class="comm-button">
                                                                                                        <button type="button" class="btn btn-primary btn-lg btn-circle cancelbutton" data-toggle="tooltip" data-original-title="Cancel" data-placement="left"><i class="fa fa-remove"></i></button>
                                                                                                    </div>
                                                                                                    mongo
                                                                                                </div>-->
                                            </div>
                                        </form>

                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>


                </div>
                @include('footer')
                <div class="modal fade" id="car_list" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog1" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="submit" id="pop_close" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form name="testform" id="testform" action="{{url('inventory_image')}}" method="post" enctype="multipart/form-data">                                        

                                    <div class="col-xs-12 col-sm-7">
                                        <h3 class="text-center">Image Selection</h3>
                                        
                                            <div style="margin:10% auto 0 auto; display: table;">

                                                <!-- begin_picedit_box -->
                                                
                                                <div class="picedit_box">
                                                    <!-- Placeholder for messaging -->
                                                    <div class="picedit_message">
                                                        <span class="picedit_control ico-picedit-close" data-action="hide_messagebox"></span>
                                                        <div></div>
                                                    </div>
                                                    <!-- Picedit navigation -->
                                                    <div class="picedit_nav_box picedit_gray_gradient">
                                                        <div class="picedit_pos_elements"></div>
                                                        <div class="picedit_nav_elements">
                                                            <!-- Picedit button element begin -->
                                                            <div class="picedit_element">
                                                                <span class="picedit_control picedit_action ico-picedit-pencil" title="Pen Tool" id="pentool"></span>
                                                                <div class="picedit_control_menu">
                                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_3">
                                                                        <label class="picedit_colors">
                                                                            <span title="Black" class="picedit_control picedit_action picedit_black active" data-action="toggle_button" data-variable="pen_color" data-value="black"></span>
                                                                            <span title="Red" class="picedit_control picedit_action picedit_red" data-action="toggle_button" data-variable="pen_color" data-value="red"></span>
                                                                            <span title="Green" class="picedit_control picedit_action picedit_green" data-action="toggle_button" data-variable="pen_color" data-value="green"></span>
                                                                        </label>
                                                                        <label>
                                                                            <span class="picedit_separator"></span>
                                                                        </label>
                                                                        <label class="picedit_sizes">
                                                                            <span title="Large" class="picedit_control picedit_action picedit_large" data-action="toggle_button" data-variable="pen_size" data-value="16"></span>
                                                                            <span title="Medium" class="picedit_control picedit_action picedit_medium" data-action="toggle_button" data-variable="pen_size" data-value="8"></span>
                                                                            <span title="Small" class="picedit_control picedit_action picedit_small" data-action="toggle_button" data-variable="pen_size" data-value="3"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Picedit button element end -->
                                                            <!-- Picedit button element begin -->
                                                            <div class="picedit_element">
                                                                <span class="picedit_control picedit_action ico-picedit-insertpicture" title="Crop" data-action="crop_open"></span>
                                                            </div>
                                                            <!-- Picedit button element end -->
                                                            <!-- Picedit button element begin -->
                                                            <div class="picedit_element">
                                                                <span class="picedit_control picedit_action ico-picedit-redo" title="Rotate"></span>
                                                                <div class="picedit_control_menu">
                                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_1">
                                                                        <label>
                                                                            <span>90° CW</span>
                                                                            <span class="picedit_control picedit_action ico-picedit-redo" data-action="rotate_cw"></span>
                                                                        </label>
                                                                        <label>
                                                                            <span>90° CCW</span>
                                                                            <span class="picedit_control picedit_action ico-picedit-undo" data-action="rotate_ccw"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Picedit button element end -->
                                                            <!-- Picedit button element begin -->
                                                            <div class="picedit_element">
                                                                <span class="picedit_control picedit_action ico-picedit-arrow-maximise" title="Resize"></span>
                                                                <div class="picedit_control_menu">
                                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_2">
                                                                        <label>
                                                                            <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="resize_image"></span>
                                                                            <span class="picedit_control picedit_action ico-picedit-close" data-action=""></span>
                                                                        </label>
                                                                        <label>
                                                                            <span>Width (px)</span>
                                                                            <input type="text" class="picedit_input" data-variable="resize_width" value="0">
                                                                        </label>
                                                                        <label class="picedit_nomargin">
                                                                            <span class="picedit_control ico-picedit-link" data-action="toggle_button" data-variable="resize_proportions"></span>
                                                                        </label>
                                                                        <label>
                                                                            <span>Height (px)</span>
                                                                            <input type="text" class="picedit_input" data-variable="resize_height" value="0">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Picedit button element end -->
                                                        </div>
                                                    </div>
                                                    <!-- Picedit canvas element -->
                                                    <div class="picedit_canvas_box">
                                                        <div class="picedit_painter image_reset3">

                                                            <canvas class="image_reset1"></canvas>

                                                        </div>
                                                        <div class="picedit_canvas image_reset4">

                                                            <canvas class="image_reset2"></canvas>

                                                        </div>
                                                        <div class="picedit_action_btns active">
                                                            <div class="picedit_control ico-picedit-picture reset_image" accept=".png, .jpg, .jpeg" data-action="load_image"><p class="text-center text-lg">Click to upload</p></div>
                                                            <!--  <div class="picedit_control ico-picedit-camera" data-action="camera_open"></div>
                                                             <div class="center">or copy/paste image here</div> -->
                                                        </div>
                                                    </div>
                                                    <!-- Picedit Video Box -->
                                                    <!--   <div class="picedit_video">
                                                          <video autoplay></video>
                                                          <div class="picedit_video_controls">
                                                              <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="take_photo"></span>
                                                              <span class="picedit_control picedit_action ico-picedit-close" data-action="camera_close"></span>
                                                          </div>
                                                      </div> -->
                                                    <!-- Picedit draggable and resizeable div to outline cropping boundaries -->
                                                    <div class="picedit_drag_resize">
                                                        <div class="picedit_drag_resize_canvas"></div>
                                                        <div class="picedit_drag_resize_box">
                                                            <div class="picedit_drag_resize_box_corner_wrap">
                                                                <div class="picedit_drag_resize_box_corner"></div>
                                                            </div>
                                                            <div class="picedit_drag_resize_box_elements">
                                                                <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="crop_image"></span>
                                                                <span class="picedit_control picedit_action ico-picedit-close" data-action="crop_close"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end_picedit_box -->


                                            </div>
                                            <input type="text" name="image" id="image" style="display: none;">




                                            </div>
                                            <div class="col-xs-12 col-sm-5">
                                                <h3>Water Mark</h3>
                                                <span>This Business Logo</span>
                                                <div class="addimage">
                                                    <div class="form-group">
                                                        <div>
                                                            <img src="{{$water_mark}}" class="image" alt=""/>
                                                        </div>
                                                    </div> 

                                                </div>
                                                <span>This Contact No</span>
                                                @if($dealerplans != 1)
                                                 <input type="text" maxlength='11' value="{{$dealer_phoneno->d_mobile}}" name="number" placeholder="mobile number" class="form-control data-number required-des" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Enter Number">
                                                 @else
                                                 <input type="text" maxlength='11' value="" name="number" placeholder="mobile number" class="form-control data-number required-des" data-validation="required" data-validation-optional="false" data-validation-error-msg="Please Enter Number" disabled="disabled">
                                                 @endif
                                                <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                <div class="row">
                                                    <div><div class="checkbox checkbox-info col-xs-6">
                                                   
                                                    <input type="radio" id="image1" checked="" name="position" value="1">
                                                    <label for="image1">Top Left</label>
                                                        </div></div>
                                                <div><div class="checkbox checkbox-info col-xs-6"><input type="radio" id="image2" name="position" value="2">
                                                    <label for="image2">Top Right</label>
                                                </div></div>
                                                <div><div class="checkbox checkbox-info col-xs-6"><input type="radio" id="image3" name="position" value="3">
                                                    <label for="image3">Bottom Left</label>
                                                </div></div>
                                                <div><div class="checkbox checkbox-info col-xs-6"><input type="radio" id="image4" name="position" value="4">
                                                    <label for="image4">Bottom Right</label>
                                                </div></div>
                                                </div>
                                                <div>
                                                    <input type="hidden" class="dplistid" name="dplistid" value="{{$dp_listid}}"/>
                                                    
                                                </div>








                                            </div>
                                        </form>
                                            <div class="text-center col-xs-12 col-sm-6 col-sm-offset-5">
                                                <button  class=" col-xs-12 col-md-4 btn-primary btn-md" type="button" id="save_image">Upload</button>

                                            </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" id="mypostingdetails" action="{{url('mypostingdetails')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" id="car_view_id" name="car_view_id" value="{{$dp_listid}}">
                </form>
                postedinventory
                <script src="{{URL::asset('js/jquery.min.js')}}"></script>
                <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
                <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
                
                <script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}"></script>
                <script src="{{URL::asset('js/label-slide.js')}}" type="text/javascript"></script>
                <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
                <script src="{{URL::asset('js/upload.js')}}"></script> 
                <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
                <script src="{{URL::asset('js/picedit.js')}}"></script>
                <script src="{{URL::asset('js/dealerplus.js')}}"></script>
                <script>

                                                        $('.BSbtninfo').filestyle({
                                                            buttonName: 'btn-info',
                                                            buttonText: ' Select a File',

                                                        });
                </script>
                <script>
                    $(document).ready(function () {
                        //$('.date').datetimepicker('setStartDate', "{{$date}}");
                        $("body").on("change", ".specialchar", function () {
                            var str= $(this).val();
                            var str1 = str.replace("!", "")
                            var str2 = str1.replace("@", "")
                            var str3 = str2.replace("&", "")
                            var result = str3.replace("#", "")
                            $(this).val(result);
                        });
                    
                    $("body").on("click", ".postedinventory", function () {
                    $('#mypostingdetails').submit();
                    });
                            $("body").on("click", ".cancelbutton", function () {
                    window.location.replace("{{url('managelisting')}}");
                    });
                            $("body").on("click", ".upload_images", function () {
                    var navigation = $(this).attr('data-specific');
                            var $nonempty = $('.imge-add img').filter(function () {
                    ;
                            return $(this).attr('src') != '';
                    });
                            if ($nonempty.length == 0)
                    {
                    alert('Please upload at least one image of the vehicle');
                    } else {
                    //upload image ajax call
                    $("#loadspinner").css("display", "block");
                            var form_data = new FormData($('#inventry-images')[0]);
                            $.ajax({
                            url: "{{url('image_upload')}}",
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data,
                                    allowedTypes: "jpg,png,gif,jpeg",
                                    multiple: true,
                                    type: 'post',
                                    success: function (response) {
                                    $("#loadspinner").css("display", "none");
                                            if (navigation == 'next') {
                                    $('.disablebutton').removeClass('active');
                                            $('.disablebutton').removeClass('in');
                                            $('#uploaddocuments').addClass('active');
                                            $('#uploaddocuments').addClass('in');
                                            $('#uploaddocumentstab').click();
                                    }
                                    },
                                    error: function () {
                                    $("#loadspinner").css("display", "none");
                                    }
                            });
                            //upload image ajax call end
                    }
                    });
                            $("body").on("click", ".backtoimages", function () {
                    $('.disablebutton').removeClass('active');
                            $('.disablebutton').removeClass('in');
                            $('#uploadimages').addClass('active');
                            $('#uploadimages').addClass('in');
                            $('#uploadimagestab').click();
                    });
                            $("body").on("click", ".vehicle_document", function () {
                            $('.documentuplodsize').html('');
                            var navigation = $(this).attr('data-specific');
                            $("#loadspinner").css("display", "block");
                            var serialized = new FormData($('#dealer_form')[0]);
                            $.ajax({
                            url: "{{url('dealer_docs')}}",
                                    type: 'POST',
                                    enctype: 'multipart/form-data',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: serialized,
                                    success: function (response) {
                                    if (response.filetyperesponse == 'problem')
                                    {
                                    $("#loadspinner").css("display", "none");
                                            $('.documentuplodsize').html('<h2>Kindly check the file size and file type</h2>');
                                    } else
                                    {
                                        $('#errormsg').html('<div class="alert alert-success alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>success!</strong>Document and Other Details Stored Successfully</div>');
                                        setTimeout(function(){ $('#errormsg .close').click(); }, 3000);
                                    $('.documentuplodsize').html('');
                                            $('.fourthtab div h4 a').trigger('click');
                                            $('#collapseThree').hide();
                                            $("#loadspinner").css("display", "none");
                                            if (navigation == 'next') {
                                    $('.disablebutton').removeClass('active');
                                            $('.disablebutton').removeClass('in');
                                            $('#certificationwarranty').addClass('active');
                                            $('#certificationwarranty').addClass('in');
                                            $('#certificationwarrantytab').click();
                                    }
                                    $.each(response, function (key, val) {
                                    if (key == 0)
                                    {
                                    $('.rcdocuments').html('<a href="' + val + '" download="download">Download File</a>');
                                    } else if (key == 1)
                                    {
                                    $('.insurancedocuments').html('<a href="' + val + '" download="download">Download File</a>');
                                    } else if (key == 2)
                                    {
                                    $('.rtodocuments').html('<a href="' + val + '" download="download">Download File</a>');
                                    } else if (key == 3)
                                    {
                                    $('.fcdocuments').html('<a href="' + val + '" download="download">Download File</a>');
                                    } else if (key == 4)
                                    {
                                    $('.nocdocuments').html('<a href="' + val + '" download="download">Download File</a>');
                                    } else if (key == 5)
                                    {
                                    $('.permitdocuments').html('<a href="' + val + '" download="download">Download File</a>');
                                    }
                                    });
                                            $('#permitupload,#nocupload,#fcupload,#rtoupload,#insuranceupload,#rcupload').val('');
                                    }
                                    },
                                    error: function (response) {

                                        $('#errormsg').html('<div class="alert alert-danger alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong>Failed to Store </div>');
                                        setTimeout(function(){ $('#errormsg .close').click(); }, 3000);
                                        $("#loadspinner").css("display", "none");
                                    }
                            });
                    });
                            $("body").on("click", ".backtodocuments", function () {
                    $('.disablebutton').removeClass('active');
                            $('.disablebutton').removeClass('in');
                            $('#uploaddocuments').addClass('active');
                            $('#uploaddocuments').addClass('in');
                            $('#uploaddocumentstab').click();
                    });
                            $('.update_certificationwarranty_list').click(function () {
                    var navigation = $(this).attr('data-specific');
                            $("#loadspinner").css("display", "block");
                            var serialized = new FormData($('#certificationwarrantyform')[0]);
                            $.ajax({
                            url: "{{url('certificationwarrantysave')}}",
                                    type: 'POST',
                                    enctype: 'multipart/form-data',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    data: serialized,
                                    success: function (response)
                                    {
                                    console.log(response.filecertificatereporturl);
                                    var errormsg = '';
                                    if (response.fileservicereportvalid == '1')
                                    {
                                        errormsg = errormsg + 'File Upload Size is < 5MB For Service Report';
                                    }
                                    if (response.fileservicereporturl != '')
                                    {
                                        $('#servicedownload').html('<a href="'+response.fileservicereporturl+'" download="download">Download</a>');
                                    }

                                    if (response.filecertificatereporturl != '')
                                    {
                                        $('#certificatedownload').html('<a href="'+response.filecertificatereporturl+'" download="download">Download</a>');
                                    }

                                    if (response.filecertificatereportvalid == '1')
                                    {
                                        errormsg = errormsg + 'File Upload Size is < 5MB For Certificate Report';
                                    }
                                    if (errormsg != '')
                                    {
                                    $('#errormsg').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> ' + errormsg + '</div>');
                                    }
                                    $('#errormsg').html('<div class="alert alert-success alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>success!</strong>Certification,Inspection and Warranty Stored Successfully</div>');
                                    setTimeout(function(){ $('#errormsg .close').click(); }, 3000);
                                            $("#loadspinner").css("display", "none");
                                            $('.sixthtab div h4 a').trigger('click');
                                            if (navigation == 'next' && errormsg == '')
                                            {
                                            $('.disablebutton').removeClass('active');
                                                    $('.disablebutton').removeClass('in');
                                                    $('#engineandspecific').addClass('active');
                                                    $('#engineandspecific').addClass('in');
                                                    $('#engineandspecifictab').click();
                                            }
                                    },
                                    error: function () {
                                        $('#errormsg').html('<div class="alert alert-danger alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Falied!</strong>Failed to Store </div>');
                                        setTimeout(function(){ $('#errormsg .close').click(); }, 3000);
                                    $("#loadspinner").css("display", "none");
                                    }
                            });
                    });
                            $("body").on("click", ".backtocerfication", function () {
                    $('.disablebutton').removeClass('active');
                            $('.disablebutton').removeClass('in');
                            $('#certificationwarranty').addClass('active');
                            $('#certificationwarranty').addClass('in');
                            $('#certificationwarrantytab').click();
                    });
                            $("body").on("click", ".update_car_list", function () {
                    var navigation = $(this).attr('data-specific');
                            $("#loadspinner").css("display", "block");
                            var serialized = new FormData($('#engineandspecification')[0]);
                            $.ajax({
                            url: "{{url('update_car_list')}}",
                                    type: 'POST',
                                    contentType: false,
                                    processData: false,
                                    data: serialized,
                                    success: function (response)
                                    {
                                        $('#errormsg').html('<div class="alert alert-success alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>success!</strong>Engine and Specifications Successfully</div>');
                                        setTimeout(function(){ $('#errormsg .close').click(); }, 3000);
                                    if (navigation == 'next') {
                                    $('.disablebutton').removeClass('active');
                                            $('.disablebutton').removeClass('in');
                                            $('#portals').addClass('active');
                                            $('#portals').addClass('in');
                                            $('#portalstab').click();
                                    }
                                    $("#loadspinner").css("display", "none");
                                    },
                                    error: function ()
                                    {
                                    $("#loadspinner").css("display", "none");
                                    }
                            });
                    });
                            $("body").on("click", ".backtoengine", function () {
                    $('.disablebutton').removeClass('active');
                            $('.disablebutton').removeClass('in');
                            $('#engineandspecific').addClass('active');
                            $('#engineandspecific').addClass('in');
                            $('#engineandspecifictab').click();
                    });
                            $(document).on("click", ".saveandpost", function(){
                    var dplistid = $('.dplistid').val();
                            $("#loadspinner").css("display", "block");
                            var datas = $("#dealer_online_portal").serialize();
                            $.ajax({
                            url:"{{url('online_portal')}}",
                                    type:"post",
                                    dataType:"json",
                                    data : datas,
                                    success:function(statusresponse)
                                    {
                                    if (statusresponse.status == "failure")
                                    {
                                    $("#loadspinner").css("display", "none");
                                            $('.mongodata').html("<h2>Kindly Fill Incomplete Tabs!!</h2>");
                                    }
                                    else
                                    {
                                    $.ajax({
                                    url:"{{url('mongo_push')}}",
                                            type: 'POST',
                                            data : {duplicate_id:dplistid},
                                            success: function(response){
                                            //window.location.href = "{{url('managelisting')}}";
                                            setTimeout(function(){ $('#errormsg .close').click(); }, 3000);

                                            $("#loadspinner").css("display", "none");
                                            $('.edit-inv,.backtoengine').hide();
                                            $('.listingsaved').show();
                                            $('.saveandpost').prop('disabled', true);
                                            $('.postedinventory').html('The Listing is posted successfully. Please click here to view');
                                            $('.errormsg').html('<div class="alert alert-success alert-dismissable">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>success!</strong>Engine and Specifications Successfully</div>');
                                            setTimeout(function(){ $('#errormsg .close').click(); }, 3000);

                                                    //console.log(response);
                                            },
                                            error : function(response){
                                            $("#loadspinner").css("display", "none");
                                                    $('.mongodata').html("<h2>Please Try Again..</h2>");
                                                    //console.log(response.responseText);
                                            }
                                    });
                                    }
                                    },
                                    error : function(){
                                    $("#loadspinner").css("display", "none");
                                            $('.mongodata').html("<h2>Please Try Again..</h2>");
                                    }
                            });
                    });
                            @if (count($dealer_listing_features) <= 0)

                            $.ajax({
                            url: "{{url('variant_selection')}}",
                                    type: 'post',
                                    dataType: "json",
                                    data: {variant_id: "{{$listing_headerdata['variant_id']}}"},
                                    success: function (response)
                                    {
                                    //console.log(response);
                                    $.each(response.textboxvalues, function (key, val) {
                                        if(val!='')
                                        {
                                            $('.'+key).prev().addClass('show');
                                        }
                                        $('.' + key).val(val);
                                    });
                                            $.each(response.checkboxvalues, function (key, val) {
                                            if (val == 1)
                                            {
                                            //$('.'+key).val(val);
                                            $('.' + key).prop('checked', true);
                                            } else
                                            {
                                            $('.' + key).prop('checked', false);
                                            }
                                            });
                                    }
                            });
                            @endif

                    });
                            $('.myclass').on('change', function(e) {
                    console.log(this.files[0].type);
                            var filesize = (this.files[0].size / 1024 / 1024).toFixed(2);
                            if (filesize > 2)
                    {
                    alert('The Allowed File Size is 2MB');
                            $(this).val('');
                            e.preventDefault();
                            return false;
                    }

                    });
                </script>
                <script type="text/javascript">
                            $(function() {
                            $('.picedit_box').picEdit({
                            imageUpdated: function(img){
                            },
                                    formSubmitted: function(){
                                    },
                                    redirectUrl: false,
                                    defaultImage: false
                            });
                            });
                            $('#pop_close').click(function(){
                    $('.image_reset4').css("display", "none");
                            $('#pentool').removeClass('active');
                    });
                            $('#save_image').click(function(){
                    $("#loadspinner").css("display", "block");
                            var image_form = new FormData($('#testform')[0]);
                            image_form.append("imageTypeData", image_type);
                            $.ajax({
                            url: "{{url('inventory_image')}}",
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: image_form,
                                    allowedTypes: "jpg,png,gif,jpeg",
                                    multiple: true,
                                    type: 'post',
                                    success: function (response) {
                                        console.log(response);
                                    $("#loadspinner").css("display", "none");
                                            $('.close').click();
                                            $('.image_reset4').css("display", "none");
                                            $('#' + imageId).attr("src", response);
                                            window.location.reload();
                                            //console.log(response);                    
                                    },
                                    error: function () {
                                    $("#loadspinner").css("display", "none");
                                    }
                            });
                    });
                            function fun(class_name, img_src, image_name)
                            {
                            console.log(img_src);
                                    $('.' + class_name).attr("data-toggle", "modal");
                                    $('.' + class_name).attr("data-target", "#car_list");
                                    imageId = img_src;
                                    image_type = image_name;
                            }
                </script>