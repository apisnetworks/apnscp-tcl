<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/********************************
	* config.php -
	* v 1.0 RC4
	* configuration parameters for
	* non-SQL connectivity, i.e.
	* admin e-mail, updates, etc
	*
	*        development: Matt Saladna
	*        msaladna@apisnetworks.com
	*           (c) 2003 Apis Networks
	* $Id: config.php,v 1.1.1.1 2004/12/22 06:16:20 root Exp $
	*********************************/
	
	/****************************/
 	/**** MAIN CONFIGURATION ****/
	/****************************/
	
	/*
	* apnscp installed on another box
	* or bound to a different port? 
	* then change it.
	*/
	$apnscpPort = "50015";
	$apnscpHost = "localhost";
	
	// send a dump of the code
	// whenever an error is generated
	// (keep this on for the beta)
	$notifyErrors = false;
	
	// defines whether to use a modified
	// error logging mechanism for use with
	// dissecting problems - this replaces
	// the stock PHP error handling feature
	// with the user-defined one (see error.php)
	$useBetterErrorLogging = false;
	
	
	/****************************/
 	/*** CUSTOM MODULE CONFIG ***/
	/****************************/
	
	/*
	*  enable Traceroute on the 
	*  site/user levels, same goes
	*  for whois, on the site/user levels
	*/
	$tracerouteEnabled['site'] = true;
	$tracerouteEnabled['user'] = true;
	$whoisEnabled['site'] = true;
	$whoisEnabled['user'] = true;
	
	// enable MIME management?
	$mimeEnabled = true;
	
	// allow users to install/uninstall
	// FrontPage Server Extensions?
	$frontpageControl = true;
	
	// will we be showing the bandwidth
	// bar for the Appliance Administrator?
	$bwBar = true;
	
	// what is your limitation on
	// bandwidth per month (for use with bandwidth bar)?
	// --UNITS MUST BE EXPRESSED IN KILOBYTES--
	// kilobytes=GB     MB     KB
	// |      |      |
	$bwTotal = 1200 * 1024 * 1024 * 1024;
	
	// log location of the mrtg 
	// bandwidth usage log
	// if you're a RS customer
	// it _is_ URL safe, read the documentation
	// regarding that
	$bwLog = "/var/www/html/mrtg/index.log";

	// use the billing system?
	$billingEnabled = true;
	
	// enable trouble ticket interface
	// for customers?
	$ttEnabled = true;
	
	// $ttemail defines to whom we'll
	// dispatch a new trouble ticket.
	$ttEmail = "support@apisnetworks.com";
	
	// tag-line appended to trouble ticket
	// e-mails
	$ttTagLine = "Thank you for choosing Apis Networks";
	
	// tagline for the MySQL warning
	// e-mail message
	$mysqlWarningTag = "Apis Networks\nsupport@apisnetworks.com";
	
	// Urchin 5 installed?
	$urchin4Enabled = true;
	
	// URL to Urchin 5 front-end
	$urchin4Path = "https://urchin.vector.apisnetworks.com/";
	
	/*
	* osCommerce installed?
	* we check for osCommerce if Miva Merchant
	* is installed too, change to suit your need
	*/
	$oscommerceEnabled = true & isset($_COOKIE['mivamerchant_enabled']) ? ($_COOKIE['mivamerchant_enabled'] && file_exists('/home/virtual/'.$gDomainName.'/var/www/oscommerce/')) : 0;
	
	// standard URL for a domain where the osCommerce store-front is installed
	$oscommercePath = "http://".$gDomainName."/osCommerce/";
	
	// path to SquirrelMail, your distribution
	// will vary from ours, default path is 
	// http://domain.com/squirrelmail/       
	$squirrelmailPath = "http://mail.".$gDomainName;
    $hordePath        = "http://horde.".$gDomainName;
	
	
	/****************************/
 	/*** POSTGRESQL AND MYSQL ***/
	/****************************/
	
	// phpMyAdmin installed?
	$phpmyadminEnabled = true;
	
	// allow MySQL Cronjobs?
	$mysqlcronjobEnabled = true & isset($_COOKIE['mysql_enabled']) ? $_COOKIE['mysql_enabled'] : 0;
	
	// path to phpMyAdmin
	$phpmyadminPath = "http://vector.apisnetworks.com/MyAdmin/";
	
	//  enabled PostgreSQL accounts?
	$postgresqlEnabled = true & (stristr($_COOKIE['ocw_username'],"@") && IsAdmin($gDomainName,$gUserName) ) ? PostgresqlInstalled($gDomainName) : 0 ;
	
	// allow PostgreSQL Cronjobs?
	$pgsqlcronjobEnabled = true & $postgresqlEnabled;
	
	/*
	* setting this value to true will
	* assume that the login of the user
	* is the same as the PostgreSQL account
	* if set to false, user aliases MUST
	* be obtained through the pgsqlhash.php
	* file
	*/
	$lazyPostgresqlAssume = true;
	
	// phpPgAdmin installed?
	$phppgadminEnabled = true & $postgresqlEnabled;
	
	// path to phpPgAdmin
	$phppgadminPath = "http://vector.apisnetworks.com/phpPgAdmin/";
	
	
	/****************************/
 	/******  MISCELLANEOUS ******/
	/****************************/
	
	/* 
	* have mod_python and mod_dtcl
	* installed on the box?
	* probably not.
	*/
	$modpythonEnabled = false;
	$moddtclEnabled = false;

	/*
	* whether or not you have a
	* http://yorudomain.com/~username
	* to 
	* http://username.yourdomain.com alias
	*/
	$subdomainAliases = true;
	
	/*
	* do a check to see if you're running
	* the latest version of apnscp
	* and the latest version of WEBppliance?
	* -NOT YET IMPLEMENTED-
	* it just prints the version as of RC4-2
	*/
	$apnscpCheck = true;
	$ensimCheck = true;
?>
