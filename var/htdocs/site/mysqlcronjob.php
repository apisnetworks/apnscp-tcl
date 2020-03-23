<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include("../global/sitefunctions.php");
	if (!$mysqlcronjobEnabled) die("The requested module is disabled.");
	Login();
	/*
		go = triggers MySQL cronjob creation 
	*/
	$conna = mysql_connect("localhost",$sql['cronjobs']['username'],$sql['cronjobs']['password']);
	mysql_select_db($sql['cronjobs']['database'],$conna);
	if (isset($_POST['go'])) {
		$retVal = 0;
		$email = trim(checkLocalServer($gDomainName,"getemail"));
		while (@list($b,$c) = @each($_POST['name'])) {
			foreach (array("name", "enable", "perform", "notify", "format", "reset") as $a) {
				$str = "\$_POST['{$a}']['$b']";
				@eval("\$str = $str;");
				eval("\$$a = \"$str\";");
			}
			$exists = 0; // flag to check for existence
			$q = mysql_query("select 1 from mysql_jobs where domain = '".$gDomainName."' AND name = '".$name."'",$conna);
			if (mysql_num_rows($q) > 0)
				$exists ^= 1;
			if ($reset || !$exists) {
				$time = mktime(0,0,0,date("m"),date("d"));
			}
			else {
				$q = mysql_query("select time from mysql_jobs where domain = '".$gDomainName."' AND name = '".$name."'",$conna);
				$row = mysql_fetch_row($q);
				$time = $row[0];
			}
			if ($exists) {
				$q = mysql_query("update mysql_jobs set notify = '".$notify."', time = '".$time."', email = '".$email."', day_span = '".$perform."', 
					enabled = '".$enable."', type = '".$format."' where domain = '".$gDomainName."' AND name = '".$name."';",$conna);			
			} else {
				$q = mysql_query("insert into mysql_jobs values('" . $time . "', '".$gDomainName."', '".$email."', '".$perform."',
					'".$notify."', '".$format."', '".$enable."', '".$name."');",$conna);
			}
			if (mysql_affected_rows() == -1) {
				$error = mysql_error();
				$retVal = 1;
			}
		}
	}
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
          <td class=head> Database Backups</td>
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
          <td class=cell1 colspan=2> &nbsp; <a href="mysqlcronjob.php" onMouseOver="status='MySQL Cronjob'; return true;" onMouseOut="status=''; return true;"><strong>MySQL 
            Cronjob</strong></a> 
            <?php if ($pgsqlcronjobEnabled) { ?>
            <img src="/images/red.gif" width=4 height=4> <a href="postgresqlcronjob.php" onMouseOver="status='PostgreSQL Cronjob'; return true;" onMouseOut="status=''; return true;">PostgreSQL 
            Cronjob </a> 
            <?php } ?>
          </td>
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
								<td width="487" align=left valign="middle" class=cell1>
									<b>Result:</b>&nbsp;MySQL Cronjob successful.
								</td>
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
								<td width="487" align=left valign="middle" class=cell1>
									<b>Result:</b>&nbsp;Error generated -> <?php print($error); ?>
								</td>
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
<form method=POST action="mysqlcronjob.php">
	<tr>
		<td class=head valign=top> 
			<table border=0 cellspacing=1 cellpadding=1 width=100%>
				<tr> 
					<td class=head3 colspan=7>MySQL Cronjob</td>
				</tr>
				<tr> 
					<td class=help valign=center colspan=7>
						MySQL Cronjob will setup periodic 
						dumps of your database, inclusive of all tables, into your home 
						directory, i.e. <em>/home/<?php print($gUserName); ?>/mysql_dumps/mysql-YYYYMMDD-dbname.ext</em><br>
						Limitations:
						<li>Only one cronjob per database</li>
						<li>The dump of your database will count towards your disk quota</li>
						<li><strong>All</strong> data pertinent to the database is dumped: 
						schema, values, definitions, everything</li>
						<li>When notify is selected, an e-mail will be dispatched to the site administrator notifying him/her of the dump</li>
						<li>Reset will reset the original date reference from which the 
						cronjob functions</li>
						<li><em>Example</em>: You set the cronjob to occur every ten days 
						on January 10, but on January 23 you changed the perform field 
						to '4' (every four days) - the next backup will occur on January 27</li>
						<li><em>Conversely:</em> on January 10 if you changed 'notify' to no, and the perform was set to '10' without the reset checkbox ticked, then the next occurrence will be on January 20 without an e-mail notification</li>
						<li>This command is analogous to :<br>
						`mysqldump -u 
						<?php print($gUserName); ?>
						-pyourpassword -a DBNAME > /home/<?php print($gUserName); ?>/mysql_dumps/mysql-YYYYMMDD-dbname.ext`</li>
					</td>
        		</tr>
				<tr>
                  <td class=head5 align=center><strong>Database Name:</strong></td>
                  <td class=head5 align=center><strong>Enabled:</strong></td>	
                  <td class=head5 align=center><strong>Perform:</strong></td>
				  <td class=head5 align=center><strong>Notify:</strong></td>
				  <td class=head5 align=center><strong>Format:</strong></td>
				  <td class=head5 align=center><strong>Reset:</strong></td>
				  <td class=head5 align=center><strong>Next Dump:</strong></td>
				</tr>
				<?php
					$connb = mysql_connect("localhost",$mysql['databases']['username'],$mysql['databases']['password']);
					mysql_select_db($mysql['databases']['database'], $connb);
					$mysqlusers = MysqlAliases($gDomainName);
					$color = "listeven";
					$i = 0;
					foreach($mysqlusers as $NULL => $user) {
						$q = mysql_query("select distinct(db) from db where user = '".$user."'", $connb);
						while ($row = mysql_fetch_row($q)) {
							$q2 = @mysql_query("select day_span, notify, type, enabled, time from mysql_jobs where domain = '".$gDomainName."' AND name = binary('".$row[0]."')", $conna);
							if (mysql_num_rows($q2) <= 0) {
								$row2[0] = "";
								$row2[1] = "0";
								$row2[2] = "tar";
								$row2[3] = "0";
								$row2[4] = "0";
							}
							else 
								$row2 = mysql_fetch_row($q2);
							?>
							<tr> 
								<td class=<?php print($color); ?> align=center valign=middle>
									<?php print($row[0]); ?>
									<input type=hidden name="name[<?php print($i); ?>]" value="<?php print($row[0]); ?>">
								</td>
								<td class=<?php print($color); ?> align=center valign=middle>
									Yes<input type=radio name="enable[<?php print($i); ?>]" value=1 <?php ($row2[3]) ? print('CHECKED') : print(''); ?>>
									&nbsp;
									No<input type=radio name="enable[<?php print($i); ?>]" value=0 <?php (!$row2[3]) ? print('CHECKED') : print(''); ?>>
								</td>
								<td class=<?php print($color); ?> align=center valign=middle>
									Every <input type=text name="perform[<?php print($i); ?>]" value="<?php print($row2[0]); ?>" size=2 maxlength=2> days
								</td>
								<td class=<?php print($color); ?> align=center valign=middle>
									Yes<input type=radio name="notify[<?php print($i); ?>]" value=1 <?php ($row2[1]) ? print('CHECKED') : print(''); ?>>
									&nbsp;
									No<input type=radio name="notify[<?php print($i); ?>]" <?php (!$row2[1]) ? print('CHECKED') : print(''); ?> value=0>
								</td>
								<td class=<?php print($color); ?> align=center valign=middle>
									<select name="format[<?php print($i); ?>]">
										<option value="tgz" <?php ($row2[2] == "gz")? print('SELECTED') : print(''); ?>>.tar.gz</option>
										<option value="bz" <?php ($row2[2] == "bz") ? print('SELECTED') : print('');?>>.tar.bz</option>
										<option value="tar" <?php ($row2[2] == "tar") ? print('SELECTED') : print('');?>>.tar</option>
										<option value="zip" <?php ($row2[2] == "zip") ? print('SELECTED') : print('');?>>.zip</option>
									</select>
								</td>
								<td class=<?php print($color); ?> align=center valign=middle>
									<input type=checkbox name="reset[<?php print($i); ?>]" value=1>
								</td>
								<td class=<?php print($color); ?> align=center valign=middle>
									<?php 
										/* simple logic here:
										*  1) take the difference of the current time - creation time
										*  2) divide by one full day, 86400 seconds - gives the elapsed days
										*  3) the next day it will occur will be the remainder of:
										*     elapsed days % days between backups
										*  4) convert remainder back to seconds, add to current time
										*  5) Call date("M j Y",$newTime) to obtain the next date
										*/
										// check to see if time, enabled, and day_span are true 
										if ($row2[4] && $row2[3] && $row2[0]) {
											$currentTime = mktime(0,0,0,date("m"),date("d"));
											// add one to the date since it occurs nightly at midnight (next day)
											$newTime = floor(($currentTime - $row2[4])/86400.)+1;
											$daysUntilNext = ($newTime < $row2[0]) ? $row2[0] : 
												ceil($newTime/$row2[0]) * $row2[0];
											print(date("M j, Y", $daysUntilNext * 86400 + $row2[4]));
										} 
										else
											print("never"); 
									?>
								</td>
							</tr>
							<?php
							$i++;
							if ($color == "listeven") 
								$color = "listodd"; 
							else
								$color = "listeven";
						}
					}
				?>
				<tr> 
					<td align=center class=<?php print($color); ?> colspan=7> 
				  		<table border=0 cellpadding=0 cellspacing=0> 
			            	<tr> 
            			  	<td class=<?php print($color); ?>><input type=hidden name=go value=1><input type=submit value='Submit'> <input type=reset value="Reset"></td>
						    </tr>
    					</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</form>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>
