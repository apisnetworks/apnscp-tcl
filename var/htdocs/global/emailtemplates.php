<?php
/* Copyright 2003 Apis Networks
*  Please read the attached LICENSE
*  included within the distribution
*  for further restrictions.
*/
/* 
* this is the template for the basic
* trouble ticket e-mail
* modify at your own discretion.
*/
$date = date("M j Y g:i:s A",time());
@$description = stripslashes($_POST['description']);
@$resolution = stripslashes($_POST['resolution']);
@$troubleticketTemplate = <<<TXT
The trouble ticket you opened has been modified.
The following notes were appended to it on {$date}:
------------------------
{$resolution}
------------------------
in response to your original trouble ticket statement:
------------------------
{$description}
------------------------
You may log into the control panel and view the status of the ticket.

{$ttTagLine}
{$ttEmail}
TXT;

@$category = stripslashes($_POST['ttcategory']);
@$newttTemplate = <<<TXT
Trouble ticket information:
Domain: {$gDomainName}
Username: {$gUserName} 
Time: {$date}
Category: {$category}
Description: {$description}
TXT;

/*
* E-mail template for issuing
* immediate MySQL usage warnings
* from the 'Issue Warning' button
*/
@$mysqlwarning = <<<TXT
This e-mail has been sent to notify you that your MySQL
usage on database {$_GET['dbname']} for domain {$_GET['domain']} is
exceeding normal usage constraints which we permit.  The current
size of the database is approximately {$_GET['size']}.  Due
to the system which cannot count MySQL usage towards one's quota, 
the e-mail sent to you, on behalf of us is to warn you that 
your MySQL quota is nearing a point where administrative action 
will be taken if size cannot be reduced.

Thank you,
{$mysqlwarningtag}
TXT;

/*
* Template for use with MySQL warning
* cronjob
*/
@$cronjobmysqlwarn = <<<TXT
This e-mail has been sent to notify you that your MySQL
usage on database {$mDb} for domain {$mDomain} is
exceeding normal usage constraints which we permit.  The current
size of the database is approximately {$mSize} MB.  Due
to the system which cannot count MySQL usage towards one's quota, 
the e-mail sent to you, on behalf of us is to warn you that 
your MySQL quota is nearing a point where administrative action 
will be taken if the size is not reduced.

Thank you,
{$mysqlwarningtag}
TXT;
?>