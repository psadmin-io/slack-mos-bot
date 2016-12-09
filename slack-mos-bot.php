<?php
	// psadmin.io
	//------------
        // MOS BOT - My Oracle Support info and link generator
	//------------
   	
	// vars
        $token_key = '***_ADD_TOKEN_***';
        $help_file = '***_ADD_URL_***';
        $command = $_POST['command'];
        $text = $_POST['text'];
        $token = $_POST['token'];

    	// validate token
	if($token != $token_key){ 
 	   $msg = "The token for the slash command doesn't match. Check your script.";
    	   die($msg);
       	   echo $msg;
	}

	// process request
	$text_array = explode(" ",$text);
	$type = $text_array[0];
	$param = $text_array[1];
	
	/* Take any text passed 2nd param and make it a string
	unset($text_array[0]);
	unset($text_array[1]);
	$descr = implode(" ",$text_array);
	*/
	
	switch ($type) {
		case doc:
			$reply = 'https://support.oracle.com/epmos/faces/DocumentDisplay?id=' . $param;
			break;
		case bug:
			$reply = 'https://support.oracle.com/epmos/faces/BugMatrix?id=' . $param;
			break;
		case patch:
			$reply = 'https://support.oracle.com/epmos/faces/PatchResultsNDetails?patchId=' . $param;
			break;
		case pum:
			$reply = generate_pum($param);
			break;
		case dpk:
			$reply = 'https://support.oracle.com/epmos/faces/DocumentDisplay?id=2127715.2';
			break;
		case idea:
			$reply = 'https://community.oracle.com/ideas/' . $param;
			break;
		default:
			if (preg_match('/^\d/', $type) === 1)
				// if number, default doc type
				$reply = 'https://support.oracle.com/epmos/faces/DocumentDisplay?id=' . $type;
			else
				$reply = generate_help();
			break;
	}

	// process response
	$response = array();
	$response["response_type"] = "in_channel";
	$response["text"] = $reply;

	header('Content-Type: application/json');
	echo json_encode($response);

	function generate_help() {
		return "Slackbot Help - https://psadminio.slack.com/files/kyle/F12PYDA3S/Slackbot_Help";
	}
	
	function generate_pum($param) {
		switch ($param) {
			case hcm:
			case hr:
				$result = '`Image 020`	December 9, 2016 `Image 021` January 20, 2017 `Image 022` April 21, 2017 `Image 023`	July 14, 2017 `Image 024` October 6, 2017'; 
				break;
			case fscm:
			case fin:
				$result = '`Image 022`	December 16, 2016 `Image 023` March 13, 2017 `Image 024` June 12, 2017 `Image 025` September 11, 2017 `Image 026` December 11, 2017'; 
				break;
			case elm:
				$result = '`Image 015`	January 27, 2017 `Image 016` July 28, 2017'; 
				break;
			case ih:
			case portal:
				$result = '`Image 003`	February 15, 2017 `Image 004` July 14, 2017 `Image 005`	December 1, 2017'; 
				break;
			case cs:
				$result = '`Image 004`	February 7, 2017 `Image 005` May 2, 2017 `Image 006` July 25, 2017 `Image 007` October 31, 2017'; 
				break;
			case crm:
				$result = '`Image 013` February 3, 2017 `Image 014` July 28, 2017'; 
				break;
			case home:
				$result = 'PUM Home Page - https://support.oracle.com/epmos/faces/DocumentDisplay?id=1641843.2'; 
				break;
			default:				
				$result = generate_help();				
		}

		return $result;
	}	
?>
