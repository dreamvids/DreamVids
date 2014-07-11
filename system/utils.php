<?php

require_once SYSTEM.'request.php';
require_once SYSTEM.'response.php';

class Utils {

	public static function getPerformedRequest() {
		$requestProtocol = $_SERVER['SERVER_PROTOCOL'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$requestURI = key($_GET);
		$requestAcceptedData = $_SERVER['HTTP_ACCEPT'];

		return new Request($requestProtocol, $requestMethod, $requestURI, $requestAcceptedData);
	}

	public static function tps() {
		$decalage = 0;
		return time() + $decalage*3600;
	}

	public static function secure($str) {
		return htmlspecialchars(strip_tags(stripslashes($str)), ENT_QUOTES, 'UTF-8');
	}

	public static function stringStartsWith($haystack, $needle) {
		return !strncmp($haystack, $needle, strlen($needle));
	}

	public static function stringEndsWith($haystack, $needle) {
		$length = strlen($needle);

		if ($length == 0) {
			return true;
		}

		return substr($haystack, -$length) === $needle ? true : false;
	}

	public static function objectToArray($data) {
		if(is_object($data))
			$data = get_object_vars($data);

		if(is_array($data))
			return $data;
		else
			return false;
	}

	public static function debug($data, $exit = false) {
		if($data) {
			print '<pre>';
			print_r($data);
			print '</pre>';
		}
		if($exit)
			exit();
	}

	public static function getNotFoundResponse() {
		$response = new Response(404);
		$response->setBody('The document that you are looking for does not exists !');

		return $response;
	}

	public static function getForbiddenResponse() {
		$response = new Response(403);
		$response->setBody('Forbidden');

		return $response;
	}

	public static function getInternalServerErrorResponse() {
		$response = new Response(500);
		$response->setBody('Error occurred while trying to treat the request (application error)');

		return $response;
	}

	public static function sendResponse($response) {
		if($response instanceof Response) {
			$response->send();
		}
		else {
			self::getInternalServerErrorResponse()->send();
		}
	}

	public static function validateUsername($string='') {
		if($string != '') {
			if(!preg_match('/[^0-9A-Za-z]/',$string)) return true;
		}

		return false;
	}

	public static function validateMail($string='') {
		if($string != '') {
			if(filter_var($string, FILTER_VALIDATE_EMAIL)) return true;
		}

		return false;
	}

}