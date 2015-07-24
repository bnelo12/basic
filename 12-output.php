<?php 
$wave = array(); 
$PI=3.14; 
$sampleRate = 44100; 
$toneFreq = 500; 
$toneFreq2 = 1000; 
$omega = 2 * $PI * $toneFreq / $sampleRate; 
$omega2 = 2 * $PI * $toneFreq2 / $sampleRate; 
$duration = 0.020; 
print $omega; 
print '<BR \>'; 
$sampleNum = $sampleRate * $duration; 
print $sampleNum; 
print '<br \>'; 
print '<svg height="600" width="900" >'; 
for($X = 1 ; $X <$sampleNum+1; $X ++) { 
$wave[$X] = 150 * ( SIN($X*$omega) + SIN($X*$omega2) ); 
if($wave[$X]<0) { 
$wave[$X] = ($wave[$X] * -1) + 300; 
 } else { 
$wave[$X] = 300 - $wave[$X]; 
 } 
print '<line x1="'.($X).'" y1="'.( $wave[$X]).'" x2="'.( $X+2).'" y2="'.( $wave[$X]).'" style="stroke:green;stroke-width:2" />'; 
 } 
print '</svg>'; 
 
 ?> 