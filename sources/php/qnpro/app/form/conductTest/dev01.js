function Dev01Controller(passignment_id){
		this.m_assignment_id = passignment_id;
		this.OnLoad=function(){	
			this.dat = new AppData();
			this.act = new AppAct();
			alert(1);
		};
	
}

function AppData(){
  
}

function AppAct(){
   this.act1=function(){
		JsController.dat.Q = [];
		var vQ = JsController.dat.Q;
		var q1 = {name:"Mahesh",rno:101,idx:1};
		var q2 = {name:"Rajesh",rno:102,idx:2};
		vQ.push(q1);
		vQ.push(q2);
		console.log(vQ);
   }
   this.act2=function(){		
		var vQ = JsController.dat.Q;
		for(i=0;i<vQ.length;i++)
			vQ[i].rno = vQ[i].rno + "oo";
		console.log(vQ);
   }
   this.act3=function(){		
		var vQ = JsController.dat.Q		;
		console.log(vQ);
   }
   this.act4=function(){		
		JsController.dat.Pgr = [];
		var Pgr = JsController.dat.Pgr;
		var p1 = {i:0,g:JsController.act.getObj}
		var p2 = {i:1,g:JsController.act.getObj}
		Pgr.push(p1); Pgr.push(p2);
		this.act5();
		
   }
   this.getObj =function(){
		alert(this.i);
		var vQ = JsController.dat.Q;
		return vQ[this.i];
   }
   this.act5=function(){
		$("#act02").html(Mustache.render("{{#page}}Name:{{#g}}{{name}}{{/g}}{{/page}}", {page:JsController.dat.Pgr}));
   }
   
}