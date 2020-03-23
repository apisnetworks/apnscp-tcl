<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	if (!$mimeEnabled) die("The requested module is disabled.");
	Login();
		
	if (isset($_POST['extension'])) {
		/* add new MIME type */
		CheckLocalServer($gDomainName,"mime","add",$_POST['mimetype'],$_POST['extension']);
	} else if (isset($_GET['remove'])) {
		/* remove it */
		CheckLocalServer($gDomainName,"mime","remove",$_GET['remove'])."<HR>";
	}
	$globalMimes = "";
	$localMimes = "";
	$mimes = GetMimeTypes($gDomainName,$globalMimes,$localMimes);
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
          <td class=head> Manage MIME Types</td>
                        <td align=right class=head3>
<script language="JavaScript">
	function popUpHelpWindow() {
		helpwin=window.open("https://<?php print($_SERVER['HTTP_HOST']); ?>/docs/en_US/site/oh_site_about_sendmail_mgr.htm","helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
		helpwin.focus();
	}
	function checkForm() {
		var extRegExp = /^[a-zA-Z0-9]+$/;
		var typeRegExp = /^[a-zA-Z0-9\/\.\+-]+$/;
		if (!extRegExp.test(document.forms[0].extension.value)) {
			alert('Extensions must be of the alphanumeric class, i.e. \'html\' and NOT \'.html\'');
			document.forms[0].extension.focus();
			return false;
		} else if (!typeRegExp.test(document.forms[0].mimetype.value)) {
			alert('Invalid MIME Type');
			document.forms[0].mimetype.focus();
			return false;
		}
		return true;
	}
</script>
         <a href="javascript:popUpHelpWindow()" onMouseOver="status='Click here for help'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">
		 <IMG SRC="https://<?php print($_SERVER['HTTP_HOST']); ?>/webhost/help_toolbar_gif" HEIGHT = "15" BORDER = "0" ALIGN = "absmiddle" WIDTH = "15"><font color=white>Help</font></a>

                </td>
               </tr>
    <tr>
          <td class=cell1 colspan=2> &nbsp; <b><a href="mimetypes.php" onMouseOver="status='Manage MIME Types'; return true;" onMouseOut="status=''; return true;">Manage 
            MIME Types</a></b> </td>
   </tr>
  </table>
 </td>
</tr>
</table><br>
<?php
	if (isset($_POST['extension'])) {
?>
		<table width=640 border=0 cellspacing=0 cellpadding=1>
			  <tr>
			  <td class=head>
			  <table width=640 border=0 cellspacing=0 cellpadding=1>
        <tr> 
          <td width="150" valign="middle" class=cell1> &nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
            <b>Status:</b>&nbsp;Successful! </td>
          <td width="487" align=left valign="middle" class=cell1><b>Result:</b>&nbsp;MIME 
            Type Added</td>
        </tr>
      </table> 
			  </td>
			  </tr>
			  </table> 
			  <br>
<?php 
	} else if (isset($_GET['remove'])) {
	?>
	<table width=640 border=0 cellspacing=0 cellpadding=1>
			  <tr>
			  <td class=head>
			  <table width=640 border=0 cellspacing=0 cellpadding=1>
        <tr> 
          <td width="150" valign="middle" class=cell1> &nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
            <b>Status:</b>&nbsp;Successful! </td>
          <td width="487" align=left valign="middle" class=cell1><b>Result:</b>&nbsp;MIME 
            Type Removed</td>
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
        <tr> 
          <td colspan=3 class=head3>Manage MIME Types</td>
        </tr>
        <tr> 
          <td colspan=3 class=help>MIME is a specification for formatting 
            non-ASCII messages so that they can be sent over the Internet. Add 
            new MIME types to handle how certain file extensions are parsed by 
            the browser.
			<li>When adding an extension, do not prefix it with a period '.'</li>
			<li>You can add multiple extensions to the same type by delimiting each with a space</li></td>
        </tr>
        <tr> 
          <td width="152" class=head4 valign="top">&nbsp;Extension:</td>
          <td width="400" class=head4 valign="top">&nbsp;MIME Type: </td>
          <td width="88" class=head4 valign="top">&nbsp;Actions: </td>
        </tr>
		<?php
			if (is_array($localMimes)) {
				while (list($key,$val) = each($localMimes)) {	
					?>
					<tr> 
					<td valign="middle" class=body bgcolor=white>&nbsp;<?php print($key); ?></td>
					<td valign="middle" class=body>&nbsp;<?php print($val); ?></td>
					<td class=body>&nbsp;
						<a href="mimetypes.php?remove=<?php print($key); ?>" onClick="return confirm('Are you sure you want to remove extension \'<?php print(trim($key)); ?>\'?');" 
							onMouseOver="status='Remove MIME extension \'<?php print(trim($key)); ?>\''; return true;" onMouseOut="status=''; return true;">
								<img border=0 src="/images/remove.gif" alt="Remove extension '<?php print(trim($key)); ?>'" width=20 height=20>
						</a>
					</td>
					</tr>
					<?php
				}
			}
		?>
		<tr>
			<td height=10 colspan=3><img src="/images/spacer.gif" alt="" height=10 /></td>
		</tr>
        <form action="mimetypes.php" method=post onSubmit="return checkForm();">
		<tr>
			<td colspan=3 class=head3>
			Add New MIME Type
			</td>
		</tr>
		<tr>
			<td class=head4>&nbsp;Extension:</td><td colspan=2 class=head4>&nbsp;MIME Type:</td>
		</tr>
		<tr>
			
          <td class=body>&nbsp;.<input type=text name=extension size=5 /></td>
			<td class=body colspan=2>&nbsp;<input type=text name=mimetype /></td>
		</tr>
        <tr> 
            <td height="26" colspan=3 align=center class=body>
              <input type=submit value="Add MIME Type"> </td>
        </tr>
	    </form>
		<tr>
			<td height=10 colspan=3 bgcolor=white><img src="/images/spacer.gif" alt="" height=10 /></td>
		</tr>
		<tr>
			<td colspan=3 class=head3>
				Globally-Defined MIME Types
			</td>
		</tr>
		<tr>
			<td class=help colspan=3>
				The following MIME types are ones that are pre-defined globally and cannot be removed nor modified.
			</td>
		</tr>
		<tr>
			<td class=head4>&nbsp;Extension
			</td>
			<td class=head4 colspan=2>&nbsp;MIME Type:</td>
		</tr>
		<?php
			$color = "listodd";
			if (is_array($globalMimes)) {
				while (list($key,$val) = each($globalMimes)) {	
					?>
					<tr>
						<td class="<?php print($color); ?>">
							&nbsp;<?php print($key); ?>
						</td>
						<td colspan=2 class="<?php print($color); ?>">
							&nbsp;<?php print($val); ?>
						</td>
					</tr>
					<?php
					if ($color == "listodd") $color = "listeven"; else $color = "listodd";	
				}
			}
		?>
      </table>
  </td>
 </tr>
</table>

<P>&nbsp;</P>
</BODY>
</HTML>
