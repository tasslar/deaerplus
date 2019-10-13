
    /*
      Module Name : Business profile js
      Created By  : Sreenivasan  20 - 03 -2017
      Use of this module is calculation js file 
    */
/*############## Company -Logo ##############*/
/*$('.cpy_logo_save').click(function () {
    $("#loadspinner").css("display", "block");
    var form_data = new FormData($('#logo')[0]);            
    $.ajax({
        url: "company_logo",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        allowedTypes: "jpg,png,gif,jpeg",
        multiple: true,
        type: 'post',
        success: function (response) {
            $("#loadspinner").css("display", "none");
            $('.cpy_logo_save').css('display','none');
            $('.cpy_logo_cancel').css('display','none');                    

        },
        error: function () {
            $("#loadspinner").css("display", "none");

        }
    });
});*/
    /*####################  Cover-Insert ###############*/
$('.com_logo').change(function(){
    $('.cpy_logo_save').css('display','block');
    $('.cpy_logo_cancel').css('display','block');    
});                
$('.cpy_logo_save').click(function(){
    $('#logo').submit();
});
$('#cmp_cov_save').click(function () {
    var form_data = new FormData($('#cover_photo')[0]);
    $("#loadspinner").css("display", "block");
    $.ajax({
        url: "cover_image",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        allowedTypes: "jpg,png,gif,jpeg",
        multiple: true,
        type: 'post',
        success: function (response) {
            $("#loadspinner").css("display", "none");
            $('#cmp_cov_save').css('display','none');
            $('#cmp_cov_cancel').css('display','none');                    

        },
        error: function () {
            $("#loadspinner").css("display", "none");

        }
    });
});



/*############## Remove Image ###################*/
$('.insert_cover').change(function(){
    $('#cmp_cov_save').css('display','block');
    $('#cmp_cov_cancel').css('display','block');
});
$('.remove_cover').click(function () {
    var remove_cover = $('.remove_cover_image').val();
    $("#loadspinner").css("display", "block");
    $.ajax({
        url: "cover_image",
        data: {remove_cover: remove_cover},
        type: 'post',
        success: function (response) {
            $("#loadspinner").css("display", "none");
                                
        },
        error: function () {
            $("#loadspinner").css("display", "none");

        }
    });
});

    /*############ Profile Image Remove ##############*/
/*$('.cpy_logo_cancel').click(function(){*/
    $(document).on('click','.logo_cancel',function(){
    $('.cpy_logo_save').css('display','none');
    $('.cpy_logo_cancel').css('display','none');
    $("#loadspinner").css("display", "block");
    $.ajax({
        url: "remove_logo",                
        type: 'get',
        success: function (response) {
            $('.image').attr('src', response);
            $("#loadspinner").css("display", "none");
                                

        },
        error: function () {
            $("#loadspinner").css("display", "none");

        }
    });            
});



    /*########## Remove- Cover ##################*/
 $('#cmp_cov_cancel').click(function(){
    $('#cmp_cov_save').css('display','none');
    $('#cmp_cov_cancel').css('display','none'); 
    $("#loadspinner").css("display", "block");
    /*var cover_image = "{{$compact_array['dealer_deatails']->coverphoto_logo}}";
     
      */        
      $.ajax({
        url: "remove_cover",                
        type: 'get',
        success: function (response) {
            $("#loadspinner").css("display", "none");
            $('#replace_cover').css('background-image', 'url(' + response + ')');
            $('#image_size').removeClass('fa fa-hand-o-down');
            $('#image_size').html('sucessfully removed');
            console.log(response);
           


        },
        error: function () {
            $("#loadspinner").css("display", "none");

        }
    });   

});

 /*################## Document-Save #########################*/
function funcancel(save,cancel,alertmessage)
{
$('.'+save).addClass('hidden');
$('.'+cancel).addClass('hidden');   
$('#'+alertmessage).addClass('hidden');   
}


function funChange(CancelClass,SaveClass,alertmessage)
{
    $('#'+alertmessage).removeClass("hidden");
    $('.'+SaveClass).removeClass('hidden');
    $('.'+CancelClass).removeClass('hidden');
    $('#'+alertmessage).addClass('hidden');   
}

function funClick(inputClass,saveClass,cancelClass,formId,alertmessage)
{
var form_data = new FormData($('#'+formId)[0]);
    $("#loadspinner").css("display", "block");
    $.ajax({
        url: "business_document",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        allowedTypes: "jpg,png,gif,jpeg",
        multiple: true,
        type: 'post',
        success: function (response) {
            $("#loadspinner").css("display", "none"); 
            if(response == 0)
            {
                $('#'+alertmessage).removeClass("hidden");
                $('#'+alertmessage).css('color','red')
                $('#'+alertmessage).html("filename required");
            }
            else
            {
                $('#'+alertmessage).addClass('hidden');
                $('.'+saveClass).addClass('hidden');
                $('.'+cancelClass).addClass('hidden');                   
                $('.'+inputClass).removeClass('hidden');                   
                $('.'+inputClass).attr('href',response.link);                   
                $('.'+inputClass).attr('download',response.filename);
            }

        },
        error: function () {
            $("#loadspinner").css("display", "none");

        },
    });
}

$(document).on('click', '.viewlisting', function () {
    $('#car_view_id').val($(this).attr('data-id'));
    $('#view_car_managelist').submit();
});




/*#############################profile name############################*/
/*$(".check_name").keyup(function () {
    var name = $(this).val();
    $('.bussiness_name').html(name);
    var profile_name = '{{$compact_array["dealer_deatails"]->profile_name}}';            
    var thisid = this;            
    if (name.length >= 4)
    {
        $.ajax({
            url: "check_name",
            type: "post",
            data: {check_name: name, },
            beforeSend: function () {
                $("#loaderDiv").show();
                $('#sucess_logo').hide();
                $('#warning_logo').hide();
            },
            success: function (data)
            {
                if (data == 0)
                {
                    $("#loaderDiv").hide();
                    $(this).val('');
                    $('.bussiness_name').html(profile_name);
                    $('#profile_name').val(profile_name);
                    $('#sucess_logo').hide();
                    $('#warning_logo').show();
                } else
                {
                    $("#loaderDiv").hide();
                    $("#gif_image").css("display", "none");
                    $("div#gif_image").css('display', 'block');
                    $('#warning_logo').hide();
                    $('#sucess_logo').show();
                    $('#profiles').delay(4000).fadeOut(2000);
                }

            }
        });

    }
});*/

