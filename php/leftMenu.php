<?php
$leftMenu = getLeftMenu();
if($leftMenu != null){
?>
<div id="left_area">
	<div id="left_menu">
<?php
	showSubMenu($leftMenu);
?>
	</div>
</div>
<?php	
}

function showSubMenu($subMenu, $level=2){
	if($subMenu->articles != null){
?>
		<ul class="left_ui_article" data-level="<?=$level?>">
<?php
		foreach($subMenu->articles as $itemArticle){
			if($itemArticle->isCurrent){
?>
			<li class="left_article_active" data-level="<?=$level?>">
<?php
			}else{
?>
			<li class="left_article" data-level="<?=$level?>">
<?php
			}
?>
				<a href="<?=$itemArticle->href?>"><?=srs($itemArticle->name)?></a>
			</li>
<?php
		}
?>
		</ul>	
<?php	
	}

	if($subMenu->menus != null){
?>
		<ul class="left_ui_menu" data-level="<?=$level?>">
<?php
		foreach($subMenu->menus as $itemMenu){
			if($itemMenu->isCurrent){
?>
			<li class="left_menu_active" data-level="<?=$level?>">
<?php
			}else{
?>
			<li class="left_menu" data-level="<?=$level?>">
<?php
			}
?>
				<a href="<?=$itemMenu->href?>"><?=srs($itemMenu->name)?></a>
<?php
			if($itemMenu->subItems!=null){
				showSubMenu($itemMenu->subItems, $level+1);
			}
?>

			</li>
<?php
		}
?>
		</ul>	
<?php	
	}
}
?>
