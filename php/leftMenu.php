<?php
$leftMenu = getLeftMenu();
if($leftMenu != null){
?>
<div id="left_area">
	<div id="left_menu_inner">
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
			$icon = def($itemArticle->name.'.icon', "/icon_team_small.png");
			if($itemArticle->isCurrent){
?>
			<li class="left_article_active tblue" data-level="<?=$level?>">
				<span style="background-image:url('<?=$icon?>')"><span class="item-txt"><?=srs($itemArticle->name)?></span><span class="icon_arrow icon_white"></span></span>
			</li>
<?php
			}else{
?>
			<li class="left_article" data-level="<?=$level?>">
				<a href="<?=$itemArticle->href?>" style="background-image:url('<?=$icon?>')"><span class="item-txt"><?=srs($itemArticle->name)?></span><span class="icon_arrow icon_white"></span></a>
			</li>
<?php
			}
?>
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
			$icon = def($itemMenu->name.'.icon', "/icon_team_small.png");
			if($itemMenu->isCurrent){
?>
			<li class="left_menu_active tblue" data-level="<?=$level?>">
<?php
			}else{
?>
			<li class="left_menu" data-level="<?=$level?>">
<?php
			}
?>
				<a href="<?=$itemMenu->href?>" style="background-image:url('<?=$icon?>')"><span class="item-txt"><?=srs($itemMenu->name)?></span><span class="icon_arrow icon_white"></span></a>
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
