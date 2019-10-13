
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

$(".tr_clone_add").on('click', function () {
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
function scriptexec(){
    $(document).on('blur', "input[type='text'],select", function () {
            totalsum();
    });
}
setTimeout(scriptexec,1000);
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
        //alert('1');
        var quantity = $('#quantity'+index).val();
        var amt_type = $('#amt_type'+index).val();
        var taxamount = percentcalc(tax_rate,carprice);
        totaltax = parseFloat(totaltax)+parseFloat(taxamount);
        var pricewithtax = parseFloat(carprice)+parseFloat(taxamount);
        if(amt_type==1)
        {
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
    grand_total = parseFloat(grand_total).toFixed(2);
    totaldiscount = parseFloat(totaldiscount).toFixed(2);
    $('#grand_total').val(grand_total);
    $('#finaldiscount').val(totaldiscount);   
}

function fun(i,data)
{
    var ndata = $(data).parent().next().next().find(".carprice").attr('id');
    var id = $(data).attr('dataid');
    var car_id = $(data).val();
    var token = $('#token').val();
    if(id==0){

        $.ajax({
            url: 'car_price',
            data: {car_id: car_id, token: token},
            type: 'post',
            success: function (response) {
                $('#' + ndata).val(response);
                 totalsum();
            },
            error: function () {
                $("#loadspinner").css("display", "none");

            }
        });
    }
    else
    {
        $(data).attr('dataid',0);    
    }
}

$(document).ready(function(){
    
});