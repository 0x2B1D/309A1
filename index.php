<?php
    require_once "model/GuessGame.php";
    require_once "model/PHPmodel.php";
    session_save_path("sess");
    session_start(); 
    ini_set('display_errors', 'On');
    $errors=array();
    $view="";       
    $dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 user=kathmuha password=10556");
    $users_query = pg_query($dbconn, "select * from appuser;");
    $model = new PHPmodel();
    
    /*while ($row = pg_fetch_row($users_query)){
        echo "first $row[0] $row[1]";
        echo "<br/>\n";
    }*/

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	switch($_SESSION['state']){
            case "login":
            // the view we display by default
            $view="login.php";    
            $users_query = pg_query($dbconn, "select * from appuser;"); 
            if(isset($_POST['login'])){
	   // perform operation, switching state and view if necessary
            while ($row = pg_fetch_row($users_query)){
                    // if registered go to profile
                    if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]"){
                        $_SESSION['username'] = $_REQUEST['user'];
                        $_SESSION['state']='profile';
                        $view="profile.php";
                        break;
                    } 
                    // TO-DO error checking                   
                }
                break;
            }
           // if(!empty($errors))break;
            if(isset($_POST['register'])){
                $_SESSION['state']='register';
                $view="register.php";
                break;
            }
            break;         
        // essentially the same as profile except no data filled out
        case 'register':
            $view="register.php";
    
            $fields = array('firstName', 'lastName', 'user', 'password', 'email');

            $error = false; //No errors yet
            
            /*
            foreach($fields AS $fieldname) { //Loop through each field
                if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
                    echo 'Field '.$fieldname.' missing!<br />'; //Display error with field
                    $error = true;
                }
            }

            if(!$error) { //Only create queries when no error occurs
                //prepare query and execute
                $query = pg_prepare($dbconn, "regis_query", "insert into appuser (username, password, firstname, lastname, role) values($1, $2, $3, $4, '')");
                $query = pg_execute($dbconn, "regis_query", array($_REQUEST['user'], $_REQUEST['password'], $_REQUEST['firstName'], $_REQUEST['lastName']));
                $_SESSION['state']="login";
                $view="login.php"; 
            }
            */
            $code = $model->registerUser($_POST['user'], $_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName']);
            if($code == 0){
                $_SESSION['username'] = $_POST['user'];
                $_SESSIION['state'] = "profile";
                $view= "profile.php"; 
            }
            break;
        case "profile":
            $view="profile.php";
            if(isset($_POST['Logout'])){
                session_destroy();
                 session_save_path("sess");
                 session_start(); 
                 $_SESSION['state']='login';
                 $view = 'login.php';
                 echo "hyaawww";
                 break;
            }
            
            break;
        
        case 'ins_create':
            $view="instructor_createclass.php";
            break;

        case 'stu_join':
            $view="student_joinclass.php";
            break;

	}
	require_once "view/view_lib.php";
	require_once "view/$view";
?>
