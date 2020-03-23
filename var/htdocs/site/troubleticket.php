<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include_once "../global/sitefunctions.php";
	include_once "../global/emailtemplates.php";
	if (!$ttEnabled) die("The requested module is disabled.");
	Login();
	
	// let's begin our connection
	mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
	mysql_select_db($mysql['standard']['database']);
	if (isset($_POST['go'])) {
		$retVal = 0;
		$q = mysql_query("insert into troubletickets values('','".$gUserName."', '".time()."', '1', '".addslashes($_POST['ttcategory'])."','".
		addslashes($_POST['description'])."','','".$gDomainName."', '', '".trim(checkLocalServer($gDomainName,"getemail"))."');");
		mail($ttEmail,"New Trouble Ticket (".$gUserName.")", $newttTemplate);
mail('6789865596@mobile.mycingular.com','Trouble Ticket',$gUserName."; ".$_POST['ttcategory']);
		if (mysql_affected_rows() == -1) {
			$retVal = 1;
			$error = mysql_error();
		}
	} else if (isset($_POST['edit'])) {
		$retVal = 0;
		$q = mysql_query("update troubletickets set date = date, data = concat(data,'\n\nAdditional notes appended on ".date("n-j-Y g:m:s A",time()).":\n','".addslashes($_POST['additionalnotes'])."') where id = '".$_POST['id']."' AND domain = '".$gDomainName."'");
		mail($ttEmail,"Trouble Ticket Modification (".$gUserName.")", $newttTemplate."\n\nAdditional notes added ".date("n-j-Y g:m:s A",time())."\n\n:".$_POST['additionalnotes']);
		if (mysql_affected_rows() == -1) {
			$retVal = 1;
			$error = mysql_error();
		}
	} else if ((isset($_POST['wasopen'])) && !$_POST['wasopen']) {
		$retVal = 0;
		$q = mysql_query("update troubletickets set status = '1' where id = '".$_POST['id']."' AND domain = '".$gDomainName."'");
		mail('6789865596@mobile.mycingular.com','Trouble Ticket',$gUserName."; ".$_POST['ttcategory']);
		if (mysql_affected_rows() == -1) {
			$retVal = 1;
			$error = mysql_error();
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
          <td class=head> Trouble Tickets</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="troubleticket.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;"><strong>Trouble 
            Tickets</strong></a> <img src="/images/red.gif" width=4 height=4> 
            <a href="ttnew.php" onMouseOver="status='Submit New Trouble Ticket'; return true;" onMouseOut="status=''; return true;">Submit 
            New Trouble Ticket</a></td>
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
								<td width="487" align=left valign="middle" class=cell1>
									<b>Result:</b>&nbsp;Trouble Ticket Modified.
								</td>
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
										&nbsp; <img border=0 src="/images/redball.gif" alt="Action Successful"> 
										<b>Status:</b>&nbsp;Failed! </td>
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
    <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
        <tr> 
          <td class=head3>Trouble Tickets</td>
        </tr>
        <tr> 
          <td class=help valign=center>You may file a new trouble ticket or read 
            over existing ones.</td>
        </tr>
       <tr> 
          <td valign=center bgcolor=white> <table width="100%" cellpadding=0 cellspacing=0 border=0>
              <tr> 
                <td width="35%"  class=head4></td>
                <td class=head4 width="30%" align=center>Open Trouble Tickets</td>
                <td width="35%" class=head4></td>
              </tr>
              <tr> 
                <td colspan=3 class=head3> <table width="100%" cellpadding=2 cellspacing=1 border=0>
                    <tr> 
                      <td class=head5 width=140><strong>Date:</strong></td>
                      <td class=head5><strong>Description:</strong></td>
                    </tr>
                    <?php
						$color = "listodd";
						$q = mysql_query("select id, date, category from troubletickets where status = '1' AND owner = '".$gUserName."' order by date desc");
						if (mysql_num_rows($q) == 0) {
							?>
							<tr>
								<td colspan=2 align=center bgcolor=white>User 
									<?php print($gUserName); ?>
									does not have any open trouble tickets.<br>
									<a href="ttnew.php" onmouseover="status='Submit a New Trouble Ticket'; return true;" onmouseout="status=''; return true;">Submit a New Trouble Ticket</a>
								</td>
							</tr>
							<?php
						} else {
							while ($row = mysql_fetch_row($q)) {		
								?>
								<tr> 
								  	<td class=<?php print($color); ?>><?php print(date("n-j-Y g:m:s A",$row[1])); ?></td>
								  	<td class=<?php print($color); ?>>
								  		<a href="viewtt.php?id=<?php print($row[0]); ?>" onmouseover="status='View Trouble Ticket [<?php print(str_replace("'","\\'",stripslashes($row[2]))); ?>]'; return true;" onmouseout="status=''; return true;">
								  		<?php print(stripslashes($row[2])); ?></a>
									</td>
								</tr>
								<?php
								if ($color == "listodd") 
									$color = "listeven"; 
								else 
									$color = "listodd";
							}
						}
					?>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td colspan=3 height=5 bgcolor=white></td>
        </tr>
        <tr> 
          <td valign=center class=nospacing> <table width="100%" cellpadding=0 cellspacing=0 border=0>
              <tr> 
                <td width="35%"  class=head4></td>
                <td class=head4 width="30%" align=center>Closed Trouble Tickets</td>
                <td width="35%" class=head4></td>
              </tr>
              <tr> 
                <td colspan=3 class=nospacing>
				<table width="100%" cellpadding=2 cellspacing=1 border=0>
                    <tr> 
                      <td class=head5 width=140><strong>Date:</strong></td>
                      <td class=head5><strong>Description:</strong></td>
                    </tr>
                    <?php
						$q = mysql_query("select id, date, category from troubletickets where status = '0' AND owner = '".$gUserName."'  order by date desc");
						while ($row = mysql_fetch_row($q)) {
							?>
							<tr> 
								
                      			<td class=<?php print($color); ?>><?php print(date("n-j-Y g:m:s A",$row[1])); ?></td>
								<td class=<?php print($color); ?>>
									<a href="viewtt.php?id=<?php print($row[0]); ?>" onmouseover="status='View Trouble Ticket [<?php print(str_replace("'","\\'",stripslashes($row[2]))); ?>]'; return true;" onmouseout="status=''; return true;">
									<?php print(stripslashes($row[2])); ?>
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
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</BODY>
</HTML>
