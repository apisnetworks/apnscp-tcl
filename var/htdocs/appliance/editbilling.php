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
	// $_POST['action'] && $_POST['action'] == delete =  deleted item
	// $_POST['go'] = edited billing item
	if (isset($_POST['go']) || 
		isset($_GET['action']) && $_GET['action'] == "delete") { // from post
		$retVal = 0;
		if (isset($_GET['action']) && $_GET['action'] == "delete") {
			// delete
			$q = @mysql_query("delete from billing where id = '".$_GET['id']."';");
		}
		if (isset($_POST['go'])) {
			// edited
			$date = strtotime($_POST['month']."/".$_POST['day']."/20".$_POST['year']);
			$q = @mysql_query("update billing set date = '".$date."', transref = '".$_POST['transref']."', 
				method = '".$_POST['payment']."', fee = '".$_POST['amount']."', remarks = 
				'".addslashes($_POST['remarks'])."' where id = '".$_POST['id']."';");
		}
		if (mysql_affected_rows() == -1) {
			$error = mysql_error();
			$retVal = 1;
		}		
	}
?>
<HTML>
<HEAD>
<script language="JavaScript">
	function checkForm(a) {
		// differs due to a two-part year.
		yearRegexp = /^[0-9]{2}$/;
		// standard amount
		amountRegexp = /^[0-9\.]+$/;
		if (a.payment.value == "") {
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
            </a></strong> <img src="/images/red.gif" width=4 height=4> <a href="billing.php" onMouseOver="status='Billing'; return true;" onMouseOut="status=''; return true;">Billing</a><a href="changelog.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;"></a><strong><a href="changelog.php" onMouseOver="status='Trouble Tickets'; return true;" onMouseOut="status=''; return true;"> 
            </a></strong> <img src="/images/red.gif" width=4 height=4> <a href="editbilling.php" onMouseOver="status='Edit Billing'; return true;" onMouseOut="status=''; return true;"><strong>Edit 
            Billing</strong></a></td>
        </tr>
      </table></td>
  </tr>
</table>
&nbsp;<br>
<?php
	if (isset($_GET['action']) && $_GET['action'] == "delete") {
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
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;Billing entry removed.</td>
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
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;Billing removal failed -> error generated: <?php print($error); ?>.</td>
						</tr>
					</table> 
				</td>
			</tr>
		</table> 
		<br>
		<?php
		}
	} else if (isset($_POST['go'])) {
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
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;Billing entry edited.</td>
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
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;Billing edit failed -> error generated: <?php print($error); ?>.</td>
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
				  
          <td class=head3>Edit Billing</td>
				</tr>
				<tr> 
				  
          <td class=help valign=center>Edit pre-existing billing entries to 
              make changes or purge existing references.            
          </td>
				</tr>
				<?php
			  		if (!isset($_GET['domain'])) {
			  		?>
						<tr>
							<td>
								<table cellpadding=2 bgcolor="#cccccc" cellspacing=1 border=0 width="320">
								<tr>
									<td class=head4 align=center>
									Please select a domain.
									
									</td>
								</tr>
											<?php
												$q = mysql_query("select domain from billing where 1 group by domain order by domain asc");
												echo mysql_error();
												while ($row = mysql_fetch_row($q)) {
											?>
											<tr>
												<td class=cell2>
													<a href="editbilling.php?domain=<?php print($row[0]); ?>"><?php print($row[0]); ?></a>
												</td>
											</tr>
											<?php
												}
											?>					
				   
								</table>
							</td>
						</tr>
						<?php
					}
			  		else if (isset($_GET['domain']) && (!isset($_GET['id']) || isset($_GET['action']) && $_GET['action'] == "delete")) {
			  		?>
						<tr>
							<td>
								<table cellpadding=2 bgcolor="#cccccc" cellspacing=1 border=0 width="100%">
								<tr>
									<td class=head4 align=center colspan=5>
									Listing for <?php print($_GET['domain']); ?>:
									</td>
								</tr>
								<tr>
									<td class=head4 width=72>
										Date
									</td>
									<td class=head4 width=70>
										Amount
									</td>
									<td class=head4 width=120>
										Payment Option
									</td>
									<td class=head4 width=268>
										Remarks
									</td>
									<td class=head4 width=80 align=center>
										Actions
									</td>
								</tr>
								<?php
									$color = "listodd";
									$q = mysql_query("select id,domain,date,method,fee,remarks from billing where domain = '".$_GET['domain']."' order by date desc");
									while ($row = mysql_fetch_row($q)) {
								?>
								<tr>
									<td class=<?php print($color); ?>>
										<?php print(date("m/d/Y",$row[2])); ?>
									</td>
									<td class=<?php print($color); ?>>
										<?php printf("%s%.2f",$gLocale['currency_symbol'],$row[4]); ?>
									</td>
									<td class=<?php print($color); ?>>
										<?php
											if ($row[3] == "credit") 
												print "Credit Card";
											else
												print $row[3];
										?>
									</td>
									<td class=<?php print($color); ?>>
										<?php print(stripslashes($row[5])); ?>
									</td>
									<td align=center class=<?php print($color); ?>>
										<a href="editbilling.php?<?php printf("domain=%s&id=%u&action=delete&id=%s",$_GET['domain'],$row[1],$row[0]); ?>"  onClick="return confirm('Are you sure you wish to delete the payment for \'<?php print(date("m/d/Y",$row[2])); ?>\'?');"><img src="/images/remove.gif" alt="Remove" border=0 /></a>
										&nbsp;
										<a href="editbilling.php?<?php printf("domain=%s&id=%u&action=edit&id=%s",$_GET['domain'],$row[1],$row[0]); ?>"><img src="/images/edit.gif" alt="Edit" border=0 /></a>
									</td>
								</tr>
								<?php
									if ($color == "listodd") $color = "listeven"; else $color = "listodd";
									}
								?>					
				   
								</table>
							</td>
						</tr>
						<?php
					} else if (isset($_GET['action']) && $_GET['action'] == "edit") {
						$q = mysql_query("select id, fee, date, transref, method, fee, remarks from billing where id = '".$_GET['id']."'");
						$row = mysql_fetch_row($q);
						?>
						<tr>
							<form action="editbilling.php?domain=<?php print($_GET['domain']); ?>" method=post onSubmit="return checkForm(document.forms[0]);">
							<td>
								<table cellpadding=2 bgcolor="#cccccc" cellspacing=1 border=0 width="320">
									<tr>
										<td class=cell2>
											<strong>Domain:</strong>
										</td>
										<td class=cell2>
											<?php print($_GET['domain']); ?>
										</td>
									</tr>
									<tr>
										<td class=cell2>
											<strong>Payment:</strong>
										</td>
										<td class=cell2>
											<select name=payment>
												<option value=credit <?php if ($row[4] == "credit") echo "SELECTED"; ?>>Credit Card</option>
												<option value=paypal <?php if ($row[4] == "paypal") echo "SELECTED"; ?>>Paypal</option>
												<option value=cash <?php if ($row[4] == "cash") echo "SELECTED"; ?>>Cash</option>
												<option value=bank <?php if ($row[4] == "bank") echo "SELECTED"; ?>>Bank</option>
												<option value=check <?php if ($row[4] == "check") echo "SELECTED"; ?>>Check</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class=cell2>
											<strong>Date:</strong>
										</td>
										<td class=cell2>
											<input type=text size=2 maxlength=2 name=month value="<?php print(date("m",$row[2])); ?>" onClick="this.value='';" />
											/
											<input type=text size=2 maxlength=2 name=day value="<?php print(date("d",$row[2])); ?>" onClick="this.value='';"/>
											/20
											<input type=text size=2 maxlength=2 name=year value="<?php print(date("y",$row[2])); ?>" onClick="this.value='';" />
										</td>
									</tr>
									<tr>
										
						  <td class=cell2><strong>Transaction Ref #:</strong></td>
										<td class=cell2><input type=text name=transref value="<?php print($row[3]); ?>" /></td>
									</tr>
									<tr>
										
						<td class=cell2><strong>Amount:</strong></td>
										<td class=cell2>
										<?php print($gLocale['currency_symbol']); ?><input type=text name=amount value="<?php print($row[5]); ?>" /></td>
									</tr>
									<tr>
										
						  <td class=cell2><strong>Notes:</strong></td>
										<td class=cell2><input type=text name=remarks value="<?php print(stripslashes($row[6])); ?>" /></td>
									</tr>
									<tr>
									<td class=cell2 colspan=2 align=center>
										<input type=hidden name=go value=1 />
										<input type=hidden name=id value=<?php print($row[0]); ?> />
										<input type=submit value=Submit />
									</td>
									</tr>
								</table>
							</td>
							</form>
						</tr>
						<?php
					}
				?>
			</table>
		</td>
	</tr>
</table>
</BODY>
</HTML>