<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
	Login();
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
          <td class=head> Changelog</td>
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
          <td class=cell1 colspan=2> &nbsp; <strong><a href="changelog.php" onMouseOver="status='Changelog'; return true;" onMouseOut="status=''; return true;">Changelog</a></strong> 
            <img src="/images/red.gif" width=4 height=4> <a href="pendingchanges.php" onMouseOver="status='View Change Submissions'; return true;" onMouseOut="status=''; return true;">View 
            Change Submissions</a> <img src="/images/red.gif" width=4 height=4> 
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
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
        			
            <td class=head3>Changelog</td>
			    </tr>
		        <tr> 
					
            <td class=help valign=center>Below is the listing of prior 
              changes to the Apis Networks Control Panel. Changes are listed descending 
              from the most current control panel version.</td>
        		</tr>
				<tr> 
				  <td>
				  <p>Version: <strong>1.0 RC4</strong> (3/16/2003)</p>
				  <strong>Additions:</strong>
          <li>New &quot;Appliance Administrator&quot; and &quot;Reseller&quot; 
              Administrator front-ends</li>
            <li>Error reporting mechanism added</li>
            <li>apnscp back-end and front-end are now configurable through apnscp.ini, 
              config.php, sql.php, logintemplate.php, and troubleticketcfg.php</li>
            <li>apnscp back-end now handles errors a bit more gracefully and custom 
              functions are error-proof in regards to blocking</li>
            <li>New Appliance Administrator modules:</li>
			<li type=square style="padding-left:15px;">MySQL Usage</li>
			<li type=square style="padding-left:15px;">Appliance Summary</li>
			<li type=square style="padding-left:15px;">apnscp License</li>
			<li type=square style="padding-left:15px;">Trouble Tickets</li>
			<li type=square style="padding-left:15px;">MySQL Warning mechanism</li>
			<li type=square style="padding-left:15px;">Billing</li>
			<li type=square style="padding-left:15px;">Bandwidth usage bars</li>
            <li>apnscp back-end and front-end can be customized through custom.tcl/custom.php 
              now (for use with custom functions)</li>
			  <li>"MySQL hash" added as an associative array of additional users mapped to a domain</li>
			  <li type=square style="padding-left:15px;">MySQL cronjob changed to reflect this</li>
			  <br>
              <br>
              <strong>Fixes:</strong>
			<li>Fixed problematic '$username' which was wiped as of RC3.&nbsp; 
              Moved to '$gUserName'</li>
            <li>Fixed domain name as well, better checks of username and domain 
              names</li>
            <li>Additional pages are now location-aware-- by this, calling Login(); 
              checks the location against the type of login and validates/invalidates 
              based upon credentials</li>
            <li>Major portions of code have now been broken down into individual 
              functions and collections</li>
            <li>Cronjob format is now 'type-YYYYMMDD-dbname.ext' for use with 
              the sort command</li>
            <li>Fixed problem where spam filter could possibly hang</li>
            <li>Minor 'notice' fixes, code should be 95% streamlined and error-free.</li>
            <li>Minor cosmetic changes yet again</li>
            <li>Many many <strong>many</strong> other tiny bug fixes with variable 
              values</li>
			<br>
              <br>
            <strong>Outstanding Issues:</strong> 
            <li>Language-specific login feature of Ensim WEBppliance has been 
              removed</li>
            <li>No pretty formatting for use when options are disabled leaving 
              excess empty cells in-between cells with data</li>
            <li>No PostgreSQL alias hash, must rely upon the login name of the 
              user</li>
            </td>
		  </tr>
				<tr> 
				  <td>
				  <p>Version: <strong>1.0 RC3</strong> (2/16/2003)</p>
				  <strong>Additions:</strong>
          <li>MIME type handling added</li>
            <li>FrontPage installation control added</li>
            <li>phpPgAdmin is now with PostgreSQL accounts</li>
            <li>PostgreSQL Cronjob support added as well</li><br>
            <strong>Fixes:</strong> 
            <li>spam filters now work once again</li>
            <li>ListenerService namespace (Tcl socket counterpart for underpriviledged circumvention from the Web server) rewritten, slightly more efficient</li>
            <li>Switch argument calls to the socket service</li>
            <li>Centralized distribution to /usr/apnscp/</li>
            <li>Logging facility improved for ListenerService, now logs ::errorInfo and ::errorCode</li>
            <li>Merged functions.php for both Site and User administrators into one nice file</li>
            <li>Function names, arguments, bodies were rewritten</li>
            <li>CSS definition globalized</li>
            <li>Site, User, Admin, and Reseller login screens now all similar</li>
			<li>Control panel no longer relies upon register_globals</li>
          </td>
		  </tr>
				<tr> 
				  <td>
				  <p>Version: <strong>1.0 RC2</strong> (1/4/2003)</p>
				  <strong>Additions:</strong>
          <li>merged development branch into the control panel</li>
            <li>'Tip of the Day' added</li><br>
		  <strong>Fixes:</strong>
		    <li>fixed errant formatting issues with bandwidth/disk quota representations</li>
		    <li>fixed Urchin 5 link on view_shortcuts.php</li>
		  	<li>when zero bytes of bandwidth have been used, it no longer outputs '['</li>
		  	<li>fixed little space between used and unused bandwidth data when zero bytes were used</li>
		    <li>socket latency lessened ten-fold, socket requests are now cached 
              for 10 minutes inside the interp</li>
          <li>fixed 'Help' a tag on view_shortcuts.php</li>
		    <li>minor cosmetic changes to the 'Trouble Ticket' interface</li>
        </td>
		  </tr>
		  </table>
		  </td>
		  </tr>

</table>
<P>&nbsp;</P>
</BODY>
</HTML>
