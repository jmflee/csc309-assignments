<?php

class Compete {

	public function __construct($id) {
        $this->user=$id;
        $this->restaurant1="";
        $this->restaurant2="";
    }
    
    public function eloAdjust($r1,$r2) {
        $query = "SELECT elo FROM restaurants WHERE restaurant_name=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"",$query);
        $result = pg_execute($_SESSION['dbconn'],"",array($r1));
        while($row=pg_fetch_row($result)) {
            $r1Elo = $row[0];
        }
        
        $query = "SELECT elo FROM restaurants WHERE restaurant_name=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"",$query);
        $result = pg_execute($_SESSION['dbconn'],"",array($r2));
        while($row=pg_fetch_row($result)) {
            $r2Elo = $row[0];
        }

        $difference = new Rating($r1Elo,$r2Elo,100,-100);
        $elo = $difference->getNewRatings();

        $query = "UPDATE restaurants SET elo=$1 WHERE restaurant_name=$2;";
        $result = pg_prepare($_SESSION['dbconn'],"",$query);
        $result = pg_execute($_SESSION['dbconn'],"",array($elo['a'],$r1));
        
        $query = "UPDATE restaurants SET elo=$1 WHERE restaurant_name=$2;";
        $result = pg_prepare($_SESSION['dbconn'],"",$query);
        $result = pg_execute($_SESSION['dbconn'],"",array($elo['b'],$r2));

    }
    
    public function voteleft() {
        $query = "INSERT INTO voting (username,restaurantgood,restaurantbad) VALUES ($1,$2,$3);";
        $result = pg_prepare($_SESSION['dbconn'],"vote",$query);
        $result = pg_execute($_SESSION['dbconn'],"vote",array($this->user,$this->restaurant1,$this->restaurant2));
        $this->eloAdjust($this->restaurant1,$this->restaurant2);
        return True;
    }
    
    public function voteright() {
        $query = "INSERT INTO voting (username,restaurantgood,restaurantbad) VALUES ($1,$2,$3);";
        $result = pg_prepare($_SESSION['dbconn'],"vote",$query);
        $result = pg_execute($_SESSION['dbconn'],"vote",array($this->user,$this->restaurant2,$this->restaurant1));
        $this->eloAdjust($this->restaurant2,$this->restaurant1);
        return True;
    }
    
    public function generateComparisons() {
        $unique=False;
        $cap=$this->getCombinations();
        for($i=0;$i<$cap && $unique==False;$i++){
            $result=$this->getCompare();
            for ($x=0;$rows=pg_fetch_row($result);$x++) {
                $restaurant[$x] = $rows[0];
            }
            if ($this->uniqueComparison($restaurant[0],$restaurant[1])) {
                $this->restaurant1=$restaurant[0];
                $this->restaurant2=$restaurant[1];
                $unique=True;
            }
        }

        return $unique;

    }

    private function uniqueComparison($r1,$r2) {
        $query = "SELECT username FROM voting WHERE username=$1 AND restaurantgood=$2 AND restaurantbad=$3;";
        $result1 = pg_prepare($_SESSION['dbconn'],"",$query);
        $result1 = pg_execute($_SESSION['dbconn'],"",array($this->user,$r1,$r2));
        $vote1=pg_num_rows($result1);
        
        $query = "SELECT username FROM voting WHERE username=$1 AND restaurantgood=$2 AND restaurantbad=$3;";
        $result2 = pg_prepare($_SESSION['dbconn'],"",$query);
        $result2 = pg_execute($_SESSION['dbconn'],"",array($this->user,$r2,$r1));
        $vote2=pg_num_rows($result2);

        return (($vote1+$vote2)==0) ? True : False;
    }

    function getCompare() {
        $query = "SELECT restaurant_name FROM restaurants ORDER BY RANDOM() LIMIT 2;";
        $result = pg_prepare($_SESSION['dbconn'],"",$query);
        $result = pg_execute($_SESSION['dbconn'],"",array());
        return $result;

    }

    function getCombinations() {
        $query = "SELECT * FROM restaurants;";
        $result = pg_prepare($_SESSION['dbconn'],"",$query);
        $result = pg_execute($_SESSION['dbconn'],"",array());
        return (pg_num_rows($result)*2)-1;
    }

    public function getR1() {
        return $this->restaurant1;
    }
    
    public function getR2() {
        return $this->restaurant2;
    }
}
?>

