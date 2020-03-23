<?php
        /* Copyright 2003 Apis Networks
        *  Please read the attached LICENSE
        *  included within the distribution
        *  for further restrictions.
        */
        /*
        * pgsqlhash.php is used to add additional aliases to
		* domain names, please be aware that if $lazyPostgresqlAssume 
		* is set to true, then it is automatically assumed the login
		* name of the user ($gUserName) is the owner of a database and
		* therefore should not be added in here
		*
		* Since there is no pre-existing alias table - as with MySQL -
		* all users must explicitly be added to here, especially 
		* if $lazyPostgresqlAssume is not set to true.
        *
        * standard format:
        * $pgsqlhash['PGSQLUSERNAME'] = siteN;
        *       example:
        *       $pgsqlhash['foobar'] = "site12";
        *
        */
        //$pgsqlhash['apis'] = "site3";
		//$pgsqlhash['root'] = "site2";
?>