<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
$_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$_REQUEST['first_name']=!empty($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
$_REQUEST['last_name']=!empty($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';
$_REQUEST['email']=!empty($_REQUEST['email']) ? $_REQUEST['email'] : '';
$_REQUEST['acctype']=!empty($_REQUEST['acctype']) ? $_REQUEST['acctype'] : '';
$_REQUEST['adminkey']=!empty($_REQUEST['adminkey']) ? $_REQUEST['adminkey'] : '';
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
		<!--
		<nav>
			<ul>
			<li> <a href="">Class</a>
			<li> <a href="">Profile</a>
			<li> <a href="">Logout</a>
			</ul>
		</nav>
		-->
		<main>
			<h1>Register</h1>
			<form method="post">
				<fieldset>
				<legend>Register</legend>
				<table>
					<!-- Trick below to re-fill the user form field -->
					<tr><th><label for="username">Username</label></th><td><input type="text" name="username" value="<?php echo($_REQUEST['username']); ?>" required/></td></tr>
					<tr><th><label for="password">Password</label></th><td> <input type="password" name="password" required/></td></tr>
					<tr><th><label for="first_name">First Name</label></th><td><input type="text" name="first_name" value="<?php echo($_REQUEST['first_name']); ?>" /></td></tr>
					<tr><th><label for="last_name">Last Name</label></th><td><input type="text" name="last_name" value="<?php echo($_REQUEST['last_name']); ?>" /></td></tr>
					<tr><th><label for="email">Email</label></th><td><input type="email" name="email" value="<?php echo($_REQUEST['email']); ?>" /></td></tr>
					<tr><th><label for="acctype">Registering as a</label></th><td>                        
                        <input type="radio" name="acctype" value="voter" checked="checked" <?php echo ($_REQUEST['acctype']=="voter")?"checked":'' ?>>Voter</input>
                        <input type="radio" name="acctype" value="admin" <?php echo ($_REQUEST['acctype']=="admin")?"checked":'' ?>>Admin</input>
                    </td></tr>
					<tr><th><label for="upgrade">Admin key</label></th><td><input type="password" name="adminkey" /></td></tr>
                    <tr><th><input type="submit" name="register" value="Register" /></td></tr>
					<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
				</table>
			</form>
			<a href="index.php?page=login">Back</a>
		</main>
		<footer>
		</footer>
	</body>
</html>

