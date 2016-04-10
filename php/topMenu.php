<?php
$topMenuItems = getTopMenu();
	
?>
	<div class="total_container" id="container_header">
		<div id="header">
			<div id="topFunctionArea">
				<a id="slideopen" href="#">
					<img alt="slide menu" src="/slideMenuIcon.png" class="slideopen"/>
				</a>
				<img class="small_logo" alt="iriso" src="/small_logo.jpg">
				<span class="langlink">
					<?=getLangLinks()?>
				</span>
				<?=getServiceTel()?>
			</div>
			<span id="logoarea">
				<a href="http://<?=$_SERVER['HTTP_HOST']?>/">
						<img alt="IRISO Traduction" src="/logoTop.png" class="logoTop"/>
				</a>
			</span>
			<div id="menuarea">
				<ul id="topemenu_ui">
<?php
foreach($topMenuItems as $item){
	if(false == $item->showInMenu){
		continue;
	}

	if($item->isCurrent){
?>
		<li class="tmn tblue crt">
<?php
	}else{
?>
		<li class="tmn tblue">
<?php
	}
?>
			<a href="<?=$item->href?>"><?=srs($item->name)?></a>
		</li>
<?php
}
?>
				</ul>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			$(".home_icon").attr("class", "home_icon");
			$(".home_icon").hover(
				function(){
					$(this).find( "a" ).animate({ "bottom":  "20px" ,"backgroundColor":["#F1F1F1", "swing"]}, "100" , "easeOutExpo");
					$(this).find( "img" ).animate({"backgroundColor":["#F1F1F1", "swing"]}, "100" , "swing");
				},
				function(){
					$(this).find( "a" ).animate({ "bottom":  "0px" ,"backgroundColor":["#55B2CD", "swing"]}, "slow" , "easeOutBounce");
					$(this).find( "img" ).animate({"backgroundColor":["#55B2CD", "swing"]}, "slow" , "swing");
				}
			);
	});
	</script>