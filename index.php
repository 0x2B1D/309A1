<?php
    
    require_once "model/PHPmodel.php";
    session_save_path("sess");
    session_start();
    ini_set('display_errors', 'On');
    $errors=array();
    $view="";
    $dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 user=kathmuha password=10556");
    $_SESSION['db']=$dbconn;
    $users_query = pg_query($dbconn, "select * from appuser;");
    $model = new PHPmodel();
    $_SESSION["model"] = $model;

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
                                    
                while ($row = pg_fetch_row($users_query)){
                    $result=$_SESSION['model']->sessSet($_REQUEST['user']);
                    // if registered go to profile
                    if ($_REQUEST['user']=="$row[0]" && $_REQUEST['password']=="$row[1]" && $row[5]==NULL){
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
                   
                }
                break;
            }
           
            if(isset($_POST['register'])){
                $_SESSION['state']='register';
                $view="register.php";
                break;
            }
            break;

       
        case 'register':
            $view="register.php";
            if(isset($_POST['Logout'])){
              echo "helllo";
              logout();
            }
            if (isset($_POST['submit1'])){
                $fields = array('firstName', 'lastName', 'user', 'password', 'email');
    
                $error = false; //No errors yet
    
                $code = $model->registerUser($_REQUEST['user'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['firstName'], $_REQUEST['lastName']);
                if($code == 0){
    
                    $result=$_SESSION['model']->sessSet($_REQUEST['user']);
                    $_SESSION['state'] = 'profile';
                    $view= "profile.php";
                }
            }
            else if (isset($_POST['back'])){
                $_SESSION['state']='login';
                $view="login.php";
            }
            break;

        case 'profile':
            $view="profile.php";

            if (isset($_POST['submit1'])){
                $answer=$_POST['role'];
                if ($answer==NULL){
                    echo "Select a type please";
                }
                else if ($answer=="ins") {
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
              echo "helllo";
              logout();
            }

            break;


        case 'ins_create':

            $view="instructor_createclass.php";
           
            if (isset($_POST['submit1'])){

                $res=$model->newClass($_REQUEST['class'], $_REQUEST['code'], $_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['username']);
                // class does not exist
                if ($res==0){
                    $_SESSION['selectedCourse']=$_REQUEST['class'] . " " . $_SESSION['firstname'] . " " . $_SESSION['lastname'];
                    $_SESSION['state']='ins_current';
                    $view="instructor_currentclass.php";
                    break;
                }
                else{echo "Class already exists";}
               
            }
            else if (isset($_POST['submit2'])){
                $selectedCourse = $_POST['courseOption'];
                $courseCode=explode(" ", $selectedCourse);
                $courseCode=$courseCode[0];
                $_SESSION['courseCode']=$courseCode;
                $code_query=pg_query_params($dbconn,"select code from courses where course=$1;", array($courseCode));
                $code=pg_fetch_result($code_query,0,0);
                
                if ($code==$_REQUEST['code2']){
                    $_SESSION['selectedCourse']=$selectedCourse;
                    $_SESSION['state']='ins_current';
                    $view="instructor_currentclass.php";
                    break;
                }
                else{
                    echo "wrong code";
                }
                
                       
            }
            break;

        case 'ins_current':
           $classEscape = $_GET['class'];
           if($classEscape){
               //navigateClass('stu');
                $view = 'instructor_createclass.php';
                $_SESSION['state'] = 'stu_join';
               break;               
           }
            $view="instructor_currentclass.php";
            break;

        case 'stu_join':
           $view="student_joinclass.php";
           $classEscape = $_GET['class'];
           if($classEscape){
               //navigateClass('stu');
                $view = 'student_joinclass.php';
                $_SESSION['state'] = 'stu_join';
               break;               
           }
            if($_SESSION['model']->coursePassword($_REQUEST['drop'], $_REQUEST['code'])){
                $view = 'student_currentclass.php';
                $_SESSION['state'] = 'student_getit';
                $_SESSION['courseCode'] = $_REQUEST['code'];
               
            }
            break;
        
        case 'student_getit':
           $classEscape = $_GET['class'];
           if($classEscape){
               //navigateClass('stu');
                $view = 'student_joinclass.php';
                $_SESSION['state'] = 'stu_join';
               break;               
           }
           $view = "student_currentclass.php";
           $va =$_GET['value'];
           $_SESSION['model']->logVote($_SESSION['username'], $_SESSION['courseCode'], $va);
           

          

    }
    
    function logout(){
      global $view;
      global $_SESSION;
      session_destroy();
      session_save_path("sess");
      session_start();
      $_SESSION['state']='login';
      $view = 'login.php';
         
           
    }
    require_once "view/view_lib.php";
    require_once "view/$view";

?>
                           
                                                                                                
