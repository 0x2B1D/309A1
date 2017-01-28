<?php
	require_once "model/GuessGame.php";

	session_save_path("sess");
	session_start(); 

	ini_set('display_errors', 'On');

	$errors=array();
	$view="";
    
    
    $dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 user=kathmuha password=10556");
    $users_query = pg_query($dbconn, "select * from appuser;");
    while ($row = pg_fetch_row($users_query)){
        echo "first $row[0] $row[1]";
        echo "<br/>\n";
    }

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	switch($_SESSION['state']){
		case "login":
			// the view we display by default
			$view="login.php";

			// check if submit or not
/*			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
                
				break;
			}


			// validate and set errors
			if(empty($_REQUEST['user'])){
				$errors[]='user is required';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='password is required';
			}
			if(!empty($errors))break;
*/
            $users_query = pg_query($dbconn, "select * from appuser;"); 
            if(isset($_POST['login'])){
			    // perform operation, switching state and view if necessary
                while ($row = pg_fetch_row($users_query)){
                    echo "row[0]: $row[0] row[1]: $row[1]";
                
                    // if in the database but no profile
                    if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]" && $row[2]=="N"){
                        $_SESSION['state']='profile';
                        $view="profile.php";
                        break;
                    }
        
                    else if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]" && $row[2]=="Y" && $row[3]=="ins"){
                        $_SESSION['state']='ins_create';
                        $view="instructor_createclass.php";
                        break;
                    }

                    else if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]" && $row[2]=="Y" && $row[3]=="stu"){
                        $_SESSION['state']='stu_join';
                        $view="student_joinclass.php";
                        break;
                    }
                    else{   
                        // validate and set errors
                        if(empty($_REQUEST['user'])){
                            $errors[]='user is required';
                        }
                        if(empty($_REQUEST['password'])){
                            $errors[]='password is required';
                        }
                        else
                            $errors[]='Invalid';
                        if(!empty($errors))break;
                        
                    }
                    
                }
                break;
            }
            
            if(!empty($errors))break;

             if(isset($_POST['register'])){
                echo "register";
                break;
            }
			/*if($_REQUEST['user']=="arnold" && $_REQUEST['password']=="something"){
				$_SESSION['GuessGame']=new GuessGame();
				$_SESSION['state']='play';
				$view="play.php";
			} else {
				$errors[]="invalid login";
			}*/
			break;
           

        case "profile":
            $view="profile.php";
           // break;
        
        case 'ins_create':
            $view="instructor_createclass.php";
            break;

        case 'stu_join':
            $view="student_joinclass.php";
            break;

		case "play":
			// the view we display by default
			$view="play.php";

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"){
				break;
			}

			// validate and set errors
			if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
			if($_SESSION["GuessGame"]->getState()=="correct"){
				$_SESSION['state']="won";
				$view="won.php";
			}
			$_REQUEST['guess']="";

			break;

		case "won":
			// the view we display by default
			$view="play.php";

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="start again"){
				$errors[]="Invalid request";
				$view="won.php";
			}

			// validate and set errors
			if(!empty($errors))break;


			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]=new GuessGame();
			$_SESSION['state']="play";
			$view="play.php";

			break;
	}
	require_once "view/view_lib.php";
	require_once "view/$view";
?>
