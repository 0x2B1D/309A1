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
        pg_prepare($this->dbconn, "my_query", 'SELECT * FROM appuser WHERE username = $1');
        $result = pg_execute($this->dbconn,"my_query",array($username));
        echo $result;
        if(!empty($result)){
            return $this->USERNAME_ALREADY_EXIST;
        }
        pg_prepare($this->dbconn, "my_query", 'SELECT * FROM appuser WHERE email = $1');
        $result = pg_execute($this->dbconn,"my_query",array($email));
        if(!empty($result)){
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
        $result = pg_prepare($this->dbconn, "my_query", 'SELECT * FROM appuser WHERE username = $1');
        $result = pg_execute($this->dbconn,"my_query",array($username));
        if(empty($result)){
            return $this->USERNAME_NO_EXIST;
        }
        $result = pg_prepare($this->dbconn, "my_query", 'SELECT * FROM appuser WHERE username = $1 AND password = $2');
        $result = pg_execute($this->dbconn,"my_query",array($username,$password));
        if(empty($result)){
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
         */
        $this->dbconn =  
                pg_connect
                ("host=mcsdb.utm.utoronto.ca dbname=kathmuha_309 "
                        . "user=kathmuha password=10556");
        if(($v = $this->checkUsernameEmail($username,$email)) != $this->VALID){
            echo $v;
            return $v;
        }
        pg_prepare($this->dbconn,"new_entry",'INSERT into appuser values($1,$2,$3,$4,$5,$6)');
        pg_execute($this->dbconn,"new_entry",array($username,$password, $firstname, $lastname, $email,NULL ));     
        return $v; 
    } 
    
    
    
    
    
}
/* 
we will use this class  for all the database manipulations,checking
 */

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function new1(){
  $cool='cool';
}
?>

