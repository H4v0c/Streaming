<!DOCTYPE html>
<html>
<head>
	<title>Video.js | HTML5 Video Player</title>
		
	<link href="video-js/video-js.css" rel="stylesheet" type="text/css">
	<script src="video-js/video.js"></script>
	<script>
		videojs.options.flash.swf = "video-js/video-js.swf";
	</script>
	<?php
		require_once "./resources/mysqli.php";
	?>

</head>
<body>
	<?php
		
		$streamer = "";
		if(empty($_POST['streamer']) AND empty($_GET['streamer'])) {
			echo "No Streamer given!";
		} else {
			if(empty($_POST['streamer'])) {
				$streamer = $_GET['streamer'];
			} else {
				$streamer = $_POST['streamer'];
			}
			$query = "SELECT `users`.user_name, `streams`.str_name, `streams`.str_currently, `streams`.str_key FROM `streams` INNER JOIN `users` ON  `streams`.str_user =  `users`.user_id WHERE `users`.user_name = '".$streamer."'";
			$res = $mysqli->query($query);
			if (!empty($res)) {
				$ob = $res->fetch_assoc();
				$streaming = $ob['str_currently'];
				if($streaming == 1)
				{
					echo "<video id=\"source\" class=\"video-js vjs-default-skin\" controls preload=\"auto\" autoplay width=\"1280\" height=\"720\" data-setup='{ \"techOrder\": [\"flash\"] }'>";
					echo "	<source src=\"rtmp://144.76.162.55/sdq/".$streamer."\" type='rtmp/mp4' />";
					echo "	<p class=\"vjs-no-js\">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href=\"http://videojs.com/html5-video-support/\" target=\"_blank\">supports HTML5 video</a></p>";
					echo " </video>";
				
				}
				else {
					echo "Sorry, Streamer is currently not streaming!";
				}
			} else {
				echo "Streamer not found!";
			}
		}
	
	?>
	

</body>
</html>
