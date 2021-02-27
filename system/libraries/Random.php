<?php
function random($n){
	$key='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$pj=strlen($key)-1;
	$res="";
	for($i=0;$i<$n;$i++){
		$in=rand(0,$pj);
		$res.=$key[$in];
	}
	return $res;
}
?>