<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	if (!$whoisEnabled['user']) die("The requested module is disabled.");
	Login();
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
<script language="JavaScript">
<!--
function checkForm() {
	var re = /^[a-z0-9-]+\.(com|net|org|edu)$/i;
	if (re.test(document.forms[0].domain.value))
		return true;
	else {
		alert("Please input a valid domain name.");
		document.forms[0].domain.focus();
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
          <td class=head> Whois</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="traceroute.php" onMouseOver="status='Traceroute'; return true;" onMouseOut="status=''; return true;">Traceroute</a>
            <img src="/images/red.gif" width=4 height=4> <a href="whois.php" onMouseOver="status='Whois'; return true;" onMouseOut="status=''; return true;"><strong>Whois</strong></a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
<form method=POST action="whois.php" onSubmit="return checkForm();">
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
        			
            <td colspan=2 class=head3>Whois</td>
			    </tr>
		        <tr> 
					
            <td class=help valign=center colspan=2>Enter the domain name for which 
              you would like to obtain registration records from and press Submit 
              to submit the query.
              <li>Domain names are the only types handled - that means no nameserver 
                nor registrar records</li>
              <li>Only domains of the .com/.edu/.net/.org family may be queried</li></td>
        		</tr>
				<tr> 		
            		<td class=cell1 width=75 valign=center>Domain</td>
				    <td class=cell1 width="100%" valign=top><input type=text name=domain value="<?php print(@$_POST['domain']); ?>"></td>
				</tr>
				<tr>		
            		<td class=cell1 valign=top>Result<br><img src="/images/spacer.gif" alt="" height=1 width=85 /></td>
					<td class=cell1>
<code><pre>
<?php 
							if (isset($_POST['domain'])) {
								echo trim(Whois($_POST['domain']));
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
