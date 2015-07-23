<?php 
$PI = 3.14; 
print '<svg height="600" width="300" >'; 
$A=0; 
print '<line x1="'.($A).'" y1="'.($A).'" x2="300" y2="'.($A).'" style="stroke:green;stroke-width:2" />'; 
print '<line x1="0" y1="0" x2="0" y2="600" style="stroke:green;stroke-width:2" />'; 
print '<line x1="0" y1="600" x2="300" y2="600" style="stroke:green;stroke-width:2" />'; 
print '<line x1="300" y1="0" x2="300" y2="600" style="stroke:green;stroke-width:2" />'; 
for($X = 1 ; $X <301; $X ++) { 
$Y=250*SIN(2*$PI*$X/300); 
print '<line x1="'.($X).'" y1="'.(300+$Y).'" x2="'.($X+1).'" y2="'.(300+$Y).'" style="stroke:green;stroke-width:2" />'; 
 } 
print '</svg>'; 
 
 ?> 