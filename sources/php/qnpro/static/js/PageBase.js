function PageHeaderFix() {
  var header = document.getElementById("myHeader");
  var sticky = topping.offsetTop + topping.offsetHeight;	
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
function FixMenus(v_r, pRole){
	for(var i=0; i < v_r.length; i++){					
		switch(parseInt(v_r[i].id)){
			case 9: case 13:
				v_r[i].redirect_to = "ActiveAssignmentRes.php";
			break;
			case 10:
				v_r[i].redirect_to = "OldAssignmentRes.php";
			break;
		}
		
	}	
}

function SupSel(){
	if (window.getSelection) {
	  if (window.getSelection().empty) {  // Chrome
		window.getSelection().empty();
	  } else if (window.getSelection().removeAllRanges) {  // Firefox
		window.getSelection().removeAllRanges();
	  }
	} else if (document.selection) {  // IE?
	  document.selection.empty();
	}
}	