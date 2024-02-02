<?php
function myrand($min = 0, $max = 1)
{
	return ($min + ($max - $min) * (mt_rand() / mt_getrandmax()));
}
if (!function_exists('sys_getloadavg')) {
	function sys_getloadavg(){
		//return array(0.12,0.34,5.67);
		return array(myrand(0,7),-1,myrand(0,7));
    }
}
function lirun($cmd){
	$res = shell_exec($cmd);
	return $res==NULL ? 'Not Working' : $res;
}

function printCmd($cmd){
	$sli_terminal = '[user@domain ~]#';
	echo( 
	'<span class="ter">' . $sli_terminal . '<span>' .
	'<span class="cmd">' . $cmd . '<span>'
	);	
}
?>