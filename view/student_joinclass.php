<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (student)</h1></header>
		<nav>
			<ul>
                        <li> <a href="index.php?class=1">Class</a>
                        <li> <a href="index.php?profile=1">Profile</a>
                        <li> <a href="index.php?logout=1">Logout</a>
                        </ul>
		</nav>
		<main>
			<h1>Class</h1>
			<form method="post" action="index.php">
				<fieldset>
					<legend>Current Classes</legend>
					<select name="drop">
                         <?php
                            $array=$_SESSION['model']->arrayClasses();
                                foreach ($array as $val){
                                    echo $val;
                                }
                         ?>
				    </select>
   					<p> <label for="code">code</label><input type="text" name="code"></input> </p>
                                        <p> <input type="submit" />
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

