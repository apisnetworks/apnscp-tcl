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
          <td class=head> apnscp Management</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="viewapnscp.php" onMouseOver="status='apnscp License'; return true;" onMouseOut="status=''; return true;"><strong>apnscp 
            License</strong></a> <img src="/images/red.gif" width=4 height=4> 
            <a href="license.php" onMouseOver="status='License Agreement'; return true;" onMouseOut="status=''; return true;">License 
            Agreement</a></td>
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
            <td width="636" height="17" class=head3>apnscp License</td>
          </tr>
          <tr> 
            <td height="17" valign=center class=help>The following lists the key 
              for which you have been given for use with the apnscp.</td>
          </tr>
          <tr> 
            <td height="17" valign=center class=head4>License File</td>
          </tr>
          <tr> 
            <td height="20" valign=center class=cell1><tt> 
              <p nowrap> 
                <?php
   	$fp = fopen("/usr/apnscp/etc/.license","r");
	while (!feof($fp)) {
		$data = fgets($fp);
		echo nl2br($data);
	}
	fclose($fp);
   ?>
              </p>
              </tt></td>
          </tr>
          <tr> 
            
          <td height="17" valign=center class=cell1>If you have any questions 
            please contact <a href="mailto:license@apisnetworks.com">license@apnscp.com</a></td>
          </tr>
        </table>
		</td>
	</tr>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>
