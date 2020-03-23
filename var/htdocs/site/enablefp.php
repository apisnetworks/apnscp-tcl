<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	if (!$frontpageControl) die("The requested module is disabled.");
	Login();
	
	if (isset($_POST['frontpage'])) {
		CheckLocalServer($gDomainName,"frontpage",$_POST['frontpage']);
	}
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
 </HEAD>
<BODY leftmargin = "15" topmargin = "2" marginwidth = "15" marginheight = "2" bgcolor = "#ffffff">
 <table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr>
   <td class=head>
     <table width=640 border=0 cellspacing=1 cellpadding=1>
       <tr>
          <td class=head> Enable/Disable FrontPage</td>
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
          <td class=cell1 colspan=2> &nbsp; <b><a href="enablefp.php" onMouseOver="status='Enable/Disable FrontPage'; return true;" onMouseOut="status=''; return true;">Enable/Disable 
            FrontPage </a> </b> </td>
   </tr>
  </table>
 </td>
</tr>
</table><br>
<?php
	if (isset($_POST['frontpage'])) {
?>
		<table width=640 border=0 cellspacing=0 cellpadding=1>
			  <tr>
			  <td class=head>
			  <table width=640 border=0 cellspacing=0 cellpadding=1>
        <tr> 
          <td width="150" valign="middle" class=cell1> &nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
            <b>Status:</b>&nbsp;Successful! </td>
          <td width="487" align=left valign="middle" class=cell1><b>Result:</b>&nbsp;FrontPage 
            service modification successful, you will need to relogin to the console 
            for changes to be visible. </td>
        </tr>
      </table> 
			  </td>
			  </tr>
			  </table> 
			  <br>
<?php } ?>
<table border=0 cellspacing=0 cellpadding=0 width=640>
 <tr>
  <td class=head>
   <table border=0 cellspacing=1 cellpadding=1 width=640>
    <tr>
          <td class=head3>Enable/Disable FrontPage</td>
        </tr>
       <tr>
          <td class=help>Normal .htaccess files are incompatible with Microsoft 
            FrontPage server extensions, so if you wish to take full advantage 
            of the .htaccess file, you will want to disable FrontPage.  This process
			may take a few minutes depending upon server load, please be patient.</td>
    </tr>
         <tr>
     <td class=cell1 nowrap>
     </td>
    </tr>
 	  <?php
	  	if ($_COOKIE['frontpage_enabled']) {
	  ?>   
	<tr>
      <form action="enablefp.php" method=post>			
     <td class=cell1 align=center>
	  <input type=hidden name=frontpage value=0>
      <input type=submit value="Disable FrontPage">
	 </td>
	 </form>
	</tr>
	 <?php
	  } else {
	 ?>
	 <tr>
	 <form action="enablefp.php" method=post>
	 	<td class=cell1 align=center>
	  <input type=hidden name=frontpage value=1>
      <input type=submit value="Enable FrontPage">
	  </td>
	  </form>
	 </tr>
	 <?php
	 }
	 ?>
   </table>
  </td>
 </tr>
</table>

<P>&nbsp;</P>
</BODY>
</HTML>
