<?php
// get nostatic cookies
$activeStatics = !(isset($_COOKIE["DESACTIVE_STATICS"]) && $_COOKIE["DESACTIVE_STATICS"]) ;
if(!$activeStatics){
	setcookie("DESACTIVE_STATICS", true, time() + (86400 * 365), "/", "iriso-service.com");
}

//$fromRealSite = ("192.168.1.2" == $_SERVER["HTTP_HOST"]);
$allowHosts = array(
	"www.iriso-service.com",
	"iriso-service.com"	
);

$fromRealSite = in_array($_SERVER["HTTP_HOST"], $allowHosts);

if($activeStatics && $fromRealSite){
?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-76613553-1', 'auto');
	  ga('send', 'pageview');
	</script>
<?php
}
?>