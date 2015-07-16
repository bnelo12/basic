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
 *  calls page initialization and page creation
 
 */

/**
 * \loads all external file types
 */ 

class loader {  
 
    private static $_instance = null;

	private function loader() { } 

	private function  __clone() { } 

	public static function getInstance() {
		self::$_instance = new loader();
		return self::$_instance; 
	}
	
	public function fileLocData($fileLoc, $type=NULL) { 
		if( $this->fileExists($fileLoc) ) 
			$fileLoc = $this->xmlLoc($fileLoc);
		else
			if(DEBUG)print $fileLoc." Not Found";
		return $fileLoc;
	}
	
	private function fileExists($fileLoc) { 
		if ( file_exists ($fileLoc) )
			return TRUE;
	    else
			return FALSE;
	}
	
	/**
	 * pars XML
	 */
    private function xmlLoc($xmlLoc) { 
		$xml = simplexml_load_file($xmlLoc);
		$i=0;
		foreach($xml->children() as $child) { 
			foreach($child->children() as $element) {  
				switch ($element->getName()) { 
					case "name":
						$message .= "Found: ". $element . "<br />";
						$name = $element;
						break;
					case "type":
						$message .= "type: ". $element . "<br />";
						$type = $element;
						break;
					case "description":
						$message .= "Description: ". $element . "<br />";
						$description = $element;
						break;
					case "xmlPath": 
						if ( file_exists (CONFIG_PATH . $element) ) {
							$message .=  'Found: '.CONFIG_PATH . $element . "<br />";
							$xmlPath = $element;
						} else {
						    if(DEBUG)print CONFIG_PATH . $element." Not Found, exception thrown";
							throw new Exception('NOT Found: '.CONFIG_PATH.$element);}
						break;
					}
				}
			$allFileData[$i++] = array("name" => $name, "type" => $type, "description" => $description, "path" => $xmlPath);
			}
		if(DEBUG)print "<br \>System Definition Files Loaded:<br \>".$message."<br \>";
		return $allFileData;
		}
	
	/**
	 * main Libraries/fucntions
	 */
    public function mainPhpLibs($xmlPath) { 
	
		$libLoaderCounter = 0;

		$xml = simplexml_load_file($xmlPath);

		foreach($xml->children() as $child) {
			foreach($child->children() as $element) {
				switch ($element->getName()) {
					case "name":
						$message .= "Found: ". $element . "<br />";
						break;
					case "description":
						$message .= "Description: ". $element . "<br />";
						break;
					case "path":
						if ( file_exists (CONFIG_PATH . $element) ) {
							$message .=  'Include Once: '.CONFIG_PATH . $element . "<br />";
							include_once CONFIG_PATH . $element;
						} else {
							if(DEBUG)print CONFIG_PATH . $element." Not Found, exception thrown";
							throw new Exception('NOT Found: '.CONFIG_PATH.$element);}
						break;
					}
				}
			}

		if(DEBUG)print "<br \>PHP Scripts Loaded:<br \>".$message."<br \>";

		}
		
	public function includeFiles($filesRequired, $include_type=NULL) { 
	
		foreach($filesRequired as $fileToLoad) {
			if($fileToLoad[type]==PHP) {
				$includeThisFile = CONFIG_PATH . $fileToLoad[path];
				$this->mainPhpLibs($includeThisFile);
				}
			if($fileToLoad[type]==JS ) {
				$includeThisFile = CONFIG_PATH . $fileToLoad[path];
				$this->mainJsLibs($includeThisFile);
				}
			}
		}
		
		/**
	 * main Libraries/fucntions
	 */
    public function mainJsLibs($xmlPath) { 
	
		$libLoaderCounter = 0;

		$xml = simplexml_load_file($xmlPath);

		foreach($xml->children() as $child) {
			foreach($child->children() as $element) {
				switch ($element->getName()) {
					case "name":
						$message .= "Found: ". $element . "<br />";
						break;
					case "description":
						$message .= "Description: ". $element . "<br />";
						break;
					case "path":
					    print SYS_PATH . $element;
						if ( file_exists (SYS_PATH . $element) ) {
							$message .=  'Include: '.SYS_PATH . $element . "<br />";
							return SYS_PATH . $element;
						} else {
							if(DEBUG)print SYS_PATH . $element." Not Found, exception thrown";
							throw new Exception('NOT Found: '.SYS_PATH.$element);}
						break;
					}
				}
			}

		if(DEBUG)print "<br \>Java Scripts Loaded:<br \>".$message."<br \>";

		}
	
	 public function headerScriptLibs($xmlPath) { 
	
		$libLoaderCounter = 0;

		$xml = simplexml_load_file($xmlPath);

		foreach($xml->children() as $child) {
			foreach($child->children() as $element) {
				switch ($element->getName()) {
					case "name":
						$message .= "Found: ". $element . "<br />";
						break;
					case "description":
						$message .= "Description: ". $element . "<br />";
						break;
					case "phpPath":
						if ( file_exists (CONFIG_PATH . $element) ) {
							$message .=  'Include: '.CONFIG_PATH . $element . "<br />";
							//include_once CONFIG_PATH . $element;
						} else {
							throw new Exception('NOT Found: '.CONFIG_PATH.$element);}
						break;
					case "jsPath":
						if ( file_exists (CONFIG_PATH . $element) ) {
							$message .=  'Include: '.CONFIG_PATH . $element . "<br />";
							//include_once CONFIG_PATH . $element;
						} else {
							throw new Exception('NOT Found: '.CONFIG_PATH.$element);}
						break;
					case "cssPath":
						if ( file_exists (CONFIG_PATH . $element) ) {
							$message .=  'Include: '.CONFIG_PATH . $element . "<br />";
							//include_once CONFIG_PATH . $element;
						} else {
							throw new Exception('NOT Found: '.CONFIG_PATH.$element);}
						break;
					}
				}
			}

		if(DEBUG)print "Header Scripts:<br \>".$message."<br \>";

		}

	}



?>



