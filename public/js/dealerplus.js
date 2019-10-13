/*$(function()
{
   $( "#q" ).autocomplete({
    source : "autocomplete",
    //minLength: 3,
    select: function(event, ui) {
      $('#q').val(ui.item.value);
    }
  });
});*/
function validatedecimalKeyPress(el, evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        var number = el.value.split('.');
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        //just one dot
        if(number.length>1 && charCode == 46){
             return false;
        }
        //get the carat position
        var caratPos = getSelectionStart(el);
        var dotPos = el.value.indexOf(".");
        if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
            return false;
        }
        return true;
    }
    function getSelectionStart(o) {
        if (o.createTextRange) {
            var r = document.selection.createRange().duplicate()
            r.moveEnd('character', o.value.length)
            if (r.text == '')
                return o.value.length
            return o.value.lastIndexOf(r.text)
        } else
            return o.selectionStart
    }
 function dealerPlusUtility()
{
	this.indianPriceFormate = function(h) {
        h = h.toString();
        h = h.replace(/,/g, "");
        h = h.replace(/^0+/, "");
        var e = h.substring(h.length - 3);
        var a = h.substring(0, h.length - 3);
        if (a != "") {
            e = "," + e;
        }
        var n = a.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + e;
        return n;
    };
	this.convertToIndianPriceString =function(u) {
		
		 u = u.replace(/,/g, "");
        var o = parseInt(u, 10);
        o = Math.floor(o);
		if (isNaN(o)) 
		{
			return "";
		}
		if (Number(o) == 0) 
		{
			return "Zero Rupees Only";
		}
		if (Number(o) == 1) 
		{
			return "One Rupee only";
		}
		var t = new String(o);
        numReversed = t.split("");
        actnumber = numReversed.reverse();
        var w = [" Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
        var h = [" Ten", " Eleven", " Twelve", " Thirteen", " Fourteen", " Fifteen", " Sixteen", " Seventeen", " Eighteen", " Nineteen"];
        var n = ["dummy", " Ten", " Twenty", " Thirty", " Forty", " Fifty", " Sixty", " Seventy", " Eighty", " Ninety"];
        var A = numReversed.length;
        var a = "";
        var e = new Array();
        var y = "";
        j = 0;
        for (i = 0; i < A; i++) {
            switch (i) {
                case 0:
                    if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
                        e[j] = "";
                    } else {
                        e[j] = w[actnumber[i]];
                    }
                    e[j] = e[j] + " Rupees Only";
                    break;
                case 1:
                    v();
                    break;
                case 2:
                    if (actnumber[i] == 0) {
                        e[j] = "";
                    } else {
                        if (actnumber[i - 1] != 0 && actnumber[i - 2] != 0) {
                            e[j] = w[actnumber[i]] + " Hundred and";
                        } else {
                            e[j] = w[actnumber[i]] + " Hundred";
                        }
                    }
                    break;
                case 3:
                    if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
                        e[j] = "";
                    } else {
                        e[j] = w[actnumber[i]];
                    }
                    if (actnumber[i + 1] != 0 || actnumber[i] > 0) {
                        e[j] = e[j] + " Thousand";
                    }
                    break;
                case 4:
                    v();
                    break;
                case 5:
                    if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
                        e[j] = "";
                    } else {
                        e[j] = w[actnumber[i]];
                    }
                    if (actnumber[i + 1] != 0 || actnumber[i] > 0) {
                        e[j] = e[j] + " Lakh";
                    }
                    break;
                case 6:
                    v();
                    break;
                case 7:
                    if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
                        e[j] = "";
                    } else {
                        e[j] = w[actnumber[i]];
                    }
                    e[j] = e[j] + " Crore";
                    break;
                case 8:
                    v();
                    break;
                default:
                    break;
            }
            j++;
			
        }
		
		function v() {
            if (actnumber[i] == 0) {
                e[j] = "";
            } else {
                if (actnumber[i] == 1) {
                    e[j] = h[actnumber[i - 1]];
                } else {
                    e[j] = n[actnumber[i]];
                }
            }
        }
        e.reverse();
        for (i = 0; i < e.length; i++) {
            y += e[i];
        }
		return y;
	}
	
}
$('.select_value').change(function(){
   var select_value  = $(this).val();
   $('#car_searchs').val(select_value);  
   if(select_value == 1)
   {
        $('#search_values').attr("action","dealer_search");
   }
   else
   {
        $('#search_values').attr("action","searchcarlisting");
   }
});
$('.search').click(function(){
   var select_value  = $('.select_value').val();
   if(select_value == 1)
   {
     var dealer_value = $('.search_value').val();
     $('.dealer_value').val(dealer_value);
     $('#search_values').submit();
   }
   else
   {
     var car_value = $('.search_value').val();
     $('#car_searchs').val(car_value);
     $('#search_values').submit();
   }
});
$(document).ready(function () {
    /*Format to String Price for INR*/
    
    var addListingNumberFormat = new dealerPlusUtility();
	try
	{
	$('.price-format').blur(function(e) {
				var u=e.target.value;
				var y=addListingNumberFormat.convertToIndianPriceString(u);
				
				var newPriceSpan = document.createElement('span');
				var textnode = document.createTextNode(y);         // Create a text node
				newPriceSpan.appendChild(textnode); 
				newPriceSpan.className = "price-string";
				var parentDiv = e.target.parentNode;
				if (parentDiv.lastChild.className == "price-string" )
				{
					parentDiv.lastChild.innerHTML = y;
				}
				else
				{
				parentDiv.appendChild(newPriceSpan);
				}
				
    });
	}
	catch(e){}
    $('body').on("click",".comparelisting",function(){
        var listingid = $(this).attr('data-car-id');
        var csrf_token = $('#token').val();
        var thisid = this;
        var dataduplicte = 0;
        var compare_datalength = 0;
        if($('#compare_data_text').val()!='')
        {
            var compare_data = $('#compare_data_text').val().split(",");
            var databuild ='';
            compare_datalength = compare_data.length;
            $.each(compare_data,function(i){
                //alert(compare_data[i]);
                if(compare_data[i]!=listingid)
                {
                    if(compare_data[i]!='')
                    {
                        if(databuild=='')
                        {
                            databuild=compare_data[i]+',';
                        }
                        else
                        {
                            databuild=databuild+compare_data[i]+',';
                        }
                    }
                }
                else
                {
                    dataduplicte++;
                    compare_datalength--;
                    compare_datalength--;
                }
            });
            
            if(parseInt(compare_datalength)>4)
            {
                alert('Please note that maximum of 4 Cars can be compared');
                return false;
            }
            if(parseInt(dataduplicte)>0)
            {
                $(this).removeClass('detail-wishlist-active');
                $(this).next().next("span").css('display','none');
                $(this).next("span").css('display','none');
                
            }
            else
            {
                $(this).addClass('detail-wishlist-active');
                $(this).next().next("span").css('display','');
                $(this).next("span").css('display','');
                databuild=databuild+listingid+',';   
                //compare_datalength++;
            }
        }
        else
        {
            $(thisid).addClass('detail-wishlist-active');
            $(this).next().next("span").css('display','');
            databuild=listingid+',';
            compare_datalength=1;
        }
        
        //alert(databuild);
        $('#compare_data_text').val(databuild);
        $('.compare-count').text('('+compare_datalength+')');
        
    });

    $('.comparepage').click(function () {
        var compare_data = $('#compare_data_text').val().split(",");
        compare_datalength = compare_data.length;
        if(compare_data==''||compare_datalength<=1)
        {
            alert('Please Select Listing for Compare');
            return false;
        }
        

        $('#compare_data_form').submit();
    });

   
});
$(document).ready(function () {
   try {
    $("#search-slide").slideUp(0);
    $("#search-slide").toggleClass('search-hide');
    $('.menu-btn').click(function () {
        $('nav.ts-sidebar').toggleClass('menu-open');
    });
   } catch(e){};
});
//Added By Naveen - 28-02-2017
//For Comet Chat Popup
$('body').on("click",".cometchat",function(){
    var cometid = $(this).attr('data-comet-id');
    $('#'+cometid).click();
});

function cometchatuserstatus()
{
    $(".cometchat").each(function() {
        var cometid = $(this).attr('data-comet-id');
        if($('#'+cometid+' div:nth-child(3) div:nth-child(1)').hasClass('cometchat_user_available'))
        { $(this).children('span:first').css('background','#36b581'); }
        else if($('#'+cometid+' div:nth-child(3) div:nth-child(1)').hasClass('cometchat_user_away'))
        { $(this).children('span:first').css('background','#efbe4d'); }
        else if($('#'+cometid+' div:nth-child(3) div:nth-child(1)').hasClass('cometchat_user_busy'))
        { $(this).children('span:first').css('background','#eb5160'); }
        else
        { $(this).children('span:first').css('background','#ffffff'); }
    });
    setTimeout(cometchatuserstatus,10000);
}
//End
$(".search-click").click(function () {
    $("#search-slide").slideToggle();
});
//tooltip
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
$("body").on('mouseover', "#profile", function () {
     $('[data-toggle="tooltip"]').tooltip();
});

//notification show
try {
            $("#msg-1").on("click", function() {
                $('.sys-notify').toggle();
                $('.sys-notify-msg,.sys-notify-alert').hide();
            });
            $("#msg-2").on("click", function() {
                $('.sys-notify-msg').toggle();
                $('.sys-notify,.sys-notify-alert').hide();
            });
            $("#msg-3").on("click", function() {
                $('.sys-notify-alert').toggle();
                $('.sys-notify-msg,.sys-notify').hide();
            });
	       /*$("#msg-1, .sys-notify").on("mouseover", function() {
                $('.sys-notify').show();
            });
            $("#msg-1, .sys-notify").on("mouseleave", function() {
                $('.sys-notify').hide();
            });
            $("#msg-2, .sys-notify-msg").on("mouseover",function () {
                $('.sys-notify-msg').show();
            });
            $("#msg-2, .sys-notify-msg").on("mouseleave",function () {
                $('.sys-notify-msg').hide();
            });
            $("#msg-3, .sys-notify-alert").on("mouseover",function () {
                $('.sys-notify-alert').show();
            });
            $("#msg-3, .sys-notify-alert").on("mouseleave",function () {
                $('.sys-notify-alert').hide();
            });*/
            $(".msg-1-res").on("click", function() {
                $('.sys-notify').toggle();
            });
            $(".msg-2-res").on("click", function() {
                $('.sys-notify-msg').toggle();
            });
            $(".msg-3-res").on("click", function() {
                $('.sys-notify-alert').toggle();
            });
}catch(e1){};

try {
//    date script
    $('.date').datetimepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        startView: "month",
        minView: "month",
        maxView: "decade"
    });

    $('.fundingdate').datetimepicker({
        autoclose: true,
        useCurrent:true,
        format: "yyyy-mm-dd",
        startView: "month",
        minView: "month",
        maxView: "decade"
    });
    
    $('.date1').datetimepicker({
        autoclose: true
    });
//    datatable script
    $('#zctb').DataTable();

//    allow extension
    $("#input-43").fileinput({
        showPreview: false,
        allowedFileExtensions: ["zip", "rar", "gz", "tgz"],
        elErrorContainer: "#errorBlock43"
                // you can configure `msgErrorClass` and `msgInvalidFileExtension` as well
    });
} catch (e2) {

};
//remove cut,copy,paste in input box

$('input').bind("cut copy paste", function (e) {
    e.preventDefault();
});

var cloneCounter = 0;
$(document).on('click', '.cloneAdd', function ($this) {
    cloneCounter++;
    var oCloneId = $(this).parent().attr('id');
    var oClone = document.getElementById(oCloneId + 'Clones').cloneNode(true);
    oClone.id = (oCloneId + 'Rows');
//    oClone.className = (oCloneId + 'C')
    var oCloneParent = $(this).parent().attr('id');
    document.getElementById(oCloneId).appendChild(oClone);
    if ($('#' + oCloneId + 'Rows').length > 0) {
        $('.cloneRemove').show();
    }

});

//remove clone section
$(document).on('click', '.cloneRemove', function ($this) {
    cloneCounter--;
    var oCloneId = $(this).parents(".cloneSet").attr('id');
    $('#' + oCloneId).remove();
});

//hide clone remove button
$(document).ready(function () {
   try{
    $('.cloneRemove').hide();
   }
   catch(e3){};
});

//edit section
$(document).on('click', '.editAdd', function ($this) {
    var editId = $(this).parent().attr('id');
    var parentInputs = document.getElementById(editId);
    $("#" + editId + " input").each(function () {
        $(this).attr('readOnly', false);
        $(this).attr('class', 'editEnabled form-control');
    });
});

//Key press validation


$(document).ready(function () {
    //File Upload Restrictions
    $("body").on("change", ".fileuploadrestriction", function () {
        var filemb = parseFloat($(this)[0].files[0].size)/1048576;
        var fileuploadrestrict = $(this).attr('data-size');
        var data_format = $(this).attr('data-format');

        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['doc','docx','pdf','jpg','jpeg','png']) == -1) {
            alert('Please Upload Supported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png');
            $(this).val('');
            $(this).parent().find('.bootstrap-filestyle .form-control').val('');
            return false;
        }

        
        if(parseFloat(filemb)>parseFloat(fileuploadrestrict))
        {
            alert('Please Upload upto '+fileuploadrestrict+'MB');
            $(this).val('');
            $(this).parent().find('.bootstrap-filestyle .form-control').val('');
            return false;
        }
    });
    //Disable Enter Key
    $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

    
    
//Input Numbers
    //$('.data-number').keydown(function (e) {
    $(document).on('keydown', '.data-number', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A, Command+A

                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {

                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.keyCode === 32 || e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

    //$('.data-decimal').keydown(function (e) {
    $(document).on('keydown', '.data-decimal', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .

        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110,190]) !== -1 ||
                // Allow: Ctrl+A, Command+A

                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.keyCode === 32 || e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    
                    e.preventDefault();
                }
            });

    //$('.data-name').keydown(function (e) {
    $(document).on('keydown', '.data-name', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 32]) !== -1 ||
                // Allow: Ctrl+A, Command+A

                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {

                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 90)) {
                    e.preventDefault();
                }
            });
});

$(document).on('keydown', '.data-password', function (e) {
    if(e.keyCode == 32)
    {
     e.preventDefault();
    }
});
$(document).on('blur', '.percentagevalidation', function (e) {
       if(parseFloat($(this).val())>100)
       {
        alert('Please Enter Less Than 100');
        $(this).val(0);
        $(this).focus();
        return false;
       }
});

// Form validation
$.validate();
$(document).on('click', '.btn-primary', function (e) {
	
    $.validate({
        onError: function ($form) {
			e.preventDefault();
            return false;
        },
        onSuccess: function ($form) {
            console.log("Form valid");
    
        }
    });


});
$(document).on('click', '.aria-validate', function ($this) {
    $.validate({
        onError: function ($form) {

            return false;
        },
        onSuccess: function ($form) {
            console.log("test");
            $("form .aria-primary").click();

        }
    });


});
$('.pan_number').keypress(function (e) {
    //alert(e.charCode);
    if((e.charCode > 0) && (e.charCode < 97 || e.charCode > 122) && (e.charCode < 65 || e.charCode > 90) && (e.charCode != 8) && (e.charCode < 48 || e.charCode > 57) ) {
        return false;
    }
});