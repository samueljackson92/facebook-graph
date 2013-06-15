<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
require_once('facebook-sdk/src/facebook.php');

$config = array(
	'appId' => '210911162367452',
	'secret' => '76f5078cc49489bb7dd8683395fb4b18',
	'cookie' => true
	);

$facebook = new Facebook($config);
$user_id = $facebook->getUser();

if($user_id) {
	// We have a user ID, so probably a logged in user.
	// If not, we'll get an exception, which we handle below.
	try {

		//get this persons facebook data.
		if(isset($_POST["id"])) {
			$id = $_POST["id"];
			echo queryMutualFriends($facebook, $id);
		} else {
			echo queryFriends($facebook);
		}

	} catch(FacebookApiException $e) {
		header('HTTP', true, 500);
	}   
} else {

// No user, print a link for the user to login
$login_url = $facebook->getLoginUrl();
echo 'Please <a href="' . $login_url . '">login.</a>';

}


function queryFriends($facebook) {
	$friends = $facebook->api('/me/friends','GET');
	return json_encode($friends);
}

function queryMutualFriends($facebook, $id) {
	$friends = $facebook->api('/'.$id.'/mutualfriends','GET');
	return json_encode($friends);
}

?>