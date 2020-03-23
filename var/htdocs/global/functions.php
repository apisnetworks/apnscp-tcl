<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/********************************
	* functions.php -
	* v 1.0 RC4-2
	* functions derived from all logins
	* :TODO: 
	* possible classification
	*
	*        development: Matt Saladna
	*        msaladna@apisnetworks.com
	*           (c) 2003 Apis Networks
	* $Id: functions.php,v 1.0 RC4-2p1 2003/03/30 17:20:13 msaladna Exp $
	*********************************/
	
	/*
	* error = default return value on error, NOT the same
	* as false, please read the Enabled functions for a 
	* few overview of that, I repeat, ERROR != 0.
	* debug variable = don't change.
	*************************
	* :TODO: log errors 
	*		  - exception: unlimited bandwidth/quota
	*************************
	*/
	define('ERROR',-1); 
	define('DEBUG', 1);
	define('APNSCPID', '$Id: apnscp,v 1.1 RC1 2004/03/09 01:08:10 msaladna Exp $');
	
	/* 
	* strip quotes off quoted material
	* (turn debug on and comment this out to see)
	* we ignore $_REQUEST since we handle through cookies
	* and $_REQUEST just contains $_COOKIE, $_GET, and $_POST
	* merged
	*/	
	$_COOKIE['ocw_username'] = trim($_COOKIE['ocw_username'],"\\\"");
	$_COOKIE['ocw_lang'] = isset($_COOKIE['ocw_lang']) ? trim($_COOKIE['ocw_lang'],"\\\"") : "";
	$_COOKIE['ocw_domainconf'] = isset($_COOKIE['ocw_domainconf']) ? trim($_COOKIE['ocw_domainconf'],"\\\"") : "";
	$_COOKIE['ocw_entrypoint'] = trim($_COOKIE['ocw_entrypoint'],"\\\"");
	$_COOKIE['ocw_cookie'] = trim(trim($_COOKIE['ocw_cookie'],"\\\"")); // remove newline and \"'s
	//Debug();
	//ParseConfiguration();
	$gHiddenServices = GetHiddenServices();
	$gUserName = stristr($_COOKIE['ocw_username'],"@") ? substr($_COOKIE['ocw_username'],0,strpos($_COOKIE['ocw_username'],"@")) : $_COOKIE['ocw_username'];
	$gDomainName = stristr($_COOKIE['ocw_username'],"@") ? substr($_COOKIE['ocw_username'],strlen($gUserName)+1) : "";
	//Debug();
    ParseConfiguration();
	/*
	* locale-specific, but we *don't*
	* really need this.
	*/
	setlocale(LC_ALL, $_COOKIE['ocw_lang']);
	$gLocale = localeconv();
	
	/*
	* more locale-specific functionality, yet
	* not all users have this installed
	*/
	if (extension_loaded("bindtext")) {
		bindtextdomain('frontend', '/usr/lib/locale/');
		textdomain('frontend');
	}	
	
	/*
	* populates cookies from joined parameters, i.e.
	* sendmail_enabled=1|ftp_enabled=1|etc...
	*/
	function ParseConfiguration() {
		global $gDomainName;
                if (strstr($_COOKIE['ocw_entrypoint'],"site") !== false ||
                    strstr($_COOKIE['ocw_entrypoint'],"user") !== false) {
                $_COOKIE['ocw_domainconf'] = CheckLocalServer($gDomainName,
                                        (
                                          (strstr($_COOKIE['ocw_entrypoint'],"site") !== false)) ?
                                            sprintf('services site') :
                                           sprintf('services user'));
                }
		//echo $_COOKIE['ocw_domainconf'];
		$paramList = explode("|", $_COOKIE['ocw_domainconf']);
		foreach ($paramList as $param) {
			@list($fieldName, $fieldVal) = split('=', $param);
			$_COOKIE[$fieldName] = trim(trim($fieldVal,"\\\""));
		}
	}
	
	/* 
	* return services that are hidden,
	* higher precedence over disabled.
	*/
	function GetHiddenServices() {
		if ( NULL !== ($handle = opendir('/etc/appliance/svcdb/hidden'))) {
			$ls = array();
			$i = 0;
			while (false !== ($file = readdir($handle))) { 
				$ls[$i] = $file;
				$i++;
			}
		} else
			return ERROR;
		closedir($handle); 
		return $ls;
	}
	
	/*
	* returns true if the requested
	* service is hidden (check GetHiddenServices)
	*/
	function IsHidden($mService) {
		global $gHiddenServices;
		return in_array($mService, $gHiddenServices);
	}
	
	/*
	* dumps superglobals, debugging purpose only
	* notice this isn't affected by the DEBUG define :)
	*/
	function Debug() {
		$superGlobals = array("\$_COOKIE", "\$_ENV", "\$_FILES", "\$_GET", "\$_POST", "\$_REQUEST", "\$_SESSION", "\$_SERVER");
		for ($i = 0; $i < sizeof($superGlobals); $i++) {
			print "<H1>".$superGlobals[$i]."</H1><BR>";
			eval("\$superGlobals[$i] = $superGlobals[$i];");
			while (list($varName,$varVal) = @each($superGlobals[$i])) {
				print $varName." => ".$varVal."<br>";
			}
		}
	}
	
		
	/*
	* calls to the local listener service
	* aka lservice process
	***********************
	* :TODO:
	* Check socket speed, may want to move over to IPC
	* if there's a large performance gain
	***********************
	*/
	function CheckLocalServer($mSite, $mType, $mData = "") {
		global $apnscpPort, $apnscpHost;
		
		// locks which the lService interacts with
		// is locking saving anyone for the record?
		
		$fp = fopen("/usr/apnscp/var/lock/".$_COOKIE['ocw_username'],"a");
		if (!$fp) { 
			trigger_error("Could not open lock for user ".$_COOKIE['ocw_username'],E_USER_ERROR);
			return ERROR;
		}
		// acquire a lock on the file
		if (!flock($fp,LOCK_EX, $val = 1)) {
			trigger_error("Could not obtain exclusive lock for user ".$_COOKIE['ocw_username'],E_USER_ERROR);
			return ERROR;
		} 
		fseek($fp,0);
		ftruncate($fp,0);
		fputs($fp,$_COOKIE['ocw_cookie']);
		flock($fp,LOCK_UN); // release lock
		fclose($fp);
		
		// only readable/writable by owner... who is nobody... oh well
		// it is better than nothing
		chmod("/usr/apnscp/var/lock/".$_COOKIE['ocw_username'],0600); 
		// sequentially build our string.
		$stream = "(".$_COOKIE['ocw_username']." ".$_COOKIE['ocw_cookie'].") ";
		$stream .= $mSite." ".$mType." ";
		for ($i = 2; $i < func_num_args(); $i++)
			$stream .= func_get_arg($i)." ";
		$res = fsockopen("127.0.0.1",50015);
		if (!$res) {
			trigger_error("Cannot connect to lService backend, is the apnscp running?", E_USER_ERROR);
			return ERROR;
		}
		// trim to remove the spacing
		fputs($res,trim($stream));
		$data = '';
		while (!feof($res))
			$data .= fgets ($res,128);
		fclose ($res);
		return trim($data);
	}
	
	/*
	* handles class types per row
	* for the 'Site Information'
	* if you want to modify it, just modify 
	* the CSS attributes.
	* optional argument that SwitchCellColors() can be invoked
	* with: 1, this will return the previous color.
	*/
	function SwitchCellColors($mIgnore = 0) {
		static $sAlternate = 0; 
		if (!$mIgnore)
			$sAlternate++;
		if ( $sAlternate % 4 == 1 || $sAlternate % 4 == 2) 
			return "even";
		else 
			return "odd";
	}
	
	
	/*
	* Ensim, you suck. 
	* :TODO:
	* Will invariably get axed
	* or highly modified. This Ensim-supplied
	* function is awful.
	*/ 
	function is_lwp310() {
		$fp = fopen("/usr/lib/opcenter/VERSION", "r");
		$str = fgets($fp, 80);
		fclose($fp);
		if (strstr($str, "3.1"))
			return true;
		else
			return false;
	}
	
	function is_lwp350() {
		$fp = fopen("/usr/lib/opcenter/VERSION", "r");
		$str = fgets($fp, 80);
		fclose($fp);
		if (strstr($str, "3.5"))
			return true;
		else
			return false;
	}
	
	function is_lwp370() {
		$fp = fopen("/usr/lib/opcenter/VERSION", "r");
		$str = fgets($fp, 80);
		fclose($fp);
		if (strstr($str, "3.7"))
			return true;
		else
			return false;
	}
	
	/*
	* checks whether or not the user
	* has Telnet access (also SSH-2)
	*/
	function TelnetEnabled($mDomain, $mUser) {		
		$fp = @fopen("/home/virtual/".$mDomain."/etc/ssh.pamlist", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (trim($line) == $mUser) {
					@fclose($fp);
					return 1;
				}
			}
		@fclose($fp);
		return 0;
	}
	
	/*
	* returns whether FTP access exists
	* for the user/site admin
	*/
	function FtpEnabled($mDomain, $mUser) {
		$fp = @fopen("/home/virtual/".$mDomain."/etc/proftpd.pamlist", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (trim($line) == $mUser) {
					@fclose($fp);
					return 1;
				}
			}
		@fclose($fp);
		return 0;
	}
	
	/*
	* returns whether e-mail access exists
	* for the user
	*/
	function EmailEnabled($mDomain, $mUser) {
		$fp = @fopen("/home/virtual/".$mDomain."/etc/imap.pamlist", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (trim($line) == $mUser) {
					@fclose($fp);
					return 1;
				}
			}
		@fclose($fp);
		return 0;
	}
	 
	/* 
	* scans file, returns random line
	* used for tip of the day
	* can be passed option argument to 
	* source different directories' totd files
	* e.g. 
	* 	/usr/var/apnscp/var/htdocs/site
	*					OR
	* 	/usr/var/apnscp/var/htdocs/user
	* latter is invoked when RandomTip(user) is called
	*/
	function RandomTip($mDir = "site") {
		static $randCalled = 0;
	  	$fp = fopen("totd.txt","r");
		$data = fread($fp,filesize("/usr/apnscp/var/htdocs/".$mDir."/totd.txt"));
		fclose($fp);
		$arr = split("\n[^[:graph:]]*\n",$data);
		unset($data);	
		if (!$randCalled) {
			srand ((float) microtime() * 10000000);
			$randCalled = 1;
		}
		return $arr[array_rand($arr)];
	}
	
	/*
	 * Query a whois server and return
	 * the results
	 ***********************
	 * :KLUDGE: 
	 * recursively calls sequential servers to obtain data
	 * beginning from rs.internic.net - only
	 * .net/.org/.com/.edu sites work with this, may want to
	 * give a centralized database of registrars for other
	 * TLDs
	 * in addition, there is some nasty formatting that
	 * could be tweaked
	 ************************
	 */
	 function Whois($mWhois) {
	 	$whoisData = "";
		$fp = fsockopen("rs.internic.net", 43, $errno, $errstr, 10);
		if (!$fp)
			return "Error: $errstr ($errno)\n";        
		else {        
			fputs($fp,$mWhois."\n");        
			while(!feof($fp)) {
				if (eregi("Whois Server: ([a-zA-Z0-9.-]+)", fgets($fp), $site)) {
					fclose($fp);
					$fp = fsockopen($site[1], 43, $errno, $errstr, 10);
					if (!$fp)
						return "Error: $errstr ($errno)\n";    
					fputs($fp,$mWhois."\n"); 
					while (!feof($fp)) 
						$whoisData .= fgets($fp);
				}
			}
			@fclose($fp);
			if (trim($whoisData) == "") 
				return "No record for ".$mWhois."\n";
			return $whoisData;
		}
	}
	
	/*
	* performs shell-level call traceroute
	* to destination
	**********************
	* :KLUDGE:
	* may want to work out a better method later
	* a shell-level traceroute that's dependent
	* upon the OS is a bad idea. Will want to
	* move over to asynchronous communication later
	* to prevent blocking
	***********************
	*/
	function Traceroute($mHostname) {
		$tracerouteData = "";
		$io = popen("traceroute ".$mHostname." 2>&1", "r");
		while (!feof($io)) {
			if (($data = trim(fgets($io))) == "") continue;
			$tracerouteData .= trim($data)."\n";
		}
		pclose($io);
		return $tracerouteData;
	}
	
	/* 
	* returns services a domain possesses
	*********************
	* :KLUDGE: 
	* only handles CGI, Frontpage, Miva,
	* mod_perl, SquirrelMail, SSI, Tomcat
	* and raw log existence - if you wish
	* to add an additional service then
	* make a file with a corresponding name
	* PostgreSQL and others will hopefully be
	* merged into here at a later date.
	**********************
	*/
	function GetServices($mDomain) {
		$services = "";
		if ($dir = @opendir("/etc/httpd/conf/".GetAdmin($mDomain))) {
			$i = 0;
			while ( ($file = readdir($dir)) ) {
			 if ($file == "." || $file == "..") continue;
			 if (!IsHidden($file)) {
			 	$services[$i] = $file;
				$i++;
			}
		  }  
		  @closedir($dir);
		} else
			return ERROR;
		return $services;
	}
	
	/*
	* returns the respective mapped
	* directory name for a domain
	* the only reason this is here
	* is for the user summary page
	*/
	function GetAdmin($mDomain) {
		if ($fp = @fopen("/etc/virtualhosting/mappings/domainmap","r")) {
			while (!feof($fp)) {
				$data = trim(fgets($fp));
				if (ereg("^".$mDomain." = site([0-9]+)$", $data, $arr)) {
					@fclose($fp);
					return "site".$arr[1];
				}
			}
			@fclose($fp);
			return ERROR;
		} else {
			@fclose($fp);
			return ERROR;
		}	
	}
	
	/*
	* inverse operation of GetAdmin
	* returns domain aliases to siteN
	*/
	function GetDomain($mSite) {
		if ($fp = @fopen("/etc/virtualhosting/mappings/domainmap","r")) {
			while (!feof($fp)) {
				$data = trim(fgets($fp));
				if (ereg("^([0-9a-zA-Z\.-]+) = ".$mSite."$", $data, $arr)) {
					// prevents it from picking up an alias
					if (file_exists("/home/virtual/".$arr[1])) {
						@fclose($fp);
						return $arr[1];
					}
				}
			}
			@fclose($fp);
			trigger_error("Could not find requested domain map for user: ".$mSite,E_USER_WARNING);
			return ERROR;
		} else {
			trigger_error("Could not open /etc/virtualhosting/mappings/domainmap!",E_USER_ERROR);
			@fclose($fp);
		}	
	}
	
	/*
	 * check for a valid login
	 * and if not, invalidate it
	 * and prompt the user with 
	 * a link to the login page
	 ***************:NOTE:******************
	 * ****PLEASE INCLUDE THIS FUNCTION*****
	 * ****WHENEVER CREATING NEW MODULES****
	 ***************:NOTE:******************
	 */
	function Login() {
		global $gUserName, $gDomainName;
		$kill = 0;
		if (DEBUG)
			$area = -1;
		/* 1 = admin
		* 2 = reseller
		* 3 = site
		* 4 = user
		* 5 = unknown
		*/
		switch (dirname($_SERVER['SCRIPT_NAME'])) {
			case "/webhost/appliance/provisions":
				$loginType = 1;
				break;
			case "/webhost/services/reseller/resellercp/provisions":
				$loginType = 2;
				break;
			case "/webhost/services/virtualhosting/siteadmin/provisions":
				$loginType = 3;
				break;
			case "/webhost/services/virtualhosting/useradmin/provisions":
				$loginType = 4;
				break;
			default:
				$loginType = 5;
		}
		if (! (isset($_COOKIE['ocw_entrypoint']) && isset($_COOKIE['ocw_username']) && isset($_SERVER['HTTP_REFERER'])) ) 
			$kill = 1;
		else if ($loginType == 1 && ($gUserName != "admin" || !ereg(":[0-9]+/webhost$",$_COOKIE['ocw_entrypoint'])
			|| !ereg(":[0-9]+(/webhost/navbar|/webhost/view_shortcuts|/webhost/appliance/provisions/.*|/webhost/)$",$_SERVER['HTTP_REFERER']))) {
			// invalid admin
			$kill = 1;
			if (DEBUG)
				$area = 1;
		} else if ($loginType == 2 && !eregi(":[0-9]+/services/reseller/resellercp$",$_COOKIE['ocw_entrypoint'])) {
			// invalid reseller
			$kill = 1;
			if (DEBUG)
				$area = 2;
		} else if ($loginType == 3 && (!ereg(":[0-9]+/webhost/services/virtualhosting/siteadmin$",$_COOKIE['ocw_entrypoint']) || !IsAdmin($gDomainName,$gUserName)
			|| !ereg(":[0-9]+(/webhost/services/virtualhosting/siteadmin(/?.*)?|/webhost/services/virtualhosting/siteadmin/navbar|/webhost/services/virtualhosting(/)?|".
			"/webhost/services/virtualhosting/siteadmin/view_shortcuts(/)?|/webhost/services/virtualhosting/siteadmin/provisions/.*)$",
			$_SERVER['HTTP_REFERER']))) {
				// invalidate and destroy the cookie.
				$kill = 1;
				if (DEBUG)
					$area = 3;
		} else if ($loginType == 4 && (!eregi(":[0-9]+/webhost/services/virtualhosting/useradmin$",$_COOKIE['ocw_entrypoint'])  || !IsUser($gDomainName,$gUserName)
			|| !ereg(":[0-9]+(/webhost/services/virtualhosting/useradmin/|/webhost/services/virtualhosting/useradmin/provisions/.*|".
			"/webhost/services/virtualhosting/useradmin/userinfo|/webhost/services/virtualhosting/useradmin/navbar|".
			"/webhost/services/virtualhosting/useradmin/view_shortcuts)$",$_SERVER['HTTP_REFERER']) )) {
				// invalid user
				$kill = 1;
				if (DEBUG)
					$area = 4;
		}
		if ($kill) {
			// cookie destruction
			while (list($cookieName,$varVal) = @each($_COOKIE)) {
				setcookie($cookieName, '', (time () - 2592000), '/', '', 0); 
			}
			if (DEBUG)
				echo $area;
			include "logintemplate.php";
			die();
		}
	}
	
	/*
	* returns whether or not the
	* username is the admin of the site
	*/
	function IsAdmin($mDomain, $mUser) {
		$fp = @fopen("/home/virtual/".$mDomain."/etc/group", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (ereg("^".$mUser.":",trim($line))) {
					@fclose($fp);
					return 1;
				}
			}
		@fclose($fp);
		return 0;
		
	}
	
	/*
	* returns whether or not the
	* username is a valid user of a site
	*/
	function IsUser($mDomain, $mUser) {
		$fp = @fopen("/home/virtual/".$mDomain."/etc/passwd", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (ereg("^".$mUser.":",trim($line))) {
					@fclose($fp);
					return 1;
				}
			}
		@fclose($fp);
		return 0;
		
	}
	
	function Commafy($text) {
		return preg_replace("/(\d)(?=(\d\d\d)+(?!\d))/","$1,",$text);
    }
		
	include_once "mysqlhash.php"; // Custom MySQL user mappings
	include_once "pgsqlhash.php"; // PostgreSQL user mappings
	include_once "config.php"; // standardized configuration
	include_once "sql.php"; // lastly, SQL connectivity
	include_once "error.php"; // error logging

	/* custom functions */
	if (file_exists("custom.php")) 
		include_once "custom.php";
?>
