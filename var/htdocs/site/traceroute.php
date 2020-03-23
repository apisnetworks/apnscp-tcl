<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	if (!$tracerouteEnabled['site']) die("The requested module is disabled.");
	Login();
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
<script language="JavaScript">
<!--
function checkForm() {
	var re1 = /^[a-zA-Z0-9-.]+\.[a-zA-Z0-9]+$/;
	var re2 = /^[0-9.]+$/;
 	if (re1.test(document.forms[0].hostname.value) || re2.test(document.forms[0].hostname.value))
		return true;
	else {
		alert("Please input a valid hostname or IP.");
		document.forms[0].hostname.focus();
		return false;
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
          <td class=head> Traceroute</td>
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
          <td class=cell1 colspan=2> &nbsp; <strong><a href="traceroute.php" onMouseOver="status='Traceroute'; return true;" onMouseOut="status=''; return true;">Traceroute</a></strong> 
            <img src="/images/red.gif" width=4 height=4> <a href="whois.php" onMouseOver="status='Whois'; return true;" onMouseOut="status=''; return true;">Whois</a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
<form method=POST action="traceroute.php"  onSubmit="return checkForm();">
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
        			<td colspan=2 class=head3>Traceroute</td>
			    </tr>
		        <tr> 
					<td class=help valign=center colspan=2>Enter the IP or hostname in the 
            		following field and hit 'Submit' to calculate the route from this 
            		hosting box to the destination IP/hostname</td>
        		</tr>
				<tr> 
				  <td class=cell1 width=85 valign=center>Hostname/IP</td>
				  <td class=cell1 width="100%" valign=top><input type=text name=hostname value="<?php print(@$_POST['hostname']); ?>"></td>
				</tr>
				<tr>
            		
            <td class=cell1 valign=top>Result<br><img src="/images/spacer.gif" alt="" height=1 width=85 /></td>
					<td class=cell1>
<code><pre>
<?php
						if (isset($_POST['hostname'])) {
							echo trim(Traceroute($_POST['hostname']));
						}
?>
</pre></code>
					</td>
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
