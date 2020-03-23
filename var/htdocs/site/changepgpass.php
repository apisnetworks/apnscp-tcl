<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	if (!$postgresqlEnabled) die("The requested module is disabled.");
	Login();
	if (isset($_POST['pgpasswd'])) {
		CheckLocalServer($gDomainName,"pgpasswd",$gUserName,$_POST['pgpasswd']);
	}
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
<script language="JavaScript">
<!--
function checkForm() {
	var re = /^[a-zA-Z0-9]+$/;
 	if (!re.test(document.forms[0].pgpasswd.value)) {
		alert("Password may be only of alphanumeric context.");
		return false;
	} else if (document.forms[0].pgpasswd.value != document.forms[0].pgpasswd2.value) {
		alert("Passwords do not match.");
		return false;
	} else
		return true;
}
//-->
</script>
</HEAD>
<BODY leftmargin = "15" topmargin = "2" marginwidth = "15" marginheight = "2" bgcolor = "#ffffff">
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head> <table width=640 border=0 cellspacing=1 cellpadding=1>
        <tr> 
          <td class=head> PostgreSQL Administration</td>
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
          <td class=cell1 colspan=2>
		  <?php
		  	if ($phppgadminEnabled) {
			?>
			&nbsp;<a href="<?php print($phppgadminPath); ?>" target="_blank" onMouseOver="status='phpPgAdmin'; return true;" onMouseOut="status=''; return true;">phpPgAdmin</a>&nbsp;<img src="/images/red.gif" width=4 height=4>
			<?php
			}
			?> 
            <a href="http://<?php print($_SERVER['HTTP_HOST']); ?>/phpPgAdmin/" target="_blank" onMouseOver="status='phpPgAdmin'; return true;" onMouseOut="status=''; return true;"></a> 
            <strong><a href="changepgpass.php" onMouseOver="status='Change PostgreSQL Password'; return true;" onMouseOut="status=''; return true;">Change 
            PostgreSQL Password</a></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	if (isset($_POST['pgpasswd'])) {
?>
		<br>
		<table width=640 border=0 cellspacing=0 cellpadding=1>
			  <tr>
			  <td class=head>
			  <table width=640 border=0 cellspacing=0 cellpadding=1>
        <tr> 
          <td width="150" valign="middle" class=cell1> &nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
            <b>Status:</b>&nbsp;Successful! </td>
          <td width="487" align=left valign="middle" class=cell1><b>Result:</b>&nbsp;Your 
            PostgreSQL password has been altered.</td>
        </tr>
      </table> 
			  </td>
			  </tr>
			  </table> 
<?php } ?>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
<form method=POST action="changepgpass.php"  onSubmit="return checkForm();">
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
        			
            <td colspan=2 class=head3>Change PostgreSQL Password</td>
			    </tr>
				<tr> 
				  
            <td class=cell1>User Name</td>
				  <td class=cell1 valign=top><?php print($gUserName); ?></td>
				</tr>
				<tr>		
    		        <td class=cell1 valign=top>New Password</td>
					<td class=cell1><input type=password name=pgpasswd /></td>
				</tr>
				<tr>
					<td class=cell1>Retype New Password</td>
					<td class=cell1><input type=password name=pgpasswd2 /></td>
				</tr>
				<tr> 
					<td align=center class=cell1 colspan=2> 
				  		<table border=0 cellpadding=0 cellspacing=0> 
			            	<tr> 
            			  	<td class=cell1> <input type=submit value='Submit'> <input type=reset value="Reset"></td>
						    </tr>
    					</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</form>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>
