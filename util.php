<?php

if (!defined("APP_LOADED")) {
	die();
}

function post(string $url, string $body) {
	/**
	 * Do a POST request to the given URL with the given body.
	 */
	
	$options = [
		"http" => [
			"method" => "POST",
			"header" => "Content-Type: application/json\r\n",
			"content" => $body,
			"timeout" => 3,
		]
	];
	
	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	
	return $result;
}

function send_discord_message(string $message) {
	$webhook_url = get_config("discord_webhook", "");
	
	if (!$webhook_url) {
		return;
	}
	
	$body = [
		"content" => $message,
	];
	
	post($webhook_url, json_encode($body));
}

function alert(string $title, string $url = "") {
	/**
	 * Add a notification to a user's inbox.
	 */
	
	send_discord_message(date("Y-m-d H:i:s", time()) . " — " . $title . ($url ? "\n[Relevant link](https://smashhitlab.000webhostapp.com/$url)" : ""));
}

function get_ip_address() : string {
	/**
	 * Get the current IP address.
	 */
	
	return $_SERVER["REMOTE_ADDR"];
}

function frand() : float {
	return mt_rand() / mt_getrandmax();
}
