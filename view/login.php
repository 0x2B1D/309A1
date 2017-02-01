<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt</h1></header>
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
			<h1>Login</h1>
			<form method="post">
				<fieldset>
					<legend>Login</legend>
					<p> <label for="user">User</label>    <input type="text" pattern="[a-zA-Z0-9]+" name="user"></input> </p>
					<p> <label for="password">Password</label><input type="password" pattern="[a-zA-Z0-9]+" name="password"></input> </p>
                    <p> <input type="submit" name="login" value="Login" />
					<p> <input type="submit" name="register" value="Register"/>

				</fieldset>
			</form>
			
		</main>
		<footer>
		</footer>
	</body>
</html>

