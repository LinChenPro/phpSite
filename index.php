<?php 
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
// If the user is on a mobile device, redirect them
if(isMobile()){
    header("Location: http://m.iriso-service.com/");
}
?>

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>睿思国际</title>
	</head>
	<body style="margin-top:30px;text-align:center">
		<div style="color:#6666FF">
			<h1>
				Iriso Service International
			</h1>
			<h1>
				睿思国际
			</h1>
		</div>
		<div style="color:#FF6666">
			<h3>
				网站正在建设中...
			</h3>
			<h3>
				Site en travaux...
			</h3>
			<h3>
				Site in building...
			</h3>
		</div>
	</body>
</html>
