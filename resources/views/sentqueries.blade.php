@include('header')
@include('sidebar')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="content-header col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="index.html"><i class="fa fa-dashboard"></i> Buy</a></li>
                    <li class="active">My Query</li>
                </ol>
            </div>
            <div class="col-xs-12">


                <h2 class="page-title">Queries {{$compact_array['car_info']['listing_error_msg']}}</h2>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-sm-4 col-xs-12"><img src="{{$compact_array['car_info']['imagelinks']}}" class="img-responsive  viewcarlisting"  data-id="{{$compact_array['car_info']['car_id']}}"  alt="" style="cursor: pointer;"/>
                            <h4 class="text-primary buy-list viewcarlisting" data-id="{{$compact_array['car_info']['car_id']}}" style="cursor: pointer;">{{$compact_array['car_info']['make']}} {{$compact_array['car_info']['model']}} {{$compact_array['car_info']['variant']}}</h4><p class="text-primary"><i class="fa fa-map-marker"></i>{{$compact_array['car_info']['car_locality']}} <span class="list-date">- {{$compact_array['car_info']['daysstmt']}}</span></p>
                            <p><span class="rate"><i class="fa fa-rupee"></i></span> {{$compact_array['car_info']['sell_price']}}</p>

                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="panel panel-primary myquery">
                                <div class="panel-heading">
                                    <h4>Conversation With {{$compact_array['car_info']['headerdealername']}}</h4></div>
                                <div class="panel-body msg-box">
                                    <div class="member_list message">
                                        <ul class="message_grid">
                                            @foreach($compact_array['messagedetails'] as $messagefetch)
                                            @if($messagefetch['style_align']=='right')
                                            <li class="left clearfix">
                                                <span class="chat-img1 pull-left">
                                                    <img src="{{$messagefetch['dealer_profile_image']}}" alt="User" class="img-circle">
                                                </span>
                                                <div class="chat-body1 clearfix">
                                                    @if($messagefetch['downloadlink']=='0')
                                                    <p>{{$messagefetch['contact_message_grid_html']}}</p>
                                                    @else
                                                    <p><a href="{{$messagefetch['contact_message_grid_html']}}" download="download">Download File</a></p>
                                                    @endif
                                                    <div class="chat_time pull-right">{{$messagefetch['delear_datetime']}}</div>
                                                </div>
                                            </li>
                                            @else
                                            <li class="left clearfix admin_chat">
                                                <span class="chat-img1 pull-right">
                                                    <img src="{{$messagefetch['dealer_profile_image']}}" alt="User" class="img-circle">
                                                </span>
                                                <div class="chat-body clearfix">
                                                    @if($messagefetch['downloadlink']=='0')
                                                    <p>{{$messagefetch['contact_message_grid_html']}}</p>
                                                    @else
                                                    <p><a href="{{$messagefetch['contact_message_grid_html']}}" download="download">Download File</a></p>
                                                    @endif
                                                    <div class="chat_time pull-left">{{$messagefetch['delear_datetime']}}</div>
                                                </div>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>

                                    </div>
                                    <form method="post" enctype="multipart/form-data" id="upload_form">
                                        <div class="message_write">
                                            <textarea class="form-control" name="text_area" id="text_area" placeholder="Type a message"></textarea>
                                            <div class="chat_bottom"><div class="col-sm-6 pull-left ">
                                                    <input type="hidden" name="to_dealer_id" id="to_dealer_id" value="{{$compact_array['car_info']['to_dealer_id']}}">
                                                    <input type="hidden" name="car_id" id="car_id" value="{{$compact_array['car_info']['car_id']}}">
                                                    <input type="hidden" name="title" id="title" value="{{$compact_array['car_info']['make']}} {{$compact_array['car_info']['model']}} {{$compact_array['car_info']['variant']}}">
                                                    <input type="hidden" name="contact_transactioncode" id="contact_transactioncode" value="{{$compact_array['car_info']['contact_transactioncode']}}">
                                                    <input type="hidden" name="sell_price" id="sell_price" value="{{$compact_array['car_info']['sell_price']}}">
                                                    <input type="hidden" name="dealer_name" id="dealer_name">
                                                    <input type="hidden" name="dealer_email" id="dealer_email">

                                                    <input type="hidden" name="notification_type_id" id="notification_type_id" value="{{$notification_type}}">                                                 
                                                    
                                                    <input type="file" name="dealer_upload[]" id="rcupload" class="BSbtninfo fileuploadrestriction" data-size="2" data-format="'gif','png','jpg','jpeg'" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                                                    
                                                </div>


                                                <div class="col-sm-6"><a href="#"  id="pop_message" class="pull-right btn-sm btn btn-primary"> Send</a></div></div>
                                        </div>
                                    </form>
                                </div></div>

                        </div>


                    </div>
                </div>

            </div>
        </div>


    </div>
    @include('footer')
</div>
</div>
</div>
</div>
@if($compact_array['active_menu_name']=='sell_menu')
<form method="post" id="view_car_managelist" action="{{url('view')}}">
    @else
    <form method="post" id="view_car_managelist" action="{{url('detail_car_listing')}}">
        @endif    
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="car_view_id" name="car_view_id">
    </form>

    <!-- Loading Scripts -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/fileinput.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/jquery.form-validator.min.js')}}"></script>
    <script src="{{URL::asset('js/dealerplus.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
$(document).ready(function () {
    $('.BSbtninfo').filestyle({
        buttonName: 'btn-info',
        buttonText: ' Select a File',
                
            });
    $(".member_list").scrollTop($(".member_list").prop("scrollHeight"));
    $('#pop_message').click(function (event) {
        event.preventDefault();
        $("#loadspinner").css("display", "block");
        var text_area = $('#text_area').val();
        var car_id = $('#car_id').val();
        var to_dealer_id = $('#to_dealer_id').val();
        var title = $('#title').val();
        var dealer_email = $('#dealer_email').val();
        var dealer_name = $('#dealer_name').val();
        var contact_transactioncode = $('#contact_transactioncode').val();
        var sell_price = $('#sell_price').val();
        if (text_area == '')
        {
            alert('Please Enter Message');
            $("#loadspinner").css("display", "none");
            $('#text_area').focus();
            return false;
        }
        $.ajax({
            url: 'popup_msg',
            /*type:'post',
             data:{text_area:text_area,car_id:car_id,to_dealer_id:to_dealer_id,title:title,dealer_email:dealer_email,dealer_name:dealer_name},
             success:function(response)
             {
             console.log(response);
             $('#text_area').val('');
             },
             error:function(e)
             {
             console.log(e.responseText);
             }*/
            data: new FormData($("#upload_form")[0]),

            async: true,
            type: 'post',
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            success: function (response) {
                if (response == 'sessionout')
                {
                    window.location.replace("{{url('login')}}");
                    return false;
                }
                $("#loadspinner").css("display", "none");
                //console.log(response);
                $('#text_area').val('');
                $('#rcupload').val('');
                $('.bootstrap-filestyle .form-control').val('');
                $('.message_grid').append(response);
                $(".member_list").scrollTop($(".member_list").prop("scrollHeight"));
            },
            error: function (e)
            {
                //$('#text_area').val('');
                //$('#dealer_upload').val('');   
                //$('.message_grid').append(e.responseText);
                //console.log(e.responseText);
                $("#loadspinner").css("display", "none");
            }
        });
    });


});

    </script>
    <script>
        $(function ()
        {
            $('.viewcarlisting').click(function () {
                $('#car_view_id').val($(this).attr('data-id'));
                $('#view_car_managelist').submit();
            });
            var onClass = "on";
            var showClass = "show";

            $("input, select, textarea")
                    .bind("checkval", function ()
                    {
                        var label = $(this).prev("label");

                        if (this.value !== "")
                            label.addClass(showClass);

                        else
                            label.removeClass(showClass);
                    })
                    .on("keyup", function ()
                    {
                        $(this).trigger("checkval");
                    })
                    .on("focus", function ()
                    {
                        $(this).prev("label").addClass(onClass);
                    })
                    .on("blur", function ()
                    {
                        $(this).prev("label").removeClass(onClass);
                    })
                    .trigger("checkval");

            $("select")
                    .on("change", function ()
                    {
                        var $this = $(this);

                        if ($this.val() == "")
                            $this.addClass("watermark");

                        else
                            $this.removeClass("watermark");

                        $this.trigger("checkval");
                    })
                    .change();


        });</script>
</body>

</html>