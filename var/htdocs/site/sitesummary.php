<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	include "../global/constants.php";
	include "../global/graph.php";	
	$services = GetServices($gDomainName);
	Login();
	
	$myGraph = new Graph(120,120*.7 + 10);
	/* please check apnscpcore.php for class instantiation and
	   image dimensions */
    $bwUsage = CheckLocalServer($gDomainName,"bwusage");
	$diskUsage = (CheckLocalServer($gDomainName,"quota")/1024.);
	$myGraph->Clean();
	
	$myGraph->AddData("used", $bwUsage);
	$myGraph->SetColor("used",116,141,75);
	$myGraph->AddData('free',$_COOKIE['bandwidth_threshold']-$bwUsage);
   	$myGraph->SetColor("background",230,230,220);
	$myGraph->SetColor("outline",50,50,50);
	$myGraph->SetColor("shadow",186,186,167);
	$myGraph->SetColor("free",235,235,235);  
	$myGraph->DrawGraph(GRAPH_PIE_3D,
						OPTION_OUTLINE|OPTION_ANTIALIASED,
						$gDomainName.'-'.$gUserName.'bwss.png'
	);
	
	
	$myGraph->Clean();
	$myGraph->AddData("used", $diskUsage);
	$myGraph->SetColor("used",116,141,75);
	if ($_COOKIE['diskquota_quota']) {
		$myGraph->AddData("free", $_COOKIE['diskquota_quota']-$diskUsage);
		$myGraph->SetColor("free",235,235,235);  
	}	
   	$myGraph->SetColor("background",230,230,220);
	$myGraph->SetColor("outline",50,50,50);    
	$myGraph->SetColor("shadow",186,186,167);
	$myGraph->DrawGraph(GRAPH_PIE_3D,
						OPTION_OUTLINE|OPTION_ANTIALIASED,
						$gDomainName.'-'.$gUserName.'dqss.png'
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
          <td class=head> Site Summary </td>
          <td align=right class=head3> 
			  <script language="JavaScript">
				function popUpHelpWindow() {
					helpwin=window.open("https://<?php print($_SERVER['HTTP_HOST']); ?>/docs/en_US/site/oh_site_about_site_summary.htm","helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
					helpwin.focus();
				}
function popUpHelpWindow2(flag) {
           var myfile = flag
           helpwin=window.open("https://<?php print($_SERVER['HTTP_HOST']); ?>/docs/en_US/site/" + myfile,"helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
           helpwin.focus();
        }
			  </script>
			
			  <a href="javascript:popUpHelpWindow()" 
			  	onMouseOver="status='Click here for help'; return true;" 
				onMouseOut="status=''; return true;" onClick="status=''; return true;"><IMG SRC="/webhost/help_toolbar_gif" HEIGHT = "15" BORDER = "0" ALIGN = "absmiddle" WIDTH = "15"><font color=white>Help</font>
			  </a> 
          </td>
        </tr>
        <tr> 
          <td class=cell1 colspan=2> &nbsp; <b> <a href="index_html" onMouseOver="status='Configuration'; return true;" onMouseOut="status=''; return true;">Configuration</a> 
            </b> 
            <?php 
				// feel free to remove this clause
				if ($gUserName != "demosite") { 
				?>
            <img src="/images/red.gif" width=4 height=4> <a href="/webhost/services/virtualhosting/siteadmin/siteinfo/form_editAdmin" onMouseOver="status='Change Administrator'; return true;" onMouseOut="status=''; return true;">Change 
            Administrator</a>
            <?php } ?>
          </td>
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
          <td class=cell1 width=175>&nbsp;&nbsp;Site Name</td>
          <td class=cell1 width=465>&nbsp;<?php print($gDomainName); ?></td>
        </tr>
        <tr> 
          <td class=cell1>&nbsp;&nbsp;Email Contact</td>
          <td class=cell1 width=465>&nbsp;<?php print(CheckLocalServer($gDomainName,"getemail"));?></td>
        </tr>
        <tr> 
          <td class=cell1>&nbsp;&nbsp;Administrator User Name</td>
          <td class=cell1 width=465>&nbsp;<?php print($gDomainName); ?></td>
        </tr>
        <tr> 
          <td class=cell1>&nbsp;&nbsp;Name Based Address</td>
          <td class=cell1 width=465>&nbsp;<?php print ($_COOKIE['ipinfo_ipaddrs']); ?></td>
        </tr>
        <TR> 
          <TD class=cell1 valign=top>&nbsp;&nbsp;Disk Usage</TD>
      <TD class=cell1> 
		   <?php
				printf('&nbsp;<img src="/images/graphs/'.$gDomainName.'-'.$gUserName.'dqss.png'.'" alt="Disk Quota Graph" />');
			?>
		   <br />
		   <?php
				printf('&nbsp;%s%% (%u MB/%s MB)', (isset($_COOKIE['diskquota_quota']) ? ceil($diskUsage/$_COOKIE['diskquota_quota']*100)  : sprintf('Unlimited')), 
											ceil($diskUsage), 
											(isset($_COOKIE['diskquota_quota']) ? $_COOKIE['diskquota_quota'] : sprintf('Unlimited'))
				);
		   ?>
	  </TD>
    </TR>
        <TR> 
          <TD class=cell1 valign=top>&nbsp;&nbsp;Bandwidth Usage</TD>
          <TD class=cell1> 
				<?php
				printf('&nbsp;<img src="/images/graphs/'.$gDomainName.'-'.$gUserName.'bwss.png'.'" alt="Bandwidth Graph" />');
				?>
				<br />
				<?php
					printf('&nbsp;%u%% (%.2f GB/%.2f GB)', ceil($bwUsage/$_COOKIE['bandwidth_threshold']*100), 
												($bwUsage/1024./1024./1024.), 
												($_COOKIE['bandwidth_threshold']/1024./1024./1024.)
					);
				?>
		  </TD>
        </TR>
        <tr> 
          <td class=cell1>&nbsp;&nbsp;Users</td>
          <td class=cell1 width=465>&nbsp;<?php printf("%d/%d",GetUserAmount($gDomainName),$_COOKIE['users_maxusers']); ?></td>
        </tr>
        <tr> 
          <td class=cell1 valign=top>&nbsp;&nbsp;Services & Options </td>
          <td class=cell1> <table border=0 cellspacing=1 cellpadding=1>
              <tr>
                <td class=cell1> 
				  <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Domain Aliasing 
				  <?php
				  	$domains = GetDomainAliases($gDomainName);
					!is_array($domains) ? print("(NULL)") : printf("(%s)",join(", ",$domains));
				  ?>
				</td>
              </tr>
              <tr>
                <td class=cell1> <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0">
                  Bandwidth Monitor (for cycle beginning <?php print(date("Y-m-d",strtotime(CheckLocalServer($gDomainName,"bwstart")))); ?>)<br> 
                  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Used: <?php printf("%.2f MB (%.2f KB)",$bwUsage/1024./1024.,$bwUsage/1024.); ?><br />
                  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Threshold: <?php printf("%.2f MB (%.2f KB)",$_COOKIE['bandwidth_threshold']/1024/1024.,$_COOKIE['bandwidth_threshold']/1024.); ?>
                  </td>
              </tr>
			  <?php
			  	if ($urchin4Enabled) {
					?>
					<tr> 
						<td class=cell1>
							<img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
						  	Urchin 5 Web Analyzer
						</td>
					</tr>
					<?php
			    }
			  ?>
              <tr>
                <td class=cell1> <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Apache Web Server: <a href="http://www.<?php print($gDomainName); ?>/" target="_blank">http://www.<?php print($gDomainName); ?>/</a><br>
				  <?php
				  if (!$_COOKIE['ipinfo_namebased']) { ?>
				  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
				  Domain Preview: <a href="http://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/" target="_blank">http://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/</a> 
				  <br>
				  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
				  SSL Preview: <a href="https://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/" target="_blank">https://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/</a> 
				  <?php
				  } else { ?>
				  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
				  Domain Preview: <a href="http://<?php print($_SERVER["SERVER_NAME"]); ?>/<?php print($gDomainName); ?>/" target="_blank">http://<?php print($_SERVER["SERVER_NAME"]); ?>/<?php print($gDomainName); ?>/</a> 
				  <?php
				  }
				  ?>
				</td>
              </tr>
				  <tr>
					<td class="<?php in_array("cgi",$services) ? print("cell1") : print("disabled"); ?>"> &nbsp;&nbsp;&nbsp;&nbsp; 
					  <img src=<?php in_array("cgi",$services) ? print("/images/check.gif") : print("/images/blank.gif"); ?> align="textcenter" width=16 height=16 border="0"> 
					  CGI: 
					  <?php
					  	if (in_array("cgi",$services)) {
						?>
					  <a href="javascript:popUpHelpWindow2('oh_site_about_cgi.htm')" onMouseOver="status='Click here for details'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">details</a> 
					  <br> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
					  Script Alias: <?php print(GetCGIAlias($gDomainName)); ?> 
					  <?php
					  }
					  ?>
					  </td>
				  </tr>
              <tr>
                <td class="<?php in_array("ssi",$services) ? print("cell1") : print("disabled");?>">
					&nbsp;&nbsp;&nbsp;&nbsp; <img src="<?php in_array("ssi",$services) ? print("/images/check.gif") : print("/images/blank.gif");?>" align="textcenter" width=16 height=16 border="0"> 
                  	Server Side Includes
				</td>
              </tr>
              <tr>
                <td class="<?php in_array("tomcat4",$services) ? print("cell1") : print("disabled");?>"> 
                  &nbsp;&nbsp;&nbsp;&nbsp;
				  <img src="<?php in_array("tomcat4",$services) ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  Tomcat 4
				</td>
              </tr>
              <tr>
                <td class="<?php in_array("mod_perl",$services) ? print("cell1") : print("disabled");?>"> 
                  &nbsp;&nbsp;&nbsp;&nbsp;
				  <img src="<?php in_array("mod_perl",$services) ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  Modperl for Apache
                  <?php if (in_array("mod_perl",$services)) { ?>
                  : <a href="javascript:popUpHelp('oh_site_about_mod_perl.htm')" onMouseOver="status='Click here for details'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">details</a> 
                  <?php
				  	if (in_array("mod_perl", $services)) {
						?>
						<br> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
						Alias: <?php print(GetPerlAlias($gDomainName)); ?>
						<?php
				  	}
				   } 
				   ?>
                </td>
              </tr>
			  <?php
			  	if ($moddtclEnabled) {
					?>
					  <tr> 
						<td class=cell1> &nbsp;&nbsp;&nbsp;&nbsp; <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
						  mod_dtcl Tcl module for Apache</td>
					  </tr>
					<?php
				}
			  	if ($modpythonEnabled) {
					?>
				 <tr> 
    	           <td class=cell1> &nbsp;&nbsp;&nbsp;&nbsp; <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
        	          mod_python Python module for Apache</td>
	              </tr>	
				<?php
			  	}
			  ?>
              <tr>
                <td class="<?php in_array("weblogs",$services) ? print("cell1") : print("disabled");?>">
					&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php in_array("weblogs",$services) ? print("/images/check.gif") : print("/images/blank.gif");?>" align="textcenter" width=16 height=16 border="0"> 
                  	Generate Web Logs
				</td>
              </tr>
              <tr>
                <td class=<?php in_array("frontpage",$services) ? print("cell1") : print("disabled"); ?>> 
                  &nbsp;&nbsp;&nbsp;&nbsp; <img src="<?php in_array("frontpage",$services) ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  FrontPage Server Extensions </td>
              </tr>
              <?php
				if ($_COOKIE['mivamerchant_enabled']) {
				?>
              <tr>
                <td class=cell1> <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Miva Merchant </td>
              </tr>
			  <?php
				}
				if ($oscommerceEnabled) {
				?>
              <tr>
                <td class=cell1> <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  osCommerce </td>
              </tr>
              <?php
				}
				?>
              <tr>
                <td class=<?php ($_COOKIE['files_enabled']) ? print("cell1") : print("disabled"); ?>> 
				<img src=<?php ($_COOKIE['files_enabled']) ? print("/images/check.gif") : print("/images/blank.gif"); ?> align="textcenter" width=16 height=16 border="0"> 
                  File Manager </td>
              </tr>
              <tr>
                <td class=<?php ($_COOKIE['vhbackup_enabled']) ? print("cell1") : print("disabled"); ?>> 
				<img src=<?php ($_COOKIE['vhbackup_enabled']) ? print("/images/check.gif") : print("/images/blank.gif"); ?> align="textcenter" width=16 height=16 border="0"> 
                  Backup/Restore </td>
              </tr>
              <tr>
                <td class="<?php ($_COOKIE['sendmail_enabled']) ? print("cell1") : print("disabled"); ?>"> 
                  <img src="<?php ($_COOKIE['sendmail_enabled']) ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  POP3 + Imap Server </td>
              </tr>
              <?php if ($_COOKIE['sendmail_enabled']) { ?>
              <tr>
                <td class=cell1> <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Sendmail SMTP Server: <?php print($_COOKIE['sendmail_mailserver']); ?>
                </td>
              </tr>
              <tr>
                <td class=cell1> &nbsp;&nbsp;&nbsp;&nbsp; <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Majordomo Mailing List Server </td>
              </tr>
              <tr>
                <td class=cell1> &nbsp;&nbsp;&nbsp;&nbsp; <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  Vacation Auto-Responder/Email Forward </td>
              </tr>
              <?php } ?>
              <tr>
                <td class=<?php in_array("sqmail",$services) ? print("cell1") : print("disabled"); ?>> 
                  <img src=<?php in_array("sqmail",$services) ? print("/images/check.gif") : print("/images/blank.gif"); ?> align="textcenter" width=16 height=16 border="0"> 
                  SquirrelMail Web-based Email: 
                  <?php in_array("sqmail",$services) ? printf("<a href=\"%s\" target=\"_blank\">Read Email</a>",$squirrelmailPath) : print (""); ?>
                </td>
              </tr>
              <tr> 
                <td class="<?php DevelopmentEnabled($gDomainName) ? print("cell1") : print("disabled"); ?>"> 
                  <img src="<?php DevelopmentEnabled($gDomainName) ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  Development (gcc, development libs)</td>
              </tr>
              <tr>
                <td class="<?php TelnetEnabled($gDomainName,$gUserName) ? print("cell1") : print("disabled"); ?>"> 
                  <img src="<?php TelnetEnabled($gDomainName,$gUserName) ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  OpenSSH Secure Shell </td>
              </tr>
              <tr> 
                <td class=<?php ($_COOKIE['proftpd_ftpserver']) ? print ("cell1") : print("disabled"); ?>> 
                  <img src="<?php ($_COOKIE['proftpd_ftpserver']) ? print ("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  ProFTPD FTP Server: <?php print($_COOKIE['proftpd_ftpserver']); ?> 
                </td>
              </tr>
              <tr>
                <td class="<?php AnonFtpEnabled($gDomainName) ? print("cell1") : print("disabled"); ?>">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="<?php AnonFtpEnabled($gDomainName) ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
					Anonymous FTP
				</td>
              </tr>
              <tr> 
                <td class="<?php $_COOKIE['mysql_enabled'] ? print("cell1") : print("disabled"); ?>">
					<img src="<?php $_COOKIE['mysql_enabled'] ? print("/images/check.gif") : print("/images/blank.gif"); ?>" align="textcenter" width=16 height=16 border="0"> 
                  	MySQL
				</td>
              </tr>
			  <?php
			  	if ($_COOKIE['mysql_enabled'] && $phpmyadminEnabled) {
				?>
              <tr> 
                <td class=cell1>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
                  	<a href="<?php print($phpmyadminPath); ?>" target="_blank">phpMyAdmin</a></td>
              </tr>
			  <?php
			  	}
				if ($postgresqlEnabled) {
				   ?>
					<tr> 
					<td class="cell1">
						<img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
						PostgreSQL
					</td>
				  </tr>
				  <?php
					if ($phppgadminEnabled) {
					?>
				  <tr> 
					<td class=cell1>
						&nbsp;&nbsp;&nbsp;&nbsp; <img src="/images/check.gif" align="textcenter" width=16 height=16 border="0"> 
					  	<a href="<?php print($phppgadminPath); ?>" target="_blank">phpPgAdmin</a></td>
				  </tr>
				  <?php
					}
				}
			   ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</BODY>
</HTML>
