<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/adminfunctions.php";
	Login();
	
	mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
	mysql_select_db($mysql['standard']['database']);

	if (isset($_POST['go'])) { // from post
		$retVal = 0;
		if ($_POST['domain1'] == "")
			$domain = $_POST['domain2'];
		else
			$domain = $_POST['domain1'];
		$date = strtotime($_POST['month']."/".$_POST['day']."/20".$_POST['year']);
		$q = @mysql_query("insert into billing values('','".$domain."','".$date."','".$_POST['transref']."','".$_POST['payment']."','".$_POST['amount']."','".addslashes($_POST['remarks'])."');");
		if (mysql_affected_rows() == -1) {
			$retVal = 1;
			$error = mysql_error();
		} 
		
	}
?>
<HTML>
<HEAD>
<script language="JavaScript">
	function checkForm(a) {
		domainRegexp = /^[a-zA-Z0-9\.-]+$/;
		// differs due to a two-part year.
		yearRegexp = /^[0-9]{2}$/;
		// standard amount
		amountRegexp = /^[0-9\.]+$/;
		if (a.domain1.value == "" && !domainRegexp.test(a.domain2.value)) {
			alert("Invalid domain, please select an existing domain or input a new one.");
			a.domain1.focus();
			return false;
		} else if (a.payment.value == "") {
			alert("Please select a payment method.");
			a.payment.focus();
			return false;
		} else if (!yearRegexp.test(a.year.value) || isNaN(Date.parse(a.month.value + "/" + a.day.value + "/" + "20" + a.year.value))) {
			alert("Invalid date specification.");
			a.month.focus();
			return false;
		} else if (!amountRegexp.test(a.amount.value)) {
			alert("Please enter a numeric amount without any signs, such as a '$'.");
			a.amount.focus();
			return false;
		}
		return true;
	}
</script>
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
</HEAD>
<BODY leftmargin = "15" topmargin = "2" marginwidth = "15" marginheight = "2" bgcolor = "#ffffff">
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head> <table width=640 border=0 cellspacing=1 cellpadding=1>
        <tr> 
          <td class=head>Management</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="troubleticket.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;">Trouble 
            Tickets</a><strong><a href="changelog.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;"> 
            </a></strong> <img src="/images/red.gif" width=4 height=4> <a href="billing.php" onMouseOver="status='Billing'; return true;" onMouseOut="status=''; return true;"><strong>Billing</strong></a><strong><a href="changelog.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;"> 
            </a></strong> <img src="/images/red.gif" width=4 height=4> <a href="editbilling.php" onMouseOver="status='Edit Billing'; return true;" onMouseOut="status=''; return true;">Edit 
            Billing</a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<?php
	if (isset($_POST['go'])) {
		if (!$retVal) {
?>
		<table width=640 border=0 cellspacing=0 cellpadding=1>
			<tr>
				<td class=head>
					<table width=640 border=0 cellspacing=0 cellpadding=1>
						<tr> 
							<td width="150" valign="middle" class=cell1> 
								&nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
								<b>Status:</b>&nbsp;Successful! </td>
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;New 
            billing entry added.</td>
						</tr>
					</table> 
				</td>
			</tr>
		</table> 
		<br>
<?php 
		} else {
		?>
		<table width=640 border=0 cellspacing=0 cellpadding=1>
			<tr>
				<td class=head>
					<table width=640 border=0 cellspacing=0 cellpadding=1>
						<tr> 
							<td width="150" valign="middle" class=cell1> 
								&nbsp; <img border=0 src="/images/redball.gif" alt="Action Successful"> 
								<b>Status:</b>&nbsp;Failed! </td>
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;Error generated: <?php print($error); ?>.</td>
						</tr>
					</table> 
				</td>
			</tr>
		</table> 
		<br>
		<?php
		}
	}
?>
<table width=640 border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
				  
          <td class=head3>Billing</td>
				</tr>
				<tr> 
				  
          <td class=help valign=center>Create transaction references 
            for use with your customers to track their subscriptions and prior 
            payments.</td>
				</tr>
				<tr>
					<form action="billing.php" method=post onSubmit="return checkForm(document.forms[0]);">
					<td>
						<table cellpadding=2 bgcolor="#cccccc" cellspacing=1 border=0 width="320">
							<tr>
								<td class=cell2>
									<strong>Domain:</strong>
								</td>
								<td class=cell2>
									<select name=domain1 
										onFocus="document.forms[0].domain2.value = '';">
									<option value="">----------</option>
									<?php
									$q = mysql_query("select domain from billing where 1 group by domain;");
									while ($row = mysql_fetch_row($q)) {
										?>
										<option value="<?php print($row[0]); ?>"><?php print($row[0]); ?></option>
										<?php
									}
									?>
									</select>
									<br>
				                    <input type=text name=domain2 value="New Domain" 
										onClick="this.value='';"
										onFocus="document.forms[0].domain1.value = '';" />
								</td>
							</tr>
							<tr>
			                	<td class=cell2>
									<strong>Payment:</strong>
								</td>
								<td class=cell2>
									<select name=payment>
										<option value="">------</option>
										<option value=credit>Credit Card</option>
										<option value=paypal>Paypal</option>
										<option value=cash>Cash</option>
										<option value=bank>Bank</option>
										<option value=check>Check</option>
									</select>
								</td>
							</tr>
							<tr>
				                <td class=cell2>
									<strong>Date:</strong>
								</td>
								<td class=cell2>
									<input type=text size=2 maxlength=2 name=month value="<?php print(date("m",time())); ?>" onClick="this.value='';" />
									/
									<input type=text size=2 maxlength=2 name=day value="<?php print(date("d",time())); ?>" onClick="this.value='';"/>
									/20
									<input type=text size=2 maxlength=2 name=year value="<?php print(date("y",time())); ?>" onClick="this.value='';" />
								</td>
							</tr>
							<tr>
								
                  <td class=cell2><strong>Transaction Ref #:</strong></td>
								<td class=cell2><input type=text name=transref /></td>
							</tr>
							<tr>
								
                <td class=cell2><strong>Amount:</strong></td>
								<td class=cell2><?php print($gLocale['currency_symbol']); ?><input type=text name=amount /></td>
							</tr>
							<tr>
								
                  <td class=cell2><strong>Notes:</strong></td>
								<td class=cell2><input type=text name=remarks /></td>
							</tr>
							<tr>
							<td class=cell2 colspan=2 align=center>
								<input type=hidden name=go value=1>
								<input type=submit value=Submit />
								<input type=reset value=Reset />
							</td>
							</tr>
						</table>
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
</table>
</BODY>
</HTML>