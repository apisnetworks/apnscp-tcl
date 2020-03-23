<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/*
	* mysqlhash.php is used to add additional aliases to 
	* users for whom there are no entries listed in 
	* /etc/virtualhosting/mappings/mysql.usermap
	* this should only be used IF you manually added a new
	* user to MySQL
	*
	* standard format:
	* $mysqlhash['MYSQLUSERNAME'] = siteN;
	* 	example:
	* 		$mysqlhash['foobar'] = "site12";
	*
	*/
	$mysqlhash['xthemanx'] = "site37";
	$mysqlhash['youth']    = "site40";
	$mysqlhash['jmd']      = "site14";
	$mysqlhash['orion']    = "site21";
	$mysqlhash['ffaddict_forums'] = "site2";
	$mysqlhash['mymail']   = "site40";
	$mysqlhash['agdn']     = "site40";
?>
