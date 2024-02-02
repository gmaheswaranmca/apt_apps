<style type="text/css">
.pgrBtAning{
	background: #fdc830;
    background: -webkit-linear-gradient(to right, #f37335, #fdc830, #f37335);
    background: linear-gradient(to right, #f37335, #fdc830, #f37335)
}
</style>

<table align="center">
	<tr>
	{{#quiz}}
	<td>
		<input type="button" 
		class="pgrBt  {{#IsAnswered}}pgrBtAns{{/IsAnswered}} {{^IsAnswered}}{{#IsNotAnswered}}pgrBtNotAns{{/IsNotAnswered}} {{^IsNotAnswered}}{{#IsNotVisited}}pgrBtNotVisit{{/IsNotVisited}}{{/IsNotAnswered}}{{/IsAnswered}}  {{#IsCurrent}}pgrBtCurr{{/IsCurrent}}" 
		value="{{qno_l}}" 
		onclick="JsController.apdata.action.LoadQuestionByNo({{qno_l}})">
	</td>
	{{#IsPagerLine}}</tr><tr>{{/IsPagerLine}}
	{{/quiz}}
	</tr>	
</table>

<table align="center">
	<tr>
	{{#pager}}{{#Q}}
	<td>
		<input type="button" 
		class="pgrBt  {{#IsAnswering}}pgrBtAning{{/IsAnswering}}  {{^IsAnswering}}{{#IsAnswered}} pgrBtAns{{/IsAnswered}} {{^IsAnswered}} {{#IsNotAnswered}} {{#IsNotVisited}}pgrBtNotVisit{{/IsNotVisited}} {{/IsNotAnswered}}pgrBtNotAns{{^IsNotAnswered}} {{/IsNotAnswered}} {{/IsAnswered}} {{/IsAnswering}}  {{#IsCurrent}}pgrBtCurr{{/IsCurrent}}" 
		value="{{idx}}" title="{{idx}}"
		onclick="JsController.apdata.action.LoadQuestionByNo({{idx}})"> 
	</td>	
	{{/Q}}
	{{#IsPagerLine}}</tr><tr>{{/IsPagerLine}}
	{{/pager}}
	</tr>	
</table>