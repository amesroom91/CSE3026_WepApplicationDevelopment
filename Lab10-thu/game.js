"use strict";

var numberOfBlocks = 9;
var targetBlocks = [];
var trapBlock;
var targetTimer;
var trapTimer;
var instantTimer;

document.observe('dom:loaded', function() {
	$("start").observe("click", clickGreenBtn);
	$("stop").observe("click", stopGame);
});

function clickGreenBtn() {
	$("state").innerHTML = "Ready!";
	$("score").innerHTML = "0";
	resetTimer();
	setTimeout(startGame, 3000);	
}

function startGame() {
	targetBlocks = [];
	trapBlock = null;
	resetTimer();
	var blocks = $$(".block");
	for(var i=0; i<blocks.length; i++) {
		blocks[i].removeClassName("target");
		blocks[i].removeClassName("trap");
	}
	startToCatch();
}

function stopGame() {
	$("state").innerHTML = "Stop";
	targetBlocks = [];
	trapBlock = null;
	resetTimer();
	var Blocks = $$(".block");
   	for(var i=0; i<Blocks.length; i++) {
		Blocks[i].stopObserving();
	}
}

function startToCatch() {
	// Change state to “Catch!”
	$("state").innerHTML = "Catch!";
	
	var blocks = $$(".block");
	var TargetIdx = -1;
	var TrapIdx = -1;
	var currentBlock = null;
	var score = 0;
	// Show target block that is picked randomly every sec (Ex 3)
	targetTimer = setInterval(showTargetBlock, 1000, blocks, TargetIdx);
	// Show trap block that is picked randomly every 3 sec (Ex 4)
	trapTimer = setInterval(showTrapBlock, 3000, blocks, TrapIdx);
	// Attach event handler for blocks (Ex 5)
	for(var i=0; i<numberOfBlocks; i++) {
		blocks[i].observe("click", function() {
			if(!(this.hasClassName("target") || this.hasClassName("trap"))) {
				if(score >= 10) {
					score -= 10;
				}
				this.addClassName("wrong");
				currentBlock = this;
				instantTimer = setTimeout(function(){ 
					currentBlock.removeClassName("wrong");}, 100);
			} else if(this.hasClassName("target")) {
				score += 20;
				this.removeClassName("target");
				for(var i=0; i<targetBlocks.length; i++) {
					if(blocks[targetBlocks[i]] === this) {
						targetBlocks.splice(i, 1);
					}
				}
			} else if(this.hasClassName("trap")) {
				if(score >= 30) {
					score -= 30;
				} else if(score < 30) {
					score = 0;
				}
				this.removeClassName("trap");
			}
			$("score").innerHTML = score;
		});
	}
}

function resetTimer() {
	//Reset timer. -> clearTimeout or clearInterval?
	clearInterval(targetTimer);
    clearInterval(trapTimer);
    clearInterval(instantTimer);
}

function showTargetBlock(arr, idx) {
	if(targetBlocks.length === 0) {
		idx = Math.floor(Math.random() * numberOfBlocks);
		targetBlocks.push(idx);
	} else {
		while(true) {
			idx = Math.floor(Math.random() * numberOfBlocks);
			print_r(targetBlocks);
			if(targetBlocks.indexOf(idx) === -1) {
				targetBlocks.push(idx);
				break;
			}
		}
	}
	arr[idx].addClassName("target");
	if(targetBlocks.length >= 5) {
		alert("you lose");
		// Also, detach the event handler to prohibit selecting more answers by user.
		instantTimer = setTimeout(stopGame, null);
	}
}

function showTrapBlock(arr, idx) {
	idx = Math.floor(Math.random() * numberOfBlocks);
	while(targetBlocks.indexOf(idx) !== -1) {
		idx = Math.floor(Math.random()*numberOfBlocks);
	}
	trapBlock = idx;
	arr[idx].addClassName("trap");
	instantTimer = setTimeout(function() { 
		arr[idx].removeClassName("trap");}, 2000);	   
}


/* 배열 내용을 alert로 확인하는 것이 귀찮아서, 콘솔로 띄우도록 만든 함수 */
function print_r(s) {
    for(var i = 0; i < s.length; i++) {
        console.log("["+i+"] => " + s[i] + " <br/>"); 
    }
    /* \[[0-9]+\] => */
}


