<?php

/**
 * @file
 * @author  Mark Elo 
 * @version 1.0
 *
 * @section LICENSE 
 *
 * This program is the property of Mark Elo
 *
 * @section DESCRIPTION
 *
 *  User management Class
 *  LOGIN, LOGOU Etc !
 */

/**
 * \brief User Management
 */ 
class userMan extends dataBaseConnect {  

    private $rs;
	private $con; 
	private $userNum;
	private $fileId; 
	
	/**
	* Establish connection
	*/ 
    function __construct($userNum, $fileId){ 
		parent::__construct(); 	
		$this->con = new MySQLConnect($this->getHostName(), $this->getUserName(), $this->getPassword()); 
		$this->userNum = $userNum;
		$this->fileId = $fileId; 
	}   

	
	/** 
	* Create New User
	*/
	function userAdd($attribute){ 
	    if(sizeof($attribute)!=4) {
			print "Incorrect syntax - USERADD &#60USERNAME&#62, &#60PASSWORD&#62, &#60PASSWORD&#62, &#60EMAIL&#62<BR \>";
			exit();
		}
	    $exists=FALSE;
	    $strsql = "SELECT * FROM users WHERE userName = '".$attribute[0]."'";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		while($row = $rs->getRow()){
			print "User '".$attribute[0]."' exists, try a different one.<BR \>";
			$exists=TRUE;
			exit();
		}
		if($attribute[1] != $attribute[2] ) {
			print "Passwords don't match - USERADD &#60USERNAME&#62, &#60PASSWORD&#62, &#60PASSWORD&#62, &#60EMAIL&#62<BR \>";
			exit();
		}
		if( $attribute[3] == '' || !strpos($attribute[3], "@") ) {
			print "Must specify email correctly - USERADD &#60USERNAME&#62, &#60PASSWORD&#62, &#60PASSWORD&#62, &#60EMAIL&#62<BR \>";
			exit();
		}
		if(!$exists) {
		    if(!$attribute[1] || !$attribute[2]) {
				print "You must specify Password twice - USERADD &#60USERNAME&#62, &#60PASSWORD&#62, &#60PASSWORD&#62, &#60EMAIL&#62<BR \>";
				exit();
				}
			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
			$password = hash('sha256', $attribute[1].$salt);
			for($round = 0; $round < 65536; $round++) { 
				$password = hash('sha256', $password.$salt); 
				} 
			$level='user';
			$strsql = "INSERT INTO users SET userName='".$attribute[0]."', passWord='".$password."', eMail='".$attribute[3]."', level='".$level."', salt='".$salt."'";
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
			$strsql = "SELECT * FROM users WHERE userName = '".$attribute[0]."'";
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
			$row = $rs->getRow();
			print "USER: '".$row[1]."' added.<BR \>";
			// print "PASSWORD: '".$row[2]."' added.<BR \>";
			print "EMAIL: '".$row[3]."' added.<BR \><BR \>";
		}
    } 
	
	/** 
	* Change PW
	*/	
	function changePW($attribute){ 
	    if(sizeof($attribute)!=3) {
			print "Incorrect syntax - CHANGEPW &#60OLD-PASSWORD&#62, &#60NEW-PASSWORD&#62, &#60NEW-PASSWORD&#62<BR \>";
			exit();
		}
	    $password = $attribute[0];
	    $strsql = "SELECT * FROM users WHERE userName = '".$_SESSION['login_user']."'";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		while($row = $rs->getRow()){
		    $check_password = hash('sha256', $password . $row['salt']); 
            for($round = 0; $round < 65536; $round++) { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
                } 
		    if($check_password != $row['passWord']) {
				print "Incorrect old password.<BR \>";
			    exit();
			}
		}
		if($attribute[1] != $attribute[2] ) {
			print "Passwords don't match - CHANGEPW &#60OLD-PASSWORD&#62, &#60NEW-PASSWORD&#62, &#60NEW-PASSWORD&#62<BR \>";
			exit();
		}

		if(!$attribute[1] || !$attribute[2]) {
			print "You must specify Password twice - CHANGEPW &#60OLD-PASSWORD&#62, &#60NEW-PASSWORD&#62, &#60NEW-PASSWORD&#62<BR \>";
			exit();
			}
		$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
		$password = hash('sha256', $attribute[1].$salt);
		for($round = 0; $round < 65536; $round++) { 
			$password = hash('sha256', $password.$salt); 
			} 
		$level='user';
		$strsql = "UPDATE users SET passWord='".$password."', level='".$level."', salt='".$salt."' WHERE userName='".$_SESSION['login_user']."'";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
		$strsql = "SELECT * FROM users WHERE userName = '".$attribute[0]."'";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
		$row = $rs->getRow();
		print "USER: '".$_SESSION['login_user']."' Password changed!<BR \>";
    } 
	
	/** 
	* Login
	*/
	function logIn($attribute){ 
	    if( $attribute[0] && $attribute[1] && !$attribute[2] && !$attribute[3] && !$attribute[4] && !$attribute[5] && !$attribute[6] && !$attribute[7]) {
			$username = stripslashes($attribute[0]);
			$password = stripslashes($attribute[1]);
			$strsql = "SELECT * from users WHERE userName='".$username."'";
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
			$rows = $rs->getRow();
			$check_password = hash('sha256', $password . $rows['salt']); 
            for($round = 0; $round < 65536; $round++) { 
                $check_password = hash('sha256', $check_password . $rows['salt']); 
                } 
            //print $check_password;
            if($check_password === $rows['passWord']) 
                $login_ok = true; 
            else
				$login_ok = false; 

			if ($login_ok) { // Initializing Session
				$_SESSION['login_user']=$username; 
				$_SESSION['login_passWord']=$check_password; 
				$_SESSION['fileId']=0; 
				print $username." is now logged in<BR \>";
			} else {
				PRINT "Username or Password is invalid<br \>";
			}
		} else {
		print "Incorrect Syntax - &#60USERNAME&#62, &#60PASSWORD&#62<br \>";
			exit();
		}
    } 
	
	/** 
	* get user ID New User
	*/
	function getUserId($username, $password){ 
		$strsql = "SELECT id from users WHERE userName='".$username."' AND passWord='".$password."'";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
		$rows = $rs->getRow();
		return $rows[0];
    } 
	
	/** 
	* Close
	*/
	
	function closeDb() {
		$this->con = null;
	}
	
	
}

?>


				
