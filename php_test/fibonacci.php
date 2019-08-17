<?php
	#include_once 'classes.php';
	
	echo "Тестовое задание 1\n";
	$lval = 0;
	$rval = 1;
	echo "0 -> 1\n1 -> 2\n";
	for($i = 3; $i < 65; $i++){
		$res = $lval + $rval;
		echo "$res -> $i\n";
		$lval = $rval;
		$rval = $res;
	}

