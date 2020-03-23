<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/userfunctions.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
<BODY style="background: url('/images/navleft.gif') left repeat-y;" bgcolor="#E6E6DC" leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<div ID="topdeck" style="position:absolute; visibility:hide;"></div>
<SCRIPT language="javascript" src="/rollover.js" type="text/javascript"></SCRIPT>
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR> 
      <TD class=bar vAlign=top height="100%" style="padding-left:5px; background-color:#E6E6DC;"><p></p>&nbsp;<BR>
		<B><A 
      href="/webhost/services/virtualhosting/useradmin/view_shortcuts" target=main class=bar>User 
		Adminstrator</A></b><BR>
		<b><a href="/webhost/services/virtualhosting/useradmin/provisions/usersummary.php" target=main class=bar>User 
		Summary</a></b><br>
		<br>
          <?php
	  	  if ($_COOKIE['sendmail_enabled']) {
			  ?>
			  <strong>Email</strong><BR>
			  &nbsp;<a class=bar href="/webhost/services/virtualhosting/useradmin/services/sendmail/sendmail_aliases" target=main>Aliases</a><br>
			  &nbsp;<a class=bar href="/webhost/services/virtualhosting/useradmin/services/sendmail/sendmail_responders" target=main>Responders</a><br>
			  &nbsp;<a class=bar href="/webhost/services/virtualhosting/useradmin/services/vacation/useremail_vacation" target=main>Vacation 
			  Message</a><br>
			  &nbsp;<a class=bar href="/webhost/services/virtualhosting/useradmin/services/vacation/useremail_forward" target=main>Forwarding</a> 
			  <?php
			  if ($_COOKIE['sqmail_enabled']) {
				?>
				  <br>
				  &nbsp;<A href="http://<?php print($gDomainName); ?>/squirrelMail/" target="_blank" class=bar>Web Mail Login</A> <br>
			
			  <?php
			  }
		  }
	  	  ?>
          <strong>Tools</strong><br>
		  <?php
		  if ($tracerouteEnabled['user']) {
		  ?>
		  &nbsp;<A href="/webhost/services/virtualhosting/useradmin/provisions/traceroute.php" target=main class=bar>Traceroute</a><BR>
		  <?php
		  } 
		  if ($whoisEnabled['user']) {
		  ?>
		  &nbsp;<A href="/webhost/services/virtualhosting/useradmin/provisions/whois.php" target=main class=bar>Whois</a><BR>
		  <?php
		  }
		  if ($_COOKIE['vhbackup_enabled']) {
		  ?>
          &nbsp;<A href="/webhost/services/virtualhosting/useradmin/services/vhbackup/form_stream_bk" target=main class=bar>Backup</a><BR>
          &nbsp;<A href="/webhost/services/virtualhosting/useradmin/services/vhbackup/form_restore_ftp" target=main class=bar>Restore</A><br>
		  <?php
		  }
		  ?>
          &nbsp;<A href="/webhost/services/virtualhosting/useradmin/userinfo/" target=main class=bar>Change Information</A> <br>
          <br>
          <strong><A href="/docs/en_US/user/user_help.htm" target="_blank" class=bar>Help</A></strong><BR>
          <A href="javascript:top('/webhost/services/virtualhosting/useradmin/manage_logout?relogin=webhost/rollout/site');" class=bar><strong>Logout</strong></A><BR></B>
          </TD>
    </TR>
  </TBODY>
</TABLE>
</BODY>
</HTML>
