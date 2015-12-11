<?php
$topMenuItems = getTopMenu();
	
?>
	<div class="total_container" id="container_header">
		<div id="header">
			<!-- <span class="ticon">睿</span> -->
			<a href="http://www.iriso-service.com/">
				<span id="logoarea">
					<span id="company_name" class="tred"><?=srs("company_name")?></span>
					<span id="sercteur_name" class="tblue" data-secteur="translate"><?=srs("secteur_translate")?></span>
					<span id="company_name_lang2" class="tblue"><?=srs("company_name_lang2")?></span>
					<span id="sercteur_name_lang2" class="tblue" data-secteur="translate">
						<?=srs("secteur_translate_lang2")?>
					</span>
				</span>
			</a>
			<div id="menuarea">
				<ul id="topemenu_ui">
<?php
foreach($topMenuItems as $item){
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
			<div id="topFunctionArea">
				<span class="langlink">
					<?=getLangLinks()?>
				</span>
				<?=getServiceTel()?>
			</div>
		</div>
	</div>
