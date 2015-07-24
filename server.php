<?php /*
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
 *  Main Lexar
 */
 /** 
 * \brief Main parsing function, converts commands and attributes to actions
 */

//LOAD Files required 
//$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$path = "config/control/main.php";

session_start();

try {
    include_once($serverRoot.$path); 
	if(DEBUG)print "Main executed, starting Lexer Server<br />";
} catch (Exception $e) {
    if(DEBUG)print 'Caught exception: '.  $e->getMessage(). "\n";
}

$userNum=0;
$fileId=0;

$lineNum=10;
$line="PRINT";


if (!empty($_POST['input']))
{
	$st = $_POST['input'];
	
	if($st=='HELP' || $st=='help' || $st=='?') {
	    include('help.php');
		}

	$line = (explode(" ",$st));
	$userMan = new userMan ( $userNum, $fileId );
	$userNum = $userMan->getUserId($_SESSION['login_user'], $_SESSION['login_passWord']);
	$userMan->closeDb();
	
	$fileId = $_SESSION['fileId'];

	// print "File Session:".$_SESSION['fileId']."<br>";

	if(is_numeric($line[0]) && $_SESSION['login_user']) {
		$lineNum = (int) $line[0];
		$cmd = $line[1];
		unset($line[0]);
		unset($line[1]);
		$attribute = implode(" ", $line);
		$changeInsertLine = new changeInsertLine ( $userNum, $fileId );
		$changeInsertLine->setLine($lineNum, strtoupper($cmd), $attribute);
		$changeInsertLine->closeDb();
		exit();
	} else {
		$cmd = $line[0];
		$cmd = stripslashes($cmd); //Stop script insertion
		unset($line[0]);
		$cmd = strtoupper($cmd);
		$attribute = implode(" ", $line);
	}
	
	if($_SESSION['login_user'] && $_SESSION['login_passWord']) {
	
		switch($cmd)
		{
			case 'LIST':
				$changeInsertLine = new changeInsertLine ( $userNum, $fileId );
				$changeInsertLine->getList();
				$changeInsertLine->closeDb();
				break;
			case 'RENUMBER':
				if($attribute=="") $attribute=0;
				$changeInsertLine = new changeInsertLine ( $userNum, $fileId );
				$changeInsertLine->setRenumber($attribute);
				$changeInsertLine->closeDb();
				break;
			case 'SAVE':
				$saveFile = new fileMan( $userNum, $fileId );
				$saveFile->saveFile($attribute);
				$saveFile->closeDb();
				break;
			case 'DIR':
				$dirFiles = new fileMan( $userNum, $fileId );
				$dirFiles->listDir($attribute);
				$dirFiles->closeDb();
				break;
			case 'LOAD':
				$loadFile = new fileMan( $userNum, $fileId );
				$loadFile->loadFile($attribute);
				$loadFile->closeDb();
				break;
			case 'DELETE':
				$changeInsertLine = new changeInsertLine ( $userNum, $fileId );
				$changeInsertLine->deleteLine($attribute);
				$changeInsertLine->closeDb();
				break;
			case 'NEW':
				$changeInsertLine = new changeInsertLine ( $userNum, $fileId );
				if($_SESSION['fileId'] == 0)
					$changeInsertLine->deleteLines();
				else
					$_SESSION['fileId'] = 0;
				$changeInsertLine->closeDb();
				break;
			case 'RUN':
				$runCode= new executeCode ( $userNum, $fileId );
				$runCode->run();
				$runCode->closeDb();
				break;
			case 'INPUT':
				processInput($attribute);
				break;
			case 'CLS':
				print '<a href="index.php" style="color: white">Click Here</a>';
				break;
			case 'WHOAMI':
				print "You are ".$_SESSION['login_user']."<br \>";
				break;	
			case 'CHANGEPW':
				$attribute = str_replace(" ", "", $attribute);
				$attributes = explode(",", $attribute);
				$userMan = new userMan ( $userNum, $fileId );
				$userMan->changePW($attributes);
				$userMan->closeDb();
				break;	
			case 'LOGOUT':
				session_destroy();
				print "Bye...<BR \>";
				break;	
			case 'HELP' || '?':
				break;
			default:
				print "Syntax Error<br />";
		}
	} else {
		switch($cmd)
		{
			case 'USERADD':
				$attribute = str_replace(" ", "", $attribute);
				$attributes = explode(",", $attribute);
				$userMan = new userMan ( $userNum, $fileId );
				$userMan->userAdd($attributes);
				$userMan->closeDb();
				break;		
			case 'LOGIN':
				$attribute = str_replace(" ", "", $attribute);
				$attributes = explode(",", $attribute);
				$logIn = new userMan ( $userNum, $fileId );
				$logIn->logIn($attributes);
				$logIn->closeDb();
				break;	
			case 'HELP' || '?':
				break;
			default:
				print "Syntax Error<br \>";
		}
	}
	//print "USER --> ".$userNum." <--<BR \>";
}
else
{
	//print 'i need some input';
}


function processInput($attribute) {

	include('math.php');
	$calc = new math();

	$attribute = preg_replace('/;(?!(([^"]*"){2})*[^"]*$)/', "!_DUMMY_CHAR_!", $attribute);
	$attribute = preg_replace('/$(?!(([^"]*"){2})*[^"]*$)/', "!_DUMMY_CHAR2_!", $attribute);
	
	$attributeElement = (explode(";",$attribute));
	$numElements = sizeof($attributeElement);

	for($i=0; $i<$numElements; $i++) { 
	    //print $attributeElement[$i]."<br>";
		if(preg_match('/"/', $attributeElement[$i])) {
		    $attributeElement[$i] = preg_replace('/!_DUMMY_CHAR_!/', ";", $attributeElement[$i]);
			$attributeElement[$i] = preg_replace('/!_DUMMY_CHAR2_!/', "$", $attributeElement[$i]);
			print  preg_replace('/"/', "", $attributeElement[$i]);
		} /* else {
			print $calc->getValueOfFunction($attributeElement[$i]); } */
			
		if(preg_match('/$/', $attributeElement[$i])) {
		    ?> <script>$('#terminal_container').terminal('input.php', {function_type : "input"});</script><?php
		}
	}
	

		
} 
?>

