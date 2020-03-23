<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	if (!$billingEnabled) die("The requested module is disabled.");
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
          <td class=head> Billing</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="billing.php" onMouseOver="status='Billing'; return true;" onMouseOut="status=''; return true;"><strong>Billing</strong></a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
        <tr> 
          <td colspan=5 class=head3>Billing</td>
        </tr>
        <tr> 
          <td class=help colspan=5 valign=center>View prior transactions regarding your 
            service.<br>
            There may be a time discrepancy between billing and apparition.</td>
        </tr>
       <tr> 
			<td class=head5><strong>Date:</strong></td>
             <td class=head5><strong>Payment Method:</strong></td>
             <td class=head5><strong>Transaction Reference:</strong></td>
             <td class=head5><strong>Fee:</strong></td>
			 <td class=head5><strong>Remarks:</strong></td>
	    </tr>
		<?php
			mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
			mysql_select_db($mysql['standard']['database']);
			$q = mysql_query("select date, transref, method, fee, remarks from billing where domain = '".$gDomainName."'");
			$color = "listodd";
			while ($row = mysql_fetch_row($q)) {
			?>
			<tr>
				<td class=<?php print($color); ?>><?php print(date("m/d/Y",$row[0])); ?></td>
				<td class=<?php print($color); ?>>
					<?php 
						if ($row[2] == "credit")
							print "Credit Card";
						else
							print($row[2]);
					?>
				</td>
				<td class=<?php print($color); ?>><?php print($row[1]); ?></td>
				<td class=<?php print($color); ?>><?php printf("%s%.2f",$gLocale['currency_symbol'],$row[3]); ?></td>
				<td class=<?php print($color); ?>><?php print(stripslashes($row[4])); ?></td>
			</tr>
			<?php
				if ($color == "listodd") $color = "listeven"; else $color = "listodd";
			}
		?>
		</table></td>
  </tr>
</table>
</BODY>
</HTML>
