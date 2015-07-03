<html>
	<head>
		<script src="resources/scripts.js"></script>
	</head>
	<body>
		
		
		<?php
			$ph = $_POST['passhash'];
			$name = $_POST['user'];
			
			if(!isset($ph) && !isset($name)){
				echo '<form>';
				echo 'Loginname <input type="text" name="user_name"><br>';
				echo 'Password  <input type="password" name="password"><br>';
				echo '<input type="button" value="Abschicken" onclick="return sendpost()">';
				echo '</form>';
				
			}
			else {
				
				echo 'Hello $name';
			}
			
			 
		?>
	</body>
</head>