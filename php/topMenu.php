<?php
$topMenuItems = getTopMenu();
	
?>
	<div class="total_container" id="container_header">
		<div id="header">
			<div id="topFunctionArea">
				<a href="#">
					<img src="/slideMenuIcon.png" class="slideopen"/>
				</a>
				<span class="langlink">
					<?=getLangLinks()?>
				</span>
				<?=getServiceTel()?>
			</div>
			<span id="logoarea">
				<a href="http://<?=$_SERVER['HTTP_HOST']?>/">
						<img src="/logoTop.png" class="logoTop"/>
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
