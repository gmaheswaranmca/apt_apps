<style type="text/css">
	.pgrBtAning{
		background: #fdc830;
		background: -webkit-linear-gradient(to right, #f37335, #fdc830, #f37335);
		background: linear-gradient(to right, #f37335, #fdc830, #f37335)
	}
</style>

<table align="center">
	<tr>
	{{#pager}}{{#Q}}
	<td>
		<input type="button" 
		class="pgrBt  {{#IsAnswering}}pgrBtAning{{/IsAnswering}}  {{^IsAnswering}}{{#IsAnswered}} pgrBtAns{{/IsAnswered}} {{^IsAnswered}} {{#IsNotAnswered}} {{#IsNotVisited}}pgrBtNotVisit{{/IsNotVisited}} {{/IsNotAnswered}}pgrBtNotAns{{^IsNotAnswered}} {{/IsNotAnswered}} {{/IsAnswered}} {{/IsAnswering}}  {{#IsCurrent}}pgrBtCurr{{/IsCurrent}}" 
		value="{{idx}}" title="{{idx}}"
		onclick="TakeTestViewRender.LoadQn({{idx}})"> 
	</td>	
	{{/Q}}
	{{#IsPagerLine}}</tr><tr>{{/IsPagerLine}}
	{{/pager}}
	</tr>	
	<tr>
	<td>
		<input type="button" class="pgrBt  " value="<<" title="Previous Question"
		onclick="TakeTestViewRender.PrevQn()"> 
	</td><td colspan="4">
		<input type="button" class="pgrBt  " value=">>" title="Next Question"
		onclick="TakeTestViewRender.NextQn()"> 
	</td>	
	
	</tr>
	</tr>	
</table>