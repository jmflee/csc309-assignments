<?php
$_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : $_SESSION['username'];
$_REQUEST['acctype']=!empty($_REQUEST['acctype']) ? $_REQUEST['acctype'] : $_SESSION['acctype'];
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
			<li> <a href="index.php?page=compete">Compete</a>
            <?php if(pg_num_rows(getUserVotes($_SESSION['username'])) >= 10) {
                    echo "<li> <a href=\"index.php?page=results\">Results</a>";
            } ?>
            <li> <a href=""><font color="red">History</font></a>
            <li> <a href="index.php?page=profile">Profile</a>
            <li> <a href="index.php?page=logout">Logout</a>
            </ul>
		</nav>
		<main>
			<h1>Results</h1>
				<form method="post">
					<table>
                        <?php
                            $entries=getUserVotes($_SESSION['username']);
                            $votes=pg_num_rows($entries);
                            echo "<tr><th><h2>Your Total Votes: $votes</h2></th></tr>";
						    echo "<tr> <th>Voted for</th><th>Against</th></tr>";
                            while($rows=pg_fetch_row($entries)) {
                                echo "<tr><th><font color=\"green\">$rows[0]</font></th><th><font color=\"red\">$rows[1]</font></th></tr>";
                            }
                        ?>
					</table>
				</form>	
		</main>
		<footer>
		</footer>
	</body>
</html>

