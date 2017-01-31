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
                        <li> <a href="">Class</a>
                        <li> <a href="">Profile</a>
                        <li> <a href="">Logout</a>
                        </ul>
		</nav>
		<main>
			<h1>Class</h1>
			<form method="post">
				<fieldset>
					<legend>Create Class</legend>
   					<p> <label for="class">class</label><input type="text" name="class"></input> </p>
   					<p> <label for="code">code</label><input type="text" name="code"></input> </p>
                                        <p> <input type="submit" name="submit1" />
				</fieldset>
			</form>
 			<form>
                                <fieldset>
                                        <legend>Current Classes</legend>
                                        <select>
                                            <option>csc356 ok a</option>
                                                <?php
                                                    echo "yo";
                                                    $courses=pg_query($_SESSION['db'], "select course from courses where insUser=$1", array($_SESSION['username']));
                                                    foreach ($courses as &$course){
                                                        ?>
                                                        <option value="<?php echo $course ?>"><?php echo $course ?></option>
                                                <?php } ?> 
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

