<?php

print "IN INPUT.PHP";

if (!empty($_POST['input']))
{
	$st = $_POST['input'];
	
	print $st."<br \>";
	
	?> <script>$('#terminal_container').terminal('server.php', {custom_prompt : "&gt; "});</script><?php
	
	
}
?>
