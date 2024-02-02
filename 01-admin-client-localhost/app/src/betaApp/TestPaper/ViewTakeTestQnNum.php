<table align="center">
	<tr>
		<td></td><td>
			<input type="button" class="pgrBt  " value="&#x25C4;" title="Previous Question"
			onclick="TakeTestViewRender.PrevQn()"> 
		</td><td>
			<input type="button" class="pgrBt  " value="&#x25BA;" title="Previous Question"
			onclick="TakeTestViewRender.NextQn()"> 
		</td>
		<td>
			<input type="button" class="pgrBt  " value="&#x003F;" title="Instruction" id="idInstructionAction"
			onclick="TakeTestViewRender.vTakeTestPage.ClickInstruction()"> 
		</td>		
		<td></td>	
	</tr>
	<tr>
		{{#Qs}}
		<td>
			<input type="button" 
			class="pgrBt  {{#IsActive}}pgrBtCurr{{/IsActive}}" 
			value="{{qno_a}}" title="{{qno_a}}"
			onclick="TakeTestViewRender.LoadQn({{qno_a}})"> 
		</td>		
		{{#IsPagerLine}}</tr><tr>{{/IsPagerLine}}
		{{/Qs}}
	</tr>		
	<tr>
		<td></td><td>
			<input type="button" class="pgrBt pgrBtLike " value="&#x1f50e;" title="Simple View"
			onclick="TakeTestViewRender.vTakeTestPage.OutViewQn(1);"> 
		</td><td>
			<input type="button" class="pgrBt pgrBtLike " value="&#9749;" title="html view"
			onclick="TakeTestViewRender.vTakeTestPage.OutViewQn(2);"> 
		</td>
		<td>
			<input type="button" class="pgrBt  " value="&#x270e;" title="Edit View"
			onclick="TakeTestViewRender.vTakeTestPage.OutViewQn(3);"> 
		</td>
		<td>
			<input type="button" class="pgrBt  " value="&#x270e;" title="Edit at Server???"
			onclick="TakeTestViewRender.vTakeTestPage.OutViewServiceQn();">  
		</td>	
	</tr>
	<tr>
		<td colspan="5">
		Opt<input 
		type="button" class="pgrBt  " value="5" title="Option 5" 
		onclick="TakeTestViewRender.vTakeTestPage.OutViewQnOpt(5);"
		><input 
		type="button" class="pgrBt  " value="4" title="Option 4" 
		onclick="TakeTestViewRender.vTakeTestPage.OutViewQnOpt(4);"
		><input 
		type="button" class="pgrBt  " value="3" title="Option 3" 
		onclick="TakeTestViewRender.vTakeTestPage.OutViewQnOpt(3);"
		><input 
		type="button" class="pgrBt  " value="2" title="Option 2" 
		onclick="TakeTestViewRender.vTakeTestPage.OutViewQnOpt(2);"
		><input 
		type="button" class="pgrBt  " value="1" title="Option 1" 
		onclick="TakeTestViewRender.vTakeTestPage.OutViewQnOpt(1);"
		> 
		</td>	
	</tr>
	<tr>
		<td>All</td>
		<td>
			<input type="button" class="pgrBt pgrBtLike " value="&#x1f50e;" title="All Qn View"  id="idAllQnViewAction"
			onclick="TakeTestViewRender.OutQnAll();"> 
		</td>
		<td></td>
		<td></td>
		<td><input type="button" class="pgrBt  " value="&#x1f4be;" title="Save All" id="idSaveAllAction"
			onclick="TakeTestViewRender.SaveTestPaper();"></td>	
	</tr>
</table>