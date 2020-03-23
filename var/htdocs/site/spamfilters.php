<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	
	if (isset($_POST['spamfilter'])) {
		CheckLocalServer($gDomainName,"filters","add",$_POST['spamfilter']);
	} else if (isset($_GET['delete'])) {
		CheckLocalServer($gDomainName,"filters","delete",$_GET['delete']);
	}
	$blockedFilters = "";
	GetSpamFilters($gDomainName,&$blockedFilters);
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
          <td class=head> Sendmail SMTP Server Manager </td>
          <td align=right class=head3> 
		    <script language="JavaScript">
	  	    function popUpHelpWindow() {
			   helpwin=window.open("https://<?php print($_SERVER['HTTP_HOST']); ?>/docs/en_US/site/oh_site_about_sendmail_mgr.htm","helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
			   helpwin.focus();
			}
			</script> 
		  	<a href="javascript:popUpHelpWindow()" onMouseOver="status='Click here for help'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">
			<IMG SRC="https://<?php print($_SERVER['HTTP_HOST']); ?>/webhost/help_toolbar_gif" HEIGHT = "15" BORDER = "0" ALIGN = "absmiddle" WIDTH = "15"><font color=white>Help</font></a> 
          </td>
        </tr>
        <tr> 
          <td class=cell1 colspan=2> &nbsp; <a href="index_html" onMouseOver="status='Aliases'; return true;" onMouseOut="status=''; return true;">Aliases</a> 
            <img src=red_gif width=4 height=4> <a href="sendmail_responders" onMouseOver="status='Responders'; return true;" onMouseOut="status=''; return true;">Responders</a> 
            <img src=red_gif width=4 height=4> <b> <a href="sendmail_spam" onMouseOver="status='Spam Filters'; return true;" onMouseOut="status=''; return true;">Spam 
            Filters</a> </b> </td>
        </tr>
      </table></td>
  </tr>
</table>
<p></p>
<?php
	if (isset($_POST['spamfilter'])) {
?>
		<table width=640 border=0 cellspacing=0 cellpadding=1>
			  <tr>
			  <td class=head>
			  <table width=640 border=0 cellspacing=0 cellpadding=1>
        <tr> 
          <td width="150" valign="middle" class=cell1> &nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
            <b>Status:</b>&nbsp;Successful! </td>
          <td width="487" align=left valign="middle" class=cell1><b>Result:</b>&nbsp;Spam 
            Filter Added</td>
        </tr>
      </table> 
			  </td>
			  </tr>
			  </table> 
			  <br>
<?php 
	} else if (isset($_GET['delete'])) {
	?>
	<table width=640 border=0 cellspacing=0 cellpadding=1>
			  <tr>
			  <td class=head>
			  <table width=640 border=0 cellspacing=0 cellpadding=1>
        <tr> 
          <td width="150" valign="middle" class=cell1> &nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
            <b>Status:</b>&nbsp;Successful! </td>
          <td width="487" align=left valign="middle" class=cell1><b>Result:</b>&nbsp;Spam 
            Filter Removed</td>
        </tr>
      </table> 
			  </td>
			  </tr>
			  </table> 
			  <br>
	<?php
	}
?>
<table border=0 cellspacing=0 cellpadding=0 width=640>
 <tr>
  <td class=head>
   <table border=0 cellspacing=1 cellpadding=1 width=640>
    <tr><td class=head3 colspan=2>Spam Filters</td></tr>
       <tr>
     <td class=head4>Filter</td>
     <td class=head4>Actions</td>
    </tr>
	<?php
		for ($i = 0; $i < sizeof($blockedFilters) && $blockedFilters != ""; $i++) {
	?>
    <tr>
     <td class=cell1>&nbsp;<em><?php print($blockedFilters[$i]); ?></em></td>
     <td class=cell1 nowrap>&nbsp;
      <a href="sendmail_spam?delete=<?php print($blockedFilters[$i]); ?>" onMouseOver="status='Remove Alias'; return true;" onMouseOut="status=''; return true;" 
	  	onClick="return confirm('Are you sure you want to remove \'<?php print($blockedFilters[$i]); ?>\' ?')"><img border=0 alt="Remove" src="/images/remove.gif"></a>
     </td>
    </tr>
	<?php
	   }
	?>
   </table>
  </td>
 </tr>
</table>
<p></p>
<script language="JavaScript">
	function checkForm() { 
		var regExp = /^[a-zA-Z0-9-\.@]+$/;
		if (!regExp.test(document.forms[0].spamfilter.value)) {
			alert("Invalid spam filter!");
			document.forms[0].spamfilter.focus();
			return false;
		}
		return true;
	}
</script>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
        <tr>
          <td colspan=2 class=head3>Add Spam Filter</td>
        </tr>
		<tr>
			<td colspan=2 class=help>Spam filters will block based upon the IP, host, and e-mail address.
			<li>When adding a spam filter, do not use wildcards, they are implicitly added</li>
			<li>Any filter added will block any e-mail, domain, or IP that matches 
              the criteria</li>
			<li>Subdomains of the domain will also be blocked</li>
			<li>To block an IP range, please input the first few numbers, e.g. to block all mail from 1.2.3.x input 1.2.3</li>
			<li>For per-user blocking, use <em>username@</em> for the spam filter.</li>
			</td>
		</tr>
        <form method=POST action="sendmail_spam"  onSubmit="return checkForm();">
          <tr> 
            <td class=cell1 valign=center>E-mail, Domain, or IP</td>
            <td class=cell1 valign=top><input type=text name=spamfilter maxlength=64> </td>
          </tr>
          <tr> 
            <td align=center class=cell1 colspan=2> 
				<input type=submit value='Add Spam Filter' onClick="return ('<?php print($gDomainName); ?>' == document.forms[0].spamfilter.value) ? confirm('Are you sure you want to add your own domain as spam filter ?') : true;"> 
				<input type=reset value="Reset"> 
			</td>
		  </tr>
        </form>
      </table></td>
  </tr>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>
