"use strict";

document.observe("dom:loaded", function() {
	 
	 var images = $$("#labs > img");
	 for(var i=0; i<images.length; i++) {
	 	new Draggable(images[i], {revert: true});
	 }

	 /* selectpad에 drop할 때, labSelect 함수를 호출 */
	 Droppables.add("selectpad", {onDrop: labSelect});

	 /* labs에 drop할 때, labSelect 함수를 호출 */
	 Droppables.add("labs", {onDrop: labSelect});
	
});
	

function labSelect(drag, drop, event) {
	var number = $$("#selectpad > img").length;	
	var flag = "ON";


	if(drop.id === "selectpad" && drag.up(0).id === "labs") {
		if(number < 3) {
			$("selectpad").appendChild(drag);
			var alt = drag.readAttribute("alt");

			var lis = $$("li");
			for(var i=0; i<lis.length; i++) {
				if(lis[i].innerHTML === alt) {
					flag = "OFF";
				} 
			}

			if(flag === "ON"){
				var li = document.createElement("li");
				$("selection").appendChild(li);
				$("selection").lastChild.innerHTML = alt;
				$("selection").lastChild.pulsate({
					delay: 0.5,
				    duration: 1.0
				});
			}		
		}	
	}


	if(drop.id === "labs" && drag.up(0).id === "selectpad") {
		$("labs").appendChild(drag);
		var lis = $$("li");
		var alt = drag.readAttribute("alt");
		var temp;
		for(var i=0; i<lis.length; i++) {
			if(lis[i].innerHTML === alt) {
				temp = i;
			} 
		}
		$("selection").removeChild($("selection").childNodes[temp]);
	}
	
}









