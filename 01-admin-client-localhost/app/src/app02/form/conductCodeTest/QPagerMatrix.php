<style type="text/css">
.pgrBtAning{
	background: #fdc830;
    background: -webkit-linear-gradient(to right, #f37335, #fdc830, #f37335);
    background: linear-gradient(to right, #f37335, #fdc830, #f37335)
}

.pgrBt{
	width: 30px; height: 30px;
	border-radius:4px; border: none; 	 
	 
	color: black; 
	cursor: pointer;
}
.pgrBtAns{
	/*background-color: #2196F3;  */
	border-radius:4px; border: 1px #a8e063 solid;
	color:white;
	background: #56ab2f;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #a8e063, #56ab2f);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #a8e063, #56ab2f); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}
.pgrBtNotAns{
	/* background-color: #ccc; #4CAF50*/
	

border-radius:4px; border: 1px #93291E solid;
	color:white;
	background: #ED213A;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #93291E, #ED213A);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #93291E, #ED213A); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}
.pgrBtNotVisit{
	 /*background-color: #eee; #f4f5f7; #4CAF50*/
	border-radius:4px; border: 1px #FFEFBA solid;
	color:black;
	background: #FFEFBA;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #FFFFFF, #FFEFFA);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #FFFFFF, #FFEFFA); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
.pgrBtCurr{
	font-weight: bold;
	border-radius:15px; border: 1px #fff200 solid;
	color:black;
	background: #fff200;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #fff200, #fffccc);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #fff200, #fffccc); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}		
</style>

<table align="center">
	<tr>
	{{#quiz}}
	<td>
		<input type="button" 
		class="pgrBt  {{#IsAnswered}}pgrBtAns{{/IsAnswered}} {{^IsAnswered}}{{#IsNotAnswered}}pgrBtNotAns{{/IsNotAnswered}} {{^IsNotAnswered}}{{#IsNotVisited}}pgrBtNotVisit{{/IsNotVisited}}{{/IsNotAnswered}}{{/IsAnswered}}  {{#IsCurrent}}pgrBtCurr{{/IsCurrent}}" 
		value="{{qno_l}}" 
		onclick="JsController.LoadQuestionByNo({{qno_l}})">
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
		value="{{qno}}" title="{{qno}}"
		onclick="JsController.apdata.action.LoadQuestionByNo({{qno}})"> 
	</td>	
	{{/Q}}
	{{#IsPagerLine}}</tr><tr>{{/IsPagerLine}}
	{{/pager}}
	</tr>	
</table>