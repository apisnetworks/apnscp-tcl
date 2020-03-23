<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/********************************
	* error.php -
	* v 1.0 RC4-2
	* standard error handling routines
	*
	*        development: Matt Saladna
	*        msaladna@apisnetworks.com
	*           (c) 2003 Apis Networks
	* $Id: error.php,v 1.0 RC4-2 2003/03/23 11:48:02 msaladna Exp $
	*********************************/
	
	// we'll handle it.
	if ($useBetterErrorLogging) { 
		set_error_handler("ErrorHandler");
		error_reporting(E_ALL);
	}
	
	// user defined error handling function
	function ErrorHandler($errno, $errmsg, $filename, $linenum, $vars) {
		// 4.3.0 bug(?)
		if ($errno & E_NOTICE)
			return;
	
		global $notifyErrors;
		// timestamp for the error entry
		$dt = date("Y-m-d H:i:s (T)");
	
		// define an assoc array of error string
		// in reality the only entries we should
		// consider are 2,8,256,512 and 1024
		$errortype = array (
					1   =>  "Error",
					2   =>  "Warning",
					4   =>  "Parsing Error",
					8   =>  "Notice",
					16  =>  "Core Error",
					32  =>  "Core Warning",
					64  =>  "Compile Error",
					128 =>  "Compile Warning",
					256 =>  "User Error",
					512 =>  "User Warning",
					1024=>  "User Notice"
					);
		// set of errors for which a var trace will be saved
		$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
		
		// $erremail = error sent through e-mail
		// $errlocal = error logged to local server
		
		$errlocal = "<errorentry>\r\n";
		$errlocal .= "\t<phpversion>".phpversion()."</phpversion>\r\n";
		$errlocal .= "\t<sysname>".php_uname()."</sysname>\r\n";
		$errlocal .= "\t<datetime>".$dt."</datetime>\r\n";
		$errlocal .= "\t<errornum>".$errno."</errornum>\r\n";
		$errlocal .= "\t<errortype>".$errortype[$errno]."</errortype>\r\n";
		$errlocal .= "\t<errormsg>".$errmsg."</errormsg>\r\n";
		$errlocal .= "\t<scriptname>".$filename."</scriptname>\r\n";
		$errlocal .= "\t<scriptlinenum>".$linenum."</scriptlinenum>\r\n";
		$errlocal .= "\t<vartrace>\r\n";
		if (in_array($errno, $user_errors)) {
			if (extension_loaded("wddx"))
				$errlocal .= "\t\t".wddx_serialize_value($vars,"Variables")."\r\n";
		}
		$errlocal .= "\t</vartrace>\r\n";
		$errlocal .= "</errorentry>\r\n";
		
		/* now for the e-mail payload
		* could just have appended onto $errlocal
		* but I'd prefer slightly different structure
		*/
		if ($notifyErrors) {
			$erremail = "<errorentry>\r\n";
			$erremail .= "\t<phpversion>".phpversion()."</phpversion>\r\n";
			$erremail .= "\t<sysname>".php_uname()."</sysname>\r\n";
			$erremail .= "\t<configopts>\r\n";
			foreach (ini_get_all() as $key => $val) {
				$erremail .= "\t\t<".$key.">\r\n";
				foreach($val as $key2 => $val2) {
					$erremail .= "\t\t\t<".$key2.">".$val2."</".$key2.">\r\n";
				}
				$erremail .= "\t\t</".$key.">\r\n";
			}
			$erremail .= "\t</configopts>\r\n";
			$erremail .= "\t<loadedmods>\r\n";
			foreach (get_loaded_extensions() as $key => $val)
				$erremail .= "\t\t<module>".$val."</module>\r\n";
			$erremail .= "\t</loadedmods>\r\n";
			$erremail .= "\t<datetime>".$dt."</datetime>\r\n";
			$erremail .= "\t<errornum>".$errno."</errornum>\r\n";
			$erremail .= "\t<errortype>".$errortype[$errno]."</errortype>\r\n";
			$erremail .= "\t<errormsg>".$errmsg."</errormsg>\r\n";
			$erremail .= "\t<scriptname>".$filename."</scriptname>\r\n";
			$erremail .= "\t<scriptlinenum>".$linenum."</scriptlinenum>\r\n";
			$erremail .= "\t<scriptcontext>\r\n";
			$fp = fopen($filename,"r");
			$i = 1;
			while (!feof($fp)) {
				$line = rtrim(fgets($fp));
				if ($i >= ($linenum - 10) && $i <= ($linenum + 10)) {
					$erremail .= "\t\t<".$i.">\r\n\t\t\t".$line."\r\n\t\t</".$i.">\r\n";
				}
				$i++;
			}
			@fclose($fp);
			$erremail .= "\t</scriptcontext>\r\n";
			$erremail .= "\t<vartrace>\r\n";
			if (in_array($errno, $user_errors)) {
				if (extension_loaded("wddx"))
					$erremail .= "\t\t".wddx_serialize_value($vars,"Variables")."\r\n";
			}
			$erremail .= "\t</vartrace>\r\n";
			$erremail .= "</errorentry>\r\n";
		}
		
		
		// save to the error log, and e-mail me if there is a critical user error
		error_log($errlocal, 3, "/usr/apnscp/var/log/php_error.log");
		if ($notifyErrors && $errno == E_USER_ERROR)
			mail("bugs@apnscp.com","Critical Error Encountered",$erremail);
			
		// lastly echo our message
		echo "<strong>".$errortype[$errno]."</strong>: ".$errmsg." in ".$filename." on line ".$linenum."\n<br>";

	}	
?>