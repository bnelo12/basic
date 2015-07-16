<?php
/**
 * @file
 * @author  Mark Elo 
 * @version 1.1
 *
 * @section LICENSE  
 *
 * This program is the property of Mark Elo
 *
 * @section DESCRIPTION
 *
 *  calls page initialization and page creation
 
 */

 /** 
 * \brief Establish a reference to where BASIC is installed then call all files.
 */

// This is where BASIC resides 
 
$basicIsAt = $_SERVER['DOCUMENT_ROOT']."/basic/";

// Define Global Def Path 
if($globalsPath=="")
	$globalsPath = $basicIsAt."config/global/globalDefs.php";
	
// Load Global Definitions

try {
    include_once ($globalsPath);
	if(DEBUG)print "<br \>Globals Found, Included: ".$globalsPath."<br />";
} catch (Exception $e) {
    if(DEBUG)print 'SYSTEM FAIL... Caught exception: '.  $e->getMessage(). "\n";
}


//and we are off......

if(DEBUG)print "<br />Executing Main...<br />";

try {
    include_once (LOAD_FILENAME);
	if(DEBUG)print "Included: ". $basicIsAt . LOAD_FILENAME . "<br />";
	if(DEBUG)print "Searching... ". $basicIsAt . CONFIG_PATH . CONFIG_FILENAME . "<br />";
		$fileLoader = loader::getInstance(); 
	$filesRequired = $fileLoader->fileLocData($basicIsAt . CONFIG_PATH . CONFIG_FILENAME); //find required files location
	$fileLoader->includeFiles($filesRequired); // then include
	if(DEBUG)print "<br />Main Complete<br />";
} catch (Exception $e) {
    if(DEBUG)print 'SYSTEM FAIL... Caught exception: '.  $e->getMessage(). "\n";	
}
	
?>



