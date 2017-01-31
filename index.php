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
                     // helper function????
                     $_SESSION['username'] = $_REQUEST['user'];
                     $result=pg_query_params($dbconn, "SELECT * FROM appuser WHERE username=$1;", array($_SESSION['username']));
                     $_SESSION['firstname']=pg_fetch_result($result,0,2);
                     $_SESSION['lastname']=pg_fetch_result($result,0,3);
                     $_SESSION['email']=pg_fetch_result($result,0,4);
                    
                    // if registered go to profile 
                    if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]" && $row[5]==NULL){
                        // helper function????
                        $_SESSION['username'] = $_REQUEST['user'];
                        $result=pg_query_params($dbconn, "SELECT * FROM appuser WHERE username=$1;", array($_SESSION['username']));
                        $_SESSION['firstname']=pg_fetch_result($result,0,2);
                        $_SESSION['lastname']=pg_fetch_result($result,0,3);
                        $_SESSION['email']=pg_fetch_result($result,0,4);
                        $_SESSION['state']='profile';
                        $view="profile.php";
                        break;
                    }
                    
                    else if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]" && $row[5]=="ins"){
                        $_SESSION['state']='ins_create';
                        $view="instructor_createclass.php";
                        break;
                    }

                    else if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]" && $row[5]=="stu"){
                        $_SESSION['state']='stu_join';
                        $view="student_joinclass.php";
                        break;
                    }

                    // TO-DO error checking                   
                }
                break;
            }
           
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
            
            $code = $model->registerUser($_REQUEST['user'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['firstName'], $_REQUEST['lastName']);
            if($code == 0){
                
                // helper function????
                $_SESSION['username'] = $_REQUEST['user'];
                $result=pg_query_params($dbconn, "SELECT * FROM appuser WHERE username=$1;", array($_SESSION['username']));
                $_SESSION['firstname']=pg_fetch_result($result,0,2);
                $_SESSION['lastname']=pg_fetch_result($result,0,3);
                $_SESSION['email']=pg_fetch_result($result,0,4); 
                $_SESSION['state'] = 'profile';
                $view= "profile.php"; 
            }
            break;
        
        case 'profile':
            $view="profile.php";
            
            if (isset($_POST['submit1'])){
                $answer=$_POST['type'];
                if ($answer=="ins") {
                    pg_query_params("UPDATE appuser SET role='ins' WHERE username= $1;", array($_SESSION['username']));
                    $_SESSION['state']='ins_create';
                    $view="instructor_createclass.php";
                }

                else if ($answer=="stu") {
                    pg_query_params("UPDATE appuser SET role='stu' WHERE username= $1;", array($_SESSION['username']));
                    $_SESSION['state']='stu_join';
                    $view="student_joinclass.php";

                }
            }

          
            if(isset($_POST['Logout'])){
                session_destroy();
                session_save_path("sess");
                session_start(); 
                $_SESSION['state']='login';
                $view = "login.php";
                
                break;
            }
             
            break;
        
        case 'ins_create':
            $view="instructor_createclass.php";
            $result=pg_prepare($dbconn, "new_class", 'insert into courses (course, code, instructor, numOfStu, dontGet, get) values($1, $2, $3, 0, 0, 0);');
            $result=pg_execute($dbconn, "new_class", array($_REQUEST['class'], $_REQUEST['code'], $_SESSION['firstname'] . $_SESSION['lastname']));
            break;

        case 'stu_join':
            $view="student_joinclass.php";
            break;

	}
	require_once "view/view_lib.php";
	require_once "view/$view";
?>
