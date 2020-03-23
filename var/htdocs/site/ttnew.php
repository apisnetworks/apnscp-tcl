<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	if (!$ttEnabled) die("The requested module is disabled.");
	Login();
	
	// fetch databases
	mysql_connect("localhost",$mysql['databases']['username'],$mysql['databases']['password']);
	mysql_select_db($mysql['databases']['database']);
	$mysqlusers = MysqlAliases($gDomainName);
	$i = 0;
	$row = array();
	foreach ($mysqlusers as $VOID => $user) {
		$q = mysql_query("select distinct(db) from db where user = '".$user."'");
		while ($tmp = mysql_fetch_row($q)) {
			$row[$i] = $tmp[0];
			$i++;
		}
	}
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
<script language="JavaScript">
<!--
function checkForm() {
	if (document.forms[0].ttcategory.value == "") {
		alert("Please select a category");
		document.forms[0].ttcategory.focus();
		return false;
	}
	else if(document.forms[0].description.value == "" ) {
		alert("Please enter a description of the problem");
		document.forms[0].description.focus();
		return false;
	} else {
		return true;
	}
}
//-->
</script>
</HEAD>
<BODY leftmargin = "15" topmargin = "2" marginwidth = "15" marginheight = "2" bgcolor = "#ffffff">
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head> <table width=640 border=0 cellspacing=1 cellpadding=1>
        <tr> 
          <td class=head> Submit New Trouble Ticket</td>
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
          <td class=cell1 colspan=2> 
		  	&nbsp; <a href="troubleticket.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;">Trouble Tickets</a>
			<img src="/images/red.gif" width=4 height=4> 
            <a href="ttnew.php" onMouseOver="status='Submit New Trouble Ticket'; return true;" onMouseOut="status=''; return true;"><strong>Submit New Trouble Ticket</strong></a>
		  </td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
<form action="troubleticket.php" method=POST onSubmit="return checkForm();">
  <tr> 
    <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
        <tr> 
          <td class=head3>Submit New Trouble Ticket</td>
        </tr>
        <tr> 
            <td class=help valign=center>File a new trouble ticket to resolve 
              a problem with the service.</td>
        </tr>
       <tr> 
          <td valign=center class=nospacing bgcolor="#748D4B"> <table width="100%" cellpadding=1 cellspacing=0 border=0>
              <tr> 
                <td colspan=3 class=nospacing> <table width="100%" cellpadding=2 cellspacing=1 border=0>
                    <tr> 
                        <td class=cell2 width=140><strong>Username:</strong></td>
					  <td class=cell2><?php print($gUserName); ?></td>
                    </tr>
					<tr>
						<td class=cell2><strong>Domain:</strong></td>
						<td class=cell2><?php print($gDomainName); ?></td>
					</tr>
					<?php
						if ($_COOKIE['mysql_enabled']) {
					?>
					<tr>
						<td class=cell2><strong>MySQL Databases:</strong></td>
						<td class=cell2><?php print(@join(", ",$row)); ?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td class=cell2><strong>Category:</strong></td>
						<td class=cell2>
							<select name=ttcategory>
								<option value="" disabled>Select One</option>
								<option value="" disabled>--------------------</option>
								<option value="Access Denied" style="color: #990000;">Access Denied</option>
								<option value="Apache Down" style="color: #990000;">Apache Down</option>
								<option value="Applications Not Responding" style="color: #990000;">Applications Not Responding</option>
								<option value="AUP Violations - Investigating" style="color: #990000;">AUP Violations - Investigating</option>
								<option value="AUP Violations - Unplugged" style="color: #990000;">AUP Violations - Unplugged</option>
								<option value="Bandwidth Monitoring" style="color: #990000;">Bandwidth Monitoring</option>
								<option value="Cannot Access My Server" style="color: #990000;">Cannot Access My Server</option>
								<option value="Cannot Access Sites on Server" style="color: #990000;">Cannot Access Sites on Server</option>
								<option value="Cannot Add Users" style="color: #990000;">Cannot Add Users</option>
								<option value="Cannot enable options for users" style="color: #990000;">Cannot enable options for users</option>
								<option value="Cannot Upload Files" style="color: #990000;">Cannot Upload Files</option>
								<option value="CGI Errors" style="color: #990000;">CGI Errors</option>
								<option value="Code Errors" style="color: #990000;">Code Errors</option>
								<option value="DNS" style="color: #990000;">DNS</option>
								<option value="Enabled but not working" style="color: #990000;">Enabled but not working</option>
								<option value="General Wrapper Error" style="color: #990000;">General Wrapper Error</option>
								<option value="Hardware Problem" style="color: #990000;">Hardware Problem</option>
								<option value="Investigating" style="color: #990000;">Investigating</option>
								<option value="Manual FSCK" style="color: #990000;">Manual FSCK</option>
								<option value="MRTG" style="color: #990000;">MRTG</option>
								<?php
								if ($_COOKIE['mysql_enabled']) {
								?>
								<option value="MySQL" style="color: #990000;">MySQL</option>
								<?php
								}
								?>
								<option value="Other" style="color: #990000;">Other</option>
								<option value="Past Due Balance" style="color: #990000;">Past Due Balance</option>
								<option value="Performance Issues" style="color: #990000;">Performance Issues</option>
								<option value="Permission Problems" style="color: #990000;">Permission Problems</option>
								<?php
								if ($postgresqlEnabled) {
								?>
								<option value="PostgreSQL" style="color: #990000;">PostgreSQL</option>
								<?php
								}
								?>
								<option value="Reboot" style="color: #990000;">Reboot</option>
								<option value="Relaying Denied" style="color: #990000;">Relaying Denied</option>
								<?php
								if ($urchin4Enabled) {
								?>
								<option value="Urchin 5" style="color: #990000;">Urchin 5</option>
								<?php
								}
								?>
								<option value="URL Not Found" style="color: #990000;">URL Not Found</option>
								<option value="Username and password errors" style="color: #990000;">Username and password errors</option>
	  						</select>
						</td>
					</tr>
					<tr>
						<td class=cell2 valign=top><strong>Description:</strong></td>
					    <td class=cell2><textarea name=description rows=10 cols=60></textarea></td>
                    </tr>
					<tr>
						<td class=cell2 colspan=2 align=center>
							<input type=hidden name=go value=1>
							<input type=submit value=Submit>
							<input type=reset value=Reset>
						</td>
					</tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>
</BODY>
</HTML>
