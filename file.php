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
 *  Main Execution Class
 *  Run the code !
 */

/**
 * \brief File manager, SAVE, LOAD, DIR etc
 */ 
class fileMan extends dataBaseConnect {  

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
	* get working file name
	*/
	function getFileNumnber($attribute){ 
	    $strsql = "SELECT fileNum FROM codelines WHERE userNum = ".$this->userNum." AND fileNum = ".$this->fileId." ORDER BY lineNum ASC";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		while($row = $rs->getRow()){
			print $row[lineNum]."<BR />";
		}
    } 

	/** 
	* save as a file name
	*/
	function saveFile($attributes){ 
	    $attributeElement = (explode(",",$attributes));
		if(!$attributeElement[0]) {
			$strsql = "UPDATE filesmanager SET timeDateStamp=NOW() WHERE id= ".$this->fileId;
			$rs2=$this->con->createResultSet($strsql, $this->getDataBaseName());
		} else {
			if(!$attributeElement[1])$attributeElement[1]="RWE";
			$strsql = "SELECT * FROM filesmanager WHERE userNum = ".$this->userNum." AND id = ".$this->fileId;
			$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
			$row = $rs->getRow();
			if($row[0]) { 
				print "FILE EXISTS IN MEMORY, DELETING OLD FILENAME<BR \>"; 
				$strsql = "UPDATE filesmanager SET fileName = '".$attributeElement[0]."' WHERE id= ".$this->fileId." AND userNum = ".$this->userNum;
				$rs2=$this->con->createResultSet($strsql, $this->getDataBaseName());
			} else {
				$strsql = "INSERT INTO filesmanager SET fileName = '".$attributeElement[0]."', permission = '".$attributeElement[1]."', userNum = ".$this->userNum;
				$rs2=$this->con->createResultSet($strsql, $this->getDataBaseName());
				$strsql = "SELECT id FROM filesmanager WHERE userNum = ".$this->userNum." AND fileName = '".$attributeElement[0]."'";
				$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
				$row = $rs->getRow();
				$fileNum = $row[0];
				$strsql = "SELECT * FROM codelines WHERE userNum = ".$this->userNum." AND fileNum = ".$this->fileId." ORDER BY lineNum ASC";
				$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
				while($row = $rs->getRow()){
					//print $row[1]." ".$row[2]." ".$row[3]." File Num: ".$row[5]."<BR>";
					$strsql = "UPDATE codelines SET fileNum = ".$fileNum." WHERE id=".$row[0]." AND userNum = ".$this->userNum;
					$rs2=$this->con->createResultSet($strsql, $this->getDataBaseName());
					$_SESSION['fileId'] = $fileNum;
				}
			}
		}
		// print "<BR>ThisFileID ".$this->fileId; print "<BR>FileID ".$_SESSION['fileId']; print "<BR>userNum ".$this->userNum;
		print "Saved!<br \>";
    } 
	
    /** 
	* List the contents of working Directory
	*/
	function listDir($attribute){ 
	    //$attributeElement = (explode(",",$attribute));
		//if(!$attributeElement[1])$attributeElement[1]="RWE";

		$strsql = "SELECT id FROM filesmanager WHERE userNum = ".$this->userNum;
	    $rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		$row = $rs->getRow();
		$fileNum = $row[0];
	    $strsql = "SELECT * FROM filesmanager WHERE userNum = ".$this->userNum." ORDER BY timeDateStamp ASC";
		$rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		while($row = $rs->getRow()){
		    // print $row[1]." ".$row[2]." ".$row[4]."<BR \>";
			print $row[4]." ".$row[1]."<BR \>";
		}
    } 
	
	/** 
	* Load a new file
	*/
	function loadFile($attribute){ 
	    //$attributeElement = (explode(",",$attribute));
		//if(!$attributeElement[1])$attributeElement[1]="RWE";
		$strsql = "SELECT id FROM filesmanager WHERE userNum = ".$this->userNum." AND fileName = '".$attribute."'";
	    $rs=$this->con->createResultSet($strsql, $this->getDataBaseName());
		$row = $rs->getRow();
		if($row) {
			print $attribute." loaded<br \>";
			$fileNum = $row[0];
			$_SESSION['fileId'] = $fileNum;
		} else
			print "Failed!<br \>";
    } 
	
	/** 
	* Close
	*/
	
	function closeDb() {
		$this->con = null;
	}
	
	
}

?>


				
