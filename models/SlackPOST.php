<?php

class SlackPOST {
	// Init POST
	var $token;
	var $teamId;
	var $teamDomain;
	var $channelId;
	var $channelName;
	var $userId;
	var $userName;
	var $command;
	var $text;
	var $responseUrl;

	// Derived
	var $action = "DEFAULT VALUE";
	var $value 	= "DEFAULT VALUE";

	function __construct($post){
		$this->token 		= $_POST["token"];
		$this->teamId 		= $_POST["team_id"];
		$this->teamDomain 	= $_POST["team_domain"];
		$this->channelId 	= $_POST["channel_id"];
		$this->channelName 	= $_POST["channel_name"];
		$this->userId 		= $_POST["user_id"];
		$this->userName 	= $_POST["user_name"];
		$this->command 		= $_POST["command"];
		$this->text 		= $_POST["text"];
		$this->responseUrl 	= $_POST["response_url"];

		$allTerms = explode(" ", $this->text);
		if(count($allTerms) > 1)
		{
			$this->action 	= $allTerms[0];
			array_shift($allTerms);
			$this->value 	= implode(" ", (array)$allTerms);
		}
	}

	function getAction(){
		return $this->action;
	}

	function getToken(){
		return $this->token;
	}

	function getMessage(){
		return "Sent from Renovo Slack: \n" . $this->value;
	}

	function getTarget(){
		return "+1" . $this->action;
	}

	function getSuccessMessage(){
		return 	"Message: " . $this->value . "\n"
				. "Recipient: " . $this->action . "\n";
	}
}