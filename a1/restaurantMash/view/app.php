<?php
$_REQUEST['username']=!empty($_SESSION['username']) ? $_SESSION['username'] : '';
$_SESSION['voter']=!empty($_SESSION['voter']) ? $_SESSION['voter'] : '';
$_SESSION['combos']=!empty($_SESSION['combos']) ? $_SESSION['combos'] : False;
$_SESSION['r1']=!empty($_SESSION['r1']) ? $_SESSION['r1'] : '';
$_SESSION['r2']=!empty($_SESSION['r2']) ? $_SESSION['r2'] : '';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>RestaurantMash</title>
	</head>
	<body>
		<header><h1>RestaurantMash</h1></header>
		<nav>
			<ul>
            <li> <a href=""><font color="red">Compete</font></a>
            <?php if(pg_num_rows(getUserVotes($_SESSION['username'])) >= 10) {
                    echo "<li> <a href=\"index.php?page=results\">Results</a>";
            } ?>
            <li> <a href="index.php?page=history">History</a>
			<li> <a href="index.php?page=profile">Profile</a>
            <li> <a href="index.php?page=logout">Logout</a>
            </ul>
		</nav>
		<main>
			
			<h1>Compete</h1>
			<h2>Which restaurant would you rather go to?</h2>
			
			<form method="post">
				<table>
                    <?php
                        $_SESSION['voter'] = new Compete ($_SESSION['username']);
                        $_SESSION['combos']=$_SESSION['voter']->generateComparisons();
                        $_SESSION['r1'] = $_SESSION['voter']->getR1(); 
                        $_SESSION['r2'] = $_SESSION['voter']->getR2(); 

                        if (isset($_REQUEST['left'])) {
                            $_SESSION['voter']-> voteleft();
                        }
                        if (isset($_REQUEST['right'])) {
                            $_SESSION['voter']-> voteright();
                        }
                    ?>
				   <tr>
		 		   <th class="choice"><button type="submit" name="left" value="Left" <?php if(!$_SESSION['combos']){ echo "disabled=\"disabled\""; } ?>><?php echo $_SESSION['r1'] ?></button></th>
				   <th>or</th>
				   <th class="choice"><button type="submit" name="right" value="Right" <?php if(!$_SESSION['combos']){ echo "disabled=\"disabled\""; } ?>><?php echo $_SESSION['r2'] ?></button></th>
				   <th>or</th>
				   <th class="choice"><button type="submit" name="choose" value="Neither">I don't like either</button></th>
				   </tr>
				</table>
			</form>

			
		</main>
		<footer>
		</footer>
	</body>
</html>

