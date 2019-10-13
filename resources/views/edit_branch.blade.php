@include('header')
<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="container-fluid footer-fixed">
            <div class="row">
                <div class="content-header col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('managebranches')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                        <li class="active">My Branches</li>
                    </ol>
                </div>
                <form method="post" action="{{url('updatebranches')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="update_branch_id" value="{{$compact_array['branch_detail']->branch_id}}">
                    <div class="col-xs-12">
                        @if (count($errors) > 0)
                        <div class="alert alert-danger" id="message-err">Please enter all mandatory fields
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        @if(Session::has('headquarter'))
                        <div class="alert alert-danger" id="message-err">{{ Session::get('headquarter') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        @endif
                        @if(Session::has('message'))
                        <div class="alert alert-danger" id="message-err">{{ Session::get('message') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        @endif
                        <!--<h2 class="page-title">Edit Branches</h2>-->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="panel-body myprof-tab">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Edit Branch</h4>
                                                </div>
                                                <div class="panel-body" id="contactAddress1">
                                                    <div class="col-xs-12" id=""> 
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-6">    
                                                                <div class="form-group field-wrapper1">
                                                                    <label class="show">Branch Name</label>
                                                                    <input type="text" name="dealer_name" class="form-control data-name validate-space required-des" value="{{$compact_array['branch_detail']->dealer_name}}" placeholder="Branch Name" data-validation="alphanumeric,length" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please Enter Branch name">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-xs-12">
                                                                <div class="form-group field-wrapper1">
                                                                    <label class="show">Contact Number</label>
                                                                    <input type="text" name="dealer_contact_no" class="form-control data-number required-des" placeholder="Contact Number" data-validation="required,length" value="{{$compact_array['branch_detail']->dealer_contact_no}}" data-validation-optional="false" data-validation-length="8-11" maxlength="11" data-validation-error-msg="Please Enter Contact Number">
                                                                </div>     
                                                            </div>
                                                            <div class="col-xs-12"> 
                                                                <div class="form-group field-wrapper1">
                                                                    <label class="show ">Address</label>
                                                                    <input type="text" name="branch_address" id="addre" value="{{$compact_array['branch_detail']->branch_address}}" class="form-control required-des address addr" placeholder="Address" data-validation="required,length" data-validation-optional="false" data-validation-length="max250" maxlength="250" data-validation-error-msg="Please Enter Address">
                                                                </div>     
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>State</label>
                                                                            <select name="dealer_state" class="form-control sta" name="dealer_state">
                                                                                @foreach($compact_array['state'] as $fetch)
                                                                                @if($compact_array['branch_detail']->dealer_state == $fetch->id)
                                                                                <option value="{{$fetch->id}}" selected="">{{$fetch->state_name}}</option>
                                                                                @else
                                                                                <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                                @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>     
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <div class="form-group field-wrapper1">
                                                                            <label>City</label>
                                                                            <select name="dealer_city" class="form-control" id="citys" name="dealer_city"> 
                                                                                @foreach($compact_array['city'] as $fetch)
                                                                                @if($compact_array['branch_detail']->dealer_city == $fetch->city_id)
                                                                                <option value="{{$fetch->city_id}}" selected="">{{$fetch->city_name}}</option>
                                                                                @else
                                                                                <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                                @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>     
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-xs-12">    
                                                                <div class="form-group field-wrapper1">
                                                                    <label>Pincode</label>
                                                                    <input type="text" name="dealer_pincode" value="{{$compact_array['branch_detail']->dealer_pincode}}" class="form-control required-des data-number pin" id="pincode" placeholder="Pincode" data-validation="required,length" data-validation-optional="false" data-validation-length="6" maxlength="6" data-validation-error-msg="Please Enter pincode">
                                                                </div>     
                                                            </div>

                                                            <div class="col-sm-6 col-xs-12">    
                                                                <div class="form-group field-wrapper1">
                                                                    <label>Mail Id</label>
                                                                    <input type="mail" value="{{$compact_array['branch_detail']->dealer_mail}}" name="dealer_mail" class="form-control" placeholder="Mail ID" data-validation="email" data-validation-optional="true">
                                                                </div>     
                                                            </div>
                                                            <div class="col-xs-5">
                                                                <div class="col-sm-6 col-xs-12">    
                                                                    <div class="checkbox checkbox-info form-group">
                                                                        @if($compact_array['branch_detail']->dealer_service == 1)
                                                                        <input type="checkbox" checked="" name="dealer_service" id="inlineCheckbox1">
                                                                        @else
                                                                        <input type="checkbox"  name="dealer_service" id="inlineCheckbox1">
                                                                        @endif
                                                                        <label for="inlineCheckbox1">Service Center</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($compact_array['headquarter_count'] == 1)
                                                            <div class="col-xs-5">
                                                                <div class="col-sm-6 col-xs-12">    
                                                                    <div class="checkbox checkbox-info form-group">
                                                                        <input type="checkbox" checked="" class="headquarter" name=" headquarter" id="inlineCheckbox">
                                                                        <label for="inlineCheckbox"> Headquarter</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @elseif($compact_array['total_headquarter'] == 0)
                                                            <div class="col-xs-5">
                                                                <div class="col-sm-6 col-xs-12">    
                                                                    <div class="checkbox checkbox-info form-group">
                                                                        <input type="checkbox" class="headquarter" name=" headquarter" id="inlineCheckbox">
                                                                        <label for="inlineCheckbox"> Headquarter</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="col-xs-12">
                                                                <iframe id="fetchMap" src="https://maps.google.it/maps?q={{$compact_array['branch_detail']->branch_address}}&output=embed" width="100%" height="200" frameborder="0" scrolling="no" style="border:0" allowfullscreen></iframe>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="reset" class="btn btn-danger cancel_btn">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @include('footer')
    </div>
    <!-- Loading Scripts -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/label-slide.js')}}"></script>
    <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
    <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>


    <script type="text/javascript">
$(document).ready(function () {
    $('#citys').change(function () {
        var address = $('.addr').val();
        var city = $(this).val();
        var State = $('.sta').val();
        var pincode = $('pin').val();
        var url = 'https://maps.google.it/maps?q=' + address + city + State + '&output=embed';
        $('#fetchMap').attr('src', url);
    });
});

    </script>        
    <!-- <script type="text/javascript">
        $(document).ready(function () {
            var to_input = document.getElementById('addre');
            var place;
            var autocomplete = new google.maps.places.Autocomplete(to_input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                place = autocomplete.getPlace();
                $("#addre").focus();
            });
        });
    </script> -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('.cancel_btn').click(function(){
                window.location.replace("{{url('managebranches')}}");
            });
            //State Based City
            $('#citys').on('change', function () {
                setMap();
            });
            var to_input = document.getElementById('addre');
            var place;
            var options = {
                componentRestrictions: {country: "in"}
            };
            var autocomplete = new google.maps.places.Autocomplete(to_input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                place = autocomplete.getPlace();
                var city = '';
                var state = '';
                $.each(place.address_components, function (k, v) {
                    if (v.types[0] == "administrative_area_level_1") {
                        state = v.long_name;
                    }
                    if (v.types[0] == "administrative_area_level_2") {
                        city = v.long_name;
                    }
                });
                console.log(state);
                console.log(city);
                var res = $(".sta option").filter(function () {
                    return this.text == state.trim();
                }).attr('selected', true);
                var res2 = $("#citys option").filter(function () {
                    return this.text == city.trim();
                }).attr('selected', true);
                console.log(res[0]);
                console.log(res2[0]);
                if (res[0] == undefined) {
                    console.log(1)
                    $('.sta option').removeAttr("selected");
                }
                if (res2[0] == undefined) {
                    console.log(2)
                    $('#citys option').removeAttr("selected");
                    selectCity();
                }
                setMap();

            });
        });
        function setMap() {
            var address = $('.addr').val();
            var city = $('#citys').val();
            var State = $('.sta').val();
            var pincode = $('pin').val();
            var url = 'https://maps.google.it/maps?q=' + address + '&output=embed';
            $('#fetchMap').attr('src', url);
        }
        function selectCity() {
            var state = $('.sta').val();
            $('#citys').empty();
            $.ajax({

                url: 'fetch_city',
                type: 'post',
                data: {state: state},
                success: function (response)
                {
                    var json = $.parseJSON(response);
                    $('#citys').append($('<option>', {value: '', text: 'Select Citys'}));
                    $.each(json, function (arrayID, group) {
                        $('#citys').append($('<option>', {value: group.city_id, text: group.city_name}));
                    });
                }
            });
        }
    </script>
</script>
</body>

</html>

<!-- $.ajax({
            url: 'fetch_model_car',
            type: 'post',
            data: {_token: csrf_token, make: make},
            success: function (response)
            {
                var json = $.parseJSON(response);
                $('[name="model"]').append($('<option>', {value: '', text: 'Select Model'}));
                $.each(json, function (arrayID, group) {

                    $('[name="model"]').append($('<option>', {value: group.model_id, text: group.model_name}));
                });
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    }); -->