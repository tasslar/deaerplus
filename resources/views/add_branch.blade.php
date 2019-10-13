@include('header')
<div class="ts-main-content">
    @include('sidebar')
    <div class="content-wrapper myprofile">
        <div class="container-fluid footer-fixed">                
            <div class="row">
                <div class="content-header col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('managebranches')}}"><i class="fa fa-dashboard"></i> Manage</a></li>
                        <li class="active">Branches</li>
                    </ol>
                </div>
                <form method="post" action="{{url('storebranches')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                        <!--<h2 class="page-title">Add Branches</h2>-->
                        <div class="row">
                            <div class="panel-body myprof-tab">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Add New Branch</h4>
                                    </div>
                                    <div class="panel-body" id="contactAddress1">
                                        <div class="col-xs-12" id=""> 
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">	
                                                    <div class="form-group field-wrapper1">
                                                        <label>Branch Name</label>
                                                        <input type="text" name="dealer_name" class="form-control data-name validate-space required-des" placeholder="Branch Name" data-validation="alphanumeric,length" data-validation-allowing="\s_-" data-validation-optional="false" data-validation-length="max50" maxlength="50" data-validation-error-msg="Please Enter Branch name" value="{{old("dealer_name")}}">
                                                    </div>     
                                                </div>
                                                <div class="col-sm-6 col-xs-12">	
                                                    <div class="form-group field-wrapper1">
                                                        <label>Contact Number</label>
                                                        <input type="text" name="dealer_contact_no" class="form-control data-number required-des" placeholder="Contact Number" data-validation="required,length" data-validation-optional="false" data-validation-length="8-11" maxlength="11" data-validation-error-msg="Please Enter Contact Number" value="{{old("dealer_contact_no")}}">
                                                    </div>     
                                                </div>
                                                <div class="col-xs-12">	
                                                    <div class="form-group field-wrapper1">
                                                        <label>Address</label>
                                                        <input type="text" name="branch_address" id="addre" class="form-control addr required-des" placeholder="Address" data-validation="required,length" data-validation-optional="false" data-validation-length="max250" maxlength="250" data-validation-error-msg="Please Enter Address" value="{{old("branch_address")}}">
                                                    </div>     
                                                </div>
                                                <div class="row"><div class="col-xs-12"><div class="col-sm-6 col-xs-12">	
                                                            <div class="form-group field-wrapper1">
                                                                <label>State</label>
                                                                <select name="dealer_state" class="form-control sta">
                                                                    <option selected="true" disabled="disabled">Select State</option>
                                                                    @foreach($compact_array['state'] as $fetch)
                                                                    <option value="{{$fetch->id}}">{{$fetch->state_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>     
                                                        </div>
                                                        <div class="col-sm-6 col-xs-12">	
                                                            <div class="form-group field-wrapper1">
                                                                <label>City</label>
                                                                <select name="dealer_city" class="form-control" id="citys"> 
                                                                    <option selected="true" disabled="disabled">Select City</option>
                                                                    @foreach($compact_array['city'] as $fetch)
                                                                    <option value="{{$fetch->city_id}}">{{$fetch->city_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>     
                                                        </div></div></div>
                                                <div class="col-sm-6 col-xs-12">	
                                                    <div class="form-group field-wrapper1">
                                                        <label>Pincode</label>
                                                        <input type="text" name="dealer_pincode" class="form-control data-number pin required-des" placeholder="Pincode" data-validation="required,length" data-validation-optional="false" data-validation-length="6" maxlength="6" data-validation-error-msg="Please Enter pincode" value="{{old("dealer_pincode")}}">
                                                    </div>     
                                                </div>

                                                <div class="col-sm-6 col-xs-12">	
                                                    <div class="form-group field-wrapper1">
                                                        <label>Mail Id</label>
                                                        <input type="mail" name="dealer_mail" class="form-control" placeholder="Mail ID" data-validation="email" data-validation-optional="true" value="{{old("dealer_mail")}}">
                                                    </div>     
                                                </div>
                                                <div class="col-xs-5">
                                                    <div class="col-sm-6 col-xs-12">	
                                                        <div class="checkbox checkbox-info form-group">
                                                            <input type="checkbox" name="dealer_service" id="inlineCheckbox1">
                                                            <label for="inlineCheckbox1">Service Center</label>
                                                        </div></div>
                                                </div>
                                                @if($compact_array['headquarter_count'] == 0)
                                                <div class="col-xs-5">
                                                    <div class="col-sm-6 col-xs-12">    
                                                        <div class="checkbox checkbox-info form-group">
                                                            <input type="checkbox" checked class="headquarter" name=" headquarter" id="inlineCheckbox">
                                                            <label for="inlineCheckbox"> Headquarter</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="col-xs-12">	
                                                    <iframe id="fetchMap" src="https://maps.google.it/maps?q={{$compact_array['map']}}&output=embed" width="100%" height="200" frameborder="0" scrolling="no" style="border:0" allowfullscreen></iframe>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-danger cancelbtn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form method="get" id="test" action="{{url('managebranches')}}">
                </form>
            </div>
        </div>
        @include('footer')
    </div>
    <!-- Loading Scripts -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">

    <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
    <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/label-slide.js')}}"></script>
    <script src="{{URL::asset('js/fileinput.js')}}"></script>
    <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDha2y052jNjpVKFYewNSOE0wEzgIu1ccI&region-in"></script>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1NuYCJfMo7kutqsXhE2u86eZk7b3Py8I&callback=initMap" type="text/javascript"></script>         -->
    <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('js/common.js')}}"></script>            
    <script type="text/javascript">
$(document).ready(function () {
    $('.headquarter').click(function () {

    });
    $('#message-err').delay(1000).fadeOut(1000);
    $('.cancelbtn').click(function(){
        window.location.replace("{{url('managebranches')}}");
    });
});
    </script>

<!-- <script type="text/javascript">
$(document).ready(function () {
//State Based City
$("#message-err").fadeIn(2000, function ()
{
$(this).delay(4000).fadeOut(20dealeity    = v.long_name;
}
});
console.log(state);
console.log(city);
var res=$(".sta option").filter(function() {
return this.text == state.trim(); 
}).attr('selected', true);
var res2=$("#citys option").filter(function() {
return this.text == city.trim(); 
}).attr('selected', true); console.log(res[0]);console.log(res2[0]);
if(res[0]==undefined){ console.log(1)
$('.sta option').removeAttr("selected");
}
if(res2[0]==undefined){ console.log(2)
$('#citys option').removeAttr("selected");
selectCity();
}
setMap();

});
}); 
function setMap(){
var address = $('.addr').val();
var city = $('#citys').val();
var State = $('.sta').val();
var pincode = $('pin').val();
var scroll = map.disableScrollWheelZoom();
console.log(scroll);
return false;
var url = 'https://maps.google.it/maps?q=' + address + '&output=embed'+scroll+;
$('#fetchMap').attr('src', url);
}
function selectCity(){
var state = $('.sta').val();
$('#citys').empty();
$.ajax({

url:'fetch_city',
type:'post',
data:{state:state},
success:function(response)
{            
var json = $.parseJSON(response);
$('#citys').append($('<option>',{value:'',text:'Select Citys'}));
$.each(json, function(arrayID,group) {                    
      $('#citys').append($('<option>', {value:group.city_id, text:group.city_name}));
});
}
});
}
</script> -->
</body>

</html>