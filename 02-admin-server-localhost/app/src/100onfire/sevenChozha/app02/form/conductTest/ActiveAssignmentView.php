<table class="aptTable">
	{{#assignment}}
	{{#IsMcq}}
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
	{{/IsMcq}}
	
	{{#IsCode}}
	<tr>
		<td class="data">
			<span class="artDataPrimary">{{assignment_name}}</span> <br>
			<span class="artDataSecondary">
				<span class="AboutQuizInScreen">Number of Questions:{{total_q}} <br> 
				Maximum Duration:{{total_duration}}mins</span>
				<span class="AboutQuizInMobile">{{total_q}} Questions, Time: {{total_duration}} mins</span>
			</span>
		</td>
		<td class="data">
			{{#IsQuizToStart}}
			<!--a href="#" class="aptBtn" style="text-decoration:none;" onclick="alert('We are upgrading the app for our technical coding test feature.\n You will get the link shortly.');">
			Go</a-->
			<a href="ConductCodeTestRes.php?assess_id={{assess_id}}" class="aptBtn" style="text-decoration:none;">
			{{#IsQuizToContinue}}Continue{{/IsQuizToContinue}}{{^IsQuizToContinue}}Start{{/IsQuizToContinue}}		
			</a>
			{{/IsQuizToStart}}
			{{^IsQuizToStart}}
				You have already finished this test. 
				<!-- Point: {{user_secure_score}} / {{total_score}}-->
			{{/IsQuizToStart}}
		</td>
	</tr>
	{{/IsCode}}

	{{#IsLink}}
	<tr>
		<td class="data">
			<span class="artDataPrimary">{{link_text}}</span> 
			
		</td>
		<td class="data">
			
			<a href="{{link_url}}" class="aptBtn" target="_blank">
			Download		
			</a>
			
		</td>
	</tr>
	{{/IsLink}}
	{{/assignment}}
	{{^assignment}}
		<tr>
		<td class="data">No Active Assignments Found.</td>
		<td class="data">&nbsp;</td>
	</tr>
	{{/assignment}}
</table>	
