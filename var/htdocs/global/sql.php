<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/* 
	* MySQL/PostgreSQL connectivity for the apnscp
	* Please edit this fully to reflect accounts
	* created on MySQL and PostgreSQL
	*/
	
	/********************************************
	*  THE FIRST THREE SETS OF USERS ARE FOR USE
	*  WITH CRONJOBS ONLY -- THE LAST ONE IS ALL 
	*  OTHER CONNECTIVITY
	********************************************/
	
	/* $sql['cronjobs'] is used for connections 
	*  to whichever database for storing and 
	*  retrieving cronjob information for MySQL
	*  and PostgreSQL cronjobs
	*/
	$sql['cronjobs']['username'] = "";
	$sql['cronjobs']['password'] = "";
	$sql['cronjobs']['database'] = "apis";
	
	/*
	* the database user is used to obtain database
	* records for a given username - PLEASE only
	* grant select permissions on the "mysql" database -> "db" table:
	* grant select on mysql.db to someuser@localhost identified by 'somepassword';
	*/
	$mysql['databases']['username'] = "";
	$mysql['databases']['password'] = "";
	$mysql['databases']['database'] = "mysql"; // DO NOT change this
	
	/*
	* PostgreSQL connectivity to the pgsql
	* db for determining dbs a user may have
	* please don't use this option unless
	* you know how to add a _RESTRICTED_ user
	* to PostgreSQL (i.e. only SELECT on pg_user AND pg_database)
	*/
	
	$pgsql['databases']['username'] = "";
	$pgsql['databases']['password'] = "";
	$pgsql['databases']['database'] = "";
	
	/*
	* all other non-cronjob connectivity
	*/
	$mysql['standard']['username'] = "";
	$mysql['standard']['password'] = "";
	$mysql['standard']['database'] = "apis";

?>
