<?php
	require_once "../resources/mysqli.php";
	$streamer = "";
	if(empty($_POST['streamer']) AND empty($_GET['streamer'])) {
		echo "No Streamer given!";
	} else {
		if(empty($_POST['streamer'])) {
			$streamer = $_GET['streamer'];
		} else {
			$streamer = $_POST['streamer'];
		}
		
		$query = "SELECT `users`.user_name, `streams`.str_name, `streams`.str_currently
											  FROM  `streams` 
											  INNER JOIN  `users` ON  `streams`.str_user =  `users`.user_id 
											  WHERE `users`.user_name = '".$streamer."'";
		
		$res = $mysqli->query($query);
		if (!empty($res)) {
			$ob = $res->fetch_assoc();
			
			$ob['str_link'] = "http://stream.havoc.at/source.php?streamer=".$ob['user_name'];
			
			$test = json_encode($ob);
			
			echo $test;
		} else {
			echo "Streamer not found!";
		}
	}
	
?>