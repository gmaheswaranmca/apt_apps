<?php 
	
?>

<style type="text/css">
.bgmnu{
font-weight: bold;
border-radius: 10px; 
border: 1px solid rgb(21, 87, 153);
color:white;
background-color: rgb(28, 181, 224);
padding: 10px;

	
}
</style>
<table width="100%">
	{{#menus}}
	<tr>
		<td>
			<a class="menu_child_name" href="{{redirect_to}}">
				<div class="c_menu_list_bg bgmnu">{{module_name}}</div>
			</a>
		</td>
	</tr>
	{{/menus}}
	{{^menus}}
	<tr>
		<td>&nbsp;</td>
	</tr>	
	{{/menus}}	
</table>