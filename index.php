<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
	function loader(){
		document.getElementById('loader').style.display ='block';
		document.getElementById('login').style.display ='none';
	document.forms["login_form"].submit();
	}
</script>
</head>
<body>
<div id="loader" style="display:none;"> <img src="images/loading_spinner.gif" width="16" height="16" border="0" /><b>Backing up data</b><br/>Please wait this may take a while.....</div>
<div id="login">
Please login to perform a backup.<br />
<br />
<form  id="login_form" action="backup.php" method="get">
  <table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Username</td>
      <td><input name="Username" type="text" /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input name="Password" type="password" /></td>
    </tr>
    <tr>
      <td><input name="Submit" type="hidden" id="Submit" value="true" /></td>
    <td><input type="button" name="Button" id="Submit" value="Backup now" onClick="loader()"/></td>
    </tr>
  </table>
  
</form>

<script type="text/javascript">
//loader();
</script>
</body>
</html>