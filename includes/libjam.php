<?php
/*
 * *** PHP library for the JustAuth.Me (http://justauth.me) API ***
 * 
 * Author: Peter CAUTY (Toulon, France)
 * Description: This library must be used to connect to the JustAuth.Me (http://justauth.me) API. JustAuth.Me is a simple registration service: get registered on JustAuth.Me, fill a profile, and click on the "JustAuth.Me" button on all websites that works with, you get simply registered !
 * Contact the author: http://twitter.com/p_cauty | http://phpeter.fr | phpeter@phpeter.fr | peter@justauth.me
 * Creation: 17/08/2013
 * License: [CC BY-NC-SA 3.0 FR] http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 * 
 * *** PHP library for the JustAuth.Me (http://justauth.me) API ***
 */

class JAM
{
	const PUBLICKEY = '21ec3f76ced2457a93cf458b6dfbe2f5e623633a3f086ea938a89cba2a354827';
	const PRIVATEKEY = '5bbe1830415ce1ce5eb1394caa960825f549b0c8af6df9e14ab8e34197ea679e';
	
	private $token;
	private $connected;
	private $err;
	private $user;
	
	public function __construct($token)
	{
		$this->token = $token;
		$this->connected = false;
		$content = 'token='.$this->token;		
		$hash = hash_hmac('sha256', $content, self::PRIVATEKEY);
		$content .= '&publickey='.self::PUBLICKEY.'&hash='.$hash;
		$ch = curl_init('https://ssl.justauth.me/api/api.php?'.$content);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result, true);
		switch (@$result['code'])
		{
			case '0':
				$this->connected = true;
			break;
			
			case '1':
				$this->err = 'JustAuth.Me API authentication failed: The protocol of the Request must be HTTPS.';
			break;
			
			case '2':
				$this->err = 'JustAuth.Me API authentication failed: Connection token does not exist.';
			break;
			
			case '3':
				$this->err = 'JustAuth.Me API authentication failed: The sender of the request is not as expected';
			break;
			
			case '4':
				$this->err = 'JustAuth.Me API authentication failed: Wrong keypair';
			break;
			
			default:
				$this->err = 'JustAuth.Me API authentication failed: Unknown error';
			break;
		}
		
		if ($this->connected)
		{
		    $result['user']['password'] = self::Crypt($result['user']['password']);
			$this->user = $result['user'];
		}
		else
			trigger_error($this->err);
	}
	
	public function getUser()
	{
		if ($this->connected)
			return $this->user;
		return false;
	}
	
	public function sendResponse($success, $data)
	{
		if ($success == 1)
			echo json_encode(array('success' => true, 'identifiant' => $data) );
		elseif ($success == 0)
			echo json_encode(array('success' => false, 'err' => $data) );
	}
	
	public static function Crypt($a,$b=self::PRIVATEKEY){while(strlen($b)<strlen($a)){$b.=$b;}$b=substr($b,0,strlen($a));return$a^$b;}
}
?>