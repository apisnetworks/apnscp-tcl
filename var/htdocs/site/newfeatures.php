<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
<script language="JavaScript">
<!--
function checkForm() {
	if (document.forms[0].title.value == "") {
		alert("Please input a title");
		document.forms[0].title.focus();
		return false;
	}
	else if(document.forms[0].category.value == "" ) {
		alert("Please select a category");
		document.forms[0].category.focus();
		return false;
	}
	else if(document.forms[0].description.value == "" ) {
		alert("Please enter a description");
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
          <td class=head> Request New Features</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="changelog.php" onMouseOver="status='Changelog'; return true;" onMouseOut="status=''; return true;">Changelog</a> 
            <img src="/images/red.gif" width=4 height=4> <a href="pendingchanges.php" onMouseOver="status='View Change Submissions'; return true;" onMouseOut="status=''; return true;">View 
            Change Submissions</a> <img src="/images/red.gif" width=4 height=4> 
            <a href="newfeatures.php" onMouseOver="status='Request New Features'; return true;" onMouseOut="status=''; return true;"><strong>Request 
            New Features</strong></a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
<form action="pendingchanges.php" method=post onSubmit="return checkForm();">
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
        			
            
          <td class=head3 colspan=2>Request New Features</td>
			    </tr>
		        <tr> 
					
            
          <td class=help colspan=2 valign=center>Have a brand new idea to submit to the 
            control panel? We are open ears, let's hear your brand new idea. <br>
            <strong>Note</strong> : in an effort to minimize duplicates, please 
            double check '<a href="pendingchanges.php" onmouseover="status='View Pending Changes'; return true;" onmouseout="status=''; return true;">View Pending Changes</a>' first before submitting an idea 
            to see whether or not the idea initially passed.<br>
			<li>When using the priority field, please use your discretion - 1 has the lowest priority, 10 has the highest</li>
          </td>
        		</tr>
				<tr> 
				  
          <td class=cell2 width=140> <strong>Title:</strong> </td>
				  <td class=cell2 width=500>
				  <input type=text name=title class=s maxlength=60 size=60>
				  </td>
		  </tr>
		  <tr>
		  	<td class=cell2><strong>Category:</strong></td>
			<td class=cell2><select name=category>
			    <option value="">Please Select</option>
				<option value="Bug Fix">Bug Fix</option>
				<option value="Enhancement">Enhancement</option>
				<option value="New Feature">New Feature</option>
				<option value="Miscellaneous">Miscellaneous</option>
			</select></td>
		  </tr>
		  <tr>
		  	<td class=cell2>
			<strong>Priority:</strong>
			</td>
			<td class=cell2><select name=priority>
				<option value=1 checked>1</option>
				<option value=2>2</option>
				<option value=3>3</option>
				<option value=4>4</option>
				<option value=5>5</option>
				<option value=6>6</option>
				<option value=7>7</option>
				<option value=8>8</option>
				<option value=9>9</option>
				<option value=10>10</option>
			</select></td>	
		  </tr>
		  <tr>
		  	<td class=cell2 valign=top><strong>Description:</strong></td>
            <td class=cell2><textarea name=description rows=15 cols=60></textarea></td>
		  </tr>
		  <tr>
			<td class=cell2 colspan=2 align=center><input type=hidden name=go value=1><input type=submit value=Submit><input type=reset value=Reset></td>
		  </tr>
		  </table>
		  </td>
		  </tr>
</form>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>
