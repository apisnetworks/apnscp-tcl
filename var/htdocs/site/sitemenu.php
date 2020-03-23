<?php 
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
<BODY style="background: url('/images/navleft.gif') left repeat-y;"  bgcolor="#E6E6DC" leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<div ID="topdeck" style="position:absolute; visibility:hide;"></div>
<SCRIPT language="javascript" src="/rollover.js" type="text/javascript"></SCRIPT>
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD class=bar vAlign=top height="100%" style="padding-left:5px; background-color:#E6E6DC;"><p></p>&nbsp;<BR>
		<B><A href="/webhost/services/virtualhosting/siteadmin/view_shortcuts/index_html" target=main class=bar>Site Administrator</A></B><BR>
		<B><A href="/webhost/services/virtualhosting/siteadmin/siteinfo/index_html" target=main class=bar>Site Summary</A></B><br>
		<?php
		// feel free to change this if you'd like.
		if ($gUserName != "demosite") { 
		?>
		<strong><a href="/webhost/services/virtualhosting/siteadmin/siteinfo/form_editAdmin" class=bar target=main>Change 
		Administrator</a></strong><br>
		<br>
		<?php 
		} 
		?>
		<B>Users</B><br>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/users/form_adduser" target=main class=bar>Add User</a><br>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/users/index_html" target=main class=bar>Manage Users</a><br>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/users/form_template" target=main class=bar>Set User Defaults</a><br>
		<?php
		if ($_COOKIE['mysql_enabled'] && !IsHidden("mysql")) {
			?>
			<B>MySQL</b><br>
			<?php
			if ($_COOKIE['mysql_enabled'] && !IsHidden("mysql")) {
				?>
				&nbsp;<a href="<?php print($phpmyadminPath); ?>" target="_blank" class=bar>phpMyAdmin</a><br>
				&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/webhost/services/virtualhosting/siteadmin/services/mysql/form_mysqlsitepass" target=main class=bar>Change 
				Password</a><br>
				<?php
				if ($mysqlcronjobEnabled) {
					?>
					&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/mysqlcronjob.php" target=main class=bar>MySQL Cronjob</a><br>
					<?php
				}
			}
		}
		if ($postgresqlEnabled) {
			?>
			<B>PostgreSQL</b><br>
			&nbsp;<a href="<?php print($phppgadminPath); ?>" target="_blank" class=bar>phpPgAdmin</a><br>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/changepgpass.php" target=main class=bar>Change Password</a><br>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/postgresqlcronjob.php" target=main class=bar>PostgreSQL Cronjob</a><br>
		<?php
		}
		?>
		<strong>Site Tools</strong><BR>
		<?php
		if ($tracerouteEnabled['site']) {
		?>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/traceroute.php" target=main class=bar>Traceroute</a><br>
		<?php
		}
		if ($whoisEnabled['site']) {
		?>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/whois.php" class=bar target=main>Whois</a><br>
		<?php
		}
		if ($_COOKIE['vhbackup_enabled']) {
		?>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/vhbackup/form_stream_bk" class=bar target=main>Backup</a>/<a href="/webhost/services/virtualhosting/siteadmin/services/vhbackup/form_restore_ftp" class=bar target=main>Restore</a><br>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/vhbackup/form_appliance_scheduled_bk" class=bar target=main>Scheduled Backup</a><br />
		fg<?php
		}
		if ($_COOKIE['files_enabled']) {
		?>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/files/" target=main class=bar>File 
		Manager</a><br>
		<?php
		}
		if ($urchin4Enabled) {
		?>
		&nbsp;<a href="<?php print($urchin4Path); ?>" target="_blank" class=bar>Urchin 
		5 Statistics</a><br>
		<?php
		}
		?>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/bandwidth.php" target="main" class=bar>Bandwidth History</a><br>
		<?php
		if ($_COOKIE['apache_enabled'] && !IsHidden("apache")) {
		?>
		<B>Apache</B><BR>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/apache/index_html" target=main class=bar>View Configuration</a><br>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/apache/view_logs" target=main class=bar>View Logs</a><br>
		<?php
		if ($mimeEnabled) {
		?>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/mimetypes.php" target=main class=bar>Manage MIME Types</a><br>
		<?php
		}
			if ($frontpageControl) {
			?>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/provisions/enablefp.php" target=main class=bar><?php ($_COOKIE['frontpage_enabled']) ? print('Disable') : print('Enable'); ?> FrontPage</a><br>
			<?php
			}
		}
		if ($_COOKIE['frontpage_enabled'] && $_COOKIE['apache_enabled'] && !IsHidden("apache")) {
			?>
			&nbsp;<a href="http://<?php print($gDomainName); ?>/_vti_bin/_vti_adm/fpadmcgi.exe?page=webadmin.htm" target="_blank" class=bar>FrontPage Management</a><br>
			<?php
		} else if ($_COOKIE['apache_enabled'] && !$_COOKIE['frontpage_enabled'] && !IsHidden("apache")) {
			?>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/apache/view_security" target=main class=bar>Protect Directories</a><br>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/apache/form_htpasswd" target=main class=bar>Manage Users</a><br>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/apache/form_htgroup" target=main class=bar>Manage Groups</a><br>		
			<?php
		}
		if (!$_COOKIE['ipinfo_namebased']) { ?>
		&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/apache/view_ssl" target=main class=bar>SSL Configuration</a><br>
		<?php
		}
		if ($_COOKIE['sendmail_enabled'] && !IsHidden("sendmail")) {
			?>
			<B>Email</B><BR>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/sendmail/index_html" target=main class=bar>Aliases</A><BR>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/sendmail/sendmail_responders" target=main class=bar>Responders</A><br>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/sendmail/sendmail_spam" target=main class=bar>Spam Filters</A><br>
			<?php
			if ($_COOKIE['majordomo_enabled']) {
				?>
				&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/majordomo/index_html" target=main class=bar>Manage Majordomo</a><br>
		<?php
			}
			if ($_COOKIE['sqmail_enabled']) {
				?>
		&nbsp;<a href="http://<?php print($gDomainName);?>/squirrelMail" class=bar target="_blank">Web 
		Mail Interface</a><br>
				<?php
			}
		}
		if ($_COOKIE['mivamerchant_enabled'] && !IsHidden('mivamerchant') || $oscommerceEnabled) {
			?>
			<strong>E-Commerce</strong> <br>
			<?php
			if ($_COOKIE['mivamerchant_enabled'] && !IsHidden('mivamerchant')) {
			?>
			
			&nbsp;<a href="http://<?php print($gDomainName); ?>/Merchant2/admin.mv?" target="main" class=bar>Miva Merchant Admin</a><br>
			&nbsp;<a href="/webhost/services/virtualhosting/siteadmin/services/mivamerchant/" class=bar target=main>Miva Merchant Config</a><br>
			&nbsp;<a href="http://<?php print($gDomainName); ?>/Merchant2/merchant.mv?" class=bar target="_blank">Miva Merchant</a><br>
		<?php
			}
			if ($oscommerceEnabled) {
				?>
		&nbsp;<a href="<?php printf("%s/admin/",rtrim($oscommercePath,"/")); ?>" class=bar target=main>osCommerce 
		Admin</a><br>
				&nbsp;<a href="<?php printf("%s/catalog/",rtrim($oscommercePath,"/")); ?>" class=bar target="_blank">osCommerce</a><br>
				<?php 
			} 
		}
		?>
		<br />
		<?php
		if ($ttEnabled) {
		?>
		<a href="/webhost/services/virtualhosting/siteadmin/provisions/troubleticket.php" target=main class=bar><strong>Trouble Tickets</strong></a><br>
		<?php
		}
		if ($billingEnabled) {
		?>
		<a href="/webhost/services/virtualhosting/siteadmin/provisions/billing.php" class=bar target=main><strong>Billing History</strong></a><br>
		<?php
		}
		?>
		<A href="/docs/en_US/site/site_help.htm" target="_blank" class=bar><strong>Help</strong></A><BR>
		<A href="javascript:top('/webhost/services/virtualhosting/siteadmin/manage_logout?relogin=webhost/rollout/site');" class=bar><strong>Logout</strong></A><BR></B> 
		
	</TD>
  </TR>
  </TBODY>
</TABLE>
</BODY>
</HTML>
