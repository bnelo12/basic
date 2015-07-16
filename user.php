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
			$level='user';
			$strsql = "INSERT INTO users SET userName='".$attribute[0]."', passWord='".$attribute[1]."', eMail='".$attribute[3]."', level='".$level."'";
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
			$strsql = "SELECT * FROM users WHERE userName = '".$attribute[0]."'";
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
			$row = $rs->getRow();
			print "USER: '".$row[1]."' added.<BR \>";
			print "PASSWORD: '".$row[2]."' added.<BR \>";
			print "EMAIL: '".$row[3]."' added.<BR \><BR \>";
		}
    } 
	
	/** 
	* Login
	*/
	function logIn($attribute){ 
	    if( $attribute[0] && $attribute[1] && !$attribute[2] && !$attribute[3] && !$attribute[4] && !$attribute[5] && !$attribute[6] && !$attribute[7]) {
			$username = stripslashes($attribute[0]);
			$password = stripslashes($attribute[1]);
			$strsql = "SELECT * from users WHERE passWord='".$password."' AND userName='".$username."'";
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
			$rows = $rs->getRow();
			if ($rows[passWord] && $rows[userName]) { // Initializing Session
				$_SESSION['login_user']=$username; 
				$_SESSION['login_passWord']=$password; 
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


				
