
    /*
      Module Name : Quotes calc 
      Created By  : Sreenivasan  20 - 03 -2017
      Use of this module is calculation js file 
    */
$('.invoiceStartDate').change(function () {
    var startDate = $('.invoiceStartDate').val();
    var endDate   = $('.invoiceEndDate').val();

    if(new Date(startDate) > new Date(endDate))
        {
            //alert('First Date should be lessthan DueDate');
        $( "#invoiceEndDates" ).datetimepicker("setDate",new Date(startDate));
        //$(".invoiceStartDate").val("");
    }
    $( "#invoiceEndDates" ).datetimepicker("setStartDate",new Date(startDate));
});
$(document).on('change', ".car_listing", function () {

});
$(document).on('click', ".remove-item", function () {
    $(this).parent().parent().remove();
    $(".sno").each(function (index) {
        $(this).text(index + 1);
    });
    $('.invoicebody tr:first-child').addClass('tr_clone');
    var numItems = $('.sno').length;
    if(parseFloat(numItems)<=1)
    {
        $('.remove-item').attr('disabled',true);
    }
    $(".sno").each(function (index) {
        $(this).next().next().next().find(".carprice").prop('id', 'test' + index);
        $(this).next().next().next().find(".carsaleprice").prop('id', 'carsaleprice' + index);
        $(this).parent().find(".discount").prop('id', 'discount' + index);
        $(this).parent().find(".tax_rate").prop('id', 'tax_rate' + index);
        $(this).parent().find(".sub_total").prop('id', 'sub_total' + index);
        $(this).parent().find(".quantity").prop('id', 'quantity' + index);
        $(this).parent().find(".amt_type").prop('id', 'amt_type' + index);
        $(this).parent().find(".cardescription").prop('id', 'cardescription' + index);
        $(this).text(index + 1);
        //totalSum();
    });
    totalsum();
});
$(".tr_clone_add").on('click', function () {
    var numItems = $('.sno').length;
    $('.remove-item').attr('disabled',false);
    var $tr = $(".clone-row").children().children('.tr_clone');
    var $clone = $tr.clone();
    $clone.find(':text').val('');
    $clone.removeClass('tr_clone');
    $clone.find('[disabled]').removeAttr("disabled");
    $('.invoicebody').append($clone);
    $('.quantity').attr("disabled", "disabled");
    $('.option1').attr("disabled", "disabled");
    $('.option2').attr("disabled", "disabled");
    $('.option3').attr("disabled", "disabled");
    var option1        =$('.option1').last().val("");
    var option2        =$('.option2').last().val("");
    var option3        =$('.option3').last().val("");
    var quantity       =$('.quantity').last().val("1");
    var discount       =$('.discount').last().val('0'); 
    var cardescription = $('.cardescription').last().val("");    
    $(".sno").each(function (index) {
        $(this).next().next().next().find(".carprice").prop('id', 'test' + index);
        $(this).next().next().next().find(".carsaleprice").prop('id', 'carsaleprice' + index);
        $(this).parent().find(".discount").prop('id', 'discount' + index);
        $(this).parent().find(".tax_rate").prop('id', 'tax_rate' + index);
        $(this).parent().find(".sub_total").prop('id', 'sub_total' + index);
        $(this).parent().find(".quantity").prop('id', 'quantity' + index);
        $(this).parent().find(".amt_type").prop('id', 'amt_type' + index);
        $(this).parent().find(".cardescription").prop('id', 'cardescription' + index);
        $(this).text(index + 1);
        //totalSum();
    });
});
function carprice(data)
{
    var ndata = $(data).parent().next().next().find(".carprice").attr('id');
    var sdata = $(data).parent().next().next().find(".carsaleprice").attr('id');
    alert(sdata);
    var car_id = $(data).val();
    var token = $('#token').val();
    $.ajax({
        url: 'car_price',
        data: {car_id: car_id, token: token},
        type: 'post',
        success: function (response) {
            $('#' + ndata).val(response);
            $('#' + sdata).val(response);
             totalsum();
        },
        error: function () {
            $("#loadspinner").css("display", "none");

        }
    });
}
$(document).on('keyup', ".carprice", function () {
    var carprice = $(this).val();
    var carpriceid = $(this).attr('id');
    var carpricesplit = carpriceid.split("test");
    var carsaleprice = $('#carsaleprice'+carpricesplit[1]).val();
    if(parseFloat(carprice)>parseFloat(carsaleprice))
    {
        alert('Please Enter Less Than Amount of Car Price');
        $(this).val(carsaleprice);
        return false;
    }

});
$(document).on('keyup', ".discount", function () {
    var discount = $(this).val();
    var discountid = $(this).attr('id');
    var discountsplit = discountid.split("discount");
    var amt_type = $('#amt_type'+discountsplit[1]).val();
    var carsaleprice = $('#test'+discountsplit[1]).val();
    if(amt_type==1&&parseFloat(discount)>parseFloat(carsaleprice))
    {
        alert('Please Enter The Less Than Sale Price');
        $(this).val(0);
        return false;
    }
    else if(amt_type==2&&parseFloat(discount)>parseFloat(100))
    {
        alert('Please Enter The Less Than 100%');
        $(this).val(0);
        return false;
    }
});

$(document).on('keyup', "#totalinvdist", function () {

        if(parseFloat($('#grand_total').val())<parseFloat($('#totalinvdist').val()))
        {
            alert('Please Enter Less Than Total Amount');
            $('#totalinvdist').val(0);
            return false;
        }
    });


$(document).on('blur', "input[type='text'],select", function () {
    totalsum();
});

function percentcalc(percent,value)
{
    return ((parseFloat(percent)/100)*parseFloat(value));
}
function totalsum()
{
    var totaltax = 0;
    var totaldiscount = 0;
    var grand_total = 0;
    var totaldisct_typ = $('#totaldisct_typ').val();
    var totalinvdist = $('#totalinvdist').val();
    if(totalinvdist=='')
    {
        totalinvdist=0
    }
    $(".sno").each(function (index) {
        var carprice = $('#test'+index).val();
        if(carprice=='')
        {
            carprice=0
        }
        var carsaleprice = $('#carsaleprice'+index).val();
        if(carsaleprice=='')
        {
            carsaleprice=0
        }
        if(parseFloat(carprice)>parseFloat(carsaleprice))
        {
            carprice=carsaleprice;
        }
        var discount = $('#discount'+index).val();
        if(discount=='')
        {
            discount=0
        }
        var tax_rate = $('#tax_rate'+index).val();
        if(tax_rate=='')
        {
            tax_rate=0
        }
        var quantity = $('#quantity'+index).val();
        var amt_type = $('#amt_type'+index).val();
        var taxamount = percentcalc(tax_rate,carprice);
        totaltax = parseFloat(totaltax)+parseFloat(taxamount);
        var pricewithtax = parseFloat(carprice)+parseFloat(taxamount);
        if(amt_type==1)
        {
            if(parseFloat(carprice)<parseFloat(discount))
            {
                $('#discount'+index).val(0);
                discount = 0;
            }
            totaldiscount = parseFloat(totaldiscount)+parseFloat(discount);
            var pricewithdiscount = parseFloat(pricewithtax)-parseFloat(discount);
        }
        else if(amt_type==2)
        {
            $('#discount'+index).keyup(function(){
                if($('#amt_type'+index).val()==2)
                {
                    if ($(this).val() > 100){
                        //alert("No numbers above 100");
                        $(this).val('0');
                    }
                }
            });
            var discountamount = percentcalc(discount,pricewithtax);
            totaldiscount = parseFloat(totaldiscount)+parseFloat(discountamount);
            var pricewithdiscount = parseFloat(pricewithtax)-parseFloat(discountamount);   
        }
        pricewithdiscount = parseFloat(pricewithdiscount).toFixed(2);
        grand_total = parseFloat(grand_total)+parseFloat(pricewithdiscount);
        $('#sub_total'+index).val(pricewithdiscount);
    });
    if(totaldisct_typ==1)
    {
        totaldiscount = parseFloat(totaldiscount)+parseFloat(totalinvdist);
        grand_total = parseFloat(grand_total)-parseFloat(totalinvdist);
    }
    else if(totaldisct_typ==2)
    {
        $('#totalinvdist').keyup(function(){
            if($('#totaldisct_typ').val()==2)
            {
                if ($(this).val() > 100){
                    //alert("No numbers above 100");
                    $(this).val('0');
                }
            }
        });
        var discountamount = percentcalc(totalinvdist,grand_total);
        totaldiscount = parseFloat(totaldiscount)+parseFloat(discountamount);
        grand_total = parseFloat(grand_total)-parseFloat(discountamount);   
    }
    if(parseFloat(grand_total)<0)
    {
        $('#totalinvdist').val(0);
        totalinvdist=0;
        $(".sno").each(function (index) {
            var carprice = $('#test'+index).val();
            if(carprice=='')
            {
                carprice=0
            }
            var carsaleprice = $('#carsaleprice'+index).val();
            if(carsaleprice=='')
            {
                carsaleprice=0
            }
            if(parseFloat(carprice)>parseFloat(carsaleprice))
            {
                carprice=carsaleprice;
            }
            var discount = $('#discount'+index).val();
            if(discount=='')
            {
                discount=0
            }
            var tax_rate = $('#tax_rate'+index).val();
            if(tax_rate=='')
            {
                tax_rate=0
            }
            var quantity = $('#quantity'+index).val();
            var amt_type = $('#amt_type'+index).val();
            var taxamount = percentcalc(tax_rate,carprice);
            totaltax = parseFloat(totaltax)+parseFloat(taxamount);
            var pricewithtax = parseFloat(carprice)+parseFloat(taxamount);
            if(amt_type==1)
            {
                if(parseFloat(carprice)<parseFloat(discount))
                {
                    $('#discount'+index).val(0);
                    discount = 0;
                }
                totaldiscount = parseFloat(totaldiscount)+parseFloat(discount);
                var pricewithdiscount = parseFloat(pricewithtax)-parseFloat(discount);
            }
            else if(amt_type==2)
            {
                $('#discount'+index).keyup(function(){
                    if($('#amt_type'+index).val()==2)
                    {
                        if ($(this).val() > 100){
                            //alert("No numbers above 100");
                            $(this).val('0');
                        }
                    }
                });
                var discountamount = percentcalc(discount,pricewithtax);
                totaldiscount = parseFloat(totaldiscount)+parseFloat(discountamount);
                var pricewithdiscount = parseFloat(pricewithtax)-parseFloat(discountamount);   
            }
            pricewithdiscount = parseFloat(pricewithdiscount).toFixed(2);
            grand_total = parseFloat(grand_total)+parseFloat(pricewithdiscount);
            $('#sub_total'+index).val(pricewithdiscount);
        });
        if(totaldisct_typ==1)
        {
            totaldiscount = parseFloat(totaldiscount)+parseFloat(totalinvdist);
            grand_total = parseFloat(grand_total)-parseFloat(totalinvdist);
        }
        else if(totaldisct_typ==2)
        {
            $('#totalinvdist').keyup(function(){
                if($('#totaldisct_typ').val()==2)
                {
                    if ($(this).val() > 100){
                        //alert("No numbers above 100");
                        $(this).val('0');
                    }
                }
            });
            var discountamount = percentcalc(totalinvdist,grand_total);
            totaldiscount = parseFloat(totaldiscount)+parseFloat(discountamount);
            grand_total = parseFloat(grand_total)-parseFloat(discountamount);   
        }
    }
    grand_total = parseFloat(grand_total).toFixed(2);
    totaldiscount = parseFloat(totaldiscount).toFixed(2);
    $('#grand_total').val(grand_total);
    $('#finaldiscount').val(totaldiscount);   
}
function fun(data)
{

    var thisid = data;
    var car_listing = $(thisid).val();
    $(thisid).removeClass('car_listing');
    $(".car_listing").each(function (index) {
        //console.log($(this).val());
        if(car_listing==$(this).val())
        {
            alert('This Car is already added');
            $(thisid).val('');
            return false;
        }
    });
    $(thisid).addClass('car_listing');
    var ndata = $(data).parent().next().next().find(".carprice").attr('id');
    var sdata = $(data).parent().next().next().find(".carsaleprice").attr('id');
    var car_id = $(data).val();
    var token = $('#token').val();
    $.ajax({
        url: 'car_price',
        data: {car_id: car_id, token: token},
        type: 'post',
        success: function (response) {
            $('#' + ndata).val(response);
            $('#' + sdata).val(response);
             totalsum();
        },
        error: function () {
            $("#loadspinner").css("display", "none");

        }
    });
}
$(document).ready(function(){
    $('.finalamount').val(null);
    $('.sub_total').val("0.00");
    $('.grand_total').val("0.00");
    $('.clear_total').click(function () {
    $('.grand_total').val("0.00");
    });
});     