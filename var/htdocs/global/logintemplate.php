<?php
	/* Copyright 2003 Apis Networks
	*  Please read the attached LICENSE
	*  included within the distribution
	*  for further restrictions.
	*/
	/* 
	 * generic login template, emulate the standard 
	 * Ensim WEBppliance login screen
	 */
?>

<html>
<head>
<title>Login</title>
<base target="_top">
<LINK REL="stylesheet" href="/stylesheet/" type="text/css">
</head>
<body BGCOLOR="#ffffff" <?php if ($loginType != 5) { printf("onLoad=\"document.f.ocw_login_username.focus()\""); } ?>>
&nbsp;<br>
&nbsp;<br>
&nbsp;<br>
<center>
<?php
	if ($loginType != 5) {
?>
  <table align=center width=300 border=0 cellspacing=0 cellpadding=0>
    <tr> 
      <td class=head> <table border=0 width=100% cellspacing=1 cellpadding=1>
	  	<?php
			switch ($loginType) {
				case "1":
					printf("<form action=\"/webhost/\" name=f method=POST>");
					break;
				case "2":
					printf("<form action=\"/webhost/services/reseller/resellercp/\" name=f method=POST>");
					break;
				case "3":
					printf("<form action=\"/webhost/services/virtualhosting/siteadmin/\" name=f method=POST>");
					break;
				case "4":
					printf("<form action=\"/webhost/services/virtualhosting/useradmin/\" name=f method=POST>");
					break;
			}
		?>
          <form action="/webhost/services/virtualhosting/siteadmin/" name=f method=POST>
            <tr> 
              <td class=head3>
			  <?php
			  	switch ($loginType) {
					case "1":
						print("Appliance");
						break;
					case "2":
						print("Reseller");
						break;
					case "3":
						print("Site");
						break;
					case "4":
						print("User");
						break;
				}
			  ?>
			   Administrator Login:
			   </td>
            </tr>
            <tr> 
              <td class=help>
			    <?php
					switch ($loginType) {
					case "1":
						printf("Your Login is the Appliance <i>username</i>.<br>These fields are case sensitive.");
						break;
					case "2":
						printf("These fields are case sensitive.");
						break;
					case "3":
						printf("Your Login is the Site <i>username</i>.<br>
                Your Domain is the site's <i>domainname.com</i>.<br>
                These fields are case sensitive.");
						break;
					case "4":
						printf("Your Login is your <i>username</i>.<br>
                Your Domain is the site's <i>domainname.com</i>.<br>
                These fields are case sensitive.");
						break;
					}
				?>
				
				</td>
            </tr>
            <tr> 
              <td class=cell1> <table width=100% border=0 cellspacing=0 cellpadding=0>
                  <tr> 
                    <td class=cell1>Login:</td>
                    <td class=cell1><input type=text name=ocw_login_username size="20" value=""></td>
                  </tr>
				  <?php
				  	if ($loginType != 1 && $loginType != 2) {
				  ?>
                  <tr> 
                    <td class=cell1>Domain:</td>
                    <td class=cell1><input type=text name=ocw_login_domain size="20" value=""></td>
                  </tr>
				  <?php
				  	}
				  ?>
                  <tr> 
                    <td class=cell1>Password:</td>
                    <td class=cell1><input type=password name=ocw_login_password size="20"></td>
                  </tr>
                  <tr> 
                    <td class=cell1 colspan=2 align=center> <input type=submit name="Login" value=Login> 
                    </td>
                  </tr>
                </table></td>
            </tr>
          </form>
        </table></td>
    </tr>
  </table>
<?php
	} else {
	?>
  <table align=center width=300 border=0 cellspacing=0 cellpadding=0>
    <tr> 
      <td class=head> <table border=0 width=100% cellspacing=1 cellpadding=1>
	  	<?php
			switch ($loginType) {
				case "1":
					printf("<form action=\"/webhost/\" name=f method=POST>");
					break;
				case "2":
					printf("<form action=\"/webhost/services/reseller/resellercp/\" name=f method=POST>");
					break;
				case "3":
					printf("<form action=\"/webhost/services/virtualhosting/siteadmin/\" name=f method=POST>");
					break;
				case "4":
					printf("<form action=\"/webhost/services/virtualhosting/useradmin/\" name=f method=POST>");
					break;
			}
		?>
            <tr> 
              
            <td class=head3> 
              Could not detect login type!</td>
            </tr>
            <tr> 
              
            <td class=help><em>Sorry</em>, however we are unable to detect which login 
              portion you should use. Please follow the link below to go to the 
              entrance page for apnscp.</td>
            </tr>
			<tr>
				<td class=cell1 align=center>
					<a href="/webhost/rollout/welcome">Login</a>
				</td>
			</tr>
        </table></td>
    </tr>
  </table>		
	<?php
	}
?>
</center>
</body>
</html>
