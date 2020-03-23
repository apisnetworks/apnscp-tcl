<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/adminfunctions.php";
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<LINK REL="stylesheet" href="https://<?php print($_SERVER['HTTP_HOST']); ?>/stylesheet/" type="text/css">
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
</HEAD>
<BODY background="/images/menubg.gif" leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR> 
      <TD class=bar vAlign=top height="100%" style="padding-left:5px; background-color:transparent;"><p></p>&nbsp;<BR>
		  <BR>
          <B><A href="/webhost/view_shortcuts" target=main class=bar>Appliance Administrator</A></B><BR>
		  <B><A href="/webhost/appliance/provisions/applsummary.php" target=main class=bar>Appliance Summary</A></B>
          <br>
		  <B>Sites</B><br>
		  &nbsp;<A href="/webhost/services/virtualhosting/index_html" target=main class=bar>List Sites</A><BR>
		  &nbsp;<A href="/webhost/services/virtualhosting/view_plans" target=main class=bar>Plan List</A><BR>
		  &nbsp;<A href="/webhost/services/virtualhosting/form_addDomain?namebased=0" target=main class=bar>Add IP-Based Site</A><BR>
		  &nbsp;<A href="/webhost/services/virtualhosting/form_addDomain?namebased=1" target=main class=bar>Add Name-Based Site</A><BR>
		  &nbsp;<A href="/webhost/services/virtualhosting/form_addPlan" target=main class=bar>Add Service Plan</A><BR>
          <B>Resellers</B><br>
		  &nbsp;<A href="/webhost/services/reseller/" target=main class=bar>Reseller List</A><BR>
		  &nbsp;<A href="/webhost/services/reseller/view_site_list" target=main class=bar>Reseller Site List</A><BR>
		  &nbsp;<A href="/webhost/services/reseller/form_add_reseller" target=main class=bar>Add Reseller</A><BR>
		  <B>Web and E-Mail</B><br>
          &nbsp;<A href="/webhost/services/apache/index_html" target=main class=bar>Web Configuration</A><BR>
          &nbsp;<A href="/webhost/services/apache/view_ssl" target=main class=bar>SSL Configuration</A><BR>
          &nbsp;<A href="/webhost/services/apache/view_logs" target=main class=bar>Web Log Files</A><BR>
          &nbsp;<A href="/webhost/services/sendmail/view_settings" target=main class=bar>E-Mail Configuration</A><BR>
          &nbsp;<A href="/webhost/services/sendmail/sendmail_spam" target=main class=bar>Spam Filters</A><BR>
		  <B>FTP and DNS</B><br>
          &nbsp;<A href="/webhost/services/proftpd/index_html" target=main class=bar>FTP Configuration</A><BR>
		  &nbsp;<A href="/webhost/services/bind/index_html" target=main class=bar>DNS Configuration</A><BR>
		  &nbsp;<A href="/webhost/services/bind/list_zones" target=main class=bar>List Zones</A><BR>
		  <B>Backup and Restore</B><br>
          &nbsp;<A href="/webhost/services/vhbackup/" target=main class=bar>Backup</A><BR>
		  &nbsp;<A href="/webhost/services/vhbackup/form_appliance_conf_bk" target=main class=bar>Appliance Backup</A><BR>
		  &nbsp;<A href="/webhost/services/vhbackup/form_appliance_restore_ftp" target=main class=bar>Restore</A><BR>
		  <b>Ensim and apnscp</b><br>
		  &nbsp;<A href="/webhost/services/appliance/index_html" target=main class=bar>Network Settings</A><BR>
		  &nbsp;<A href="/webhost/appliance/view_diskusage" target=main class=bar>Disk Usage</A><BR>
		  &nbsp;<A href="/webhost/appliance/provisions/mysqlusage.php" target=main class=bar>MySQL Usage</A><BR>
		  &nbsp;<A href="/webhost/services/bandwidth/" target=main class=bar>Bandwidth Usage</A><BR>
		  &nbsp;<A href="/webhost/appliance/view_time" target=main class=bar>System Time</A><BR>
		  &nbsp;<A href="/webhost/appliance/form_editsupport" target=main class=bar>Change Administrator</A><BR>
		  &nbsp;<A href="/webhost/appliance/view_license" target=main class=bar>WEBppliance License</A><BR>
		  &nbsp;<A href="/webhost/appliance/provisions/viewapnscp.php" target=main class=bar>apnscp License</A><BR>
		  &nbsp;<A href="/webhost/services/index_html" target=main class=bar>Service Status</A><BR>
		  &nbsp;<A href="/webhost/services/appliance/view_reboot" target=main class=bar>Restart/Reboot</A><BR>
		  <p></p>
		  <?php
		  if ($billingEnabled) {
		  ?>
          <b><a href="/webhost/appliance/provisions/billing.php" target=main class=bar>Billing</a></b><br>
		  <?php
		  }
		  if ($ttEnabled) {
		  ?>
		  <b><a href="/webhost/appliance/provisions/troubleticket.php" target=main class=bar>Trouble Tickets</a></b><br>
		  <?php
		  }
		  ?>
          <B><A href="/docs/en_US/appliance/web31appl.htm" target="_blank" class=bar>Help</A></B><BR>
          <B><A href="/webhost/manage_logout?relogin=webhost/rollout/welcome" target="_top" class=bar>Logout</A></B><BR>
          </TD>
    </TR>
	</TBODY>
</TABLE>
</BODY>
</HTML>
