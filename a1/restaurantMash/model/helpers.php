<?php
    $errors;

    function setSessionDb($dbconn) {
        $_SESSION['dbconn']=$dbconn;
    }

    function logout() {
        session_destroy();
        $_SESSION['page']='login';
        $_SESSION['state']='login';
        return "login.php";
    }

    function userInfo ($user,$password) {
        $query = "SELECT * FROM users WHERE username=$1 and password=$2;";
        $result = pg_prepare($_SESSION['dbconn'],"login",$query);
        $result = pg_execute($_SESSION['dbconn'],"login",array($user,$password));
        return pg_fetch_row($result);
    }

    function userExists($user) {
        $query = "SELECT * FROM users WHERE username=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"find_duplicates",$query);
        $result = pg_execute($_SESSION['dbconn'],"find_duplicates",array($user));
        if (pg_num_rows($result) > 0) {
            return True;
        }
        return False;
    }

    function keyCheck($adminkey) {
        $query = "SELECT aKey FROM adminkeys WHERE akey=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"find_aKey",$query);
        $result = pg_execute($_SESSION['dbconn'],"find_aKey",array(sha1($adminkey)));
        if (pg_num_rows($result) > 0) {
            return True;
        }
        return False; 
    }
    
    function registerKey($newAdminkey,$username) {
        if (keyCheck($newAdminkey)) {
            return False;
        }
        $query = "INSERT INTO adminkeys (akey,key_owner) VALUES ($1,$2);";
        $result = pg_prepare($_SESSION['dbconn'],"register_aKey",$query);
        $result = pg_execute($_SESSION['dbconn'],"register_aKey",array(sha1($newAdminkey),$username));
        return True;
    }

    function registerUser($user,$pass,$first_name,$last_name,$email,$acc_type,$adminkey) {
        if (!userExists($user)) {
            if ($acc_type=="admin" && !keyCheck($adminkey)) {
                $errors[]="Invalid admin access key";
                return False; 
            }
            $query = "INSERT INTO users (username, password, first_name, last_name, email, account_type) VALUES ($1,$2,$3,$4,$5,$6);";
            $result = pg_prepare($_SESSION['dbconn'],"create_user",$query);
            $result = pg_execute($_SESSION['dbconn'],"create_user",array($user,$pass,$first_name,$last_name,$email,$acc_type));
            return True;
        } else {
            $errors[]="Username already exists, please choose another";
            return False;
        }
    }

    function deleteUser($user) {
        $query = "DELETE FROM users where username=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"delete_user",$query);
        $result = pg_execute($_SESSION['dbconn'],"delete_user",array($user)); 
    }

    function updateUser($user,$pass,$first_name,$last_name,$email,$acc_type,$adminkey) {
        if ($_SESSION['acctype']=="voter" && $acc_type=="admin" && !keyCheck($adminkey)) {
            $errors[]="Invalid admin access key";
            return False;
        }
        $pass = ($pass) ? sha1($pass) : $_SESSION['password'];
        $first_name = ($first_name) ? $first_name : $_SESSION['first_name'];
        $last_name = ($last_name) ? $last_name : $_SESSION['last_name'];
        $email = ($email) ? $email : $_SESSION['email'];
        $acc_type = ($acc_type) ? $acc_type : $_SESSION['acctype'];
        
        $query = "UPDATE users SET password=$1,first_name=$2,last_name=$3,email=$4,account_type=$5 WHERE username=$6;";
        $result = pg_prepare($_SESSION['dbconn'],"update_user",$query);
        $result = pg_execute($_SESSION['dbconn'],"update_user",array($pass,$first_name,$last_name,$email,$acc_type,$user));
        setSession($user,$pass,$first_name,$last_name,$email,$acc_type);
        return True;
    }
    function restExists($rest) {
        $query = "SELECT * FROM restaurants WHERE restaurant_name=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"find_rest",$query);
        $result = pg_execute($_SESSION['dbconn'],"find_rest",array($rest));
        if (pg_num_rows($result) > 0) {
            return True;
        }
        return False;
    }
    function addRestaurant($rest,$elo) {
        if (restExists($rest)) return false; 
        $query = "INSERT INTO restaurants (restaurant_name,elo) VALUES ($1, $2);";
        $result = pg_prepare($_SESSION['dbconn'],"add_rest",$query);
        $result = pg_execute($_SESSION['dbconn'],"add_rest",array($rest,$elo));
        return True;
    }
    function deleteRestaurant($rest) {
        if (!restExists($rest)) return false; 
        $query = "DELETE FROM restaurants where restaurant_name=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"del_rest",$query);
        $result = pg_execute($_SESSION['dbconn'],"del_rest",array($rest));
        return True;
    }
    
    function getAll() {
        $query = "select w.restaurant_name, w.elo, w.wins, l.losses from (select restaurants.restaurant_name as restaurant_name, elo, count(restaurantgood) as Wins from restaurants left join voting on restaurants.restaurant_name=voting.restaurantgood group by restaurants.restaurant_name) as w,(select restaurants.restaurant_name as restaurant_name, elo, count(restaurantbad) as losses from restaurants left join voting on restaurants.restaurant_name=voting.restaurantbad group by restaurants.restaurant_name) as l where w.restaurant_name=l.restaurant_name order by w.elo desc;";
        $result = pg_prepare($_SESSION['dbconn'],"get_all_restaurants",$query);
        $result = pg_execute($_SESSION['dbconn'],"get_all_restaurants",array());
        return $result;
    }
    
    function countAll() {
        $query = "select username from voting;";
        $result = pg_prepare($_SESSION['dbconn'],"get_all_votes",$query);
        $result = pg_execute($_SESSION['dbconn'],"get_all_votes",array());
        return pg_num_rows($result);
    }
    
    function getUserVotes($user) {
        $query = "SELECT restaurantgood,restaurantbad FROM voting where username=$1;";
        $result = pg_prepare($_SESSION['dbconn'],"",$query);
        $result = pg_execute($_SESSION['dbconn'],"",array($user));
        return $result;
    }

    function setSession ($user,$pass,$first_name,$last_name,$email,$acc_type) { 
        $_SESSION['username']=$user;
        $_SESSION['password']=$pass;
        $_SESSION['first_name']=$first_name;
        $_SESSION['last_name']=$last_name;
        $_SESSION['email']=$email;
        $_SESSION['acctype']=$acc_type;
    }
?>
