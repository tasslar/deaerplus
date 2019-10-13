@include('header')
@include('sidebar')

<div class="ts-main-content">
	<div class="content-wrapper myprofile">
		<div class="container-fluid footer-fixed">
			<div class="row">
				<div class="col-xs-12" id="features">
					<h2 class="page-title">Inventory Reports</h2>
				</div>
				<form method="post" action="{{url('/inventory-age-report')}}">
					{!!csrf_field()!!}
					<div class="col-md-3">
						<label>Ascending or Descending Date</label>
					</div>
					<div class="col-md-3">
						<select name="ddl_sort_type" class="form-control">
							<option value="0">---SELECT---</option>
							<option value="1">ASCENDING</option>
							<option value="2">DESCENDING</option>
						</select>
					</div>
					<div class="clearfix"></div>

					<div class="col-md-3">
						<label>Type</label>
					</div>
					<div class="col-md-3">
						<select name="ddl_sort_type" class="form-control">
							<option value="0">---SELECT---</option>
							<option value="1">DRAFT</option>
							<option value="2">READY FOR SALE</option>
							<option value="3">LIVE</option>
						</select>
					</div>
					<div class="clearfix"></div>

					<div class="col-md-3">
						<label>Show Amount In Car</label>
					</div>
					<div class="col-md-3">
						<input type="checkbox" name="chk_show_amt" value="yes">
					</div>
					<div class="clearfix"></div>
					<input type="submit" name="btn_generate" value="Generate" class="btn btn-primary">
					<input type="submit" name="btn_download" value="Download" class="btn btn-primary">
				</form>
			</div>
		</div>
	</div>
</div>

@include('footer')