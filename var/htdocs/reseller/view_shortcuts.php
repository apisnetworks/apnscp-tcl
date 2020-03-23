<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/**********************************************
	 * Basic front-end skin for reseller administrators
	 * Please read the attached "LICENSE" file for
	 * further licensing information and indemnifications
	 * any modifications done to the view_shortcuts.php 
	 * is not covered through support, modify at 
	 * your own risk.
	 *                       (c) 2003 Apis Networks
	 * -packaged for use with apnscp 1.0 RC4-2-
	 **********************************************/
	 
	 /* 
	 * functions native to reseller admin
	 * are derived from ../global/reseller.php
	 */
	include "../global/resellerfunctions.php";
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
<p></p>
<TABLE cellSpacing=2 cellPadding=2 width=640 border=0>
  <TBODY>
    <TR> 
      <TD class=header height=22 colSpan=5>Reseller Management</TD>
    </TR>
    <TR> 
     <td colspan=5>
	 	<table width="100%" cellpadding=0 cellspacing=0 style="border: 1px solid #53805C;">
          <!--SITE RELATED OPTIONS-->
          <TR> 
            
            <TD height="12" colspan=12 valign=middle class=subheader>Sites and 
              Service Plans</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <TR> 
            <td width="2" height="60"><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD align=center height=80 width=121 vAlign=middle style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/services/reseller/resellercp/virtualhosting/';" 
				onMouseOver="rollon(this); status='Site List'; pop(1,'List all sites that you control as a reseller.','Site List');"  
				onMouseOut="rolloff(this); status=''; kill();"> 
              		<a href="/webhost/services/reseller/resellercp/virtualhosting/" onmouseover="status='Site List'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/list_sites.gif" alt="Site List" align=absMiddle border=0><br>
				            <B>Site List</B>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=121 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Add Name-Based Site'; pop(2,'Create a new domain, aliased via the name.','Add Name-Based Site');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/resellercp/virtualhosting/form_addDomain?namebased=1';"> 
              		<a href="/webhost/services/reseller/resellercp/virtualhosting/form_addDomain?namebased=1" onmouseover="status='Add Name-Based Site'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/add_site_ip.gif" alt="Add Name-Based Site" align=absMiddle border=0><br>
              				<b>Add Name-Based<br>Site</b>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          	<TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=122 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Add IP-Based Site'; pop(3,'Add a new site based upon a unique IP.','Add IP-Based Site');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/resellercp/virtualhosting/form_addDomain?namebased=0';"> 
            		<a href="/webhost/services/reseller/resellercp/virtualhosting/form_addDomain?namebased=0"  onmouseover="status='Add IP-Based Site'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/add_site.gif" alt="Add IP-Based Site" align=absMiddle border=0><br>
              				<B>Add IP-Based<br>Site</B>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=122 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Plan List'; pop(4,'View existing service plans you have created.','Plan List');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/resellercp/virtualhosting/view_plans';"> 
            		<a href="/webhost/services/reseller/resellercp/virtualhosting/view_plans"  onmouseover="status='Plan List'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/plans.gif" alt="Plan List" align=absMiddle border=0><br>
							<B>Plan List</B>
					</a>
			</TD>
            <td width="2"><img src="/images/spacer.gif" width=2 alt=""></td>
          	<TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" width=122 vAlign=middle align=center 
				onMouseOver="rollon(this); status='Add Service Plan'; pop(2,'Add a new service plan to your reseller account.','Add Service Plan');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/resellercp/virtualhosting/form_addPlan';"> 
            		<a href="/webhost/services/reseller/resellercp/virtualhosting/form_addPlan"  onmouseover="status='Add Service Plan'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/add_plan.gif" alt="Add Service Plan" align=absMiddle border=0><br>
            				<B>Add Service<br>Plan</B>
					</a>
			</TD>
          </tr>
          <tr> 
            <td colspan=12 height=5></td>
          </tr>
          <!--- END SITE RELATED OPTIONS --->
		  
          <!-- CONFIGURATION RELATED OPTIONS --->
          <TR> 
            <TD height="12" colspan=12 valign=middle class=subheader>Configuration and Miscellaneous</TD>
          </TR>
          <tr> 
            <td colspan=12 height=2><img src="/images/spacer.gif" alt="" height=2></td>
          </tr>
          <tr> 
            <td height=80><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='View Services'; pop(1,'View enabled services on the hosting box.','View Services');" 
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/resellercp/services';"> 
              		<a href="/webhost/services/reseller/resellercp/services" onmouseover="status='View Configuration'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/reseller_list.gif" alt="View Services" align=absMiddle border=0><br>
              				<b>View Services</b>
					</a>
			</TD>
			<td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;"  vAlign=middle align=center 
				onMouseOver="rollon(this); status='Change Password'; pop(4,'Lost your password? Need to change it? Change your password through here.','Change Password');"  
				onMouseOut="rolloff(this); status=''; kill();" onClick="location.href='/webhost/services/reseller/resellercp/administration/form_change_password';"> 
              		<a href="/webhost/services/reseller/resellercp/administration/form_change_password" onmouseover="status='Change Password'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/change_password.gif" alt="Change Password" align=absMiddle border=0><br>
				            <b>Change<br>Password</b>
					</a>
			</TD>
			<td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD align=center  vAlign=middle  style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" 
				onClick="location.href='/webhost/services/reseller/resellercp/administration/view_summary';" 
				onMouseOver="rollon(this); status='Reseller Summary'; pop(4,'Gives a comprehensive overview of your reseller account.','Reseller Summary');"  
				onMouseOut="rolloff(this); status=''; kill();"> 
              		<a href="/webhost/services/reseller/resellercp/administration/view_summary" onmouseover="status='Reseller Summary'; return true;" 
						onmouseout="status=''; return true;">
						<IMG src="/images/summary_page.gif" alt="Reseller Summary" align=absMiddle border=0><br>
              			<b>Reseller<br>Summary</b>
					</a>
			</TD>
		    <td><img src="/images/spacer.gif" width=2 alt=""></td>
            <TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Help'; pop(2,'View the WEBppliance help file for reseller administrators.','Help');"  onMouseOut="rolloff(this); status=''; kill();" 
				onClick="window.open('/docs/en_US/reseller/web31reseller.htm','','','');"> 
              		<a href="/docs/en_US/reseller/web31reseller.htm" target="_blank" onmouseover="status='Help'; return true;" onmouseout="status=''; return true;">
						<IMG src="/images/usermanual.gif" alt="Help" align=absMiddle border=0><br> 
              			<b>Help</b>
					</a>
			</TD>
			<td><img src="/images/spacer.gif" width=2 alt=""></td>
			<TD style="BORDER: #cccccc 1px solid; background-color:#f1f1f1;" vAlign=middle align=center 
				onMouseOver="rollon(this); status='Logout'; pop(1,'Logout and destroy your current session.','Logout');"  onMouseOut="rolloff(this); status=''; kill();" 
				onClick="location.href='/webhost/services/reseller/resellercp/manage_logout?relogin=webhost/rollout/welcome';"> 
            		<a href="/webhost/services/reseller/resellercp/manage_logout?relogin=webhost/rollout/welcome" target="_top" onmouseover="status='Logout'; return true;" 
						onmouseout="status=''; return true;">
							<IMG src="/images/logout.gif" alt="Logout" align=absMiddle border=0><br> 
              				<b>Logout</b>
					</a>
			</TD>
  		    <td><img src="/images/spacer.gif" width=2 alt=""></td>
			</tr>
          <tr> 
            <td height=5 colspan=12></td>
          </tr>
          <!-- END CONFIGURATION RELATED OPTIONS --->
        </table></td>
    </tr>
  </TBODY>
</TABLE>

<div align=right style="color:#cccccc; font-size:10px; font-family: monospace normal, courier new, courier;"><?php print(APNSCPID); ?></div>

</BODY>
</HTML>