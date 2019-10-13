@if(isset($fetch_data[0]))
<div class="">
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-xs-12 mt" id="no-more-tables">
	            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	                <thead>
	                    <tr>
							<th>Sl No</th>
							<th>Inventory ID</th>
							<th>Inventory Type</th>
							<th>Registration Number</th>
							<th>Engine Number</th>
							<th>Chassis Number</th>
							<th>Registration Year</th>
							<th>Make</th>
							<th>Model Name</th>
							<th>Variant</th>
							<th>Body Type</th>
							<th>Transmission</th>
							<th>Total Distance</th>
							<th>Milage</th>
							<th>Owner Type</th>
							<th>Colors</th>
							<th>Car City</th>
							<th>Dealer Name</th>
							<th>Branch Name</th>
							<th>Fuel Type</th>
							<th>Price</th>
							<th>Created At</th>
	                    </tr>
	                </thead>
	                <tfoot class="hidden-xs">
	                    <tr>
							<th>Sl No</th>
							<th>Inventory ID</th>
							<th>Inventory Type</th>
							<th>Registration Number</th>
							<th>Engine Number</th>
							<th>Chassis Number</th>
							<th>Registration Year</th>
							<th>Make</th>
							<th>Model Name</th>
							<th>Variant</th>
							<th>Body Type</th>
							<th>Transmission</th>
							<th>Total Distance</th>
							<th>Milage</th>
							<th>Owner Type</th>
							<th>Colors</th>
							<th>Car City</th>
							<th>Dealer Name</th>
							<th>Branch Name</th>
							<th>Fuel Type</th>
							<th>Price</th>
							<th>Created At</th>
	                    </tr>
	                </tfoot>
	                <tbody>
	                	@foreach($fetch_data as $i => $fetch)
	                    	<tr>
	                    		<?php $i++; ?>
	                    		@if(empty($fetch['Dealer_Branch']))
									<?php $fetch['Dealer_Branch'] =""; ?>
								@endif
								<td data-title="Sl No.">{{$i}}</td>
								<td data-title="Inventory ID">{{$fetch['Inventory_Id']}}</td>
								<td data-title="Inventory Type">{{$fetch['Inventory_Type']}}</td>
								<td data-title="Registration Number">{{$fetch['Registration_Number']}}</td>
								<td data-title="Engine Number">{{$fetch['Engine_Number']}}</td>
								<td data-title="Chassis Number">{{$fetch['Chassis_Number']}}</td>
								<td data-title="Registration Year ">{{$fetch['Registration_Year']}}</td>
								<td data-title="Make ">{{$fetch['Make']}}</td>
								<td data-title="Model Name ">{{$fetch['Model_Name']}}</td>
								<td data-title="Variant ">{{$fetch['Variant']}}</td>
								<td data-title="Body Type ">{{$fetch['Body_Type']}}</td>
								<td data-title="Transmission ">{{$fetch['Transmission']}}</td>
								<td data-title="Kms Completed ">{{$fetch['Kms_Completed']}}</td>
								<td data-title="Mileage ">{{$fetch['Mileage']}}</td>
								<td data-title="Owner Type ">{{$fetch['Owner_Type']}}</td>
								<td data-title="Colors ">{{$fetch['Colors']}}</td>
								<td data-title="City ">{{$fetch['City']}}</td>
								<td data-title="Dealer Name ">{{$fetch['Dealer_Name']}}</td>
								<td data-title="Dealer Branch ">{{$fetch['Dealer_Branch']}}</td>
								<td data-title="Fuel Type ">{{$fetch['Fuel_Type']}}</td>
								<td data-title="Price ">{{$fetch['Price']}}</td>
								<td data-title="Created At ">{{$fetch['Created_At']}}</td>
	                    	</tr>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
@elseif(isset($fetch_data1[0]))
<div class="">
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-xs-12 mt" id="no-more-tables">
	            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	                <thead>
	                    <tr>
							<th>Sl No</th>
							<th>Inventory ID</th>
							<th>Inventory Type</th>
							<th>Dealer Name</th>
							<th>Fuel Type</th>
							<th>Variant</th>
							<th>Milage</th>
							<th>Transmission</th>
							<th>Colors</th>
							<th>Make</th>
							<th>Model Name</th>
							<th>Car City</th>
							<th>Age</th>
							<th>Created At</th>
	                    </tr>
	                </thead>
	                <tfoot class="hidden-xs">
	                    <tr>
							<th>Sl No</th>
							<th>Inventory ID</th>
							<th>Inventory Type</th>
							<th>Dealer Name</th>
							<th>Fuel Type</th>
							<th>Variant</th>
							<th>Milage</th>
							<th>Transmission</th>
							<th>Colors</th>
							<th>Make</th>
							<th>Model Name</th>
							<th>Car City</th>
							<th>Age</th>
							<th>Created At</th>
	                    </tr>
	                </tfoot>
	                <tbody>
	                	@foreach($fetch_data1 as $i => $fetch)
	                    	<tr>
	                    		<?php $i++; ?>
	                    		@if(empty($fetch['Dealer_Branch']))
									<?php $fetch['Dealer_Branch'] =""; ?>
								@endif
								<td data-title="Sl No.">{{$i}}</td>
								<td data-title="Inventory ID">{{$fetch['Inventory_Id']}}</td>
								<td data-title="Inventory Type">{{$fetch['Inventory_Type']}}</td>
								<td data-title="Dealer Name">{{$fetch['Dealer_Name']}}</td>
								<td data-title="Fuel Type">{{$fetch['Fuel_Type']}}</td>
								<td data-title="Variant">{{$fetch['Variant']}}</td>
								<td data-title="Mileage">{{$fetch['Mileage']}}</td>
								<td data-title="Transmission ">{{$fetch['Transmission']}}</td>
								<td data-title="Colors">{{$fetch['Colors']}}</td>
								<td data-title="Make">{{$fetch['Make']}}</td>
								<td data-title="Model Name">{{$fetch['Model_Name']}}</td>
								<td data-title="City ">{{$fetch['City']}}</td>
								<td data-title="Days Between ">{{$fetch['days_between']}}</td>
								<td data-title="Created At ">{{$fetch['Created_At']}}</td>
	                    	</tr>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
@endif