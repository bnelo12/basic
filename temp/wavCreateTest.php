<?php 
$freqOfTone = 440;
$sampleRate = 44100;
$seconds = 2;

$samplesCount = $seconds * $sampleRate;

$amplitude = 0.25 * 32768;
$w = 2 * pi() * $freqOfTone / $sampleRate;

$samples = array();
for ($n = 0; $n < $samplesCount; $n++) {
    $samples[] = (int)($amplitude *  sin($n * $w));
}

$srate = $sampleRate; //sample rate
$bps = 16; //bits per sample
$Bps = $bps/8; //bytes per sample /// I EDITED

$str = call_user_func_array("pack",
    array_merge(array("VVVVVvvVVvvVVv*"),
        array(//header
            0x46464952, //RIFF
            160038,      //File size
            0x45564157, //WAVE
            0x20746d66, //"fmt " (chunk)
            16, //chunk size
            1, //compression
            1, //nchannels
            $srate, //sample rate
            $Bps*$srate, //bytes/second
            $Bps, //block align
            $bps, //bits/sample
            0x61746164, //"data"
            160000 //chunk size
        ),
        $samples //data
    )
);
$myfile = fopen("sine440.wav", "wb") or die("Unable to open file!");
fwrite($myfile, $str);
print "DONE, played ".$samplesCount." samples";
 
?> 
 
<audio autoplay>
	<source src="sine440.wav" type="audio/wav">
</audio>