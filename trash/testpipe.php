<?php
	$desc = array (
		0 => array ('pipe', 'r'),
		1 => array ('file', './trash/error.out', 'a'),
		2 => array ('pipe', 'w')
	);

	$cmd = 'exec php ./trash/loop.php';

	$process = proc_open($cmd, $desc, $pipes);
	
	
	fwrite($pipes[0], null);
	fclose($pipes[0]);
	$status = proc_get_status($process);
	$pid = $status['pid'];
	echo $pid;
	sleep(1);
	

//	$output = stream_get_contents($pipes[1]);
//	$error_output = stream_get_contents($pipes[2]);
//	sleep(2);
//	fclose($pipes[1]);
	fclose($pipes[2]);
//        proc_close($process);
//	$pid = $pid + 1;
//	posix_kill($pid, SIGTERM);

//	echo $output;
?>
