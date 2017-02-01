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
              <ul>
                        <li> <a href="<?php $role=$_SESSION['model']->roleDirection($_SESSION['username']); $_SESSION['state']='stu_join'?>">Class</a>
                        <li> <a href="<?php $_SESSION['state']='profile'?>">Profile</a>
                        <li> <a href="">Logout</a>
                        </ul>

       </nav>
		<main>
			<h1>Profile</h1>
			<form method="post">
				<fieldset>
					<legend>Edit Profile</legend>
					<p> <label for="user">User</label>    <input type="text" name="user" value=<?php echo $_SESSION['username'];?>></input> </p>
					<p> <label for="password">Password</label><input type="password" name="password"></input> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstName" value= <?php echo $_SESSION['firstname'];?>></input> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastName" value= <?php echo $_SESSION['lastname'];?>></input> </p>
					<p> <label for="email">email</label><input type="text" name="email" value= <?php echo $_SESSION['email'];?>></input> </p>
					<p> <label for="type">type</label>
						<input type="radio" name="type" value='ins'>instructor</input> 
						<input type="radio" name="type" value='stu'>student</input> 
					</p>
					<p> <input type="submit" name="submit1"/>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

