<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('facebook-sdk/src/facebook.php');

  $configData  = json_decode(file_get_contents("config.json"));

  $config = array(
    'appId' => $configData->appId,
    'secret' => $configData->secret,
    'cookie' => $configData->cookie
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();
?>
<!DOCTYPE html> 
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Facebook friends graph</title>

		 <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		 <style type="text/css">
		 	body {margin: 0 auto; text-align: center;}
		 	canvas {display: inline;}
		 	#log-box {width: 800px; margin: 0 auto;}
		 </style>
	</head>
	<body>
		<h1>Facebook Friends Graph</h1>
		<h3>By Sam Jackson</h3>

	<?php
	if($user_id) {
	?>
	
		<div id="log-box">
			<p>Building graph...</p>
			<div class="progress">
			  <div class="bar" style="width: 0%;"></div>
			</div>
		</div>
		<div>
			<button type="button" id="show-all-labels" class="btn btn-primary" data-toggle="button">Show All Labels</button>
		</div>
	<?php
	  // We have a user ID, so probably a logged in user.
	  // If not, we'll get an exception, which we handle below.
	  try {

?>
		
		<canvas id="viewport" width="800" height="600"></canvas>
		<div id="data-box"></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="arbor/lib/arbor.js"></script>
		<script src="renderer.js"></script>
		<script src="main.js"></script>

<?php
	  } catch(FacebookApiException $e) {
	    // If the user is logged out, you can have a 
	    // user ID even though the access token is invalid.
	    // In this case, we'll get an exception, so we'll
	    // just ask the user to login again here.
	    $login_url = $facebook->getLoginUrl(); 
	    echo 'Please <a href="' . $login_url . '">login.</a>';
	    error_log($e->getType());
	    error_log($e->getMessage());
	  }   
	} else {

	  // No user, print a link for the user to login
	  $login_url = $facebook->getLoginUrl();
	  echo '<a href="'. $login_url .'" class="btn btn-primary" >Please login.</a>';

	}

?>
	</body>
</html>