<?php
$_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : $_SESSION['username'];
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : $_SESSION['password'];
$_REQUEST['first_name']=!empty($_REQUEST['first_name']) ? $_REQUEST['first_name'] : $_SESSION['first_name'];
$_REQUEST['last_name']=!empty($_REQUEST['last_name']) ? $_REQUEST['last_name'] : $_SESSION['last_name'];
$_REQUEST['email']=!empty($_REQUEST['email']) ? $_REQUEST['email'] : $_SESSION['email'];
$_REQUEST['acctype']=!empty($_REQUEST['acctype']) ? $_REQUEST['acctype'] : $_SESSION['acctype'];
$_REQUEST['adminkey']=!empty($_REQUEST['adminkey']) ? $_REQUEST['adminkey'] : '';
$_REQUEST['newadminkey']=!empty($_REQUEST['newAdminkey']) ? $_REQUEST['newAdminkey'] : '';
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
			<li> <a href="index.php?page=history">History</a>
			<li> <a href=""><font color="red">Profile</font></a>
            <li> <a href="index.php?page=logout">Logout</a>
            </ul>
		</nav>
		<main>
			<h1>Welcome back <?php echo $_SESSION['username'] ?>!</h1>
            <form method="post">
            <fieldset>
				<legend>Edit Profile</legend>
				<table>
                    <tr><th><input type="submit" name="delete" value="Delete Account" /></td></tr>
                    <tr><th><label for="username">Username</label></th><td><input type="text" name="username" disabled="disabled" value="<?php echo($_REQUEST['username']); ?>" required/></td></tr>
					<tr><th><label for="password">Password</label></th><td> <input type="password" name="password" /></td></tr>
					<tr><th><label for="first_name">First Name</label></th><td><input type="text" name="first_name" value="<?php echo($_REQUEST['first_name']); ?>" /></td></tr>
					<tr><th><label for="last_name">Last Name</label></th><td><input type="text" name="last_name" value="<?php echo($_REQUEST['last_name']); ?>" /></td></tr>
					<tr><th><label for="email">Email</label></th><td><input type="email" name="email" value="<?php echo($_REQUEST['email']); ?>" /></td></tr>
					<tr><th><label for="acctype">Changing as a</label></th><td>                        
                        <input type="radio" name="acctype" value="voter" <?php echo ($_REQUEST['acctype']=="voter")?"checked":'' ?>>Voter</input>
                        <input type="radio" name="acctype" value="admin" <?php echo ($_REQUEST['acctype']=="admin")?"checked":'' ?>>Admin</input>
                    </td></tr>
                    <?php 
                        if($_SESSION['acctype']=="voter") { 
                            echo "<tr><th><label for=\"upgrade\">Convert to Admin with Key</label></th><td><input type=\"password\" name=\"adminkey\" /></td></tr>";
                        }
                    ?>
                    <tr><th><input type="submit" name="update" value="Update" /></td></tr>
					<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
				</table>
                </fieldset>
                <?php 
                    if($_SESSION['acctype']=="admin") { 
                        echo "<fieldset>
                                <legend>Admin Options</legend>
                                <table>
                                    <tr><th><label for=\"newAdminkey\">Create a new Admin Key</label></th><td><input type=\"password\" name=\"newAdminkey\" /></td><th><input type=\"submit\" name=\"addkey\" value=\"Create Key\" /></td></tr>
                                    <tr><th><label for=\"addRestaurant\">Add a Restaurant</label></th><td><input type=\"text\" name=\"newRest\" /></td><th><input type=\"submit\" name=\"addRest\" value=\"Add\" /></td></tr>
                                    <tr><th><label for=\"startElo\">Starting Elo</label></th><td><input type=\"number\" name=\"elo\" value=1500 /></td></tr>
                                </table>
                                </fieldset>
                                <tr><th>&nbsp;</th><td>";
                                echo(view_errors($keyerrors));
                        echo "</td></tr>";
                    echo "</fieldset>";
                    }
                ?>
                    
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

