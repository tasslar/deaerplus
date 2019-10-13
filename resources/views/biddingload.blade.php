@foreach($bidding_data as $document)
	<div class="form-group">
		<label class="col-xs-4 text-primary">{{$document["dealer_name"]}}</label>
		<div class="col-xs-8">
		    <p class="text-default">Rs.{{$document["bidded_amount"]}}<span class="bid-time">{{$document["bidded_datetime"]}}</span></p>
		</div>
	</div>
@endforeach