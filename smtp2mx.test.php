<?

/*
*
*	Zukas Michael smtp2mx php class example
*	2012 - 2013
*	zukasmichael@gmail.com
*	
*/
	require ( 'smtp2mx.class.php' );



	$a_smtp2px = new smtp2mx();

	if( $a_smtp2px->smtp_mail ('test@test.com','test@test.com','final test','test email content' ) )
	{
	
		//	var_dump ( $a_smtp2px->debug );
		echo "Mail sent";
	
	}

?>