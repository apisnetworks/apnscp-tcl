<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/********************************
	* userfunctions.php -
	* v 1.0 RC4-2
	* functions for user admins ONLY
	*
	*        development: Matt Saladna
	*        msaladna@apisnetworks.com
	*           (c) 2003 Apis Networks
	* $Id: userfunctions.php,v 1.1.1.1 2004/12/22 06:16:20 root Exp $
	*********************************/
	
	include_once "functions.php";
	
	/*
	* returns the numeric alias
	* of a specific user (e.g. 45305)
	* could've passed the domain and username as args
	* but it would've broken several existing calls
	* ugly work-around, expect fix shortly
	*/
	function GetUserNumRef($mDomain, $mUser) {
		$uid = ERROR; /* default, not found, error (could be 0 in theory) */
		$fp = @fopen("/home/virtual/".$mDomain."/etc/passwd", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (ereg("^".$mUser.":x:(.*):.*:.*:.*:.*$",$line, $regs)) {
					$uid = $regs[1];
					break;
				}
			}
		@fclose($fp);
		return $uid;
	}
	
	/*
	* returns full name of a user
	*/
	function GetFullName($mDomain, $mUser) {
		$fp = @fopen("/home/virtual/".$mDomain."/etc/passwd", "r");
		$uname = "";
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (ereg("^".$mUser.":x:.*:.*:(.*):.*:.*$",$line, $regs)) {
					$uname = $regs[1];
					break;
				}
			}
		return $uname;
		@fclose($fp);	
	}
	
?>