<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/adminfunctions.php";
	Login();	
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
</HEAD>
<BODY leftmargin = "15" topmargin = "2" marginwidth = "15" marginheight = "2" bgcolor = "#ffffff">
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head> <table width=640 border=0 cellspacing=1 cellpadding=1>
        <tr> 
          <td class=head> Appliance Summary </td>
          <td align=right class=head3>
			  <script language="JavaScript">
				function popUpHelpWindow() {
				   helpwin=window.open("https://<?php print($_SERVER['HTTP_HOST']); ?>/docs/en_US/site/oh_site_about_site_summary.htm","helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
				   helpwin.focus();
				}
			  </script>
			  <a href="javascript:popUpHelpWindow()" onMouseOver="status='Click here for help'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">
				<IMG SRC="https://<?php print($_SERVER['HTTP_HOST']); ?>/webhost/help_toolbar_gif" HEIGHT = "15" BORDER = "0" ALIGN = "absmiddle" WIDTH = "15">
				<font color=white>Help</font>
			  </a> 
          </td>
        </tr>
        <tr> 
          <td class=cell1 colspan=2> &nbsp; <b> <a href="applsummary.php" onMouseOver="status='Configuration'; return true;" onMouseOut="status=''; return true;">Configuration</a></b></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td class=head> <table border=0 width=100% cellpadding=1 cellspacing=1>
        <tr>
          <td colspan=2 class=head3>Configuration</td>
        </tr>
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
			ChunkSize($usedSpace,$unitUsed);
			ChunkSize($totalSpace,$unitTotal);
			?>
			<tr>	
				
          <td class=cell1>Disk Usage&nbsp;<font style="font-size: smaller;">(<?php printf("%s on %s",$driveInfo[0],$driveInfo[5]); ?>)</font></td>
				<TD class=cell1> 
					<table width="100%" cellpadding=0 cellspacing=0 border=0 style="border-width:0px;">
						<tr> 
							<td style="border-width:0px;" class=cell1 align=right><img src="/images/bandwidthbarleft.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=cell1 width="<?php print(ceil($driveInfo[4]*2)); ?>"><img src="/images/bandwidthbar.gif" alt="" height=14 width="<?php print(ceil($driveInfo[4]*2)); ?>"></td>
							<td style="border-width:0px;" class=cell1 width="<?php print(ceil((100-$driveInfo[4])*2)); ?>"><img src="/images/bandwidthempty.gif" alt="" height=14 width="<?php print(ceil((100-$driveInfo[4])*2)); ?>"></td>
							<td style="border-width:0px;" class=cell1 align=left><img src="/images/bandwidthbarright.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=cell1 align=left>
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
					<td class=cell1>Monthly Bandwidth Usage:</td>
					<TD class=cell1> 
						<table width="100%" cellpadding=0 cellspacing=0 border=0  style="border-width:0px;">
						  <tr> 
							<td style="border-width:0px;" class=cell1 align=right><img src="/images/bandwidthbarleft.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=cell1 width="<?php print(ceil(($bwUsage/$bwTotal*100))*2); ?>"><img src="/images/bandwidthbar.gif" alt="" height=14 width="<?php print(ceil(($bwUsage/$bwTotal*100))*2); ?>"></td>
							<td style="border-width:0px;" class=cell1 width="<?php print(ceil((100-$bwUsage/$bwTotal*100))*2); ?>"><img src="/images/bandwidthempty.gif" alt="" height=14 width="<?php print(ceil((100-$bwUsage/$bwTotal*100))*2); ?>"></td>
							<td style="border-width:0px;" class=cell1 align=left><img src="/images/bandwidthbarright.gif" alt="" align=absMiddle border=0></td>
							<td style="border-width:0px;" class=cell1 align=left>
								<?php
									ChunkSize($bwUsage,$unitUsed);
									ChunkSize($bwTotal,$unitTotal);
									printf("%.2f %s / %.2f %s <font style=\"font-size:smaller;\">(%.2f%%)</font>",$bwUsage,$gSpaceMapping[$unitUsed],$bwTotal,$gSpaceMapping[$unitTotal],$bwUsage/$bwTotal*100);
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
   		 	
          <td class=cell1>Trouble Tickets</td>
			<TD class=cell1> 
				<table width="100%" cellpadding=0 cellspacing=0 border=0 style="border-width:0px;">
					<tr> 
						<td style="border-width:0px;" class=cell1 align=left>Opened:</td>
						<td style="border-width:0px;" class=cell1 align=left>&nbsp;<?php print($ttOpen); ?></td>
						<td style="border-width:0px;" class=cell1 align=left>&nbsp;|&nbsp;</td>
						<td style="border-width:0px;" class=cell1 align=left>Total:</td>
						<td style="border-width:0px;" class=cell1 align=left>&nbsp;<?php print($ttTotal); ?></td>
						<td style="border-width:0px;" class=cell1 align=left width="100%"><img src="/images/spacer.gif" alt="" width="100%" height=1 /></td>
					</tr>
				</table>
			</TD>
		</tr>
		<?php
		}
		if ($apnscpCheck) {
		?>
		<tr>
			
          <td class=cell1>apnscp Version</td>
			<td class=cell1><?php print(apnscpCheck()); ?></td>
		</tr>
		<?php
		} 
		if ($ensimCheck) {
		?>
		<tr>
			
          <td class=cell1>Ensim WEBppliance Version</td>
			<td class=cell1><?php print(EnsimCheck()); ?></td>
		</tr>
		<?php
		}
		?>
        <tr> 
          <td class=cell1 valign=top>Services</td>
          <td class=cell1> 
		  	<table border=0 cellspacing=1 cellpadding=1>
			  <?php
			  	$services = array();
				ServiceStatus($services);
			    while(list($key,$val) = @each($services)) {
			  	  ?>
				  <tr> 
					<td class=cell1>
						<?php print($key); ?>
					</td>
					<td class=cell1>
						<?php 
							if ($val && $val != -1)
								print("<img src=\"/images/on.gif\" alt=\"On\" />");
							else if (!$val)
								print("<img src=\"/images/off.gif\" alt=\"Off\" />");
							else
								print("<img src=\"/images/disabled.gif\" alt=\"Disabled\" />");
						?>
					</td>
				  </tr>
				  <?php
				}
			  ?>
            </table>
		  </td>
        </tr>
      </table></td>
  </tr>
</table>
</BODY>
</HTML>
