<?php
//	session_name('XULSession'); // Set session name
	session_start();
        if (isset($_SESSION['CSpace_userID']))
            header("Location: http://www.coagmento.org/spring2015/sidebar/sidebar.php");
        else {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<link rel="Coagmento icon" type="image/x-icon" href="http://www.coagmento.org/spring2015/img/favicon.ico">
			<title>Coagmento</title>
			<link rel="stylesheet" href="css/styles.css" type="text/css" />
			</head>
			<body>
        <form action="loginOnSideBarAux.php" method=post>
		<table>
			<tr><td align=center colspan=2 <span style="font-weight:bold;">Login to your Account</span></td></tr>
			<tr><td colspan=2><br/></td></tr>
			<tr><td> Username </td><td> <input name="userName" type="text" size=20 /></td></tr>
			<tr><td> Password </td><td> <input name="password" type="password" size=20 /></td></tr>
			<tr><td colspan=2 align="center"><input type="submit" value="Login"/></td></tr>
			<tr><td colspan=2><br/></td></tr>
			<tr><td>
                            </td>
                            <td>

                            </td>
                        </tr>
		</table>
</form>
                         </body>
                        </html>
<?php
    }
?>
