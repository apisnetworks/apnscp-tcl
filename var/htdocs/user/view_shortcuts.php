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
	*    -packaged for use with apnscp 1.0 RC4-2-
	**********************************************/
	
	/* 
	* functions native to site and user admins
	* are derived from ../global/functions.php
	*/
	include "../global/userfunctions.php";
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
	$myGraph->SetColor("free",230,230,220);	
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
<link href="/stylesheet/" rel="stylesheet" type="text/css">
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
								
				<td> <?php printf("mail.%s",$gDomainName); ?> </td>
								
				<td vAlign=top> <strong> Full Name:</strong></td>
								
				<td> <?php print(GetFullName($gDomainName,$gUserName)); ?> </td>
							</tr>
							<tr>
								<td colspan=4 class=horzspacer><img src="/images/spacer.gif" alt="" height=1 width=1 /></td>
							</tr>
							<tr>
								
				<td><strong>Web Site Location:</strong></td>
								<td colspan=3>
									<a href="http://<?php print($gDomainName); ?>/~<?php print($gUserName);?>/" target="_blank">http://<?php print($gDomainName); ?>/~<?php print($gUserName);?>/</a> 
								</td>
							</tr>
							<tr>
								<td colspan=4 class=horzspacer><img src="/images/spacer.gif" alt="" height=1 width=1 /></td>
							</tr>
							<tr>							
								<td vAlign=top> <strong> Disk Usage:</strong> </td>
								<td>
									<div align=center class=void>
									   <?php
											printf('<img src="/images/graphs/'.$gDomainName.'-'.$gUserName.'dq.png'.'" alt="Disk Quota Graph" />');
										?>
									   <br />
									   <?php
									   		printf('%s (%.2f MB/%.2f MB)', ($quota) ? ceil($used/$quota*100).'%'  : sprintf('Unlimited'), 
																		$used, 
																		($quota) ? $quota : sprintf('Unlimited')
											);
									   ?>
									</div>                                        
								</td>
								<td vAlign=top>&nbsp;</td>
								<td>&nbsp;
									                      
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
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<P></P>
<TABLE cellSpacing=0 cellPadding=0 width=640 border=0>
  <TBODY>
    <TR> 
      <TD height="48" class=header><img src="/images/fx/usershortcuts.jpg" alt="User Administrator Shortcuts" /></TD>
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
								<img src="/images/fx/sitetools.jpg" alt="Site Tools" />
							</td>
						</tr>
						<tr>
							<td vAlign=top>
								<table width="100%" cellpadding=2 cellspacing=0 border=0>
									<tr>
									    <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>		
										
						<TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
											onClick="location.href='/webhost/services/virtualhosting/useradmin/view_shortcuts';"
											onMouseOver="rollon(this); status='User Administrator';"  
											onMouseOut="rolloff(this); status=''; kill();"> 
						  <a href="/webhost/services/virtualhosting/useradmin/view_shortcuts"
													onmouseover="status='User Administrator'; return true;" 
													onmouseout="status=''; return true;">User 
						  Administrator</a> </TD>
										<td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										
										
						<TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
											onClick="location.href='/webhost/services/virtualhosting/useradmin/provisions/usersummary.php';"
											onMouseOver="rollon(this); status='User Summary';"  
											onMouseOut="rolloff(this); status=''; kill();"> 
						  <a href="/webhost/services/virtualhosting/useradmin/provisions/usersummary.php"
													onmouseover="status='User Summary'; return true;" 
													onmouseout="status=''; return true;">User 
						  Summary</a> </TD>
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
											onMouseOver="rollon(this); status='Change Information';"  
											onMouseOut="rolloff(this); status='';" 
											onClick="location.href='/webhost/services/virtualhosting/useradmin/userinfo/';"> 
						  <a href="/webhost/services/virtualhosting/useradmin/userinfo/"  
												onmouseover="status='Change Information'; return true;" 
												onmouseout="status=''; return true;">Change 
						  Information</a> </TD>
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
											onClick="location.href='/webhost/services/virtualhosting/useradmin/provisions/traceroute.php';" 
											onMouseOver="rollon(this); status='File Manager';"  
											onMouseOut="rolloff(this); status=''; kill();"> 
						  <a href="/webhost/services/virtualhosting/useradmin/provisions/traceroute.php"  
													onmouseover="status='Traceroute'; return true;" 
													onmouseout="status=''; return true;">Traceroute</a></TD>
										<td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										
						<TD width="50%" vAlign=middle align=center style="border: 1px solid white;"
											onMouseOver="rollon(this); status='Whois';" onMouseOut="rolloff(this); status='';"
											onClick="location.href='/webhost/services/virtualhosting/useradmin/provisions/whois.php';"> 
						  <a href="/webhost/services/virtualhosting/useradmin/provisions/whois.php" onmouseover="status='Whois'; return true;" 
												onmouseout="status=''; return true;">Whois</a></TD>
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
											onMouseOver="rollon(this); status='Backup/Restore';"  
											onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/useradmin/services/vhbackup/form_stream_bk';"> 
											<a href="/webhost/services/virtualhosting/useradmin/services/vhbackup/form_stream_bk" onmouseover="status='Backup/Restore'; return true;" 
											onmouseout="status=''; return true;">Backup/Restore</a></TD>
										<td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										
						<td vAlign=middle align=center style="border: 1px solid white;"
											onMouseOver="rollon(this); status='Whois';"  
											onMouseOut="rolloff(this); status='';" onClick="location.href='/webhost/services/virtualhosting/siteadmin/provisions/whois.php';">&nbsp; 
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
								<img src="/images/fx/email.jpg" alt="E-Mail" />
							</td>
							<td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
							<td width=312 class=subheader>
								<img src="/images/fx/miscellaneous.jpg" alt="Miscellaneous" />
							</td>
						</tr>
						<tr>
							<td vAlign=top>
								<table width="100%" cellpadding=2 cellspacing=0 border=0>
									<tr>
									    <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										<TD align=center width="50%" vAlign=middle style="border: 1px solid white;"
											onClick="location.href='/webhost/services/virtualhosting/useradmin/services/sendmail/sendmail_aliases';" 
											onMouseOver="rollon(this); status='Aliases';"  
											onMouseOut="rolloff(this); status=''; kill();"> 
											<a href="/webhost/services/virtualhosting/useradmin/services/sendmail/sendmail_aliases" 
												onmouseover="status='Aliases'; return true;" 
												onmouseout="status=''; return true;">Aliases</a>
										</TD>
										<td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										
						<TD width="50%" vAlign=middle align=center style="border: 1px solid white;"
											onMouseOver="rollon(this); status='Forwarding';" onMouseOut="rolloff(this); status='';" 
											onClick="location.href='/webhost/services/virtualhosting/useradmin/services/vacation/useremail_forward';"> 
						  <a href="/webhost/services/virtualhosting/useradmin/services/vacation/useremail_forward"  
						onmouseover="status='Forwarding'; return true;" onmouseout="status=''; return true;">Forwarding</a></TD>
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
											onMouseOver="rollon(this); status='Web Mail Interface';"  
											onMouseOut="rolloff(this); status='';" 
											onClick="javascript:openwin('<?php print($squirrelmailPath); ?>','sqmail','');"> 
						  <a href="javascript:openwin('<?php print($squirrelmailPath); ?>','sqmail',''); " onmouseover="status='Web Mail Interface'; return true;" 
												onmouseout="status=''; return true;">Web 
						  Mail Interface</a> </TD>
										<td class=vertspacer><img src="/images/spacer.gif" height=2 alt="" /></td>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										<td vAlign=middle align=center style="border: 1px solid white;"
											onMouseOver="rollon(this); status='Responders';"  
											onMouseOut="rolloff(this); status='';" 
											onClick="location.href='/webhost/services/virtualhosting/useradmin/services/sendmail/sendmail_responders';"> 
											<a href="/webhost/services/virtualhosting/useradmin/services/sendmail/sendmail_responders" 
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
									<tr>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										
						<TD vAlign=middle align=center style="border: 1px solid white;"
											onMouseOver="rollon(this); status='Vacation Message';"  
											onMouseOut="rolloff(this); status='';" 
											onClick="location.href='/webhost/services/virtualhosting/useradmin/services/vacation/useremail_vacation';"> 
						  <a href="/webhost/services/virtualhosting/useradmin/services/vacation/useremail_vacation"  
						onmouseover="status='Vacation Message'; return true;" onmouseout="status=''; return true;">Vacation Message</a>
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
							</td>
							<td class=vertspacer width=1><img src="/images/spacer.gif" alt="" width="1" height=1 /></td>
							<td vAlign=top>
								<table width="100%" cellpadding=2 cellspacing=0 border=0>
									<tr>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										<TD vAlign=middle align=center width="50%" style="border: 1px solid white;"
											onMouseOver="rollon(this); status='Logout';"  
											onMouseOut="rolloff(this); status='';" 
											onClick="location.href='/webhost/services/virtualhosting/siteadmin/manage_logout?relogin=webhost/rollout/site';"> 
												<a href="/webhost/services/virtualhosting/siteadmin/manage_logout?relogin=webhost/rollout/site" target="_top"
												onmouseover="status='Logout'; return true;" onmouseout="status=''; return true;">Logout</a>
										</TD>
										<td width=1 class=vertspacer><img src="/images/spacer.gif" width=1 alt="" /></td>
										<td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
										<TD vAlign=middle align=center width="50%" style="border: 1px solid white;"
											onMouseOver="rollon(this); status='Help';"  
											onMouseOut="rolloff(this); status='';" 
											onClick="win = window.open('/docs/en_US/user/user_help.htm','_blank',''); win.focus();"> 
												<a href="/docs/en_US/user/user_help.htm" target="_blank" 
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

</BODY>
</HTML>
