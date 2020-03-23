<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include_once "../global/adminfunctions.php";
	include_once "../global/emailtemplates.php";
	Login();
	
	mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
	mysql_select_db($mysql['standard']['database']);
	$retVal = 0;
	if (isset($_POST['go']) && $_POST['closenow']) { // from resolution post
		$q2 = mysql_query("select email, category, data, date from troubletickets where id = '".$_POST['id']."' and owner = '".$_POST['owner']."'");
		$row = mysql_fetch_row($q2);
		$q = @mysql_query("insert into resolutions values('".$_POST['id']."','".$_POST['owner']."','".time()."','".addslashes(htmlentities($_POST['resolution'],ENT_QUOTES))."');");
		$q = @mysql_query("update troubletickets set status = '0' where id = '".$_POST['id']."' and owner = '".$_POST['owner']."';");
		$newdata = $_POST['resolution'];
		$origdata = stripslashes($row[2]);
		mail($row[0],"Trouble ticket resolution (".$row[1].") - Date: ".date("M j Y g:i:s A",$row[3]),$troubleticketTemplate,"From: support@apisnetworks.com");
		if (mysql_affected_rows() == -1) {
			$error = mysql_error();
			$retVal = 1;
		}
	} else if (isset($_POST['closed']) && !$_POST['closenow']) {
		/* customer edited his trouble ticket */
		$q2 = mysql_query("select email, category, data, date from troubletickets where id = '".$_POST['id']."' and owner = '".$_POST['owner']."'");
		$row = mysql_fetch_row($q2);
		$q = mysql_query("insert into resolutions values('".$_POST['id']."','".$_POST['owner']."','".time()."','');");
		$q = mysql_query("update resolutions set resolution = concat(resolution,'\n\nThe following notes were added on ".date("M j Y g:i:s A",time()).":\n".addslashes(html_entities($_POST['resolution'],ENT_QUOTES))."') where id = '".$_POST['id']."' and owner = '".$_POST['owner']."';");
		$q2 = mysql_query("update troubletickets set status = '1' where id = '".$_POST['id']."' and owner = '".$_POST['owner']."';");
		$newdata = $_POST['resolution'];
		$origdata = stripslashes($row[2]);
		mail($row[0],"Trouble ticket reopened (".$row[1].") - Date: ".date("M j Y g:i:s A",$row[3]),
		"The trouble ticket you closed has been reopened.
		The following notes were appended to it on ".date("M j Y g:i:s A",time()).":\n
		------------------------\n
		".stripslashes($_POST['resolution'])."\n
		------------------------\n
		in response to your original trouble ticket statement:\n
		------------------------\n
		".stripslashes($row[2])."\n
		------------------------\n
		You may log into the control panel and view the status of the ticket.\n
		\n
		".$ttTagLine."\n
		".$ttEmail."\n","From: support@apisnetworks.com");
		if (mysql_affected_rows() == -1) {
			$error = mysql_error();
			$retVal = 1;
		}
	}
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
          <td class=head>Management</td>
          <td align=right class=head3> <script language="JavaScript">
        function popUpHelpWindow() {
           helpwin=window.open("https://<?php print($_SERVER['HTTP_HOST']); ?>/docs/en_US/site/oh_site_user_menu.htm","helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
           helpwin.focus();
        }
        </script> <a href="javascript:popUpHelpWindow()" onMouseOver="status='Click here for help'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">
		<IMG SRC="https://<?php print($_SERVER['HTTP_HOST']); ?>/webhost/help_toolbar_gif" HEIGHT = "15" BORDER = "0" ALIGN = "absmiddle" WIDTH = "15"><font color=white>Help</font></a> 
          </td>
        </tr>
        <tr> 
          <td class=cell1 colspan=2> &nbsp; <strong><a href="troubleticket.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;">Trouble 
            Tickets </a></strong> <img src="/images/red.gif" width=4 height=4> 
            <a href="billing.php" onMouseOver="status='Billing'; return true;" onMouseOut="status=''; return true;">Billing</a><a href="billing.php" onMouseOver="status='Billing'; return true;" onMouseOut="status=''; return true;"><strong></strong></a><strong><a href="changelog.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;"> 
            </a></strong> <img src="/images/red.gif" width=4 height=4> <a href="editbilling.php" onMouseOver="status='Edit Billing'; return true;" onMouseOut="status=''; return true;">Edit 
            Billing</a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<?php
	if (isset($_POST['go'])) {
		if (!$retVal) {
			?>
			<table width=640 border=0 cellspacing=0 cellpadding=1>
				<tr>
					<td class=head>
						<table width=640 border=0 cellspacing=0 cellpadding=1>
							<tr> 
								<td width="150" valign="middle" class=cell1> 
									&nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
									<b>Status:</b>&nbsp;Successful! </td>
								
			  <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;Trouble 
				Ticket Closed</td>
							</tr>
						</table> 
					</td>
				</tr>
			</table> 
			<br>
<?php 
		} else {
		?>
			<table width=640 border=0 cellspacing=0 cellpadding=1>
				<tr>
					<td class=head>
						<table width=640 border=0 cellspacing=0 cellpadding=1>
							<tr> 
								<td width="150" valign="middle" class=cell1> 
									&nbsp; <img border=0 src="/images/redball.gif" alt="Action Failed"> 
									<b>Status:</b>&nbsp;Failed!
								</td>
			 					<td width="487" align=left valign="middle" class=cell1>
									<b>Result:</b>&nbsp;Error generated -> <?php print($error); ?>
								</td>
							</tr>
						</table> 
					</td>
				</tr>
			</table> 
			<br>
		<?php
		}
	}
?>
<table width=640 border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
				  <td class=head3>Trouble Tickets</td>
				</tr>
				<tr> 
				  
          <td class=help valign=center>Utilize the integrated 'Trouble 
            Ticket' interface to better assist your customers' comments and concerns 
            quickly and easily.</td>
				</tr>
				<tr>
					<td class=head4 align=center><strong>Latest Open Trouble Tickets:</strong></td>
				</tr>
				<tr>
					<td>
						<table cellpadding=2 cellspacing=1 border=0 width="100%" bgcolor="#cccccc"><!--DWLayoutTable-->
							<tr>
							  <td class=head5 width=30 align=center><strong>#:</strong></td>
							  <td class=head5 width=120><strong>Date:</strong></td>
							  <td width="76" class=head5><strong>Owner:</strong></td>
							  <td width="79" class=head5><strong>Domain:</strong></td>
							  <td width="129" class=head5><strong>Category:</strong></td>
							  <td width="79" class=head5><strong>Status:</strong></td>
							  <td width="87" align=center class=head5><strong>Actions:</strong></td>
							</tr>
							<?php
							$q = mysql_query("select * from troubletickets where status = '1' order by date desc");
							$color = "listodd";
							while ($row = mysql_fetch_row($q)) {
								?>
								<tr>
									<td class="<?php print($color); ?>" align=center>
										<?php print($row[0]); ?>
									</td>
									<td class="<?php print($color); ?>">
										<?php print(date('m/d/y g:i:s A',$row[2])); ?>
									</td>
									<td class="<?php print($color); ?>">
											<?php print($row[1]); ?>
									</td>
									<td class="<?php print($color); ?>">
										<?php
										 print($row[7]);
										?>
									</td>
									<td class="<?php print($color); ?>">
										<?php print($row[4]); ?>
									</td>
									<td class="<?php print($color); ?>">
										<?php
										 $row[3] ? print('Open') : print ('Closed')
										?>
									</td>
									<td class="<?php print($color); ?>" align=center>
										<a href="viewtt.php?<?php printf("id=%u&owner=%s&domain=%s&closed=0",$row[0],$row[1],$row[7]); ?>">
											<img src="/images/respondtt.gif" alt="Respond" border=0 />
										</a>
									</td>
								</tr>
								<?php
								if ($color == "listodd") 
									$color = "listeven"; 
								else 
									$color = "listodd";
							}
							?>
						</table>
					</td>
				</tr>
				
				
				<tr>
					<td class=head4 align=center><strong>Closed Trouble Tickets:</strong></td>
				</tr>
				<tr>
					<td>
						<table cellpadding=2 cellspacing=1 border=0 width="100%" bgcolor="#cccccc"><!--DWLayoutTable-->
							<tr>
							  <td class=head5 width=30 align=center><strong>#:</strong></td>
							  <td class=head5 width=120><strong>Date:</strong></td>
							  <td width="76" class=head5><strong>Owner:</strong></td>
							  <td width="79" class=head5><strong>Domain:</strong></td>
							  <td width="129" class=head5><strong>Category:</strong></td>
							  <td width="79" class=head5><strong>Status:</strong></td>
							  <td width="87" align=center class=head5><strong>Actions:</strong></td>
							</tr>
							<?php
							$q = mysql_query("select * from troubletickets where status = '0' order by date desc");
							$color = "listodd";
							while ($row = mysql_fetch_row($q)) {
								?>
								<tr>
									<td class="<?php print($color); ?>" align=center>
										<?php print($row[0]); ?>
									</td>
									<td class="<?php print($color); ?>">
										<?php print(date('m/d/y g:i:s A',$row[2])); ?>
									</td>
									<td class="<?php print($color); ?>">
											<?php print($row[1]); ?>
									</td>
									<td class="<?php print($color); ?>">
										<?php
										 print($row[7]);
										?>
									</td>
									<td class="<?php print($color); ?>">
										<?php print($row[4]); ?>
									</td>
									<td class="<?php print($color); ?>">
										<?php
										 $row[3] ? print('Open') : print ('Closed')
										?>
									</td>
									<td class="<?php print($color); ?>" align=center>
										<a href="viewtt.php?<?php printf("id=%u&owner=%s&domain=%s&closed=1",$row[0],$row[1],$row[7]); ?>">
											<img src="/images/respondtt.gif" alt="Respond" border=0 />
										</a>
									</td>
								</tr>
								<?php
								if ($color == "listodd") 
									$color = "listeven"; 
								else 
									$color = "listodd";
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</BODY>
</HTML>
