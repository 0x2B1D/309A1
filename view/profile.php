<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt</h1></header>
		<nav>
                    <form method="post" action="index.php">
			<ul>
                        <li> <input type="submit" name="Class" value ="Class"></a>
                        <li> <input type="submit" name="Profile" value = "Profile">
                        <li> <input type="submit" name="Logout" value = "Logout">
                        </ul>
                    </form>
		</nav>
		<main>
			<h1>Profile</h1>
			<form>
				<fieldset>
					<legend>Edit Profile</legend>
					<p> <label for="user">User</label>    <input type="text" name="user"></input> </p>
					<p> <label for="password">Password</label><input type="password" name="password"></input> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstName"></input> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastName"></input> </p>
					<p> <label for="email">email</label><input type="text" name="email"></input> </p>
					<p> <label for="type">type</label>
						<input type="radio" name="type">instructor</input> 
						<input type="radio" name="type">student</input> 
					</p>
					<p> <input type="submit" />
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

