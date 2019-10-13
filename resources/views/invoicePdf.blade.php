<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Invoice</title>
		<style type="text/css">
		    html, body 
		    { 
		    	height: 100%;
		    	font-family: arial;
		    }
		    body
		    {
		    	font-family: arial;
		    }
		    table 
		    {
		    	border-collapse: collapse;
		    	width: 100%;
		    }
		    h4
		    {
		    	margin:10px 0px;
		   	}
		   /* .container 
		    {
		    	width: 100%;
		    	padding: 0;
		    	float:left;
		    }
		    .content
		    {
		    	width:90%;
		    	margin:0 5%;
		    	float:left;
		    }
		    .content .logo
		    {
		    	display: inline-block;
		    	float:left;
		    	width: 207px;
		    }
		    .head-1
		    {
		    	text-transform: uppercase;
		    	font-size: 25px;
		    	margin: 0px;
		    	text-align: center;
		    }*/
		    .table-invoice
		    {
		    	width:100%;
		    	border-collapse: collapse;
		    }
		    .table-invoice tr
		    {
		    	border-bottom: none;
		    }
		    .table-invoice td, .table-invoice th
		    {
		    	padding: 5px 10px;
		    	vertical-align: baseline;
				border: none;
				text-align: left;
				font-size: 14px;
			}
		    thead tr
		    {
		    	background-color: #183055;
		    	padding:10px;
		    	color:#fff;
		    	text-align: center;
		   	}
		    .span-data
		    {
		    	float: right;
		    }
		    .td-data
		    {
		    	text-align: left;
		    }
		    p
		    {
		    	font-size: 13px;
		    	margin:0px;
		    	line-height: 20px;
		    }
		    .table-invoice
		    {
		    	margin-top: 10px;
		    }
		    .body-invoice1
		    {
		    	text-align: right;
		    }
		    .detail-link
		    {
		    	margin-top:10px;
		    	font-size: 18px;
		    	text-align: center;
		    }
		    .border-none
		    {
		    	border:0px;
		    }
		    .td-data 
		    {
		    	margin:0px;
		    	font-size: 14px;
		    	line-height: 20px;
		   	}
		    .td-data h4
		    {
		    	color:#ff2222;
		    	font-size: 14px;
		    	margin: 0px;
		    }
		    .rupee-word
		    {
		    	font-weight: bold;
		   	}
		    .content-text
		    {
		    	text-align:left;
		    	margin-top:10px;
		    }
		    .bold-word
		    {
		    	font-weight: bold;
		    	margin-top:10px;
		    	text-align: right;
		    }   
		    .content-right
		    {
		    	width: 100%;
		    }
		    .address1
		    {
		    	float:left;
		    	width: 33.334%;
		    	text-align: left;
		    }
		    .address1 h1
		    {
		    	display: inline-block;
		    	margin-top: -30px;
		    	margin-bottom: 0px;
		    	font-size: 22px;
		    }
		    .addresscenter
		    {
		    	float: left;
		    	width: 33.334%;
		    	text-align: center;
		    }
		    .address2
		    {
		    	float:right;
		    	width: 33.334%;
		    	text-align: right
		    }
		</style>
    </head>

	<body>
		<table align="center" width="100%" cellspacing="0" cellpadding="0"  class="tbl" >
			<tbody>
				<tr>
					<td>
						<table>
							<tbody>
								<tr>
									<td class="address1">
										<table>
											<tbody>
												<tr>
													<td style="width: 120px;">
													@if($compact_array['dealer_profile']->company_logo)
														<img class="logo" src="{{$compact_array['dealer_profile']->company_logo}}" alt="Company logo" style="max-width: 150px;max-height: 100px;"/>
														@else
														<img class="logo" src="{{url('img/logo.png')}}" alt="Company logo" style="max-width: 150px;max-height: 100px;"/>
														@endif
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								    <td class="addresscenter">
								    	<h2 class="head-1">INVOICE</h2>
								    </td>
								</tr>
								<tr>
									<td class="address1">
										<p><h1>{{$compact_array['dealer_profile']->dealership_name}}</h1></p>
										<p>{{$compact_array['dealer_profile']->dealership_name}}</p>
										<p>{{$compact_array['dealer_info'][0]->Address}}</p>
										<p>
											@foreach($compact_array['city'] as $fetch_city)
												@if($compact_array['dealer_info'][0]->d_city == $fetch_city->city_id)
													{{$fetch_city->city_name}}
												@endif
											@endforeach
                                        </p>
                                        <p>
											@foreach($compact_array['state'] as $fetch_state)
												@if($compact_array['dealer_info'][0]->d_state == $fetch_state->id)
													{{$fetch_state->state_name}}
												@endif
											@endforeach
                                        </p>
										<p>{{$compact_array['dealer_info'][0]->pincode}}</p>
									</td>
									<td class="addresscenter"></td>
									<td class="address2">
								    	<p><b>Date :</b>{{$compact_array['date']}}</p>
                                        <p><b>Invoice # :</b>{{$compact_array['quotes_value'][0]->invoice_number}}</p>
                                        <p><b>Customer Id :</b>{{$compact_array['get_client']->contact_management_id}}</p>
                                        <p><b>Due Date :</b> {{$compact_array['quotes_value'][0]->due_date}}</p>
								    </td>
									<!-- <td class="address2">
										<p>{{$compact_array['get_client']->contact_mailing_address}}</p>
										<p>
											@foreach($compact_array['city'] as $fetch_city)
												@if($compact_array['get_client']->contact_mailing_city == $fetch_city->city_id)
													{{$fetch_city->city_name}}
												@endif
											@endforeach
                                        </p>
                                        <p>
											@foreach($compact_array['state'] as $fetch_state)
												@if($compact_array['get_client']->contact_mailing_locality == $fetch_state->id)
													{{$fetch_state->state_name}}
												@endif
											@endforeach,
                                        </p>
										<p>{{$compact_array['get_client']->contact_mailing_pincode}}</p>
									</td> -->
								</tr>
								<tr>
									<td>
										<table class="table-invoice" align="center" width="100%" cellspacing="0" cellpadding="0">
											<thead>
												<tr>
													<th> Bill To</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<p>
															{{$compact_array['get_client']->contact_first_name}}
														</p>
														<p>
															{{$compact_array['get_client']->contact_mailing_address}}
														</p>
														<p>
															@foreach($compact_array['city'] as $fetch_city)
																@if($compact_array['get_client']->contact_mailing_city == $fetch_city->city_id)
																	{{$fetch_city->city_name}}
																@endif
															@endforeach
														</p>
														<p>
															{{$compact_array['get_client']->contact_mailing_pincode}}
														</p>
														<p>
															{{$compact_array['get_client']->contact_phone_1}}
														</p>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table class="table-invoice" align="center" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #000;">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Product Name</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Price</th>
									<th>Tax Rate</th>
									<th>Discount</th>
									<th>Type</th>
									<th>Sub Total</th>
								</tr>
							</thead>
							<tbody>
								@foreach($compact_array['quotes_car_value'] as $i => $fetch)
									<tr>
										<td>{{++$i}}</td>
										<td>
											<div class="td-data">
											    <p>
											    	@foreach($compact_array['car_lisitng'] as $fetch_car)
	                                                    @if($fetch->product_id == $fetch_car->car_id)
	                                                        <p>{{$fetch_car->model_name}},{{$fetch_car->variant_name}}</p>
	                                                    @endif
	                                                @endforeach
												</p>
											</div>
										</td>
										<td>
											<div class="td-data">
											    <p>{{$fetch->notes}}</p>
											</div>
										</td>
										<td>
											<div class="td-data">
											    <p>1</p>
											</div>
										</td>
										<td>
											<div class="td-data">
											    <p>{{$fetch->cost}}</p>
											</div>
										</td>
										<td>
											<div class="td-data">
											    <p>
													@if ($fetch->tax_rate1 == "10")
													    10%
													@else
													    20%
													@endif
												</p>
											</div>
										</td>
										<td>
											<div class="td-data">
											    <p>{{$fetch->discount}}</p>
											</div>
										</td>
										<td>
											<div class="td-data">
											    <p>{{$fetch->discount_type}}</p>
											</div>
										</td>
										<td>
											<div class="td-data">
											    <p>{{$fetch->sub_total}}</p>
											</div>
										</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="7" class="border-none"></td>
									<td>
										<p class="rupee-word">Amount</p>
									</td>
									<td>
										<p>
											{{$compact_array['quotes_value'][0]->discount}}
										</p>
									</td>
								</tr>
								<tr>
									<td colspan="7" class="border-none"></td>
									<td>
										<p class="rupee-word">Discount Type</p>
									</td>
									<td>
										<p>{!!$compact_array['quotes_value'][0]->invoice_discount_type!!}</p>
									</td>
								</tr>
								<tr>
									<td colspan="7" class="border-none"></td>
									<td>
										<p class="rupee-word">Total Amount</p>
									</td>
									<td>
										<p>{{$compact_array['quotes_value'][0]->amount}}</p>
									</td>
								</tr>
								<tr>
									<td colspan="7" class="border-none"></td>
									<td>
										<p class="rupee-word">Final Discount</p>
									</td>
									<td>
										<p>{{$compact_array['quotes_value'][0]->po_number}}</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			    <tr>
			        <td>
			            <p class="content-text content-right">Total In Words *** <span class="rupee-word">{{$compact_array['getNumberWords']}}</span> ***</p>
			        </td>
			    </tr>
			    <tr>
			        <td>
			            <table class="table-invoice"  align="center" width="100%" cellspacing="0" cellpadding="0">
			                <tbody>
			                    <tr>
			                        <td>
			                            <table class="table-invoice" align="center" width="100%" cellspacing="0" cellpadding="0" border>
			                                <thead>
			                                    <tr>
			                                        <th>Terms and Conditions</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                    <tr>
			                                        <td>
			                                            {{$compact_array['quotes_value'][0]->terms}}
			                                        </td>
			                                    </tr>
			                                </tbody>
			                            </table>
			                        </td>
			                        <td>
			                            <table class="table-invoice" align="center" width="100%" cellspacing="0" cellpadding="0" border>
			                                <thead>
			                                    <tr>
			                                        <th>Amount Paid</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                    <tr>
			                                        <td>
														@foreach($compact_array['amountPaid'] as $amounts)
															<label>Amount Paid</label>
															<p>{{$amounts->amount}}</p>
															<label>Payment Date</label>
															<p>{{$amounts->payment_date}}</p>
															<label>Amount Type</label>
															@if($amounts->payment_type_id == "1")
																<p>CHECK</p>
															@elseif($amounts->payment_type_id == "2")
																<p>CASH</p>
															@else
																<p>BANK TRANSFER</p>
															@endif
														@endforeach
			                                        </td> 
			                                    </tr>
			                                </tbody>
			                            </table>
			                        </td>
			                    </tr>
			                </tbody>
			            </table>
			            <p class="detail-link">If you have any question about this Invoice, Please contact</p>
			            <p class="detail-link">[{{$compact_array['dealer_profile']->dealer_name}},{{$compact_array['dealer_profile']->d_mobile}},{{$compact_array['dealer_profile']->d_email}}]</p>
			            <p class="detail-link"><b>Thank You For Your Business!</b></p>   
			        </td>
			    </tr>
			    <tr>
			        <td>
			            <table>
			                <tbody>
			                    <tr>   
			                        <td> <p>Invoice Template &copy; 2017 www.dealerplus.in</p> </td>
			                        <td style="text-align: right"><img class="logo" src="img/logo.png" alt="" style="width: 150px;margin-bottom: 20px"/></td>
			                    </tr>  
			                </tbody>
			            </table>
			        </td>
			    </tr>
			</tbody>
		</table>
	</body>
</html>