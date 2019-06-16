// Stage
// Note: Yet another way to declare a class, using .prototype.

function Stage(width, height, monsterNum, percentBox, stageElementID){
	this.actors=[]; // all actors on this stage (monsters, player, boxes, ...)
	this.player=null; // a special actor, the player
  	this.numMonsters = monsterNum; // number of monster
  	this.numMonster; // number of remaining monster
  	this.percentBox= percentBox; // the percentage of box in the game
	// the logical width and height of the stage
  	this.gameState = "START"; // game state
	this.width=width; // game width
	this.height=height; // game height
	this.gameInterval;
	this.score = 0; // game score

	// the element containing the visual representation of the stage
	this.stageElementID=stageElementID; //game element ID

	// take a look at the value of these to understand why we capture them this way
	// an alternative would be to use 'new Image()'
	this.blankImageSrc=document.getElementById('blankImage').src;
	this.monsterImageSrc=document.getElementById('monsterImage').src;
	this.playerImageSrc=document.getElementById('playerImage').src;
	this.boxImageSrc=document.getElementById('boxImage').src;
	this.wallImageSrc=document.getElementById('wallImage').src;
}

// initialize an instance of the game
Stage.prototype.initialize=function(){
	this.score = 0; // setup the score
	this.numMonster = this.numMonsters ; // setup number of remaining monster
	// Create a table of blank images, give each image an ID so we can reference it later
	var s='<table>';
	// YOUR CODE GOES HERE
  	var countMonster = 0;
	for (var y=0; y < this.height; y++){
		s+="<tr>";
		for (var x = 0; x< this.width ; x++){

			// if it is border then add wall to it
			if (x==0 || x == this.height -1 || y == 0 || y == this.height-1){
				s+= '<td><img src="' + this.wallImageSrc +'" id="' + this.getStageId(x,y) + '" style="border:1px solid black"/></td>';
				this.addActor(new Wall(x, y, this, this.wallImageSrc));
			} else{

			// add box or just blank
		        var addWall = Math.random()* 100 < this.percentBox;
		        if (addWall){
		          s+= '<td><img src="' + this.boxImageSrc +'" id="' + this.getStageId(x,y) + '" style="border:1px solid black"/></td>';
		          this.addActor(new Box(x, y, this, this.boxImageSrc));
		        }
		        else
			        s+= '<td><img src="' + this.blankImageSrc +'" id="' + this.getStageId(x,y) + '" style="border:1px solid black"/></td>';
			}
		}
		s+="</tr>";
	}
	s+="</table>";
	var PlayerAdded = 0;

	// Put it in the stageElementID (innerHTML)
	document.getElementById("game-field").innerHTML=s;


	// Add the player to the center of the stage
	var xpos1 = Math.floor(this.width/2);
	var ypos1 = Math.floor(this.height/2);
	if (this.getActor(xpos1, ypos1) != null){
		this.removeActor(this.getActor(xpos1, ypos1));
		this.setImage(xpos1,ypos1, this.blankImageSrc);
	}
	this.player = new Player(xpos1 , ypos1, this , this.playerImageSrc);
	this.addActor(this.player);
	this.setImage(xpos1, ypos1, this.playerImageSrc);
	// Add walls around the outside of the stage, so actors can't leave the stage

	// Add some Boxes to the stage

	// Add in some Monsters
  	while(countMonster < this.numMonster){
	    var xpos = Math.floor(Math.random() * (this.width-1));
	    var ypos = Math.floor(Math.random() * (this.height-1));
	    if (xpos > 1 && xpos < this.height -1 && ypos > 1 && ypos < this.height -1 && this.getActor(xpos,ypos) == null){
	      this.addActor(new Monster(xpos,ypos, stage, this.monsterImageSrc));
	      this.setImage(xpos, ypos, this.monsterImageSrc);
	      countMonster++;
    		}
  	}

	// Setting some setting for new game
  	this.setUpKeyboard();
  	this.gameInterval = setInterval(function(){if(this.gameState == "END") clearInterval(this.gameInterval); else stage.step();}, 1000);
  	document.getElementById("ResumeButton").disabled = true;
	document.getElementById("PauseButton").disabled = false;
	document.getElementById("controls").style ="";
}


// Set state of the game
Stage.prototype.setState=function(State){
  this.gameState = State ;
}


//Get state of the game
Stage.prototype.getState=function(){
  return this.gameState;
}

// Return the ID of a particular image, useful so we don't have to continually reconstruct IDs
Stage.prototype.getStageId=function(x,y){ return "pos_"+x+"_"+y; }


//Add actor to actors
Stage.prototype.addActor=function(actor){
	this.actors.push(actor);
}

// remove actor from actors
Stage.prototype.removeActor=function(actor){
	// Lookup javascript array manipulation (indexOf and splice).
	var xpos = actor.x;
	var ypos = actor.y;
	this.actors.splice(this.actors.indexOf(actor), 1);
	this.setImage(xpos,ypos, this.blankImageSrc);
}

//Remove all actor in the game
Stage.prototype.removeAllActor=function(){
	while (this.actors.length> 0){
		this.actors.splice(0,1);
	}
}

// Set the src of the image at stage location (x,y) to src
Stage.prototype.setImage=function(x, y, src){
	document.getElementById(this.getStageId(x,y)).src = src;
}

// Take one step in the animation of the game.
Stage.prototype.step=function(){
	document.getElementById("GameScore").value = this.score;
	if (this.numMonster == 0){
		this.changeState("END");
		return;
	}
	for(var i=0;i<this.actors.length;i++){
		// each actor takes a single step in the game
    	this.actors[i].step();
	}
}

// return the first actor at coordinates (x,y) return null if there is no such actor
// there should be only one actor at (x,y)!
Stage.prototype.getActor=function(x, y){
	var i = 0;
	for (i=0; i< this.actors.length;i++){
		if (this.actors[i].x == x && this.actors[i].y==y)
			return this.actors[i];
	}
  return null;
}

//Switch new image with the new image
Stage.prototype.switchImage=function(newX, newY, newImg, oldX, oldY, oldImg){
	this.setImage(newX,newY,oldImg);
	this.setImage(oldX,oldY,newImg);
}


// Is called everytime gamestate is changed
Stage.prototype.changeState=function(newState){
	this.gameState = newState;
	switch (this.gameState){
		case "START":
			this.removeAllActor();
			this.actors=[];
			this.player = null;
  			document.getElementById("ResumeButton").disabled = true;
			document.getElementById("PauseButton").disabled = false;
			document.getElementById("controls").style ="";
			clearInterval(this.gameInterval);
			this.initialize();
			break;
		case "END":

			this.removeAllActor();
			this.actors=[];
			this.player = null;
  			document.getElementById("ResumeButton").disabled = true;
			document.getElementById("PauseButton").disabled = true;
			document.getElementById("controls").style ="display:none";
			clearInterval(this.gameInterval);
			this.stopKeyboard();
			if (this.numMonster == 0) {
				alert("Congrats You Won!\n Final Score: "+$('#GameScore').val()+" points!");
				update_highscore("win");
			} else {
				alert("Game Over\n You Scored: "+$('#GameScore').val()+" points!");
				update_highscore("loss");
			}
			break;
		case "PAUSE":
			document.getElementById("ResumeButton").disabled = false;
			document.getElementById("PauseButton").disabled = true;
			document.getElementById("controls").style ="display:none";
			this.stopKeyboard();
			clearInterval(this.gameInterval);
			break;
		case "RESUME":
			document.getElementById("ResumeButton").disabled = true;
			document.getElementById("PauseButton").disabled = false;
			document.getElementById("controls").style ="";
			this.setUpKeyboard();
			this.gameInterval = setInterval(function(){if(this.gameState == "END") clearInterval(this.gameInterval); else stage.step();}, 1000);
			break;
		case "QUIT":
			break;
		default:
			break;

	}
}

//when a control putton is pressed
Stage.prototype.press = function(newMove){
	switch (newMove){
		case "N":
			this.player.setMove(-1,0);
			break;
		case "NW":
			this.player.setMove(-1,-1);
			break;
		case "NE":
			this.player.setMove(-1,1);
			break;
		case "E":
			this.player.setMove(0,1);
		 	break;
		case "W":
			this.player.setMove(0,-1);
			break;
		case "S":
			this.player.setMove(1,0);
			break;
		case "SE":
			this.player.setMove(1,1);
			break;
		case "SW":
			this.player.setMove(1,-1);
			break;
		default:
			break;

	}
}

// Set up a keyboard listener
Stage.prototype.setUpKeyboard=function(){
	document.onkeydown = function(event) {
		var keyboard = event.keyCode;
		switch(keyboard){
			case 81:
				stage.player.setMove(-1,-1);
				break;
			case 87:
				stage.player.setMove(-1, 0);
				break;
			case 69:
				stage.player.setMove(-1, 1);
				break;
			case 65:
				stage.player.setMove(0,-1);
				break;
			case 68:
				stage.player.setMove(0,1);
				break;
			case 90:
				stage.player.setMove(1,-1);
				break;
			case 88:
				stage.player.setMove(1,0);
				break;
			case 67:
				stage.player.setMove(1,1);
				break;
			default:
				break;
		}

	}
}

// deactivate keyboard listener
Stage.prototype.stopKeyboard= function(){
	document.onkeydown = null;
}

// End Class Stage
