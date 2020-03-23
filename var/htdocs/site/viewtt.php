<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/*
	 * basic trouble ticket structure
	 * expect further modifications
	 * - msaladna@apisnetworks.com
	 */
	include "../global/sitefunctions.php";
	Login();
	if (!$ttEnabled) die("The requested module is disabled.");
	
	/* fetch databases */
	mysql_connect("localhost",$mysql['databases']['username'],$mysql['databases']['password']);
	mysql_select_db($mysql['databases']['database']);
	$mysqlusers = MysqlAliases($gDomainName);
	$i = 0;
	$row = array(); // in case there are no users.
	foreach ($mysqlusers as $VOID => $user) {
		$q = mysql_query("select db from db where user = '".$user."'");
		while ($tmp = mysql_fetch_row($q)) {
			$row[$i] = $tmp[0];
			$i++;
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
          <td class=head> View Trouble Ticket</td>
          <td align=right class=head3> 
		<script language="JavaScript">
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
	mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
	mysql_select_db($mysql['standard']['database']);
	$q2 = mysql_query("select date,status,category,data from troubletickets where id = '".$_GET['id']."' AND owner = '".$gUserName."'");
	$row2 = mysql_fetch_row($q2);
	$q3 = mysql_query("select date,resolution from resolutions where id = '".$_GET['id']."' AND owner = '".$gUserName."'");
	$row3 = mysql_fetch_row($q3);
	$answered = (mysql_num_rows($q3) == 1);
	$open = $row2[1];
	//if (mysql_num_rows($q3) > 0) $open ^= 1; // it is closed then
	if (mysql_num_rows($q2) <= 0) {
	?>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
        <tr> 
          <td class=head3>View Trouble Ticket</td>
        </tr>
        <tr> 
          <td class=help valign=center>There was no trouble ticket that matched the criteria.</td>
        </tr>
		</table>
	 </td>
	</tr>
</table>	
	<?php
	} else {
?>

<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
        <tr> 
          <td class=head3>View Trouble Ticket</td>
        </tr>
        <tr> 
          <td class=help valign=center>View an existing trouble ticket.</td>
        </tr>
       <tr>
		  <form action="troubleticket.php" method=POST>
          <td valign=center class=nospacing> <table width="100%" cellpadding=0 cellspacing=0 border=0>
              <tr> 
                <td colspan=3 class=head3> <table width="100%" cellpadding=2 cellspacing=1 border=0>
                    <tr> 
                      <td class=head4 width=140><strong>Username:</strong></td>
					  <td class=head4><?php print($gUserName); ?></td>
                    </tr>
					<tr>
						<td class=head5><strong>Domain:</strong></td>
						<td class=head5><?php print($gDomainName); ?></td>
					</tr>
					<?php
					if ($_COOKIE['mysql_enabled']) {
					?>
					<tr>
						<td class=head4><strong>MySQL Databases:</strong></td>
						<td class=head4><?php print(@join(", ",$row)); ?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td class=head5><strong>Category:</strong></td>
						<td class=head5><?php print(stripslashes($row2[2])); ?></td>
					</tr>
					<tr>
						<td class=head4><strong>Date:</strong></td>
						<td class=head4><?php print(date("n-j-Y g:m:s A",$row2[0])); ?></td>
					</tr>
					<tr>
						<td class=head5><strong>Status:</strong></td>
                      	<td class=head5>
							<strong><?php ($open) ? print("Open") : print ("Closed <input type=submit value='Reopen' name='reopen' />"); ?></strong>
						</td>
					</tr>
					<tr>
					  <td class=head4 valign=top><strong>Description:</strong></td>
					  <td class=head4><textarea name=description rows=10 cols=60 READONLY><?php print(stripslashes($row2[3])); ?></textarea></td>
                    </tr>
					<?php
						// trouble ticket is closed
						if ($answered) {
						?>
					<tr>
						<td class=head5><strong>Date Resolved:</strong></td>
						<td class=head5><?php (!$open) ? print(date("n-j-Y g:m:s A",$row3[0])) : print('Unresolved'); ?></td>
					</tr>
					<tr>
					  <td class=head4 valign=top><strong>Resolution:</strong></td>
					  <td class=head4><textarea name=description rows=10 cols=60 READONLY><?php print(stripslashes($row3[1])); ?></textarea></td>
                    </tr>
					<?php
					}
					if ($open) {
					?>
					<tr>
						<td colspan=2 class=cell2 align=center><strong>Note: You may not modify the existing trouble ticket data</strong></td>
					<tr>
						<td class=head5><strong>Additional Notes:</strong></td>
						<td class=head5 valign=top><textarea name=additionalnotes rows=10 cols=60></textarea></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td class=head4 colspan=2 align=center>
							<input type=hidden name=wasopen value=<?php ($open) ? print('1') : print('0'); ?> />
							<input type=hidden name=id value=<?php print($_GET['id']); ?> />
							<?php if ($open) { ?>
							<input type=submit value="Edit Trouble Ticket" />
							<input type=hidden name=edit value=1 />
							<br /><br />
							<?php } ?>
							<a href="troubleticket.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;">
								Return to Trouble Tickets
							</a>
						</td>
					</tr>
                  </table></td>
              </tr>
            </table></td>
			</form>
        </tr>
      </table></td>
  </tr>
</form>
</table>
<?php
}
?>
<p>
</p>
</BODY>
</HTML>
