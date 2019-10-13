@if(!empty($fre_array))
    @foreach($fre_array as $frequncyfetch)
        {{$frequncyfetch['frequency_id']}}{{$frequncyfetch['frequency_name']}}
      @endforeach
@endif

    