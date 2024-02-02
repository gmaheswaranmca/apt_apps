var vSuffleRule=[
  {"name":"Test 01",
		"rule":[
		    {"rule":1,"from": 1,"to": 25, "suffleCount":0},
			{"rule":2,"from": 26,"to": 45, "suffleCount":0}
		]
	},{"name":"Test 02",
		"rule":[
		    {"rule":1,"from": 1,"to": 10, "suffleCount":0},
			{"rule":2,"from": 11,"to": 15, "suffleCount":0},
			{"rule":3,"from": 16,"to": 20, "suffleCount":0},
			{"rule":4,"from": 21,"to": 24, "suffleCount":0},
			{"rule":5,"from": 25,"to": 29, "suffleCount":0},
			{"rule":6,"from": 30,"to": 30, "suffleCount":0}
		]
	}
	
];  

var CurrSuffledRules=[];
var CurrRules={};
var CurrRulesIsThere=false;
var CurrRuleSufIdx = 0;
//alert(44);