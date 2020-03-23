<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/********************************
	* adminfunctions.php -
	* v 1.0 RC4-2
	* functions for administrator ONLY
	* there are some duped functions,
	* probably will merge dupes into core
	*
	*        development: Matt Saladna
	*        msaladna@apisnetworks.com
	*           (c) 2003 Apis Networks
	* $Id: adminfunctions.php,v 1.1.1.1 2004/12/22 06:16:20 root Exp $
	*********************************/
	
	include_once "functions.php";
	$gSpaceMapping = array("B", "KB", "MB", "GB", "TB");

	/*
	 * recursively backtrack to get the 'best'
	 * unit measurements
	 */
	 function ChunkSize(&$rmValue, &$rmUnit) {
	 	$rmUnit++;
		$rmValue /= 1024.;
	 	if ($rmValue / 1024. > 1) 
			return ChunkSize($rmValue, $rmUnit);
		else
			return 1;
	 }
	 
	 /*
	  * returns number of sites hosted
	  */
	 function GetSiteTotal() {	
		if ( NULL !== ($handle = opendir('/home/virtual/'))) {
			$i = 0;
			while (false !== ($directory = readdir($handle))) { 
				if (strstr($directory,"site"))
					$i++;
			}
		} else
			return ERROR;
		closedir($handle); 
		return $i;	 	
	 }
	
	/*
	 * returns total number of open and 
	 * total trouble tickets
	 */	 
	 function GetTTCount(&$rttOpen, &$rttTotal) {
	 	global $mysql;
		mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
		mysql_select_db($mysql['standard']['database']);
		// probably shouldn't have enum'd the field, can't sum() it.
		if ($q = mysql_query("select count(id) from troubletickets where status = '1'"))
			$rttOpen = array_pop(mysql_fetch_row($q));
		if ($q = mysql_query("select count(id) from troubletickets where 1"))
			$rttTotal = array_pop(mysql_fetch_row($q));	
		return;
	 }
	 
	 /*
	 * check to see if we're running
	 * the latest apnscp version
	 */
	function apnscpCheck() {
		$fp = fopen("/usr/apnscp/etc/VERSION","r");
		$data = fread($fp,filesize("/usr/apnscp/etc/VERSION"));
		fclose($fp);
		return $data;
	}

	/*
	 * check to see if we're running
	 * the latest Ensim WEBppliance version
	 */
	 function EnsimCheck() {
	 	$fp = fopen("/usr/lib/opcenter/VERSION","r");
		$data = fread($fp,filesize("/usr/lib/opcenter/VERSION"));
		fclose($fp);
		return $data;
	 }
	/*
	 * returns an associative array
	 * of "service name" => status
	 * where status is of: 0,1 - off/on
	 */ 
	 function ServiceStatus(&$rServices) {
		global $urchin4Enabled;
		
		if (IsHidden("apache"))
			$status = -1;
		else
			$status = trim(shell_exec("ps ax | grep /usr/sbin/httpd | grep -v -c grep"));
		$rServices["Apache Web Server"] = $status;
		
		$status = trim(shell_exec("ps ax | grep /usr/apnscp/sbin/lservice | grep -v -c grep"));
		$rServices["apnscp"] = $status;
		
		if (IsHidden("bind"))
			$status = -1;
		else
			$status = trim(shell_exec("ps ax | grep named | grep -v -c grep"));
		$rServices["BIND DNS Server"] = $status;
		
		if (IsHidden("mysql"))
			$status = -1;
		else
			$status = trim(shell_exec("ps ax | grep mysqld | grep -v -c grep"));
		$rServices["MySQL"] = $status;
		
		$status = trim(shell_exec("ps ax | grep /usr/bin/postmaster | grep -v -c grep"));
		$rServices["PostgreSQL"] = $status;
		
		$status = trim(shell_exec("ps ax | grep /usr/sbin/sshd | grep -v -c grep"));
		$rServices["OpenSSH Secure Shell"] = $status;
		
		/*
		* because IMAP/POP3 is run under the xinetd process
		* with Redhat, we must check the file, assuming
		* an Ensim distribution, which places our required information
		* in wp_ipop3; given this, scan the file for the disabled
		* line and check the value.  It is slow and ugly, 
		* *but* it works, same ideology behind Telnet
		*/
		if (IsHidden("imap"))
			$status = -1;
		else {
			$status = trim(shell_exec("ps ax | grep xinetd | grep -v -c grep"));
			if ($status) {
				$status = ServiceOnOff("wp_ipop3");
			}
		}
		$rServices["POP3 + Imap Server"] = $status;
		
		if (IsHidden("proftpd"))
			$status = -1;
		else
			$status = trim(shell_exec("ps ax | grep proftpd | grep -v -c grep"));
		$rServices["ProFTPD FTP Server"] = $status;
		
		if (IsHidden("sendmail"))
			$status = -1;
		else
			$status = trim(shell_exec("ps ax | grep sendmail | grep -v -c grep"));
		$rServices["Sendmail SMTP Server"] = $status;
		
		if (IsHidden("telnet"))
			$status = -1;
		else {
			$status = trim(shell_exec("ps ax | grep xinetd | grep -v -c grep"));
			if ($status) {
				$status = ServiceOnOff("wp_telnet");
			}
		}	
		$rServices["Telnet"] = $status;
		
		if (IsHidden("tomcat4"))
			$status = -1;
		else
			$status = trim(shell_exec("ps ax | grep java.*endorsed.dirs | grep -v -c grep"));
		$rServices["Tomcat 4"] = $status;
		
		if ($urchin4Enabled) {
			$status = trim(shell_exec("ps ax | grep urchinwebd | grep -v -c grep"));
			$rServices["Urchin 5"] = $status;
		}
		// well if we're viewing this page *then*
		// WEBppliance works.
		$rServices["WEBppliance"] = 1;
	 }
	 
	/* 
	* returns 1 if on
	* else 0 if off
	*/
	function ServiceOnOff($mService) {
		$fp = @fopen("/etc/xinetd.d/".$mService, "r");
		if ($fp) {
			while (!feof($fp)) {
				$line = fgets($fp);
				if (ereg("disable[[:space:]=]*(yes|no)", trim($line), $opt)) {
					@fclose($fp);
					break;
				}
			}
			if ($opt[1] == "yes") 
				return 0;
			else
				return 1;
		}
		trigger_error("Cannot open file: /etc/xinetd.d/".$mService, E_ERROR);
		return -1;
	}
	/*
	* returns databases which a particular
	* user owns, uses distinct to ignore
	* different host entries
	*/
	function GetDatabases($mUsername) {
		global $mysql;
		$databases = array();
		mysql_connect("localhost",$mysql['databases']['username'],$mysql['databases']['password']);
		mysql_select_db($mysql['databases']['database']);
		$q = mysql_query("select distinct(db) from db where user = '".$mUsername."'");
		$i = 0;
		while ($row = mysql_fetch_row($q)) {
			$databases[$i] = $row[0];
			$i++;
		}
		return $databases;
	}
		
	/*
	* for use with MRTG logs
	*/
	function GetBandwidth() {
		global $bwLog;
		$fp = fopen($bwLog,"r");
		if (!$fp)
			return -1;
		$data = explode(" ",fgets($fp)); // disregard first line
		$lastTime = $data[0]; // set first timestamp
		// marks beginning of the date
		$timestampThreshold = mktime(0,0,0,date("m"),1,date("Y"));
		$bwAmt = 0;
		$i = 0;
		while (1) {
			$data = explode(" ",trim(fgets($fp)));
			if ($data[0] < $timestampThreshold) // went too far, break
				break;
			$bwAmt += $data[1] * ($lastTime - $data[0]) + $data[2] * ($lastTime - $data[0]); // add out/in
			$lastTime = $data[0];
			$i++;
		}
		fclose($fp);
		return $bwAmt;
	}
	/*
	* grabs the users -> domain
	* mappings for MySQL access
	*/
	function MysqlAliases() {
		global $mysqlhash;
		$aliases = array();
		// get a quick domain translation		
		$fp = @fopen("/etc/virtualhosting/mappings/mysql.usermap", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = trim(fgets($fp));
				if (ereg("^([a-zA-Z0-9]+) = (site[0-9]+)$",$line,$regs)) {
					$aliases[$regs[1]] = GetDomain($regs[2]);
				}
			}
		@fclose($fp);
		// now the additional $mysqlhash mappings
		if (isset($mysqlhash)) {
			foreach ($mysqlhash as $key => $val) {
				$aliases[$key] = GetDomain($val);
			}
		}
		return $aliases;
	}
?>
