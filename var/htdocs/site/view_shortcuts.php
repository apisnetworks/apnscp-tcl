<?php
        /* Copyright 2003 Apis Networks
        *  Please read the attached LICENSE
        *  included within the distribution
        *  for further restrictions.
        */
        /**********************************************
        * Basic front-end skin for site administrators
        * Please read the attached "LICENSE" file for
        * further licensing information and indemnifications
        * any modifications done to the view_shortcuts.php 
        * is not covered through support, modify at 
        * your own risk.
        *                       (c) 2003 Apis Networks
        * -packaged for use with apnscp 1.0 RC4-2-
        **********************************************/

        /* 
        * functions native to site and user admins
        * are derived from ../global/functions.php
        */
	error_reporting(E_ALL);
        //xdebug_start_profiling();
	include "../global/sitefunctions.php";
        include "../global/constants.php";
        include "../global/graph.php";
        $myGraph = new Graph(120,120*.7 + 10);
        /* please check apnscpcore.php for class instantiation and
           image dimensions */
        $bwUsage = CheckLocalServer($gDomainName,"bwusage");
        $diskUsage = (CheckLocalServer($gDomainName,"quota")/1024.);
        $myGraph->Clean();

        $myGraph->AddData("used", $bwUsage);
        $myGraph->SetColor("used",116,141,75);
        $myGraph->AddData('free',$_COOKIE['bandwidth_threshold']-$bwUsage);
        $myGraph->SetColor('free',230,230,220);
        $myGraph->SetColor("background",255,255,255);
        $myGraph->SetColor("outline",50,50,50);
        $myGraph->SetColor("shadow",186,186,167);
        $myGraph->DrawGraph(GRAPH_PIE_3D,
                                                OPTION_OUTLINE|OPTION_ANTIALIASED,
                                                $gDomainName.'-'.$gUserName.'bw.png'
        );

        $myGraph->Clean();
        $myGraph->AddData("used", $diskUsage);
        $myGraph->SetColor("used",116,141,75);
        if ($_COOKIE['diskquota_quota']) {
                $myGraph->AddData("free", $_COOKIE['diskquota_quota']-$diskUsage);
                $myGraph->SetColor("free",230,230,220);
        }
        $myGraph->SetColor("background",255,255,255);
        $myGraph->SetColor("outline",50,50,50);   
        $myGraph->SetColor("shadow",186,186,167);   
        $myGraph->DrawGraph(GRAPH_PIE_3D,
                                                OPTION_OUTLINE|OPTION_ANTIALIASED,
                                                $gDomainName.'-'.$gUserName.'dq.png'
        );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
</HEAD>
<BODY bgColor=#ffffff leftMargin=5 topMargin=5 marginheight="5" marginwidth="5" onLoad="status='';">
<div ID="topdeck" style="position:absolute; visibility:hide;"></div>
<SCRIPT language="javascript" src="/rollover.js" type="text/javascript"></SCRIPT>
<table width="640" border="0" cellpadding="0" cellspacing="0" class=tableborder>
  <tr>
    <td width="100%" class=nospacing>
        <table width="100%" cellpadding=0 cellspacing=0 border=0>
                        <TR> 
                          <TD class=header height=48><img src="/images/fx/siteinfo.jpg" alt="Site Information" /></TD>
                        </TR>
            <tr>
              <td width="100%" vAlign=top class=nospacing>
                    <table width="100%" cellpadding=2 cellspacing=0 style="border:1px solid #748D4B;">
                                                        <tr>
                                                                <td width="146" vAlign=top> <strong> Web Server Name:</strong> 
                                                                </td>
                                                                <td width=163>
                                                                        <?php printf("www.%s",$gDomainName); ?>                                       
                                                                </td>

                                                                <td width="146" vAlign=top> <strong> FTP Server Name:</strong> 
                                                                </td>
                                                                <td width=163>
                                                                        <?php printf("ftp.%s",$gDomainName); ?>                                       
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 class=horzspacer><img src="/images/spacer.gif" alt="" height=1 width=1 /></td>
                                                        </tr>
                                                        <tr>

                                <td vAlign=top> <strong> Mail Server Name:</strong> </td>
                                                                <td>
                                                                        <?php print($_COOKIE['sendmail_mailserver']); ?>
                                                                </td>

                                <td vAlign=top> <strong> IP Address:</strong> </td>
                                                                <td>
                                                                        <?php print($_COOKIE['ipinfo_ipaddrs']); ?>
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 class=horzspacer><img src="/images/spacer.gif" alt="" height=1 width=1 /></td>
                                                        </tr>
                                                        <tr>

                                <td vAlign=top> <strong> Users:</strong> </td>
                                                                <td>
                                                                        <?php 
                                                                                printf("%d/%d",GetUserAmount($gDomainName),$_COOKIE['users_maxusers']);
                                                                        ?>
                                                                </td>

                                <td vAlign=top> <strong> Contact E-Mail:</strong></td>
                                                                <td>
                                                                        <?php print(CheckLocalServer($gDomainName,"getemail")); ?>
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 class=horzspacer><img src="/images/spacer.gif" alt="" height=1 width=1 /></td>
                                                        </tr>
                                                        <tr>
                                                                <td><strong>Domain Preview:</strong></td>
                                                                <td colspan=3>
                                                                        <?php
                                                                        if (!$_COOKIE['ipinfo_namebased']) { ?>
                                                                        <a href="http://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/" target="_blank">http://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/</a> 
                                                                        <?php
                                                                        } else { ?>
                                                                        <a href="http://<?php print($_SERVER["SERVER_NAME"]); ?>/<?php print($gDomainName); ?>/" target="_blank">http://<?php print($_SERVER["SERVER_NAME"]); ?>/<?php print($gDomainName); ?>/</a> 
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 class=horzspacer><img src="/images/spacer.gif" alt="" height=1 width=1 /></td>
                                                        </tr>
                                                        <?php
                                                        if (!$_COOKIE['ipinfo_namebased']) { ?>
                                                        <tr>
                                                                <td><strong>SSL Preview:</strong></td>
                                                                <td colspan=3>

                                                                        <a href="https://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/" target="_blank">http://<?php print($_COOKIE['ipinfo_ipaddrs']); ?>/</a> 
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 class=horzspacer><img src="/images/spacer.gif" alt="" height=1 width=1 /></td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        <tr>

                                                                <td vAlign=top> <strong> Bandwidth Usage:</strong> </td>
                                                                <td>
                                                                        <div align=center class=void>
                                                                                <?php
                                                                                printf('<img src="/images/graphs/'.$gDomainName.'-'.$gUserName.'bw.png'.'" alt="Bandwidth Graph" />');
                                                                                ?>
                                                                                <br />
                                                                                <?php
                                                                                        printf('%u%% (%.2f GB/%.2f GB)', ceil($bwUsage/$_COOKIE['bandwidth_threshold']*100), 
($bwUsage/1024./1024./1024.), 
($_COOKIE['bandwidth_threshold']/1024./1024./1024.)
                                                                                        );
                                                                           ?>
                                                                        </div>                      
                                                                </td>

                                <td vAlign=top> <strong> Disk Usage:</strong> </td>
                                                                <td>
                                                                        <div align=center class=void>
                                                                           <?php
                                                                                        printf('<img src="/images/graphs/'.$gDomainName.'-'.$gUserName.'dq.png'.'" alt="Disk Quota Graph" />');
                                                                                ?>
                                                                           <br />
                                                                           <?php
                                                                                        printf('%s%% (%u MB/%u MB)', (isset($_COOKIE['diskquota_quota']) ? ceil($diskUsage/$_COOKIE['diskquota_quota']*100)  : sprintf('Unlimited')), 
ceil($diskUsage), 
(isset($_COOKIE['diskquota_quota']) ? $_COOKIE['diskquota_quota'] : sprintf('Unlimited'))
                                                                                        );
                                                                           ?>
                                                                        </div>                                        
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 class=horzspacer><img src="images/spacer.gif" alt="" height=1 width=1 /></td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 align=center vAlign=middle>                    
                                                                        <strong>Please Notice:</strong> there may be a delay in statistics due
                                                                        to stale information remaining from a prior login.   
</td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 class=horzspacer><img src="images/spacer.gif" alt="" height=1 width=1 /></td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan=4 align=left>
                                                                <font color=red><b>News and Updates</b></font>:<br />
                                                                <?php if (file_exists('../global/sitenews.txt')) {
                                                                        include('../global/sitenews.txt');
                                                                } else {
                                                                        print("There is no news at this time.");
                                                                }
                                                                ?>
                                                                </td>
                                                        </tr>
                                                </table>
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
<p></p>
<TABLE cellSpacing=0 cellPadding=0 width=640 border=0>
  <TBODY>
    <TR> 
      <TD class=header height=48><img src="/images/fx/tipofthelogin.jpg" alt="Tip of the Login" /></TD>
    </TR>
    <TR> 
        <td style="border: 1px solid #748D4B; background-image: url('/images/totd.gif'); background-repeat: no-repeat; background-position:bottom right;">
                <table width="100%"  cellSpacing=2 cellPadding=2 border=0>
                        <tr>  
                                <td class=cell1 style="background:transparent;">
                                        <?php print(nl2br(RandomTip())); ?>
                                </td>
                        </tr>
                        <tr>
                                <td style="background:transparent;"><a href="view_shortcuts.php" onmouseover="status='Random Tip'; return true;" onmouseout="status=''; return true;">&gt;&gt; Random Tip</a></td>
                        </tr>
                </table>
        </td>
        </tr>
  </TBODY>
</TABLE>
<P></P>
<TABLE cellSpacing=0 cellPadding=0 width=640 border=0>
  <TBODY>
    <TR> 
      <TD height="48" class=header><img src="/images/fx/siteshortcuts.jpg" alt="Site Administrator Shortcuts" /></TD>
    </TR>
    <!-- USER RELATED OPTIONS -->
    <tr> 
      <td align=center>
                <table width="100%" cellpadding=0 cellspacing=0 style="border: 1px solid #748D4B;">
                    <tr> 
               <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
                </tr>
                        <tr>
                                <td colspan=12>
                                        <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                <tr>
                                                        <td width=313 class=subheader>
                                                                <img src="/images/fx/sitemain.jpg" alt="Site Maintenance" />
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td width=312 class=subheader>
                                                                <img src="/images/fx/usermanagement.jpg" alt="User Management" />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td vAlign=top>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/siteinfo/index_html';"
                                                                                        onMouseOver="rollon(this); status='Site Administrator';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                <a href="/webhost/services/virtualhosting/siteadmin/view_shortcuts/index_html"
                                                                                                        onmouseover="status='Site Administrator'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Site Administrator</a>
                                                                      
                                                                                </TD>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/siteinfo/index_html';"
                                                                                        onMouseOver="rollon(this); status='Site Summary';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                <a href="/webhost/services/virtualhosting/siteadmin/siteinfo/index_html"
                                                                                                        onmouseover="status='Site Administrator'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Site Summary</a>
                                                                      
                                                                                </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <?php
                                                                        if ($gUserName != 'demosite') {
                                                                        ?>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Change Administrator';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/users/form_template';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/users/form_template"  
                                                                                                onmouseover="status='Set User Defaults'; return true;" 
                                                                                                onmouseout="status=''; return true;">Change Administrator</a> 
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td>&nbsp;</td>
                                                                        </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td vAlign=top>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/users/form_adduser';" 
                                                                                        onMouseOver="rollon(this); status='Add User';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                  <a href="/webhost/services/virtualhosting/siteadmin/users/form_adduser" onmouseover="status='Add User'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Add 
                                                  User</a> </TD>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                <TD width="50%" vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Manage Users';"
                                                                                        onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/siteadmin/users/index_html';"> 
                                                  <a href="/webhost/services/virtualhosting/siteadmin/users/index_html" onmouseover="status='Manage Users'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Manage 
                                                  Users</a> </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Set User Defaults';"  
                                                                                        onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/siteadmin/users/form_template';"> 
                                                  <a href="/webhost/services/virtualhosting/siteadmin/users/form_template"  onmouseover="status='Set User Defaults'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Set 
                                                  User Defaults</a> </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td>&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
          <tr> 
               <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
                </tr>
                        <tr>
                                <td colspan=12>
                                        <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                <tr>
                                                        <td width=313 class=subheader>
                                                                <img src="/images/fx/databases.jpg" alt="RDBMS Management" />
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td width=312 class=subheader>
                                                                <img src="/images/fx/sitetools.jpg" alt="Site Tools" />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td vAlign=top>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <?php 
                                                                                if ($_COOKIE['mysql_enabled']) {
                                                                                ?>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="javascript:openwin('<?php print($phpmyadminPath); ?>','phpmyadmin','');"
                                                                                        onMouseOver="rollon(this); status='phpMyAdmin';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                <a href="javascript:openwin('<?php print($phpmyadminPath); ?>','phpmyadmin','');" 
                                                                                                        onmouseover="status='phpMyAdmin'; return true;" 
                                                                                                        onmouseout="status=''; return true;">phpMyAdmin</a>
                                                                      
                                                                                </TD>
                                                                                <?php
                                                                                } else print('<td width="50%">&nbsp;</td>');
                                                                                ?>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <?php
                                                                                if ($_COOKIE['mysql_enabled']) {
                                                                                ?>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/mysql/form_mysqlsitepass';"
                                                                                        onMouseOver="rollon(this); status='Change MySQL Password';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                <a href="/webhost/services/virtualhosting/siteadmin/services/mysql/form_mysqlsitepass" 
                                                                                                        onmouseover="status='Change MySQL Password'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Change MySQL Password</a> 
                                                                      
                                                                                </TD>
                                                                                <?php
                                                                                } else print('<td width="50%">&nbsp;</td>');
                                                                                ?>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <?php
                                                                        if ($_COOKIE['mysql_enabled'] || $postgresqlEnabled) {
                                                                        ?>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                        <?php 
                                                                        if ($_COOKIE['mysql_enabled']) {
                                                                        ?>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='MySQL Cronjob';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/mysqlcronjob.php';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/provisions/mysqlcronjob.php" \
                                                                                                onmouseover="status='MySQL Cronjob'; return true;" 
                                                                                                onmouseout="status=''; return true;">MySQL Cronjob</a>
                                                                                </TD>
                                                                        <?php
                                                                        } else print('<TD></TD>'); 
                                                                        ?>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                        <?php
                                                                        if ($postgresqlEnabled) {
                                                                        ?>
                                                                        <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='phpPgAdmin ';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:openwin('<?php print($phppgadminPath); ?>','phpPgAdmin','');"> 
                                                                                                <a href="javascript:openwin('<?php print($phppgadminPath); ?>','phpPgAdmin','');"
                                                                                                        onmouseover="status='phpPgAdmin'; return true;" 
                                                                                                        onmouseout="status=''; return true;">phpPgAdmin</a>
                                                                        </TD>
                                                                        <?php 
                                                                        } else print('<td>&nbsp;</td>'); 
                                                                        ?>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <?php
                                                                        } 
                                                                        if ($postgresqlEnabled) {
                                                                        ?>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='MySQL Cronjob';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/mysqlcronjob.php';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/provisions/changepgpass.php" onmouseover="status='Change PostgreSQL Password'; return true;" 
                                                                                                onmouseout="status=''; return true;">Change PostgreSQL<br />Password</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                                onMouseOver="rollon(this); status='PostgreSQL Cronjob ';"  
                                                                                                onMouseOut="rolloff(this); status='';" 
                                                                                                onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/postgresqlcronjob.php'"> 
                                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/provisions/postgresqlcronjob.php" 
                                                                                                                onmouseover="status='PostgreSQL Cronjob'; return true;" 
                                                                                                                onmouseout="status=''; return true;">PostgreSQL Cronjob</a>
                                                                                </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                </table>
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td vAlign=top>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/files/';" 
                                                                                        onMouseOver="rollon(this); status='File Manager';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/files/" \
                                                                                                onmouseover="status='File Manager'; return true;" 
                                                                                                onmouseout="status=''; return true;">File Manager</a></TD>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD width="50%" vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Urchin 5 Statistics';" onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:openwin('<?php print($urchin4Path); ?>','Urchin5','');"> 
                                                                                                <a href="javascript:openwin('<?php print($urchin4Path); ?>','Urchin5','');"
                                                                                                        onmouseover="status='Urchin 5 Statistics'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Urchin 5 Statistics</a>
                                                                                </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Traceroute';"  
                                                                                        onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/traceroute.php';"> 
                                                                                                <a href="/webhost/services/virtualhosting/siteadmin/provisions/traceroute.php"  
                                                                                                        onmouseover="status='Traceroute'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Traceroute</a></TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Whois';"  
                                                                                        onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/whois.php';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/provisions/whois.php" onmouseover="status='Whois'; return true;" 
                                                                                                onmouseout="status=''; return true;">Whois</a>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Bandwidth History';"  
                                                                                        onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/bandwidth.php';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/provisions/bandwidth.php" onmouseover="status='Bandwidth History'; return true;" 
                                                                                onmouseout="status=''; return true;">Bandwidth History</a></TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <?php if ($_COOKIE['vhbackup_enabled']) { ?>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Backup/Restore';"  
                                                                                        onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/vhbackup/form_stream_bk';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/vhbackup/form_stream_bk" onmouseover="status='Backup/Restore'; return true;" 
                                                                                        onmouseout="status=''; return true;">Backup/Restore</a></TD>
                                                                                <?php } else { ?>
                                                                                        <td>&nbsp;</td>
                                                                                <?php } ?>
                                                                                
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        
                                                                </table>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                        <tr> 
               <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
                </tr>
                        <tr>
                                <td colspan=12>
                                        <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                <tr>
                                                        <td width=313 class=subheader>
                                                                <img src="/images/fx/web.jpg" alt="Web Server Management" />
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td width=312 class=subheader>
                                                                <img src="/images/fx/email.jpg" alt="E-Mail" />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td vAlign=top>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/apache/view_logs'"
                                                                                        onMouseOver="rollon(this); status='View Logs';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/apache/view_logs" 
                                                                                                onmouseover="status='View Logs'; return true;" 
                                                                                                onmouseout="status=''; return true;">View Logs</a>

                                                                                </TD>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" alt="" width=2 height="2" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/mimetypes.php';"
                                                                                        onMouseOver="rollon(this); status='Manage MIME Types';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                <a href="/webhost/services/virtualhosting/siteadmin/provisions/mimetypes.php" onmouseover="status='Manage MIME Types'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Manage MIME Types
                                                                                                </a>
                                                                      
                                                                                </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Enable/Disable FrontPage';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/enablefp.php';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/provisions/enablefp.php" 
                                                                                                onmouseover="status='Enable/Disable FrontPage'; return true;"
                                                                                                onmouseout="status=''; return true;"><?php ($_COOKIE['frontpage_enabled']) ? 
                                                                                                print('Disable') : print('Enable'); ?> FrontPage</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <?php 
                                                                                $fp = $_COOKIE['frontpage_enabled'];
                                                                                 ?>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='FrontPage Management';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="<?php ($fp) ? print("javascript:openwin('http://".$gDomainName.
                                                                                        "/_vti_bin/_vti_adm/fpadmcgi.exe?page=webadmin.htm','fpadmin',''); ") : 
                                                                                        print("location.href='/webhost/services/virtualhosting/siteadmin/services/apache/view_security';");?>"> 
                                                                                        <a href="<?php ($fp) ? print("javascript:openwin('http://".$gDomainName.
                                                                                        "/_vti_bin/_vti_adm/fpadmcgi.exe?page=webadmin.htm','fpadmin',''); ") : 
                                                                                                print ('/webhost/services/virtualhosting/siteadmin/services/apache/view_security'); ?>" 
                                                                                                onmouseover="status='<?php ($fp)? print('FrontPage Management') : print('Protect Directories'); ?>'; return true;" 
                                                                                                onmouseout="status=''; return true;"><?php ($fp)? print('FrontPage<br>Management') : print('Protect Directories'); ?></a>
                                                                                </TD>

                                                                        </tr>
                                                                        <?php
                                                                        if (!$fp) {
                                                                        ?>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Manage Web Users';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/apache/form_htpasswd';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/apache/form_htpasswd"  
                                                                                                onmouseover="status='Manage Web Users'; return true;" 
                                                                                                onmouseout="status=''; return true;">Manage Web Users</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Manage Web Groups';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/apache/form_htgroup'"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/apache/form_htgroup"  
                                                                                                onmouseover="status='Manage Web Groups'; return true;" 
                                                                                                onmouseout="status=''; return true;">Manage Web Groups</a>
                                                                                </TD>
                                                                        </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>

                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                                onMouseOver="rollon(this); status='View Configuration ';"  
                                                                                                onMouseOut="rolloff(this); status='';" 
                                                                                                onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/apache/index_html'"> 
                                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/apache/index_html" 
                                                                                                                onmouseover="status='View Configuration'; return true;" 
                                                                                                                onmouseout="status=''; return true;">View Configuration</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <?php
                                                                                if (!$_COOKIE['ipinfo_namebased']) { 
                                                                                ?>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                                onMouseOver="rollon(this); status='SSL Configuration ';"  
                                                                                                onMouseOut="rolloff(this); status='';" 
                                                                                                onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/apache/view_ssl'"> 
                                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/apache/view_ssl" 
                                                                                                                onmouseover="status='SSL Configuration'; return true;" 
                                                                                                                onmouseout="status=''; return true;">SSL Configuration</a>
                                                                                </TD>
                                                                                <?php
                                                                                } else print('<td>&nbsp;</td>');
                                                                                ?>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>

                                                                </table>
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td vAlign=top>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/sendmail/index_html';" 
                                                                                        onMouseOver="rollon(this); status='Aliases';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/sendmail/index_html" onmouseover="status='Aliases'; return true;" 
                                                                                                onmouseout="status=''; return true;">Aliases</a>
                                                                                </TD>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD width="50%" vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Spam Filters';" onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/sendmail/sendmail_spam';"> 
                                                                                                <a href="/webhost/services/virtualhosting/siteadmin/services/sendmail/sendmail_spam" 
                                                                                                        onmouseover="status='Spam Filters'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Spam Filters</a>
                                                                                </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='SquirrelMail Interface';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:openwin('<?php print($squirrelmailPath); ?>','sqmail','');"> 
                                                                                                <a href="javascript:openwin('<?php print($squirrelmailPath); ?>','sqmail','');" onmouseover="status='Web Mail Interface'; return true;" onmouseout="status=''; return true;" onClick="javascript:openwin('<?php print($squirrelmailPath); ?>','sqmail','');">Web Mail Interface</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Responders';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/sendmail/sendmail_responders';"> 
                                                                                        <a href="/webhost/services/virtualhosting/siteadmin/services/sendmail/sendmail_responders" 
                                                                                        onmouseover="status='Responders'; return true;" 
                                                                                                onmouseout="status=''; return true;">Responders</a>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <?php
                                                                        if ($_COOKIE['majordomo_enabled']) {
                                                                        ?>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Manager Majordomo';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/majordomo/index_html';"> 
                                                                                                <a href="/webhost/services/virtualhosting/siteadmin/services/majordomo/index_html"
                                                                                                        onmouseover="status='Manage Majordomo'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Manage Majordomo</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td>&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                </table>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                  <tr> 
               <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
                </tr>
                        <tr>
                                <td colspan=12>
                                        <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                <tr>
                                                        <td width=313 class=subheader>
                                                                <img src="/images/fx/miscellaneous.jpg" alt="Miscellaneous" />
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td width=312 class=subheader>
                                                                <?php if ($_COOKIE['mivamerchant_enabled'] || $oscommerceEnabled) { ?> <img src="/images/fx/ecommerce.jpg" alt="E-Commerce" /><?php } else print('<img src="/images/spacer.gif" alt="" height=1 />');?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td vAlign=top>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/troubleticket.php'"
                                                                                        onMouseOver="rollon(this); status='Trouble Tickets';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                                <a href="/webhost/services/virtualhosting/siteadmin/provisions/troubleticket.php" 
                                                                                                        onmouseover="status='Trouble Tickets'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Trouble Tickets</a>
                                                                                </TD>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" alt="" width=2 height="2" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/billing.php';"
                                                                                        onMouseOver="rollon(this); status='Billing History';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                                <a href="/webhost/services/virtualhosting/siteadmin/provisions/billing.php" 
                                                                                                onmouseover="status='Billing History'; return true;" 
                                                                                                onmouseout="status=''; return true;">Billing History</a>
                                                                                </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Logout';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:top('/webhost/services/virtualhosting/siteadmin/manage_logout?relogin=webhost/rollout/site');"> 
                                                                                                <a href="javascript:top('/webhost/services/virtualhosting/siteadmin/manage_logout?relogin=webhost/rollout/site');"
                                                                                                onmouseover="status='Logout'; return true;" target="" onmouseout="status=''; return true;">Logout</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Help';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:openwin('<?php print('https://'.$_SERVER['SERVER_NAME'].'/docs/en_US/site/site_help.htm'); ?>','help','');"> 
                                                                                                <a href="javascript:openwin('<?php print('https://'.$_SERVER['SERVER_NAME'].'/docs/en_US/site/site_help.htm'); ?>','help','');" 
                                                                                                        onmouseover="status='Help'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Help</a>
                                                                                </TD>

                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                        <td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
                                                        <td vAlign=top>
                                                                <?php
                                                                if ($_COOKIE['mivamerchant_enabled'] || $oscommerceEnabled) {
                                                                ?>
                                                                <table width="100%" cellpadding=2 cellspacing=0 border=0>
                                                                        <?php
                                                                        if ($oscommerceEnabled) {
                                                                        ?>
                                                                        <tr>
                                                                            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
                                                                                        onClick="location.href='<?php printf("%s/admin/",rtrim($oscommercePath,"/")); ?>';" 
                                                                                        onMouseOver="rollon(this); status='osCommerce Administration';"  
                                                                                        onMouseOut="rolloff(this); status=''; kill();"> 
                                                                                                <a href="<?php printf("%s/admin/",rtrim($oscommercePath,"/")); ?>" onmouseover="status='osCommerce Administration'; return true;" 
                                                                                                onmouseout="status=''; return true;">osCommerce Administration</a>
                                                                                </TD>
                                                                                <td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD width="50%" vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='osCommerce E-Front';" onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:openwin('<?php printf("%s/catalog/",rtrim($oscommercePath,"/")); ?>','oscommerce','');"> 
                                                                                                <a href="javascript:openwin('<?php printf("%s/catalog/",rtrim($oscommercePath,"/")); ?>','oscommerce','');" 
                                                                                                        onmouseover="status='osCommerce E-Front'; return true;" 
                                                                                                        onmouseout="status=''; return true;">osCommerce<br />E-Front</a>
                                                                                </TD>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <?php
                                                                        }
                                                                        if ($_COOKIE['mivamerchant_enabled']) {
                                                                        ?>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>

                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Miva Merchant Administration';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:openwin('http://<?php print($gDomainName); ?>/Merchant2/admin.mv?','mivaadmin','');"> 
                                                                                                <a href="javascript:openwin('http://<?php print($gDomainName); ?>/Merchant2/admin.mv?','mivaadmin','');" 
                                                                                                        onmouseover="status='Miva Merchant Administration'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Miva Merchant<br />Administration</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Miva Merchant Configuration';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="location.href='/webhost/services/virtualhosting/siteadmin/services/mivamerchant/';"> 
                                                                                                <a href="/webhost/services/virtualhosting/siteadmin/services/mivamerchant/" 
                                                                                                        onmouseover="status='Miva Merchant Configuration'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Miva Merchant<br>Configuration</a>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <TD vAlign=middle align=center style="border: 1px solid white;"
                                                                                        onMouseOver="rollon(this); status='Miva Merchant E-Front';"  
                                                                                        onMouseOut="rolloff(this); status='';" 
                                                                                        onClick="javascript:openwin('http://<?php print($gDomainName); ?>/Merchant2/merchant.mv?','miva','');"> 
                                                                                                <a href="javascript:openwin('http://<?php print($gDomainName); ?>/Merchant2/merchant.mv?','miva','');"
                                                                                                        onmouseover="status='Miva Merchant E-Front'; return true;" 
                                                                                                        onmouseout="status=''; return true;">Miva Merchant<br />E-Front</a>
                                                                                </TD>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
                                                                                <td>&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" alt="" height=2 /></td>
                                                                                <td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                                <td class=nospacing><img src="/images/spacer.gif" height=2 alt=""></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" alt="" height=1 /></td>
                                                                                <td height=1 class=horzspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                                <td class=horzspacer><img src="/images/spacer.gif" height=1 alt=""></td>
                                                                        </tr>
                                                                </table>
                                                                <?php
                                                                }
                                } else print('&nbsp;'); 
                                ?>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                        <tr> 
               <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
                </tr>
         </table></td>
    </tr>
  </TBODY>
</TABLE>

<div align=right style="color:#666666; font-size:10px; font-family: monospace normal, courier new, courier;"><?php print(APNSCPID); ?></div>
<?php
//xdebug_dump_function_profile(XDEBUG_PROFILER_SD_LBL);

//xdebug_dump_function_profile(XDEBUG_PROFILER_CPU);
//xdebug_dump_function_trace(); 
?>
</BODY>
</HTML>
