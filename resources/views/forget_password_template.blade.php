


<html>
<body>
   
@include('email_header_template')
<?php
echo $data['mail_message'];
?>
@include('email_footer_template')
</body>
</html>