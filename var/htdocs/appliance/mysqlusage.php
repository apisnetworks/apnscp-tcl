<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/adminfunctions.php";
	include_once "../global/emailtemplates.php";
	Login();
	
	/*
	* this is ugly and inefficient
	*	- Matt
	*/
	
	// Step One: let's populate our databases
	$dbInfo = array(); // initialize the database variable which we'll look for
	// get all dbs... subject to change.
	$maxsize = 0; // used to holding max size for use with relative
	$databases = MysqlAliases();
	foreach ($databases as $username => $domain) 
		foreach (GetDatabases($username) as $VOID => $database) {
			$db[$database]['size'] = 0;
			$db[$database]['domain'] = $domain;
			$db[$database]['user'] = $username;
			$db[$database]['relative'] = "";
			array_push($dbInfo,$database);
		}
	
	// Step Two-- 
	// send data to backend and add them back to the array
	$data = split(" ",CheckLocalServer("admin","mysqlusage",join(" ",$dbInfo)));
	$maxSize = array_pop($data);
	$i = 0;
	$name = "";
	$size = "";
	while (list($VOID,$val) = each($data)) {
		if ($i == 0) { 
			$name = $val;
			$i++;
		}
		else {
			$i = 0;
			$db[$name]['size'] = $val;
			$db[$name]['relative'] = $db[$name]['size']/$maxSize*100;
		}
	}

	// Step Three --
	//		iterate through each, divide
	//		each as 'size/maxsize' to obtain
	//		relative percentage
	
	// change the way we connect
	mysql_connect("localhost",$mysql['standard']['username'],$mysql['standard']['password']);
	mysql_select_db($mysql['standard']['database']);

	$retVal = 0; // it's ok!
	if (isset($_POST['go'])) {
		foreach ($_POST['warn'] as $dbName => $warningSize) {
			$q = mysql_query("select 1 from mysqlusage where db = '".$dbName."'");
			if (mysql_num_rows($q) > 0) { // exists
				$q = mysql_query("update mysqlusage set warn = '".$warningSize."' where db = '".$dbName."';");
				if (mysql_affected_rows() == -1) {
					$error = mysql_error($q);
					$retVal = 1;
				}
			} else { // doesn't exist
				$q = mysql_query("insert into mysqlusage values('".$dbName."','".$db[$dbName]['domain']."','".$warningSize."');");
				if (mysql_affected_rows() == -1) {
					$error = mysql_error($q);
					$retVal = 1;
				}
			}
		}
	
	} else if (isset($_GET['warn'])) {
		mail(CheckLocalServer($_GET['domain'],"getemail"),"MySQL Usage Warning for ".$_GET['dbname'],$mysqlwarning,"Importance: High");
	}
?>
<HTML>
<HEAD>
<script language="JavaScript">
	function checkText(a) {
		warnRegexp = /^[0-9]*$/;
		if (!warnRegexp.test(a.value)) {
			alert("The warn field can only contain whole integers");
			a.value = "";
			a.focus();
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
          <td class=head> Database Usage</td>
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
          <td class=cell1 colspan=2> &nbsp; <strong><a href="mysqlusage.php" onMouseOver="status='MySQL Usage'; return true;" onMouseOut="status=''; return true;">MySQL 
            Usage</a></strong></td>
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
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;MySQL 
            warning entries have been modified.</td>
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
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;Warning 
            entry modification failed, error generated: <?php print($error); ?>.</td>
						</tr>
					</table> 
				</td>
			</tr>
		</table> 
		<br>
		<?php
		}
	} elseif (isset($_GET['warn'])) {
?>
		<table width=640 border=0 cellspacing=0 cellpadding=1>
			<tr>
				<td class=head>
					<table width=640 border=0 cellspacing=0 cellpadding=1>
						<tr> 
							<td width="150" valign="middle" class=cell1> 
								&nbsp; <img border=0 src="/images/greenbal.gif" alt="Action Successful"> 
								<b>Status:</b>&nbsp;Successful! </td>
							
          <td width="487" align=left valign="middle" class=cell1> <b>Result:</b>&nbsp;The owner of <?php print($_GET['dbname']); ?> has been issued a warning.</td>
						</tr>
					</table> 
				</td>
			</tr>
		</table> 
		<br>
	<?php
	}
?>
<table width=640 border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
					<td class=head3>MySQL Usage</td>
			    </tr>
		        <tr> 
			        <td class=help valign=center>
						The following is a list of databases, the 
						domain to which it belongs, and disk use per database.
						<br>Please keep these constraints in mind when viewing data:
						<li>Database sizes are approximate and not exact</li>
						<li>A 'warn at' value of 0 MB disables the warning feature</li>
						<li>The 'warn at' feature is done nightly as a cronjob</li>
						<li>You can automatically issue a warning through the 'Actions' cells</li>
						<li>'Realtive' lists database size relative to other databases - there 
						will <strong>always</strong> be a 100% database</li>
					</td>
        		</tr>
				<tr>
					<td>
						<table cellpadding=2 cellspacing=1 border=0 width="100%" bgcolor="#cccccc">
						<form action="mysqlusage.php" method=post>
							<tr>				  
			                  <td class=head5 align=center><strong>Database Name:</strong></td>
							  <td align=center class=head5><strong>Domain:</strong></td>
							  <td class=head5 align=center><strong>Size:</strong></td>
                  			  <td class=head5 align=center><strong>Relative Size:</strong></td>
							  <td class=head5 align=center><strong>Warn At:</strong></td>
							  <td align=center class=head5><strong>Actions:</strong></td>
							</tr>
							<?php
							$color = "listodd";
							foreach ($db as $key => $val) {
								$q = mysql_query("select warn from mysqlusage where db = '".$key."'");
								$warn = mysql_num_rows($q) > 0 ? array_pop(mysql_fetch_row($q)) : 0;
								?>
								<tr>
									<td class="<?php print($color); ?>">
										<?php print($key); ?>
									</td>
									<td class="<?php print($color); ?>">
										<?php print($db[$key]['domain']); ?>
									</td>
									<td align="center" class="<?php print($color); ?>">
										<?php 
											// continually break the size down to 
											// a more easily readable format
											$units = array("B", "KB", "MB", "GB");
											$i = 0;
											while ($db[$key]['size']/1024. > 1) {
												$db[$key]['size'] /= 1024.;
												$i++;
											}
											printf("%.2f %s",$db[$key]['size'],$units[$i]); 
										?>
									</td>
									<td class="<?php print($color); ?>" align=center>
										<table width="100%" cellpadding=0 cellspacing=0 border=0 style="border-width:0px;">
											<tr> 
												<td style="border-width:0px;" class=<?php print($color); ?> align=right><img src="/images/bandwidthbarleft.gif" alt="" align=absMiddle border=0></td>
												<td style="border-width:0px;" class=<?php print($color); ?> width="<?php print(ceil($db[$key]['relative'])); ?>"><img src="/images/bandwidthbar.gif" alt="" height=14 width="<?php print(ceil($db[$key]['relative'])); ?>"></td>
												<td style="border-width:0px;" class=<?php print($color); ?> width="<?php print(ceil(100-$db[$key]['relative'])); ?>"><img src="/images/bandwidthempty.gif" alt="" height=14 width="<?php print(ceil(100-$db[$key]['relative'])); ?>"></td>
												<td style="border-width:0px;" class=<?php print($color); ?> align=left><img src="/images/bandwidthbarright.gif" alt="" align=absMiddle border=0></td>
												<td style="border-width:0px;" class=<?php print($color); ?> align=left>
													<?php printf(" %.2f%%",$db[$key]['relative']); ?> 
												</td>
											</tr>
										</table>
									</td>
									<td class="<?php print($color); ?>">
										<input type=text name="warn[<?php print($key); ?>]" value="<?php print($warn); ?>" size=4 maxlength=4 onBlur="checkText(this);" />MB
									</td>
									<td class="<?php print($color); ?>" align=center>
										<a href="mysqlusage.php?<?php printf("dbname=%s&domain=%s&size=%.2f%s&warn=1",$key,$db[$key]['domain'],$db[$key]['size'],"%20".$units[$i]); ?>"
											onClick="return confirm('Are you sure you wish to warn the owner of \'<?php print($key); ?>\'?');">
											<img src="/images/email.gif" alt="Issue Warning" border=0 />
										</a>
									</td>
								</tr>
								<?php
								if ($color == "listodd") 
									$color = "listeven"; 
								else 
									$color = "listodd";
							}
							?>
							<tr>
								<td colspan=6 class=<?php print($color); ?> align=center>
									<input type=submit value="Submit Changes" />
									<input type=hidden name=go value=1 />
								</td>
							</tr>
						</form>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>
