<?php
require_once('../inc/global.php');
if (!isset($_SESSION['level']) || $_SESSION['level'] > 1) {
?>
<script language="JavaScript" type="text/javascript">
function SubmitCheck(){
  	if(document.forms[0].username.value==""||document.forms[0].password.value==""){
  	  return false;
    }
  return true;
}
</script>
<style>
<!--
#login {
	height: 150px;
	padding-top: 66px;
	padding-left:10px;
	background: url(../images/bg_login.jpg) no-repeat;
	background-position: center center;
	font-size: 12px;
}
-->
</style>

<body>
<div align=center valign=center>
	<div id="login"> 
		<form action="check_login.php" method="POST" onSubmit="return SubmitCheck();">
			<p>用户名：<input type="text" name="username" size="18" /></p>
			<p>密　码：<input type="password" name="password" size="20" /></p>
			<input  type="submit"  value="提交" /> 　 
			<input type="reset"  value="重置" />
		</form>
	</div>
</div>
</body>

<?php
die;
}
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>呆瓜瓜后台登录</title>
</head>
<frameset cols="178,*">
<frame noresize="noresize" src="accordion.php" name="menu"></frame>
<frame noresize="noresize" src="welcome.php" name="function"></frame>
</frameset>
<noframes></noframes>

</html>