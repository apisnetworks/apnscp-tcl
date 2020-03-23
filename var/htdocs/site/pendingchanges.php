<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	Login();
	
	mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
	mysql_select_db($mysql['standard']['database']);
	if (isset($_POST['go'])) { // we've got data!
		if (getenv(HTTP_CLIENT_IP)) 
			$ip = getenv(HTTP_CLIENT_IP);
		else 
			$ip = getenv(REMOTE_ADDR);
		$q = mysql_query("insert into features values('','".addslashes(htmlentities($_POST['title'],ENT_QUOTES))."', '".addslashes(htmlentities($_POST['description'],ENT_QUOTES))."', '".$gUserName."', '".$_POST['priority']."', '".time()."','".$_POST['category']."','Pending','');");
		mail($featureEmail,"New feature request!","Submitted by: ".$gUserName."\n"."IP: ".$ip."\nTitle: ".$_POST['title']."\nDescription: ".$_POST['description']);
	}
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
          <td class=head> View Change Submissions</td>
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
            <img src="/images/red.gif" width=4 height=4> <a href="pendingchanges.php" onMouseOver="status='View Pending Changes'; return true;" onMouseOut="status=''; return true;"><strong>View 
            Change Submissions</strong></a> <img src="/images/red.gif" width=4 height=4> 
            <a href="newfeatures.php" onMouseOver="status='Request New Features'; return true;" onMouseOut="status=''; return true;">Request 
            New Features</a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=2 width=100%>
				<tr> 
        			
            
          <td class=head3 colspan=8>View Change Submissions</td>
			    </tr>
		        <tr> 
					
            
          <td class=help  colspan=8 valign=center>This page lists all changes 
            submitted by the users of the control panel. <br>
            Changes are listed by date posted, descending.<br>
			<!-- 
				filters could be handy
				when/if it grows
			-->
          </td>
        		</tr>
				<tr>
		  	<td colspan=8 height=5></td>
		  </tr>
		  <?php
			$priorityColors = array("#000000","#330000","#440000","#663333","#660000","#993333","#990000","#CC3333","#CC0000","#FF0000");
		  	$q = mysql_query("select title, description, username, priority, timestamp, category, status, response from features");
			$color = "listeven";
			while ($row = mysql_fetch_row($q)) {
			?>
				<tr> 
               		<td class=head5><strong>Posted By:</strong></td>
               		<td align=center class=<?php print($color); ?>><?php print($row[2]); ?></td>
					<td class=head5><strong>Date Posted:</strong></td><td class=<?php print($color); ?>><?php echo date("M j Y g:i:s A",$row[4]); ?></td>
					<td class=head5><strong>Priority:</strong></td><td align=center class=<?php print($color); ?>><?php echo "<strong><font color=\"".$priorityColors[($row[3]-1)]."\">".$row[3]."</font></strong>"; ?></td>
					<td class=head5><strong>Status:</strong></td><td align=center class=<?php print($color); ?>><?php print($row[6]); ?></td>
				</tr>
				<tr>
					<td class=head5><strong>Title:</strong></td><td colspan=7 class=<?php print($color); ?>><?php print(stripslashes($row[0])); ?></td>
				</tr>
				<tr>
					<td class=head5><strong>Abstract:</strong></td><td colspan=7 class=<?php print($color); ?>>
					<?php print(stripslashes($row[1])); ?>
					</td>
				</tr>
				<?php
					if ($row[7]) {
					?>
				<tr>
					<td class=head5><strong>Response:</strong></td><td colspan=7 class=<?php print($color); ?>>
					<?php print(stripslashes($row[7])); ?>
					</td>
				</tr>
				<?php
				}
				?>
		  <tr>
		  	<td height=5 colspan=8></td>
		  </tr>
		  <?php
		  if ($color == "listeven") $color = "listodd"; else $color = "listeven";
		  }
		  ?>
		  </table>
		  </td>
		  </tr>

</table>
<P>&nbsp;</P>
</BODY>
</HTML>
