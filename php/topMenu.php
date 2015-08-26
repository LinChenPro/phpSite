<?php
$topMenuItems = getTopMenu();
	
?>
<div id="head">
		<div id="head_area">
		<span id="company_name"><?=srs("company_name")?></span>
		<span id="sercteur_name" data-secteur="translate"><?=srs("secteur_translate")?></span>

		<span id="company_name_lang2"><?=srs("company_name_lang2")?></span>
		<span id="sercteur_name_lang2" data-secteur="translate"><?=srs("secteur_translate_lang2")?></span>
	</div>
	<div id="topemenu">
		<ul id="topemenu_ui">
<?php
foreach($topMenuItems as $item){
	if($item->isCurrent){
?>
			<li class="topemenu_item_active">
<?php
	}else{
?>
		<li class="topemenu_item">
<?php
	}
?>
			<a href="<?=$item->href?>"><?=srs($item->title)?></a>
		</li>
<?php
}
?>
		</ul>
	</div>
</div>