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
 *  Code Management
 *  Insert, Delete or Change Lines
 */


/**
 * \brief changes/updates lines of code in DB
 */ 
class changeInsertLine extends dataBaseConnect {  

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
	* List program.
	*/
	function getList(){ 
		$strsql = "SELECT * FROM codelines WHERE userNum = ".$this->userNum." AND fileNum = ".$this->fileId." ORDER BY lineNum ASC";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		while($row = $rs->getRow()){
			print $row['lineNum']." ";
			print $row['lineCmd']." ";
			$lineAttribute = str_replace("DUMMY_FORWARD_SLASH", "/", $row['lineAttribute']);
		    $lineAttribute = str_replace("DUMMY_BACK_SLASH", "\\", $lineAttribute);
			print $lineAttribute."<br \>"; 
		}
		return 1;
    } 
	
	/** 
	* renumber program.
	*/
	function setRenumber( $increment ){ 
		if($increment==0) $increment=10;
		$strsql = "SELECT * FROM codelines WHERE userNum = ".$this->userNum." AND fileNum = ".$this->fileId." ORDER BY lineNum ASC";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		while($row = $rs->getRow()){
			$strsql = "UPDATE codelines SET lineTemp =".$row['lineNum']." WHERE lineNum=".$row['lineNum']." AND userNum = ".$this->userNum." AND fileNum = ".$this->fileId;
		    $rs2=$this->con->createResultSet($strsql, $this->getDataBaseName());
		} 
		$strsql = "SELECT * FROM codelines WHERE userNum = ".$this->userNum." AND fileNum = ".$this->fileId." ORDER BY lineTemp ASC";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		$newLineNumber = $increment;
		while($row = $rs->getRow()){
			$strsql = "UPDATE codelines SET lineNum =".$newLineNumber." WHERE lineTemp=".$row['lineNum']." AND userNum = ".$this->userNum." AND fileNum = ".$this->fileId;
		    $rs2=$this->con->createResultSet($strsql, $this->getDataBaseName());
			$newLineNumber = $newLineNumber + $increment;
		} 
		return 1;
    } 
	
    /*
	* Input a line of code into DB
	*/
	function setLine($lineNum, $lineCmd, $lineAttribute){
		$strsql = "SELECT COUNT(*) FROM codelines WHERE lineNum = ".$lineNum." AND userNum = ".$this->userNum." AND fileNum = ".$this->fileId;
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		$row = $rs->getRow();
		if($row[0]) {
			print "Line ".$lineNum." exists <br \>";
		} else { 
        $lineAttribute = str_replace("/", "DUMMY_FORWARD_SLASH", $lineAttribute);
		$lineAttribute = str_replace("\\", "DUMMY_BACK_SLASH", $lineAttribute);
		$strsql = "INSERT INTO codelines SET lineTemp=0, lineNum=".$lineNum.", lineCmd='".$lineCmd."', lineAttribute='".$lineAttribute."', userNum = ".$this->userNum.", fileNum = ".$this->fileId;
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName()); 
		}
		return 1;
    } 
	
	/*
	* Delete Line No.
	*/
	function deleteLine($lineNum){ 
	    if(!$lineNum) {
			print "Please specifiy a line number<br \>";
		} else {
			$strsql = "SELECT COUNT(*) FROM codelines WHERE lineNum = ".$lineNum." AND userNum = ".$this->userNum." AND fileNum = ".$this->fileId;
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
			$row = $rs->getRow();
			if($row[0]) {
				$strsql = "DELETE FROM codelines WHERE lineNum = ".$lineNum." AND userNum = ".$this->userNum." AND fileNum = ".$this->fileId;
				$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
				print "Line ".$lineNum." Deleted!<br \>";
			    } else {
				print "No such line number!<br \>"; }
			}
		$this->con = null; 
		return 1;
    } 
	
	/*
	* Delete Lines
	*/
	function deleteLines(){ 
		$strsql = "DELETE FROM codelines WHERE userNum = ".$this->userNum." AND fileNum = ".$this->fileId;
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		$this->con = null; 
		return 1;
    } 
	
	/** 
	* Close
	*/
	function closeDb() {
		$this->con = null;
	}
}

?>



