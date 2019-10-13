
@include('header')
@include('sidebar')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="content-header col-sm-12">
                <div><ol class="breadcrumb">
                        <li><a href="{{url('/buy')}}"><i class="fa fa-dashboard"></i> Buy</a></li>
                        <li class="active">Search</li>
                    </ol></div>
            </div>
            <div class="col-md-12 buylist">


                <div class="row">
                    <div class="col-md-12">
                        <div class="search-car col-sm-5 col-sm-offset-3">
                            <h3 class="text-uppercase text-center">Search the right car</h3>
                            <form method="post" action="searchcarlisting" id="searchcarlisting">
                                <div class="form-group field-wrapper">
                                    <label>Car Sites</label>
                                    
                                    <select title="Select Websites" class="selectpicker" name="car_sites[]" multiple >
<!--                                        <option value="" selected="true" disabled="disabled">Select Car Sites</option>-->

                                        @foreach($compact_array['api_sites'] as $fetch)
                                        <option data-id="{{$fetch->sitename}}" value="{{$fetch->sitename}}">{{$fetch->sitename}}</option>
                                        @endforeach
                                    </select> </div>
                                <div class="form-group field-wrapper">
                                    <label>City</label>
                                    <select class="form-control" name="city_name">
                                        <option value="" selected="true" disabled="disabled">Select City</option>
                                        @foreach($compact_array['master_city'] as $fetch)
                                        <option data-id="{{$fetch->city_name}}" value="{{$fetch->city_name}}">{{$fetch->city_name}}</option>
                                        @endforeach
                                    </select></div>
                                <div class="form-group">
                                    <div class="radio radio-primary radio-inline">
                                        <input type="radio" id="budget" value="1" name="radioInline" checked="">
                                        <label for="budget"> By Budget </label>
                                    </div>
                                    <div class="radio radio-primary radio-inline">
                                        <input type="radio" id="model" value="2" name="radioInline">
                                        <label for="model"> By Model </label>
                                    </div>

                                </div>
                                <div class="bybudget"><div class="form-group field-wrapper">
                                        <label>Select Budget</label>
                                        <select class="form-control" name="car_budget" data-validation="required" data-validation-optional="true">
                                            <option value="" selected="true" disabled="disabled">Select Budget</option>
                                            <option value="0-100000">Below 1 Lakh
                                            <option value="100000-300000">1 Lakh-3 Lakh</option>
                                            <option value="300000-500000">3 Lakh - 5 Lakh</option>
                                            <option value="500000-1000000">5 Lakh - 10 Lakh</option>
                                            <option value="1000000-2000000">10 Lakh - 20 Lakh</option>
                                            <option value="2000000-above">Above 20 Lakh</option>
                                        </select></div>
                                    <div class="form-group field-wrapper">
                                        <label>Body Type</label>
                                        <select class="form-control" name="vehicle_type" data-validation="required" data-validation-optional="true">
                                            <option value=""selected="true" disabled="disabled">All Body Type</option>
                                            <option value="HATCHBACK">Hatch back</option>
                                            <option value="MUV">MUV</option>
                                            <option value="LUXURY">Luxury</option>
                                            <option value="HYBRID">Hybrid</option>
                                            <option value="SEDAN">Sedan</option>
                                        </select></div></div>
                                <div class="bymodel"><div class="form-group field-wrapper">
                                        <label>Make</label>
                                        <select class="form-control" name="vehicle_make" data-validation="required" data-validation-optional="true">
                                            <option value=""selected="true" disabled="disabled">Select Make</option>
                                            @foreach($compact_array['make'] as $fetch)
                                            <option data-id="{{$fetch->make_id}}" value="{{$fetch->make_id}}">{{$fetch->makename}}</option>
                                            @endforeach
                                        </select></div>
                                    <div class="form-group field-wrapper">
                                        <label>Model</label><select class="form-control" name="vehicle_model" data-validation="required" data-validation-optional="true">
                                            <option value="">Select Model</option>
                                        </select></div></div>

                                <input type="hidden" name="page_name" value="searchpage">

                                <input  class="btn btn-primary btn-block buy-search" type="submit" value="SEARCH">
                            </form>
                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>
    @include('footer')
</div>

<!-- Loading Scripts -->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
<script src="{{URL::asset('js/dealerplus.js')}}"></script>
<script src="{{URL::asset('js/label-slide.js')}}"></script>
<script>
$(document).ready(function () {
    $("#budget").click(function () {
        $(".bymodel").hide().slow;
        $(".bybudget").show().slow;
    });
    $("#model").click(function () {
        $(".bymodel").show().slow;
        $(".bybudget").hide().slow;
    });


    $('#budget').prop('checked',true);
    $("select option").prop("selected", false);
    $('[name="city_name"],[name="car_budget"],[name="vehicle_type"],[name="vehicle_make"]').val('');
    
    $('[name="vehicle_make"]').change(function () {
        var make = [$(this).val()];
        /*alert();*/
        var csrf_token = $('#token').val();
        $('[name="vehicle_model"]').empty();
        $.ajax({
            url: 'fetch_model',
            type: 'post',
            data: {_token: csrf_token, make: make},
            success: function (response)
            {
                var json = $.parseJSON(response);
                $('[name="vehicle_model"]').append($('<option>', {value: '', text: 'Select Model'}));
                $.each(json, function (arrayID, group) {
                    $('[name="vehicle_model"]').append($('<option>', {value: group.model_name, text: group.model_name}));
                });
            },
            error: function (e)
            {
                console.log(e.responseText);
            }
        });
    });
});

</script>

</body>

</html>