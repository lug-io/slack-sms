<?php

require "shared/SlackCredentials.php";
require "shared/TwilioCredentials.php";
require "models/SlackPOST.php";
require "libraries/twilio-php-master/Services/Twilio.php";

if(	empty($_POST["token"]) || empty($_POST["team_id"]) || empty($_POST["team_domain"]) || empty($_POST["channel_id"]) || 
	empty($_POST["channel_name"]) || empty($_POST["user_id"]) || empty($_POST["user_name"]) || empty($_POST["command"]) || 
	empty($_POST["text"]) || empty($_POST["response_url"]))
{
	die("Not all Slack POST properties are set");
}

$incoming = new SlackPOST($_POST);

if($incoming->getToken() != $SlackToken){
	die("Bad token");
}

// Determine Action (poor man's routing)
switch($incoming->getAction()){
    case "-add":
        // If valid...
        // DB Connection
        // Exists?
        // If not, add, flag as pending
        // Else, die
        break;
    case "-remove":
        // If valid...
        // DB Connection
        // Exists?
        // If yes, remove
        // Else, die
        break;
    case "-update":
        // If valid...
        // DB Connection
        // Exists?
        // If yes, update, flag as pending
        // Else, die
        break;
    default:
        sendMessage($incoming->getMessage(), $incoming->getTarget(), $TwilioAccountSid, $TwilioAuthToken, $TWILIONUMBER);
}


// Send reply
function sendMessage($message, $target, $TwilioAccountSid, $TwilioAuthToken, $TWILIONUMBER)
{
    // instantiate a new Twilio Rest Client
    $client = new Services_Twilio($TwilioAccountSid, $TwilioAuthToken);

    try {
        $message = $client->account->messages->create(array(
            "From" 	=> $TWILIONUMBER,
            "To" 	=> $target,
            "Body" 	=> $message
        ));
    } catch (Services_Twilio_RestException $e) {
        die($e->getMessage());
    }

    echo $incoming->getSuccessMessage();
}

?>