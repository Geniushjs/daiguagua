<?php 
require_once('../inc/global.php');
require_once('../inc/common.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>呆瓜瓜</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<base target="function" />
</head>

<body>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="78" width="178" align="center"  background="../images/index/bar_blue_bg.gif">
				<a href="../index.php" target="_parent"><span class="fontwrite">返回网站</span></a><br/>
			</td>
		</tr>
		<tr>
			<td height="78" width="178" align="center"  background="../images/index/bar_blue_bg.gif">
				<a href="manage/class.php"><span class="fontwrite">分类管理</span></a><br/>
			</td>
		</tr>
		<tr>
			<td height="78" width="178" align="center"  background="../images/index/bar_blue_bg.gif">
				<a href="manage/soft.php"><span class="fontwrite">软件管理</span></a><br/>
			</td>
		</tr>
<?php
	if ($_SESSION['level'] == 0)
	{
?>
		<tr>
			<td height="78" width="178" align="center"  background="../images/index/bar_green_bg.gif">
				<a href="manage/user.php"><span class="fontwrite">用户管理</span></a><br/>
			</td>
		</tr>
<?php
	}
?>
		<tr>
			<td height="78" width="178" align="center"  background="../images/index/bar_blue_bg.gif">
				<a href="changepwd.php"><span class="fontwrite">修改密码</span></a><br/>
			</td>
		</tr>
		<tr>
			<td height="78" width="178" align="center"  background="../images/index/bar_blue_bg.gif">
				<a href="logout.php"><span class="fontwrite">退出登录</span></a><br/>
			</td>
		</tr>
	</table>
</body>
</html>