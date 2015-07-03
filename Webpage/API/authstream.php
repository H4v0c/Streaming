<?php
	require_once "../resources/mysqli.php";
	$test = true;
	$debug = false;
	if ( !empty($_POST) ) {
			switch ( $_POST['call'] ) {
					case "publish":
							$publisher_ip = $_POST['addr']; 
							if ( isset($_POST['skey']) && $_POST['skey'] != NULL ) {
									// Check to see if this is a correct skey
									
									$query = "SELECT `users`.user_name, `streams`.str_name, `streams`.str_key FROM  `streams` INNER JOIN  `users` ON  `streams`.str_user =  `users`.user_id WHERE `users`.user_name = '".$_POST['name']."'";
									
									if($debug) trigger_error($query);
									
									$res = $mysqli->query($query);
									
									if (!empty($res)) {	
										$num = $res->num_rows;										
										if($num != 0) {
											for($i = 0 ; $i < $num ; $i++) {
												$ob = $res->fetch_assoc();
												
												if ($_POST['name'] == $ob['user_name']) {
													if ($_POST['skey'] == $ob['str_key']) {
															$test = false;
															$query = "UPDATE `streams` INNER JOIN  `users` ON  `streams`.str_user = `users`.user_id SET `streams`.str_currently=1 WHERE `users`.user_name = '".$_POST['name']."'";
									
															if($debug) trigger_error($query);
															$mysqli->query($query);
															header("HTTP/1.1 202 Accepted"); // 2xx responses will keep session going
													} else {
															header("HTTP/1.1 403 Forbidden"); // Drop the session - incorrect skey
													
													}
												}
											}
											if($test == true) {
												header("HTTP/1.1 403 Forbidden"); // Drop the session - incorrect skey
											}

										} else {
											header("HTTP/1.1 403 Forbidden"); // Drop the session - No User found
										}
									} else {										
										
										header("HTTP/1.1 403 Forbidden"); // Drop the session - incorrect skey
											
									}
							} else {
									header("HTTP/1.1 403 Forbidden"); // Drop the session - no skey
							}
					break;
					case "play":
							// The same parameters - name, addr, etc. also work for playing streams over RTMP
							// You could use the on_play parameter to authorize plays against this same file
							// and perhaps limit plays to an IP address in a database, etc.
							// to enforce a paywall or to track visits
							header("HTTP/1.1 202 Accepted");
					break;
					case "publish_done":    $publisher_ip = $_POST['addr'];
                                                        if ( isset($_POST['skey']) && $_POST['skey'] != NULL ) {
                                                                        // Check to see if this is a correct skey
																		$query = "SELECT `users`.user_name, `streams`.str_name, `streams`.str_key FROM  `streams` INNER JOIN  `users` ON  `streams`.str_user =  `users`.user_id WHERE `users`.user_name = '".$_POST['name']."'";
																		$res = $mysqli->query($query);
                                                                        if (!empty($res)) {
                                                                                $num = $res->num_rows;
                                                                                if($num != 0) {
                                                                                        for($i = 0 ; $i < $num ; $i++) {
                                                                                                $ob = $res->fetch_assoc();
                                                                                                if ($_POST['name'] == $ob['user_name']) {
                                                                                                        if ($_POST['skey'] == $ob['str_key']) {
                                                                                                                        $test = false;
                                                                                                                        $query = "UPDATE `streams` INNER JOIN  `users` ON  `streams`.str_user = `users`.user_id SET `streams`.str_currently=0 WHERE `users`.user_name = '".$_POST['name']."'";
                                                                                                                        if($debug) trigger_error($query);
                                                                                                                        $mysqli->query($query);
                                                                                                                        header("HTTP/1.1 202 Accepted"); // 2xx responses will keep session going
                                                                                                        } else {
                                                                                                                        header("HTTP/1.1 403 Forbidden"); // Drop the session - incorrect skey

                                                                                                        }
                                                                                                }
                                                                                        }
                                                                                        if($test == true) {
                                                                                                header("HTTP/1.1 403 Forbidden"); // Drop the session - incorrect skey
                                                                                        }

                                                                                } else {
                                                                                        header("HTTP/1.1 403 Forbidden"); // Drop the session - No User found
                                                                                }
                                                                        } else {

                                                                                header("HTTP/1.1 403 Forbidden"); // Drop the session - incorrect skey

                                                                        }
                                                        } else {
                                                                        header("HTTP/1.1 403 Forbidden"); // Drop the session - no skey
                                                        }
                                        break;

			}

	}

?>
