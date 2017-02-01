<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (instructor)</h1></header>
		<nav>
			<ul>
                        <li> <a href="index.php?class=1">Class</a>
                        <li> <a href="index.php?profile=1">Profile</a>
                        <li> <a href="index.php?logout=1">Logout</a>
                        </ul>
		</nav>
		<main>
			<h1>Class</h1>
			<form method="post">
				<fieldset>
					<legend>Create Class</legend>
   					<p> <label for="class">class</label><input type="text" pattern="[a-zA-Z0-9]+" name="class"></input> </p>
   					<p> <label for="code">code</label><input type="text" pattern="[a-zA-Z0-9]+" name="code"></input> </p>
                                        <p> <input type="submit" name="submit1" />
				</fieldset>
			</form>
 			<form method="post">
                                <fieldset>
                                        <legend>Current Classes</legend>
                                        <select name="courseOption">                                       
                                                <?php
                                                    $array=$_SESSION['model']->insClasses($_SESSION['username']);
                                                    foreach ($array as $val){
                                                        echo $val;
                                                    } 
                                                ?> 
                                        </select>
                                        <p> <label for="code">code</label><input type="text" pattern="[a-zA-Z0-9]+" name="code2"></input> </p>
                                        <p> <input type="submit" name="submit2" />
                                </fieldset>
                        </form>

		</main>
		<footer>
		</footer>
	</body>
</html>

