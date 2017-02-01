<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			td a {
				background-color:green; 
				display:block; 
				width:200px; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
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
					<legend><?php echo $_SESSION['selectedCourse'] ?> </legend>
					<table style="width:100%;">
						<tr>
							<td><a style="background-color:green;" href="index.php?value=1">i Get It</a></td>
							<td><a style="background-color:red;  " href="index.php?value=0">i Don't Get It</a></td>
						</tr>
					</table>
                    <form method="post" >

                        <p> <label for="feedback">Feedback:</label>    <input type="text" name="feed"></input> </p>
                         <p> <input type="submit" name="submit1"/>
                    </form>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

