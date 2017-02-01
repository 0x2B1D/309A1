<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="refresh" content="200">
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			span {
				background-color:green; 
				display:block; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
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
			<form>
				<fieldset>
					<legend> <?php echo $_SESSION['selectedCourse'] ?> </legend>
                    
					<span style="background-color:green; width:<?php $result=$_SESSION['model']->votes($_SESSION['courseCode']); echo $result[0]/$result[2]*100;?>%;">i Get It</span>
					<span style="background-color:red;  width:<?php $result=$_SESSION['model']->votes($_SESSION['courseCode']); echo $result[1]/$result[2]*100;?>%;" >i Don't Get It</span>
                    
				</fieldset>
                <p> <label for="feedback">Feedback:</label><br></br>
                <?php
                    $result=pg_query_params($_SESSION['db'],"select feedback, time_stamp from feedback where course=$1;", array($_SESSION['courseCode']));
                    while($row=pg_fetch_row($result)){
                        echo $row[1]."<br>".$row[0]."<br>";
                    }
                ?> 
			</form>
		</main>
         
		<footer>
		</footer>
	</body>
</html>

