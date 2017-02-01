<?php


class PHPmodel{
    
    private $dbconn;
    private $VALID = 0;
    
    
    private $USERNAME_NO_EXIST = 1;
    private $WRONG_PASSWORD = 2;
   
    
    private $USERNAME_ALREADY_EXIST = 1;
    private $EMAIL_ALREADY_EXIST = 2;
    
    
    public function _construct(){
        $this->dbconn =  
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
        $this->USERNAME_NO_EXIST = 1;
        $this->WRONG_PASSWORD = 2;
        $this->VALID = 0;
    }
    
    public function checkUsernameEmail($username,$email){
        /*
         * CHECKS TO SEE IF THE USERNAME OR EMAIL IS ALREADY TAKEN
         * returns 0 if valid
         *         1 if username already exists
         *         2 if email already exists
         * 
         */
       $this->dbconn =  
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
        pg_prepare($this->dbconn, "first", 'SELECT * FROM appuser WHERE username = $1 ;');
        $result = pg_execute($this->dbconn,"first",array($username));
        if(!(pg_num_rows($result) == 0)){
            return $this->USERNAME_ALREADY_EXIST;
        }
        pg_prepare($this->dbconn, "another", 'SELECT * FROM appuser WHERE email = $1 ;');
        $result = pg_execute($this->dbconn,"another",array($email));
        if(!(pg_num_rows($result) == 0)){
            return $this->EMAIL_ALREADY_EXIST;
        }
        return $this->VALID;
        
    }
    
    public function validCombination($username,$password){
        /*
         * returns 1 if username doesn't exist
         *         2 if incorrect password
         *         0 on successs
         */
        $this->dbconn =  
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");

        
        $result = pg_prepare($this->dbconn, "third", 'SELECT * FROM appuser WHERE username = $1 ;');
        $result = pg_execute($this->dbconn,"third",array($username));
        if((pg_num_rows($result) == 0)){
            return $this->USERNAME_NO_EXIST;
        }
        $result = pg_prepare($this->dbconn, "fourth", 'SELECT * FROM appuser WHERE username = $1 AND password = $2;');
        $result = pg_execute($this->dbconn,"fourth",array($username,$password));
        if((pg_num_rows($result) == 0)){
            return $this->WRONG_PASSWORD;
        }
        return $this->VALID;
    }
    
    
    public function registerUser($username,$email, $password, $firstname, $lastname){
        /*
         * Adds user into the appuser table
         * returns 0 if valid
         *         1 if username already exists
         *         2 if email already exists
         *         3 if empty
        */
        $this->dbconn =  
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
       
        $fields = array('firstName', 'lastName', 'user', 'password', 'email');

        $error = false; //No errors yet

        
        foreach($fields AS $fieldname) { //Loop through each field
            if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
                echo 'Field '.$fieldname.' missing!<br />'; //Display error with field
                $error = true;
                return 3;
            }
        }


        if(($v = $this->checkUsernameEmail($username,$email)) != $this->VALID){
            return $v;
        }

        pg_prepare($this->dbconn,"new_entry",'INSERT into appuser(username,password,firstname,lastname,email,role) values($1,$2,$3,$4,$5,$6);');
        pg_execute($this->dbconn,"new_entry",array($username,$password, $firstname, $lastname, $email,NULL ));
        return $v;
    } 
    
    

    public function updateGet($coursecode, $getValue){
    	$this->dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 ", "user=kathmuha password=10556");
	pg_prepare($this->dbconn,"add",'update courses set $1=$1+1 where course=$2');
	if($getValue){
		pg_execute($this->dbconn,"add",array('get',$coursecode));
	}else{
		pg_execute($this->dbconn,"add",array('dontGet',$coursecode));

	}
    }	

  public function coursePassword($course, $code){
	/*

	returns 0 if no match
	        1 if match


	*/
       $this->dbconn =  
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
	pg_prepare($this->dbconn,'course','select * from courses where course = $1 and code = $2;');
	$result = pg_execute($this->dbconn,'course',array($course,$code));
	if (pg_num_rows($result) == 0){
		return 0;
	}
	return 1;

  } 
  
      public function logVote($username,$course,$vote){
          
       $this->dbconn =  
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
       $t = time();
       pg_prepare($this->dbconn,"log",'INSERT into students(username, course, vote, time_stamp) values($1,$2,$3,$4);');
       $dateGo = date("Y-m-d",$t);
       pg_execute($this->dbconn,'log',array($username,$course,$vote,$dateGo));
       
       
	
   }
   public  function arrayClasses(){

    $array  = array();
	$this->dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 user=kathmuha password=10556");
	$result = pg_query($this->dbconn, 'select course,instructor from courses;');       
	while ($row = pg_fetch_row($result)) {
        array_push($array,'<option value="'.$row[0].'">'.$row[0].' '.$row[1].'</option>');
        
    }
	return $array;
   }
    
    public function insClasses($username){
        $this->dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 user=kathmuha password=10556");
        $courses=pg_query_params($this->dbconn, "select course,instructor from courses where insUser=$1", array($username));
        $array=array();
        
        while ($row = pg_fetch_row($courses)){
            array_push($array,'<option value="'.$row[0].' '.$row[1]. '">'.$row[0].' '.$row[1].'</option>');
        }
        return $array;
    }
    public function newClass($classname, $code, $fname, $lname, $user){
        
        $this->dbconn =
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");    
        // check if course exists
        $exists=false;
        $course_query=pg_query($this->dbconn, "select course from courses;");
        while ($row = pg_fetch_row($course_query)){
            if ($row[0]==$classname){
                $exists=true;
                break;
            }
        }
        
        // new class
        if(!$exists){
            $result=pg_prepare($this->dbconn, "new_class", 'insert into courses (course, code, instructor, insUser, numOfStu, dontGet, get) values($1, $2, $3, $4, 0, 0, 0);');
            $result=pg_execute($this->dbconn, "new_class", array($classname, $code, $fname ." ". $lname, $user));
            return 0;
        }
        return 1;
    }

    public function votes($classname){
        $result=array();
        $this->dbconn =
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
        $votes_query=pg_query_params($this->dbconn, "select get,dontget from courses where course=$1;", array($classname));
        array_push($result,pg_fetch_result($votes_query,0,0));
        array_push($result,pg_fetch_result($votes_query,0,1));
        array_push($result,pg_fetch_result($votes_query,0,0)+pg_fetch_result($votes_query,0,1));
        return $result;
    }

    public function roleDirection($username){
        $this->dbconn =
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
        $role_query=pg_query_params($this->dbconn, "select role from appuser where username=$1;", array($username));
        $role=pg_fetch_result($role_query,0,0);
        if ($role=='ins'){
            return 'ins_create';
        }
        return 'stu_join';
        
    }
    
    public function sessSet($user){
        $this->dbconn =
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
        $_SESSION['username'] = $user;          
        $result=pg_query_params($this->dbconn, "SELECT * FROM appuser WHERE username=$1;", array($user));
        $_SESSION['firstname']=pg_fetch_result($result,0,2);
        $_SESSION['lastname']=pg_fetch_result($result,0,3);
        $_SESSION['email']=pg_fetch_result($result,0,4);
        $_SESSION['role']=pg_fetch_result($result,0,5);
    }
}

?>

