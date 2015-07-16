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
 *  User Help Data
 *  
 */
print "User<br \>";
print "----<br \>";
print "USERADD &#60USERNAME&#62, &#60PASSWORD&#62, &#60PASSWORD&#62, &#60EMAIL&#62<BR \>";
print "LOGIN &#60USERNAME&#62, &#60PASSWORD&#62<BR \>";
//print "RESETPW &#60USERNAME&#62<BR \>";
print "LOGOUT<BR \>";

print "<br \>File<br \>";
print "----<br \>";
print "DIR<br \>";
print "NEW<br \>";
print "LOAD &#60filename&#62<br \>";
print "SAVE &#60filename&#62<br \>";

print "<br \>Edit/Execute<br \>";
print "------------<br \>";
print "RUN<br \>";
print "LIST<br \>";
//print "EDIT &#60line number&#62<br \>";
print "RENUMBER &#60Increment&#62<br \>";
//print "SAHRE <FILE>, <USERNAME>, EDIT | RUN<br \>";
//print "UNSHARE <FILE>, <USERNAME><br \>";

print "<br \>Commands<br \>";
print "--------<br \>";
print "DIM(&#60SIZE&#62)<br \>";
print "LET &#60REAL&#62 or &#60STRING&#62= &#60NUM&#62 or \"Foo Bar\" <br \>";
print "FOR &#60REAL&#62 = &#60NUM&#62 TO &#60NUM&#62<br \>";
print "NEXT &#60REAL&#62<br \>";
print 'PRINT &#60STRING&#62 ; &#60REAL&#62 ; "Foo Bar"<br \>';
print 'GRAPHBEGIN &#60XSIZE&#62, &#60YSIZE&#62<br \>';
print 'LINE &#60X1POS&#62, &#60Y1POS&#62, &#60X2POS&#62, &#60Y2POS&#62<br \>';
print 'GRAPHEND<br \>';

print "<br \>Variables<br \>";
print "---------<br \>";
print "Real X, x<br \>";
print "String X$, x$<br \>";
print "Array X$[&#60Element&#62], X[&#60Element&#62]<br \>";
print "<br \>";

?>