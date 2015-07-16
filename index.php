<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	  	  
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>BASIC - PHP Server BASIC</title>
<style type="text/css">
body {
	margin: 0;
}
</style>
</head>
<body>

<div id="terminal_container"></div>

<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>-->
<script type="text/javascript" src="terminal-master/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="terminal-master/jquery.terminal.js"></script>

<script type="text/javascript">
$('#terminal_container').height($(document).height());
$('#terminal_container').terminal('server.php', {custom_prompt : "&gt; ", hello_message : 'PHP Server Basic <br \>Ready'});
</script>			
</body>
</html>
