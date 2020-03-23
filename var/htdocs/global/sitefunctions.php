<?php
	/********************************
	* sitefunctions.php -
	* v 1.0 RC4-2
	* functions for site admins ONLY
	*
	*        development: Matt Saladna
	*        msaladna@apisnetworks.com
	*           (c) 2003 Apis Networks
	* $Id: sitefunctions.php,v 1.1.1.1 2004/12/22 06:16:20 root Exp $
	*********************************/
	include_once "functions.php";
	
	/*
	* returns whether PostgreSQL 
	* is enabled for account
	*************************
	* :KLUDGE:
	* the implementation is ugly at best
	* and another method should be found for checking
	*************************
	*/
	function PostgresqlInstalled($mDomain) {
		return file_exists("/home/virtual/".$mDomain."/usr/bin/psql");
	}
	
	/*
	* returns number of users for a domain
	*/
	function GetUserAmount($mDomain) {
		$userCount = 0;
		if ($fp = @fopen("/home/virtual/".$mDomain."/etc/passwd","r")) 
			while (!feof($fp)) {
				$data = fgets($fp);
				$userCount++;
			}
		else 
			return ERROR;
		@fclose($fp);
		return $userCount;
	}
	
	/*
	* returns the aliases
	* a domain may contain
	*/
	function GetDomainAliases($mDomain) {
		$aliases = "";
		$i = 0;
		$siteMap = GetAdmin($mDomain);
		if ($fp = @fopen("/etc/virtualhosting/mappings/domainmap","r")) 
			while (!feof($fp)) {
				$data = trim(fgets($fp));
				if (ereg("^(.+) = ".$siteMap."$", $data, $matches)) {
					if ($matches[1] == $mDomain) continue;
					$aliases[$i] = $matches[1];
					$i++;
				}
			}
		else 
			return ERROR;
		@fclose($fp);
		return $aliases;
	}
	
	/*
	* returns existing spam filters for a given domain
	*/
	 function GetSpamFilters($mDomain,&$rmSpamFilters) {
		 $fp = @fopen("/home/virtual/".$mDomain."/etc/mail/access", "r");
		 $i = 0;
		 if ($fp)
				while (!feof($fp)) {
					$line = trim(fgets($fp));
					/* may want to add REJECT/NNN Message/RELAY/OK later */
					if (eregi("^([a-zA-Z0-9\.@-]+)",$line, $regs)) {
						$rmSpamFilters[$i] = $regs[1];
						$i++;
					}
				}
			@fclose($fp);
			return;	
	 }

	/*
	* returns CGI Alias for a domain
	*/
	function GetCGIAlias($mDomain) {
		$fp = @fopen("/etc/httpd/conf/".GetAdmin($mDomain)."/cgi", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = trim(fgets($fp));
				if (eregi("^ScriptAlias[[:space:]]+([a-zA-Z0-9\./-]+)[[:space:]]+.+$",$line, $regs)) {
					// found
					@fclose($fp);
					return $regs[1];
				}
			}
		@fclose($fp);
		return "";	
	}
	
	/*
	* returns Perl Alias for a domain
	*/
	function GetPerlAlias($mDomain) {
		$fp = @fopen("/etc/httpd/conf/".GetAdmin($mDomain)."/mod_perl", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = trim(fgets($fp));
				if (eregi("Alias[[:space:]]+([a-zA-Z0-9\./-]+)[[:space:]]+.+$",$line, $regs)) {
					// found
					@fclose($fp);
					return $regs[1];
				}
			}
		@fclose($fp);
		return "";	
	}
	
	/*
	* check for anonymous FTP support
	* for a given domain
	*/
	function AnonFtpEnabled($mDomain) {
		$fp = @fopen("/home/virtual/".$mDomain."/etc/passwd", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = trim(fgets($fp));
				if (ereg("^ftp:", $line)) {
					@fclose($fp);
					return 1;
				}
			}
		@fclose($fp);
		return 0;
	}
	
	/*
	* reads MIME types from /etc/mime.types
	* and from /home/virtual/$gDomainName/var/www/html/.htaccess
	* if there's no public read bit set, then it returns nada
	*/
	function GetMimeTypes($mDomain,&$rmGlobalMimes,&$rmLocalMimes) {
		/* first let's populate the $rmGlobalMimes variable */
		$fp = @fopen("/etc/mime.types", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = trim(fgets($fp));
				if (ereg("^[a-zA-Z0-9/\.-]+[[:space:]]+[a-zA-Z0-9/\.-]+",$line)) {
					// it has an associated extension, ugly regexp though
					$data = split("[[:space:]]+",$line);
					$rmGlobalMimes[join(" ",array_slice($data,1))] = $data[0];
				}
			}
		@fclose($fp);
		/* next step, see if there are any locals */
		$fp = @fopen("/home/virtual/".$mDomain."/var/www/html/.htaccess", "r");
		if ($fp)
			while (!feof($fp)) {
				$line = fgets($fp);
				if (eregi("^AddType[[:space:]]+[a-zA-Z0-9\./-]+[[:space:]]+[a-zA-Z0-9]+$",trim($line))) {
					// it has an associated extension, ugly regexp though
					$data = split("[[:space:]]+",$line);
					$rmLocalMimes[join(" ",array_slice($data,2))] = $data[1];
				}
			}
		@fclose($fp);
		return;
	}
	
	/*
	* best check I can think of to check
	* whether or not a site has development
	* libs installed.
	*/
	function DevelopmentEnabled($mDomain) {
		return file_exists("/home/virtual/".$mDomain."/usr/bin/gcc");
	}
	
	/*
	* returns all aliases that a particular domain holds
	* differs from the MysqlAliases() in adminfunctions.php
	* in that it requires a single parameter, $mDomain, to
	* return for _only_ that site.
	*/
	function MysqlAliases($mDomain) {
		global $mysqlhash;
		$aliases = array();
		$siteAdmin = GetAdmin($mDomain);
		// get a quick domain translation		
		$fp = @fopen("/etc/virtualhosting/mappings/mysql.usermap", "r");
		$i = 0;
		if ($fp) {
			while (!feof($fp)) {
				$line = trim(fgets($fp));
				if (ereg("^([a-zA-Z0-9]+) = ".$siteAdmin."$",$line,$regs)) {
					$aliases[$i] = $regs[1];
					$i++;
				}
			}
		}
		@fclose($fp);
		// now the additional $mysqlhash mappings
		if (isset($mysqlhash)) {
			foreach($mysqlhash as $key => $val) {
				$hashedDomain = GetDomain($val);
				if ($hashedDomain == $mDomain) {
					$aliases[$i] = $key;
					$i++;
				}
			}
		}
		return $aliases;
	}
	
	/*
	* returns all aliases that a particular domain holds
	* for a PostgreSQL account, there is no equivalent in
	* the adminfunctions.php
	*/
	function PostgresqlAliases($mDomain) {
		global $pgsqlhash, $lazyPostgresqlAssume, $gUserName;
		$siteAdmin = GetAdmin($mDomain);		
		$i = 0;
		if ($lazyPostgresqlAssume) {
			$aliases[$i] = $gUserName;
			$i++;
		}
		// now the additional $mysqlhash mappings
		if (isset($pgsqlhash)) {
			foreach($pgsqlhash as $key => $val) {
				$hashedDomain = GetDomain($val);
				if ($hashedDomain == $mDomain) {
					$aliases[$i] = $key;
					$i++;
				}
			}
		}
		return $aliases;
	}
?>
