var Qhtml= function(){/*
{{#Q}}
<div style="height:20px;" id="{{name}}{{qno}}"> &nbsp;</div>
<div class="card m-2">
	<div class="card-header p-0">
		<div class="input-group m-1 p-0">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">{{name}}</span>
			</div>
			<input type="number" value="{{qno}}" class="form-control  ml-1" style="max-width:5rem!important;">
			<button class="btn btn-warning ml-1">Edit</button>
			<button class="btn btn-danger ml-1">Delete</button>
			<button class="btn btn-dark ml-1">Up</button>
			<button class="btn btn-dark ml-1">Down</button>
		</div> 
	</div>
	<div class="card-body p-0 p-1">
		<p class="text-secondary text-bold m-0 mb-1">Instructions to Question</p>						
		<p class="p-2 border-top border-bottom m-0 mb-1">What is your name?</p>
		<p class="alert alert-secondary m-0 mb-1">Option 1.</p>
		<p class="alert alert-secondary m-0 mb-1">Option 2.</p>
		<p class="alert alert-secondary m-0 mb-1">Option 3.</p>
		<p class="alert alert-secondary m-0">Option 4.</p>
	</div>
	<div class="card-footer text-muted p-0">		
		<div class="input-group m-1 p-0">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">End of {{name}}{{qno}}</span>
			</div>
			<button class="btn btn-warning ml-1" onclick="ShowQuizPageContent();">Edit</button>
			<button class="btn btn-danger ml-1">Delete</button>
		</div>
	</div>
</div>
{{/Q}}		
*/}.toString().slice(14,-3)

/* --------------------------------------------------------------------------------------------------------- */


var Qnohtml= function(){/*
{{#Q}}		
<a class="nav-link p-0 px-2 mr-1 rounded-pill" href="#{{name}}{{qno}}">{{^isq}}{{name}}{{/isq}}{{qno}}</a>
{{/Q}}		
*/}.toString().slice(14,-3)

/* --------------------------------------------------------------------------------------------------------- */

var testListhtml= function(){/*

<div class="container-responsive p-5">
<div class="row  row-cols-1 row-cols-md-3">

	<div class="col-md-4">
	  <div class="card mb-4 shadow-sm h95">
		<div class="card-header p-0">
			<p class="card-text">Not Defined</p>
		</div>
		<div class="card-body">
			<p class="card-text">
				Number of Questions: Not Defined <br>
				<small>Multiple Choice Single Response</small>
			</p>
		</div>
		<div class="card-footer">
			<div class="d-flex justify-content-between align-items-center">
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-outline-secondary" 
						onclick="return ShowTestQuestionPage()">Create Test</button>                  
				</div>
				<small class="text-muted">*** mins</small>
			</div>
		</div>
	  </div>
	</div>

{{#testList}}		

<div class="col-md-4">
	  <div class="card mb-4 shadow-sm h95">
		<div class="card-header p-0">
			<p class="card-text">Assess Test (May-Jun2020) #{{testNo}}</p>
		</div>
		<div class="card-body">
			<p class="card-text">
				Total Number of Questions: 50 <br>
				<small>Multiple Choice Single Response</small>
			</p>
		  
		</div>
		<div class="card-footer">
			<div class="d-flex justify-content-between align-items-center">
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-outline-secondary"  onclick="return ShowTestQuestionPage()">Edit</button>                  
				</div>
				<small class="text-muted">50 mins</small>
			</div>
		</div>
	  </div>
	</div>
{{/testList}}		
</div>
</div>
*/}.toString().slice(14,-3)

/* --------------------------------------------------------------------------------------------------------- */

var TestListPage= function(){/*
<div class="navbar navbar-light bg-light">
	<nav>		
		<div class="d-inline-block">Test List</div>
	</nav>
</div>
<header class="py-0">
	<div class="nav py-0 mb-0">			
		<nav class="nav d-flex justify-content-between py-0" id="testList">				
								
		</nav>			
	</div>
</header>
*/}.toString().slice(14,-3)

var TestQuestionPage= function(){/*
<div class="navbar navbar-light bg-light">	
	<nav>
		<a href="nav-link" onclick="return ShowTestListPage()"> Back </a>
		<div class="d-inline-block">Test Assessment(May-Jun 2020)</div>
	</nav>
</div>

<div class="row">
	<div class="col-2 pr-0">
		<nav id="navbar-example" class="navbar navbar-light bg-light mt-2 ml-1 p-0">
			<nav class="nav nav-pills" id="Qno">
			</nav>
		</nav>
	</div>
	<div class="col-10 pl-0">
		<div data-spy="scroll" data-target="#navbar-example" data-offset="0" class="scrollspy-example-2" id="Q">			
		
		</div>
	</div>
</div>

*/}.toString().slice(14,-3)



var QuizPage= function(){/*
	<div class="navbar navbar-light bg-light">	
		<nav>
			<a href="nav-link" onclick="return ShowTestQuestionPage()"> Back </a>
			<div class="d-inline-block">Test Assessment(May-Jun 2020) > Quiz </div>
		</nav>
	</div>

	<div class="container">

	<form class="form">
	<div class="form-group m-10">
		<label for="#TestName">Test Name</label>
		<input type="text" class="form-control" name="TestName" id="idTestName">
	</div>
	<div class="form-group m-10">
		<label class="d-inline">Instruction</label><input type="button" class="btn btn-dark" onclick="ShowEditorPageContent()" value="Editor">	
		<div class="border-top border-bottom" style="min-height:10rem;" id="idEditorData01"></div>
	</form>
	</div>
*/}.toString().slice(14,-3)

var EditorPage= function(){/*
<div class="container-responsive">


	<div class="navbar navbar-light bg-light">	
		<nav>
			<a href="nav-link" onclick="EditorsDataGet();return ShowQuizPageContent();"> Back </a>
			<div class="d-inline-block">Test Assessment(May-Jun 2020) > Quiz </div>
		</nav>
	</div>
	
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="home" aria-selected="true">Editor</a>
  </li>
  <li class="nav-item" role="presentation" onclick="EditorsDataGet()">
    <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="profile" aria-selected="false">Preview</a>
  </li>
  <li class="nav-item" role="presentation" onclick="EditorsDataGet()">
    <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="profile" aria-selected="false">Source</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">    	
	<textarea class="form-control" style="width:300px;height:100px" name="InstructionExt" id="idInstructionExt">
	</textarea>	
  </div>
  <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
    <div class="" id="idEditorData01"></div>
  </div>
  <div class="tab-pane fade" id="three" role="tabpanel" aria-labelledby="three-tab">	
    <pre id="idEditorData03"></pre>	
  </div>
  
</div>

	
</div>
*/}.toString().slice(14,-3)
/* --------------------------------------------------------------------------------------------------------- */

var QData= function(){
	var data = [];	
	var Qs = 50;
	for(var i=1; i<=Qs; i++){
		if(i==1) 		  data.push({'qno':1,'name':'Quiz','isq':false})		
		if((i-1) % 5 ==0) data.push({'qno':((i-1)/5 + 1),'name':'G','isq':false})		
		/*             */ data.push({'qno':i,'name':'Q','isq':true})	
	}
	return data;
}();

var testData= function(){
	var data = [];	
	var Tests = 10;
	for(var i=1; i<=Tests; i++){
		data.push({'testNo': i})				
	}
	return data;
}()


function resetScrollPos(selector) {
  var divs = document.querySelectorAll(selector);
  for (var p = 0; p < divs.length; p++) {
    if (Boolean(divs[p].style.transform)) { //for IE(10) and firefox
      divs[p].style.transform = 'translate3d(0px, 0px, 0px)';
    } else { //for chrome and safari
      divs[p].style['-webkit-transform'] = 'translate3d(0px, 0px, 0px)';
    }
  }
}
