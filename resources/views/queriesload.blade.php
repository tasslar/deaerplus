@if(!empty($compact_array['messagedetails']))
    @foreach($compact_array['messagedetails'] as $messagefetch)
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
    @endforeach
@endif