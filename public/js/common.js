
/*
  Module Name : Manage 
  Created By  : Sreenivasan  19-1-2017
  Use of this module is common js file
*/

$(document).ready(function () {
    //State Based City        
    $('#message-err').delay(1000).fadeOut(1000);
        $('.sta').change(function(){
           selectCity();
        });

        var to_input = document.getElementById('addre');
        var place;
        var autocomplete = new google.maps.places.Autocomplete(to_input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            place = autocomplete.getPlace();
            $("#addre").focus();
        });

        var to_input = document.getElementById('other_address');
        var place;
        var autocomplete = new google.maps.places.Autocomplete(to_input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            place = autocomplete.getPlace();
            $("#other_address").focus();
        });
});
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
            $('#citys').append($('<option>',{value:'',text:'Select City'}));
            $.each(json, function(arrayID,group) {                    
                  $('#citys').append($('<option>', {value:group.city_id, text:group.city_name}));
          });
        }
    });
}
$(document).ready(function () {
    //State Based City
    $('#citys').on('change',function () {
       setMap();
    });
    var to_input = document.getElementById('addre');
    var place;
    var options = {
          componentRestrictions: { country: "in" }
    };
    var autocomplete = new google.maps.places.Autocomplete(to_input,options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        place = autocomplete.getPlace();
        var city    ='';
        var state   ='';
        $.each(place.address_components,function(k,v){
            if(v.types[0]=="administrative_area_level_1"){
                state   = v.long_name;
            }
            if(v.types[0]=="administrative_area_level_2"){
                city    = v.long_name;
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
    var url = 'https://maps.google.it/maps?q=' + address + '&output=embed';
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
            $('#citys').append($('<option>',{value:'',text:'Select City'}));
            $.each(json, function(arrayID,group) {                    
                  $('#citys').append($('<option>', {value:group.city_id, text:group.city_name}));
          });
        }
    });
}