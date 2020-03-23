<?php 
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/**********************************************
	 * Basic front-end skin for appliance administrators
	 * Please read the attached "LICENSE" file for
	 * further licensing information and indemnifications
	 * any modifications done to the view_shortcuts.php 
	 * is not covered through support, modify at 
	 * your own risk.
	 *                       (c) 2003 Apis Networks
	 * -packaged for use with apnscp 1.0 RC4-2-
	 **********************************************/
	 
	 /* 
	 * functions native to appliance administrator
	 * are derived from ../global/adminfunctions.php
	 */
	include "../global/adminfunctions.php";
	Login();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
</HEAD>
<BODY bgColor=#ffffff leftMargin=5 topMargin=5 marginheight="5" marginwidth="5">
<div ID="topdeck" style="position:absolute; visibility:hide;"></div>
<SCRIPT language="javascript" src="/rollover.js" type="text/javascript"></SCRIPT>
<TABLE cellSpacing=2 cellPadding=2 width=640 border=0>
	<TR> 
		
    <TD class=header height=22 colSpan=2>Appliance Information</TD>
    </TR>
	<tr>
		<TD class=<?php print(SwitchCellColors()); ?>><B>Hostname:</B></TD>
		<TD class=<?php print(SwitchCellColors()); ?>><?php print($_SERVER['SERVER_NAME']); ?></TD>
	</tr>
	<tr>
		<TD class=<?php print(SwitchCellColors()); ?>><B>IP Address:</B></TD>
		<TD class=<?php print(SwitchCellColors()); ?>><?php print($_SERVER['HTTP_HOST']); ?></TD>
	</TR>
	<?php
		/* 
		* loop through and get the devices
		* and space, this could be moved over to a function
		* with an associative array holding values
		*/
		/* anchor matches to get only devices */
	 	$mounts = explode("\n",trim(shell_exec("/bin/df | grep ^/")));
		for ($i = 0; $i < sizeof($mounts); $i++) {
			$driveInfo = split("[[:space:]]+",$mounts[$i]);
			$unitUsed = $unitTotal = 1; // set the initial unit map to KB
			$usedSpace = $driveInfo[2]; 
			$totalSpace = $driveInfo[2]+$driveInfo[3];
			$percentage = $usedSpace/$totalSpace*100;
			// better resolution for the parenthesized percentage as opposed to the integer df reports as a percentage
			ChunkSize($usedSpace,$unitUsed);
			ChunkSize($totalSpace,$unitTotal);
			?>
			<tr>	
				<td class=<?php print(SwitchCellColors()); ?>><B>Disk Usage</B>&nbsp;<font style="font-size: smaller;">(<?php printf("%s on %s",$driveInfo[0],$driveInfo[5]); ?>)</font>:</td>
				<TD class=<?php print(SwitchCellColors()); ?>> 
					<table width="100%" cellpadding=0 cellspacing=0 border=0 style="border-width:0px;">
						<tr> 
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=right><img src="/images/bandwidthbarleft.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> width="<?php print(ceil($driveInfo[4]*2)); ?>"><img src="/images/bandwidthbar.gif" alt="" height=14 width="<?php print(ceil($driveInfo[4]*2)); ?>"></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> width="<?php print(ceil((100-$driveInfo[4])*2)); ?>"><img src="/images/bandwidthempty.gif" alt="" height=14 width="<?php print(ceil((100-$driveInfo[4])*2)); ?>"></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left><img src="/images/bandwidthbarright.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left>
								<?php printf("%.2f %s / %.2f %s <font style=\"font-size:smaller;\">(%.2f%%)</font>",$usedSpace, $gSpaceMapping[$unitUsed], $totalSpace, $gSpaceMapping[$unitTotal],$percentage); ?> 
							</td>
						</tr>
					</table>
				</TD>
			</tr>
			<?php
		}
		if ($bwBar) {
			$bwUsage = GetBandwidth();
			$unitUsed = $unitTotal = 0; // set the initial unit map to bytes
				?>
				<tr>	
					<td class=<?php print(SwitchCellColors()); ?>><B>Monthly Bandwidth Usage:</B></td>
					<TD class=<?php print(SwitchCellColors()); ?>> 
						<table width="100%" cellpadding=0 cellspacing=0 border=0  style="border-width:0px;">
						  <tr> 
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=right><img src="/images/bandwidthbarleft.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> width="<?php print(floor(($bwUsage/$bwTotal*100))*2+1); ?>"><img src="/images/bandwidthbar.gif" alt="" height=14 width="<?php print(floor(($bwUsage/$bwTotal*100))*2+1); ?>"></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> width="<?php print(floor((100-$bwUsage/$bwTotal*100))*2-1); ?>"><img src="/images/bandwidthempty.gif" alt="" height=14 width="<?php print(floor((100-$bwUsage/$bwTotal*100))*2-1); ?>"></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left><img src="/images/bandwidthbarright.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left>
								<?php
									ChunkSize($bwUsage,$unitUsed);
									ChunkSize($bwTotal,$unitTotal);
									printf("%.2f %s / %.2f %s <font style=\"font-size:smaller;\">(%.2f%%)</font>",$bwUsage,$gSpaceMapping[$unitUsed],$bwTotal,$gSpaceMapping[$unitTotal],($bwUsage/$bwTotal*100));
								?> 
							</td>
						  </tr>
						</table>
					</TD>
				</tr>
				<?php
		}
		if ($ttEnabled) {
			$ttOpen = -1;
			$ttTotal = -1;
			GetTTCount($ttOpen,$ttTotal);
		?>
		<tr>		
   		 	<td class=<?php print(SwitchCellColors()); ?>><B>Trouble Tickets:</B></td>
			<TD class=<?php print(SwitchCellColors()); ?>> 
				<table width="100%" cellpadding=0 cellspacing=0 border=0 style="border-width:0px;">
					<tr> 
						<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left>Opened:</td>
						<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left>&nbsp;<?php print($ttOpen); ?></td>
						<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left><img src="/images/spacer.gif" alt="" height=1 width=5 />|<img src="/images/spacer.gif" alt="" height=1 width=5 /></td>
						<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left>Total:</td>
						<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left>&nbsp;<?php print($ttTotal); ?></td>
						<td style="border-width:0px;" class=<?php print(SwitchCellColors(1)); ?> align=left width="100%"><img src="/images/spacer.gif" alt="" width="100%" height=1 /></td>
					</tr>
				</table>
			</TD>
		</tr>
		<?php
		}
		if ($apnscpCheck) {
		?>
		<tr>
			<td class=<?php print(SwitchCellColors()); ?>><strong>apnscp Version:</strong></td>
			<td class=<?php print(SwitchCellColors()); ?>><?php print(apnscpCheck()); ?></td>
		</tr>
		<?php
		} 
		if ($ensimCheck) {
		?>
		<tr>
			<td class=<?php print(SwitchCellColors()); ?>><strong>Ensim WEBppliance Version:</strong></td>
			<td class=<?php print(SwitchCellColors()); ?>><?php print(EnsimCheck()); ?></td>
		</tr>
		<?php
		}
		?>
</TABLE>
<P></P>
<TABLE cellSpacing=2 cellPadding=2 width=640 border=0>
  <TBODY>
    <TR> 
      <TD class=header height=22>Tip of the Day</TD>
    </TR>
    <TR> 
	<td style="border: 1px solid #53805C; background-image: url('/images/totd.gif'); background-repeat: no-repeat; background-position:bottom right;">
		<table width="100%"  cellSpacing=2 cellPadding=2 border=0>
			<tr>  
				<td class=cell1 style="background:transparent;">
					<?php print(nl2br(RandomTip("appliance"))); ?>
				</td>
			</tr>
			<tr>
				<td style="background:transparent;"><a href="view_shortcuts.php" onmouseover="status='Random Tip'; return true;" onmouseout="status=''; return true;">&gt;&gt; Random Tip</a></td>
			</tr>
		</table>
	</td>
	</tr>
    <tr> 
      <TD height=1></TD>
    </tr>
  </TBODY>
</TABLE>
<P></P>
<TABLE cellSpacing=2 cellPadding=2 width=640 border=0>
  <TBODY>
    <TR> 
      <TD class=header height=22 colSpan=5>Appliance Management</TD>
    </TR>
    <TR> 
     <td colspan=5>
	 	<table width="100%" cellpadding=0 cellspacing=0 style="border: 1px solid #53805C;">

          <!-- SITE RELATED OPTIONS -->
          <TR> 
	       <TD height="12" colspan=12 valign=middle class=subheader>Sites</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <TR> 
            <td width="2" height="60"><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD align=center height=80 width=121 vAlign=middle style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/services/virtualhosting/index_html';" 
				onMouseOver="rollon(this); status='Site List'; pop(1,'List all virtual and dedicated sites that exist in WEBppliance.','Site List');"  
				onMouseOut="rolloff(this); status=''; kill();"> 
              		<a href="/webhost/services/virtualhosting/index_html" onmouseover="status='Site List'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/list_sites.gif" alt="Site List" align=absMiddle border=0><br>
				            <B>Site List</B>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=121 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Plan List'; pop(2,'List plans you have created.','Plan List');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/virtualhosting/view_plans';"> 
              		<a href="/webhost/services/virtualhosting/view_plans" onmouseover="status='Plan List'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/plans.gif" alt="Plan List" align=absMiddle border=0><br>
              				<b>Plan List</b>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
            
          	<TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=122 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Add IP-Based Site'; pop(3,'Add a new site based upon a unique IP.','Add IP-Based Site');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/virtualhosting/form_addDomain?namebased=1';"> 
            		<a href="/webhost/services/virtualhosting/form_addDomain?namebased=0"  onmouseover="status='Add IP-Based Site'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/add_site_ip.gif" alt="Add IP-Based Site" align=absMiddle border=0><br>
            				<B>Add IP-Based<br>Site</B>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=122 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Add Name-Based Site'; pop(4,'Add a new virtual site.','Add Name-Based Site');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/virtualhosting/form_addDOmain?namebased=1';"> 
            		<a href="/webhost/services/virtualhosting/form_addDomain?namebased=1"  onmouseover="status='Set User Defaults'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/add_site.gif" alt="Add Name-Based Site" align=absMiddle border=0><br>
 			 	        	<B>Add Name-Based<br>Site</B>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          	<TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=122 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Add Service Plan'; pop(2,'Add a new service plan to assign to sites.','Add Service Plan');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/virtualhosting/form_addPlan';"> 
            		<a href="/webhost/services/virtualhosting/form_addPlan"  onmouseover="status='Add Service Plan'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/add_plan.gif" alt="Add Service Plan" align=absMiddle border=0><br>
            				<B>Add Service<br>Plan</B>
					</a>
			</TD>
          </tr>
          <tr> 
            <td colspan=12 height=5></td>
          </tr>
          <!-- END SITE RELATED OPTIONS -->

          <!-- RESELLER RELATED OPTIONS -->
          <TR> 
            <TD height="12" colspan=12 valign=middle class=subheader>Reseller Configuration </TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='Reseller List'; pop(1,'View all the resellers that belong to your box.','Reseller List');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller';"> 
              		<a href="/webhost/services/reseller" onmouseover="status='Reseller List'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/reseller_list.gif" alt="Reseller List" align=absMiddle border=0><br>
              				<b>Reseller<br>List</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='Reseller Site List'; pop(2,'List sites that resellers have added.','Reseller Site List');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/view_site_list';"> 
              		<a href="/webhost/services/reseller/view_site_list" onmouseover="status='Reseller Site List'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/resellersitelist.gif" alt="Reseller Site List" align=absMiddle border=0><br>
              				<b>Reseller Site<br>List</b>
					</a>
			</TD>
			<td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='Add Reseller'; pop(4,'Add a new reseller to your box.','Add Reseller');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/form_add_reseller';"> 
              		<a href="/webhost/services/reseller/form_add_reseller" onmouseover="status='Add Reseller'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/addreseller.gif" alt="Add Reseller" align=absMiddle border=0><br>
              				<b>Add Reseller</b>
					</a>
			</TD>
		    <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD></TD>
			<td><img src="/images/spacer.gif" width=2 alt=""></td>
			<td></td>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
			</tr>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END RESELLER RELATED OPTIONS -->

          <!-- SITE TOOL RELATED OPTIONS -->
          <TR> 
            <TD height="12" colspan=12 class=subheader>Web and E-Mail Configuration</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='Web Configuration'; pop(1,'View your Apache Web server configuration.','Web Configuration');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/apache/index_html';"> 
              		<a href="/webhost/services/apache/index_html"  onmouseover="status='Web Configuration'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/apache.gif" alt="Web Configuration" align=absMiddle border=0><br>
           					<b>Web<br>Configuration</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='SSL Configuration'; pop(2,'Manage your SSL certification for encrypted HTTP transfers.','SSL Configuration');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/apache/view_ssl';"> 
              		<a href="/webhost/services/apache/view_ssl" onmouseover="status='SSL Configuration'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/sslconfig.gif" alt="SSL Configuration" align=absMiddle border=0><br>
			            	<b>SSL<br>Configuration</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Web Log Files'; pop(3,'View the Apache raw log files for <em>only</em> the normal Apache server, ' +
				'i.e. not the virtual domain raw logs.','Web Log Files');"  onMouseOut="rolloff(this); status=''; kill();" 
				onClick="location.href='/webhost/services/apache/view_logs';"> 
              		<a href="/webhost/services/apache/view_logs" onmouseover="status='Web Log Files'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/raw.gif" alt="Web Log Files" align=absMiddle border=0><br>
              			<b>Web<br>Log Files</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='E-Mail Configuration'; pop(1,'Modify the default sendmail configuration.','E-Mail Configuration');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/sendmail/view_settings';"> 
              		<a href="/webhost/services/sendmail/view_settings" onmouseover="status='E-Mail Configuration'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/emailconfig.gif" alt="E-Mail Configuration" align=absMiddle border=0><br>
              				<b>E-Mail<br>Configuration</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='Spam Filters'; pop(2,'Manage the global spam filter policies, applied to all sites; this in no way affects local '+
				'sites\' spam filters.','Spam Filters');" onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/sendmail/sendmail_spam';"> 
              	<a href="/webhost/services/sendmail/sendmail_spam" onmouseover="status='Spam Filters'; return true;" 
					onmouseout="status=''; return true;">
						<IMG src="/images/spam_filters.gif" alt="Spam Filters" align=absMiddle border=0><br>
              			<b>Spam<br>Filters</b>
				</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          </TR>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END TOOL RELATED OPTIONS -->

		  <!-- FTP AND DNS RELATED OPTIONS -->
          <TR> 
            <TD height="12" colspan=12 class=subheader>FTP and DNS Configuration</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='FTP Configuration'; pop(1,'Configure the default ProFTPD settings.','FTP Configuration');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/proftpd/index_html';"> 
	            	<a href="/webhost/services/proftpd/index_html"  onmouseover="status='FTP Configuration'; return true;" 
						onmouseout="status=''; return true;"> <IMG src="/images/ftpserver.gif" alt="FTP Configuration" align=absMiddle border=0><br>
              				<b>FTP<br>Configuration</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='DNS Configuration'; pop(2,'Configure BIND\'s default settings, responsible for DNS service.','DNS Configuration');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/bind/index_html';"> 
              		<a href="/webhost/services/bind/index_html" onmouseover="status='DNS Configuration'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/bind.gif" alt="DNS Configuration" align=absMiddle border=0><br>
              			<b>DNS<br>Configuration</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='List Zones'; pop(3,'List and manage your DNS zones through BIND.','List Zones');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/bind/list_zones';"> 
              		<a href="/webhost/services/bind/list_zones" onmouseover="status='List Zones'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/listzones.gif" alt="List Zones" align=absMiddle border=0><br>
						<b>List Zones</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD></TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD></TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          </TR>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END FTP AND DNS OPTIONS -->

		  <!-- BACKUP AND RESTORE OPTIONS -->
          <TR> 
            <TD height="12" colspan=12 class=subheader>Backup and Restore</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='Backup'; pop(1,'Backup individual sites.','Backup');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/vhbackup/';"> 
	            	<a href="/webhost/services/vhbackup/"  onmouseover="status='Backup'; return true;" 
						onmouseout="status=''; return true;"> <IMG src="/images/data_backup.gif" alt="Backup" align=absMiddle border=0><br>
              				<b>Backup</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Appliance Backup'; pop(2,'Backup Ensim WEBppliance.','Appliance Backup');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/vhbackup/form_appliance_conf_bk';"> 
              		<a href="/webhost/services/vhbackup/form_appliance_conf_bk" onmouseover="status='Appliance Backup'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/applbackup.gif" alt="Appliance Backup" align=absMiddle border=0><br>
              			<b>Appliance<br>Backup</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Restore'; pop(3,'Restore your data from a previous backup.','Restore');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/vhbackup/form_appliance_restore_ftp';"> 
              		<a href="/webhost/services/vhbackup/form_appliance_restore_ftp" onmouseover="status='Restore'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/data_restore.gif" alt="Restore" align=absMiddle border=0><br>
						<b>Restore</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD></TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD></TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          </TR>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END BACKUP AND RESTORE OPTIONS -->

          <!-- BEGIN MANAGEMENT RELATED OPTIONS -->
          <TR> 
            <TD height="12" colspan=12 class=subheader>Ensim WEBppliance and apnscp Management</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Network Settings'; pop(2,'View the network settings of the box.','Network Settings');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/appliance/index_html';"> 
              		<a href="/webhost/services/appliance/index_html" onmouseover="status='Network Settings'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/network.gif" alt="Network Settings" align=absMiddle border=0><br>
              				<b>Network<br>Settings</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Disk Usage'; pop(4,'View disk usage per mount point.','Disk Usage');"
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/appliance/view_diskusage';">
				<a href="/webhost/appliance/view_diskusage" onmouseover="status='Disk Usage'; return true;" 
					onmouseout="status=''; return true;">
						<IMG src="/images/diskusage.gif" alt="Disk Usage" align=absMiddle border=0><br>
              			<b>Disk Usage</b>
				</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
			<TD align=center vAlign=middle style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/appliance/provisions/mysqlusage.php';" 
				onMouseOver="rollon(this); status='MySQL Usage'; pop(1,'View MySQL usage for all sites and opt whether to automatically notify them ' +
				'if they are close to their quota.','MySQL Usage');"  onMouseOut="rolloff(this); status=''; kill();"> 
              		<a href="/webhost/appliance/provisions/mysqlusage.php" onmouseover="status='MySQL Usage'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/mysqlusage.gif" alt="MySQL Usage" align=absMiddle border=0><br>
              				<b>MySQL Usage</b>
					</a>
			</TD>
			<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td> 
			<TD align=center vAlign=middle style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/services/bandwidth/';" 
				onMouseOver="rollon(this); status='Bandwidth Usage'; pop(1,'View bandwidth usage for all hosted sites.',
				'Bandwidth Usage');" onMouseOut="rolloff(this); status=''; kill();">
					<a href="/webhost/services/bandwidth/" onmouseover="status='Bandwidth Usage'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/bandwidth.gif" alt="Bandwidth Usage" align=absMiddle border=0><br>
              				<b>Bandwidth<br>Usage</b>
					</a>
			</TD>
			<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td> 
            <TD align=center vAlign=middle style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/appliance/view_time';" onMouseOver="rollon(this); status='System Time'; 
				pop(4,'Modify the system time of the box.','System Time');" onMouseOut="rolloff(this); status=''; kill();">
					<a href="/webhost/appliance/view_time" onmouseover="status='System Time'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/time.gif" alt="System Time" align=absMiddle border=0><br>
              				<b>System Time</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
          </TR>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END MANAGEMENT TOOL RELATED OPTIONS -->

		  <!-- CONTINUE MANAGEMENT RELATED OPTIONS -->
          <TR> 
            <TD height="12" colspan=12 class=subheader>Ensim WEBppliance and apnscp Management Continued</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
			<TD align=center vAlign=middle style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/appliance/form_editsupport';" 
				onMouseOver="rollon(this); status='Change Administrator'; pop(1,'Is your system\'s password at risk? Change it through \'Change Adminsitrator\'.',
				'Change Administrator');" onMouseOut="rolloff(this); status=''; kill();">
					<a href="/webhost/appliance/form_editsupport" onmouseover="status='Change Administrator'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/change_password.gif" alt="Change Password" align=absMiddle border=0><br>
              				<b>Change<br>Administrator</b>
					</a>
			</TD>
			<td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='WEBppliance License'; pop(1,'Upgrade, save, or view your existing WEBppliance license.','WEBppliance License');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/appliance/view_license';"> 
              		<a href="/webhost/appliance/view_license" onmouseover="status='WEBppliance License'; return true;" 
						onmouseout="status=''; return true;">
							<img src="/images/ensimkey.gif" alt="WEBppliance License" align=absMiddle border=0><br>
							<b>WEBppliance<br>License</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='apnscp License'; pop(1,'Upgrade, save, or view your existing apnscp license.','apnscp License');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/appliance/provisions/viewapnscp.php';"> 
              		<a href="/webhost/appliance/provisions/viewapnscp.php" onmouseover="status='apnscp License'; return true;" 
						onmouseout="status=''; return true;">
							<img src="/images/apnscpkey.gif" alt="apnscp License" align=absMiddle border=0><br>
							<b>apnscp<br>License</b>
					</a>
			</TD>
			<td><img src="/images/spacer.gif" width=2 alt=""></td>
			<TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Service Status'; pop(4,'View the status of all services and individually stop/restart/start each one',
				'Service Status');"  onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/index_html';"> 
              		<a href="/webhost/services/index_html" onmouseover="status='Service Status'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/services.gif" alt="Service Status" align=absMiddle border=0><br>
              			<b>Service<br>Status</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Restart/Reboot'; pop(4,'Whenever it is time for the routine reboot, why not bypass the shell and just use this?',
				'Restart/Reboot');"  onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/appliance/view_reboot';"> 
              		<a href="/webhost/services/appliance/view_reboot" onmouseover="status='Restart/Reboot'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/restart.gif" alt="Restart/Reboot" align=absMiddle border=0><br>
              			<b>Restart/<br>Reboot</b>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          </TR>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END MANAGEMENT RELATED OPTIONS -->

          <!-- BEGIN MISCELLANEOUS RELATED OPTIONS -->
          <TR> 
            <TD height="12" colspan=12 class=subheader>Miscellaneous</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Logout'; pop(1,'Logout and destroy your current session.','Logout');"  onMouseOut="rolloff(this); 
				status=''; kill();" onClick="location.href='/webhost/manage_logout?relogin=webhost/rollout/welcome';"> 
              		<a href="/webhost/manage_logout?relogin=webhost/rollout/welcome" onmouseover="status='Logout'; return true;" 
						target="_top" onmouseout="status=''; return true;">
							<IMG src="/images/logout.gif" alt="Logout" align=absMiddle border=0><br> 
             				<b>Logout</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Help'; pop(2,'View the WEBppliance help file for appliance administrators.','Help');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="window.open('/docs/en_US/site/web31site.htm','','','');"> 
              		<a href="/docs/en_US/appliance/web31appl.htm" target="_blank" onmouseover="status='Help'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/usermanual.gif" alt="Help" align=absMiddle border=0><br> 
              			<b>Help</b>
					</a>
			</TD>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <?php
			if ($ttEnabled) {
			?>
			<TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Trouble Tickets'; pop(4,'View and de-escalate any existing trouble tickets. ','Trouble Tickets');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/appliance/provisions/troubleticket.php';"> 
              		<a href="/webhost/appliance/provisions/troubleticket.php" onmouseover="status='Trouble Tickets'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/troubleticket.gif" alt="Trouble Tickets" align=absMiddle border=0><br> 
              				<b>Trouble Tickets</b>
					</a>
			</TD>
			<?php
			}
			else print("<TD></TD>");
			?>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
			<?php
			if ($billingEnabled) {
			?>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Billing'; pop(3,'View, edit, and add new billing transactions for domains.','Billing');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/appliance/provisions/billing.php';"> 
              		<a href="/webhost/appliance/provisions/billing.php" onmouseover="status='Billing'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/billing.gif" alt="Billing" align=absMiddle border=0><br>
            				<b>Billing</b>
					</a>
			</TD>
			<?php
			}
			else print("<TD></TD>");
			?>
            <td><img src="/images/spacer.gif" width=2 alt=""></td>
	        <TD align=center  vAlign=middle  style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/appliance/provisions/applsummary.php';" 
				onMouseOver="rollon(this); status='Appliance Summary'; pop(4,'\'Appliance Summary\' gives a quick overview of your current box.','Appliance Summary');"  
				onMouseOut="rolloff(this); status=''; kill();">
					<a href="/webhost/appliance/provisions/applsummary.php" onmouseover="status='Site Summary'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/summary_page.gif" alt="Appliance Summary" align=absMiddle border=0><br>
            				<b>Appliance<br>Summary</b>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          </TR>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END MISCELLANEOUS RELATED OPTIONS --->
        </table></td>
    </tr>
  </TBODY>
</TABLE>

<div align=right style="color:#cccccc; font-size:10px; font-family: monospace normal, courier new, courier;"><?php print(APNSCPID); ?></div>


</BODY>
</HTML>
