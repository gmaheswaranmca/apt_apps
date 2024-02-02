<div style="background-color: #F4F5F7; border: 1px solid #97A3AF; border-radius: 20px; padding: 20px; margin-top: 10px;
 font-family: Arial; font-size: 12pt;">
	{{#assess_list}}
	
		<div>
			<b>{{assignment_name}}</b><br/>
			<span style="color: #738f93;">Number of Questions:{{total_q}}</span><br/>
			<!--<span style="color: #738f93;">Maximum Point:{{total_score}}</span><br/>-->
			<span style="color: #738f93;">Maximum Duration:{{total_duration}}mins</span><br/>
		</div>
		<div>
			{{#IsQuizToStart}}
			{{#IsQuizToContinue}}
				<!--{{#AdjDatTime}}<span style="color: #738f93;">Remaning Time:{{mins}}Mins</span><br/>{{/AdjDatTime}}-->
				<br/><a href="ConductCodeTestRes.php?assess_id={{assess_id}}" class="aptBtn" style="text-decoration:none;">Continue</a>
				<br/><br/><br/>
			{{/IsQuizToContinue}}
			{{^IsQuizToContinue}}		
				
				<br/><a href="ConductCodeTestRes.php?assess_id={{assess_id}}" class="aptBtn"  style="text-decoration:none;">Start</a>
				<br/><br/><br/>
			{{/IsQuizToContinue}}
			{{/IsQuizToStart}}
			{{^IsQuizToStart}}
				You have already finished this test.<br/>
				<!-- Point: {{user_secure_score}} / {{total_score}}--><br/><br/>
			{{/IsQuizToStart}}
		</div>	
	{{/assess_list}}
	{{^assess_list}}		
			No Active Assignments Found.		
	{{/assess_list}}
</div>
