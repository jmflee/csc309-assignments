<?php
$_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : $_SESSION['username'];
$_REQUEST['acctype']=!empty($_REQUEST['acctype']) ? $_REQUEST['acctype'] : $_SESSION['acctype'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="refresh" content="10" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>RestaurantMash</title>
	</head>
	<body>
		<header><h1>RestaurantMash</h1></header>
		<nav>
			<ul>
			<li> <a href="index.php?page=compete">Compete</a>
            <li> <a href=""><font color="red">Results</font></a>
            <li> <a href="index.php?page=history">History</a>
            <li> <a href="index.php?page=profile">Profile</a>
            <li> <a href="index.php?page=logout">Logout</a>
            </ul>
		</nav>
		<main>
			<h1>Results</h1>
				<form method="post">
					<table>
                        <?php
                            $entries=getAll();
                            $votes=countAll();
                            echo "</tr><th><h2>Total User Votes: $votes</h2></th></tr>";
						    echo "<tr> <th>Restaurant</th><th>Rating</th><th>Wins</th><th>Losses</th></tr>";
                            while($rows=pg_fetch_row($entries)) {
                                echo "<tr><th>$rows[0]</th><th>$rows[1]</th><th>$rows[2]</th><th>$rows[3]</th></tr>";
                            }
                        ?>
					</table>
				</form>	
		</main>
		<footer>
		</footer>
	</body>
</html>

