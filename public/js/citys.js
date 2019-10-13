
$(document).ready(function () {
    //State Based City        
    $('#message-err').delay(1000).fadeOut(1000);
        $('#state2').change(function(){
           changecity();
        });

        var to_input = document.getElementById('address2');
        var place;
        var autocomplete = new google.maps.places.Autocomplete(to_input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            place = autocomplete.getPlace();
            $("#address2").focus();
        });
});
$(document).ready(function () {
    //State Based City
    var to_input = document.getElementById('address2');
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
         var res=$("#state2 option").filter(function() {
            return this.text == state.trim(); 
        }).attr('selected', true);
        var res2=$("#citys2 option").filter(function() {
            return this.text == city.trim(); 
        }).attr('selected', true); console.log(res[0]);console.log(res2[0]);
        if(res[0]==undefined){ console.log(1)
            $('#state2 option').removeAttr("selected");
        }
        if(res2[0]==undefined){ console.log(2)
            $('#citys2 option').removeAttr("selected");
            changecity();
        }
        
    });
}); 
