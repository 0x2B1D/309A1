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
			<form>
				<fieldset>
					<p> <label for="user">User</label>    <input type="text" name="user"></input> </p>
					<p> <label for="password">Password</label><input type="password" name="password"></input> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstName"></input> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastName"></input> </p>
					<p> <label for="email">email</label><input type="text" name="email"></input> </p>
					<p> <label for="email">type</label>
						<input type="radio" name="type">instructor</input> 
						<input type="radio" name="type">student</input> 
					</p>
					<p> <input type="submit" />
				</fieldset>
			</form>




        
</html>

