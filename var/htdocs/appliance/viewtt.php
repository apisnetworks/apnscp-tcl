<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/adminfunctions.php";
	Login();
	
	mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
	mysql_select_db($mysql['standard']['database']);
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
<table width=640 border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
				  <td colspan=6 class=head3>Trouble Tickets</td>
				</tr>
				<tr> 	  
			        <td class=help colspan=6 valign=center>
						Utilize the integrated 'Trouble 
						Ticket' interface to better assist your customers' comments and concerns 
						quickly and easily.
					</td>
				</tr>
				<tr>
					<td>
					<?php
					$q = mysql_query("select id, owner, date, category, data, pass, email from troubletickets where id = '".$_GET["id"]."'");
					$row = mysql_fetch_row($q);
					?>
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
					<form action="troubleticket.php" method=post>
					  <tr> 
						<td class=head4>
							<strong>Domain Name</strong>:
						</td>
						<td class=head4> 
						  <?php print($_GET['domain']); ?>
						</td>
						<td class=head4>
							<strong>Login Name</strong>:
						</td>					   
						<td class=head4> 
						  <?php print($_GET['owner']); ?>
						</td>
					  </tr>
					  <tr> 
                  		<td class=head5>
							<strong>MySQL Databases</strong>:
						</td>
						<td class=head5> 
						  <?php print(@join(",",GetDatabases($_GET['owner']))); ?>
						</td>
						<td class=head5>
							<strong>Password:</strong>
						</td>
						<td class=head5> 
						  <?php print(stripslashes($row[4])); ?>
						</td>
					  </tr>
					  <tr> 
						<td class=head4>
							<strong>E-Mail:</strong>
						</td>
						<td class=head4> 
							<?php print($row[6]); ?>
						</td>
						<td class=head4><strong>Submitted On:</strong></td>
						<td class=head4> 
						  <?php print(date('m/d/y g:i:s A',$row[2])); ?>
						</td>
					  </tr>
					  <tr> 
						<td class=head5><strong>Category:</strong></td>
						<td class=head5> 
							<font color="#d40026"><?php print(stripslashes($row[3])); ?></font>
						</td>
						<td class=head5><strong>Close:</strong></td>
						<td class=head5><select name=closenow><option value=1 SELECTED>Yes</option><option value=0>No</option></td>
					  </tr>
					  <tr> 
						<td class=head4 valign=top>
							<strong>Description:</strong>
						</td>
						<td colspan=3 class=head4> 
						   <textarea name=description rows=10 cols=70 READONLY><?php print(stripslashes($row[4])); ?></textarea>
						</td>
					  </tr>
					  <tr> 
						<td valign="top" class=head4><strong>Resolution:</strong></td>
						<td colspan=3 class=head4> 
						   <textarea name=resolution rows=20 cols=70></textarea>
						</td>
					  </tr>
					  <tr>
						<td colspan=4 class=head4 align=center>
                            <input type=hidden name=closed value="<?php print($_GET['closed']); ?>" />
							<input type=hidden name=id value="<?php print($_GET['id']); ?>">
							<input type=hidden name=owner value="<?php print($_GET['owner']); ?>">
							<input type=hidden name=go value=1>
							<input type=submit value=Submit>
						</td>
					  </tr>
					  </form>
					 </table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>