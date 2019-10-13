
<div class="">
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-xs-12 mt" id="no-more-tables">
	            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	                <thead>
	                    <tr>
							@foreach($header_title as $i => $fetch)
								@if($i==0)
									<th>#No</th>
								@endif
								<th>{{$fetch}}</th>
							@endforeach							
	                    </tr>
	                </thead>
	                <tfoot class="hidden-xs">
	                    <tr>
	                    	@foreach($header_title as $i => $fetch)
								@if($i==0)
									<th>#No</th>
								@endif
								<th>{{$fetch}}</th>
							@endforeach
	                    </tr>
	                </tfoot>
	                <tbody>
	                	@php ($sno=1)
	                	@foreach($sheetArray as $i => $fetch)
	                    	<tr>
	                    		<td>{{$sno++}}</td>
								@foreach($fetch as $j => $values) 
									<td data-title="Inventory ID">{{$values}}</td>
								@endforeach		
							</tr>
						@endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
