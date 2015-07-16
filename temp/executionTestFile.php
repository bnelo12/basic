<?php 
$ATHISISCHAR="MARK"; 
$PI = 3.14; 
$B=4; 
$ALPHA = SIN(2*$PI); 
$C= 4/2; 
print $ATHISISCHAR; 
print ' Elo <BR \>'; 
print $B; 
print ' '; 
print $PI; 
print '<BR \>'; 
for($D=1; $D<101; $D++) { 
$C=$C+1; 
print $C+1; 
 } 
$ab=4; 
$ba=8; 
$cc=$ab*$ba; 
print '<BR \>'; 
print $cc; 
print '<br \>'; 
for($A = 1 ; $A <11; $A ++) { 
for($B = 1 ; $B <13; $B ++) { 
print $A; 
print ' x '; 
print $B; 
print ' = '; 
print $A*$B; 
print '<BR \>'; 
 } 
print '<BR \>'; 
 } 
print '<svg height="600" width="300" >'; 
$A=0; 
print '<line x1="'.($A).'" y1="'.($A).'" x2="300" y2="'.($A).'" style="stroke:green;stroke-width:2" />'; 
print '<line x1="0" y1="0" x2="0" y2="600" style="stroke:green;stroke-width:2" />'; 
for($X = 1 ; $X <301; $X ++) { 
$Y=250*SIN(2*$PI*$X/300); 
print '<line x1="'.($X).'" y1="'.(300+$Y).'" x2="'.($X+1).'" y2="'.(300+$Y).'" style="stroke:green;stroke-width:2" />'; 
 } 
print '<line x1="0" y1="600" x2="300" y2="600" style="stroke:green;stroke-width:2" />'; 
print '<line x1="300" y1="0" x2="300" y2="600" style="stroke:green;stroke-width:2" />'; 
print '</svg>'; 
$arrayValTHISISCHAR = array(); 
$arrayNum = array(); 
for($A=1; $A<11; $A++) { 
$arrayNum[$A]=$A*2; 
$arrayValTHISISCHAR[$A]="MARK ELO <BR \>"; 
print '<BR \>'; 
print $arrayValTHISISCHAR[$A]; 
print ' '; 
print '<br \>Array Output = '; 
print $arrayNum[$A]; 
 } 
print '<BR \>'; 
$Y = array(); 
for($X = 1 ; $X <301; $X ++) { 
$freq=75; 
$Y[$X]=250*SIN(2*$PI*$X/$freq); 
 } 
print '<svg height="600" width="600" >'; 
for($cycle = 0 ; $cycle <2; $cycle ++) { 
for($X = 1 ; $X <301; $X ++) { 
print '<line x1="'.($X+($cycle*300)).'" y1="'.(300+$Y[$X]).'" x2="'.(($X+1)+($cycle*300)).'" y2="'.(300+$Y[$X]).'" style="stroke:green;stroke-width:2" />'; 
 } 
 } 
print '</svg>'; 
 
 ?> 