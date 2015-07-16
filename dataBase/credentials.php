<?php

/**
 * @file
 * @author  Mark Elo 
 * @version 1.0
 *
 * @section LICENSE 
 *
 * This program is the property of Webistree.
 *
 * @section DESCRIPTION
 *
 *  connect to dB with credentials
 */

/**
 * \brief Connection to the Database
 */

class dataBaseConnect { 
 
	private $hostname;
	private $dataBaseName;
	private $userName;
	private $password;	

	/**
	* Setup credentials
	*/
	function __construct(){ 
		$this->hostname=HOSTNAME;
		$this->dataBaseName=DBNAME;
		$this->userName=USERNAME;
		$this->password=PASSWORD;
    } 
	
	/**
	* get host name
	*/
	function getHostName(){ 
		return $this->hostname;
    }  
	
	/**
	* get dB name
	*/
	function getDataBaseName(){ 
		return $this->dataBaseName;
    }   
	
	/**
	* get user name
	*/
	function getUserName(){ 
		return $this->userName;
    }  

	/**
	* get pw
	*/
	function getPassword(){ 
		return $this->password;
    }   	
}

?>



