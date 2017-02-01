<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
$_REQUEST['user']=!empty($_REQUEST['user']) ? $_REQUEST['user'] : '';
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$_REQUEST['firstName']=!empty($_REQUEST['firstName']) ? $_REQUEST['firstName'] : '';
$_REQUEST['lastName']=!empty($_REQUEST['lastName']) ? $_REQUEST['lastName'] : '';
$_REQUEST['email']=!empty($_REQUEST['email']) ? $_REQUEST['email'] : '';
?>
<!DOCTYPE html>
<html lang="en">

			<h1>Register</h1>
			<form method="post" action="index.php">
				<fieldset>
                                    <p> <label for="user">User</label>    <input type="text" pattern="[a-zA-Z0-9]+" name="user"></input> </p>
					<p> <label for="password">Password</label><input type="password" pattern="[a-zA-Z0-9]+" name="password"></input> </p>
					<p> <label for="firstName">First Name</label><input type="text" pattern="[a-zA-Z0-9]+" name="firstName"></input> </p>
					<p> <label for="lastName">Last Name</label><input type="text" pattern="[a-zA-Z0-9]+" name="lastName"></input> </p>
					<p> <label for="email">email</label><input type="email" name="email"></input> </p>
						 
					</p>
					<p> <input type="submit" name="submit1" />
                    <p> <input type="submit" name="back" value="Back"/>
				</fieldset>
			</form>




        
</html>

