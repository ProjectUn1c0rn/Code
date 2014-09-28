<?php
// easter egg ? Some coding challenge ;)
/*
	Provide a function with a set of numbers and a target number.
	Get how many combinations are possible to find the target number with the set we gave

*/

define('DEBUG',true);

//tests :

$tests = array(
	//test 1 (arg1,arg2,expect)
	array(
		array(5,5,15,10),15,3
	),
	//test 2
	array(
		array(1,2,3,4),6,2
	),
	//test 3 (extended)
	array(
		array(1,4,2,6,1,3),11,5
	),
	array(
		array(1,5,11,54,32,14,18,9),87,3
	)


);

function calculate_combinations($numbers,$target) {
	$woot = 0;
	foreach(make_comb($numbers) as $comb) {
		if(array_sum($comb) == $target) {
			if(DEBUG)
				echo PHP_EOL.'DEBUG : '.json_encode($comb).PHP_EOL;
			$woot++;
		}

	}
	return $woot;
}

function make_comb($a) {
	//adapted from the clever method of http://stackoverflow.com/a/4280757
	$len  = count($a);
	$list = array();
	for($i = 1; $i < (1 << $len); $i++) {
		$c = array();
		for($j = 0; $j < $len; $j++)
			if($i & (1 << $j))  //so today I discovered << in PHP , thanks a******!
				$c[] = $a[$j];
		$list[] = $c;
	}
return $list;
}


//run tests :

foreach($tests as $test) {
	echo 'Testing '.implode(',',$test[0]).' against '.$test[1].' = '.$test[2].' : ';
	$result =  calculate_combinations($test[0],$test[1]);
	if($result === $test[2]) {
		echo 'OK';
	} else {
		echo 'FAILED : '.$result;
	}
	echo PHP_EOL;
}
