<?

/*
*
*	Zukas Michael smtp2mx php class
*	2012 - 2013
*	zukasmichael@gmail.com
*
*/



class smtp2mx
{

	private function talk($msg) {
	
		// if defined message - sending to socket
	
		if ($msg) {
		
			fputs($this->socket, "{$msg}\r\n");
		
		}
	
		// otherwise - just waiting for socket response
	
		$response = array();
		do
		{
			$s = fgets($this -> socket , 1024);
			$response[] = $s;
		}   while( strlen($s) > 3 && ' '!==$s[3]);
		
		$this -> debug[] = $response;
		return $response;
	}
	
	// end # private function: talk 

	
	public function smtp_mail($from, $to, $subject, $message)
	{
		getmxrr ( substr(strrchr($to, "@"), 1) , $mxhosts , $weight );

		$to_host = $mxhosts[0];
		$to_port = 25;
		$from_host = substr(strrchr($from, "@"), 1);

		$this->socket = fsockopen($to_host, $to_port, $errno, $errstr, 15);
		
		if ($this->socket)	{
		
			// let's talk in smtp language
			
			$this->talk("");
			$this->talk("EHLO {$to_host}");
			$this->talk("MAIL FROM:<{$from}>");
			$this->talk("RCPT TO:<{$to}>");
			$this->talk("DATA");
			$this->talk("User-Agent: {$from_host}\r\nFrom: \"{$from}\" <{$from}>\r\nReturn-Path: <{$from}>\r\nTo: {$to}\r\nSubject: {$subject}\r\nReply-To: \"{$from}\" <{$from}>\r\nX-Sender: {$from}\r\nX-Mailer: {$from_host}\r\nX-Priority: 3 (Normal)\r\nMime-Version: 1.0\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n{$message}\r\n\r\n.");
			$this->talk("QUIT");
			
			return true;

		} else return false;

	}
	
	// end # public function: smtp_mail

}

// end # class smtp2mx



?>