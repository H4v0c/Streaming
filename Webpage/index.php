<html>
	<head>
		<title>Stream test Site</title>
		<?php
			require_once "./resources/mysqli.php";
		?>


	</head>
	<body>
		<?php
		
			echo '<a href="login.php">Login</a><br><br>';
			
			$query = "SELECT `users`.user_name, `streams`.str_name, `streams`.str_currently FROM `streams` INNER JOIN `users` ON `streams`.str_user =  `users`.user_id WHERE `streams`.str_currently = 1";
									
			$res = $mysqli->query($query);
			if (!empty($res)) {
				$num = $res->num_rows;
				if($num != 0)
				{
					for ($i = 0; $i < $num; $i++)
					{
						$ob = $res->fetch_assoc();
						$streamer = $ob["user_name"];
						$streaming = $ob["str_name"];
						echo "<div>";
						echo $streamer." is currently streaming ".$streaming."!</br>\n";
						echo"<a href=\"source.php?streamer=". $streamer ."\">Stream in Source Quality</a></br>\n";
						echo "<a href=\"sdq.php?streamer=".$streamer ."\">Stream in 480p Quality</a>\n";
						
						echo "</div>";
					}
				}
				else {
					echo "Sorry, nobody is currently streaming =(\n";
				}
			}
			else {
				echo "Sorry, nobody is currently streaming =(\n";
			}
			
		?> 
		<!--<p>
		<a href="source.html">Stream in Source Quality</a></br>
		<a href="sdq.html">Stream in 480p Quality</a>
		</p>-->
	</body>
</html>