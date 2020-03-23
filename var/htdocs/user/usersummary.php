<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/userfunctions.php";
	Login();
	$services = GetServices($gDomainName);
		include "../global/constants.php";
	include "../global/graph.php";

	$myGraph = new Graph(120,120*.7 + 10);
	/* please check apnscpcore.php for class instantiation and
	   image dimensions */
	
	$myGraph->Clean();
	$d = split(" ",CheckLocalServer(GetUserNumRef($gDomainName,$gUserName),"uquota")); 
	$used = ($d[0]/1024);
	$quota = ($d[1]/1024);
	unset($d);
	if ($quota) {
		$myGraph->AddData("used", $used);
		$myGraph->SetColor("used",116,141,75);
	}
	$myGraph->AddData("free", $quota-$used);
   	$myGraph->SetColor("background",230,230,220);
	$myGraph->SetColor("outline",50,50,50);
	$myGraph->SetColor("shadow",186,186,167);
	$myGraph->SetColor("free",235,235,235);   
	$myGraph->DrawGraph(GRAPH_PIE_3D,
						OPTION_OUTLINE|OPTION_ANTIALIASED,
						$gDomainName.'-'.$gUserName.'dqus.png'
	);
	
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
          <td class=head> User Summary </td>
          <td align=right class=head3>
			  <script language="JavaScript">
				function popUpHelpWindow() {
				   helpwin=window.open("https://<?php print($_SERVER['HTTP_HOST']); ?>/docs/en_US/site/oh_site_about_site_summary.htm","helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
				   helpwin.focus();
				}
			  </script>
			  <a href="javascript:popUpHelpWindow()" onMouseOver="status='Click here for help'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">
				<IMG SRC="https://<?php print($_SERVER['HTTP_HOST']); ?>/webhost/help_toolbar_gif" HEIGHT = "15" BORDER = "0" ALIGN = "absmiddle" WIDTH = "15">
				<font color=white>Help</font>
			  </a> 
          </td>
        </tr>
        <tr> 
          <td class=cell1 colspan=2> &nbsp; <b> <a href="usersummary.php" onMouseOver="status='Configuration'; return true;" onMouseOut="status=''; return true;">Configuration</a></b></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table border=0 width=640 cellpadding=0 cellspacing=0>
  <tr>
    <td class=head> <table border=0 width=100% cellpadding=1 cellspacing=1>
        <tr>
          <td colspan=2 class=head3>Configuration</td>
        </tr>
        <tr> 
          <td class=cell1>&nbsp;Site Name</td>
          <td class=cell1 width=489>&nbsp;<?php print($gDomainName); ?></td>
        </tr>
        <tr> 
          <td class=cell1>&nbsp;Username</td>
          <td class=cell1 width=489>&nbsp;<?php print($gUserName); ?></td>
        </tr>
        <tr> 
          <td class=cell1>&nbsp;Full Name</td>
          <td class=cell1>&nbsp;<?php print(GetFullName($gDomainName,$gUserName)); ?></td>
        </tr>
        <tr> 
          <td class=cell1>&nbsp;Disk Used/Allocated</td>
          <td class=cell1 width=489> 
			   <?php
					printf('&nbsp;<img src="/images/graphs/'.$gDomainName.'-'.$gUserName.'dqus.png'.'" alt="Disk Quota Graph" />');
				?>
			   <br />
			   <?php
					printf('&nbsp;%s (%.2f MB/%.2f MB)', ($quota) ? ceil($used/$quota*100).'%'  : sprintf('Unlimited'), 
												$used, 
												($quota) ? $quota : sprintf('Unlimited')
					);
			   ?> 
          </td>
        </tr>
        <tr> 
          <td class=cell1 valign=top>&nbsp;Services & Options </td>
          <td class=cell1> <table border=0 cellspacing=1 cellpadding=1>
              <tr> 
                <td class=cell1> <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Apache Web Server: <a href='http://www.<?php print($gDomainName); ?>/~<?php print($gUserName); ?>/' target='_blank'>http://www.<?php print($gDomainName); ?>/~<?php print($gUserName); ?></a><br> 
                  <?php 
				  	if ($subdomainAliases) {
						?>
						&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Domain 
						Alias: <a href="<?php printf("http://%s.%s/",$gUserName,$gDomainName); ?>" target="_blank">
							<?php printf("http://%s.%s/",$gUserName,$gDomainName); ?>
						</a> 
						<?php
					}
				  	?>
                </td>
              </tr>
              <tr> 
                <td class=cell1><img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Public HTML directory:<br> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                  &nbsp;&nbsp;&nbsp;&nbsp;<?php printf("/home/%s/public_html/",$gUserName); ?>
				</td>
              </tr>
			   <tr> 
                <td class=<?php ($_COOKIE['vhbackup_enabled']) ? print("cell1") : print("disabled"); ?>> 
                  <img src="<?php ($_COOKIE['vhbackup_enabled']) ? print("/images/check.gif") : print ("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  Backup/Restore
                  </td>
              </tr>
              <tr> 
                <td class=<?php EmailEnabled($gDomainName,$gUserName) ? print("cell1") : print("disabled"); ?>> 
                  <img src="<?php EmailEnabled($gDomainName,$gUserName) ? print("/images/check.gif") : print ("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  E-Mail Access
                  <?php 
				  	if ($_COOKIE['sqmail_enabled']) {
					?>
					<br>
                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    SquirrelMail Web-based Email: <a href="<?php print($squirrelmailPath); ?>" target="_blank">Read Email</a> 
				  <?php
				    }
					?></td>
              </tr>
              <tr> 
                <td class=<?php FtpEnabled($gDomainName,$gUserName) ? print("cell1") : print ("disabled"); ?>> 
                  <img src="<?php FtpEnabled($gDomainName,$gUserName) ? print("/images/check.gif") : print ("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  FTP Access
				</td>
              </tr>
              <tr> 
                <td class=<?php TelnetEnabled($gDomainName,$gUserName) ? print("cell1") : print ("disabled"); ?>> 
                  <img src="<?php TelnetEnabled($gDomainName,$gUserName) ? print("/images/check.gif") : print ("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  SSH2 Access
				</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</BODY>
</HTML>
