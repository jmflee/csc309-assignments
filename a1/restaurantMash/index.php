<?php
	ini_set('display_errors', 'On');
	require_once "lib/lib.php";
	require_once "model/Compete.php"; 
	require_once "model/helpers.php";
	require_once "model/Rating.php";

	session_save_path("sess");
	session_start(); 

	$dbconn = db_connect();

	$errors=array();
	$keyerrors=array();
	$view="";

	setSessionDb($dbconn);

    /* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login'; // Login page by default
	}

	switch($_SESSION['state']){
		case "profile":
			$view="profile.php";

			if (!$dbconn) return;
 
            if(isset($_POST['delete']) && $_REQUEST['delete']){
                deleteUser($_SESSION['username']);
                session_destroy();
                $_SESSION['page']='login';
                $_SESSION['state']='login';
                $view="login.php";
                header("Location: index.php");
			    break;
            }
            
            if (isset($_POST['addkey']) && $_REQUEST['addkey']) {
                if(!registerKey($_REQUEST['newAdminkey'],$_SESSION['username'])) {
                    $keyerrors[]='Admin key already exists';    
                }
            }
            
            if (isset($_POST['addRest']) && $_REQUEST['addRest']) {
                if(!addRestaurant($_REQUEST['newRest'], $_REQUEST['elo'])) {
                    $keyerrors[]='Restaurant already exists';    
                }
            }
            
            if (isset($_POST['delRest']) && $_REQUEST['delRest']) {
                if(!deleteRestaurant($_REQUEST['delRest'])) {
                    $keyerrors[]='Restaurant does not exists';    
                }
            }

            if (isset($_POST['update']) && $_REQUEST['update']) {
                if ($_SESSION['acctype']=="voter") {
                    if (!updateUser($_SESSION['username'],$_REQUEST['password'],$_REQUEST['first_name'],$_REQUEST['last_name'],$_REQUEST['email'],$_REQUEST['acctype'],$_REQUEST['adminkey'])) {
                        $errors[]='Error updating account'; 
                    }
                } else {
                    if (!updateUser($_SESSION['username'],$_REQUEST['password'],$_REQUEST['first_name'],$_REQUEST['last_name'],$_REQUEST['email'],$_REQUEST['acctype'],NULL)) {
                        $errors[]='Error updating account'; 
                    }
                }
            }
			 
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="logout"){
                $view=logout();
                header("Location: index.php");
			    break;
            }

			if(!empty($_REQUEST['page']) && $_REQUEST['page']=="compete"){
                $_SESSION['page']='compete';
                $_SESSION['state']='compete';
                $view="app.php";
                header("Location: index.php");
            }
			
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="results"){
                $_SESSION['page']='results';
                $_SESSION['state']='results';
                $view="results.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="history"){
                $_SESSION['page']='history';
                $_SESSION['state']='history';
                $view="history.php";
                header("Location: index.php");
            }
            
            if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="update"){
				break;
			}
            
            break;

        case "compete":
			if (!$dbconn) return;
            $view="app.php";
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="results"){
                $_SESSION['page']='results';
                $_SESSION['state']='results';
                $view="results.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="history"){
                $_SESSION['page']='history';
                $_SESSION['state']='history';
                $view="history.php";
                header("Location: index.php");
            }
			
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="profile"){
                $_SESSION['page']='profile';
                $_SESSION['state']='profile';
                $view="profile.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="logout"){
                $view=logout();
                header("Location: index.php");
			    break;
            }
			
            
            if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="compete"){
				break;
			}
            break;

        case "results":
			if (!$dbconn) return;
            $view="results.php";
            
			if(!empty($_REQUEST['page']) && $_REQUEST['page']=="compete"){
                $_SESSION['page']='compete';
                $_SESSION['state']='compete';
                $view="app.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="history"){
                $_SESSION['page']='history';
                $_SESSION['state']='history';
                $view="history.php";
                header("Location: index.php");
            }
			
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="profile"){
                $_SESSION['page']='profile';
                $_SESSION['state']='profile';
                $view="profile.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="logout"){
                $view=logout();
                header("Location: index.php");
			    break;
            }
			
            if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="results"){
				break;
			}
            break;

        case "history":
			if (!$dbconn) return;
            $view="history.php";
            
			if(!empty($_REQUEST['page']) && $_REQUEST['page']=="compete"){
                $_SESSION['page']='compete';
                $_SESSION['state']='compete';
                $view="app.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="results"){
                $_SESSION['page']='results';
                $_SESSION['state']='results';
                $view="results.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="profile"){
                $_SESSION['page']='profile';
                $_SESSION['state']='profile';
                $view="profile.php";
                header("Location: index.php");
            }
            
            if(!empty($_REQUEST['page']) && $_REQUEST['page']=="logout"){
                $view=logout();
                header("Location: index.php");
			    break;
            }
			
            if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="history"){
				break;
			}
            break;

		case "login":
			// the view we display by default
			$view="login.php";

            // check if new user
			if(!empty($_REQUEST['page']) && $_REQUEST['page']=="register"){
				$_SESSION['state']='register'; 
                $view="register.php";
                header("Location: index.php?page=register");
                break;
			}

			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['username'])){
				$errors[]='username is required';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='password is required';
			}
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if(!$dbconn) return;
            
            if($rows = userInfo($_REQUEST['username'], sha1($_REQUEST['password']))){
				setSession($rows[0],$rows[1],$rows[2],$rows[3],$rows[4],$rows[5]);
                $_SESSION['page']='profile';
                $_SESSION['state']='profile';
				$view="profile.php";
                header("Location: index.php");
			} else {
				$errors[]="invalid login";
			}
			break;

        case "register":
            // change view to register
            $view="register.php";

			if(!empty($_REQUEST['page']) && $_REQUEST['page']=="login"){
				$_SESSION['state']='login'; 
                $view="login.php";
                header("Location: index.php?page=login");
                break;
			}

			// check if submit or not
			if(empty($_REQUEST['page']) || $_REQUEST['page']!="register"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['username'])){
				$errors[]='user is required';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='password is required';
			}
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if(!$dbconn) return;

            if (registerUser($_REQUEST['username'],sha1($_REQUEST['password']),$_REQUEST['first_name'],$_REQUEST['last_name'],$_REQUEST['email'],$_REQUEST['acctype'],$_REQUEST['adminkey'])) {
                $_SESSION['state']='login'; 
                $view="login.php";
                header("Location: index.php?page=login");
            } else {
                $errors[]="Username already exists, please choose another";
            }
			break;
	}
	require_once "view/$view";
?>
