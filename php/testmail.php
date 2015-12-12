<?php
	$to = "contact@iriso-service.com";
	$subject = "来自官网的询价信";
	$txt = "abcd";
	$from = "abc@gmail.com";
	$headers = "From:$from\r\nCC: somebodyelse@example.com";
	echo $headers;

	mail($to,$subject,$txt,$headers);
	//phpinfo();
?>