class Monster{

	//constructor for class monster
	constructor(x, y, stage, img){
		this.x = x;
		this.y = y;
		this.stage = stage;
		this.img = img;
	}

	// Called everytime by Stage.prototype.step()
	step(){

	// Search for player in nearby
	if (this.checkPlayerNearby() == 1){
    		this.getPlayer();
    		this.stage.changeState("END");

    	} else if (this.checkDeadEnd() == 1){
    		this.stage.numMonster	--;
    		this.stage.score+=500;
    		this.stage.removeActor(this);
    		this.stage.setImage(this.x, this.y, this.stage.blankImageSrc);
    	} else {
    		var newX = this.x + Math.floor(Math.random()*3)-1;
    		var newY =this.y +  Math.floor(Math.random()*3)-1;
    		while (newX == this.x && newY == this.y || this.stage.getActor(newX, newY) != null){
    			newX = this.x + Math.floor(Math.random()*3)-1;
    			newY = this.y + Math.floor(Math.random()*3)-1;
    		}
    		this.stage.switchImage(this.x, this.y, this.img, newX, newY, this.stage.blankImageSrc);
    		this.x = newX;
    		this.y = newY;

    	}
}

	//Check if no way out
	checkDeadEnd(){
		var i;
		var j;
		for(i = this.x-1; i < this.x+2; i++){
			for(j = this.y-1; j < this.y+2; j++){
				var newNeighbor=this.stage.getActor(i,j);
				if (newNeighbor == null)
					return 0;
			}
		}

		return 1;
	}

	// Found player kill him
	getPlayer(){
		var newX = this.stage.player.x;
		var newY = this.stage.player.y;
		this.stage.switchImage(this.x, this.y, this.img, newX, newY, this.stage.blankImageSrc);
    		this.x = newX;
    		this.y = newY;
	}

	//Return 1 if player is nearby otherwise 0
	checkPlayerNearby(){
		if (this.stage.player.x <= this.x+1  && this.stage.player.x >= this.x-1 &&
			this.stage.player.y <= this.y+1  && this.stage.player.y >= this.y-1){
			return 1;
		}
		return 0;
	}

	//move to this position
	setPos(x, y){
		this.x = x;
		this.y = y;
		this.stage.setImage(this.x, this.y, this.img);
	}

}
