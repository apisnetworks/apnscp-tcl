<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	include "../global/sitefunctions.php";
    dl('statistics.so');
	error_reporting(E_ALL);
	$tmpData = CheckLocalServer($gDomainName,"bwlog");
    
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
          <td class=head> Bandwidth Log </td>
          <td align=right class=head3> 
		    <script language="JavaScript">
	  	    function popUpHelpWindow() {
			   alert('Not implemented.');
			}
			</script> 
		  	<a href="javascript:popUpHelpWindow()" onMouseOver="status='Click here for help'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;">
			<IMG SRC="https://<?php print($_SERVER['HTTP_HOST']); ?>/webhost/help_toolbar_gif" HEIGHT = "15" BORDER = "0" ALIGN = "absmiddle" WIDTH = "15"><font color=white>Help</font></a> 
          </td>
        </tr>
        <tr> 
          <td class=cell1 colspan=2> &nbsp; <strong><a href="bandwidth.php" onMouseOver="status='Bandwidth Log'; return true;" onMouseOut="status=''; return true;">Bandwidth Log</a></strong> 
            </td>
        </tr>
      </table></td>
  </tr>
</table>
<p></p>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=experimental align=center>
		<strong>THIS PROVISION IS EXPERIMENTAL.</strong><br />
		What does experimental mean? It means you should take the
		accuracy of this provision with a grain of salt.  It may be inaccurate,
		it may cause odd behaviors; in fact, it may even bake a cake for you.
	</td>
  </tr>
</table>
<p></p>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td class=head valign=top> <table border=0 cellspacing=1 cellpadding=1 width=100%>
        <tr>
          <td class=head3>Bandwidth Log</td>
        </tr>
		<tr>
			<td class=help>The chart below illustrates your bandwidth usage since
            the date your account was created.  Data is grouped per month.  Please be aware that if you have not been
            with us for more than a month, then the historical bandwidth table will be empty.
			"delta" is the change of bandwidth from month to
			month, if you accumulated 0 bytes of bandwidth, then the field will be omitted.  The "t-score"
			is calculated as: (x-bar - mu)/s/sqrt(n) where
			x-bar = data point, mu = average, s = standard deviation of sample, n = size of data.  Confidence
			intervals may be redefined and give an approximate forecasted range of bandwidth.
			<br /><br /><strong>If your data has a high variance</strong>, then the confidence
			interval MAY be incredibly incorrect.  The approximations furnished here-in should only be interpreted
			for scholarly or geeky reasons.  If you have data accumulated for over 30 months, then the approximations
			may be rather accurate, as then the t-distribution begins to assume a normal distribution's shape.
			<br /><br /><strong>For display of the confidence interval approximations</strong>, you must have been
			a customer on our servers and have bandwidth history for at least two complete months.  Although the
			forecasting may be horribly inaccurate, it can be displayed.
			<br /><br />It has been a while since I took a statistics course, so my rationale may be off.  If you
			feel a better distribution would suffice than a t-distribution or would like to confirm my logic, let me
			know through either a trouble ticket or <a href="mailto:msaladna@apisnetworks.com?t-distribution">via e-mail</a>.
			<br /><br />
			Next addition for this provision is to incorporate monthly approximations with the daily bandwidth data.  As always,
			I am open to further suggestions, so let me hear them.
			</td>
		</tr>
          <tr> 
            <td align=center class=nospacing> 
				<table width="100%" cellspacing=0 cellpadding=2 border=0>
                    <tr>
                        <td width=120 class=cell2>Date Span:</td>
                        <td align=center class=cell2>In (MB): </td>
                        <td align=center class=cell2>Out (MB): </td>
                        <td align=center class=cell2>Aggregate (GB): </td>
                        <td align=center class=cell2>delta: </td>
						<td align=center class=cell2>t-score:</td>
                    </tr>
					<?php
						$i = 0;
						$color = 'listodd';
						$previousBandwidth = array('begin' => NULL,
													'end'   => NULL,
													'in'    => NULL,
													'out'   => NULL);
						$zeroPoint = NULL;
						$delta = NULL;
						$ciArray = array();
						$data = array();
						if (!empty($tmpData)) {
							foreach (explode('|',$tmpData) as $bwGump) {
								list($begin, $end, $in, $out) = explode(' ',$bwGump);
								if (is_null($zeroPoint)) {
									/* first data set */
									$tscore = NULL;
									$refDate = explode('-',$begin);
									$refDate = array($refDate[0], $refDate[1]);
									$zeroPoint = $begin;
									
								} else {
									if ($begin != $previousBandwidth['end']) {
										// There has been some NULL months with bandwidth,
										// compensate!
										$d1 = explode('-',$previousBandwidth['end']);
										$d2 = explode('-',$begin);
										$loops = ($d2[0]*12 + $d2[1] - $d1[0]*12 - $d1[1]);
										for ($i = 0; $i < $loops; $i++) {
											$ciArray[] = 0;
										}
									}
								}
								$ciArray[] = ($in+$out)/1024/1024.;
								$data[] = array('begin' => $begin,
												'end'   => $end,
												'in'    => $in,
												'out'   => $out);
								$previousBandwidth = array('begin' => $begin,
														   'end'   => $end,
														   'in'    => $in,
														   'out'   => $out);
							}
							/* let's calculate mu */
							$mu = array_sum($ciArray)/sizeof($ciArray);
							for($i = 0, $s = 0, $size = sizeof($ciArray); $i < $size; $i++) {
								$s += pow(($ciArray[$i] - $mu),2);
							}
							$s = sqrt($s/(sizeof($ciArray)-1));
							$previousBandwidth = array('begin'     => NULL,
														   'end'   => NULL,
														   'in'    => NULL,
														   'out'   => NULL);
							for($i = 0,
								$size = sizeof($data); $i < $size; $i++) {		
								$in    = $data[$i]['in'];
								$out   = $data[$i]['out'];
								$begin = $data[$i]['begin'];
								$end   = $data[$i]['end'];
								?>
								<tr>
									<td align=left class=<?php print($color); ?>><?php print($begin.' - '.$end); ?></td>
									<td align=center class=<?php print($color); ?>>
										<?php print(Commafy(sprintf("%.2f MB",$in/1024/1024))); ?>
									</td>
									<td align=center class=<?php print($color); ?>>
										<?php print(Commafy(sprintf("%.2f MB",$out/1024./1024.))); ?>
									</td>
									<td align=center class=<?php print($color); ?>>
										<?php print(Commafy(sprintf("%.2f GB",($in+$out)/1024./1024/1024.))); ?>
									</td>
									<td align=center class=<?php print($color); ?>>
										<?php print(Commafy(sprintf("%.2f GB",($out+$in-$previousBandwidth['in']-$previousBandwidth['out'])/1024/1024/1024))); ?>
									</td>
									<td align=center class=<?php print($color); ?>>
										<?php ($s > 0 ) ? printf("%.2f",(($out+$in)/1024/1024 - $mu)/$s/sqrt($size)) : print('N/A'); ?>
									</td>
								</tr>
								<?php
								if ($color == 'listodd') $color = 'listeven'; else $color = 'listodd';
								$previousBandwidth = array('begin' => $begin,
														   'end'   => $end,
														   'in'    => $in,
														   'out'   => $out);
							}
						}
					?>
					<tr>
						<td colspan=6 class=head4 align=center>Based upon your statistics, the projected bandwidth for this month is:</td>
					</tr>
					<tr>
						<td align=center class=nospacing colspan=6> 
							<table width="100%" cellspacing=0 cellpadding=2 border=0>
								<tr>
									<td class=cell2 align=center>Conf. Interval:</td>
									<td class=cell2 align=center>Range (MB)</td>
									<td class=cell2 align=center>Standard Error</td>
									<td class=cell2 align=center>t-critical</td>
								</tr>
								<?php
								if (sizeof($data) > 1) {
									for ($i = 0, $cis = array('99.99', '99.5', '99', '98', '97.5', '95', '90', '80'),
										 $size = sizeof($ciArray), $df = ($size - 1), $cisSize = sizeof($cis);
										 $i < $cisSize;
										 $i++) {
										 $tcrit = stats_cdf_t($cis[$i]/100+(1-$cis[$i]/100)/2,$df,2);
									?>
									<tr>
										<td align=center class=<?php print($color); ?>><?php printf("%.2f %%",$cis[$i]); ?></td>
										<td align=center class=<?php print($color); ?>>
											<?php print(Commafy(sprintf("[%.2f, %.2f] MB",
												  $mu-$tcrit*$s/sqrt($size),
												  $mu+$tcrit*$s/sqrt($size))));
											?>
										</td>
										<td align=center class=<?php print($color); ?>>
											<?php print(Commafy(sprintf("%.2f MB",$tcrit*$s/sqrt($size)))); ?>
										</td>
										<td align=center class=<?php print($color); ?>>
											<?php printf("%.2f",$tcrit); ?>
										</td>
									</tr>
									<?php
										if ($color == 'listodd') $color = 'listeven'; else $color = 'listodd';
									}
								?>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan=6 class=head4 align=center>Additional data used to calculate the projected values:</td>
					</tr>
					<tr>
						<td align=center class=nospacing colspan=6> 
							<table width="100%" cellspacing=0 cellpadding=2 border=0>
								<tr>
									<td class=cell2 align=center width="33%">mu:</td>
									<td class=cell2 align=center width="33%">s</td>
									<td class=cell2 align=center width="33%">df</td>
								</tr>
								<tr>
									<td align=center class=<?php print($color); ?>>
										<?php print(Commafy(sprintf("%.2f MB",
											  $mu)));
										?>
									</td>
									<td align=center class=<?php print($color); ?>>
										<?php print(Commafy(sprintf("%.2f MB",
											  $s))); ?>
									</td>
									<td align=center class=<?php print($color); ?>>
										<?php print(Commafy(sprintf("%u",
											  sizeof($ciArray)-1))); ?>
									</td>
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
      </table></td>
  </tr>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>
