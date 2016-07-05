<?php
	// psadmin.io
	//------------
        // MOS BOT - My Oracle Support info and link generator
	//------------
   	
	// vars
        $token_key = '***_ADD_TOKEN_***';
        $command = $_POST['command'];
        $text = $_POST['text'];
        $token = $_POST['token'];

        // validate token
        if($token != $token_key){
           $msg = "The token for the slack command doesn't match. Check your script.";
           die($msg);
           echo $msg;
        }

        // process request
        $text_array = explode(" ",$text);
        $type = $text_array[0];
        $param = $text_array[1];

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
                        $reply = generate_help();
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
                                $result = '`Image 19` October 7, 2016 `Image 20` December 9, 2016';
                                break;
                        case fscm:
                        case fin:
                                $result = '`Image 19` June 27, 2016 `Image 20` August 22, 2016 `Image 21` October 17, 2016 `Image 22` December 12, 2016';
                                break;
                        case elm:
                                $result = '`Image 14` September 23, 2016';
                                break;
                        case ih:
                        case portal:
                                $result = '`Image 3` August 4, 2016 `Image 4` December 15, 2016';
                                break;
 case cs:
                                $result = '`Image 2` July 26, 2016 `Image 3` November 1, 2016';
                                break;
                        case crm:
                                $result = '`Image 12` September 23, 2016';
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
                           
