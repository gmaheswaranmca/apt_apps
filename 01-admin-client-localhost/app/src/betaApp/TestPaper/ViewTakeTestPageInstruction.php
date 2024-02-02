	{{#quiz}}
		<div class="qst_main_table_li">
			<table border=1 class="tblGridLi">				
				<tr class="c_list_head_gr">
					<td>{{quiz_name}}</td>				
				</tr>
				<tr class="c_list_item_gr">
					<td>{{about_quiz}}</td>				
				</tr>
				<tr class="c_list_item_gr">
					<td>{{qn_count}} Qns</td>				
				</tr>
				<tr class="c_list_head_gr">
					<td>Instructions</td>				
				</tr>
			</table>	
			<table border=1 class="tblGridLi">
				<tr class="c_list_item_gr">
					<td>{{{intro_text}}}</td>
				</tr>
				<tr class="c_list_item_gr">
					<td>{{{rule}}}</td>
				</tr>
			</table>
		</div>
	{{/quiz}}
