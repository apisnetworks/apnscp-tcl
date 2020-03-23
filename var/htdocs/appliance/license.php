<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/adminfunctions.php";
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
          <td class=head> apnscp Management</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="viewapnscp.php" onMouseOver="status='apnscp License'; return true;" onMouseOut="status=''; return true;">apnscp 
            License</a> <img src="/images/red.gif" width=4 height=4> <a href="license.php" onMouseOver="status='License Agreement'; return true;" onMouseOut="status=''; return true;"><strong>License 
            Agreement</strong></a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<table width=640 border=0 cellspacing=0 cellpadding=0>
<tr> 
  <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
	  <tr> 
		<td colspan=2 class=head3>apnscp</td>
	  </tr>
	  <tr>
		<td class=head4 valign=center colspan=2>License and Warranty Agreement</td>
	  </tr>
	  <tr>
		<td class=cell1 valign=center colspan=2><table border=0 cellpadding=2 cellspacing=2>
			<tr>
			    <td class=cell1> This Agreement is between you, your principals, 
                  officers, directors, employees, agents and/or successors ("You") 
                  and Apis Networks ("apns"), and sets forth the terms and conditions 
                  governing your access to and use of the apnscp computer programs 
                  including, without limitation, the apnscp license key(s), software 
                  and source code, and information, services, products, features 
                  and materials included therewith (collectively, "apnscp"). As 
                  a convenience to You, this apnscpdistribution also includes 
                  third-party software products, and Your use of each included 
                  third-party product is subject to separate licensing agreements 
                  included therewith. Among other things, this Agreement describes 
                  your responsibilities and limits apns' liabilities. Please read 
                  it carefully before accepting. BY USING THIS SOFTWARE AND/OR 
                  DOWNLOADING, COPYING OR USING APNSCP, YOU ACCEPT, WITHOUT LIMITATION 
                  OR QUALIFICATION, ALL OF THE TERMS AND CONDITIONS IN THIS AGREEMENT. 
                  If you have any questions about these terms and conditions, 
                  please contact apns at <a href="mailto:webppliance@ensim.com">apnscp@apisnetworks.com</a> 
                  or by phone through 678-986-5596. 
                  <p> 1. <u>Use of apnscp; License</u>.<br>
                    Subject to all the terms and conditions of this Agreement, 
                    apns grants to You a personal, royalty-free, nonsublicensable, 
                    nontransferable, nonexclusive license to use apnscp on a single 
                    network server during the term of this Agreement. You may 
                    make one archival copy of apnscp, and You agree that You will 
                    not otherwise copy or reproduce, distribute, or modify apnscp 
                    or any portion thereof. apns expressly reserves the right 
                    to monitor Your usage of apnscp for compliance with the terms 
                    and conditions of this Agreement. Except to the extent that 
                    the following restriction is prohibited by applicable law, 
                    if any, You shall not reverse assemble, reverse compile or 
                    reverse engineer any software source code or other components 
                    of apnscp, or otherwise attempt to discover any underlying 
                    Proprietary Information (as that term is defined below). 
                  <p> 2. <u>Ownership</u>.<br>
                    Except as expressly licensed in Section 1 above, as between 
                    the parties, apns owns all right, title and interest in and 
                    to apnscp and Proprietary Information. Ownership of included 
                    third-party products remains with their respective holders.&nbsp; 
                    Source may not be reproduced or republished without expressed 
                    written consent on behalf of apns.
                  <p> 3. <u>Confidentiality</u>.<br>
                    You acknowledge that, in the course of using apnscp, you may 
                    obtain or develop information relating to apnscp and/or to 
                    apns ("Proprietary Information"), including, but not limited 
                    to, technology, software code, know-how, ideas, testing procedures, 
                    structure, interfaces, documentation, problem reports, analysis 
                    and performance information, and other technical, business, 
                    product, marketing and financial information, plans and data. 
                    During and after the term of this Agreement, you shall hold 
                    in confidence and protect, and shall not use (except as expressly 
                    authorized by this Agreement) or disclose, Proprietary Information, 
                    unless such Proprietary Information becomes part of the public 
                    domain without breach of this Agreement by You. You acknowledge 
                    and agree that due to the unique nature of apns' Proprietary 
                    Information, there can be no adequate remedy at law for any 
                    breach of your obligations hereunder, that any such breach 
                    may allow You or third parties to unfairly compete with apns 
                    resulting in irreparable harm to apns, and therefore, that 
                    upon any such breach or threat thereof, Ensim shall be entitled 
                    to injunctions and other appropriate equitable relief in addition 
                    to whatever remedies it may have at law. 
                  <p> 4. <u>Training and Support</u>.<br>
                    During the course of preliminary, non-marketed software, otherwise 
                    known as a &quot;Release Candidate&quot; (&quot;RC&quot;), 
                    you will be granted limited support through e-mail, instant 
                    messaging software, and any other such methods listed on <a href="http://apisnetworks.com/contact.ttml" target="_blank">http://apisnetworks.com/contact.ttml</a>. 
                    apns shall have no other obligation under this Agreement to 
                    provide any training or support or to correct any bugs, defects 
                    or errors or to otherwise support, develop or maintain apnscp 
                    or any included third-party products. apns is not subject 
                    to provide technical support for any unauthorized software 
                    installations, client enhancements, server-side upgrades, 
                    or third-party software installations or upgrades not included 
                    with this distribution. Any modifications of or upgrades to 
                    the software included with this distribution may jeopardize 
                    the performance and reliability of apnscp.&nbsp; The RC stage 
                    of the apnscp will only guarantee community-based support 
                    through forums located at <a href="http://apnscp.com/forums/">http://apnscp.com/forums/</a> 
                  <p> 5. <u>United States Government Restricted Rights</u>.<br>
                    apnscp is provided with Restricted Rights. Use, duplication, 
                    or disclosure by the United States Government is subject to 
                    restrictions as set for in subparagraph (c)(f)(ii) of the 
                    Rights in Technical Data and Computer Software clause at DFARS 
                    252.227-7013 or subparagraphs (c)(1) and (2) of the Commercial 
                    Computer Software-Restricted Rights at 48 CFR 52.227-19, as 
                    applicable. Contractor/manufacturer is Apis Networks at 772 
                    Brookwood Terrace, Lilburn, GA 30047-3144. 
                  <p> 6. <u>Warranty Disclaimer</u>.<br>
                    The parties acknowledge and agree that apnscp and/or any included 
                    third-party products may not function correctly or at all 
                    on your machine or in any environment and are therefore provided 
                    "AS-IS" and at your sole risk. TO THE FULL EXTENT PERMISSIBLE 
                    UNDER APPLICABLE LAW, APNS DISCLAIMS ALL WARRANTIES, EXPRESS 
                    OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES 
                    AGAINST INFRINGEMENT OF THIRD PARTY RIGHTS, MERCHANTABILITY 
                    AND FITNESS FOR A PARTICULAR PURPOSE. APNS MAKES NO WARRANTY 
                    TO ANY PERSON RELATING TO APNSCP AND/OR INCLUDED THIRD PARTY 
                    PRODUCTS, THE USE OR ANY INABILITY TO USE APNSCP AND/OR INCLUDED 
                    THIRD PARTY PRODUCTS, THE RESULTS OF THEIR USE, OR THAT ERRORS 
                    IN APNSCP AND/OR INCLUDED THIRD-PARTY PRODUCTS WILL BE CORRECTED. 
                    NOTHING IN THIS AGREEMENT SHALL BE CONSTRUED AS PERMITTING 
                    YOU TO RELY IN ANY WAY ON THE CONTINUED USE OF APNSCP AND/OR 
                    INCLUDED THIRD-PARTY PRODUCTS OR ANY FURTHER DEVELOPMENT OR 
                    COMMERCIAL RELEASES THEREOF. 
                  <p> 7. <u>Limitation of Remedies and Damages</u>.<br>
                    TO THE FULL EXTENT PERMISSIBLE UNDER APPLICABLE LAW, APNS 
                    SHALL NOT BE RESPONSIBLE OR LIABLE WITH RESPECT TO ANY SUBJECT 
                    MATTER OF THIS AGREEMENT OR TERMS AND CONDITIONS RELATED THERETO 
                    UNDER ANY CONTRACT, NEGLIGENCE, STRICT LIABILITY OR OTHER 
                    THEORY, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGES, 
                    FOR ANY (A) LOSS OR INACCURACY OF DATA, (B) DAMAGE TO SOFTWARE 
                    OR EQUIPMENT, (C) INABILITY TO DELIVER GOODS, SERVICES OR 
                    TECHNOLOGY, (D) COST OF PROCUREMENT OF SUBSTITUTE GOODS, SERVICES 
                    OR TECHNOLOGY, (E) INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY 
                    OR CONSEQUENTIAL DAMAGES INCLUDING, BUT NOT LIMITED TO, LOSS 
                    OF REVENUES, DATA OR PROFITS, OR (F) FOR ANY MATTER BEYOND 
                    ITS REASONABLE CONTROL. IN NO EVENT WILL APNS' TOTAL LIABILITY 
                    TO YOU UNDER THIS AGREEMENT, IN THE AGGREGATE, EXCEED THE 
                    LICENSE FEE PAID BY YOU PURSUANT TO THIS AGREEMENT. 
                  <p> 8. <u>Term and Termination</u>.<br>
                    If You have received an Evaluation version of apnscp, this 
                    Agreement will remain in effect for a period of 30 days and 
                    will then automatically expire as provided herein. If You 
                    have received or subsequently acquire a standard version of 
                    apnscp, this Agreement shall remain in effect until either 
                    of the parties terminates the Agreement as provided herein. 
                    This Agreement may be terminated by you for any reason or 
                    no reason upon written notice to apns. This Agreement may 
                    be terminated by apns, with or without notice, immediately 
                    upon Your breach of any provision of this Agreement. Notice 
                    can be delivered by any means, including electronic mail. 
                    Upon termination or expiration, the terms of this Agreement 
                    will remain in full force and effect, except the license granted 
                    in Section 1 shall terminate and You will immediately cease 
                    all use of apnscp and destroy all copies or portions of apnscp 
                    and Proprietary Information in your possession or control. 
                  <p> 9. <u>No Assignment</u>.<br>
                    Neither the rights nor the obligations arising under this 
                    Agreement are assignable or transferable by You without apns' 
                    express written consent, and any such attempted assignment 
                    or transfer shall be void and without effect. 
                  <p> 10. <u>Controlling Law; Severability</u>.<br>
                    This Agreement shall be governed by and construed in accordance 
                    with the laws of the State of Georgia without regard to conflicts 
                    of laws provisions thereof. You agree to submit to the exclusive 
                    jurisdiction and venue of the federal and state courts located 
                    in the State of Georgia and County of Gwinnett. In the event 
                    that any of the provisions of this Agreement shall be held 
                    by a court or other tribunal of competent jurisdiction to 
                    be unenforceable, such provisions shall be limited or eliminated 
                    to the minimum extent necessary so that this Agreement shall 
                    otherwise remain in full force and effect and enforceable. 
                  <p> 11. <u>Entire Agreement; Amendment; Waiver</u>.<br>
                    This Agreement constitutes the entire agreement between the 
                    parties pertaining to the subject matter hereof, and supercedes 
                    any and all written or oral agreements heretofore existing 
                    between the parties. No waiver or modification of this Agreement 
                    will be binding upon either party unless made in a writing 
                    signed by both parties and no failure or delay in enforcing 
                    any right will be deemed a waiver. 
                  <p> </td>
			</tr>
		  </table></td>
	  </tr>
	</table></td>
</tr>
</table>
</BODY>
</HTML>
