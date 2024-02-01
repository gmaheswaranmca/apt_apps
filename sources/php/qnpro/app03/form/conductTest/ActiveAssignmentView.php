<table class="aptTable">
	{{#assignment}}
	<tr>
		<td class="data">
			<span class="artDataPrimary">{{quiz_name}}</span> <br>
			<span class="artDataSecondary">
				<span class="AboutQuizInScreen">Total Number of Questions: {{pass_score}} Questions <br> 
				Maximum Time Limit: {{quiz_time}} mins</span>
				<span class="AboutQuizInMobile">{{pass_score}} Questions, Time: {{quiz_time}} mins</span>
			</span>
		</td>
		<td class="data">
			{{#IsQuizToStart}}
			<a href="ConductTestRes.php?assignment_id={{assignment_id}}" class="aptBtn">
			{{#IsQuizToContinue}}Continue{{/IsQuizToContinue}}{{^IsQuizToContinue}}Start{{/IsQuizToContinue}}		
			</a>
			{{/IsQuizToStart}}
			{{^IsQuizToStart}}
				{{StatusStr}} 
			{{/IsQuizToStart}}
		</td>
	</tr>
	{{/assignment}}
	{{^assignment}}
		<tr>
		<td class="data">No Active Assignments Found.</td>
		<td class="data">&nbsp;</td>
	</tr>
	{{/assignment}}
</table>	
