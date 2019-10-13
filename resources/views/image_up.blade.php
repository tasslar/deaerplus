
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" action="{{url('image_resize')}}" enctype="multipart/form-data">
<input type="hidden" name="_token" value="{{csrf_token()}}">
	<input type="file" name="image">
	<button type="submit">Submit</button>
</form>
</body>
</html>